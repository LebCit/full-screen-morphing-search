/**
 * File customize-preview.js.
 *
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */

( function( $ ) {

	// FSMS Main Background Color.
	wp.customize( 'fsmsp_options[fsmsp_main_background_color]', function( value ) {
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
			$( 'div.dummy-media-object' ).css( 'background', newval );
			$( 'div.dummy-media-object' ).mouseout( function() {
				$(this).css( 'background', newval );
			} );
		} );
	} );

	// FSMS Columns Hover Background Color.
	wp.customize( 'fsmsp_options[fsmsp_columns_hover_background_color]', function( value ) {
		value.bind( function( newval ) {
			$( 'div.dummy-media-object' ).mouseover( function() {
				$(this).css( 'background', newval );
			} );
		} );
	} );

	// FSMS Links Color.
	wp.customize( 'fsmsp_options[fsmsp_links_color]', function( value ) {
		value.bind( function( newval ) {
			$( '.dummy-media-object h3 a' ).css( 'color', newval );
			$( 'div.dummy-media-object' ).mouseout( function() {
				$(this).find( 'h3 a' ).css( 'color', newval );
			} );
		} );
	} );

	// FSMS Links Hover Color.
	wp.customize( 'fsmsp_options[fsmsp_links_hover_color]', function( value ) {
		value.bind( function( newval ) {
			$( 'div.dummy-media-object' ).mouseover( function() {
				$(this).find( 'h3 a' ).css( 'color', newval );
			} );
		} );
	} );

	// FSMS Search Form Text.
	wp.customize( 'fsmsp_options[fsmsp_search_form_text]', function( value ) {
		value.bind( function( newval ) {
			$( 'input.morphsearch-input' ).attr( 'placeholder', newval );
		} );
	} );

	/**
	 * MutationObserver to display the default placeholder text (search...),
	 * when the user erases all characters of his text in the FSMS Search Form Text option.
	 */
	let targetNodePhTxt = $( "input.morphsearch-input" )[0]; // Get the Node element.
	let observerPhTxt = new MutationObserver( callbackPhTxt );
	let obsConfigPhTxt = { attributes: true };
	observerPhTxt.observe( targetNodePhTxt, obsConfigPhTxt );
	function callbackPhTxt(mutations) {
		mutations.forEach( function( mutation ) {
			if ( mutation.target.placeholder.length == 0 ) {
				$( '.morphsearch-form .morphsearch-input' ).attr( 'placeholder', fsmsp_cp.fsmsp_placeholder_text );
			}
		} );
	}

	/**
	 * MutationObserver to prevent weird behaviour in Chrome and Edge, when input of text control option is clicked/focused.
	 * Not needed but added to reflect same behaviour as on the live site (not Customizer preview).
	 * When the overlay comes out, focus() on .morphsearch-input, then close it if we press on the Esc button.
	 */
	let targetNode = $( '#morphsearch' )[0]; // Get the Node element.
	let observerNode = new MutationObserver( mutationNodeCallback );
	let obsNodeConfig = { attributes: true };
	observerNode.observe( targetNode, obsNodeConfig );
	function mutationNodeCallback( mutations ) {
		mutations.forEach( function( mutation ) {
			if ( 'attributes' === mutation.type ) {
				// This focus() will affect every input in a form[role=search] !
				$( '.morphsearch-input' ).focus();
				$( '.morphsearch' ).on( 'keydown', function( event ) {
					if (event.keyCode === 27) {
						// Remove the focus() first with blur() on every form[role=search] input !
						$( 'form[role=search] input' ).blur();
						// Close the overlay : $( '.morphsearch-close' ).click();
						$( '.morphsearch' ).removeClass( 'open' );
					}
				} );
			}
		} );
	}

	/**
	 * Following MutationObserver are to display the default icon for each column when no Icon/Image is provided.
	 * This will take effect when the Remove button is clicked while in the Customizer preview.
	 */

	// 1- MutationObserver for article icon.
	let targetObjArt = $( '.fsmsp-article-link' ); // Get the Object element NOT the Node.
	let observerObjArt = new MutationObserver( callbackArt );
	let obsConfigArt = { childList: true };
	targetObjArt.each( function() {
		/**
		 * Using .each( function() { } ); since we have more than one object element matching our request.
		 */
		observerObjArt.observe( this, obsConfigArt );
	} );
	function callbackArt( mutationList ) {
		mutationList.forEach( function( mutation ) {
			if ( mutation.type == 'childList' ) {
				/**
				 * When <span class="customize-partial-edit-shortcut customize-partial-edit-shortcut-fsmsp_article_icon">
				 * is the only child left (this is when we click on the remove button after adding a chosen image/icon),
				 * we append the default article icon (fsmsp_cp.fsmsp_article_icon) to the targetObjArt.
				 */
				if ( mutation.target.childNodes.length == 1 ) {
					targetObjArt.append( fsmsp_cp.fsmsp_article_icon );
				}
			}
		} );
	}
	// 2- MutationObserver for category icon.
	var targetObjCat = $( '.fsmsp-category-image' ); // Get the Object element NOT the Node.
	var observerCat = new MutationObserver(callbackCategory);
	var obsConfigCat = { childList: true };
	targetObjCat.each( function() {
		observerCat.observe(this, obsConfigCat);
	} );
	function callbackCategory( mutationList ) {
		mutationList.forEach( function( mutation ) {
			if ( mutation.type == 'childList' ) {
				if ( mutation.target.childNodes.length == 1 ) {
					targetObjCat.append( fsmsp_cp.fsmsp_category_icon );
				}
			}
		} );
	}
	// 3- MutationObserver for tag icon.
	var targetObjTag = $( '.fsmsp-tag-image' ); // Get the Object element NOT the Node.
	var observerTag = new MutationObserver(callbackTag);
	var obsConfigTag = { childList: true };
	targetObjTag.each( function() {
		observerTag.observe(this, obsConfigTag);
	} );
	function callbackTag( mutationList ) {
		mutationList.forEach( function( mutation ) {
			if ( mutation.type == 'childList' ) {
				if ( mutation.target.childNodes.length == 1 ) {
					targetObjTag.append( fsmsp_cp.fsmsp_tag_icon );
				}
			}
		} );
	}

} )( jQuery );