<?php
/**
* Widgets
*
* Create and display widgets
*
* @package	YouTubeEmbed
*/

global $wp_version;
if ( ( float ) $wp_version >= 2.8 ) {

	class YouTubeEmbedWidget extends WP_Widget {

		/**
		* Widget Constructor
		*
		* Call WP_Widget class to define widget
		*
		* @since	2.0
		*
		* @uses		WP_Widget				Standard WP_Widget class
		*/

		function YouTubeEmbedWidget() {
			parent::WP_Widget(	'youtube_embed_widget',
								'YouTube Embed',
								array( 'description' => 'Embed YouTube Widget.', 'class' => 'my-widget-class' )
								);
		}

		/**
		* Display widget
		*
		* Display the YouTube widget
		*
		* @since	2.0
		*
		* @uses		generate_youtube_code	Generate the required YouTube code
		*
		* @param	string		$args			Arguments
		* @param	string		$instance		Instance
		*/

		function widget( $args, $instance ) {
			extract( $args, EXTR_SKIP );

			// Output the header
			echo $before_widget;

			// Extract title for heading
			$title = $instance[ 'titles' ];

			// Output title, if one exists
			if ( !empty( $title ) ) { echo $before_title . $title . $after_title; }

			// Generate the video and output it
			echo ye_generate_youtube_code ( $instance[ 'id' ],
											$instance[ 'type' ],
											$instance[ 'width' ],
											$instance[ 'height' ],
											$instance[ 'fullscreen' ],
											$instance[ 'related' ],
											$instance[ 'autoplay' ],
											$instance[ 'loop' ],
											$instance[ 'start' ],
											$instance[ 'info' ],
											$instance[ 'annotation' ],
											$instance[ 'cc' ],
											$instance[ 'style' ],
											$instance[ 'link' ],
											$instance[ 'react' ],
											$instance[ 'stop' ],
											$instance[ 'sweetspot' ],
											$instance[ 'disablekb' ],
											'',
											$instance[ 'autohide' ],
											$instance[ 'controls' ],
											$instance[ 'profile' ],
											$instance[ 'list' ],
											'',
											$instance[ 'template' ],
											$instance[ 'hd' ] );

			// Output the trailer
			echo $after_widget;
		}

		/**
		* Widget update/save function
		*
		* Update and save widget
		*
		* @since	2.0
		*
		* @param	string		$new_instance		New instance
		* @param	string		$old_instance		Old instance
		* @return	string							Instance
		*/

		function update( $new_instance, $old_instance ) {

			$instance = $old_instance;
			$instance[ 'titles' ] = strip_tags( $new_instance[ 'titles' ] );
			$instance[ 'id' ] = $new_instance[ 'id' ];
			$instance[ 'type' ] = $new_instance[ 'type' ];
			$instance[ 'width' ] = $new_instance[ 'width' ];
			$instance[ 'height' ] = $new_instance[ 'height' ];
			$instance[ 'fullscreen' ] = $new_instance[ 'fullscreen' ];
			$instance[ 'related' ] = $new_instance[ 'related' ];
			$instance[ 'autoplay' ] = $new_instance[ 'autoplay' ];
			$instance[ 'loop' ] = $new_instance[ 'loop' ];
			$instance[ 'start' ] = $new_instance[ 'start' ];
			$instance[ 'info' ] = $new_instance[ 'info' ];
			$instance[ 'annotation' ] = $new_instance[ 'annotation' ];
			$instance[ 'cc' ] = $new_instance[ 'cc' ];
			$instance[ 'style' ] = $new_instance[ 'style' ];
			$instance[ 'link' ] = $new_instance[ 'link' ];
			$instance[ 'react' ] = $new_instance[ 'react' ];
			$instance[ 'stop' ] = $new_instance[ 'stop' ];
			$instance[ 'sweetspot' ] = $new_instance[ 'sweetspot' ];
			$instance[ 'disablekb' ] = $new_instance[ 'disablekb' ];
			$instance[ 'autohide' ] = $new_instance[ 'autohide' ];
			$instance[ 'controls' ] = $new_instance[ 'controls' ];
			$instance[ 'profile' ] = $new_instance[ 'profile' ];
			$instance[ 'list' ] = $new_instance[ 'list' ];
			$instance[ 'template' ] = $new_instance[ 'template' ];
			$instance[ 'hd' ] = $new_instance[ 'hd' ];

			return $instance;
		}

		/**
		* Widget Admin control form
		*
		* Define admin file
		*
		* @since	2.0
		*
		* @param	string		$instance		Instance
		*/

		function form( $instance ) {
			include ( WP_PLUGIN_DIR . '/youtube-embed/includes/options-widgets.php' );
		}
	}

	/**
	* Register Widget
	*
	* Register widget when loading the WP core
	*
	* @since	2.0
	*/

	function youtube_embed_register_widgets() {
		register_widget( 'YouTubeEmbedWidget' );
	}
	add_action( 'widgets_init', 'youtube_embed_register_widgets' );
}
?>