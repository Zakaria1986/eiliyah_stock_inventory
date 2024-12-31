<?php

class Eiliyah_Product_Search
{

    public function __construct()
    {
        add_action('pre_get_posts', [$this, 'modify_product_search']);
    }

    /**
     * Modify the product search query to filter by custom fields or taxonomies.
     *
     * @param WP_Query $query
     */

    public function modify_product_search($query)
    {
        // Ensure we're targeting the main query on the front end
        if (! is_admin() && $query->is_main_query() && (is_search() || is_post_type_archive('product'))) {

            if (isset($_GET['total_stocks']) && ! empty($_GET['total_stocks'])) {
                $query->set('meta_query', array(
                    array(
                        'key'     => '_total_stocks',
                        'value'   => sanitize_text_field($_GET['total_stocks']),
                        'compare' => 'LIKE'
                    ),
                ));
            }

            if (isset($_GET['total_sold']) && ! empty($_GET['total_sold'])) {
                $query->set('meta_query', array(
                    array(
                        'key'     => '_total_sold',
                        'value'   => sanitize_text_field($_GET['total_sold']),
                        'compare' => 'LIKE'
                    ),
                ));
            }

            // Filter by custom taxonomies (e.g., returns or Color)
            if (isset($_GET['product_returns']) && ! empty($_GET['product_returns'])) {
                $query->set('tax_query', array(
                    array(
                        'taxonomy' => 'product_returns',
                        'field'    => 'id',
                        'terms'    => sanitize_text_field($_GET['product_returns']),
                        'operator' => 'IN',
                    ),
                ));
            }

            if (isset($_GET['product_restocked']) && ! empty($_GET['product_restocked'])) {
                $query->set('tax_query', array(
                    array(
                        'taxonomy' => 'product_restocked',
                        'field'    => 'id',
                        'terms'    =>  sanitize_textarea_field($_GET['product_restocked']),
                        'operator' => 'IN',
                    ),
                ));
            }
        }
    }

    /**
     * Render the custom search form with filters.
     */
    public static function render_product_search_form()
    {
?>
        <form method="get" action="<?php echo esc_url(home_url('/')); ?>">
            <input type="text" name="s" placeholder="<?php _e('Search Products...', 'eiliyah-product-inventory'); ?>" value="<?php echo get_search_query(); ?>" />

            <label for="total_stocks"><?php _e('Total Stocks', 'eiliyah-product-inventory'); ?></label>
            <input type="number" id="total_stocks" name="total_stocks" placeholder="<?php _e('Filter by Total Stocks', 'eiliyah-product-inventory'); ?>" value="<?php echo isset($_GET['total_stocks']) ? esc_attr($_GET['total_stocks']) : ''; ?>" />

            <label for="total_sold"><?php _e('Total Sold', 'eiliyah-product-inventory'); ?></label>
            <input type="number" id="total_sold" name="total_sold" placeholder="<?php _e('Filter by Total Sold', 'eiliyah-product-inventory'); ?>" value="<?php echo isset($_GET['total_sold']) ? esc_attr($_GET['total_sold']) : ''; ?>" />

            <label for="product_returns"><?php _e('Returns', 'eiliyah-product-inventory'); ?></label>
            <select name="product_returns" id="product_returns">
                <option value=""><?php _e('Select Returns', 'eiliyah-product-inventory'); ?></option>
                <?php
                $returns = get_terms(array('taxonomy' => 'product_sreturns', 'hide_empty' => false));
                foreach ($returns as $return) {
                    echo '<option value="' . esc_attr($return->term_id) . '" ' . selected(isset($_GET['product_return']) && $_GET['product_return'] == $return->term_id, true, false) . '>' . esc_html($return->name) . '</option>';
                }
                ?>
            </select>

            <label for="product_restocked"><?php _e('Restocked', 'eiliyah-product-inventory'); ?></label>
            <select name="product_restocked" id="product_restocked">
                <option value=""><?php _e('Select restocked', 'eiliyah-product-inventory'); ?></option>
        <?php
        $restocked = get_terms(array('taxonomy' => 'product_restocked', 'hide_empty' => false));
        foreach ($restocked as $restock) {
            echo '<option value="' . esc_attr($restock->term_id) . '" ' . selected(isset($_GET['product_restock']) && $_GET['product_restock'] == $color->term_id, true, false) . '>' . esc_html($restock->name) . '</option>';
        }
    }
}
