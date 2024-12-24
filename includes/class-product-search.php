<?php

class Eilijah_Product_Search {

    public function __construct() {
        add_action( 'pre_get_posts', [ $this, 'modify_product_search' ] );
    }

    /**
     * Modify the product search query to filter by custom fields or taxonomies.
     *
     * @param WP_Query $query
     */

    public function modify_product_search( $query ) {
    
        // Ensure we're targeting the main query on the front end
        if ( ! is_admin() && $query->is_main_query() && ( is_search() || is_post_type_archive( 'product' ) ) ) {

            if ( isset( $_GET['total_stocks'] ) && ! empty( $_GET['total_stocks'] ) ) {
                $query->set( 'meta_query', array(
                    array(
                        'key'     => '_total_stocks',
                        'value'   => sanitize_text_field( $_GET['total_stocks'] ),
                        'compare' => 'LIKE'
                    ),
                ));
            }

            if ( isset( $_GET['total_sold'] ) && ! empty( $_GET['total_sold'] ) ) {
                $query->set( 'meta_query', array(
                    array(
                        'key'     => '_total_sold',
                        'value'   => sanitize_text_field( $_GET['total_sold'] ),
                        'compare' => 'LIKE'
                    ),
                ));
            }

            // Filter by custom taxonomies (e.g., Size or Color)
            if ( isset( $_GET['product_size'] ) && ! empty( $_GET['product_size'] ) ) {
                $query->set( 'tax_query', array(
                    array(
                        'taxonomy' => 'product_size',
                        'field'    => 'id',
                        'terms'    => sanitize_text_field( $_GET['product_size'] ),
                        'operator' => 'IN',
                    ),
                ));
            }

            if ( isset( $_GET['product_color'] ) && ! empty( $_GET['product_color'] ) ) {
                $query->set( 'tax_query', array(
                    array(
                        'taxonomy' => 'product_color',
                        'field'    => 'id',
                        'terms'    => sanitize_text_field( $_GET['product_color'] ),
                        'operator' => 'IN',
                    ),
                ));
            }
        }
    }

    /**
     * Render the custom search form with filters.
     */
    public static function render_product_search_form() {
        ?>
        <form method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
            <input type="text" name="s" placeholder="<?php _e( 'Search Products...', 'eiliyah-product-inventory' ); ?>" value="<?php echo get_search_query(); ?>" />

            <label for="total_stocks"><?php _e( 'Total Stocks', 'eiliyah-product-inventory' ); ?></label>
            <input type="number" id="total_stocks" name="total_stocks" placeholder="<?php _e( 'Filter by Total Stocks', 'eiliyah-product-inventory' ); ?>" value="<?php echo isset( $_GET['total_stocks'] ) ? esc_attr( $_GET['total_stocks'] ) : ''; ?>" />

            <label for="total_sold"><?php _e( 'Total Sold', 'eiliyah-product-inventory' ); ?></label>
            <input type="number" id="total_sold" name="total_sold" placeholder="<?php _e( 'Filter by Total Sold', 'eiliyah-product-inventory' ); ?>" value="<?php echo isset( $_GET['total_sold'] ) ? esc_attr( $_GET['total_sold'] ) : ''; ?>" />

            <label for="product_size"><?php _e( 'Size', 'eiliyah-product-inventory' ); ?></label>
            <select name="product_size" id="product_size">
                <option value=""><?php _e( 'Select Size', 'eiliyah-product-inventory' ); ?></option>
                <?php
                $sizes = get_terms( array( 'taxonomy' => 'product_size', 'hide_empty' => false ) );
                foreach ( $sizes as $size ) {
                    echo '<option value="' . esc_attr( $size->term_id ) . '" ' . selected( isset( $_GET['product_size'] ) && $_GET['product_size'] == $size->term_id, true, false ) . '>' . esc_html( $size->name ) . '</option>';
                }
                ?>
            </select>

            <label for="product_color"><?php _e( 'Color', 'eiliyah-product-inventory' ); ?></label>
            <select name="product_color" id="product_color">
                <option value=""><?php _e( 'Select Color', 'eiliyah-product-inventory' ); ?></option>
                <?php
                $colors = get_terms( array( 'taxonomy' => 'product_color', 'hide_empty' => false ) );
                foreach ( $colors as $color ) {
                    echo '<option value="' . esc_attr( $color->term_id ) . '" ' . selected( isset( $_GET['product_color'] ) && $_GET['product_color'] == $color->term_id, true, false ) . '>' . esc_html( $color->name
