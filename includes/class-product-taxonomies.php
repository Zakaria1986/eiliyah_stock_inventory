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
                    'name'              => _x('Product Categories', 'taxonomy general name', 'eiliyah-product-manager'),
                    'singular_name'     => _x('Product Category', 'taxonomy singular name', 'eiliyah-product-manager'),
                ),
                'hierarchical'          => true,
            )
        );

        // Register Product Tag taxonomy
        register_taxonomy(
            'product_sizes',
            'product',
            array(
                'labels' => array(
                    'name'              => _x('Add Sizes', 'taxonomy general name', 'eiliyah-product-manager'),
                    'singular_name'     => _x('Add Sizes', 'taxonomy singular name', 'eiliyah-product-manager'),
                ),
                'hierarchical'          => true,
                'show_ui'               => true,
                'show_in_rest'          => true,  // Enable for Gutenberg
                'show_admin_column'     => true,
                'query_var'             => true,
                'rewrite'               => array('slug' => 'product-category'),
            )
        );

        // Register Product Tag taxonomy
        register_taxonomy(
            'product_colours',
            'product',
            array(
                'labels' => array(
                    'name'              => _x('Add colours', 'taxonomy general name', 'eiliyah-product-manager'),
                    'singular_name'     => _x('Add colours', 'taxonomy singular name', 'eiliyah-product-manager'),
                ),
                'hierarchical'          => true,
            )
        );


        // Register 'product_tag' taxonomy
        $args = array(
            'hierarchical'          => false,
            'labels'                => array(
                'name'              => _x('Product Tags', 'taxonomy general name', 'eiliyah-product-manager'),
                'singular_name'     => _x('Product Tag', 'taxonomy singular name', 'eiliyah-product-manager'),
            ),
            'show_ui'               => true,
            'show_in_rest'          => true,  // Enable for Gutenberg
            'show_admin_column'     => true,
            'query_var'             => true,
            'rewrite'               => array('slug' => 'product-tag'),
        );
        register_taxonomy('product_tag', array('product'), $args);
    }
}
