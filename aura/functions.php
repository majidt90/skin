<?php
/**
 * Aura theme bootstrap: theme support, asset loading and includes.
 *
 * Most of the design lives in theme.json and the Site Editor. This file stays
 * small on purpose and only wires things together.
 *
 * @package Aura
 */

defined( 'ABSPATH' ) || exit;

/**
 * Vazirmatn web font stylesheet (served by jsDelivr, pinned to a release tag).
 *
 * @return string
 */
function aura_font_url() {
	return apply_filters( 'aura_font_css_url', 'https://cdn.jsdelivr.net/gh/rastikerdar/vazirmatn@v33.003/Vazirmatn-font-face.css' );
}

/**
 * Default values for every Customizer option. Used by aura_mod() and the Customizer.
 *
 * @return array
 */
function aura_default_mods() {
	return array(
		'aura_color_primary'      => '#4338CA',
		'aura_color_text'         => '#0F172A',
		'aura_color_background'   => '#FFFFFF',
		'aura_color_surface'      => '#F8FAFC',
		'aura_color_border'       => '#E2E8F0',
		'aura_base_font_size'     => 16,
		'aura_load_cdn_font'      => true,
		'aura_content_width'      => 720,
		'aura_container_width'    => 1200,
		'aura_border_radius'      => 12,
		'aura_header_sticky'      => true,
		'aura_header_show_search' => true,
		'aura_header_show_cart'   => true,
		'aura_footer_copyright'   => '© {year} Aura. All rights reserved.',
		'aura_product_columns'    => 3,
		'aura_shop_sidebar'       => false,
		'aura_disable_animations' => false,
		'aura_lazy_load'          => true,
	);
}

/**
 * Read a Customizer option with its theme default.
 *
 * @param string $key Option key.
 * @return mixed
 */
function aura_mod( $key ) {
	$defaults = aura_default_mods();
	return get_theme_mod( $key, $defaults[ $key ] ?? null );
}

/**
 * Theme setup.
 */
function aura_setup() {
	load_theme_textdomain( 'aura', get_theme_file_path( 'languages' ) );

	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'wp-block-styles' );
	add_theme_support( 'editor-styles' );
	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' ) );

	// WooCommerce core support. Block templates handle layout; no legacy wrappers.
	add_theme_support( 'woocommerce' );

	$editor_styles = array( 'assets/css/editor.css' );
	if ( aura_load_cdn_font() ) {
		$editor_styles[] = aura_font_url();
	}
	add_editor_style( $editor_styles );
}
add_action( 'after_setup_theme', 'aura_setup' );

/**
 * Whether the Vazirmatn CDN stylesheet should load (Customizer option).
 *
 * @return bool
 */
function aura_load_cdn_font() {
	return (bool) aura_mod( 'aura_load_cdn_font' );
}

/**
 * Whether scroll and hover animations are enabled.
 *
 * @return bool
 */
function aura_animations_enabled() {
	return ! aura_mod( 'aura_disable_animations' );
}

/**
 * Front-end assets.
 */
function aura_enqueue_assets() {
	$version = wp_get_theme()->get( 'Version' );

	if ( aura_load_cdn_font() ) {
		// Font-display is "swap" in the stylesheet, so text is never invisible while loading.
		wp_enqueue_style( 'aura-vazirmatn', aura_font_url(), array(), null ); // phpcs:ignore WordPress.WP.EnqueuedResourceParameters.MissingVersion
	}

	// Non-critical CSS. Loaded without blocking render (see aura_nonblocking_style_tag()).
	wp_enqueue_style( 'aura-main', get_theme_file_uri( 'assets/css/aura.css' ), array(), $version );

	wp_enqueue_script(
		'aura-main',
		get_theme_file_uri( 'assets/js/aura.js' ),
		array(),
		$version,
		array(
			'in_footer' => true,
			'strategy'  => 'defer',
		)
	);
}
add_action( 'wp_enqueue_scripts', 'aura_enqueue_assets' );

/**
 * Includes.
 */
require_once get_theme_file_path( 'inc/performance.php' );
require_once get_theme_file_path( 'inc/customizer.php' );
require_once get_theme_file_path( 'inc/woocommerce.php' );
