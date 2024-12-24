<?php

/**
 * Class for managing product meta boxes
 */
class Advanced_Product_Manager_Meta_Boxes
{

    /**
     * Register the meta box
     */
    public function add_product_meta_boxes()
    {
        add_meta_box(
            'product_details',
            __('Product Details', 'advanced-product-manager'),
            array($this, 'show_product_details'),
            'product',
            'normal',
            'high'
        );
    }

    /**
     * Show fields in the meta box
     */
    public function show_product_details($post)
    {
        // var_dump($post);
        // print_r('Hello: ' . $post->ping_status);

        // Nonce field to verify the request
        wp_nonce_field(basename(__FILE__), 'product_details_nonce');

        // Get the current values of the fields
        $total_stocks = get_post_meta($post->ID, 'total_stocks', true);
        $total_sold = get_post_meta($post->ID, 'total_sold', true);
        $size = get_post_meta($post->ID, 'size', true);
        $colors = get_post_meta($post->ID, 'colors', true);

?>
        <table class="form-table">

            <tr>
                <th scope="row"><label for="total_stocks"><?php _e('Total Stocks', 'advanced-product-manager'); ?></label></th>
                <td><input type="number" id="total_stocks" name="total_stocks" value="<?php echo esc_attr($total_stocks); ?>" /></td>
            </tr>
            <tr>
                <th scope="row"><label for="total_sold"><?php _e('Total Sold', 'advanced-product-manager'); ?></label></th>
                <td><input type="number" id="total_sold" name="total_sold" value="<?php echo esc_attr($total_sold); ?>" /></td>
            </tr>
            <tr>
                <th scope="row"><label for="size"><?php _e('Size', 'advanced-product-manager'); ?></label></th>
                <td><input type="text" id="size" name="size" value="<?php echo esc_attr($size); ?>" /></td>
            </tr>
            <tr>
                <th scope="row"><label for="colors"><?php _e('Colors', 'advanced-product-manager'); ?></label></th>
                <td><input type="text" id="colors" name="colors" value="<?php echo esc_attr($colors); ?>" /></td>
            </tr>
        </table>
<?php
    }

    /**
     * Save the custom field values
     */
    public function save_product_meta($post_id)
    {

        // Check if our nonce is set.
        if (! isset($_POST['product_details_nonce']) || ! wp_verify_nonce($_POST['product_details_nonce'], basename(__FILE__))) {
            return $post_id;
        }

        // Check if user has permission to edit
        if (! current_user_can('edit_post', $post_id)) {
            return $post_id;
        }

        // Check if data was actually submitted.
        if (! isset($_POST['total_stocks']) || ! isset($_POST['total_sold']) || ! isset($_POST['size']) || ! isset($_POST['colors'])) {
            return $post_id;
        }


        // Sanitize and save the values
        $total_stocks = isset($_POST['total_stocks']) ? intval($_POST['total_stocks']) : 0;
        $total_sold = isset($_POST['total_sold']) ? intval($_POST['total_sold']) : 0;
        $size = isset($_POST['size']) ? sanitize_text_field($_POST['size']) : '';
        $colors = isset($_POST['colors']) ? sanitize_text_field($_POST['colors']) : '';

        // Update the meta field in the database
        update_post_meta($post_id, 'total_stocks', $total_stocks);
        update_post_meta($post_id, 'total_sold', $total_sold);
        update_post_meta($post_id, 'size', $size);
        update_post_meta($post_id, 'colors', $colors);
    }
}

// Initialize the class
$product_manager_meta_boxes = new Advanced_Product_Manager_Meta_Boxes();

// Hook into WordPress actions
add_action('add_meta_boxes', array($product_manager_meta_boxes, 'add_product_meta_boxes'));
add_action('save_post_product', array($product_manager_meta_boxes, 'save_product_meta'));
