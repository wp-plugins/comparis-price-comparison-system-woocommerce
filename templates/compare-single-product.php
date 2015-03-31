<?php
/**
 * The template for displaying compare product content
 *
 *
 * @author 		UouApps
 * @package 	Comparis/Templates
 * @version     1.0.1
 */

$post_slug = get_query_var( 'compare' );

$post_slug_args = array(
  'name' => $post_slug,
  'post_type' => 'product',
  'post_status' => 'publish',
  'posts_per_page' => 1,
);

$my_query = null;
$my_query = new WP_Query($post_slug_args);

if( $my_query->have_posts() ) {
  while ($my_query->have_posts()) : $my_query->the_post();
    	

  		global $product;
			
		$cats = get_the_terms( $post->ID, 'product_cat' );
		$brand = get_the_terms( $post->ID, 'brand' );

		$cat_id = array();
		if( !empty($cats) ) {
			foreach ($cats as $key => $value) {
				$cat_id[] = $value->term_id;
			}
		}
		if( !empty($brand) ) {
			foreach ($brand as $key => $value) {
				$brand_id = $value->term_id;
			}
		}

		$search_title = get_the_title();

		$preview_image_url = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'large');
        if($preview_image_url) {
            $preview_thumbnail =  $preview_image_url[0];
        } else {
            $preview_thumbnail =  wc_placeholder_img_src();
        }

  endwhile;
}
wp_reset_query();  // Restore global post data stomped by the_post().

?>




