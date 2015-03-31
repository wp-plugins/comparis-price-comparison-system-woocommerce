<?php 
/**
 * The Template for displaying all archive products.
 *
 * Override this template by copying it to yourtheme/archive-product.php
 *
 * @author 		UouApps
 * @package 	Comparis/Templates
 * @version     1.0.1
 */
get_header(); ?>
	<?php
		/**
		 * calling uou_wrapper_start hook
		 *
		 * @return an <div id="main-content" class="main-content"> for twentyfourteen
		 * @return an <div id="page-content"> for other theme
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
								<div class="css-table-cell"><?php _e('Available Products', 'uou-pc'); ?></div>
							</div>
						</div>

						<div class="row">
								
								<?php if ( have_posts() ) : ?>
			
										<?php // woocommerce_product_subcategories(); ?>

										<?php while ( have_posts() ) : the_post(); ?>

											<?php wc_get_template_part( 'content', 'product' ); ?>

										<?php endwhile; // end of the loop. ?>


								<?php elseif ( ! woocommerce_product_subcategories( array( 'before' => woocommerce_product_loop_start( false ), 'after' => woocommerce_product_loop_end( false ) ) ) ) : ?>

									<?php wc_get_template( 'loop/no-products-found.php' ); ?>

								<?php endif; ?>
						</div>
						<div class="clearfix mb30">
							<?php
								/**
								 * woocommerce_before_shop_loop hook
								 *
								 * @hooked woocommerce_result_count - 20
								 * @hooked woocommerce_catalog_ordering - 30
								 */
								do_action( 'woocommerce_before_shop_loop' );
							?>

							<?php
								/**
								 * woocommerce_after_shop_loop hook
								 *
								 * @hooked woocommerce_pagination - 10
								 */
								do_action( 'woocommerce_after_shop_loop' );
							?>
						</div>

					</div> <!-- end #product-wrapper -->

					<?php
						/**
						 * calling ucp_filter_underscore_template hook
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
		 * calling uou_wrapper_end hook
		 *
		 * @return an </div> <!--end #main-content --> for twentyfourteen
		 * @return an </div> <!-- end #page-content --> for other theme
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