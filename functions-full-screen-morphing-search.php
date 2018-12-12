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
	$deps      = array( 'customize-preview' );
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
 * Require Kirki.
 */
require_once dirname( __FILE__ ) . '/assets/kirki/kirki.php';

/**
 * Setup Kirki Config.
 * Add Panel, Sections and Controls.
 */
if ( class_exists( 'Kirki' ) ) {
	// Setup Kirki Config.
	Kirki::add_config(
		'fsmsp_kirki',
		array(
			'capability'  => 'edit_theme_options',
			'option_type' => 'option',
			'option_name' => 'fsmsp_options',
		)
	);
	// Add FSMS Plugin Panel.
	Kirki::add_panel(
		'fsmsp_panel',
		array(
			'title'    => __( 'FSMS Plugin', 'full-screen-morphing-search' ),
			'priority' => 160,
		)
	);
	// Add Color Section.
	Kirki::add_section(
		'fsmsp_color',
		array(
			'title'    => __( 'FSMS Colors', 'full-screen-morphing-search' ),
			'priority' => 5,
			'panel'    => 'fsmsp_panel',
		)
	);
	// FSMS Main Backgroung Color.
	Kirki::add_field(
		'fsmsp_kirki',
		array(
			'type'        => 'color-alpha',
			'settings'    => 'fsmsp_main_backgroung_color',
			'label'       => __( 'FSMS Main Backgroung Color', 'full-screen-morphing-search' ),
			'description' => esc_attr__( 'Change the main background color', 'full-screen-morphing-search' ),
			'section'     => 'fsmsp_color',
			'default'     => '#f1f1f1',
			'transport'   => 'auto',
			'output'      => array(
				array(
					'element'  => array(
						'#morphsearch',
						'div.morphsearch-content',
					),
					'property' => 'background-color',
				),
			),
		)
	);
	// FSMS Close Color.
	Kirki::add_field(
		'fsmsp_kirki',
		array(
			'type'        => 'color-alpha',
			'settings'    => 'fsmsp_close_icon_color',
			'label'       => __( 'FSMS Close Icon Color', 'full-screen-morphing-search' ),
			'description' => esc_attr__( 'Change the close icon color', 'full-screen-morphing-search' ),
			'section'     => 'fsmsp_color',
			'default'     => '#000',
			'transport'   => 'auto',
			'output'      => array(
				array(
					'element'  => array(
						'span.morphsearch-close::before',
						'span.morphsearch-close::after',
					),
					'property' => 'background',
				),
			),
		)
	);
	// FSMS Search ... Color.
	Kirki::add_field(
		'fsmsp_kirki',
		array(
			'type'        => 'color-alpha',
			'settings'    => 'fsmsp_search_text_color',
			'label'       => __( 'FSMS Search &hellip; text Color', 'full-screen-morphing-search' ),
			'description' => esc_attr__( 'Change the search &hellip; text color', 'full-screen-morphing-search' ),
			'section'     => 'fsmsp_color',
			'default'     => '#c2c2c2',
			'transport'   => 'auto',
			'output'      => array(
				array(
					'element'  => 'input.morphsearch-input::placeholder',
					'property' => 'color',
				),
			),
		)
	);
	// FSMS Input Text Color.
	Kirki::add_field(
		'fsmsp_kirki',
		array(
			'type'        => 'color-alpha',
			'settings'    => 'fsmsp_input_text_color',
			'label'       => __( 'FSMS Input Text Color', 'full-screen-morphing-search' ),
			'description' => esc_attr__( 'Change the input text color', 'full-screen-morphing-search' ),
			'section'     => 'fsmsp_color',
			'default'     => '#ec5a62',
			'transport'   => 'auto',
			'output'      => array(
				array(
					'element'  => '.morphsearch-input',
					'property' => 'color',
					'suffix'   => ' !important',
				),
			),
		)
	);
	// FSMS Magnifier Submit Color.
	Kirki::add_field(
		'fsmsp_kirki',
		array(
			'type'        => 'color-alpha',
			'settings'    => 'fsmsp_magnifier_submit_color',
			'label'       => __( 'FSMS Magnifier Submit Color', 'full-screen-morphing-search' ),
			'description' => esc_attr__( 'Change the magnifier submit  color', 'full-screen-morphing-search' ),
			'section'     => 'fsmsp_color',
			'default'     => '#ddd',
			'transport'   => 'auto',
			'output'      => array(
				array(
					'element'  => '#Capa_1 path',
					'property' => 'fill',
				),
			),
		)
	);
	// FSMS Headings Color.
	Kirki::add_field(
		'fsmsp_kirki',
		array(
			'type'        => 'color-alpha',
			'settings'    => 'fsmsp_headings_color',
			'label'       => __( 'FSMS Headings Color', 'full-screen-morphing-search' ),
			'description' => esc_attr__( 'Change the headings color', 'full-screen-morphing-search' ),
			'section'     => 'fsmsp_color',
			'default'     => '#c2c2c2',
			'transport'   => 'auto',
			'output'      => array(
				array(
					'element'  => 'div.dummy-column h2',
					'property' => 'color',
				),
			),
		)
	);
	// FSMS Columns Background Color.
	Kirki::add_field(
		'fsmsp_kirki',
		array(
			'type'        => 'color-alpha',
			'settings'    => 'fsmsp_columns_background_color',
			'label'       => __( 'FSMS Columns Background Color', 'full-screen-morphing-search' ),
			'description' => esc_attr__( 'Change the columns background color', 'full-screen-morphing-search' ),
			'section'     => 'fsmsp_color',
			'default'     => 'rgba(118, 117, 128, 0.05)',
			'transport'   => 'auto',
			'output'      => array(
				array(
					'element'  => 'div.dummy-media-object',
					'property' => 'background',
				),
			),
		)
	);
	// FSMS Columns Hover Background Color.
	Kirki::add_field(
		'fsmsp_kirki',
		array(
			'type'        => 'color-alpha',
			'settings'    => 'fsmsp_columns_hover_background_color',
			'label'       => __( 'FSMS Columns Hover Background Color', 'full-screen-morphing-search' ),
			'description' => esc_attr__( 'Change the columns hover background color', 'full-screen-morphing-search' ),
			'section'     => 'fsmsp_color',
			'default'     => 'rgba(118, 117, 128, 0.1)',
			'transport'   => 'auto',
			'output'      => array(
				array(
					'element'  => array(
						'div.dummy-media-object:hover',
						'div.dummy-media-object:focus',
					),
					'property' => 'background',
				),
			),
		)
	);
	// FSMS Links Color.
	Kirki::add_field(
		'fsmsp_kirki',
		array(
			'type'        => 'color-alpha',
			'settings'    => 'fsmsp_links_color',
			'label'       => __( 'FSMS Links Color', 'full-screen-morphing-search' ),
			'description' => esc_attr__( 'Change the links color', 'full-screen-morphing-search' ),
			'section'     => 'fsmsp_color',
			'default'     => 'rgba(145, 145, 145, 0.7)',
			'transport'   => 'auto',
			'output'      => array(
				array(
					'element'  => 'div.dummy-column h3 a',
					'property' => 'color',
				),
			),
		)
	);
	// FSMS Links Hover Color.
	Kirki::add_field(
		'fsmsp_kirki',
		array(
			'type'        => 'color-alpha',
			'settings'    => 'fsmsp_links_hover_color',
			'label'       => __( 'FSMS Links Hover Color', 'full-screen-morphing-search' ),
			'description' => esc_attr__( 'Change the links hover color', 'full-screen-morphing-search' ),
			'section'     => 'fsmsp_color',
			'default'     => 'rgba(236, 90, 98, 1)',
			'transport'   => 'auto',
			'output'      => array(
				array(
					'element'  => 'div.dummy-media-object:hover h3 a',
					'property' => 'color',
				),
			),
		)
	);
	// Add Search Form Section.
	Kirki::add_section(
		'fsmsp_search_form',
		array(
			'title'    => __( 'FSMS Search Form', 'full-screen-morphing-search' ),
			'priority' => 10,
			'panel'    => 'fsmsp_panel',
		)
	);
	// FSMS Search Form Text.
	Kirki::add_field(
		'fsmsp_kirki',
		array(
			'type'        => 'text',
			'settings'    => 'fsmsp_search_form_text',
			'label'       => __( 'FSMS Search Form Text', 'full-screen-morphing-search' ),
			'description' => esc_attr__( 'Change the search form text. If leaved blank, it will return to original value !', 'full-screen-morphing-search' ),
			'section'     => 'fsmsp_search_form',
			'default'     => '',
			'transport'   => 'postMessage',
			'js_vars'     => array(
				array(
					'element'  => 'input.morphsearch-input.ui-autocomplete-input',
					'function' => 'html',
					'attr'     => 'placeholder',
				),
			),
		)
	);
	// Add Icons Section.
	Kirki::add_section(
		'fsmsp_icons',
		array(
			'title'    => __( 'FSMS Icons', 'full-screen-morphing-search' ),
			'priority' => 15,
			'panel'    => 'fsmsp_panel',
		)
	);
	/**
	 * Function to display an uploaded image to the media library.
	 * 1- Retrive the images' URL, here by the option.
	 * 2- Convert the attachment URL into a post ID. @see https://developer.wordpress.org/reference/functions/attachment_url_to_postid/
	 * 3- Choose applied classes depending on the classes option.
	 * 4- Display the image with some parameters. @see https://developer.wordpress.org/reference/functions/wp_get_attachment_image/
	 * 5- Set this function as a render_callback in the partial_refersh module of the option.
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
	// FSMS Article Icon.
	Kirki::add_field(
		'fsmsp_kirki',
		array(
			'type'            => 'image',
			'settings'        => 'fsmsp_article_icon',
			'label'           => __( 'FSMS Article Icon', 'full-screen-morphing-search' ),
			'description'     => esc_attr__( 'Change the article icon.', 'full-screen-morphing-search' ),
			'section'         => 'fsmsp_icons',
			'default'         => '',
			'partial_refresh' => array(
				'fsmsp_article_icon' => array(
					'selector'        => 'div.dummy-media-object a.fsmsp-article-link',
					'render_callback' => 'full_screen_morphing_search_article_icon',
				),
			),
		)
	);
	// FSMS Article Icon/Image Classes.
	Kirki::add_field(
		'fsmsp_kirki',
		array(
			'type'            => 'checkbox',
			'settings'        => 'fsmsp_article_i_classes',
			'label'           => __( 'Article Icon/Image Round or Not ?!', 'full-screen-morphing-search' ),
			'section'         => 'fsmsp_icons',
			'default'         => true,
			'partial_refresh' => array(
				'fsmsp_article_i_classes' => array(
					'selector'        => 'div.dummy-media-object a.fsmsp-article-link',
					'render_callback' => 'full_screen_morphing_search_article_icon',
				),
			),
		)
	);

	/**
	 * Function to display an uploaded image to the media library.
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
	// FSMS Category Icon.
	Kirki::add_field(
		'fsmsp_kirki',
		array(
			'type'            => 'image',
			'settings'        => 'fsmsp_category_icon',
			'label'           => __( 'FSMS Category Icon', 'full-screen-morphing-search' ),
			'description'     => esc_attr__( 'Change the category icon.', 'full-screen-morphing-search' ),
			'section'         => 'fsmsp_icons',
			'default'         => '',
			'partial_refresh' => array(
				'fsmsp_category_icon' => array(
					'selector'        => 'span.fsmsp-category-image',
					'render_callback' => 'full_screen_morphing_search_category_icon',
				),
			),
		)
	);
	// FSMS Category Icon/Image Classes.
	Kirki::add_field(
		'fsmsp_kirki',
		array(
			'type'            => 'checkbox',
			'settings'        => 'fsmsp_category_i_classes',
			'label'           => __( 'Category Icon/Image Round or Not ?!', 'full-screen-morphing-search' ),
			'section'         => 'fsmsp_icons',
			'default'         => true,
			'partial_refresh' => array(
				'fsmsp_category_i_classes' => array(
					'selector'        => 'span.fsmsp-category-image',
					'render_callback' => 'full_screen_morphing_search_category_icon',
				),
			),
		)
	);

	/**
	 * Function to display an uploaded image to the media library.
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
	// FSMS Tag Icon.
	Kirki::add_field(
		'fsmsp_kirki',
		array(
			'type'            => 'image',
			'settings'        => 'fsmsp_tag_icon',
			'label'           => __( 'FSMS Tag Icon', 'full-screen-morphing-search' ),
			'description'     => esc_attr__( 'Change the tag icon.', 'full-screen-morphing-search' ),
			'section'         => 'fsmsp_icons',
			'default'         => '',
			'partial_refresh' => array(
				'fsmsp_tag_icon' => array(
					'selector'        => 'span.fsmsp-tag-image',
					'render_callback' => 'full_screen_morphing_search_tag_icon',
				),
			),
		)
	);
	// FSMS Tag Icon/Image Classes.
	Kirki::add_field(
		'fsmsp_kirki',
		array(
			'type'            => 'checkbox',
			'settings'        => 'fsmsp_tag_i_classes',
			'label'           => __( 'Tag Icon/Image Round or Not ?!', 'full-screen-morphing-search' ),
			'section'         => 'fsmsp_icons',
			'default'         => true,
			'partial_refresh' => array(
				'fsmsp_tag_i_classes' => array(
					'selector'        => 'span.fsmsp-tag-image',
					'render_callback' => 'full_screen_morphing_search_tag_icon',
				),
			),
		)
	);

}
