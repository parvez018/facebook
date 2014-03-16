<?php
  // Remember to copy files from the SDK's src/ directory to a
  // directory in your application on the server, such as php-sdk/
require_once('php-sdk/facebook.php');

$config = array(
  'appId' => '174445619379174',
  'secret' => '6a4d46bb72277759195614014d298ac8',
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
      $fql = 'SELECT status,name,sex,interests,locale,friend_count,activities,about_me,birthday_date from user where uid = ' . $user_id;
      $ret_obj = $facebook->api(array(
       'method' => 'fql.query',
       'query' => $fql,
       ));
/*
        // FQL queries return the results in an array, so we have
        //  to get the user's name from the first element in the array.
      echo '<pre>Name is : ' . $ret_obj[0]['name'] . '</pre>';
      echo '<pre>Sex is : ' . $ret_obj[0]['sex'] . '</pre>';
      echo '<pre>Interest is : ' . $ret_obj[0]['interests'] . '</pre>';
      echo '<pre>Locale is : ' . $ret_obj[0]['locale'] . '</pre>';
      echo '<pre>Total friend is : ' . $ret_obj[0]['friend_count'] . '</pre>';
      echo '<pre>Activities are : ' . $ret_obj[0]['activities'] . '</pre>';
      echo '<pre>About me is : ' . $ret_obj[0]['about_me'] . '</pre>';
      echo '<pre>Birthday is : ' . $ret_obj[0]['birthday_date'] . '</pre>';
    */
      //var_dump($user_id);
      var_dump($ret_obj);
      $fql="SELECT user_id, object_id, post_id, object_type FROM like WHERE user_id = me()";
      $ret_obj = $facebook->api(array(
       'method' => 'fql.query',
       'query' => $fql,
       ));
      //var_dump($ret_obj);
      $fql="SELECT name from user WHERE uid IN (SELECT uid2 FROM friend WHERE uid1 = me())";
      $ret_obj = $facebook->api(array(
       'method' => 'fql.query',
       'query' => $fql,
       ));
      //var_dump($ret_obj);
      
      $fql="SELECT name, page_id, page_url, location, fan_count, were_here_count FROM page WHERE contains(\"বাশেরকেল্লা\") ORDER BY fan_count DESC";
      $ret_obj = $facebook->api(array(
       'method' => 'fql.query',
       'query' => $fql,
       ));
      var_dump($ret_obj);
/*      $fql='SELECT post_id, actor_id, target_id, message FROM stream WHERE source_id in 
      (SELECT target_id FROM connection WHERE source_id='.$user_id.') AND is_hidden = 0';
      $ret_obj = $facebook->api(array('method' => 'fql.query','query' => $fql,));
      //var_dump($ret_obj);
*/
      $fql="SELECT message FROM status WHERE contains(\"me\")";
      $ret_obj = $facebook->api(array(
       'method' => 'fql.query',
       'query' => $fql,
       ));
      //var_dump($ret_obj);
    } catch(FacebookApiException $e) {
        // If the user is logged out, you can have a 
        // user ID even though the access token is invalid.
        // In this case, we'll get an exception, so we'll
        // just ask the user to login again here.
        $params = array('scope' => 'read_stream, friends_likes,user_birthday,read_friendlists,user_status,user_about_me,user_activities');

        $login_url = $facebook->getLoginUrl($params); 
        echo 'Please <a href="' . $login_url . '">login.</a>';
        error_log($e->getType());
        error_log($e->getMessage());
        echo $e->getType();
        echo $e->getMessage();
    }   
  } else {

      // No user, so print a link for the user to login
        $params = array('scope' => 'read_stream, friends_likes,user_birthday,read_friendlists,user_status,user_about_me,user_activities');

        $login_url = $facebook->getLoginUrl($params);

    echo 'Please <a href="' . $login_url . '">login.</a>';

  }

  ?>

</body>
</html>