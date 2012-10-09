=== Artiss YouTube Embed ===
Contributors: dartiss
Donate link: http://artiss.co.uk/donate
Tags: admin, annotations, artiss, automatic, editor, embed, embedding, embedplus, flash, flv, google, hd, height, iframe, manage, media, plugin, page, play, playlist, post, profile, sidebar, simple, smart, url, valid, video, widget, width, xhtml, youtube, youtuber
Requires at least: 2.9
Tested up to: 3.2.1
Stable tag: 2.3.1

A simple to use method of embedding YouTube videos into your posts and pages but with powerful features for those that need them.

== Description ==

Artiss YouTube Embed (formally YouTube Embed) is an incredibly simple, yet powerful, method of embedding YouTube videos into your WordPress site. Options include:

* XHTML and HTML5 compliant - works with all the latest browsers
* Multiple embedding methods available - OBJECT, IFRAME, CHROMELESS and EmbedPlus
* Allow users to add videos to comments
* Build your own playlists and play them back however you want
* Create multiple profiles - use them for different videos to get the exact style that you want
* Google compatible metadata is added to the video output - great for SEO!
* Code is cached for maximum performance
* Using a different YouTube plugin? Documentation and tools are provided to help you migrate to Artiss YouTube Embed
* And much, much more!

It has all the features of other similar plugins - Smart YouTube, for instance. In fact if there's a feature in another YouTube embedding plugin that this doesn't have, let me know - I haven't come across it!

To add a video to a post or page simply use the shortcode `[youtube]video[/youtube]`, where `video` is the ID or URL of the video. Alternatively, you can add one (or more) widgets to your sidebar.

Within the administration area of your blog you will find a new menu named `YouTube` (see screenshot 1). Click on the `Options` sub-menu to set a number of general options. Alternatively click on the `Profiles` sub-menu to set the default options which define the output of your videos - any videos you display (unless overridden by parameters - more on that later) will use the settings from the Profiles screen.

The above should get you started - for more information and advanced options please read the "Other Notes" tab. This also includes details on how to migrate from another embedding plugin to Artiss YouTube Embed.

