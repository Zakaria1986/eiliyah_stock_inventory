<?php

class Product_Manager_Meta_Boxes
{
    public function add_product_meta_boxes()
    {
        add_meta_box(
            'product_details',
            __('Product Details', 'eiliyah-product-inventory'),
            [$this, 'show_product_details'],
            'product',
            'normal',
            'high'
        );
    }

    public function show_product_details($post)
    {
        wp_nonce_field(basename(__FILE__), 'product_details_nonce');

        $total_stocks = get_post_meta($post->ID, 'total_stocks', true) ?: 0;
        $total_sold   = get_post_meta($post->ID, 'total_sold', true) ?: 0;
        $returns      = get_post_meta($post->ID, 'returns', true) ?: '';
        $restocked    = get_post_meta($post->ID, 'restocked', true) ?: '';

?>
        <table class="form-table">
            <tr>
                <th><label for="total_stocks"><?php _e('Total Stocks', 'eiliyah-product-inventory'); ?></label></th>
                <td><input type="number" id="total_stocks" name="total_stocks" value="<?php echo esc_attr($total_stocks); ?>" /></td>
            </tr>
            <tr>
                <th><label for="total_sold"><?php _e('Total Sold', 'eiliyah-product-inventory'); ?></label></th>
                <td><input type="number" id="total_sold" name="total_sold" value="<?php echo esc_attr($total_sold); ?>" /></td>
            </tr>
            <tr>
                <th><label for="returns"><?php _e('Returns', 'eiliyah-product-inventory'); ?></label></th>
                <td><input type="text" id="returns" name="returns" value="<?php echo esc_attr($returns); ?>" /></td>
            </tr>
            <tr>
                <th><label for="restocked"><?php _e('Restocked', 'eiliyah-product-inventory'); ?></label></th>
                <td><textarea id="restocked" name="restocked" rows="4"><?php echo esc_textarea($restocked); ?></textarea></td>
            </tr>
        </table>
<?php
    }

    public function save_product_meta($post_id)
    {
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return $post_id;

        if (!isset($_POST['product_details_nonce']) || !wp_verify_nonce($_POST['product_details_nonce'], basename(__FILE__))) return $post_id;

        if (!current_user_can('edit_post', $post_id)) return $post_id;

        if (get_post_type($post_id) !== 'product') return $post_id;

        $fields = [
            'total_stocks' => isset($_POST['total_stocks']) ? max(0, intval($_POST['total_stocks'])) : null,
            'total_sold'   => isset($_POST['total_sold']) ? max(0, intval($_POST['total_sold'])) : null,
            'returns'      => isset($_POST['returns']) ? sanitize_text_field($_POST['returns']) : null,
            'restocked'    => isset($_POST['restocked']) ? sanitize_textarea_field($_POST['restocked']) : null,
        ];

        foreach ($fields as $key => $value) {
            if ($value !== null) {
                update_post_meta($post_id, $key, $value);
            }
        }
    }
}

// $product_manager_meta_boxes = new Eiliyah_Product_Manager_Meta_Boxes();

// add_action('add_meta_boxes', [$product_manager_meta_boxes, 'add_product_meta_boxes']);
// add_action('save_post_product', [$product_manager_meta_boxes, 'save_product_meta']);
