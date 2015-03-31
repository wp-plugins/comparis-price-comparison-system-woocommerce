<?php get_header() ?>
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
								<div class="css-table-cell"><?php _e('Available Brands', 'uou'); ?></div>
							</div>
						</div>

						<div class="row">
							<?php 
								$terms = uou_get_product_brands();

								foreach ( $terms as $term ) :

								    // The $term is an object, so we don't need to specify the $taxonomy.
								    $term_link = get_term_link( $term );
								   
								    // If there was an error, continue to the next term.
								    if ( is_wp_error( $term_link ) ) {
								        continue;
								    }
							?>
								<div class="col-md-4 col-xs-6">
									<div class="compare-price-category align-center white-container">
										<div class="thumb">
											<?php $logo_url = uou_get_brand_logo($term->term_id); ?>
											<img src="<?php echo $logo_url; ?>" width="116" height="81" alt="">
										</div>

										<h6><?php echo $term->name; ?></h6>

										<a href="<?php echo esc_url( $term_link ); ?>" class="btn btn-default"><?php _e('Browse', 'uou'); ?></a>
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