Although this document contains a lot of information more is available from a series of linked pages, plus as much information as possible is provided on the various administration pages. Whilst on the administration pages, click on the "Help" button in the top right for some useful tips and links. If anything isn't covered and you're unsure of what it does please ask [on the forum](http://www.artiss.co.uk/forum "WordPress Plugins Forum").

Not yet convinced? [See the feature comparison](https://spreadsheets.google.com/spreadsheet/pub?hl=en_GB&hl=en_GB&key=0AqxzQNe7e-NwdF80eUZuNjdtS1J1bWM4VERFVUN6ZHc&single=true&gid=4&output=html "YouTube Embed : Comparison") between this and the top 10 alternative plugins for embedding YouTube videos.

**For help with this plugin, or simply to comment or get in touch, please read the appropriate section in "Other Notes" for details. This plugin, and all support, is supplied for free, but [donations](http://artiss.co.uk/donate "Donate") are always welcome.**

== Advanced embedding options ==

A basic shortcode will embed your video using your default profile settings. However, you may wish to override some of these options on a video-by-video basis - this is done via parameters added to the shortcode.

e.g. `[youtube width=300 height=200]Z_sCoHGIpU0[/youtube]`

Which options are available depends upon the embedding type you're using - you can specify any of them but, depending on the type, they may be ignored. There are 3 types - OBJECT, IFRAME and EmbedPlus. IFRAME is the current YouTube default and will use HTML 5, if available - this makes it ideal for maximum compatibility. However, HTML5 has a number of features that's not available with the standard Flash player.

The following parameters work with all embed types:

* **audio** - yes or no, this will hide the video and display just the toolbar (ideal for audio only playback) if switched on
* **autoplay** - yes or no, should the video automatically start playing?
* **height** - the video height, in pixels
* **list** - if you've specified your own list, use this to select the way the videos should be output. Should be `random` (display videos in a random order), `single` (show just one video, randomly picked from the list) or `order` (show each video in the original order - this is the default)
* **profile** - specify a different default profile (see section on Profiles for further details)
* **ratio** - allows you to define a window ratio - specify just a height or width and the ratio will calculate the missing dimension. Uses the format x:x, e.g. 4:3, 16:9
* **start** - a number of seconds from where to start the video playing
* **style** - apply CSS elements directly to the video output
* **template** - specify a template (see section on Templates for further details)
* **type** - which embedding type to use, this can be `embedplus`, `iframe`, `object` or `chromeless`
* **width** - the video width, in pixels

The following parameters will not work with EmbedPlus:

* **autohide** - 0, 1 or 2, this parameter indicates whether the video controls will automatically hide after a video begins playing. The default behaviour, a value of 2, is for the video progress bar to fade out while the player controls (play button, volume control, etc.) remain visible. If this parameter is set to 0, the video progress bar and the video player controls will be visible throughout the video. If this parameter is set to 1, then the video progress bar and the player controls will slide out of view a couple of seconds after the video starts playing. They will only reappear if the user moves her mouse over the video player or presses a key on her keyboard.
* **controls** - yes or no, should the controls be shown?
* **https** - yes or no, whether to use HTTPS for the video
* **loop** - yes or no, whether to start the video again once it ends
* **theme** - dark or light, display player controls (like a 'play' button or volume control) within a dark or light control bar

The following parameters will not work with EmbedPlus or if IFRAME uses HTML5:

* **annotation** - yes or no, this determines if annotations are shown
* **cc** - yes or no, decided whether closed captions (subtitles) are displayed
* **color** - white or red, the colour of the progress bar (see the FAQ about having a white progress bar with the light theme)
* **disablekb** - yes or no, disable keyboard controls
* **fullscreen** - yes or no, this will add the fullscreen button to the toolbar. This also works with EmbedPlus.
* **info** - yes or no, show video information
* **link** - yes or no, link video to YouTube
* **related** - yes or no, show related videos

The following parameters are only for use with EmbedPlus:

* **hd** - play the video in HD quality, if available
* **react** - yes or no, this specified whether you wish to show the Real-time Reactions button
* **stop** - this stops the video at a specific time, given in seconds
* **sweetspot** - yes or no, this will find sweet spots for the next/prev buttons

== Alternative Shortcodes ==

Within administration, selecting `Options` from the `YouTube` menu will provide a list of general options. One section is named `Alternative Shortcodes` and allows you to specify 1 or 2 additional shortcodes - these will work exactly the same as the standard shortcode of `[youtube]`.

There are 2 reasons why you might want to do this...

1. If migrating from another plugin, it may use a different shortcode - more details can be found in the section named "Migration"
2. If another plugin uses the same shortcode (e.g. Jetpack) this will allow you to specify and use an alternative

Each of the new shortcodes can also have their own default profile assigned to them (see the Profiles section for more details on this).

== Function Call ==

As well as a shortcode you can also use a PHP function call to display a video (e.g. in a sidebar). The function is named `youtube_video_embed` and has 2 parameters - the first is the video ID (or URL) and the second is a list of display parameters. The display parameters are the same as those used in the shortcode but are separated by an ampersand.

e.g. `youtube_video_embed( 'Z_sCoHGIpU0', 'width=300&height=200' )`

== Widgets ==

Sidebar widgets can be easily added. In Administration simply click on the `Widgets` option under the `Appearance` menu. `YouTube Embed` will be one of the listed widgets. Drag it to the appropriate sidebar on the right hand side and then choose your video options - any that aren't specified are taken from your default profile.

And that's it! You can use unlimited widgets, so you can add different videos to different sidebars.

== Playlists ==

YouTube allows users to create their own playlists - collections of videos that can be played in sequence.

Before version 2 of Artiss YouTube Embed, separate shortcodes and function calls had to be used to specify these. However, now you can simply specify their ID or URL with the standard methods.

e.g. `[youtube]095393D5B42B2266[/youtube]`

Playlists cannot be used along with the EmbedPlus embedding method.

A better alternative to playlists is the build-in lists function in Artiss YouTube Embed - see the Lists section for further details.

== Templates ==

Both in the profile and as a parameter you can specify a template. This allows you to define any CSS that you wish to "wrap" around the YouTube output.

The template consists simply of any HTML that you wish but with `%video%` where you wish the video to appear.

e.g. `<div align="center">%video%</div>`

Be wary that when adding template via a parameter that any HTML included may cause your video to have <pre> tags wrapped around it. The easiest way to check and fix this is to view any post in the HTML editor and remove any <pre> tags that have been added.

== Profiles ==

You've probably already had a look at the default profile, accessible by selecting `Profiles` from the `YouTube` administration menu option. Here you can specify the default option which will apply to any embedded video.

However, in the top right hand corner is a drop-down box and a button marked `Change profile`. Simply select an alternative profile and click the button and you can then edit the options for this alternative profile. You can even name it as well.

To use this profile, simply use the parameter `profile=` followed by the profile name or number. The options for this profile will then be used.

This could be useful, for instance, for having a separate profile for different parts of your site - posts, sidebar, etc - or for different video types (e.g. widescreen).

By default you have 5 extra profiles - if you wish to have more (or less) this number can be changed from the `Options` sub-menu.

== Lists ==

Although this plugin will play standard YouTube playlists their playback options are limited. Instead you can create your own video lists. Under the `YouTube` administration menu is a sub-menu named `Lists`. Select this and you will be shown a screen where you can type in a list of video IDs (or URLS). You can also provide a name for the list.

When saving the list each video is validated.

As with profiles you can select the list from a drop down in the top right-hand corner. You can also change the number of lists from the `Options` sub-menu too.

To use a list, simply specify the list name or number instead of a video ID.

e.g. `[youtube]List 1[/youtube]`

There is also a parameter, named `list`, that lets you modify the playback of the list. You can either play each in turn, play them randomly, or have just one played (but picked randomly).

== Transcripts ==

Some YouTube videos include transcripts - this is a text output of the speech from the video with timings added. These are available in XML format and can, via a function call or shortcode, be displayed in your post.

The shortcode `transcript` will display the transcript in your post along with the start time for each line. Simply supply the video ID as a parameter.

e.g. `[transcript]MSPsrhCPt-0[/transcript]`

If no transcript exists, nothing will be output.

For style purposes, the `SPAN` around the time has a class of `TranscriptTime`, the `SPAN` around the text has a class of `TranscriptText` and the `DIV` around the whole transcript output has a class of `Transcript`.

If you wish to use a PHP function call to get the transcript, then you would use the format `get_youtube_transcript( ID )`, where ID is the video ID.

In all of these cases, the original XML format has been changed to a readable output. If, though, you'd like to return the original XML format, then you can use the call `get_youtube_transcript_xml( ID )`.

== Migration ==

Within administration, selecting `Options` from the `YouTube` menu will provide a list of general options. One section is named `Migration`. There are 2 boxes that can be ticked to activate 2 different types of alternative embedding - these have been provided to allow easy migration from other similar plugins. You can also assign a specific profile to these migrated options.

The first option, `Bracket Embedding`, allows YouTube IDs to be assigned within brackets - similar to shortcodes but without the actual shortcode name. e.g. `[http://www.youtube.com/watch?v=Z_sCoHGIpU0]`.

The second option, `Alternative Embedding`, activates a short of other alternative embedding methods.

In both cases, activating these will impact performance so should only be used if absolutely necessary.

[Read more details](http://www.artiss.co.uk/artiss-youtube-embed/compatibility "Artiss YouTube Embed Compatibility") on which options to select for which plugin.

== Further options ==

**Thumbnails**

Artiss YouTube embed also has the ability to return a thumbnail of a video (sorry, this doesn't work with playlists). There are two methods you can use for this - a shortcode or a function call.

Use the function call `youtube_thumb_embed( 'id', 'paras', '', 'alt' )` to add a thumbnail to any part of your theme.

Like the video embed equivalent, the ID is the video ID and alt is the alternative text for the thumbnail image (optional). The parameters are different, however, but, again, are separated by ampersand.

The parameters are as follows...

* **rel** - specify a REL override, e.g. rel="nofollow"
* **target** - specify a TARGET override, e.g. target="_blank"
* **width** - this specifies the width of the thumbnail image
* **height** - this specifies the height of the thumbnail image
* **version** - which version of the thumbnail to use. This can be `default`, `hq` (for a high quality version of the default image), `start`, `middle` or `end`. The latter 3 indicate where from the video the thumbnails are taken from

e.g. `youtube_thumb_embed( 'id', 'rel=nofollow&target=_blank', '', 'Demo Video' )`

To use the shortcode method, insert `[youtube_thumb]id[/youtube_thumb]` into a post or page to create a thumbnail of the relevant video ID which, once clicked, will open up the appropriate YouTube page.

Like the function call above, you can specify a number of parameters. They are the same as detailed above but with the addition of one further parameter...

* **alt** - specify some `ALT` text for the thumbnail image

e.g. `[youtube_thumb target="_blank" alt="Demo video"]id[/youtube_thumb]`

This overrides the `TARGET` and `ALT` elements of the thumbnail.

**Video name**

You can retrieve the name of a video via 1 of 2 methods.

You can call the PHP function `get_youtube_name`, passing it to the video URL or ID - this will return the name of the video.

e.g. `echo get_youtube_name( 'Z_sCoHGIpU0' );`

Alternatively, you can use the shortcode `[youtube_name]`, again passing the video URL or ID. The video name will be displayed.

e.g. `[youtube_name]Z_sCoHGIpU0[/youtube_name]`

**Shortened URL**

You may return a short URL for any YouTube video by way of either a function call or a shortcode.

For a function call add `youtube_short_url( 'id' )` to your code to return a URL (note that this is not written out, but returned as a value), where `id` is the video ID.

e.g. `<a href="<?php echo youtube_short_url( 'Z_sCoHGIpU0' ); ?>"Click here for video</a>`

This will create a link to a video using the short URL standard.

To use the shortcode method simply insert `[youtube_url id=xx]` anywhere within a post to return a shortened URL. `xx` is the ID of the video.

**Download URL**

If you wish your users to be able to download a YouTube video or playlist then you can do this via either a shortcode of PHP function call.

The function call is named `get_video_download` and has one parameter - the video ID. It will return the download link URL.

e.g. `<a href="<?php echo get_video_download( 'Z_sCoHGIpU0' ); ?>">Download the video</a>`

Alternatively, you can use the shortcode `download_video`. The content to link is specified between the open and close shortcode tags and there are 3 parameters...

* **id** - The ID of the video or playlist. This is required.
* **target** - The target of the link (e.g. `_blank`). This is optional.
* **nofollow** - yes or no, use this to specify whether a `nofollow` tag should be added to the link. This is optional and by default it will be included.

e.g. `[download_video id="Z_sCoHGIpU0" target="_blank"]Download the video[/download_video]`

**Caching**

Caches are used to improve plugin performance. Under the `YouTube` administration menu is a sub-menu named `Options`. Select this and find the section named `Performance`. From here there are 3 cache options...

1. Embed Cache - this is how long to store the resulting cache code. It will update if you change any parameters so, theoretically, shouldn't need to change. It defaults to 24 hours.
2. Video Information Cache - video IDs are checked with YouTube to ensure that they're valid. This option lets you to specify how often this should be checked. This defaults to 1 hour.
3. Transcript Cache - how long to store transcripts. Defaults to 24 hours.

In all cases putting the cache to 0 will switch off caching for that option.

**Further Embedding Options**

Under the `YouTube` administration menu is a sub-menu named `Options`. Select this and find the section named `Embedding`. There are 4 options here...

1. Add Metadata - by default, RDFa metadata is added to video output. This can be switched on or off as required (see the FAQs for more information about metadata usage).
2. URL Embedding - if you place a YouTube URL directly into a post then WordPress will convert this to a video. This, however, is not performed by Artiss YouTube Embed. Select this option to allow this plugin to take over this functionality.
3. Comment Embedding - tick this to allow YouTube URLs added to comments to be converted to embedded videos.
4. Feed - videos will not appear in feeds so use this option to decide whether you want them to be converted to links and/or thumbnails.

In the case of URL and Comment embedding a profile can be selected.

== Licence ==

This WordPress plugin is licensed under the [GPLv2 (or later)](http://wordpress.org/about/gpl/ "GNU General Public License").

== Support ==

All of my plugins are supported via [my website](http://www.artiss.co.uk "Artiss.co.uk").

Please feel free to visit the site for plugin updates and development news - either visit the site regularly or [follow me on Twitter](http://www.twitter.com/artiss_tech "Artiss.co.uk on Twitter") (@artiss_tech).

For problems, suggestions or enhancements for this plugin, there is [a dedicated page](http://www.artiss.co.uk/artiss-youtube-embed "Artiss YouTube Embed") and [a forum](http://www.artiss.co.uk/forum "WordPress Plugins Forum"). The dedicated page will also list any known issues and planned enhancements.

**This plugin, and all support, is supplied for free, but [donations](http://artiss.co.uk/donate "Donate") are always welcome.**

== Reviews & Mentions ==

[New Technology Finds The Most Buzzed-About Parts Of Videos](http://www.socialtimes.com/2011/03/new-technology-finds-the-most-buzzed-about-parts-of-videos-interview/ "New Technology Finds The Most Buzzed-About Parts Of Videos") - SocialTimes.

[Andesch tips on WordPress plugins!](http://andershagstrom.se/andesch-tipsar-om-wordpress-plugins/ "Andesch tipsar om WordPress-plugins!") - Anders.

[Critical Mass](http://www.bikinginmemphis.com/2011/03/26/critical-mass/ "Critical Mass") - Biking in Memphis.

[Embedding YouTube Videos In Your WordPress Theme](http://frogenyozurt.com/2011/04/embedding-youtube-videos-in-your-wordpress-theme/ "Embedding YouTube Videos In Your WordPress Theme") - FrogenYozurt.Com.

== Installation ==

1. Upload the entire `youtube-embed` folder to your wp-content/plugins/ directory.
2. Activate the plugin through the 'Plugins' menu in WordPress.
3. If you're updating from version 2.0.1 or before, please read the FAQ on backwards compatibility.
3. That's it, you're done - you just need to add the shortcode wherever you need.

== Frequently Asked Questions ==

= How do I find the ID of a YouTube video? =

If you play a YouTube video, look at the URL - it will probably look something like this - `http://www.youtube.com/watch?v=L5Y4qzc_JTg`.

The video ID is the list of letters and numbers after `v=`, in this case `L5Y4qzc_JTg`.

= Why can't I change the player colour as I used to? =

Artiss YouTube Embed is now using the latest version of the YouTube Player, named AS3. This does not allow for the player colour to be modified, and a few other options are now missing as well.

Equally, some options are not supported depending on whether you use the IFRAME or OBJECT embedding method.

[Read more about which options are supported](http://www.artiss.co.uk/artiss-youtube-embed/further-help#ye-api "API Support").

= How do I add a border to the video =

The border option is no longer available with the YouTube player. However, you can use the `style` option to mimic it. Simply add a style of `border: 10px solid #b1b1b1`.

= When trying to display a video it says "An error occurred accessing the YouTube API" =

This has been reported by a number of users - for some reason some people are unable to access the YouTube API, which is used by this plugin to determine the video type and whether it's valid or not. If you are one of them then simply go to the `Options` screen within the `YouTube Embed` administration menu and, near the bottom, there is an option to stop reporting API errors.

If you switch off API errors then the plugin will simply assume all IDs are valid and work out the type from the ID length (which is not set, so if this changes in future it may cause problems!).

I have requested further information on why these errors may be occurring from the YouTube forum but, as yet, I've had no response. [Click here](http://groups.google.com/group/youtube-api-gdata/browse_thread/thread/764f2f2a3b5863f8?hl=en "YouTube APIs Developer Forum") if you wish to track the request.

= I've upgraded from an earlier version of Artiss YouTube Embed and one of the functions / shortcodes / parameters that I used is no longer documented =

Code created for previous versions of the plugin should still work - however, the functions will not be documented to deter people from using them in the future.

= So if I upgrade to this from an earlier version is it compatible? =

It should be, yes, but with one exception.

If you have upgraded from version 2.0.1 or before and used the `style` parameter then it may cause some problems. This is because the `style` parameter now affects the CSS of the video. Before, it added a DIV "wrapper" around the video and applied the styles to this.

Therefore, if you used the `style` parameter to centre a video this probably doesn't now work. However, you can do this now by using the `template` parameter instead - please read the section on that for further help.

However, with the change to the way the `style` works you can now apply more direct styling to the video - e.g. adding a border.

= Is the generated code standards compliant? =

In all cases, yes. However, it depends on which options you choose as to which DOCTYPE it will validate to.

IFRAME does not work with XHTML so will only validate as XHTML transitional (this includes if you use IFRAME as the fallback to EmbedPlus).

If you include Metadata then you must use the XHTML Strict + RDFa DOCTYPE - in this case it validates.

If you don't include Metadata then it will also validate as HTML5 compliant.

The [W3C Markup Validation Service](http://validator.w3.org/ "W3C Markup Validation Service") was used to test the above.

You can [read more about this here](http://www.artiss.co.uk/artiss-youtube-embed/further-help#ye-standards "Standards Compliance").

= Which browsers does the output work on? =

It uses standard OBJECT and IFRAME coding - this, along with the above standards compliance, means that the output should work on most browsers.

However, I can confirm that it's been tested in IE7 (IE8 in compatibility mode), IE8, IE9, Firefox 5 and Chrome 12.

= Which version of PHP does this plugin work with? =

It has been syntax checked as PHP 4. However, this does not guarantee PHP 4 compatibility and the minimum for WordPress is now PHP 5.2.4.

Although I attempt to keep with PHP 4 compatibility there are no guarantees of this.

= A new box has appeared on my dashboard all about Artiss plugins =

That's correct - all Artiss plugins will now add this feature to keep you up-to-date with the latest news and support links. If you wish to switch it off simply click on the "Screen Options" tab at the top and untick "Artiss News & Support".

== Screenshots ==

1. Artiss YouTube Embed in the administration menu.
2. The main options screen.
3. The profiles screen.
4. The lists screen - videos have been added and validated. The drop-down help is also shown.
5. The About screen
6. The default widget options

== Changelog ==

= 1.0 =
* Initial release

= 1.1 =
* Maintenance: Updated test video on options screen, as previous one had been removed
* Maintenance: Confirmed WP 3.0 compatibility
* Enhancement: Resulting XHTML code is better formatted, with comments identifying code location

= 1.2 =
* Enhancement: Minor changes to the XHTML code to prevent warnings from certain validators

= 1.3 =
* Enhancement: Added transparency option so that videos won't cover up layers

= 1.3.1 =
* Enhancement: New widget option to specify title

= 1.4 =
* Maintenance: Tidied up code
* Enhancement: Now supports multiple widgets - widget code completely re-written
* Enhancement: Support for EmbedPlus added
* Enhancement: Added option to suppress links back to YouTube
* Enhancement: Added functions and shortcodes for returning and outputting available transcripts

= 1.4.1 =
* Enhancement: HD option is available with EmbedPlus - updated the admin and widget screen to reflect this

= 1.4.2 =
* Enhancement: Added keyboard disable option
* Bug: Fixed bug which meant that people upgrading from previous versions may not be able to display video until they've been to the options screen and re-saved their default options

= 1.5 =
* Enhancement: Added clone of 'youtube' shortcode, called 'youtube_video'
* Enhancement: Editor now has YouTube button, which inserts the YouTube shortcode (this can be switched off in the options screen)
* Enhancement: Added new option to disable keyboard controls
* Enhancement: Added option to supply a ratio, in case height or width are not supplied - the missing parameter will then be calculated
* Enhancement: Option to create a download link (for video and playlist) using function call or shortcode
* Enhancement: You can now change on the options screen which set of parameters the demonstration video uses (i.e. "normal" or EmbedPlus). This allows you to try your options on a different video type without switching to it.

= 2.0 =
* Maintenance: Renamed to Artiss YouTube Embed from YouTube Embed
* Maintenance: Major re-write, using new coding standards
* Maintenance: AS3 player is now used, AS2 has been retired
* Maintenance: Compliancy and browser checked - XHTML and HTML5 compliant and works in all the latest browsers
* Maintenance: README completely re-written, contextual help added to admin screens and links to further information
* Enhancement: New administration screens, introducing multiple profiles and playlists
* Enhancement: Both OBJECT and IFRAME versions can be selected
* Enhancement: Migration options added, allowing compatibility with other similar plugins
* Enhancement: Can now specify full video URL as well as video ID
* Enhancement: No need to use separate shortcode for playlists, as they are automatically detected. Video IDs are also now validated
* Enhancement: Options to allow YouTube URLs not within shortcodes to be accepted, as well as in comments
* Enhancement: RDFa metadata added to code output
* Enhancement: Caching of code and ID checking to improve performance
* Enhancement: Templating system replaces CSS specification
* Enhancement: Improved editor button and link added to admin bar
* Enhancement: Many, many more changes - too many to list!

= 2.0.1 =
* Enhancement: Changed cache key encoding so that it was compatible with PHP 4
* Enhancement: Added autoplay option to EmbedPlus
* Enhancement: Re-instated `style` option, allowing you to apply a direct set of CSS elements to the output - a requirement if you wish to add a border to the video, for instance
* Maintenance: Updated screens and documentation to show the `start` parameter works with EmbedPlus
* Bug: Fixed incorrect caching of options - was only changing if override parameters were modified
* Bug: Video Information Cache will no longer reset to zero if the Embed cache is greater
* Bug: Added random ID to EmbedPlus output to resolve a bug that can affect IE users

= 2.0.2 =
* Enhancement: Strip tags from video ID, in case any have crept in
* Enhancement: Tidied some of the widget controls
* Enhancement: You can now specify YouTube short URLs as video IDs
* Bug: Removed reference to jscolor.js script, which isn't used
* Bug: Video IDs beginning with numbers are being confused with list numbers
* Bug: Corrected problem with random single videos being picked from a list
* Bug: Fixed problem with list where one video was being ignored and another repeated
* Bug: Modified widget code to allow for all states to be allowable. Defaults updated
* Bug: YouTube documentation states that if you don't specify the fullscreen parameter it will default to off. It doesn't. Corrected in the code

= 2.0.3 =
* Enhancement: Decode any passed `template` parameters, as WP may have encoded the content first
* Enhancement: Improved file handling
* Enhancement: Now using HTTPS and version 2 of YouTube gdata API
* Enhancement: New general option to switch off reporting of API errors - will simply accept ID and work out type
* Maintenance: Added details to the README to cover issues with `style` backwards compatibility and YouTube API

= 2.0.4 =
* Enhancement: Removed HTTPS access to gdata API - will add a switchable option for this in a later release

= 2.1 =
* Enhancement: New option to switch API options (where HTTP or HTTPS, display messages or not or even switch off)
* Enhancement: Output video playback errors as XHTML comments. Output to post a generic message which can be changed in the options
* Enhancement: Video information is shown in lists screen when first entering (no need to press Save button to display)
* Enhancement: Added new `color` parameter, which allows you to specify the colour of the progress bar
* Enhancement: Added new `theme` parameter, allowing you to specify if the player is dark or light skinned
* Enhancement: Added new `https` parameter, allowing you to use HTTPS instead of HTTP for the video display
* Enhancement: Added new `version` parameter to thumbnails, allowing different versions (including a high resolution one) to be displayed
* Enhancement: Added new administration option to allow the thumbnail used in RSS feeds to be specified
* Enhancement: Log the current plugin version into the database. This may be of use in future upgrades to detect which version the user is upgrading from
* Bug: Fixed video title no longer being fetched since 2.0.3 (because of using v2 of API)
* Bug: Fixed some error output - due to changes made in an earlier release some errors would not display

= 2.2 =
* Maintenance: Updated dashboard widget to latest version
* Maintenance: Added advertising banners to options screen - these can be turned off if you donate
* Enhancement: Replace WP_PLUGIN_URL with plugins_url()
* Enhancement: Added H and W as alternative shortcode parameters to HEIGHT and WIDTH
* Enhancement: Editor button should appear for anyone from editor role upwards
* Enhancement: Removed maximum length from profile and list names. However, only first 20 characters will appear in lists

= 2.3 =
* Bug: Fixed incorrect listing of long profile or list names
* Bug: Fixed INCLUDE bug in widgets.php
* Enhancement: Editor button will add text between shortcodes if no URL or ID is specified
* Enhancement: Square brackets are stripped from alternative shortcodes on option screen - text added to warn against this too
* Enhancement: Added Chromeless player option
* Enhancement: Increased maximum output length of profile and list names to 30 characters

= 2.3.1 =
* Maintenance: Removed the sponsorship

== Upgrade Notice ==

= 1.0 =
* Initial release

= 1.1 =
* Update to get the test video on the options screen working again!

= 1.2 =
* Update to ensure no warnings are reported by XHTML validators

= 1.3 =
* Update if you find that the videos are covering up layers

= 1.3.1 =
* Update if you wish to change the widget heading

= 1.4 =
* Update to add EmbedPlus, multi-widgets and transcript output capabilities

= 1.4.1 =
* Upgrade to make a small correction to the parameter lists

= 1.4.2 =
* Upgrade is you upgraded to version 1.4 or 1.4.1 from a previous version, to fix an important bug

= 1.5 =
* Upgrade to add a number of new options including video size ratios, disabling keyboard controls, an editor button and different demonstration video options on the admin screen

= 2.0 =
* Upgrade to take advantage of many new features. Code completely re-written

= 2.0.1 =
* Update to fix a few minor bugs found in 2.0 and add a couple of small enhancements

= 2.0.2 =
* Further update to fix a few minor bugs found in 2.0. A few small enhancements have also been made

= 2.0.3 =
* Removed secure API access as this was causing some users issues

= 2.0.4 =
* Fixed SSL bug by removing HTTPS access to API

= 2.1 =
* New options to change player colours, chose your thumbnails and control API usage

= 2.2 =
* Assorted minor improvements

= 2.3 =
* Assorted bug fixes and minor improvements. Also added Chromeless player.

= 2.3.1 =
* Upgrade to remove the sponsorship