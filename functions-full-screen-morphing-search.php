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
					'element'  => array(
						'#Layer_1 circle',
						'#Layer_1 line',
					),
					'property' => 'stroke',
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
}
