/**
 * File customize-preview.js.
 *
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */

jQuery(document).ready(function ($) {

	/**
	 * Following MutationObserver are to display the default icon for each column when no Icon/Image is provided.
	 * This will take effect when the Remove button is clicked while in the Customizer preview.
	 */

	// MutationObserver for article icon.
	var targetNode = $(".fsmsp-article-link");
	var observer = new MutationObserver(callback);
	var obsConfig = { childList: true };
	targetNode.each(function () {
		observer.observe(this, obsConfig);
	});
	function callback(mutationList) {
		mutationList.forEach(function (mutation) {
			if (mutation.type == 'childList') {
				/**
				 * When <span class="customize-partial-edit-shortcut customize-partial-edit-shortcut-fsmsp_article_icon">
				 * is the only child left (this is when we click on the remove button after adding a chosen image/icon),
				 * we append the default article icon (fsmsp_cp.fsmsp_article_icon) to the targetNode.
				 */
				if (mutation.target.childNodes.length == 1) {
					targetNode.append(fsmsp_cp.fsmsp_article_icon);
				}
			}
		});
	}
	// MutationObserver for category icon.
	var targetNodeCat = $(".fsmsp-category-image");
	var observerCat = new MutationObserver(callbackCategory);
	var obsConfigCat = { childList: true };
	targetNodeCat.each(function () {
		observerCat.observe(this, obsConfigCat);
	});
	function callbackCategory(mutationList) {
		mutationList.forEach(function (mutation) {
			if (mutation.type == 'childList') {
				var $length = targetNodeCat.children().length;
				if ($length == 5) {
					targetNodeCat.append(fsmsp_cp.fsmsp_category_icon);
				}
			}
		});
	}
	// MutationObserver for tag icon.
	var targetNodeTag = $(".fsmsp-tag-image");
	var observerTag = new MutationObserver(callbackTag);
	var obsConfigTag = { childList: true };
	targetNodeTag.each(function () {
		observerTag.observe(this, obsConfigTag);
	});
	function callbackTag(mutationList) {
		mutationList.forEach(function (mutation) {
			if (mutation.type == 'childList') {
				var $length = targetNodeTag.children().length;
				if ($length == 5) {
					targetNodeTag.append(fsmsp_cp.fsmsp_tag_icon);
				}
			}
		});
	}

	/**
	 * Following MutationObserver are to display the default placeholder text (search...),
	 * if the user choose to display another placeholder text, then remove completely his chosen text.
	 * This will happen when the user erase all charachters of his text in the FSMS Search Form Text option.
	 */

	// MutationObserver for placeholder text.
	var targetNodePhT = $("input.morphsearch-input");
	var observerPhT = new MutationObserver(callbackPhT);
	var obsConfigPht = { attributes: true };
	targetNodePhT.each(function () {
		observerPhT.observe(this, obsConfigPht);
	});
	function callbackPhT(mutations) {
		mutations.forEach(function (mutation) {
			if (mutation.type == 'attributes') {
				var entry = {
					mutation: mutation,
					el: mutation.target,
					value: mutation.target.placeholder.length,
				};
			}
			if (entry.value == 0) {
				$('.morphsearch-form .morphsearch-input').attr('placeholder', fsmsp_cp.fsmsp_placeholder_text);
			}
		});
	}

	/**
	 * Following MutationObserver are to prevent weird behaviour in Chrome and Edge,
	 * when we focus on the input of the text control option to change the placeholder text.
	 * It's not needed but was added to reflect the same behaviour as on the live site (not Customizer preview),
	 * in order to focus() on the .morphsearch-input when the overlay comes out, then close it if we press on the Esc button.
	 */

	// MutationObserver for input focus.
	var targetObj = $("#morphsearch");
	var observerObject = new MutationObserver(mutationObjectCallback);
	var obsConfig = { attributes: true };
	targetObj.each(function () {
		observerObject.observe(this, obsConfig);
	});
	function mutationObjectCallback(mutationRecordsList) {
		mutationRecordsList.forEach(function(mutationRecord) {
		if ("attributes" === mutationRecord.type) {
			// This focus() will affect every input in a form[role=search] !
			$('.morphsearch-input').focus();
			$('.morphsearch').on('keydown', function (event) {
				if (event.keyCode === 27) {
					// Remove the focus() first with blur() on every form[role=search] input !
					$('form[role=search] input').blur();
					/**
					 * Now, we can call the desired method to close the overlay.
					 * We could have done the following :
					 * $('.morphsearch-close').click();
					 */
					$('.morphsearch').removeClass('open');
				}
			});
		}
		});
	}

});