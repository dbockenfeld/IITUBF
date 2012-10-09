<?php
/**
* Lists Options Page
*
* Screen for specifying different lists and the video IDs within them
*
* @package	YouTubeEmbed
* @since	2.0
*/
?>
<div class="wrap">

<div class="icon32"><img src="<?php echo plugins_url(); ?>/youtube-embed/images/screen_icon.png" alt="" title="" height="32px" width="32px"/><br /></div>

<h2>Artiss YouTube Embed Lists</h2>

<?php
// Set current list number
if ( isset( $_POST[ 'youtube_embed_list_no' ] ) ) { $list_no = $_POST[ 'youtube_embed_list_no' ]; } else { $list_no = 0; }
if ( $list_no == '' ) { $list_no = 1; }

// If options have been updated on screen, update the database
if ( ( !empty( $_POST[ 'Submit' ] ) ) && ( check_admin_referer( 'youtube-embed-general', 'youtube_embed_general_nonce' ) ) ) {

	$class = 'updated fade';
	$message = 'Settings Saved.';
	$new_id_list = '';

	if ( ( $_POST[ 'youtube_embed_video_list' ] == '' ) or ( $_POST[ 'youtube_embed_name' ] == '' ) ) {
		$class = 'error';
		$message = 'All fields must be completed.';
	} else {
		$id_array = explode( "\n", $_POST[ 'youtube_embed_video_list' ] );
		$loop = 0;
		$valid = true;

		// Loop through the video IDs
		while ( $loop < count( $id_array ) ) {
			// Extract the ID from the provided data
			$id = trim( ye_extract_id( $id_array[ $loop ] ) );
			// Now check its validity
			if ( $id != '' ) {
				$video_info = ye_validate_id( $id, true );
				if ( $video_info[ 'type' ] != 'v' ) { $valid = false; }
				$new_id_list .= $id . "\n";
			}
			$loop ++;
		}

		// If one or more IDs weren't valid, output an error
		if (!$valid) {
			$class = 'error';
			$message = 'Errors were found with your video list. See the list below for details.';
		}
	}

	// Update the options
	$options[ 'name' ] = $_POST[ 'youtube_embed_name' ];

	if ( $new_id_list == '' ) {
		$options[ 'list' ] = $_POST[ 'youtube_embed_video_list' ];
	} else {
		$options[ 'list' ] = substr( $new_id_list, 0, strlen( $new_id_list ) - 1 );
	}

	if ( substr( $class, 0, 7 ) == 'updated' ) { update_option( 'youtube_embed_list' . $list_no, $options ); }
	echo '<div class="' . $class.'"><p><strong>' . __( $message ) . "</strong></p></div>\n";
} else {
	$class = '';
}

// Fetch options into an array
if ( $class != "error" ) { $options = ye_set_list_defaults( $list_no ); }
$general = ye_set_general_defaults();
?>

<form method="post" action="<?php echo get_bloginfo( 'wpurl' ) . '/wp-admin/admin.php?page=youtube-embed-lists'; ?>">

<span class="alignright">
<select name="youtube_embed_list_no">
<?php
$loop = 1;
while ( $loop <= $general[ 'list_no' ] ) {

	$listfiles = get_option( 'youtube_embed_list' . $loop );
	$listname = $listfiles[ 'name' ];

	if ( $listname == '' ) { $listname = 'List ' . $loop; }
    if ( strlen( $listname ) > 30 ) { $listname = substr( $listname, 0, 30 ) . '&#8230;'; }
	echo '<option value="' . $loop . '"';
	if ( $list_no == $loop ) { echo " selected='selected'"; }
	echo '>' . __( $listname ) . "</option>\n";

	$loop ++;
}
?>
</select>
<input type="submit" name="List" class="button-secondary" value="<?php _e( 'Change list' ); ?>"/>
</span><br/>

<?php echo __( 'These are the options for list ' . $list_no . '.<br/>Update the name, if required, and specify a list of YouTube video IDs. Use the drop-down on the right hand side to swap between lists.' ); ?>

<table class="form-table">

<tr>
<th scope="row"><?php _e( 'List name' ); ?></th><td>
<input type="text" size="20" name="youtube_embed_name" value="<?php echo $options[ 'name' ]; ?>"/>
<?php echo '&nbsp;<span class="description">' . __( 'The name you wish to give this list' ) . '</span>'; ?>
</td></tr>

<tr>
<th scope="row"><?php _e( 'Video IDs (one per line)' ); ?></th><td>
<textarea name="youtube_embed_video_list" id="youtube_embed_video_list" cols="12" rows="10" class="widefat"><?php echo $options[ 'list' ]; ?></textarea>
</td></tr>
</table>

<?php wp_nonce_field( 'youtube-embed-general','youtube_embed_general_nonce', true, true ); ?>

<p class="submit"><input type="submit" name="Submit" class="button-primary" value="<?php _e( 'Save Settings' ); ?>"/></p>

</form>

<?php

// If video IDs exist display them on screen along with their status'
if ( $options[ 'list' ] != '' ) {

	$id_array = explode( "\n", $options[ 'list' ] );

	echo "<table class=\"widefat\">\n<thead>\n\t<tr>\n\t\t<th>Video ID</th>\n\t\t<th>Video Title</th>\n\t\t<th>Status</th>\n\t</tr>\n</thead>\n<tbody>\n";
	$loop = 0;

	while ( $loop < count( $id_array ) ) {

		// Extract the ID from the provided data

		$id = trim( ye_extract_id( $id_array[ $loop ] ) );
		if ( $id != '' ) {

			// Validate the video type

			$video_info = ye_validate_id( $id, true );
			$type = $video_info[ 'type' ];

			if ( $type == 'p' ) {
				$text = 'This is a playlist';
				$status = '-1';
			} else {
				if ( $type == '' ) {
					$text = 'Invalid video ID';
					$status = '-2';
				} else {
					if ( strlen( $type ) != 1 ) {
						$text = 'YouTube API error';
						$status = '-3';
					} else {
						$text = 'Valid video';
						$status = '0';
					}
				}
			}

			// Output the video information

			echo "\t<tr>\n\t\t<td>" . $id . "</td>\n";
			echo "\t\t<td>" . $video_info[ 'title' ] . "</td>\n";
			echo "\t\t<td style=\"";

			if ( $status != 0 ) {
				echo 'font-weight: bold; color: #f00;';
			}

			echo '"><img src="' . plugins_url() . '/youtube-embed/images/';
			if ( $status == 0 ) {
				echo 'tick.png" alt="The video ID is valid" title="The video ID is valid" ';
			} else {
				echo 'cross.png" alt="The video ID is invalid" title="The video ID is invalid" ';
			}

			echo "height=\"16px\" width=\"16px\"/>&nbsp;" . $text . "</td>\n\t</tr>\n";
		}
		$loop ++;
	}
	echo "</tbody>\n</table>\n";
}
?>

</div>