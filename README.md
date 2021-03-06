# Full Screen Morphing Search 
Contributors: lebcit  
Tags: search, full screen search, morphing  search, search overlay,  autocomplete  
Requires at least: 4.1.0  
Tested up to: 5.6  
Requires PHP: 5.6  
Stable tag: 3.5  
License: GPLv2 or later  
License URI: https://spdx.org/licenses/GPL-2.0-or-later.html

Responsive Full Screen Morphing Search Page Overlay With Predictive Autocomplete !

## Description

**PLEASE, MAKE SURE TO HAVE AT LEAST ONE POST WITH ONE CATEGORY AND ONE TAG BEFORE ACTIVATING**  
Zipped : V2.7 -> 683Ko / V3.0 -> 33.6Ko !  
MUCH LIGHTER, but STRONGER than ever !

Effect for any WordPress search input that morphs into a fullscreen overlay.  
Enlarge the search input and show 5 most recent posts, 5 most used categories and tags with counter.  
Once a search input is clicked, the whole search element expands to a fullscreen overlay.  
The fullscreen overlay has a bigger search input.

There are no settings for this plugin. Simply activate it, click on any search input and see the magic happens !

In the Customizer, look for **FSMS Plugin**, design it as you want !  
You can change colors, search placeholder's text and default icons with a styling option !  

Don't forget to take a look at the <a href="https://wordpress.org/plugins/full-screen-morphing-search/faq/" title="Frequently Asked Questions">FAQ</a> Section.  
If you have some issues **don't hesitate**, head over to the <a href="https://wordpress.org/support/plugin/full-screen-morphing-search" title="Support">Support</a> Section !  
If you use this plugin, please consider leaving a <a href="https://wordpress.org/support/plugin/full-screen-morphing-search/reviews/" title="Reviews">Review</a> to give me a push forward ;)

## Installation

### How to install the plugin and get it working.

1. Install Full Screen Morphing Search plugin through the WordPress plugins screen directly.
2. Make sure to have at least one post with one category and one tag before activating.
3. Activate the plugin through the 'Plugins' screen in WordPress.
4. Navigate to your site and click on any search input and see the magic happens !
5. In the Customizer, look for **FSMS Plugin**, design it as you want !

## Frequently Asked Questions

### Recent posts thumbnails are not round !

Some of your images where added before this plugin.  
If your posts thumbnails are not round,  
you'll have to use, one time, a thumbnail regenerator.  
I recommend <a href="https://wordpress.org/plugins/regenerate-thumbnails/" title="Regenerate Thumbnails" target="_blank">Regenerate Thumbnails</a>.  
You can uninstall the thumbnail regenerator once the regeneration is done.

### The overlay is not covering the whole page !

If your theme has some boxed style(s), like Twenty Sixteen or Twenty Twelve,  
the overlay will only cover the inside box (the site content) !

### How to change the search input text color ?

First, you'll have to type something in the input,  
then choose the desired color.  
Take a look at the <a href="https://github.com/LebCit/full-screen-morphing-search#screenshots" title="Screenshots">Screenshots</a>.

### How to change the shape of **New Icon/Image** ?

First make sure that you have used a thumbnail regenerator, see first FAQ.  
Then, click on the checkbox option **Icon/Image Round or Not ?!**  
If the new Icon/Image is already round (like the default one of category and tag), this option will have no effect !

### Hitting Enter key doesn't fire a search !

**As long as** the autocompletition gives results as you type,  
the Enter key will only work on given results.  
If you wish to ignore given results and fire a search query,  
type your search then just click on the search icon.

### Autocomplete predicts only posts and pages !

Yes, just for now !  
I'll be adding some more cool functions with time.

## Screenshots

