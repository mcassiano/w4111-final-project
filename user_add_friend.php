<?php
require_once('include/connection.php');

$username = $_GET['username'];
$gid = $_GET['uid'];
$sql = "select user_id from GGUser where username = '$username'";
$uid = $db_connection->select($sql)[0]['user_id'];
$sql = "insert into User_User_friends values ($uid, $gid, SYSDATE)";
$db_connection->insert($sql);

?>