<?php
/**
 * The template for displaying product content within loops.
 *
 * Override this template by copying it to yourtheme/woocommerce/content-product.php
 *
 * @author 		UouApps
 * @package 	Comparis/Templates/WooCommerce
 * @version     1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $product, $woocommerce_loop;

// Store loop count we're currently on
if ( empty( $woocommerce_loop['loop'] ) )
	$woocommerce_loop['loop'] = 0;

// Store column count for displaying the grid
if ( empty( $woocommerce_loop['columns'] ) )
	$woocommerce_loop['columns'] = apply_filters( 'loop_shop_columns', 4 );

// Ensure visibility
if ( ! $product || ! $product->is_visible() )
	return;

// Increase loop count
$woocommerce_loop['loop']++;

// Extra post classes
$classes = array();
$classes[] = 'col-md-4 col-sm-6 col-xs-6';
if ( 0 == ( $woocommerce_loop['loop'] - 1 ) % $woocommerce_loop['columns'] || 1 == $woocommerce_loop['columns'] )
	$classes[] = 'first';
if ( 0 == $woocommerce_loop['loop'] % $woocommerce_loop['columns'] )
	$classes[] = 'last';
?>						
						<div <?php post_class( $classes ); ?>>
							<div class="compare-price-item grid white-container">
								<div class="image">
									<div class="thumb">
										<?php
											/**
											 * woocommerce_before_shop_loop_item_title hook
											 *
											 * @hooked woocommerce_show_product_loop_sale_flash - 10
											 * @hooked woocommerce_template_loop_product_thumbnail - 10
											 */
											do_action( 'woocommerce_before_shop_loop_item_title' );
										?>
									</div>
								</div>

								<div class="product">
									<h6><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h6>
								</div>
								<div class="retailer">
									<?php
										$store_id = get_post_meta( $post->ID, '_uou_pc_meta_box_id_store_name', true );
										$store_image_url = wp_get_attachment_image_src( get_post_thumbnail_id( $store_id ), 'large');
										$store_url =  get_post_meta( $store_id, '_uou_pc_meta_box_id_store_url', true );
							            if($store_image_url) {
							                $store_thumbnail =  $store_image_url[0];
							            } else {
							                $store_thumbnail =  wc_placeholder_img_src();
							            }
						            ?>
									<a href="<?php echo $store_url; ?>" class="thumb">
							            <img src="<?php echo $store_thumbnail; ?>" alt="">
									</a>
								</div>

								<div class="price">
									<?php if ( $price_html = $product->get_price_html() ) : ?>
										<?php echo $price_html; ?>
									<?php else : ?>
										<!-- no price -->
									<?php endif; ?>
									
									<a href="<?php echo home_url() . '/compare/' . $post->post_name; ?>" class="btn btn-default"><?php _e('Compare Price', 'uou-pc'); ?></a>
								</div>
							</div>
						</div>