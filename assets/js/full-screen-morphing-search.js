// When the document is ready...
( function( $ ) {

	// Display the Full Screen search when The user focuses on a search field.
	$( 'form[role=search] input' ).on( 'focus', function( event ) {
		// Prevent the default action.
		event.preventDefault();

		// Display the Morphing Search Page.
		$( '.morphsearch' ).addClass( 'open' );

		/**
		 * 1- Focus on the Full Screen Morphing Search Input Field, but not if the site is being previewed in the Customizer.
		 * This first decision was taken because of weird behaviour in Chrome and Edge...
		 * 2- Focusing on the input of Full Screen Morphing Search Input Field by a setTimeout() to avoid a recursive function. 
		 * The main function is called upon 'focus' on any $('form[role=search] input'),
		 * so if we focus directly on the .morphsearch-input it will be a recursive function
		 * since the two inputs are in a 'form[role=search]' !
		 * Recursive function :@see https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Errors/Too_much_recursion
		 * 
		 * The Customizer preview part is handled by a MutationObserver in customize-preview.js !
		 * 
		 */
		if (!fsmsp_vars.fsmsp_is_customize_preview) {
			setTimeout(function () {
				$('.morphsearch input.morphsearch-input').focus();
			}, 500);
		}
	} );

	// Hide the Morphing Search Page when the user clicks the close span.
	$( '.morphsearch span.morphsearch-close' ).on( 'click', function( event ) {
		// Prevent the default event
		event.preventDefault();

		// Hide the Morphing Search Page.
		$( '.morphsearch' ).removeClass( 'open' );
	} );

	/**
	 * Hide the Morphing Search Page when the user press on the Escape key.
	 * 
	 * Since outside the Customizer preview (on live site) the input is focus(),
	 * when we press the Esc button .morphsearch will close then reopen.
	 * Since it's focus(), pressing on Esc will close it but send another focus() after 500ms !
	 * To prevent this behaviour when the Esc button is pressed,
	 * we blur() all $('form[role=search] input') including $('.morphsearch input.morphsearch-input'),
	 * then we removeClass('open') from $('.morphsearch').
	 * 
	 */
	$('.morphsearch').on('keydown', function (event) {
		if (event.keyCode === 27 && !fsmsp_vars.fsmsp_is_customize_preview) {
			$('form[role=search] input').blur();
			$('.morphsearch').removeClass('open');
		}
	});

	// Reset Morphing Search Input Value to Search...
	$('input.search-field').val('');

	console.info( fsmsp_vars.fsmsp_options_does_not_exists );
	if ( fsmsp_vars.fsmsp_options_does_not_exists ) {
		console.log( 'I do not exist' );
		$( '#morphsearch, div.morphsearch-content' ).css( 'background-color', '#f1f1f1' );

	} else {
		console.log( 'Here I am' );
		$( '#morphsearch, div.morphsearch-content' ).css( 'background-color', fsmsp_vars.fsmsp_main_backgroung_color );
	}

} )( jQuery );