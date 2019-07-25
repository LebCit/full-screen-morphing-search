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
			'fsmsp_placeholder_text' => esc_attr( 'Search&hellip;' ),
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

	// Add Search Form Section.
	$wp_customize->add_section(
		'fsmsp_search_form',
		array(
			'title'    => __( 'FSMS Search Form', 'full-screen-morphing-search' ),
			'priority' => 10,
			'panel'    => 'fsmsp_panel',
		)
	);

	// ==========================
	// = FSMS Search Form Text. =
	// ==========================
	$wp_customize->add_setting(
		'fsmsp_options[fsmsp_search_form_text]',
		array(
			'default'           => '',
			'sanitize_callback' => 'wp_filter_nohtml_kses', // Strips all HTML from a text string.
			'capability'        => 'edit_theme_options',
			'type'              => 'option',
			'transport'         => 'postMessage',
		)
	);

	$wp_customize->add_control(
		'fsmsp_options[fsmsp_search_form_text]',
		array(
			'label'       => __( 'FSMS Search Form Text', 'full-screen-morphing-search' ),
			'description' => esc_attr__( 'Change the search form text. If leaved blank, it will return to original value !', 'full-screen-morphing-search' ),
			'section'     => 'fsmsp_search_form',
			'settings'    => 'fsmsp_options[fsmsp_search_form_text]',
			'type'        => 'text',
			'input_attrs' => array(
				'placeholder' => __( 'Search&hellip;', 'full-screen-morphing-search' ),
			),
		)
	);

	// Add Icons Section.
	$wp_customize->add_section(
		'fsmsp_icons',
		array(
			'title'    => __( 'FSMS Icons', 'full-screen-morphing-search' ),
			'priority' => 15,
			'panel'    => 'fsmsp_panel',
		)
	);

	// ======================
	// = FSMS Article Icon. =
	// ======================
	$wp_customize->add_setting(
		'fsmsp_options[fsmsp_article_icon]',
		array(
			'default'           => '',
			'type'              => 'option',
			'transport'         => 'postMessage',
			'sanitize_callback' => 'esc_url_raw',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Image_Control(
			$wp_customize,
			'fsmsp_options[fsmsp_article_icon]',
			array(
				'label'         => __( 'FSMS Article Icon', 'full-screen-morphing-search' ),
				'description'   => esc_attr__( 'Change the article icon.', 'full-screen-morphing-search' ),
				'section'       => 'fsmsp_icons',
				'settings'      => 'fsmsp_options[fsmsp_article_icon]',
				'button_labels' => array(
					'select'       => __( 'Select Article Icon' ),
					'change'       => __( 'Change Article Icon' ),
					'remove'       => __( 'Remove' ),
					'frame_title'  => __( 'Select Article Icon' ),
					'frame_button' => __( 'Choose Article Icon' ),
				),
			)
		)
	);

	$wp_customize->selective_refresh->add_partial(
		'fsmsp_options[fsmsp_article_icon]',
		array(
			'selector'        => 'div.dummy-media-object a.fsmsp-article-link',
			'settings'        => array( 'fsmsp_options[fsmsp_article_icon]' ),
			'render_callback' => 'full_screen_morphing_search_article_icon',
		)
	);

	// ====================================
	// = FSMS Article Icon/Image Classes. =
	// ====================================
	$wp_customize->add_setting(
		'fsmsp_options[fsmsp_article_i_classes]',
		array(
			'default'           => true,
			'type'              => 'option',
			'transport'         => 'postMessage',
			'sanitize_callback' => 'wp_validate_boolean',
		)
	);

	$wp_customize->add_control(
		'fsmsp_options[fsmsp_article_i_classes]',
		array(
			'label'    => __( 'Article Icon/Image Round or Not ?!', 'full-screen-morphing-search' ),
			'section'  => 'fsmsp_icons',
			'settings' => 'fsmsp_options[fsmsp_article_i_classes]',
			'type'     => 'checkbox',
		)
	);

	$wp_customize->selective_refresh->add_partial(
		'fsmsp_options[fsmsp_article_i_classes]',
		array(
			'selector'        => 'div.dummy-media-object a.fsmsp-article-link',
			'settings'        => array( 'fsmsp_options[fsmsp_article_i_classes]' ),
			'render_callback' => 'full_screen_morphing_search_article_icon',
		)
	);

	// =======================
	// = FSMS Category Icon. =
	// =======================
	$wp_customize->add_setting(
		'fsmsp_options[fsmsp_category_icon]',
		array(
			'default'           => '',
			'type'              => 'option',
			'transport'         => 'postMessage',
			'sanitize_callback' => 'esc_url_raw',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Image_Control(
			$wp_customize,
			'fsmsp_options[fsmsp_category_icon]',
			array(
				'label'         => __( 'FSMS Category Icon', 'full-screen-morphing-search' ),
				'description'   => esc_attr__( 'Change the category icon.', 'full-screen-morphing-search' ),
				'section'       => 'fsmsp_icons',
				'settings'      => 'fsmsp_options[fsmsp_category_icon]',
				'button_labels' => array(
					'select'       => __( 'Select Category Icon' ),
					'change'       => __( 'Change Category Icon' ),
					'remove'       => __( 'Remove' ),
					'frame_title'  => __( 'Select Category Icon' ),
					'frame_button' => __( 'Choose Category Icon' ),
				),
			)
		)
	);

	$wp_customize->selective_refresh->add_partial(
		'fsmsp_options[fsmsp_category_icon]',
		array(
			'selector'        => 'span.fsmsp-category-image',
			'settings'        => array( 'fsmsp_options[fsmsp_category_icon]' ),
			'render_callback' => 'full_screen_morphing_search_category_icon',
		)
	);

	// =====================================
	// = FSMS Category Icon/Image Classes. =
	// =====================================
	$wp_customize->add_setting(
		'fsmsp_options[fsmsp_category_i_classes]',
		array(
			'default'           => true,
			'type'              => 'option',
			'transport'         => 'postMessage',
			'sanitize_callback' => 'wp_validate_boolean',
		)
	);

	$wp_customize->add_control(
		'fsmsp_options[fsmsp_category_i_classes]',
		array(
			'label'    => __( 'Category Icon/Image Round or Not ?!', 'full-screen-morphing-search' ),
			'section'  => 'fsmsp_icons',
			'settings' => 'fsmsp_options[fsmsp_category_i_classes]',
			'type'     => 'checkbox',
		)
	);

	$wp_customize->selective_refresh->add_partial(
		'fsmsp_options[fsmsp_category_i_classes]',
		array(
			'selector'        => 'span.fsmsp-category-image',
			'settings'        => array( 'fsmsp_options[fsmsp_category_i_classes]' ),
			'render_callback' => 'full_screen_morphing_search_category_icon',
		)
	);

	// ==================
	// = FSMS Tag Icon. =
	// ==================
	$wp_customize->add_setting(
		'fsmsp_options[fsmsp_tag_icon]',
		array(
			'default'           => '',
			'type'              => 'option',
			'transport'         => 'postMessage',
			'sanitize_callback' => 'esc_url_raw',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Image_Control(
			$wp_customize,
			'fsmsp_options[fsmsp_tag_icon]',
			array(
				'label'         => __( 'FSMS Tag Icon', 'full-screen-morphing-search' ),
				'description'   => esc_attr__( 'Change the tag icon.', 'full-screen-morphing-search' ),
				'section'       => 'fsmsp_icons',
				'settings'      => 'fsmsp_options[fsmsp_tag_icon]',
				'button_labels' => array(
					'select'       => __( 'Select Tag Icon' ),
					'change'       => __( 'Change Tag Icon' ),
					'remove'       => __( 'Remove' ),
					'frame_title'  => __( 'Select Tag Icon' ),
					'frame_button' => __( 'Choose Tag Icon' ),
				),
			)
		)
	);

	$wp_customize->selective_refresh->add_partial(
		'fsmsp_options[fsmsp_tag_icon]',
		array(
			'selector'        => 'span.fsmsp-tag-image',
			'settings'        => array( 'fsmsp_options[fsmsp_tag_icon]' ),
			'render_callback' => 'full_screen_morphing_search_tag_icon',
		)
	);

	// ================================
	// = FSMS Tag Icon/Image Classes. =
	// ================================
	$wp_customize->add_setting(
		'fsmsp_options[fsmsp_tag_i_classes]',
		array(
			'default'           => true,
			'type'              => 'option',
			'transport'         => 'postMessage',
			'sanitize_callback' => 'wp_validate_boolean',
		)
	);

	$wp_customize->add_control(
		'fsmsp_options[fsmsp_tag_i_classes]',
		array(
			'label'    => __( 'Tag Icon/Image Round or Not ?!', 'full-screen-morphing-search' ),
			'section'  => 'fsmsp_icons',
			'settings' => 'fsmsp_options[fsmsp_tag_i_classes]',
			'type'     => 'checkbox',
		)
	);

	$wp_customize->selective_refresh->add_partial(
		'fsmsp_options[fsmsp_tag_i_classes]',
		array(
			'selector'        => 'span.fsmsp-tag-image',
			'settings'        => array( 'fsmsp_options[fsmsp_tag_i_classes]' ),
			'render_callback' => 'full_screen_morphing_search_tag_icon',
		)
	);

}
add_action( 'customize_register', 'full_screen_morphing_search_customize_register' );

/**
 * Render article icon for the selective refresh partial.
 */
function full_screen_morphing_search_article_icon() {
	$image_url         = get_option( 'fsmsp_options' )['fsmsp_article_icon'];
	$attachment_id     = attachment_url_to_postid( $image_url ); // Tries to convert an attachment URL into a post ID.
	$article_i_classes = get_option( 'fsmsp_options' )['fsmsp_article_i_classes'];
	$classes;
	if ( ! empty( $article_i_classes ) ) {
		$classes = 'round fsmsp-article-icon';
	} else {
		$classes = 'fsmsp-article-icon';
	}
	echo wp_get_attachment_image( $attachment_id, 'thumbnail', '', array( 'class' => $classes ) ); // Get an HTML img element representing an image attachment.
}

/**
 * Render category icon for the selective refresh partial.
 */
function full_screen_morphing_search_category_icon() {
	$imagecat_url       = get_option( 'fsmsp_options' )['fsmsp_category_icon'];
	$attachmentcat_id   = attachment_url_to_postid( $imagecat_url );
	$category_i_classes = get_option( 'fsmsp_options' )['fsmsp_category_i_classes'];
	$classes;
	if ( ! empty( $category_i_classes ) ) {
		$classes = 'round fsmsp-category-icon';
	} else {
		$classes = 'fsmsp-category-icon';
	}
	echo wp_get_attachment_image( $attachmentcat_id, 'thumbnail', '', array( 'class' => $classes ) );
}

/**
 * Render tag icon for the selective refresh partial.
 */
function full_screen_morphing_search_tag_icon() {
	$imagetag_url     = get_option( 'fsmsp_options' )['fsmsp_tag_icon'];
	$attachmenttag_id = attachment_url_to_postid( $imagetag_url );
	$tag_i_classes    = get_option( 'fsmsp_options' )['fsmsp_tag_i_classes'];
	$classes;
	if ( ! empty( $tag_i_classes ) ) {
		$classes = 'round fsmsp-tag-icon';
	} else {
		$classes = 'fsmsp-tag-icon';
	}
	echo wp_get_attachment_image( $attachmenttag_id, 'thumbnail', '', array( 'class' => $classes ) );
}
