<?php
/**
 * Customizer panel (English) and the bridge that feeds its values into theme.json.
 *
 * Everything the Site Editor can edit (typography, spacing, block styles,
 * templates, patterns) stays in the Site Editor. The Customizer holds a small
 * set of global switches and the base palette.
 *
 * @package Aura
 */

defined( 'ABSPATH' ) || exit;

/**
 * Register the Aura panel and its controls.
 *
 * @param WP_Customize_Manager $wp_customize Customizer manager.
 */
function aura_customize_register( $wp_customize ) {
	$wp_customize->add_panel(
		'aura_options',
		array(
			'title'       => __( 'Aura Theme Options', 'aura' ),
			'description' => __( 'Global switches for colors, layout, header, footer, WooCommerce and performance. Fonts, spacing, buttons and every template or block are edited in Appearance > Editor.', 'aura' ),
			'priority'    => 30,
		)
	);

	$sections = array(
		'aura_colors'      => __( 'Colors', 'aura' ),
		'aura_typography'  => __( 'Typography', 'aura' ),
		'aura_layout'      => __( 'Layout', 'aura' ),
		'aura_header'      => __( 'Header', 'aura' ),
		'aura_footer'      => __( 'Footer', 'aura' ),
		'aura_woocommerce' => __( 'WooCommerce', 'aura' ),
		'aura_performance' => __( 'Performance', 'aura' ),
	);
	foreach ( $sections as $id => $title ) {
		$wp_customize->add_section( $id, array( 'title' => $title, 'panel' => 'aura_options' ) );
	}

	$controls = array(
		// Colors.
		array( 'aura_color_primary', 'aura_colors', __( 'Primary (buttons and links)', 'aura' ), 'color' ),
		array( 'aura_color_text', 'aura_colors', __( 'Text', 'aura' ), 'color' ),
		array( 'aura_color_background', 'aura_colors', __( 'Background', 'aura' ), 'color' ),
		array( 'aura_color_surface', 'aura_colors', __( 'Surface (cards and footer)', 'aura' ), 'color' ),
		array( 'aura_color_border', 'aura_colors', __( 'Border', 'aura' ), 'color' ),
		// Typography.
		array(
			'aura_base_font_size', 'aura_typography', __( 'Base font size (px)', 'aura' ), 'range',
			array( 'min' => 14, 'max' => 22, 'step' => 1 ),
		),
		array(
			'aura_load_cdn_font', 'aura_typography', __( 'Load Vazirmatn from the jsDelivr CDN', 'aura' ), 'checkbox',
			array( 'description' => __( 'Turn off to use the system font stack only (local fallback, no external request).', 'aura' ) ),
		),
		// Layout.
		array(
			'aura_content_width', 'aura_layout', __( 'Content width (px)', 'aura' ), 'range',
			array( 'min' => 560, 'max' => 960, 'step' => 10 ),
		),
		array(
			'aura_container_width', 'aura_layout', __( 'Wide container width (px)', 'aura' ), 'range',
			array( 'min' => 960, 'max' => 1440, 'step' => 10 ),
		),
		array(
			'aura_border_radius', 'aura_layout', __( 'Corner radius (px)', 'aura' ), 'range',
			array( 'min' => 0, 'max' => 32, 'step' => 1 ),
		),
		// Header.
		array( 'aura_header_sticky', 'aura_header', __( 'Sticky header', 'aura' ), 'checkbox' ),
		array( 'aura_header_show_search', 'aura_header', __( 'Show product search in header', 'aura' ), 'checkbox' ),
		array( 'aura_header_show_cart', 'aura_header', __( 'Show cart icon in header', 'aura' ), 'checkbox' ),
		// Footer.
		array(
			'aura_footer_copyright', 'aura_footer', __( 'Copyright text', 'aura' ), 'textarea',
			array( 'description' => __( 'Use {year} to insert the current year. Basic HTML is allowed.', 'aura' ) ),
		),
		// WooCommerce.
		array(
			'aura_product_columns', 'aura_woocommerce', __( 'Products per row (shop and category pages)', 'aura' ), 'select',
			array( 'choices' => array( 2 => '2', 3 => '3', 4 => '4', 5 => '5' ) ),
		),
		array(
			'aura_shop_sidebar', 'aura_woocommerce', __( 'Show category sidebar on shop pages', 'aura' ), 'checkbox',
		),
		// Performance.
		array( 'aura_disable_animations', 'aura_performance', __( 'Disable animations', 'aura' ), 'checkbox' ),
		array( 'aura_lazy_load', 'aura_performance', __( 'Lazy-load images', 'aura' ), 'checkbox' ),
	);

	$defaults = aura_default_mods();

	foreach ( $controls as $control ) {
		list( $id, $section, $label, $type ) = $control;
		$extra   = $control[4] ?? array();
		$default = $defaults[ $id ];

		$wp_customize->add_setting(
			$id,
			array(
				'default'           => $default,
				'type'              => 'theme_mod',
				'capability'        => 'edit_theme_options',
				'transport'         => 'refresh',
				'sanitize_callback' => aura_customizer_sanitizer( $type, $default, $extra ),
			)
		);

		if ( 'color' === $type ) {
			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					$id,
					array(
						'label'   => $label,
						'section' => $section,
					)
				)
			);
			continue;
		}

		$args = array(
			'label'       => $label,
			'section'     => $section,
			'type'        => $type,
			'description' => $extra['description'] ?? '',
		);
		if ( 'range' === $type ) {
			$args['input_attrs'] = $extra;
		}
		if ( 'select' === $type ) {
			$args['choices'] = $extra['choices'];
		}
		$wp_customize->add_control( $id, $args );
	}
}
add_action( 'customize_register', 'aura_customize_register' );

