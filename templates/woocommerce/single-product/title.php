<?php
/**
 * Single Product title
 *
 * @author 		UouApps
 * @package 	Comparis/Templates/WooCommerce
 * @version     1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
global $post;
?>
<h1 itemprop="name" class="product_title entry-title"><?php the_title(); ?></h1><a href="<?php echo home_url() . '/compare/' . $post->post_name; ?>"><?php _e('Compare Price', 'uou-pc'); ?></a>