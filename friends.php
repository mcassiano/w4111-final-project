<?php
include('include/nav.php');
require_once('include/facebook/src/facebook.php');
require_once('include/connection.php');

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

if (isset($_GET['logout']) && $_GET['logout'] == 'true') {
  session_destroy();
  header('Location: ?');
}

$sactive = "friends";
$active = $user ? "dashboard" : "reg";
$title = $nav[$active]['title'];
include('template/header.html');

$username = $user_profile['username'];

$sql = "select user_id from GGUser where username = '$username'";
$uid = $db_connection->select($sql)[0]['user_id'];

$sql = "select * from GGUser all_users inner join User_User_friends the_friends on all_users.user_id = the_friends.user2_id and the_friends.user1_id = $uid";
$friends = $db_connection->select($sql);

?>

<body>
  <?php include('template/nav.html'); ?>

  <?php if ($user) { ?>
  <div class="container-fluid">

    <div class="row">

      <?php include('template/sidebar.html'); ?>

      <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">


        <h1>Friends</h1>

        <div class="row">
          <div class="col-md-8">
            <?php if (!$friends) { ?>
            You don't have any friends yet.
            <?php } else { ?>
              <?php foreach($friends as $friend) { ?>
                <p><a href="user.php?id=<?php echo $friend['user_id']; ?>"><?php echo $friend['first_name'].' '.$friend['last_name']; ?></a></p>
              <?php } }?>

          </div>
          <div class="col-md-4">
          </div>

      </div>


    </div>

  </div><!-- /.container -->

  <?php } ?>

    <?php include('template/footer.html'); ?>
