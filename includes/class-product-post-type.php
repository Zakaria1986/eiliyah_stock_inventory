<?php

class Product_Post_Type
{
    public function __construct()
    {
        add_action('init', array($this, 'register_product_post_type'));
    }

    public function register_product_post_type()
    {
        $labels = array(
            'name'                  => _x('Eiliyah Stocks', 'Post Type General Name', 'advanced-product-manager'),
            'singular_name'         => _x('Product', 'Post Type Singular Name', 'advanced-product-manager'),
            // ... other labels
        );

        $args = array(
            'label'                 => __('product', 'advanced-product-manager'),
            'labels'                => $labels,
            'supports'              => array('title', 'editor', 'thumbnail'),
            'public'                => true,
            'show_ui'               => true,
            'show_in_menu'          => true,
            'menu_position'         => 5,
            'menu_icon'             => 'dashicons-cart',
        );

        register_post_type('product', $args);
    }
}
