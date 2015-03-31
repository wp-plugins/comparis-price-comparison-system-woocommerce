<?php
/**
 * Plugin Name: Comparis
 * Plugin URI: http://uouapps.com/
 * Description: COMPARIS - Price Comparison WooCommerce Plugin: that allows to filtering through product and compare between the same product
 * Version: 1.0.0
 * Author: UouApps
 * Author URI: http://uouapps.com/
 * Wordpress Requires at least: 3.8
 * Tested up to: 4.0
 *
 * WooCommerce tested: 2.2.4
 *
 * Text Domain: uou-pc
 * Domain Path: /languages/
 *
 * @package comparis
 * @category Core
 * @author UouApps
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) )
    exit;


/**
 * Check if WooCommerce is active
 **/
if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {

    class Uou_Comparis_Plugin {
        
        public function __construct() {

            define( 'UCP', '1.0.0' );
            define( 'UCP_DIR', untrailingslashit( plugin_dir_path( __FILE__ ) ) );
            define( 'UCP_URL', untrailingslashit( plugins_url( basename( plugin_dir_path( __FILE__ ) ), basename( __FILE__ ) ) ) );
            define( 'UCP_CSS_PATH', UCP_URL.'/assets/css/' );
            define( 'UCP_JS_PATH', UCP_URL.'/assets/js/' );
            define( 'UCP_TEMPLATE_PATH', plugin_dir_path( __FILE__ ) . 'templates/' );
            define( 'UCP_WOOCOMMERCE_TEMPLATE_PATH', plugin_dir_path( __FILE__ ) . 'templates/woocommerce/' );
            define( 'UCP_INCLUDES_PATH', UCP_DIR. '/includes/' );

            require_once( UCP_INCLUDES_PATH . 'class-ucp-post-type.php' );
            include( UCP_INCLUDES_PATH . 'class-ucp-ajax.php' );
            
            require_once( UCP_INCLUDES_PATH . 'class-ucp-load-template.php' );
            require_once( UCP_INCLUDES_PATH . 'class-ucp-router.php' );
            
            include( UCP_INCLUDES_PATH . 'ucp-functions.php' );

            // Actions
            add_action( 'plugins_loaded', array( $this, 'ucp_load_comparis_textdomain' ) );

            add_action( 'wp_enqueue_scripts', array($this, 'ucp_scripts' ), 100 );
            add_action( 'admin_enqueue_scripts', array($this, 'ucp_admin_scripts' ) );

            // get path for templates used for page template ( like archive-product.php )
            add_filter( 'template_include', array($this, 'ucp_include_template_function' ), 100 );
            
            // get path for templates used in loop ( like content-product.php )
            add_filter( 'wc_get_template_part', array($this, 'ucp_get_template_part'), 10, 3 );
            
            // get path for all other templates.
            add_filter( 'woocommerce_locate_template', array($this, 'ucp_locate_template'), 10, 3 );

            add_filter( 'woocommerce_output_related_products_args', array($this, 'ucp_related_products_args' ) );

        }

        /**
         * Localization & Include custom product type
         * @return  void
         */
        public function ucp_load_comparis_textdomain() {
            load_plugin_textdomain( 'uou-pc', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
        }

        /**
         * Enqueue uou price comparison scripts and styles
         *
         * @return void
         */
        public function ucp_scripts() {

            wp_register_script( 'underscore', UCP_JS_PATH.'underscore-min.js', array(), UCP, true );
            wp_enqueue_script( 'underscore');

            wp_register_script( 'typeahead.bundle', UCP_JS_PATH.'typeahead.bundle.js', array(), UCP, true );
            wp_enqueue_script( 'typeahead.bundle');

            wp_register_style( 'uou-bootstrap', UCP_CSS_PATH.'bootstrap.css', array(), UCP, $media = 'all' );
            wp_enqueue_style( 'uou-bootstrap');
            
            wp_register_style('font-awesome', UCP_CSS_PATH.'font-awesome.min.css', array(), UCP, $media = 'all');
            wp_enqueue_style('font-awesome');

            wp_register_style( 'uou-style', UCP_CSS_PATH.'style.css', array(), UCP, $media = 'all' );
            wp_enqueue_style( 'uou-style');

            wp_register_style( 'uou-responsive', UCP_CSS_PATH.'responsive.css', array(), UCP, $media = 'all' );
            wp_enqueue_style( 'uou-responsive');

            wp_register_script( 'uou-google', 'https://maps.google.com/maps/api/js?sensor=false', array('jquery'), UCP, false);
            wp_enqueue_script( 'uou-google' );

            wp_register_script( 'uou-maplace', UCP_JS_PATH.'maplace.min.js', array('jquery'), UCP, false);
            wp_enqueue_script( 'uou-maplace' );

            wp_register_script( 'ucp-script', UCP_JS_PATH.'script.js', array('jquery'), UCP, true );
            wp_enqueue_script( 'ucp-script');

            wp_register_script( 'ucp-pagination', UCP_JS_PATH.'pagination.js', array('jquery'), UCP, true );
            wp_enqueue_script( 'ucp-pagination');

            wp_register_script( 'ucp-ajax-script', UCP_JS_PATH.'comparis-ajax.js', array('jquery', 'underscore', 'jquery-ui-core'), UCP, true );
            wp_enqueue_script( 'ucp-ajax-script');

            /* wp localize script */

            wp_localize_script( 'ucp-ajax-script', 'ajax_object', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );

            $template = get_option( 'template' );

             switch( $template ) {
                case 'twentythirteen' :
                    wp_register_style( 'ucp-twentythirteen', UCP_CSS_PATH.'twentythirteen.css', array(), $ver = false, $media = 'all' );
                    wp_enqueue_style( 'ucp-twentythirteen');
                    break;
                case 'twentyfourteen' :
                    wp_register_style( 'ucp-twentyfourteen', UCP_CSS_PATH.'twentyfourteen.css', array(), $ver = false, $media = 'all' );
                    wp_enqueue_style( 'ucp-twentyfourteen');
                    break;
             }

        }

        public function ucp_admin_scripts() {
            
            wp_enqueue_script('maps.google', 'http://maps.google.com/maps/api/js?sensor=false', array('jquery'), false, true);
            
            wp_register_style( 'fontawesome-min', UCP_CSS_PATH.'font-awesome.min.css', array(), $ver = false, $media = 'all' );
            wp_enqueue_style( 'fontawesome-min');

            wp_register_style( 'fontawesome-iconpicker', UCP_CSS_PATH.'fontawesome-iconpicker.css', array(), $ver = false, $media = 'all' );
            wp_enqueue_style( 'fontawesome-iconpicker');

            wp_register_script( 'fontawesome-iconpicker', UCP_JS_PATH.'fontawesome-iconpicker.js', array('jquery'), $ver = false, true );
            wp_enqueue_script('fontawesome-iconpicker');

            wp_register_script( 'ucp-admin', UCP_JS_PATH.'admin_script.js', array('jquery', 'fontawesome-iconpicker'), $ver = false, true );
            wp_enqueue_script('ucp-admin');

            wp_register_script( 'ucp-gps_converter', UCP_JS_PATH.'gps_converter.js', array('jquery'), $ver = false, true );
            wp_enqueue_script('ucp-gps_converter');
        }

        /**
         * ucp_include_template_function
         * 
         * Load product templates
         * @return $template_path
         */
        public function ucp_include_template_function( $template_path ) {
                
                if ( is_single() && get_post_type() == 'product' ) {
                    
                    // checks if the file exists in the theme first,
                    // otherwise serve the file from the plugin
                    if ( $theme_file = locate_template( array ( 'single-product.php' ) ) ) {
                        $template_path = $theme_file;
                    } else {
                        $template_path = UCP_TEMPLATE_PATH . 'single-product.php';
                    }

                } elseif ( is_product_taxonomy() ) {

                    if ( is_tax( 'product_cat' ) ) {
                        
                        // checks if the file exists in the theme first,
                        // otherwise serve the file from the plugin
                        if ( $theme_file = locate_template( array ( 'taxonomy-product_cat.php' ) ) ) {
                            $template_path = $theme_file;
                        } else {
                            $template_path = UCP_TEMPLATE_PATH . 'taxonomy-product_cat.php';
                        }

                    } else {

                        // checks if the file exists in the theme first,
                        // otherwise serve the file from the plugin
                        if ( $theme_file = locate_template( array ( 'archive-product.php' ) ) ) {
                            $template_path = $theme_file;
                        } else {
                            $template_path = UCP_TEMPLATE_PATH . 'archive-product.php';
                        }
                    }

                } elseif ( is_archive() && get_post_type() == 'product' ) {
                    
                    // checks if the file exists in the theme first,
                    // otherwise serve the file from the plugin
                    if ( $theme_file = locate_template( array ( 'archive-product.php' ) ) ) {
                        $template_path = $theme_file;
                    } else {
                        $template_path = UCP_TEMPLATE_PATH . 'archive-product.php';
                    }

                }

            return $template_path;
        }

        /**
         * ucp_get_template_part
         * 
         * get & overwrite WooCommerce templates form plugin in templates/woocommerce/ folder
         * @return $template
         */
        public function ucp_get_template_part( $template, $slug, $name ) { 

            // Look in comparis/templates/woocommerce/slug-name.php or comparis/templates/woocommerce/slug.php
            if ( $name ) {
                $path = UCP_TEMPLATE_PATH . WC()->template_path() . "{$slug}-{$name}.php";    
            } else {
                $path = UCP_TEMPLATE_PATH . WC()->template_path() . "{$slug}.php";    
            }

            return file_exists( $path ) ? $path : $template;
        }

        /**
         * ucp_locate_template
         * 
         * locate & overwrite WooCommerce templates form plugin in templates/woocommerce/ folder
         * @return $template
         */
        public function ucp_locate_template( $template, $template_name, $template_path ) { 

            $path = UCP_TEMPLATE_PATH . $template_path . $template_name;  
            return file_exists( $path ) ? $path : $template;
        }

        /**
         * ucp_related_products_args
         *
         * Customize related products posts per page count
         * @return $args
         */
        public function ucp_related_products_args( $args ) {
        
            $args['posts_per_page'] = 3; // 3 related products
            $args['columns'] = 2; // arranged in 2 columns
            return $args;
        }

    }

    $GLOBALS['Uou_Comparis_Plugin'] = new Uou_Comparis_Plugin();

} else {
    function ucp_admin_notice() {
        ?>
        <div class="error">
            <p><?php _e( 'Please Install WooCommerce first before activating the Comparis Plugin. You can download WooCommerce from <a href="http://wordpress.org/plugins/woocommerce/">here</a>.', 'uou-pc' ); ?></p>
        </div>
        <?php
    }
    add_action( 'admin_notices', 'ucp_admin_notice' );
}


