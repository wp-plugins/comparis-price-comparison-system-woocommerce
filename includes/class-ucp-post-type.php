<?php

/**
 * Comparis 
 *
 * Add Custom Post Type
 *
 * @class       Comparis_Plugin_Post_Types
 * @version     1.0.1
 * @package     comparis/includes
 * @category    Class
 * @author      UouApps
 */


class Comparis_Plugin_Post_Types {
    public function __construct() {
        include( 'vendor/cuztom/cuztom.php' );

        $store = register_cuztom_post_type( 'Store', array(
            'supports' => array( 'title', 'editor', 'thumbnail' ),
        ) );

        $product = register_cuztom_post_type( 'Product', array(
            'rewrite' => false,
            'has_archive' => true
        ) );

        $product->add_taxonomy( 'Spec' );

        $args = array(
            'post_type'        => 'store',
            'posts_per_page' => -1,
        );

        $posts_array = get_posts( $args );

        $value = array();

        $value[0] = 'Select Store';


        foreach ($posts_array as $post) {
            $value[$post->ID] = $post->post_title;

        }


        $product->add_meta_box(
            'uou_pc_meta_box_id',
            'Store Name',
            array(
                array(
                    'name'          => 'store_name',
                    'label'         => __('Store Name', 'uou-pc'),
                    'description'   => __('Assign your product to a specific store', 'uou-pc'),
                    'type'          => 'select',
                    'options'       => $value
                )
            )
        );

        // Register custom taxonomies.
        $permalinks = get_option( 'woocommerce_permalinks' );
        
        $args = array(
                    'hierarchical'          => true,
                    'update_count_callback' => '_wc_term_recount',
                    'label'                 => __( 'Product Categories', 'uou-pc' ),
                    'labels' => array(
                            'name'              => __( 'Product Categories', 'uou-pc' ),
                            'singular_name'     => __( 'Product Category', 'uou-pc' ),
                            'menu_name'         => _x( 'Categories', 'Admin menu name', 'uou-pc' ),
                            'search_items'      => __( 'Search Product Categories', 'uou-pc' ),
                            'all_items'         => __( 'All Product Categories', 'uou-pc' ),
                            'parent_item'       => __( 'Parent Product Category', 'uou-pc' ),
                            'parent_item_colon' => __( 'Parent Product Category:', 'uou-pc' ),
                            'edit_item'         => __( 'Edit Product Category', 'uou-pc' ),
                            'update_item'       => __( 'Update Product Category', 'uou-pc' ),
                            'add_new_item'      => __( 'Add New Product Category', 'uou-pc' ),
                            'new_item_name'     => __( 'New Product Category Name', 'uou-pc' )
                        ),
                    'show_ui'               => true,
                    'query_var'             => true,
                    'capabilities'          => array(
                        'manage_terms' => 'manage_product_terms',
                        'edit_terms'   => 'edit_product_terms',
                        'delete_terms' => 'delete_product_terms',
                        'assign_terms' => 'assign_product_terms',
                    ),
                    'rewrite'               => array(
                        'slug'         => empty( $permalinks['category_base'] ) ? _x( 'product-category', 'slug', 'uou-pc' ) : $permalinks['category_base'],
                        'with_front'   => false,
                        'hierarchical' => true,
                    ),
                );
        $product_cat = register_cuztom_taxonomy( 'product_cat', 'product', $args );

        // Add image field to Genre (Note that you need to wrap all the fields in an array).
        $product_cat->add_term_meta (
            array(
                array(
                    'name'        => 'cat_icon',
                    'label'       => __( 'Category Icon', 'uou-pc' ),
                    'description' => __( 'Add font awseome icon like: <span style="color:green;">"fa-bicycle"</span>', 'uou-pc' ),
                    'type'        => 'text'
                )
            )
        );

        add_filter( 'manage_edit-product_cat_columns', array($this, 'uou_product_cat_tax_columns'));
        /*show type taxonomy column*/
        add_filter( 'manage_product_cat_custom_column', array($this, 'uou_manage_product_category_columns'), 10, 3 );

        // Register custom taxonomies.
        $brand = register_cuztom_taxonomy( 'Brand', 'product' );

        // Add image field to Genre (Note that you need to wrap all the fields in an array).
        $brand->add_term_meta (
            array(
                array(
                    'name'        => 'brand_image',
                    'label'       => __( 'Brand Image', 'uou-pc' ),
                    'description' => __( 'Featured Author Image', 'uou-pc' ),
                    'type'        => 'image'
                )
            )
        );

        add_filter( 'manage_edit-brand_columns', array($this, 'uou_product_types_tax_columns'));
        

        /*show type taxonomy column*/
        add_filter( 'manage_brand_custom_column', array($this, 'uou_manage_category_columns'), 10, 3 );

        $this->ucp_add_store_metabox($store);

        add_action( 'do_meta_boxes', array($this, 'ucp_change_store_image_box'));
        add_filter( 'enter_title_here', array($this, 'uou_change_default_title'));

        // Hook into the 'after_setup_theme' action
        // add_action( 'after_setup_theme', array($this, 'uou_custom_theme_features'));
    }


