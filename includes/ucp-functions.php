<?php
/**
 * Comparis Functions
 *
 * Functions for hook and template html
 *
 * @author 		UouApps
 * @category 	Core
 * @package 	comparis/includes
 * @version 	1.0.1
 */

/**
 * function ucp_comparis_sidebar()
 * @return sidebar html
 */
function ucp_comparis_sidebar() { ?>

				<aside>
					<div class="white-container mb0">
						<div class="widget sidebar-widget compare-price-search-widget">
							<h5 class="widget-title"><?php _e('Product Search', 'uou-pc'); ?></h5>

							<div class="widget-content">
								<form id="product-search-fields" type="post">
									
									<input type="text" class="form-control mt10 search-fields" name="s" placeholder="Search for ...">
									<div id="suggestions"></div>

									<input type="hidden" name="posts_per_page" class="posts_per_page" value="<?php echo get_option('posts_per_page'); ?>">

									<?php $args = array(
										'show_option_all'    => 'Categories',
										'hierarchical'       => 1,
										'name'				 => 'product_cat',
										'class'              => 'form-control mt10 mb10',
										'taxonomy'           => 'product_cat',
									); ?>
									<?php wp_dropdown_categories( $args ); ?>

									<?php $args = array(
										'show_option_all'    => 'Brands',
										'hierarchical'       => 1, 
										'name'				 => 'brand',
										'class'              => 'form-control mt10 mb10',
										'taxonomy'           => 'brand',
									); ?>
									<?php wp_dropdown_categories( $args ); ?>

									<input type="submit" class="btn btn-default btn-search" value="Search">
								</form>
							</div>
						</div>

						<div class="widget sidebar-widget compare-price-filter-widget">
							<h5 class="widget-title"><?php _e('Filter Results', 'uou-pc'); ?></h5>

							<div class="widget-content">

								<h6 class="filter-title"><?php _e('Price Range', 'uou-pc'); ?></h6>

								<div class="range-slider clearfix">
									<div class="slider" data-min="1" data-max="500000"></div>
									<div class="first-value"><span><?php _e('1', 'uou-pc'); ?></span></div>
									<div class="last-value"><span><?php _e('500000', 'uou-pc'); ?></span></div>
								</div>

								<input type="submit" class="btn btn-default btn-filter mt30" value="Filter">
							</div>
						</div>
					</div>
				</aside>
<?php }

/**
 * ucp_filter_underscore_template hook
 *
 * @return an uderscore template for loading the filtering data place this anywhere to your theme file
 */
add_action( 'ucp_filter_underscore_template', 'ucp_filter_underscore_template' );

function ucp_filter_underscore_template() { ?>
	
	<script type="text/html" id="product_box">

		<% if( _.isObject(v) ){ %>

			<div class="compare-price-head">
				<div class="css-table">
					<div class="css-table-cell"><?php _e('Available Products', 'uou-pc'); ?></div>
				</div>
			</div>

			<div class="row">
				<% _.each(v, function(v){ %>
					<div class="product-item col-sm-6 col-md-4">
						<div class="compare-price-item grid white-container">
							<div class="image">
								<div class="thumb">
									<img src="<%= v.post_thumbnail %>" alt="">
								</div>
							</div>

							<div class="product">
								<h6><a href="<%= v.post_permalink %>"><%= v.post_title %></a></h6>
							</div>

							<div class="retailer">
								<a href="<%= v.store_url %>" class="thumb"><img src="<%= v.store_thumbnail %>" alt="<%= v.store_name %>"></a>
							</div>

							<div class="price">
								<span><%= v.price_html %></span>
								<a href="<%= v.post_comparelink %>" class="btn btn-default"><?php _e('Compare Price', 'uou-pc'); ?></a>
							</div>
						</div>
					</div>
				<% }) %>
			</div>
		<%  } %>

	</script>

	<div class="clearfix mb30">
		<select rel="price_html" id="sort_price" class="form-control pull-left">
			<option value="0"><?php _e('Sort By', 'uou-pc'); ?></option>
			<option value="asc"><?php _e('Sort by price: low to high', 'uou-pc'); ?></option>
			<option value="desc"><?php _e('Sort by price: high to low', 'uou-pc'); ?></option>
		</select>
		
		<div class="pagination-wrapper"></div>

	</div>
		
	<script type="text/html" id="product_box_sorry">
		<div class="compare-price-product white-container">
			<div class="css-table">
				<div class="css-table-cell">
					<h3><?php _e('Sorry! No post found!', 'uou-pc'); ?></h3>
				</div>
			</div>
		</div>

		<div class="compare-price-head">
			<div class="css-table">
				<div class="css-table-cell"><?php _e('Available Products', 'uou-pc'); ?></div>
			</div>
		</div>

		<p class="alert alert-success"><?php _e('Unfortunately there is no product available for your searching criteria.', 'uou-pc'); ?></p>
	</script>

<?php }

/**
 * uou_theme_wrapper_start hook
 *
 * @return wrapper start for theme return an opening div with some id and class
 */
