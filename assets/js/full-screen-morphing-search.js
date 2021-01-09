/**
 * Main JavaScript file.
 *
 * Handles the effect for any WordPress search input that morphs into a fullscreen overlay. Renders Customizer choices.
 *
 * @author LebCit.
 * @since  3.3
 */

'use strict';

// Target any search input containing any default [attribute=value] of get_search_form().
let searchInputs = document.querySelectorAll('input[type=search], input[class=search-field], input[name=s], input[id=s]');

// Display the Full Screen search when The user focuses on a search field.
const morphSearch = document.getElementById('morphsearch');
const morphSearchInputField = document.getElementById('morphsearch-input');
for (const searchInput of searchInputs) {
	searchInput.addEventListener('click', () => {
		morphSearch.classList.add('open');
		// Focus on the Full Screen Morphing Search Input Field.
		setTimeout(function () {
			morphSearchInputField.focus();
		}, 500);
	});
}

// Hide the Morphing Search Page when the user clicks the close span.
const morphSearchCloseSpan = document.querySelector('.morphsearch-close');
morphSearchCloseSpan.addEventListener('click', () => {
	for (const searchInput of searchInputs) {
		searchInput.blur();
	}
	morphSearch.classList.remove('open');
});

// Hide the Morphing Search Page when the user press on the Escape key.
morphSearch.addEventListener('keydown', function (event) {
	if (event.key === 'Escape') {
		for (const searchInput of searchInputs) {
			searchInput.blur();
		}
		morphSearch.classList.remove('open');
	}
});

let fsmspBackgrounds = document.querySelectorAll('#morphsearch, div.morphsearch-content'),
	fsmspHeadings = document.querySelectorAll('div.dummy-column h2'),
	fsmspColumns = document.querySelectorAll('div.dummy-media-object'),
	fsmspLinks = document.querySelectorAll('div.dummy-media-object h3 a');

// Output default options' values !
if (fsmsp_vars.fsmsp_options_does_not_exists) {

	// Output fsmsp_main_background_color.
	for (let fsmspBackground of fsmspBackgrounds) {
		fsmspBackground.style.backgroundColor = '#f1f1f1';
	}

	// Output fsmsp_close_icon_color.
	document.querySelector('span.morphsearch-close').style.setProperty("--morphsearch-close-background", '#000');

	// Output fsmsp_search_text_color.
	morphSearchInputField.style.setProperty("--morphsearch-input-placeholder", '#c2c2c2');

	// Output fsmsp_input_text_color.
	morphSearchInputField.style.color = '#ec5a62';

	// Output fsmsp_magnifier_submit_color.
	document.querySelector('#Capa_1 path').setAttribute('fill', '#ddd');

	// Output fsmsp_headings_color.
	for (let fsmspHeading of fsmspHeadings) {
		fsmspHeading.style.color = '#c2c2c2';
	}

	for (let fsmspColumn of fsmspColumns) {

		// Output fsmsp_columns_background_color.
		fsmspColumn.style.background = '#ebebeb';

		fsmspColumn.addEventListener("mouseover", function () {
			// Output fsmsp_columns_hover_background_color.
			this.style.background = '#e4e4e5';
			// Output fsmsp_links_hover_color.
			this.lastElementChild.firstElementChild.style.color = '#ec5a62';
		});

		fsmspColumn.addEventListener("mouseout", function () {
			this.style.background = '#ebebeb';
			// Output fsmsp_links_color.
			this.lastElementChild.firstElementChild.style.color = '#b2b2b2';
		});
	}

	// Output fsmsp_links_color.
	for (let fsmspLink of fsmspLinks) {
		fsmspLink.style.color = '#b2b2b2';
	}

	// Output fsmsp_search_form_text.
	morphSearchInputField.placeholder = 'Search...';


} else {

	for (let fsmspBackground of fsmspBackgrounds) {
		fsmspBackground.style.backgroundColor = fsmsp_vars.fsmsp_main_background_color;
	}

	document.querySelector('span.morphsearch-close').style.setProperty("--morphsearch-close-background", fsmsp_vars.fsmsp_close_icon_color);

	morphSearchInputField.style.setProperty("--morphsearch-input-placeholder", fsmsp_vars.fsmsp_search_text_color);

	morphSearchInputField.style.color = fsmsp_vars.fsmsp_input_text_color;

	document.querySelector('#Capa_1 path').setAttribute('fill', fsmsp_vars.fsmsp_magnifier_submit_color);

	for (let fsmspHeading of fsmspHeadings) {
		fsmspHeading.style.color = fsmsp_vars.fsmsp_headings_color;
	}

	for (let fsmspColumn of fsmspColumns) {

		fsmspColumn.style.background = fsmsp_vars.fsmsp_columns_background_color;

		fsmspColumn.addEventListener("mouseover", function () {
			this.style.background = fsmsp_vars.fsmsp_columns_hover_background_color;
			this.lastElementChild.firstElementChild.style.color = fsmsp_vars.fsmsp_links_hover_color;
		});

		fsmspColumn.addEventListener("mouseout", function () {
			this.style.background = fsmsp_vars.fsmsp_columns_background_color;
			this.lastElementChild.firstElementChild.style.color = fsmsp_vars.fsmsp_links_color
		});
	}

	for (let fsmspLink of fsmspLinks) {
		fsmspLink.style.color = fsmsp_vars.fsmsp_links_color;
	}

	morphSearchInputField.placeholder = fsmsp_vars.fsmsp_search_form_text;

}