### Full Screen Morphing Search Plugin Screenshot
![Full Screen Morphing Search Plugin Screenshot](https://github.com/LebCit/fsms-screenshots/blob/master/screenshot-1.png "Full Screen Morphing Search Plugin Screenshot")
As you can see, their is a search form a close button and three columns.  
The first column shows the most 5 recent posts.  
The second column shows the top 5 used categories and how many posts each category has.  
The third column shows the top 5 used tags and how many posts each tag has.

### FSMS Plugin in the Customizer
![FSMS Plugin in the Customizer](https://github.com/LebCit/fsms-screenshots/blob/master/screenshot-2.png "FSMS Plugin in the Customizer")
FSMS Plugin in the Customizer.

### Posts with no Featured Image defined
![Posts with no Featured Image defined](https://github.com/LebCit/fsms-screenshots/blob/master/screenshot-3.png "Posts with no Featured Image defined")
Posts with no Featured Image defined.

### Change the default icons and choose to make the new Icon/Image Round or Not !
![Change the default icons](https://github.com/LebCit/fsms-screenshots/blob/master/screenshot-4.png "Change the default icons")
Change the default icons and choose to make the new Icon/Image Round or Not !

### First type something in the input text field, then change the input text color.
![Change the input text color](https://github.com/LebCit/fsms-screenshots/blob/master/screenshot-5.png "Change the input text color")
First type something in the input text field, then change the input text color.

### Old screenshot
![Old screenshot](https://github.com/LebCit/fsms-screenshots/blob/master/screenshot-6.png "Old screenshot")
Old screenshot.

## Changelog

### 3.5 =
* Updated readme file.

### 3.4 =
* Corrected file upload

### 3.3 =
* Add autoComplete.js to plugin.
* Force thumbnails size.
* Main JS file without jQuery only vanilla JS.
* Move .morphsearch-content below autocomplete `<ul>` tag.
* Removing jQuery dependencies.
* Tested up to version 5.6 of WordPress.

### 3.2 =
* Added empty value for $classes.
* Added important for .morphsearch-submit:hover
* Optimized search input target.
* Rectified background spelling.
* Removed echo on functions for security.
* Tested up to version 5.5.3 of WordPress.

### 3.1 =
* Optimized search input target.

### 3.0 =
* Plugin rewritten from ground up.

### 2.7 =
* Corrected Undefined Index 'fsmsp_search_form_text'.

### 2.6 =
* Corrected Undefined Index Error.
* Force Search Input height.
* Tested up to version 5.2.2 of WordPress.

### 2.5 =
* Tested up to version 5.2 of WordPress.
* Updated Kirki from 3.0.34.1 to 3.0.35.3

### 2.4 =
* Added full_screen_morphing_search_add_svg_tags( $svg_tags )
* Changed magnifier.svg
* Removed file_get_contents()

### 2.3 =
* Corrected Undefined Index Error.
* Removed Undefined Index Error from FAQ Section.

### 2.2 =
* Corrected MutationObserver for categories and tags icons.
* Updated readme FAQ section for Undefined index Error.

### 2.1 =
* Added ability to change icons from Customizer.
* Added ability to change input text color.
* Added italic font-style to input. 
* Changed placehoder's text behaviour on total remove.

### 2.0 =
* Plugin rewritten from ground up.

### 1.2.1 =
* Tested up to version 4.9.4 of WordPress.

### 1.2 =
* Added Predictive Autocomplete For Pages.
* Added Press Escape Key To Close Search Overlay. 

### 1.1 =
* Added Predictive Autocomplete For Posts.

### 1.0 =
* Initial release.

## Upgrade Notice

### 3.4 =
Actual stable plugin version.

## Resources

This plugin is created by <a href="http://tympanus.net/codrops/author/crnacura/" rel="author" title="Manoela Ilic" target="_blank">Manoela Ilic</a> and ported to WordPress by <a href="https://profiles.wordpress.org/lebcit/" rel="author" title="LebCit" target="_blank">LebCit</a>.  
If you want to learn more about this plugin, visit the <a href="http://tympanus.net/codrops/2014/11/04/simple-morphing-search/" title="Simple Morphing Search" target="_blank">Simple Morphing Search</a> original post.  
> A <a href="https://wordpress.org/plugins/full-screen-morphing-search/#screenshots" title="Screenshots">Picture</a> is worth a thousand words

I think that a demo is even better !  
See how <a href="http://tympanus.net/Development/MorphingSearch/" title="Full Screen Morphing Search" target="_blank">Full Screen Morphing Search</a> works.

The autocompletition implemented in this plugin is based on <a href="https://github.com/TarekRaafat/autoComplete.js" title="autoComplete.js" target="_blank">autoComplete.js</a> by <a href="https://github.com/TarekRaafat" title="Tarek Raafat" target="_blank">Tarek Raafat</a> under the <a href="https://opensource.org/licenses/Apache-2.0" title="Apache License, Version 2.0" target="_blank">Apache 2.0</a> License.

The main plugin icon is made by <a href="http://www.flaticon.com/authors/pixel-buddha" title="Pixel Buddha">Pixel Buddha</a> from <a href="http://www.flaticon.com" title="Flaticon">www.flaticon.com</a> and is licensed by <a href="http://creativecommons.org/licenses/by/3.0/" title="Creative Commons BY 3.0" target="_blank">CC 3.0 BY</a>  
The article icon is made by <a href="https://www.flaticon.com/authors/freepik" title="Freepik">Freepik</a> from <a href="http://www.flaticon.com" title="Flaticon">www.flaticon.com</a> and is licensed by <a href="http://creativecommons.org/licenses/by/3.0/" title="Creative Commons BY 3.0" target="_blank">CC 3.0 BY</a>  
The category icon is made by <a href="https://www.flaticon.com/authors/freepik" title="Freepik">Freepik</a> from <a href="http://www.flaticon.com" title="Flaticon">www.flaticon.com</a> and is licensed by <a href="http://creativecommons.org/licenses/by/3.0/" title="Creative Commons BY 3.0" target="_blank">CC 3.0 BY</a>  
The tag icon is made by <a href="https://www.flaticon.com/authors/freepik" title="Freepik">Freepik</a> from <a href="http://www.flaticon.com" title="Flaticon">www.flaticon.com</a> and is licensed by <a href="http://creativecommons.org/licenses/by/3.0/" title="Creative Commons BY 3.0" target="_blank">CC 3.0 BY</a>