add_action( 'uou_theme_wrapper_start', 'uou_theme_wrapper_start' );

function uou_theme_wrapper_start() {
	$template = get_option( 'template' );

         switch( $template ) {

            case 'twentyfourteen' :
                echo '<div id="main-content" class="main-content theme-hack">';
                break;
            default :
            	echo '<div id="page-content">';
				break;
         }
}

/**
 * uou_theme_wrapper_end hook
 *
 * @return wrapper end for theme return an closing div </div>
 */
add_action( 'uou_theme_wrapper_end', 'uou_theme_wrapper_end' );

function uou_theme_wrapper_end() {
	$template = get_option( 'template' );

         switch( $template ) {

            case 'twentyfourteen' :
                echo '</div>';
                break;
            default :
            	echo '</div>';
				break;
         }
}

/**
 * function ucp_get_product_categories
 *
 * @return $terms
 */
function ucp_get_product_categories($parent = 0) {
	$taxonomy = 'product_cat';
	$args = array(
		'hide_empty'        => 0,
		'parent'            => $parent,
	);
	$terms = get_terms($taxonomy, $args);
	
	return $terms;
}

/**
 * function uou_get_product_brands
 *
 * @return $terms
 */

function ucp_tax_has_children($term_id) {
	global $wpdb;
	$term = get_queried_object();
		$check = $wpdb->get_results(" SELECT * FROM $wpdb->term_taxonomy WHERE parent = '$term_id' ");
     if ($check) {
          return true;
     } else {
          return false;
     }
}

/**
 * function uou_get_product_brands
 *
 * @return $terms
 */
function uou_get_product_brands() {
	$taxonomy = 'brand';
	$args = array(
		'hide_empty'        => 0,
		'parent'            => 0,
	);
	$terms = get_terms($taxonomy, $args);
	
	return $terms;
}

/**
 * function uou_get_brand_logo
 *
 * @return $logo_url
 */
function uou_get_brand_logo($term_id) {
	$brand = get_option( 'term_meta_brand_'.$term_id, '' );
											    
    if(!empty($brand))
      $logo = wp_get_attachment_image_src($brand['_brand_image'], 'large');        

    if(!empty($logo[0])){
        $logo_url = $logo[0];
    } else {
        $logo_url = ucp_placeholder_img_src('brand');
    }

    return $logo_url;
}


function uou_get_product_categories_icon($cat_id, $type = false) {
	$icon = get_option( 'term_meta_product_cat_'.$cat_id, '' );

    if(!empty($icon))
        $icon_check = $icon['_cat_icon'];
    if($type == true) {
    	if(!empty($icon_check)){
	        $icon_html = '<i class="fa ' . $icon_check . '"></i>';
	    } else {
	        $icon_html = '<i class="fa fa-globe"></i>';
	    }

	 	return $icon_html;

    } else {
    	if(!empty($icon_check)){
	        $icon_name = $icon_check;
	    } else {
	        $icon_name = 'fa-globe';
	    }

	    return $icon_name;
    }
}

/**
 * Provides a standard format for the page title depending on the view. This is
 * filtered so that plugins can provide alternative title formats.
 *
 * @param       string    $title    Default title text for current view.
 * @param       string    $sep      Optional separator.
 * @return      string              The filtered title.
 * @package     
 * @subpackage  includes
 * @version     1.0.1
 * @since       1.0.0
 */
function ucp_wp_title( $title, $sep ) {
	$name = get_bloginfo('name');

	if( get_query_var('brands') ) {
		$title = __('Brands');
		return "$title $sep";
	}

	if( get_query_var('product-categories') ) {
		
		if( get_query_var('product-categories') == 'yes' ) {
			$title = __('Product Categories');
			return "$title $sep";
		} else {
			$title .= __('Product Subcategories : ');
			$title .= get_query_var('product-categories');
			return "$title $sep";
		}

	}

	if( get_query_var('compare') ) {

		if( get_query_var('compare') == 'yes' ) {
			return;
		} else {
			$post_name = get_query_var( 'compare' );

			$args = array(
			  'name' => $post_name,
			  'post_type' => 'product',
			  'post_status' => 'publish',
			  'posts_per_page' => 1,
			);
			$my_posts = get_posts( $args );
			
			$title .= __('Compare : ');
			$title .= $my_posts[0]->post_title;
			return "$title $sep";
		}
	}

	if(is_shop()) {
		$title = __('Shop ', 'uou-pc') . $sep . ' ';
	}
 
	return $title;
 
}
add_filter( 'wp_title', 'ucp_wp_title', 10, 2 );


function ucp_placeholder_img_src($type = null) {
	if($type == 'brand') {
		return plugins_url( '', dirname(__FILE__) ) . '/assets/img/brand.png';
	} elseif($type == 'category') {
		return plugins_url( '', dirname(__FILE__) ) . '/assets/img/category.jpg';	
	} else {
		return wc_placeholder_img_src();
	}
	
}