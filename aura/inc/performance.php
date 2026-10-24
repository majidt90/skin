<?php
/**
 * Performance helpers: remove unneeded WordPress output, inline critical CSS,
 * defer non-critical CSS, add resource hints and body classes.
 *
 * @package Aura
 */

defined( 'ABSPATH' ) || exit;

/**
 * Remove head/script output that a block theme rarely needs.
 */
function aura_remove_bloat() {
	remove_action( 'wp_head', 'rsd_link' );
	remove_action( 'wp_head', 'wlwmanifest_link' );
	remove_action( 'wp_head', 'wp_generator' );
	remove_action( 'wp_head', 'wp_shortlink_wp_head' );
	remove_action( 'wp_head', 'wp_oembed_add_discovery_links' );
	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
	remove_action( 'wp_print_styles', 'print_emoji_styles' );
	remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
	remove_action( 'admin_print_styles', 'print_emoji_styles' );
	remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
	remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
	add_filter( 'emoji_svg_url', '__return_false' );
}
add_action( 'init', 'aura_remove_bloat' );

/**
 * Dequeue assets that are not needed on the front end.
 */
function aura_dequeue_extras() {
	wp_deregister_script( 'wp-embed' );

	if ( ! is_user_logged_in() ) {
		wp_deregister_style( 'dashicons' );
	}
}
add_action( 'wp_enqueue_scripts', 'aura_dequeue_extras', 100 );

/**
 * Preconnect to the font CDN.
 *
 * @param array  $urls          URLs or hint arrays.
 * @param string $relation_type Hint type.
 * @return array
 */
function aura_resource_hints( $urls, $relation_type ) {
	if ( 'preconnect' === $relation_type && aura_load_cdn_font() ) {
		$urls[] = array(
			'href'        => 'https://cdn.jsdelivr.net',
			'crossorigin' => 'anonymous',
		);
	}
	return $urls;
}
add_filter( 'wp_resource_hints', 'aura_resource_hints', 10, 2 );

/**
 * Output the critical CSS inline in <head>.
 */
function aura_inline_critical_css() {
	static $printed = false;
	if ( $printed ) {
		return;
	}
	$printed = true;

	$file = get_theme_file_path( 'assets/css/critical.css' );
	if ( is_readable( $file ) ) {
		echo '<style id="aura-critical-css">' . file_get_contents( $file ) . "</style>\n"; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}

	// Tiny inline flag that turns on scroll-reveal styles only when JS can run and motion is allowed.
	if ( aura_animations_enabled() ) {
		echo '<script>!function(d){if(!matchMedia("(prefers-reduced-motion: reduce)").matches){d.classList.add("aura-js")}}(document.documentElement)</script>' . "\n";
	}
}
add_action( 'wp_head', 'aura_inline_critical_css', 1 );

/**
 * Load the main stylesheet without blocking first render.
 *
 * @param string $html   Link tag.
 * @param string $handle Style handle.
 * @param string $href   Stylesheet URL.
 * @return string
 */
function aura_nonblocking_style_tag( $html, $handle, $href ) {
	if ( 'aura-main' !== $handle || is_admin() ) {
		return $html;
	}

	return sprintf(
		'<link rel="preload" href="%1$s" as="style" id="%2$s-css" onload="this.onload=null;this.rel=\'stylesheet\'" />' . "\n" . '<noscript><link rel="stylesheet" href="%1$s" /></noscript>' . "\n",
		esc_url( $href ),
		esc_attr( $handle )
	);
}
add_filter( 'style_loader_tag', 'aura_nonblocking_style_tag', 10, 3 );

/**
 * Lazy-load images (Customizer toggle). WordPress already lazy-loads by default.
 *
 * @param bool   $default  Default value.
 * @param string $tag_name Tag name.
 * @return bool
 */
function aura_lazy_load_filter( $default, $tag_name ) {
	if ( 'img' === $tag_name && ! aura_mod( 'aura_lazy_load' ) ) {
		return false;
	}
	return $default;
}
add_filter( 'wp_lazy_loading_enabled', 'aura_lazy_load_filter', 10, 2 );

/**
 * Body classes that drive CSS-only theme options.
 *
 * @param array $classes Existing classes.
 * @return array
 */
function aura_body_classes( $classes ) {
	if ( aura_mod( 'aura_header_sticky' ) ) {
		$classes[] = 'aura-header-sticky';
	}
	if ( aura_mod( 'aura_shop_sidebar' ) ) {
		$classes[] = 'aura-has-shop-sidebar';
	}
	if ( ! aura_animations_enabled() ) {
		$classes[] = 'aura-no-animations';
	}
	return $classes;
}
add_filter( 'body_class', 'aura_body_classes' );
