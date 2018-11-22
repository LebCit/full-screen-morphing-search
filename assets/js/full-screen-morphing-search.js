// When the document is ready...
jQuery(document).ready(function ($) {

    // Display the Full Screen search when The user focuses on a search field
    $('form[role=search] input').on('focus', function (event) {
        // Prevent the default action
        event.preventDefault();

        // Display the Morphing Search Page
        $('.morphsearch').addClass('open');

        // Focus on the Morphing Search Input Field
        $('.morphsearch input.morphsearch-input').focus();
    });

    // Hide the Morphing Search Page when the user clicks the close span
    $('.morphsearch span.morphsearch-close').on('click', function (event) {
        // Prevent the default event
        event.preventDefault();

        // Hide the Morphing Search Page
        $('.morphsearch').removeClass('open');
    });

    // Hide the Morphing Search Page when the user press on the Escape key
    $('.morphsearch').on('keydown', function (event) {
        if (event.keyCode === 27) {
            $('.morphsearch').removeClass('open');
        }
    });

    // Reset Morphing Search Input Value to Search...    
    $('input.search-field').val('');
});