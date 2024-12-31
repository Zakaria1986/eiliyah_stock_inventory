<?php
class Product_Filters
{
    public function __construct()
    {
        // Hooks for adding filters and modifying the query
        add_action('restrict_manage_posts', array($this, 'add_filter_to_products_list'));
        add_filter('pre_get_posts', array($this, 'filter_products_list'));
    }

    public function add_filter_to_products_list()
    {
        if (isset($_GET['post_type']) && $_GET['post_type'] == 'product') {
            // Separate variables for each filter
            $product_category = isset($_GET['filter_product_category']) ? intval($_GET['filter_product_category']) : '';
            $product_color    = isset($_GET['filter_product_color']) ? intval($_GET['filter_product_color']) : '';
            $product_size     = isset($_GET['filter_product_size']) ? intval($_GET['filter_product_size']) : '';

?>
            <form method="get" action="">
                <input type="hidden" name="post_type" value="product">
                <!-- Product Category Filter -->
                <select name="filter_product_category">
                    <option value=""><?php _e('Filter by Product Category', 'eiliyah-product-manager'); ?></option>
                    <?php
                    // Get top-level categories (parents)
                    $abayas_parent = get_term_by('slug', 'abayas', 'product_category');
                    if ($abayas_parent) {
                        // Fetch child categories under 'abayas' parent term
                        $parent_categories = get_terms(array(
                            'taxonomy'   => 'product_category',
                            'parent'     => $abayas_parent->term_id, // Use term ID, not the term object
                            'hide_empty' => false,
                        ));

                        foreach ($parent_categories as $parent_term) {
                            echo '<option value="' . esc_attr($parent_term->term_id) . '" ' . selected($product_category, $parent_term->term_id, false) . '>' . esc_html($parent_term->name) . '</option>';
                        }
                    }
                    ?>
                </select>

                <!-- Product Color Filter -->
                <select name="filter_product_color">
                    <option value=""><?php _e('Filter by Color', 'eiliyah-product-manager'); ?></option>
                    <?php
                    // Get the parent category for 'colors'
                    $colors_parent = get_term_by('slug', 'colours', 'product_category');
                    if ($colors_parent) {
                        $color_terms = get_terms(array(
                            'taxonomy'   => 'product_category',
                            'parent'     => $colors_parent->term_id,
                            'hide_empty' => true,
                        ));
                        foreach ($color_terms as $color) {
                            echo '<option value="' . esc_attr($color->term_id) . '" ' . selected($product_color, $color->term_id, false) . '>' . esc_html($color->name) . '</option>';
                        }
                    }
                    ?>
                </select>

                <!-- Product Size Filter -->
                <select name="filter_product_size">
                    <option value=""><?php _e('Filter by Size', 'eiliyah-product-manager'); ?></option>
                    <?php
                    // Get the parent category for 'sizes'
                    $sizes_parent = get_term_by('slug', 'sizes', 'product_category');
                    if ($sizes_parent) {
                        $size_terms = get_terms(array(
                            'taxonomy'   => 'product_category',
                            'parent'     => $sizes_parent->term_id,
                            'hide_empty' => true,
                        ));
                        foreach ($size_terms as $size) {
                            echo '<option value="' . esc_attr($size->term_id) . '" ' . selected($product_size, $size->term_id, false) . '>' . esc_html($size->name) . '</option>';
                        }
                    }
                    ?>
                </select>

                <!-- Reset Button -->
                <!-- <button type="submit" class="button"><?php //_e('Filter', 'eiliyah-product-manager'); 
                                                            ?></button> -->
                <a href="<?php echo remove_query_arg(array('filter_product_category', 'filter_product_color', 'filter_product_size')); ?>" class="button"><?php _e('Reset Filters', 'eiliyah-product-manager'); ?></a>
            </form>
<?php
        }
    }

    public function filter_products_list($query)
    {
        global $pagenow;

        if (is_admin() && $pagenow == 'edit.php' && isset($_GET['post_type']) && $_GET['post_type'] == 'product') {
            $tax_query = array();

            // Filter by Product Category (Parent and Child relationship)
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
                $tax_query[] = array(
                    'taxonomy' => 'product_category',  // Assuming 'product_color' is registered under 'product_category'
                    'field'    => 'term_id',
                    'terms'    => $color_term_id,
                    'operator' => 'IN',
                    'hide_empty' => false,
                );
            }

            // Filter by Product Size
            if (!empty($_GET['filter_product_size'])) {
                $size_term_id = intval($_GET['filter_product_size']);
                $tax_query[] = array(
                    'taxonomy' => 'product_category',   // Assuming 'product_size' is registered under 'product_category'
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