/**
 * Build a sanitize callback for one control type.
 *
 * @param string $type    Control type.
 * @param mixed  $default Default value.
 * @param array  $extra   Extra arguments (min/max, choices).
 * @return callable
 */
function aura_customizer_sanitizer( $type, $default, $extra ) {
	switch ( $type ) {
		case 'color':
			return static function ( $value ) use ( $default ) {
				return sanitize_hex_color( $value ) ?: $default;
			};

		case 'range':
			return static function ( $value ) use ( $extra ) {
				return min( $extra['max'], max( $extra['min'], (int) $value ) );
			};

		case 'select':
			return static function ( $value ) use ( $extra, $default ) {
				$value = (int) $value;
				return array_key_exists( $value, $extra['choices'] ) ? $value : $default;
			};

		case 'textarea':
			return 'wp_kses_post';

		case 'checkbox':
			return 'wp_validate_boolean';
	}

	return 'sanitize_text_field';
}

/**
 * Apply Customizer values to theme.json (theme level).
 *
 * Global Styles edits made in the Site Editor are stored at the user level and
 * take precedence over these defaults.
 *
 * @param WP_Theme_JSON_Data $theme_json Theme data.
 * @return WP_Theme_JSON_Data
 */
function aura_theme_json_from_customizer( $theme_json ) {
	$data    = $theme_json->get_data();
	// get_data() keys the palette by origin ("theme"). Work on the flat list and pass it back flat.
	$palette = $data['settings']['color']['palette']['theme'] ?? $data['settings']['color']['palette'] ?? array();

	$map = array(
		'primary'  => 'aura_color_primary',
		'contrast' => 'aura_color_text',
		'base'     => 'aura_color_background',
		'surface'  => 'aura_color_surface',
		'border'   => 'aura_color_border',
	);

	foreach ( $palette as $index => $entry ) {
		$slug = $entry['slug'] ?? '';
		if ( isset( $map[ $slug ] ) ) {
			$palette[ $index ]['color'] = aura_mod( $map[ $slug ] );
		}
	}

	$radius = (int) aura_mod( 'aura_border_radius' );

	return $theme_json->update_with(
		array(
			'version'  => 3,
			'settings' => array(
				'color'  => array( 'palette' => $palette ),
				'layout' => array(
					'contentSize' => aura_mod( 'aura_content_width' ) . 'px',
					'wideSize'    => aura_mod( 'aura_container_width' ) . 'px',
				),
				'custom' => array(
					'base-font-size' => aura_mod( 'aura_base_font_size' ) . 'px',
					'radius'         => array(
						'sm'   => round( $radius / 2 ) . 'px',
						'md'   => $radius . 'px',
						'lg'   => round( $radius * 1.5 ) . 'px',
						'pill' => '999px',
					),
				),
			),
		)
	);
}
add_filter( 'wp_theme_json_data_theme', 'aura_theme_json_from_customizer' );
