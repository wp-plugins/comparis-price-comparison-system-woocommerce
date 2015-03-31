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

						<div class="compare-price-head">
							<div class="css-table">
								<div class="css-table-cell"><?php _e('Available Categories', 'uou'); ?></div>
							</div>
						</div>

						<div class="row">
							<?php

							 	$terms = ucp_get_product_categories();

								foreach ( $terms as $term ) :
								 
									if (!ucp_tax_has_children($term->term_id)) {
										
									    $term_link = get_term_link( $term );

									} else {

										$term_link = site_url() . '/product-categories/' . $term->slug . '/';
									}

							    // If there was an error, continue to the next term.
							    if ( is_wp_error( $term_link ) ) {
							        continue;
							    }
							?>
								<div class="col-lg-4 col-md-6">
									<div class="compare-price-category align-center white-container">
										<div class="thumb">
											<?php
											    global $wp_query;
											    // get the query object
											    $cat = $wp_query->get_queried_object();
											    // get the thumbnail id user the term_id
											    $thumbnail_id = get_woocommerce_term_meta( $term->term_id, 'thumbnail_id', true ); 
											    // get the image URL
											    $image = wp_get_attachment_url( $thumbnail_id ); 
											    // print the IMG HTML

											    if( $image ) {
											    	echo '<img src="'.$image.'" alt="' .$term->name. '" width="160" height="110" />';	
											    } else {
											    	echo '<img src="' . ucp_placeholder_img_src('category') . '" alt="' .$term->name. '" width="160" height="110" />';
												}
											?>
										</div>

										<h6><?php echo $term->name; ?></h6>

										<a href="<?php echo esc_url( $term_link ); ?>" class="btn btn-default"><?php _e('Browse', 'uou-pc') ?></a>
									</div>
								</div>

							<?php endforeach; ?>
						</div>

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