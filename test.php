<?php
  require_once("sdk/facebook.php");

  $config = array();
  $config['appId'] = 'YOUR_APP_ID';
  $config['secret'] = 'YOUR_APP_SECRET';
  $config['fileUpload'] = false; // optional

  $facebook = new Facebook($config);

?>