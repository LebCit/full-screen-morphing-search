<?php
/**
 * Full Screen Morphing Search Functions
 *
 * @package WordPress
 */

/**
 * Register a new image size for the plugin.
 */
function full_screen_morphing_search_thumb() {
	add_image_size( 'full-screen-morphing-search-plugin-thumb', 50, 50, true );
}
add_action( 'init', 'full_screen_morphing_search_thumb' );

/**
 * This outputs the javascript needed to automate the live settings preview.
 * Also keep in mind that this function isn't necessary unless your settings
 * are using 'transport'=>'postMessage' instead of the default 'transport'
 * => 'refresh'.
 *
 * Used by hook: 'customize_preview_init'
 */
function fsmsp_customize_preview_js() {
	$handle    = 'fsmsp-customize-preview';
	$src       = plugins_url( 'assets/js/customize-preview.js', __FILE__ );
	$deps      = array( 'jquery', 'customize-preview' );
	$ver       = '0.1';
	$in_footer = true;
	wp_enqueue_script( $handle, $src, $deps, $ver, $in_footer );
	wp_localize_script(
		'fsmsp-customize-preview',
		'fsmsp_cp',
		array(
			'fsmsp_article_icon'     => '<img src="' . esc_url( plugins_url( 'assets/img/article.png', __FILE__ ) ) . '">',
			'fsmsp_category_icon'    => '<img src="' . esc_url( plugins_url( 'assets/img/category.png', __FILE__ ) ) . '">',
			'fsmsp_tag_icon'         => '<img src="' . esc_url( plugins_url( 'assets/img/tag.png', __FILE__ ) ) . '">',
			'fsmsp_placeholder_text' => esc_attr( 'Search &hellip;' ),
		)
	);
}
add_action( 'customize_preview_init', 'fsmsp_customize_preview_js' );

if ( ! function_exists( 'full_screen_morphing_search_add_svg_tags' ) ) {
	/**
	 * Function to add svg tags to wp_kses_allowed_html
	 *
	 * @see http://themelovin.com/add-allowed-html-tags-wordpress/
	 *
	 * To secure the output, to correctly escape it !
	 * @see https://wordpress.stackexchange.com/a/316943
	 *
	 * @param array $svg_tags The SVG Tags.
	 *
	 * @since 2.4
	 */
	function full_screen_morphing_search_add_svg_tags( $svg_tags ) {
		$svg_tags['svg']  = array(
			'version'     => true,
			'id'          => true,
			'xmlns'       => true,
			'xmlns:xlink' => true,
			'x'           => true,
			'y'           => true,
			'viewbox'     => true, // <= Must be lower case !
			'style'       => true,
			'xml:space'   => true,
		);
		$svg_tags['path'] = array(
			'fill' => true,
			'd'    => true,
		);
		return $svg_tags;
	}
	add_filter( 'wp_kses_allowed_html', 'full_screen_morphing_search_add_svg_tags' );
}

/**
 * Add our Customizer content.
 *
 * @param WP_Customize_Manager $wp_customize Manager instance.
 */
