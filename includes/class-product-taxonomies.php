<?php

class Product_Taxonomies
{
    public function __construct()
    {
        add_action('init', array($this, 'register_product_taxonomies'));
    }

    public function register_product_taxonomies()
    {
        // Register Product Category taxonomy
        register_taxonomy(
            'product_category',
            'product',
            array(
                'labels' => array(
                    'name'              => _x('Product Categories', 'taxonomy general name', 'advanced-product-manager'),
                    'singular_name'     => _x('Product Category', 'taxonomy singular name', 'advanced-product-manager'),
                ),
                'hierarchical'          => true,
            )
        );

        // Register Product Tag taxonomy
        register_taxonomy(
            'product_tag',
            'product',
            array(
                'labels' => array(
                    'name'              => _x('Product Tags', 'taxonomy general name', 'advanced-product-manager'),
                    'singular_name'     => _x('Product Tag', 'taxonomy singular name', 'advanced-product-manager'),
                ),
                'hierarchical'          => true,
            )
        );
    }
}