<?php get_header(); ?>
	<?php
		/**
		 * uou_wrapper_start hook
		 *
		 * @return an <div id="main-content" class="main-content"> for twentyfourteen
		 * @return an <div id="page-content"> for other
		 */
		do_action( 'uou_theme_wrapper_start' );
	?>
		<div class="container">
			<div class="row">

				<div class="col-sm-4 page-sidebar">

					<?php ucp_comparis_sidebar(); ?>
				
				</div> <!-- end .page-sidebar -->

				<div class="col-sm-8 page-content">
					<div id="product-wrapper">
						<div id="compare-price-map" class="white-container"></div>

						<?php if( !empty($search_title) ) : ?>
							
							<div class="compare-price-product white-container">
								<div class="css-table">
									<div class="css-table-cell">
										<div class="thumb"><img src="<?php echo $preview_thumbnail; ?>" alt=""></div>
									</div>

									<div class="css-table-cell">
										<span><?php _e('You are searching for:', 'uou-pc'); ?></span>
										<h3><a href=""><?php echo $search_title; ?></a></h3>
									</div>
								</div>
							</div>

						<?php endif; ?>

						<div class="compare-price-head">
							<div class="css-table">
								<div class="css-table-cell product"><?php _e('Product', 'uou-pc'); ?></div>
								<div class="css-table-cell retailer"><?php _e('Retailer', 'uou-pc'); ?></div>
								<div class="css-table-cell price"><?php _e('Price', 'uou-pc'); ?></div>
							</div>
						</div>


						<?php
							if( !empty($cats) && !empty($brand) && !empty($search_title) ) {
								$args = array(
								    'post_type' => 'product',
								    's' => $search_title,
								    'posts_per_page' => -1,
								    'tax_query' => array(
								        'relation' => 'AND',
								        array(
								            'taxonomy' => 'product_cat',
								            'field' => 'id',
								            'terms' => $cat_id
								        ),
								        array(
								            'taxonomy' => 'brand',
								            'field' => 'id',
								            'terms' => $brand_id
								        )
								    )
								);
							} elseif( !empty($search_title) ) {
								$args = array(
								    'post_type' => 'product',
								    's' => $search_title,
								    'posts_per_page' => -1,
								);
							} else {
								echo '<p class="alert alert-success">' . __('Unfortunately there is no product available for comparing in your searching criteria.', 'uou-pc') . '</p>';
							}
							
							$the_query = new WP_Query($args);

							$location = array();
							$marker = plugins_url( '', dirname(__FILE__) ) . '/assets/img/marker.png';

							if( $the_query->have_posts() ) {
								while ($the_query->have_posts()) : $the_query->the_post(); 
								
								global $woocommerce;

								$get_price = get_post_meta( $post->ID, '_price', true );
	            				$price_html= get_woocommerce_currency_symbol() . ' ' . $get_price;


	            				$large_image_url = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'large');
					            if($large_image_url) {
					                $post_thumbnail =  $large_image_url[0];
					            } else {
					                $post_thumbnail =  wc_placeholder_img_src();
					            }


					            $store_id = get_post_meta( $post->ID, '_uou_pc_meta_box_id_store_name', true );

					            $store_url =  get_post_meta( $store_id, '_uou_pc_meta_box_id_store_url', true );

	            				$store_image_url = wp_get_attachment_image_src( get_post_thumbnail_id( $store_id ), 'large');
					            if($store_image_url) {
					                $store_thumbnail =  $store_image_url[0];
					            } else {
					                $store_thumbnail =  wc_placeholder_img_src();
					            }

					            $store = get_post($store_id);

					            $location[] = array(
									'lat' => get_post_meta( $store_id, '_uou_pc_meta_box_id_latitude', true ),
									'lon' => get_post_meta( $store_id, '_uou_pc_meta_box_id_longitude', true ),
									'title' => $store->post_title,
									'html' => '<a href="' . get_post_meta( $store_id, '_uou_pc_meta_box_id_store_url', true ) . '" target="_blank"><strong>'. $store->post_title . '</strong></a><br>
									' . $store->post_content . '<br><img src="' . $store_image_url[0] .'" width="116" height="80">',
									'icon' => $marker
								);

	            				?>
									<div class="compare-price-item white-container">
										<div class="css-table">
											<div class="css-table-cell image">
												<div class="thumb">
													<img src="<?php echo $post_thumbnail; ?>" alt="">
												</div>
											</div>

											<div class="css-table-cell product">
												<h6><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h6>
												<p><?php the_excerpt(); ?></p>
											</div>

											<div class="css-table-cell retailer">
												<a href="<?php echo $store_url; ?>" class="thumb"><img src="<?php echo $store_thumbnail; ?>" alt=""></a>
											</div>

											<div class="css-table-cell price">
												<span><?php echo $price_html; ?></span>
												<?php woocommerce_template_loop_add_to_cart(); ?>
											</div>
										</div>
									</div>
								<?php endwhile; ?>
								<div class="related-hook white-container mb0 clearfix">
									<div class="row">
										<?php do_action( 'woocommerce_after_single_product_summary' ); ?>
									</div>
								</div>
								
								<?php wp_reset_query();  // Restore global post data stomped by the_post().
							}
							?>


							<?php
							
							if( !empty($location) ) :
								
								$location = array_unique($location, SORT_REGULAR);

								$json = json_encode($location);
							?>

								<script>
									new Maplace({
										map_div: '#compare-price-map',
										map_options: {
											mapTypeId: google.maps.MapTypeId.ROADMAP,
											scrollwheel: false,
											zoom: 14
										},

										locations: <?php echo $json; ?>

									}).Load();

								</script>

							<?php endif; ?>

					</div> <!-- end #product-wrapper -->

		

					<?php
						/**
						 * ucp_filter_underscore_template hook
						 *
						 * @return underscore template for showing the filtering data
						 */
						do_action( 'ucp_filter_underscore_template' );
					?>

				</div> <!-- end .page-content -->
			</div>
		</div> <!-- end .container -->
	<?php
		/**
		 * uou_wrapper_end hook
		 *
		 * @return an </div> <!--end #main-content --> for twentyfourteen
		 * @return an </div> <!-- end #page-content --> for other
		 */
		do_action( 'uou_theme_wrapper_end' );
	?>
	<script>
		// jQuery(document).ready(function() {
		//     document.title = 'your title here';
		// });
	</script>
<?php
/**
 * get_sidebar()
 *
 * @return if the theme is twentyfourteen display the sidebar
 */
if(get_option( 'template' ) == 'twentyfourteen') {
	get_sidebar();
}
get_footer(); ?>