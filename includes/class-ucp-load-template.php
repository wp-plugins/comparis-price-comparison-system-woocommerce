<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Comparis Uou_Comparis_Load_Template
 *
 * Load Template Handler
 *
 * @class       Uou_Comparis_Load_Template
 * @version     1.0.0
 * @package     Comparis/Includes
 * @category    Class
 * @author      UouApps
 */
class Uou_Comparis_Load_Template {


    protected $filter_prefix = 'comparis';

    protected $theme_template_directory = 'comparis';


    protected $plugin_directory = UCP_DIR;


    protected $plugin_template_directory = 'templates';


    public function get_template_part( $slug, $name = null, $load = true ) {
        do_action( 'get_template_part_' . $slug, $slug, $name );

        $templates = $this->get_template_file_names( $slug, $name );

        return $this->locate_template( $templates, $load, false );
    }


    protected function get_template_file_names( $slug, $name ) {
        $templates = array();
        if ( isset( $name ) ) {
            $templates[] = $slug . '-' . $name . '.php';
        }
        $templates[] = $slug . '.php';


        return apply_filters( $this->filter_prefix . '_get_template_part', $templates, $slug, $name );
    }


    public function locate_template( $template_names, $load = false, $require_once = true ) {
        $located = false;

        $template_names = array_filter( (array) $template_names );
        $template_paths = $this->get_template_paths();

        foreach ( $template_names as $template_name ) {
            $template_name = ltrim( $template_name, '/' );

            foreach ( $template_paths as $template_path ) {
                if ( file_exists( $template_path . $template_name ) ) {
                    $located = $template_path . $template_name;
                    break 2;
                }
            }
        }

        if ( $load && $located ) {
            load_template( $located, $require_once );
        }

        return $located;
    }


    protected function get_template_paths() {
        $theme_directory = trailingslashit( $this->theme_template_directory );

        $file_paths = array(
            10  => trailingslashit( get_template_directory() ) . $theme_directory,
            100 => $this->get_templates_dir(),
        );


        if ( is_child_theme() ) {
            $file_paths[1] = trailingslashit( get_stylesheet_directory() ) . $theme_directory;
        }

        $file_paths = apply_filters( $this->filter_prefix . '_template_paths', $file_paths );


        ksort( $file_paths, SORT_NUMERIC );

        return array_map( 'trailingslashit', $file_paths );
    }

    protected function get_templates_dir() {
        return trailingslashit( $this->plugin_directory ) . $this->plugin_template_directory;
    }


}


// function uou_archive_shortcode(){
//     $template_loader = new Uou_Comparison_Load_Template();

//     ob_start();
//     $template = $template_loader->locate_template( 'archive-product.php' );
//     include( $template );
//     return ob_get_clean();
// }


// $template_loader = new Uou_Careers_Load_Template();
// public function uou_register_shortcode(){
//    ob_start();
//    $template = $this->template_loader->locate_template( 'register.php' );
//    include( $template );
//    return ob_get_clean();
// }

//new Uou_Careers_Load_Template();