    public function uou_manage_product_category_columns($out, $column_name, $cat_id) {
        $icon = get_option( 'term_meta_product_cat_'.$cat_id, '' );

        if(!empty($icon))
            $icon_name = $icon['_cat_icon'];

        switch ($column_name) {

            case 'icon':
                if(!empty($icon_name)){
                    $out .= $icon_name . '<i class="iconpicker-display fa ' . $icon_name . '"></i>';
                } else {
                    $out .= '';
                }
                break;
            
            default:
                break;
        }

        return $out;
    }

    public function uou_product_cat_tax_columns() {
        $new_columns = array(
            'cb'            => '<input type="checkbox" />',
            'thumb'      => __('Image', 'uou-pc'),
            'icon'      => __('Icon', 'uou-pc'),
            'name'          => __('Name', 'uou-pc'),
            'description'       => __('Description', 'uou-pc'),
            'slug'          => __('Slug', 'uou-pc'),
            'posts'         => __('Count', 'uou-pc'),
        );
        return $new_columns;
    }

    private function ucp_add_store_metabox($store) {

        $store->add_meta_box(

            'uou_pc_meta_box_id',
            'Store URL and Store Location on Google Map',

            array(
                
                array(
                    'name'          => 'store_url',
                    'label'         => __('Store URL', 'uou-pc'),
                    'description'   => __('Store main website URL', 'uou-pc'),
                    'type'          => 'text'
                ),
                array(
                    'label' => __('Country Name ', 'uou-pc'),
                    'name' => 'country_name',
                    'type' => 'text',
                    'desc' => __('Country', 'uou-pc')
                ),
                array(
                    'label' => __('Region Name', 'uou-pc'),
                    'name' => 'region_name',
                    'type' => 'text',
                    'desc' => __('Region', 'uou-pc')
                ),
                array(
                    'label' => __('Address Name', 'uou-pc'),
                    'name' => 'address_name',
                    'type' => 'text',
                    'desc' => __('Address', 'uou-pc')
                ),
                array(
                    'label' => __('Zip Code of Region', 'uou-pc'),
                    'name' => 'zip_code',
                    'type' => 'text',
                    'desc' => __('ZIP codes', 'uou-pc')
                ),
                array(
                    'label' => 'map canvas',
                    'name'  => 'map_canvas',
                    'type' => 'hidden',

                ),
                array(
                    'name'          => 'convert_zip',
                    'label'         => 'Covert to zip code to latitude and longitude',
                    'description'   => 'click checkbox to find result',
                    'type'          => 'checkbox',
                    'default_value' => 'off'
                ),
                array(
                    'label' => __('Latitude', 'uou-pc'),
                    'name' => 'latitude',
                    'type' => 'text',
                    'std' => '0',
                    'desc' => __('Latitude', 'uou-pc')
                ),
                array(
                    'label' => __('Longitude', 'uou-pc'),
                    'name' => 'longitude',
                    'type' => 'text',
                    'std' => '0',
                    'desc' => __('longitude', 'uou-pc')
                ),
                array(
                    'name'          => 'status',
                    'label'         => '<div id="convert_gps_log"></div>',
                    'description'   => '',
                    'type'          => 'checkbox',
                ),

              )

          );
    }
    public function uou_manage_category_columns( $out, $column_name, $cat_id ) {
            
        $marker = get_option( 'term_meta_brand_'.$cat_id, '' );
        
        if(!empty($marker))
          $marker_icon = wp_get_attachment_image_src( $marker['_brand_image'],array(32,32) );   

        switch ($column_name) {
            case 'marker':
                if(!empty($marker_icon[0])){
                    $out .= '<img src="'.$marker_icon[0].'" alt="" width="32" height="32">';
                } else {
                    $out .= '<img src="' . wc_placeholder_img_src() . '" width="32" height="32" alt="">';
                }
                break;
            
            default:
                break;
        }
        return $out;
    }
    public function uou_product_types_tax_columns( $category_columns ) {
        $new_columns = array(
            'cb'            => '<input type="checkbox" />',
            'marker'      => __('Image', 'uou-pc'),
            'name'          => __('Name', 'uou-pc'),
            'description'       => __('Description', 'uou-pc'),
            'slug'          => __('Slug', 'uou-pc'),
            'posts'         => __('Items', 'uou-pc'),
        );
        return $new_columns;
    }

    public function ucp_change_store_image_box() {
        remove_meta_box( 'postimagediv', 'custom_post_type', 'side' );
        add_meta_box( 'postimagediv', __( 'Store Image', 'uou-pc' ), 'post_thumbnail_meta_box', 'store', 'side' );
    }

    public function uou_change_default_title( $title ) {
 
        $screen = get_current_screen();
     
        if ( 'store' == $screen->post_type ){
            $title = __( 'Store name', 'uou-pc' );
        }
     
        return $title;
    }

    // Register Theme Features
    public function uou_custom_theme_features()  {
        global $wp_version;

        // Add theme support for Featured Images
        add_theme_support( 'post-thumbnails', array( 'post', 'product', 'store' ) ); 
    }
}

new Comparis_Plugin_Post_Types();



