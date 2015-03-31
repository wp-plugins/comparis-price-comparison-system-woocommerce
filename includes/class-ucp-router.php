<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Comparis Uou_Comparis_Plugin_Router
 *
 * Routing Template Event Handler
 *
 * @class       Uou_Comparis_Plugin_Router
 * @version     1.0.1
 * @package     Comparis/Includes
 * @category    Class
 * @author      UouApps
 */

class Uou_Comparis_Plugin_Router {


    public function __construct(){
        add_action( 'init', array( $this , 'add_comparis_rule' ) );
        add_filter( 'query_vars',array( $this, 'add_comparis_query_var' ) );
        add_filter( 'template_include', array( $this, 'load_comparis_template' ) );

    }

    public function add_comparis_rule(){
        global $wp_rewrite;

        add_rewrite_rule(  'brands', 'index.php?brands=yes', 'top' );
        
        add_rewrite_rule(  'product-categories/([^/]+)', 'index.php?product-categories=$matches[1]', 'top' );

        add_rewrite_rule(  'product-categories', 'index.php?product-categories=yes', 'top' );

        add_rewrite_rule(  'compare/([^/]+)', 'index.php?compare=$matches[1]', 'top' );

        $wp_rewrite->flush_rules();
    }

    public function add_comparis_query_var( $vars ){

        $vars[] = 'brands';
        $vars[] = 'product-categories';
        $vars[] = 'compare';

        return $vars;
    }


    public function load_comparis_template($template){
        global $post;

        $template_loader = new Uou_Comparis_Load_Template();

        if ( get_query_var( 'brands' ) && get_query_var('brands') == 'yes' ) {

          return $template_loader->locate_template( 'taxonomy-brands.php' );

        } 
        if ( get_query_var( 'product-categories' ) && get_query_var('product-categories') == 'yes' ) {

          return $template_loader->locate_template( 'taxonomy-product-categories.php' );

        }
        elseif ( get_query_var( 'product-categories' ) && get_query_var('product-categories') != 'yes' ) {
            return $template_loader->locate_template( 'taxonomy-product-sub-categories.php' );
        }
        elseif ( get_query_var( 'compare' ) && get_query_var('compare') != 'yes' ) {
            return $template_loader->locate_template( 'compare-single-product.php' );
        }
        else {

            return $template;
        }
    }
}

new Uou_Comparis_Plugin_Router();