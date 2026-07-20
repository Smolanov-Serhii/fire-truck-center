<?php
/**
 * Card used in truck catalog and Truck Type archive results.
 *
 * @package Fire_Truck_Center
 */

$truck_id = get_the_ID();
$sku      = function_exists( 'get_field' ) ? get_field( 'sku', $truck_id ) : get_post_meta( $truck_id, 'sku', true );
?>
<a class="sale__item" href="<?php the_permalink(); ?>" aria-label="<?php echo esc_attr( get_the_title() ); ?>">
	<div class="sale__item-image">
		<?php the_post_thumbnail( 'large' ); ?>
	</div>
	<h2 class="sale__item-title"><?php the_title(); ?></h2>
	<?php if ( $sku ) : ?>
		<div class="sale__item-sku"><?php echo esc_html( $sku ); ?></div>
	<?php endif; ?>
	<div class="sale__item-price"><?php esc_html_e( 'More', 'fire-truck-center' ); ?></div>
	<div class="sale__item-lnk" aria-hidden="true">
		<svg width="61" height="41" viewBox="0 0 61 41" fill="none" xmlns="http://www.w3.org/2000/svg" focusable="false">
			<path d="M15.4999 0H28.9999L17.4615 41H3.96143L15.4999 0Z" fill="#C92D36"/>
			<path d="M34.25 0H39.75L28.5 41H23L34.25 0Z" fill="#C92D36"/>
			<path d="M11.3704 0H61V41H0L11.3704 0Z" fill="#C92D36"/>
			<path d="M27 23V17H35V12.16L42.84 20L35 27.84V23H27Z" fill="white"/>
		</svg>
	</div>
</a>