function full_screen_morphing_search_customize_register( $wp_customize ) {

	// Add FSMS Plugin Panel.
	$wp_customize->add_panel(
		'fsmsp_panel',
		array(
			'title'    => __( 'FSMS Plugin', 'full-screen-morphing-search' ),
			'priority' => 160,
		)
	);

	// Add Color Section.
	$wp_customize->add_section(
		'fsmsp_color',
		array(
			'title'    => __( 'FSMS Colors', 'full-screen-morphing-search' ),
			'priority' => 5,
			'panel'    => 'fsmsp_panel',
		)
	);

	// =====================================
	// = FSMS Main Backgroung Color Picker =
	// =====================================
	$wp_customize->add_setting(
		'fsmsp_options[fsmsp_main_backgroung_color]',
		array(
			'default'           => '#f1f1f1',
			'sanitize_callback' => 'sanitize_hex_color',
			'capability'        => 'edit_theme_options',
			'type'              => 'option',
			'transport'         => 'postMessage',

		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'fsmsp_options[fsmsp_main_backgroung_color]',
			array(
				'label'       => __( 'FSMS Main Backgroung Color', 'full-screen-morphing-search' ),
				'description' => esc_attr__( 'Change the main background color', 'full-screen-morphing-search' ),
				'section'     => 'fsmsp_color',
				'settings'    => 'fsmsp_options[fsmsp_main_backgroung_color]',
			)
		)
	);

	// =====================
	// = FSMS Close Color. =
	// =====================
	$wp_customize->add_setting(
		'fsmsp_options[fsmsp_close_icon_color]',
		array(
			'default'           => '#000',
			'sanitize_callback' => 'sanitize_hex_color',
			'capability'        => 'edit_theme_options',
			'type'              => 'option',
			'transport'         => 'postMessage',

		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'fsmsp_options[fsmsp_close_icon_color]',
			array(
				'label'       => __( 'FSMS Close Icon Color', 'full-screen-morphing-search' ),
				'description' => esc_attr__( 'Change the close icon color', 'full-screen-morphing-search' ),
				'section'     => 'fsmsp_color',
				'settings'    => 'fsmsp_options[fsmsp_close_icon_color]',
			)
		)
	);

	// =========================
	// = FSMS Search... Color. =
	// =========================
	$wp_customize->add_setting(
		'fsmsp_options[fsmsp_search_text_color]',
		array(
			'default'           => '#c2c2c2',
			'sanitize_callback' => 'sanitize_hex_color',
			'capability'        => 'edit_theme_options',
			'type'              => 'option',
			'transport'         => 'postMessage',

		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'fsmsp_options[fsmsp_search_text_color]',
			array(
				'label'       => __( 'FSMS Search&hellip; text Color', 'full-screen-morphing-search' ),
				'description' => esc_attr__( 'Change the search&hellip; text color', 'full-screen-morphing-search' ),
				'section'     => 'fsmsp_color',
				'settings'    => 'fsmsp_options[fsmsp_search_text_color]',
			)
		)
	);

	// ==========================
	// = FSMS Input Text Color. =
	// ==========================
	$wp_customize->add_setting(
		'fsmsp_options[fsmsp_input_text_color]',
		array(
			'default'           => '#ec5a62',
			'sanitize_callback' => 'sanitize_hex_color',
			'capability'        => 'edit_theme_options',
			'type'              => 'option',
			'transport'         => 'postMessage',

		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'fsmsp_options[fsmsp_input_text_color]',
			array(
				'label'       => __( 'FSMS Input Text Color', 'full-screen-morphing-search' ),
				'description' => esc_attr__( 'Change the input text color', 'full-screen-morphing-search' ),
				'section'     => 'fsmsp_color',
				'settings'    => 'fsmsp_options[fsmsp_input_text_color]',
			)
		)
	);

	// ================================
	// = FSMS Magnifier Submit Color. =
	// ================================
	$wp_customize->add_setting(
		'fsmsp_options[fsmsp_magnifier_submit_color]',
		array(
			'default'           => '#ddd',
			'sanitize_callback' => 'sanitize_hex_color',
			'capability'        => 'edit_theme_options',
			'type'              => 'option',
			'transport'         => 'postMessage',

		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'fsmsp_options[fsmsp_magnifier_submit_color]',
			array(
				'label'       => __( 'FSMS Magnifier Submit Color', 'full-screen-morphing-search' ),
				'description' => esc_attr__( 'Change the magnifier submit  color', 'full-screen-morphing-search' ),
				'section'     => 'fsmsp_color',
				'settings'    => 'fsmsp_options[fsmsp_magnifier_submit_color]',
			)
		)
	);

	// ========================
	// = FSMS Headings Color. =
	// ========================
	$wp_customize->add_setting(
		'fsmsp_options[fsmsp_headings_color]',
		array(
			'default'           => '#c2c2c2',
			'sanitize_callback' => 'sanitize_hex_color',
			'capability'        => 'edit_theme_options',
			'type'              => 'option',
			'transport'         => 'postMessage',

		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'fsmsp_options[fsmsp_headings_color]',
			array(
				'label'       => __( 'FSMS Headings Color', 'full-screen-morphing-search' ),
				'description' => esc_attr__( 'Change the headings color', 'full-screen-morphing-search' ),
				'section'     => 'fsmsp_color',
				'settings'    => 'fsmsp_options[fsmsp_headings_color]',
			)
		)
	);

	// ==================================
	// = FSMS Columns Background Color. =
	// ==================================
	$wp_customize->add_setting(
		'fsmsp_options[fsmsp_columns_background_color]',
		array(
			'default'           => '#ebebeb',
			'sanitize_callback' => 'sanitize_hex_color',
			'capability'        => 'edit_theme_options',
			'type'              => 'option',
			'transport'         => 'postMessage',

		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'fsmsp_options[fsmsp_columns_background_color]',
			array(
				'label'       => __( 'FSMS Columns Background Color', 'full-screen-morphing-search' ),
				'description' => esc_attr__( 'Change the columns background color', 'full-screen-morphing-search' ),
				'section'     => 'fsmsp_color',
				'settings'    => 'fsmsp_options[fsmsp_columns_background_color]',
				'input_attrs' => array( // Optional.
					'class'      => 'color-picker',
					'data-alpha' => true,
				),
			)
		)
	);

	// ========================================
	// = FSMS Columns Hover Background Color. =
	// ========================================
	$wp_customize->add_setting(
		'fsmsp_options[fsmsp_columns_hover_background_color]',
		array(
			'default'           => '#e4e4e5',
			'sanitize_callback' => 'sanitize_hex_color',
			'capability'        => 'edit_theme_options',
			'type'              => 'option',
			'transport'         => 'postMessage',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'fsmsp_options[fsmsp_columns_hover_background_color]',
			array(
				'label'       => __( 'FSMS Columns Hover Background Color', 'full-screen-morphing-search' ),
				'description' => esc_attr__( 'Change the columns hover background color', 'full-screen-morphing-search' ),
				'section'     => 'fsmsp_color',
				'settings'    => 'fsmsp_options[fsmsp_columns_hover_background_color]',
			)
		)
	);

	// =====================
	// = FSMS Links Color. =
	// =====================
	$wp_customize->add_setting(
		'fsmsp_options[fsmsp_links_color]',
		array(
			'default'           => '#b2b2b2',
			'sanitize_callback' => 'sanitize_hex_color',
			'capability'        => 'edit_theme_options',
			'type'              => 'option',
			'transport'         => 'postMessage',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'fsmsp_options[fsmsp_links_color]',
			array(
				'label'       => __( 'FSMS Links Color', 'full-screen-morphing-search' ),
				'description' => esc_attr__( 'Change the links color', 'full-screen-morphing-search' ),
				'section'     => 'fsmsp_color',
				'settings'    => 'fsmsp_options[fsmsp_links_color]',
			)
		)
	);

	// ===========================
	// = FSMS Links Hover Color. =
	// ===========================
	$wp_customize->add_setting(
		'fsmsp_options[fsmsp_links_hover_color]',
		array(
			'default'           => '#ec5a62',
			'sanitize_callback' => 'sanitize_hex_color',
			'capability'        => 'edit_theme_options',
			'type'              => 'option',
			'transport'         => 'postMessage',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'fsmsp_options[fsmsp_links_hover_color]',
			array(
				'label'       => __( 'FSMS Links Hover Color', 'full-screen-morphing-search' ),
				'description' => esc_attr__( 'Change the links hover color', 'full-screen-morphing-search' ),
				'section'     => 'fsmsp_color',
				'settings'    => 'fsmsp_options[fsmsp_links_hover_color]',
			)
		)
	);

}
add_action( 'customize_register', 'full_screen_morphing_search_customize_register' );

