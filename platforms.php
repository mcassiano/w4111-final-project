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

$sactive = "platforms";
$active = $user ? "dashboard" : "reg";
$title = $nav[$active]['title'];
include('template/header.html');

$sql = "select * from (select * from Platform order by rating desc) where ROWNUM <= 5";
$results = $db_connection->select($sql);

$username = $user_profile['username'];

$sql = "select user_id from GGUser where username = '$username'";
$uid = $db_connection->select($sql)[0]['user_id'];

$sql = "select * from Platform natural join(select platform_id from User_Platform_has where user_id = $uid)";
$platforms = $db_connection->select($sql);

?>

<body>
  <?php include('template/nav.html'); ?>

  <?php if ($user) { ?>
  <div class="container-fluid">

    <div class="row">

      <?php include('template/sidebar.html'); ?>

      <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">


        <h1>Platforms</h1>

        <div class="row">
          <div class="col-md-8">
            <?php if (!$platforms) { ?>
            You don't have any games yet.
            <?php } else { ?>
              <?php foreach($platforms as $platform) { ?>
                <p><a href="platform.php?id=<?php echo $platform['platform_id']; ?>"><?php echo $platform['name']; ?></a></p>
              <?php } }?>
          </div>
          <div class="col-md-4">
            <h3>Featured platforms</h3>

            <?php $i = 1; foreach($results as $platform) { ?>
              <p><?php echo $i; ?>. <a href="platform.php?id=<?php echo $platform['platform_id']; ?>"><?php echo $platform['name']; ?></a></p>
              <p><span class="stars"><?php echo $platform['rating']*5/10; ?></span></p>
              <script>$('span.stars').stars();</script>
              <?php $i++; ?>
            <?php } ?>
          </div>

      </div>


    </div>

  </div><!-- /.container -->

  <?php } ?>

    <?php include('template/footer.html'); ?>
