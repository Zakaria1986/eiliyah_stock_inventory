<?php

class Admin_Settings
{
    public function __construct()
    {
        add_action('admin_menu', [$this, 'add_admin_menu_page']);
        add_action('admin_init', [$this, 'register_settings']);
        add_action('admin_action_duplicate_product', [$this, 'duplicate_product_post']);
        add_filter('post_row_actions', [$this, 'add_duplicate_link'], 10, 2);
    }

    public function add_admin_menu_page()
    {
        add_menu_page(
            __('Manager Settings', 'eiliyah-product-inventory'),
            __('Manager', 'eiliyah-product-inventory'),
            'manage_options',
            'product-manager-settings',
            [$this, 'render_settings_page'],
            'dashicons-admin-settings',
            60
        );
    }

    public function render_settings_page()
    {
        echo '<h1>' . esc_html__('Product Manager Settings', 'eiliyah-product-inventory') . '</h1>';
    }

    public function register_settings()
    {
        register_setting('product_manager_settings', 'some_setting_key');
        add_settings_section('general_settings', __('General Settings', 'eiliyah-product-inventory'), null, 'product-manager-settings');
        add_settings_field('example_setting', __('Example Setting', 'eiliyah-product-inventory'), function () {
            echo '<input type="text" name="some_setting_key" value="' . esc_attr(get_option('some_setting_key')) . '" />';
        }, 'product-manager-settings', 'general_settings');
    }

    public function duplicate_product_post()
    {
        if (isset($_GET['post']) && check_admin_referer('duplicate_product_nonce', '_wpnonce')) {
            $post_id = intval($_GET['post']);
            $post = get_post($post_id);

            if ($post && $post->post_type === 'product') {
                $new_post = [
                    'post_title'   => sanitize_text_field($post->post_title . ' (Duplicate)'),
                    'post_content' => sanitize_textarea_field($post->post_content),
                    'post_status'  => 'draft',
                    'post_type'    => $post->post_type,
                ];

                $new_post_id = wp_insert_post($new_post);

                if ($new_post_id) {
                    $meta_fields = get_post_meta($post_id);
                    foreach ($meta_fields as $key => $values) {
                        foreach ($values as $value) {
                            update_post_meta($new_post_id, $key, maybe_unserialize($value));
                        }
                    }

                    wp_redirect(admin_url('edit.php?post_type=product'));
                    exit;
                }
            }
        }
        wp_die(__('Failed to duplicate product.', 'eiliyah-product-inventory'));
    }

    public function add_duplicate_link($actions, $post)
    {
        if ($post->post_type === 'product') {
            $nonce = wp_create_nonce('duplicate_product_nonce');
            $actions['duplicate'] = '<a href="' . esc_url(admin_url('admin.php?action=duplicate_product&post=' . $post->ID . '&_wpnonce=' . $nonce)) . '">' . __('Duplicate', 'eiliyah-product-inventory') . '</a>';
        }
        return $actions;
    }
}