/**
 * Output fsmsp_main_backgroung_color.
 */
/*function fsmsp_main_backgroung_color() {
	$fsmsp_options = get_option( 'fsmsp_options' );
	if ( ! empty( $fsmsp_options['fsmsp_main_backgroung_color'] ) ) {
		$fsmsp_main_backgroung_color = $fsmsp_options['fsmsp_main_backgroung_color'];
	} else {
		$fsmsp_main_backgroung_color = '#f1f1f1';
	}
	echo esc_attr( $fsmsp_main_backgroung_color );
}*/

/**
 * Output fsmsp_close_icon_color.
 */
function fsmsp_close_icon_color() {
	$fsmsp_options = get_option( 'fsmsp_options' );
	if ( ! empty( $fsmsp_options['fsmsp_close_icon_color'] ) ) {
		$fsmsp_close_icon_color = $fsmsp_options['fsmsp_close_icon_color'];
	} else {
		$fsmsp_close_icon_color = '#000';
	}
	echo esc_attr( $fsmsp_close_icon_color );
}

/**
 * Output fsmsp_search_text_color.
 */
function fsmsp_search_text_color() {
	$fsmsp_options = get_option( 'fsmsp_options' );
	if ( ! empty( $fsmsp_options['fsmsp_search_text_color'] ) ) {
		$fsmsp_search_text_color = $fsmsp_options['fsmsp_search_text_color'];
	} else {
		$fsmsp_search_text_color = '#c2c2c2';
	}
	echo esc_attr( $fsmsp_search_text_color );
}

