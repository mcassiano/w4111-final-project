<?php
require_once('include/connection.php');

$username = $_GET['username'];
$gid = $_GET['gid'];
$sql = "select user_id from GGUser where username = '$username'";
$uid = $db_connection->select($sql)[0]['user_id'];
$sql = "insert into User_Game_wishes values ($uid, $gid)";
$db_connection->insert($sql);

?>