<?php
require_once('include/facebook/src/facebook.php');
include('include/connection.php');

$facebook = new Facebook(array(
  'appId' => '191476537592963',
  'secret' => '10baf8ac8c229617f0612efe303fa86c'
  )
);

$user = $facebook->getUser();
if ($user) {
  try {
// Proceed knowing you have a logged in user who's authenticated.
    $user_profile = $facebook->api('/me');
  } catch (FacebookApiException $e) {
    $user = null;
  }
}

$username = $user_profile['username'];
$sql = "select user_id from GGUser where username = '$username'";
$uid = $db_connection->select($sql)[0]['user_id'];
$gid = $_POST['game_id'];
$rating = $_POST['rating'];
$text = htmlspecialchars($_POST['text']);

$sql = "insert into Review values ($uid, $gid, $rating, '$text')";
$db_connection->insert($sql);
header("Location: game.php?id=".$gid);

?>