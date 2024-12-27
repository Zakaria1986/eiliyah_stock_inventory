<?php
class Product_Filters {

public function __construct() {
    // Hooks for adding filters and modifying the query
    add_action('restrict_manage_posts', array($this, 'add_filter_to_products_list'));
    add_filter('pre_get_posts', array($this, 'filter_products_list'));
}

public function add_filter_to_products_list() {
    if (isset($_GET['post_type']) && $_GET['post_type'] == 'product') {
        // Separate variables for each filter
        $product_category = isset($_GET['filter_product_category']) ? intval($_GET['filter_product_category']) : '';
        $product_color    = isset($_GET['filter_product_color']) ? intval($_GET['filter_product_color']) : '';
        $product_size     = isset($_GET['filter_product_size']) ? intval($_GET['filter_product_size']) : '';
        
        ?>
        <!-- Product Category Filter -->
        <select name="filter_product_category">
            <option value=""><?php _e('Filter by Product Category', 'advanced-product-manager'); ?></option>
            <?php
            $categories = get_terms(array(
                'taxonomy'   => 'product_category',
                'parent'     => 0,
                'hide_empty' => true,
            ));
            foreach ($categories as $category_term) {
                echo '<option value="' . esc_attr($category_term->term_id) . '" ' . selected($product_category, $category_term->term_id, false) . '>' . esc_html($category_term->name) . '</option>';
            }
            ?>
        </select>

        <!-- Product Color Filter -->
        <select name="filter_product_color">
            <option value=""><?php _e('Filter by Color', 'advanced-product-manager'); ?></option>
            <?php
            // Adjust this to your taxonomy for color
            $colors = get_terms(array(
                'taxonomy'   => 'product_category', // Assuming 'product_color' is registered
                'parent'     => 4,               // Adjust the parent term ID as needed
                'hide_empty' => true,
            ));
            foreach ($colors as $color) {
                echo '<option value="' . esc_attr($color->term_id) . '" ' . selected($product_color, $color->term_id, false) . '>' . esc_html($color->name) . '</option>';
            }
            ?>
        </select>

        <!-- Product Size Filter -->
        <select name="filter_product_size">
            <option value=""><?php _e('Filter by Size', 'advanced-product-manager'); ?></option>
            <?php
            // Adjust this to your taxonomy for size
            $sizes = get_terms(array(
                'taxonomy'   => 'product_category', // Assuming 'product_size' is registered
                'parent'     => 5,               // Adjust the parent term ID as needed
                'hide_empty' => true,
            ));
            foreach ($sizes as $size) {
                echo '<option value="' . esc_attr($size->term_id) . '" ' . selected($product_size, $size->term_id, false) . '>' . esc_html($size->name) . '</option>';
            }
            ?>
        </select>
    <?php
    }
}

public function filter_products_list($query) {
    global $pagenow;

    if (is_admin() && $pagenow == 'edit.php' && isset($_GET['post_type']) && $_GET['post_type'] == 'product') {
        $tax_query = array();

        // Filter by Product Category
        if (!empty($_GET['filter_product_category'])) {
            $category_term_id = intval($_GET['filter_product_category']);
            $tax_query[] = array(
                'taxonomy' => 'product_category',
                'field'    => 'term_id',
                'terms'    => $category_term_id,
                'operator' => 'IN',
                'hide_empty' => false,
            );
        }

        // Filter by Product Color
        if (!empty($_GET['filter_product_color'])) {
            $color_term_id = intval($_GET['filter_product_color']);
            error_log("Selected Color Term ID: " . $color_term_id);  // Log the selected color term ID for debugging
            
            $tax_query[] = array(
                'taxonomy' => 'product_category',  // Product color taxonomy
                'field'    => 'term_id',        // Filter by term ID
                'terms'    => $color_term_id,   // Filter products by selected color
                'operator' => 'IN',             // Match the terms associated with the products
                'hide_empty' => false,          // Include empty terms if needed
            );
        }

        // Filter by Product Size
        if (!empty($_GET['filter_product_size'])) {
            $size_term_id = intval($_GET['filter_product_size']);
            $tax_query[] = array(
                'taxonomy' => 'product_category',   // Product size taxonomy
                'field'    => 'term_id',
                'terms'    => $size_term_id,
                'operator' => 'IN',
                'hide_empty' => false,
            );
        }

        // Apply the tax query if filters are set
        if (!empty($tax_query)) {
            $query->set('tax_query', $tax_query);
        }
    }

    return $query;
}
}


