<?php
  // Remember to copy files from the SDK's src/ directory to a
  // directory in your application on the server, such as php-sdk/
  require_once('php-sdk/facebook.php');

  $config = array(
    'appId' => '174445619379174',
  'secret' => '6a4d46bb72277759195614014d298ac8',
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

        $user_profile = $facebook->api('/search?q="শাহবাগ"&type=post&updated_time>1347494400','GET');
        $user_profile = $facebook->api('/search?q=parvez&type=post','GET');
        $user_profile = $facebook->api('/search?q=শাহবাগ&type=post&fields=message&limit=10&until=5/3/2013','GET');
        //$user_profile = $facebook->api('/shahbagecyberjuddho/posts','GET');
        //echo "Name: " . $user_profile['name'];
        foreach ($user_profile['data'] as $key => $value) {
          echo $key."  ===>>>  ".$value['message']."<br/>";
        }
        var_dump($user_profile);

      } catch(FacebookApiException $e) {
        // If the user is logged out, you can have a 
        // user ID even though the access token is invalid.
        // In this case, we'll get an exception, so we'll
        // just ask the user to login again here.
        $login_url = $facebook->getLoginUrl(); 
        echo 'Please <a href="' . $login_url . '">login.</a>';
        error_log($e->getType());
        error_log($e->getMessage());
        echo $e->getType();
        echo $e->getMessage();
      }   
    } else {

      // No user, print a link for the user to login
      $login_url = $facebook->getLoginUrl();
      echo 'Please <a href="' . $login_url . '">login.</a>';
      echo $e->getType();
        echo $e->getMessage();

    }

  ?>

  </body>
</html>