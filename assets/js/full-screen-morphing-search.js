// When the document is ready...
( function( $ ) {

	// Target any search input containing any default [attribute=value] of get_search_form().
	let $searchInput = $( 'form' ).find( 'input, button' ).filter( '[type=search], [class=search-field], [name=s], [id=s], [type=submit]' );

	// Display the Full Screen search when The user focuses on a search field.
	$searchInput.on( 'focus', function( event ) {
		// Prevent the default action.
		event.preventDefault();

		// Display the Morphing Search Page.
		$( '.morphsearch' ).addClass( 'open' );

		/**
		 * 1- Focus on the Full Screen Morphing Search Input Field, but not if the site is being previewed in the Customizer.
		 * This first decision was taken because of weird behaviour in Chrome and Edge...
		 * 2- Focusing on the input of Full Screen Morphing Search Input Field by a setTimeout() to avoid a recursive function. 
		 * The main function is called upon 'focus' on any $searchInput,
		 * so if we focus directly on the .morphsearch-input it will be a recursive function
		 * since the two inputs are in a $searchInput !
		 * Recursive function :@see https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Errors/Too_much_recursion
		 * 
		 * The Customizer preview part is handled by a MutationObserver in customize-preview.js !
		 * 
		 */
		if (!fsmsp_vars.fsmsp_is_customize_preview) {
			setTimeout( function() {
				$( '#morphsearch > form > input.morphsearch-input' ).focus();
			}, 500);
		}
	} );

	// Hide the Morphing Search Page when the user clicks the close span.
	$( '.morphsearch span.morphsearch-close' ).on( 'click', function( event ) {
		// Prevent the default event
		event.preventDefault();

		// Hide the Morphing Search Page.
		$searchInput.blur();
		$( '.morphsearch' ).removeClass( 'open' );
	} );

	/**
	 * Hide the Morphing Search Page when the user press on the Escape key.
	 * 
	 * Since outside the Customizer preview (on live site) the input is focus(),
	 * when we press the Esc button .morphsearch will close then reopen.
	 * Since it's focus(), pressing on Esc will close it but send another focus() after 500ms !
	 * To prevent this behaviour when the Esc button is pressed,
	 * we blur() all $searchInput including $('.morphsearch input.morphsearch-input'),
	 * then we removeClass('open') from $('.morphsearch').
	 * 
	 */
	$( '.morphsearch' ).on( 'keydown' , function( event ) {
		if ( event.keyCode === 27 && !fsmsp_vars.fsmsp_is_customize_preview ) {
			$searchInput.blur();
			$( '.morphsearch' ).removeClass( 'open' );
		}
	});

	// Clear Search Input Value
	$( 'input' ).filter( '[name=s]' ).val('');

	// Output default options' values !
	if ( fsmsp_vars.fsmsp_options_does_not_exists ) {

		// Output fsmsp_main_background_color.
		$( '#morphsearch, div.morphsearch-content' ).css( 'background-color', '#f1f1f1' );

		// Output fsmsp_close_icon_color.
		document.querySelectorAll( 'span.morphsearch-close' )[0].style.setProperty( "--morphsearch-close-background", '#000' );

		// Output fsmsp_search_text_color.
		document.querySelectorAll( 'input.morphsearch-input' )[0].style.setProperty( "--morphsearch-input-placeholder", '#c2c2c2' );

		// Output fsmsp_input_text_color.
		$( '#morphsearch .morphsearch-input' ).css( 'color', '#ec5a62' );

		// Output fsmsp_magnifier_submit_color.
		$( '#Capa_1 path' ).css( 'fill', '#ddd' );

		// Output fsmsp_headings_color.
		$( 'div.dummy-column h2' ).css( 'color', '#c2c2c2' );

		// Output fsmsp_columns_background_color.
		$( 'div.dummy-media-object' ).css( 'background', '#ebebeb' );
		$( 'div.dummy-media-object' ).mouseout( function() {
			$(this).css( 'background', '#ebebeb' );
			// Output fsmsp_links_color.
			$(this).find( 'h3 a' ).css( 'color', '#b2b2b2' );
		});

		// Output fsmsp_columns_hover_background_color.
		$( 'div.dummy-media-object' ).mouseover( function() {
			$(this).css( 'background', '#e4e4e5' );
			// Output fsmsp_links_hover_color.
			$(this).find( 'h3 a' ).css( 'color', '#ec5a62' );
		});

		// Output fsmsp_links_color.
		$( '.dummy-media-object h3 a' ).css( 'color', '#b2b2b2' );

		// Output fsmsp_search_form_text.
		$( 'form.morphsearch-form' ).children().first().attr( 'placeholder', 'Search...' );

	} else {

		$( '#morphsearch, div.morphsearch-content' ).css( 'background-color', fsmsp_vars.fsmsp_main_background_color );

		document.querySelectorAll( 'span.morphsearch-close' )[0].style.setProperty( "--morphsearch-close-background", fsmsp_vars.fsmsp_close_icon_color );

		document.querySelectorAll( 'input.morphsearch-input' )[0].style.setProperty( "--morphsearch-input-placeholder", fsmsp_vars.fsmsp_search_text_color );

		$( '#morphsearch .morphsearch-input' ).css( 'color', fsmsp_vars.fsmsp_input_text_color );

		$( '#Capa_1 path' ).css( 'fill', fsmsp_vars.fsmsp_magnifier_submit_color );

		$( 'div.dummy-column h2' ).css( 'color', fsmsp_vars.fsmsp_headings_color );

		$( 'div.dummy-media-object' ).css( 'background', fsmsp_vars.fsmsp_columns_background_color );
		$( 'div.dummy-media-object' ).mouseout( function() {
			$(this).css( 'background', fsmsp_vars.fsmsp_columns_background_color );
			$(this).find( 'h3 a' ).css( 'color', fsmsp_vars.fsmsp_links_color );
		});

		$( 'div.dummy-media-object' ).mouseover( function() {
			$(this).css( 'background', fsmsp_vars.fsmsp_columns_hover_background_color );
			$(this).find( 'h3 a' ).css( 'color', fsmsp_vars.fsmsp_links_hover_color );
		});

		$( '.dummy-media-object h3 a' ).css( 'color', fsmsp_vars.fsmsp_links_color );

		$( 'form.morphsearch-form' ).children().first().attr( 'placeholder', fsmsp_vars.fsmsp_search_form_text );

	}

} )( jQuery );