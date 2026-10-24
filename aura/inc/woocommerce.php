<?php
/**
 * WooCommerce and header integration for block templates.
 *
 * Product grids are real Product Collection blocks, so they stay editable in
 * the Site Editor. The Customizer only supplies the default column count when
 * a block does not set its own.
 *
 * @package Aura
 */

defined( 'ABSPATH' ) || exit;

/**
 * Columns used by product collections that do not set their own column count.
 *
 * @return int
 */
function aura_product_columns() {
	return min( 5, max( 2, (int) aura_mod( 'aura_product_columns' ) ) );
}

/**
 * Apply the Customizer column count to product collections without an explicit value.
 *
 * @param array $parsed_block Parsed block.
 * @return array
 */
function aura_product_collection_columns( $parsed_block ) {
	if ( 'woocommerce/product-collection' !== ( $parsed_block['blockName'] ?? '' ) ) {
		return $parsed_block;
	}

	$attrs = $parsed_block['attrs'] ?? array();
	if ( isset( $attrs['displayLayout']['columns'] ) ) {
		return $parsed_block;
	}

	$attrs['displayLayout'] = array_merge(
		array(
			'type'          => 'flex',
			'shrinkColumns' => true,
		),
		$attrs['displayLayout'] ?? array(),
		array( 'columns' => aura_product_columns() )
	);

	$parsed_block['attrs'] = $attrs;
	return $parsed_block;
}
add_filter( 'render_block_data', 'aura_product_collection_columns' );

/**
 * Hide header items the Customizer switched off.
 *
 * Items are identified by the className set in the Site Editor (aura-header-search,
 * aura-header-cart), so the header can still be moved or restyled freely.
 *
 * @param string $block_content Rendered block.
 * @param array  $block         Block data.
 * @return string
 */
function aura_header_item_visibility( $block_content, $block ) {
	$class = $block['attrs']['className'] ?? '';
	if ( ! is_string( $class ) || '' === $class ) {
		return $block_content;
	}

	if ( false !== strpos( $class, 'aura-header-search' ) && ! aura_mod( 'aura_header_show_search' ) ) {
		return '';
	}

	if ( false !== strpos( $class, 'aura-header-cart' ) && ! aura_mod( 'aura_header_show_cart' ) ) {
		return '';
	}

	return $block_content;
}
add_filter( 'render_block', 'aura_header_item_visibility', 10, 2 );

/**
 * [aura_copyright] shortcode, used in the footer template part.
 *
 * @return string
 */
function aura_copyright_shortcode() {
	$text = str_replace( '{year}', wp_date( 'Y' ), (string) aura_mod( 'aura_footer_copyright' ) );
	return '<div class="aura-copyright">' . wp_kses_post( $text ) . '</div>';
}
add_shortcode( 'aura_copyright', 'aura_copyright_shortcode' );

/**
 * Register the pattern category used by Aura's section patterns.
 */
function aura_register_pattern_categories() {
	register_block_pattern_category(
		'aura-sections',
		array( 'label' => __( 'Aura Sections', 'aura' ) )
	);
}
add_action( 'init', 'aura_register_pattern_categories' );
