<?php $sub_categories = get_query_var( 'product-categories' ); ?>

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
								<div class="css-table-cell"><?php _e('Available Sub Categories', 'uou'); ?></div>
							</div>
						</div>

						<div class="row">
							<?php 

								function check_cat_children($term_id) {
									global $wpdb;
									$term = get_queried_object();
										$check = $wpdb->get_results("SELECT * FROM $wpdb->term_taxonomy WHERE parent = '$term_id'");
								     if ($check) {
								          return true;
								     } else {
								          return false;
								     }
							 	}
							 	$taxonomy_name = 'product_cat';

							 	$terms_parent = get_term_by('slug', $sub_categories, $taxonomy_name);

							 	$term_child = $wpdb->get_results("SELECT * FROM $wpdb->term_taxonomy WHERE parent = '$terms_parent->term_id'");

							 	foreach ($term_child as $child) :
							 	
									$term_child_data = get_term_by( 'id', $child->term_id, $taxonomy_name, OBJECT );

									if (!check_cat_children($term_child_data->term_id)) {
									
									    $term_link = get_term_link( $term_child_data );
									    ?>
									    <div class="col-sm-6 col-md-4">
											<div class="compare-price-category align-center white-container">
												<div class="thumb">
													<?php
													    global $wp_query;
													    // get the query object
													    $cat = $wp_query->get_queried_object();
													    // get the thumbnail id user the term_id
													    $thumbnail_id = get_woocommerce_term_meta( $term_child_data->term_id, 'thumbnail_id', true ); 
													    // get the image URL
													    $image = wp_get_attachment_url( $thumbnail_id ); 
													    // print the IMG HTML

													    if( $image ) {
													    	echo '<img src="'.$image.'" alt="' .$term_child_data->name. '" width="160" height="110" />';	
													    } else {
													    	echo '<img src="' . ucp_placeholder_img_src('category') . '" alt="' .$term_child_data->name. '" width="160" height="110" />';
														}
													?>
												</div>

												<h6><?php echo $term_child_data->name; ?></h6>

												<a href="<?php echo esc_url( $term_link ); ?>" class="btn btn-default"><?php _e('Browse', 'uou'); ?></a>
											</div>
										</div>

									<?php } else {

										$terms_sub = get_term_children( $term_child_data->term_id, $taxonomy_name );

										$term_link = get_term_link( $terms_sub[0], $taxonomy_name );
										$term_child_data = get_term_by( 'id', $child->term_id, $taxonomy_name, OBJECT );

										?>
										<div class="col-sm-6 col-md-4">
											<div class="compare-price-category align-center white-container">
												<div class="thumb">
													<?php
													    global $wp_query;
													    // get the query object
													    $cat = $wp_query->get_queried_object();
													    // get the thumbnail id user the term_id
													    $thumbnail_id = get_woocommerce_term_meta( $term_child_data->term_id, 'thumbnail_id', true ); 
													    // get the image URL
													    $image = wp_get_attachment_url( $thumbnail_id ); 
													    // print the IMG HTML

													    if( $image ) {
													    	echo '<img src="'.$image.'" alt="' .$term_child_data->name. '" width="160" height="110" />';	
													    } else {
													    	echo '<img src="http://placehold.it/160x110" alt="' .$term_child_data->name. '" width="160" height="110" />';
														}
													?>
												</div>

												<h6><?php echo $term_child_data->name; ?></h6>

												<a href="<?php echo esc_url( $term_link ); ?>" class="btn btn-default"><?php _e('Browse', 'uou'); ?></a>
											</div>
										</div>
										<?php
									}

							endforeach; ?>
							
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