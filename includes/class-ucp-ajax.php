<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Comparis Uou_Comparis_Plugin_Ajax
 *
 * AJAX Event Handler
 *
 * @class       Uou_Comparis_Plugin_Ajax
 * @version     1.0.1
 * @package     Comparis/Includes
 * @category    Class
 * @author      UouApps
 */


class Uou_Comparis_Plugin_Ajax {

	public function __construct(  ){

		add_action( 'wp_ajax_uou_comparis_search', array( $this, 'uou_comparis_search'));
		add_action( 'wp_ajax_nopriv_uou_comparis_search', array( $this , 'uou_comparis_search'));

	}

	public function uou_comparis_search() {

		$fields = $_POST['fields'];
		$start = $_POST['start'];
		$end = $_POST['end'];

		$search_title = '';
		
		$tax_query = array();
		
		$term_id = array();

		foreach ($fields as $field) {

			if($field['name'] == 'product_cat'){
				$term_id['product_cat'] = $field['value'];
			}

			if($field['name'] == 'brand'){
				$term_id['brand'] = $field['value'];
			}
			if(!empty($field['name']) && $field['name'] == 's'){
				$search_title = $field['value'];
			}
		}

		$term_product_cat = new stdClass();
		$term_product_cat->name = false;

		if($term_id['product_cat'] != 0) {
			$term_product_cat = get_term( $term_id['product_cat'], 'product_cat' );
		}
		
		$term_brand = new stdClass();
		$term_brand->name = false;

		if($term_id['brand'] != 0) {
			$term_brand = get_term( $term_id['brand'], 'brand' );
		}

		global $wpdb;

		if( !$search_title && !$term_product_cat->name && !$term_brand->name) {
			/**
			 * @var $querystr
			 * @var $query_object
			 *
			 	-
				- !$search_title && !$term_product_cat->name && !$term_brand->name
				- 
			 */
			$querystr= "SELECT DISTINCT $wpdb->posts.* FROM $wpdb->posts
			 						LEFT JOIN $wpdb->postmeta v1
			 							ON ( $wpdb->posts.ID = v1.post_id )

									WHERE ( v1.meta_key = '_price'
			 							AND v1.meta_value BETWEEN {$start} AND {$end} )
			 							AND $wpdb->posts.post_status = 'publish'
			 							AND $wpdb->posts.post_type = 'product' 
			 							ORDER BY $wpdb->posts.post_title ASC";


			$query_object = $wpdb->get_results($querystr);
		}
		elseif( $search_title && !$term_product_cat->name && !$term_brand->name) {
			/**
			 * @var $querystr
			 * @var $query_object
			 *
			 	-
				- $search_title && !$term_product_cat->name && !$term_brand->name
				- 
			 */

			$querystr= "SELECT DISTINCT $wpdb->posts.* FROM $wpdb->posts
			 						LEFT JOIN $wpdb->postmeta v1
			 							ON ( $wpdb->posts.ID = v1.post_id )
			 						LEFT JOIN $wpdb->term_relationships
			 							ON ( $wpdb->posts.ID = $wpdb->term_relationships.object_id )
			 						LEFT JOIN $wpdb->term_taxonomy
			 							ON ( $wpdb->term_relationships.term_taxonomy_id = $wpdb->term_taxonomy.term_taxonomy_id )
			 						LEFT JOIN $wpdb->terms
			 							ON ( $wpdb->term_taxonomy.term_id = $wpdb->terms.term_id ) 

									WHERE ( $wpdb->terms.name LIKE '%$search_title%'
			 							OR $wpdb->posts.post_content LIKE '%$search_title%'
			 							OR $wpdb->posts.post_title LIKE '%$search_title%' )
			 							AND ( v1.meta_key = '_price'
			 							AND v1.meta_value BETWEEN {$start} AND {$end} )
			 							AND $wpdb->posts.post_status = 'publish'
			 							AND $wpdb->posts.post_type = 'product' 
			 							ORDER BY $wpdb->posts.post_title ASC";

			$query_object = $wpdb->get_results($querystr);

		}  elseif( $search_title && !$term_product_cat->name && $term_brand->name) {

			/**
			 * @var $querystr
			 * @var $query_object
			 *
				-
				- $search_title && !$term_product_cat->name && $term_brand->name
				- 
			 *
			 */


				$querystr = "SELECT DISTINCT p.*
						FROM $wpdb->posts AS p
	  						INNER JOIN $wpdb->term_relationships AS rel1
	    						ON p.ID = rel1.object_id
	  						INNER JOIN $wpdb->term_taxonomy AS tax1 
	    						ON rel1.term_taxonomy_id = tax1.term_taxonomy_id
	  						INNER JOIN $wpdb->terms AS term1 
	    						ON tax1.term_id = term1.term_id

	  						INNER JOIN $wpdb->term_relationships AS rel2
	    						ON p.ID = rel2.object_id
	  						INNER JOIN $wpdb->term_taxonomy AS tax2 
	    						ON rel2.term_taxonomy_id = tax2.term_taxonomy_id
	  						INNER JOIN $wpdb->terms AS term2 
	    						ON tax2.term_id = term2.term_id

	    					LEFT JOIN $wpdb->postmeta v1
				 	 				ON (p.ID = v1.post_id)

							WHERE p.post_status = 'publish' 
	  							AND p.post_type = 'product'
	  							AND ( tax1.taxonomy = 'brand'
	  							AND term1.name ='$term_brand->name' )
	  							AND ( term2.name LIKE '%$search_title%'
	  							OR p.post_content LIKE '%$search_title%'
								OR p.post_title LIKE '%$search_title%' )
								AND ( v1.meta_key = '_price'
				 				AND v1.meta_value BETWEEN {$start} AND {$end} )
								ORDER BY p.post_title ASC";

				$query_object = $wpdb->get_results($querystr);


		} elseif( $search_title && $term_product_cat->name && !$term_brand->name) {

			/**
			 * @var $querystr
			 * @var $query_object
			 *
			 	-
			 	- $search_title && $term_product_cat->name && !$term_brand->name
			 	- 
			 *
			 */

				$querystr = "SELECT DISTINCT p.*
						FROM $wpdb->posts AS p
	  						INNER JOIN $wpdb->term_relationships AS rel1
	    						ON p.ID = rel1.object_id
	  						INNER JOIN $wpdb->term_taxonomy AS tax1 
	    						ON rel1.term_taxonomy_id = tax1.term_taxonomy_id
	  						INNER JOIN $wpdb->terms AS term1 
	    						ON tax1.term_id = term1.term_id

	  						INNER JOIN $wpdb->term_relationships AS rel2
	    						ON p.ID = rel2.object_id
	  						INNER JOIN $wpdb->term_taxonomy AS tax2 
	    						ON rel2.term_taxonomy_id = tax2.term_taxonomy_id
	  						INNER JOIN $wpdb->terms AS term2 
	    						ON tax2.term_id = term2.term_id

	    					LEFT JOIN $wpdb->postmeta v1
				 	 				ON ( p.ID = v1.post_id )

							WHERE p.post_status = 'publish' 
	  							AND p.post_type = 'product'
	  							AND ( tax1.taxonomy = 'product_cat'
	  							AND term1.name ='$term_product_cat->name' )
	  							AND ( term2.name LIKE '%$search_title%'
	  							OR p.post_content LIKE '%$search_title%'
								OR p.post_title LIKE '%$search_title%' )
								AND ( v1.meta_key = '_price'
				 				AND v1.meta_value BETWEEN {$start} AND {$end} )
								ORDER BY p.post_title ASC";

				$query_object = $wpdb->get_results($querystr);

		} elseif( !$search_title && $term_product_cat->name && $term_brand->name ) {

			/**
			 * @var $querystr
			 * @var $query_object
			 *
			 	-
			 	- !$search_title && $term_product_cat->name && $term_brand->name
			 	-
			 *
			 */

			 	$querystr = "SELECT DISTINCT *
							FROM $wpdb->posts AS p
	  						INNER JOIN $wpdb->term_relationships AS rel1
	    						ON p.ID = rel1.object_id
	  						INNER JOIN $wpdb->term_taxonomy AS tax1 
	    						ON rel1.term_taxonomy_id = tax1.term_taxonomy_id
	  						INNER JOIN $wpdb->terms AS term1 
	    						ON tax1.term_id = term1.term_id

	  						INNER JOIN $wpdb->term_relationships AS rel2
	    						ON p.ID = rel2.object_id
	  						INNER JOIN $wpdb->term_taxonomy AS tax2 
	    						ON rel2.term_taxonomy_id = tax2.term_taxonomy_id
	  						INNER JOIN $wpdb->terms AS term2 
	    						ON tax2.term_id = term2.term_id

	    					LEFT JOIN $wpdb->postmeta v1
			 	 				ON ( p.ID = v1.post_id )

							WHERE p.post_status = 'publish' 
	  							AND p.post_type = 'product'
	  							AND ( tax1.taxonomy = 'product_cat'
	  							AND term1.name ='$term_product_cat->name'
	  							AND tax2.taxonomy = 'brand'
	  							AND term2.name ='$term_brand->name' )
								AND ( v1.meta_key = '_price'
			 					AND v1.meta_value BETWEEN {$start} AND {$end} )
								ORDER BY p.post_title ASC";

			
			$query_object = $wpdb->get_results($querystr);
				
		} elseif( !$search_title && $term_product_cat->name && !$term_brand->name) {
			/**
			 * @var $querystr
			 * @var $query_object
			 *
			 	-
				- Only work for product_cat from categories select box
				- 
			 *
			 *
			 	-
			 	- !$search_title && $term_product_cat->name && !$term_brand->name
			 	-
			 */

			 	$querystr= "SELECT DISTINCT * FROM $wpdb->posts
			 						LEFT JOIN $wpdb->postmeta v1
			 							ON ( $wpdb->posts.ID = v1.post_id )
			 						LEFT JOIN $wpdb->term_relationships
			 							ON ( $wpdb->posts.ID = $wpdb->term_relationships.object_id )
			 						LEFT JOIN $wpdb->term_taxonomy
			 							ON ( $wpdb->term_relationships.term_taxonomy_id = $wpdb->term_taxonomy.term_taxonomy_id )
			 						LEFT JOIN $wpdb->terms
			 							ON ( $wpdb->term_taxonomy.term_id = $wpdb->terms.term_id ) 
									
									WHERE ( $wpdb->terms.name = '$term_product_cat->name' )
			 							AND (v1.meta_key = '_price'
			 							AND v1.meta_value BETWEEN {$start} AND {$end} )
			 							AND $wpdb->posts.post_status = 'publish'
			 							AND $wpdb->posts.post_type = 'product' 
			 							ORDER BY $wpdb->posts.post_title ASC";

			
			$query_object = $wpdb->get_results($querystr);

		} elseif( !$search_title && !$term_product_cat->name && $term_brand->name) {
			/**
			 * @var $querystr
			 * @var $query_object
			 *
			 	-
				- Only work for bdand from brands select box
				-
			 *
			 *
			 	-
			 	- !$search_title && !$term_product_cat->name && $term_brand->name
			 	- 
			 */

		 	$querystr= "SELECT DISTINCT * FROM $wpdb->posts
		 						LEFT JOIN $wpdb->postmeta v1
		 							ON ( $wpdb->posts.ID = v1.post_id )

		 						LEFT JOIN $wpdb->term_relationships
		 							ON ( $wpdb->posts.ID = $wpdb->term_relationships.object_id )

		 						LEFT JOIN $wpdb->term_taxonomy
		 							ON ( $wpdb->term_relationships.term_taxonomy_id = $wpdb->term_taxonomy.term_taxonomy_id )
		 						LEFT JOIN $wpdb->terms
		 							ON ( $wpdb->term_taxonomy.term_id = $wpdb->terms.term_id ) 
								
								WHERE ( $wpdb->terms.name = '$term_brand->name' )
		 							AND ( v1.meta_key = '_price'
		 							AND v1.meta_value BETWEEN {$start} AND {$end} )
		 							AND $wpdb->posts.post_status = 'publish'
		 							AND $wpdb->posts.post_type = 'product' 
		 							ORDER BY $wpdb->posts.post_title ASC";

			$query_object = $wpdb->get_results( $querystr );

		} elseif( $search_title && $term_product_cat->name && $term_brand->name ) {

			/**
			 * @var $querystr
			 * @var $query_object
			 *
			 	-
			 	- $search_title && $term_product_cat->name && $term_brand->name
			 	-
			 *
			 */


			 $querystr = "SELECT DISTINCT p.*
						FROM $wpdb->posts AS p
  						INNER JOIN $wpdb->term_relationships AS rel1
    						ON p.ID = rel1.object_id
  						INNER JOIN $wpdb->term_taxonomy AS tax1 
    						ON rel1.term_taxonomy_id = tax1.term_taxonomy_id
  						INNER JOIN $wpdb->terms AS term1 
    						ON tax1.term_id = term1.term_id

  						INNER JOIN $wpdb->term_relationships AS rel2
    						ON p.ID = rel2.object_id
  						INNER JOIN $wpdb->term_taxonomy AS tax2 
    						ON rel2.term_taxonomy_id = tax2.term_taxonomy_id
  						INNER JOIN $wpdb->terms AS term2 
    						ON tax2.term_id = term2.term_id
    					
    					INNER JOIN $wpdb->term_relationships AS rel3
	   						ON p.ID = rel3.object_id
   						INNER JOIN $wpdb->term_taxonomy AS tax3
     						ON rel3.term_taxonomy_id = tax3.term_taxonomy_id
   						INNER JOIN $wpdb->terms AS term3
     						ON tax3.term_id = term3.term_id

    					LEFT JOIN $wpdb->postmeta v1
			 	 				ON (p.ID = v1.post_id)

						WHERE p.post_status = 'publish' 
  							AND p.post_type = 'product'
  							AND ( tax1.taxonomy = 'product_cat'
  							AND term1.name ='$term_product_cat->name'
  							AND tax2.taxonomy = 'brand'
  							AND term2.name ='$term_brand->name' )
  							AND ( term3.name LIKE '%$search_title%'
  							OR p.post_content LIKE '%$search_title%'
							OR p.post_title LIKE '%$search_title%' )
							AND ( v1.meta_key = '_price'
			 				AND v1.meta_value BETWEEN {$start} AND {$end} )
							ORDER BY p.post_title ASC";

			$query_object = $wpdb->get_results($querystr);

		} else {

			/**
			 * @var NULL
			 * @return
			 *
			 	-
				- NOTHING TO DO.
				- 
			 */

			return;
		}


        $result = array();

        if( $query_object ) {

	        foreach($query_object as $key=>$post){
	            $data = array();
	            $data['post_title'] = $post->post_title;
	            $data['post_permalink'] = get_the_permalink($post->ID);
	            $data['post_comparelink'] = home_url() . '/compare/' . $post->post_name;

	            $get_price = get_post_meta( $post->ID, '_price', true );
	            $data['price_html'] = get_woocommerce_currency_symbol() . ' ' . $get_price;
	            $data['price'] = $get_price;

	            $large_image_url = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'large');
	            if($large_image_url) {
	                $data['post_thumbnail'] =  $large_image_url[0];
	            } else {
	                $data['post_thumbnail'] =  wc_placeholder_img_src();
	            }

	            $store_id = get_post_meta( $post->ID, '_uou_pc_meta_box_id_store_name', true );

	            $store = get_post($store_id);

	            $data['store_name'] = $store->post_title;

	            $data['store_url'] =  get_post_meta( $store_id, '_uou_pc_meta_box_id_store_url', true );

	            $store_image_url = wp_get_attachment_image_src( get_post_thumbnail_id( $store_id ), 'large');
	            if($store_image_url) {
	                $data['store_thumbnail'] =  $store_image_url[0];
	            } else {
	                $data['store_thumbnail'] =  wc_placeholder_img_src();
	            }

	            $result[] = $data;
	        }
	    }

        echo json_encode( $result );

      	wp_die();
	}

}

new Uou_Comparis_Plugin_Ajax();