<?php
  // Remember to copy files from the SDK's src/ directory to a
  // directory in your application on the server, such as php-sdk/
  require_once('facebook-php-sdk/src/facebook.php');

  $config = array(
    'appId' => '246458295561723',
    'secret' => '9f041bb39320c2b732fd088613f23840',
    'allowSignedRequest' => false // optional but should be set to false for non-canvas apps
  );
  $facebook = new Facebook($config);
  $user_id = $facebook->getUser();
?>
<html>
  <head></head>
  <body>

  <?php
    if($user_id) {

      // We have a user ID, so probably a logged in user.
      // If not, we'll get an exception, which we handle below.
      try {

        $user_profile = $facebook->api('/me','GET');
        echo "Name: " . $user_profile['name']."</br>";
	$permissions = $facebook->api('/me/permissions');
	$permissions["data"][0]["user_birthday"];
	if ($permissions["data"][0]["user_birthday"] == 1)
	 { 			
	 echo "permission ok";
	  } else {
 	echo "no permission\n";
	  $login_url = $facebook->getLoginUrl(array(
		'scope'		=> 'read_stream, publish_stream, user_birthday, user_location, user_work_history, user_hometown, user_photos',
		'redirect_uri'   => 'https://apps.facebook.com/246458295561723' , 
		)); 
	echo $login_url ;
	echo 'Please <a href="' . $login_url . '">login.</a>';
	}
      } catch(FacebookApiException $e) {
        // If the user is logged out, you can have a 
        // user ID even though the access token is invalid.
        // In this case, we'll get an exception, so we'll
        // just ask the user to login again here.
	echo 'You looged out\n' ;
        $login_url = $facebook->getLoginUrl(); 
        echo 'Please <a href="' . $login_url . '">login.</a>';
        error_log($e->getType());
        error_log($e->getMessage());
      }   
    } else {
      echo "hello there.... <br/>";
      $login_url = $facebook->getLoginUrl();
      // No user, print a link for the user to login
      echo 'Please <a href="' . $login_url . '">login.</a>';
      }

  ?>

  </body>
</html>

