<?php


	IF ($add_msg_success == 1){
		echo "<strong>Added new bible study item successfully.</strong>";
		}
	IF ($edit_msg_success == 1){
		echo "<strong>Edited bible study item successfully.</strong>";
		}

	echo "
		<br />
		<br />
		<a href = 'a_msg.php'>Click here to Add or Edit other Bible study records</a>";

?>