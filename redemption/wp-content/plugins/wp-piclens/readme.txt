=== WP PicLens ===
Contributors: The Cooliris Team
Donate link: none
Tags: immersive, slideshow, flash, photos, pictures, images, media, widget, sidebar, gallery, piclens, firefox
Requires at least: 2.1
Tested up to: 2.3.2
Stable tag: 1.0.5

Creates an immersive, full-screen slideshow presentation of photos and images in your blog.

== Description ==

The PicLens Plugin for WordPress makes it easy for you to provide your visitors with an immersive slideshow experience for rich media on your blog.  

Visitors simply click a "start slideshow" link you place in your blog entry, and a slick slideshow interface will instantly appear with your images. From there, visitors can play or pause your slideshow, or better yet delve into a full-screen experience that goes beyond the confines of the browser window.

Optionally, you can also enable our sidebar widget to display a mini slideshow of images from throughout your blog.

== Installation ==

Requires:

- WordPress v2.1+ (Plugin only)

- WordPress v2.3.1+ (Plugin & Widget)

- PHP version 5

1. Verify your website's php installation has libxml support.
2. Upload the `wp-piclens` folder to the `/wp-content/plugins/` directory.
3. Activate one or both of the plugins through the 'Plugins' menu in WordPress.
4. Set your options in the 'Options->PicLens' menu in WordPress.
5. Setup the PicLens Slideshow Widget in 'Presentation->Widgets' menu in WordPress.

== Frequently Asked Questions == 

= What is the difference between the plugin and the widget? =

The PicLens plugin lets you create immersive slideshows to appear within any blog entry, using images from any server. The PicLens widget, on the other hand, creates a mini display in your sidebar, and loops images from your entire blog.

= What do my site visitors need to do to enjoy my immersive slideshows? =

It's as easy as clicking a "start slideshow" button you place into your blog. To enjoy the full features of your presentation, your visitors must have Adobe Flash Player v.9.0.28 or higher, or our free PicLens browser add-on.

= Can I use the PicLens plugin and widget on a blog hosted at WordPress.com, i.e. myblog.wordpress.com? =

Not yet, since blogs hosted on WordPress.com do not support plugins. Our plugin and widget work only on WordPress blogs hosted on your own domain and server at this time. You will need to have WordPress v2.1+ to use the plugin, and 2.3.1+ if you want both the plugin and widget.

= Can I add audio or video? =

Currently, audio and video works only on PicLens Lite installed on websites. The audio on/off button on the PicLens Lite console is not yet functional with this plugin.

= Why does WP PicLens require at least PHP verison 5? =

PHP 5 supports libxml functions which the plugin uses to create the Media RSS feed. PHP 4 at the time of writing this plugin has reached its end of life and will no longer be supported by the PHP development team.

= I got a Fatal PHP error when I activated the plugin, how do I fix it? =

Make sure you are using php version 5, to remove the plugin, simply delete the wp-piclens folder.

== Screenshots ==

1. PicLens Lite screenshot
2. Blog with sidebar widget
3. PicLens Plug-In options

== Changelog ==

Changes in 1.0.5:

Fixed a bug that would show if you have an empty Flickr RSS Feed.

New features added in 1.0.4:

* The widget now has the ability to add a Flickr.com RSS Feed to the list of slideshow images.
* The widget serves as a visual table of contents, clicking on the slideshow image brings you to the page with the image.
* The Media RSS Feed now has attribution tags and proper title tags.
* PicLens Lite displays the title and attribution from the MRSS Feed now.
* widget timer changed to default to 4 seconds.
* some general code cleanup was done.