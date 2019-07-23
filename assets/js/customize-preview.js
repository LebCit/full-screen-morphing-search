/**
 * File customize-preview.js.
 *
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */

( function( $ ) {

	// FSMS Main Backgroung Color.
	wp.customize( 'fsmsp_options[fsmsp_main_backgroung_color]', function( value ) {
		value.bind( function( newval ) {
			$( '#morphsearch, div.morphsearch-content' ).css( 'background-color', newval );
		} );
	} );

	// FSMS Close Color.
	wp.customize( 'fsmsp_options[fsmsp_close_icon_color]', function( value ) {
		value.bind( function( newval ) {
			document.querySelectorAll( 'span.morphsearch-close' )[0].style.setProperty( "--morphsearch-close-background", newval );
			/**
			 * @see https://stackoverflow.com/a/49618941/6837428
			 */
		} );
	} );

	// FSMS Search... Color.
	wp.customize( 'fsmsp_options[fsmsp_search_text_color]', function( value ) {
		value.bind( function( newval ) {
			document.querySelectorAll( 'input.morphsearch-input' )[0].style.setProperty( "--morphsearch-input-placeholder", newval );
		} );
	} );

	// FSMS Input Text Color.
	wp.customize( 'fsmsp_options[fsmsp_input_text_color]', function( value ) {
		value.bind( function( newval ) {
			$( '#morphsearch .morphsearch-input' ).css( 'color', newval );
		} );
	} );

	// FSMS Magnifier Submit Color.
	wp.customize( 'fsmsp_options[fsmsp_magnifier_submit_color]', function( value ) {
		value.bind( function( newval ) {
			$( '#Capa_1 path' ).css( 'fill', newval );
		} );
	} );

	// FSMS Headings Color.
	wp.customize( 'fsmsp_options[fsmsp_headings_color]', function( value ) {
		value.bind( function( newval ) {
			$( 'div.dummy-column h2' ).css( 'color', newval );
		} );
	} );

	// FSMS Columns Background Color.
	wp.customize( 'fsmsp_options[fsmsp_columns_background_color]', function( value ) {
		value.bind( function( newval ) {
			// Repeat the CSS logic in PHP : background !
			$( 'div.dummy-media-object' ).css( 'background', newval );
			// Repeat the JS logic in PHP : onmouseout !
			$( 'div.dummy-media-object' ).mouseout( function() {
				$(this).css( 'background', newval );
			});
		} );
	} );

	// FSMS Columns Hover Background Color.
	wp.customize( 'fsmsp_options[fsmsp_columns_hover_background_color]', function( value ) {
		value.bind( function( newval ) {
			// Repeat the JS logic in PHP : onmouseover !
			$( 'div.dummy-media-object' ).mouseover( function() {
				$(this).css( 'background', newval );
			});
		} );
	} );

	// FSMS Links Color.
	wp.customize( 'fsmsp_options[fsmsp_links_color]', function( value ) {
		value.bind( function( newval ) {
			// Repeat the CSS logic in PHP : color !
			$( '.dummy-media-object h3 a' ).css( 'color', newval );
			// Repeat the JS logic in PHP : onmouseout !
			$( '.dummy-media-object h3 a' ).mouseout( function() {
				$(this).css( 'color', newval );
			});
		} );
	} );

	// FSMS Links Hover Color.
	wp.customize( 'fsmsp_options[fsmsp_links_hover_color]', function( value ) {
		value.bind( function( newval ) {
			// Repeat the JS logic in PHP : onmouseover !
			$( '.dummy-media-object h3 a' ).mouseover( function() {
				$(this).css( 'color', newval );
			});
		} );
	} );

} )( jQuery );