/**
 * Output fsmsp_input_text_color.
 */
function fsmsp_input_text_color() {
	$fsmsp_options = get_option( 'fsmsp_options' );
	if ( ! empty( $fsmsp_options['fsmsp_input_text_color'] ) ) {
		$fsmsp_input_text_color = $fsmsp_options['fsmsp_input_text_color'];
	} else {
		$fsmsp_input_text_color = '#ec5a62';
	}
	echo esc_attr( $fsmsp_input_text_color );
}

/**
 * Output FSMS Magnifier Submit Color.
 */
function fsmsp_svg_color() {
	// CN: Modify 'fill' attribute of <path> in <svg>.
	$response = wp_remote_get( 'https://plugins.svn.wordpress.org/full-screen-morphing-search/trunk/assets/img/magnifier.svg' );
	if ( is_array( $response ) && ! is_wp_error( $response ) ) {
		$svg = wp_remote_retrieve_body( $response );
		$dom = new DOMDocument();
		libxml_use_internal_errors( true );
		$dom->loadHTML( $svg );
		libxml_use_internal_errors( false );
		$nodes = $dom->getElementsByTagName( 'path' );
		foreach ( $nodes as $node ) {
			$fsmsp_options = get_option( 'fsmsp_options' );
			if ( ! empty( $fsmsp_options['fsmsp_magnifier_submit_color'] ) ) {
				$fill = $node->setAttribute( 'fill', $fsmsp_options['fsmsp_magnifier_submit_color'] );
			} else {
				$fill = $node->setAttribute( 'fill', '#ddd' );
			}
		}
		echo wp_kses( $dom->saveHTML(), 'full_screen_morphing_search_add_svg_tags' );
	}
}

/**
 * Output fsmsp_headings_color.
 */
function fsmsp_headings_color() {
	$fsmsp_options = get_option( 'fsmsp_options' );
	if ( ! empty( $fsmsp_options['fsmsp_headings_color'] ) ) {
		$fsmsp_headings_color = $fsmsp_options['fsmsp_headings_color'];
	} else {
		$fsmsp_headings_color = '#c2c2c2';
	}
	echo esc_attr( $fsmsp_headings_color );
}

/**
 * Output fsmsp_columns_background_color.
 */
function fsmsp_columns_background_color() {
	$fsmsp_options = get_option( 'fsmsp_options' );
	if ( ! empty( $fsmsp_options['fsmsp_columns_background_color'] ) ) {
		$fsmsp_columns_background_color = $fsmsp_options['fsmsp_columns_background_color'];
	} else {
		$fsmsp_columns_background_color = '#ebebeb';
	}
	echo esc_attr( $fsmsp_columns_background_color );
}

/**
 * Output fsmsp_columns_hover_background_color.
 */
function fsmsp_columns_hover_background_color() {
	$fsmsp_options = get_option( 'fsmsp_options' );
	if ( ! empty( $fsmsp_options['fsmsp_columns_hover_background_color'] ) ) {
		$fsmsp_columns_hover_background_color = $fsmsp_options['fsmsp_columns_hover_background_color'];
	} else {
		$fsmsp_columns_hover_background_color = '#e4e4e5';
	}
	echo esc_attr( $fsmsp_columns_hover_background_color );
}

/**
 * Output fsmsp_links_color.
 */
function fsmsp_links_color() {
	$fsmsp_options = get_option( 'fsmsp_options' );
	if ( ! empty( $fsmsp_options['fsmsp_links_color'] ) ) {
		$fsmsp_links_color = $fsmsp_options['fsmsp_links_color'];
	} else {
		$fsmsp_links_color = '#b2b2b2';
	}
	echo esc_attr( $fsmsp_links_color );
}

/**
 * Output fsmsp_links_hover_color.
 */
function fsmsp_links_hover_color() {
	$fsmsp_options = get_option( 'fsmsp_options' );
	if ( ! empty( $fsmsp_options['fsmsp_links_hover_color'] ) ) {
		$fsmsp_links_hover_color = $fsmsp_options['fsmsp_links_hover_color'];
	} else {
		$fsmsp_links_hover_color = '#ec5a62';
	}
	echo esc_attr( $fsmsp_links_hover_color );
}
