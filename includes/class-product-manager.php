<?php
class Product_Manager
{
    public function __construct()
    {
        // Initialize the plugin features
        $this->init_post_type();
        $this->init_taxonomies();
        $this->init_meta_boxes();
        $this->init_columns();
        $this->init_filters();
        $this->init_admin_settings();
        // $this->init_admin_faultyStocks();
    }

    private function init_post_type()
    {
        // Corrected file path
        require_once plugin_dir_path(__FILE__) . 'class-product-post-type.php'; // No extra 'includes/'
        $this->post_type = new Product_Post_Type();  // Store the object for later use
    }

    private function init_taxonomies()
    {
        // Corrected file path
        require_once plugin_dir_path(__FILE__) . 'class-product-taxonomies.php'; // No extra 'includes/'
        $this->taxonomies = new Product_Taxonomies();  // Store the object for later use
    }

    private function init_meta_boxes()
    {
        // Corrected file path
        require_once plugin_dir_path(__FILE__) . 'class-product-manager-meta-boxes.php'; // No extra 'includes/'
        $this->meta_boxes = new Product_Manager_Meta_Boxes();  // Use the correct class name
    }

    private function init_columns()
    {
        // Corrected file path
        require_once plugin_dir_path(__FILE__) . 'class-product-columns.php'; // No extra 'includes/'
        $this->columns = new Product_Columns();  // Store the object for later use
    }

    private function init_filters()
    {
        // Corrected file path
        require_once plugin_dir_path(__FILE__) . 'class-product-filters.php'; // No extra 'includes/'
        $this->filters = new Product_Filters();  // Store the object for later use
    }

    private function init_admin_settings()
    {
        // Corrected file path
        require_once plugin_dir_path(__FILE__) . 'class-admin-settings.php'; // No extra 'includes/'
        $this->settings = new Admin_Settings();  // Store the object for later use
    }

    // private function init_admin_faultyStocks()
    // {
    //     // Corrected file path
    //     require_once plugin_dir_path(__FILE__) . 'class-admin-faulty-stocks.php'; // No extra 'includes/'
    //     $this->faultyStocks = new Class_admin_faulty_stocks();  // Store the object for later use
    // }
}
