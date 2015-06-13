=== Wordpress Picture Element ===
Contributors: eclev91
Tags: thumbnails
Requires at least: 4.0
Tested up to: 4.2.2
Stable tag: 4.2.2
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Get a picture element instead of an image tag for responsive images on your WordPress site.

== Description ==

This plugin introduces a couple of nifty functions to replace `the_post_thumbnail()` & `get_the_post_thumbnail()` in exchange for the responsive `picture` element. Use `get_the_post_picture($fallback_image_size, array($breakpoint_1=>$image_size_1, $breakpoint_2=>$image_size_2[, $id]);`

For example:

```<?php echo get_the_post_picture('single-featured-sm', array('(min-width:768px)'=>'single-featured-md', '(min-width:992px)'=>'single-featured-lg', '(min-width:1200px)'=>'single-featured')); ?>```

== Installation ==

Install via the WordPress Plugin directory

== Frequently Asked Questions ==

= What? =

`the_post_picture()` and `get_the_post_picture()`. See the description for an example.

= Why? =

This is really a bigger question than the scope of this plugin, but [see here](http://code.tutsplus.com/tutorials/better-responsive-images-with-the-picture-element--net-36583).

= Does the order of my sizes array matter? =

Yup. Pass them smallest image to largest.

= Browser Support? =

The plugin includes [PictureFill.js](http://scottjehl.github.io/picturefill/). This should polyfill most browsers. If you have an issue, please report it!

= Can I use my custom image sizes? =

Yessir.

= Can I contribute? =

PRs are welcome! [See GitHub.](https://github.com/ethanclevenger91/fill-murray-thumbnails)


== Screenshots ==


== Changelog ==

= 1.0 =
* Initial launch!