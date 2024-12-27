<?php

class Product_Filters
{
    public function __construct()
    {
        add_action('restrict_manage_posts', array($this, 'add_filter_to_products_list'));
        add_filter('pre_get_posts', array($this, 'filter_products_list'));
    }

    public function add_filter_to_products_list()
    {
        if (isset($_GET['post_type']) && $_GET['post_type'] == 'product') {
            $product_category = isset($_GET['filter_product_category']) ? $_GET['filter_product_category'] : '';
?>
            <select name="filter_product_category">
                <option value=""><?php _e('Filter by Product Category', 'advanced-product-manager'); ?></option>
                <?php
                $categories = get_terms(array(
                    'taxonomy' => 'product_category',
                    'hide_empty' => true,
                ));
                foreach ($categories as $category_term) {
                    echo '<option value="' . esc_attr($category_term->term_id) . '" ' . selected($product_category, $category_term->term_id, false) . '>' . esc_html($category_term->name) . '</option>';
                }
                ?>
            </select>


<?php
        }

           // Product Tag Filter
           $product_tag = isset($_GET['filter_product_tag']) ? intval($_GET['filter_product_tag']) : ''; 
           ?>
           <select name="filter_product_tag">
               <option value=""><?php _e('Filter by Tag', 'advanced-product-manager'); ?></option>
               <?php
               $tags = get_terms(array(
                   'taxonomy' => 'product_tag',
                   'hide_empty' => true,
               ));
               foreach ($tags as $tag) {
                   echo '<option value="' . esc_attr($tag->term_id) . '" ' . selected($product_tag, $tag->term_id, false) . '>' . esc_html($tag->name) . '</option>';
               }
               ?>
           </select>
           <?php 
    }

    public function filter_products_list($query)
    {
        global $pagenow;
       
        if (is_admin() && $pagenow == 'edit.php' && isset($_GET['post_type']) && $_GET['post_type'] == 'product') {
            if (!empty($_GET['filter_product_category'])) {
                $query->set('tax_query', array(
                    array(
                        'taxonomy' => 'product_category',
                        'field' => 'term_id',
                        'terms' => $_GET['filter_product_category'],
                        'operator' => 'IN',
                    ),
                ));
            }
            
        }
    }
}
