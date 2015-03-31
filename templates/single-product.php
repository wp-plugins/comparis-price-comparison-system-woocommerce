<?php
/**
 * The Template for displaying all single products.
 *
 * Override this template by copying it to yourtheme/single-product.php
 *
 * @author 		UouApps
 * @package 	Comparis/Templates
 * @version     1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

get_header(); ?>

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

							<?php while ( have_posts() ) : the_post(); ?>

								<?php wc_get_template_part( 'content', 'single-product' ); ?>

							<?php endwhile; // end of the loop. ?>
						</div> <!-- end #product-wrapper -->

						<?php
							/**
							 * ucp_filter_underscore_template hook
							 *
							 * @return underscore template for show filtering data
							 */
							do_action( 'ucp_filter_underscore_template' );
						?>
					</div> <!-- end .page-content -->
				</div> <!-- end .row -->
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