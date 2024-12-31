<?php
class Product_Post_Type
{
    public function __construct()
    {
        // Register the custom post type on 'init' hook
        add_action('init', array($this, 'register_product_post_type'));
        add_action('init', array($this, 'register_product_taxonomies'));  // Register custom taxonomy
    }

    /**
     * Registers the custom post type for products
     */
    public function register_product_post_type()
    {
        $labels = array(
            'name'                  => _x('Eiliyah Stocks', 'Post Type General Name', 'eiliyah-product-manager'),
            'singular_name'         => _x('Eiliyah Stock', 'Post Type Singular Name', 'eiliyah-product-manager'),
            'menu_name'             => __('Eiliyah Stocks', 'eiliyah-product-manager'),
            'name_admin_bar'        => __('Eiliyah Stocks', 'eiliyah-product-manager'),
            'all_items'             => __('All Eiliyah Stocks', 'eiliyah-product-manager'),
            'add_new_item'          => __('Add New Product', 'eiliyah-product-manager'),
            'edit_item'             => __('Edit Product', 'eiliyah-product-manager'),
            'view_item'             => __('View Product', 'eiliyah-product-manager'),
            'search_items'          => __('Search Products', 'eiliyah-product-manager'),
            'not_found'             => __('No products found', 'eiliyah-product-manager'),
            'not_found_in_trash'    => __('No products found in trash', 'eiliyah-product-manager'),
            'featured_image'        => __('Product Image', 'eiliyah-product-manager'),
        );

        $args = array(
            'label'                 => __('Eiliyah Stock', 'eiliyah-product-manager'),
            'labels'                => $labels,
            'supports'              => array('title', 'editor', 'thumbnail', 'custom-fields', 'excerpt'),
            'public'                => true,
            'show_ui'               => true,
            'show_in_menu'          => true,
            'menu_position'         => 5,
            'menu_icon'             => 'dashicons-cart',
            'taxonomies'            => array('product_category', 'product_tag'), // Ensure the taxonomy is included
            'description'           => __('Post type for products in the Eiliyah Stocks system.', 'eiliyah-product-manager'),
            'show_in_nav_menus'     => true,
            'can_export'            => true,
        );

        register_post_type('product', $args);
    }


    /**
     * Registers custom taxonomies for the 'product' post type
     */
    public function register_product_taxonomies()
    {
        // Register 'product_category' taxonomy
        $args = array(
            'hierarchical'          => true,
            'labels'                => array(
                'name'              => _x('Product Categories', 'taxonomy general name', 'eiliyah-product-manager'),
                'singular_name'     => _x('Product Category', 'taxonomy singular name', 'eiliyah-product-manager'),
                'search_items'      => __('Search Product Categories', 'eiliyah-product-manager'),
                'all_items'         => __('All Product Categories', 'eiliyah-product-manager'),
                'parent_item'       => __('Parent Product Category', 'eiliyah-product-manager'),
                'parent_item_colon' => __('Parent Product Category:', 'eiliyah-product-manager'),
                'edit_item'         => __('Edit Product Category', 'eiliyah-product-manager'),
                'update_item'       => __('Update Product Category', 'eiliyah-product-manager'),
                'add_new_item'      => __('Add New Product Category', 'eiliyah-product-manager'),
                'new_item_name'     => __('New Product Category Name', 'eiliyah-product-manager'),
                'menu_name'         => __('Product Categories', 'eiliyah-product-manager'),
            ),
            'show_ui'               => true,
            'show_in_rest'          => true, // Enable for Gutenberg editor
            'show_admin_column'     => true,
            'query_var'             => true,
            'rewrite'               => array('slug' => 'product-category'),
        );
        register_taxonomy('product_category', array('product'), $args);

        // Register 'product_tag' taxonomy
        $args = array(
            'hierarchical'          => false,
            'labels'                => array(
                'name'              => _x('Product Tags', 'taxonomy general name', 'eiliyah-product-manager'),
                'singular_name'     => _x('Product Tag', 'taxonomy singular name', 'eiliyah-product-manager'),
                'search_items'      => __('Search Product Tags', 'eiliyah-product-manager'),
                'all_items'         => __('All Product Tags', 'eiliyah-product-manager'),
                'edit_item'         => __('Edit Product Tag', 'eiliyah-product-manager'),
                'update_item'       => __('Update Product Tag', 'eiliyah-product-manager'),
                'add_new_item'      => __('Add New Product Tag', 'eiliyah-product-manager'),
                'new_item_name'     => __('New Product Tag Name', 'eiliyah-product-manager'),
                'menu_name'         => __('Product Tags', 'eiliyah-product-manager'),
            ),
            'show_ui'               => true,
            'show_in_rest'          => true,
            'show_admin_column'     => true,
            'query_var'             => true,
            'rewrite'               => array('slug' => 'product-tag'),
        );
        register_taxonomy('product_tag', array('product'), $args);
    }
}
