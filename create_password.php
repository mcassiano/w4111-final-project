<?php
include('include/nav.php');
require_once("include/connection.php");

$active = "cpassword";
$title = $nav[$active]['title'];

require_once('include/facebook/src/facebook.php');

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

if (!$user) {
  header('Location: '.$website_url);
}

$username = $user_profile['username'];
$sql = "select * from GGUser where username = '$username'";

if ($db_connection->select($sql)) {
    header("Location: register.php");
    exit();
  }

if (isset($_POST['password'])) {

  $username   = $user_profile['username'];
  $first_name = $user_profile['first_name'];
  $last_name  = $user_profile['last_name'];
  $birthday   = $user_profile['birthday'];
  $email      = $user_profile['email'];
  $password   = md5($_POST['password']);

  $sql = "insert into GGUser VALUES (1,'$first_name','$last_name','$username','$password',NULL,NULL,0,to_date('$birthday', 'mm/dd/yyyy'), SYSDATE)";
  $db_connection->insert($sql);

  $sql = "select * from GGUser where username = '$username'";

  if ($db_connection->select($sql)) {
    header("Location: register.php");
    exit();
  }

  exit();
}

include('template/header.html');
?>

<body>
  <?php include('template/nav.html'); ?>
  <div class="container">
    <div class="starter-template">
      
      <div class="starter-template">
        <h1>Register for GameGifter</h1>
        <p class="lead">Hey there, <?php echo $user_profile['first_name']; ?>. One more step and you're done!</p>

        <div class="col-sm-4">
        </div>
        <div class="col-sm-4">
          <form action="create_password.php" method="POST">
            <div class="form-group">
              <label for="password">Type your password</label>
              <input type="password" name="password" class="form-control" id="password">
            </div>
            <button type="submit" class="btn btn-default">submit</button>
          </form>
        </div>
        <div class="col-sm-4">
        </div>

      </div>

    </div><!-- /.container -->

    <?php include('template/footer.html'); ?>
