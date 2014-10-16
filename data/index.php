<?php
require 'facebook-php-sdk/src/facebook.php';
$facebook = new Facebook(array(
  'appId'  => '191476537592963',
  'secret' => '10baf8ac8c229617f0612efe303fa86c',
));
$loginUrl = $facebook->getLoginUrl();
$user = $facebook->getUser();
?>
<!doctype html>

<html lang="en">
<head>
  <meta charset="utf-8">

  <title>Game Gifter</title>
  <meta name="description" content="">
  <meta name="author" content="">

  <!--<link rel="stylesheet" href="css/styles.css?v=1.0">-->
  <!--[if lt IE 9]>
  <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
  <![endif]-->
</head>

<body>
  <h1>Welcome</h1>
  <a href="register.php">Register</a>
  <a href="login.php">Login</p>
</body>
</html>
