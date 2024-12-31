<?php

class Product_Columns
{
    public function __construct()
    {
        add_filter('manage_product_posts_columns', array($this, 'add_product_columns'));
        add_action('manage_product_posts_custom_column', array($this, 'show_product_column'), 10, 2);
    }

    public function add_product_columns($columns)
    {
        // Ensure columns array is properly structured and not null
        if (is_array($columns)) {
            // Add custom columns to the product post list
            $columns['product_category'] = __('Category', 'eiliyah-product-manager');
            // $columns['product_line'] = __('Product Line', 'eiliyah-product-manager');
            $columns['total_stocks'] = __('Total Stocks', 'eiliyah-product-manager');
            $columns['total_sold'] = __('Total Sold', 'eiliyah-product-manager');
            $columns['returns'] = __('Returns', 'eiliyah-product-manager');
            $columns['restocked'] = __('Restocked', 'eiliyah-product-manager');
        } else {
            // If $columns is not an array, set it as an empty array
            $columns = array();
        }

        // Return the updated columns array
        return $columns;
    }

    public function show_product_column($column, $post_id)
    {
        // Check which column is being requested and display corresponding custom field data
        switch ($column) {

            case 'product_category':
                // Get the terms for the product_category taxonomy
                $product_category_terms = get_the_terms($post_id, 'product_category');

                if (!empty($product_category_terms) && !is_wp_error($product_category_terms)) {
                    // Extract term names and join them with a comma
                    $term_names = wp_list_pluck($product_category_terms, 'name');
                    echo esc_html(implode(', ', $term_names));
                } else {
                    echo esc_html(__('No data', 'eiliyah-product-manager'));
                }
                break;

                // case 'product_line':
                //     // Display Product Line data
                //     $product_line = get_post_meta($post_id, 'product_line', false);

                //     // Check if it's an array and convert it to a string if necessary
                //     if (is_array($product_line)) {
                //         $product_line = implode(', ', $product_line); // Convert array to a string
                //     }
                //     echo esc_html($product_line ? $product_line : __('No data', 'eiliyah-product-manager'));
                //     break;

            case 'total_stocks':
                // Display Total Stocks data
                $total_stocks = get_post_meta($post_id, 'total_stocks', true);
                echo esc_html($total_stocks ? $total_stocks : __('0', 'eiliyah-product-manager'));
                break;

            case 'total_sold':
                // Display Total Sold data
                $total_sold = get_post_meta($post_id, 'total_sold', true);
                echo esc_html($total_sold ? $total_sold : __('0', 'eiliyah-product-manager'));
                break;

            case 'returns':
                // Display returns data
                $returns = get_post_meta($post_id, 'returns', true);
                echo esc_html($returns ? $returns : __('0', 'eiliyah-product-manager'));
                break;

            case 'restocked':
                // Display restocked data
                $restocked = get_post_meta($post_id, 'restocked', true);
                echo esc_html($restocked ? $restocked : __(' ', 'eiliyah-product-manager')); // Empty string for no data
                break;

            default:
                // If the column doesn't match any case, leave it empty or handle custom columns here
                break;
        }
    }
}
