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

$sactive = "wishlist";
$active = $user ? "dashboard" : "reg";
$title = $nav[$active]['title'];
include('template/header.html');

$sql = "select * from (select * from Game order by rating desc) where ROWNUM <= 5";
$results = $db_connection->select($sql);

if (isset($_GET['id'])) {
  $id = $_GET['id'];
  $sactive = "";
}
else {
  
  $username = $user_profile['username'];

  $sql = "select user_id from GGUser where username = '$username'";
  $id = $db_connection->select($sql)[0]['user_id'];

}
  $sql = "select * from Game natural join (select game_id from User_Game_wishes where user_id = $id)";
  $games = $db_connection->select($sql);

?>

<body>
  <?php include('template/nav.html'); ?>

  <?php if ($user) { ?>
  <div class="container-fluid">

    <div class="row">

      <?php include('template/sidebar.html'); ?>

      <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">


        <h1>Wishlist</h1>

        <div class="row">
          <div class="col-md-8">
            
            <?php if (!$games) { ?>
            User's wishlist doesn't have any games yet.
            <?php } else { ?>
              <?php foreach($games as $game) { ?>
                <p><a href="game.php?id=<?php echo $game['game_id']; ?>"><?php echo $game['name']; ?></a></p>
              <?php } }?>

          </div>
          <div class="col-md-4">
            <h3>Featured games</h3>

            <?php $i = 1; foreach($results as $game) { ?>
              <p><?php echo $i; ?>. <a href="game.php?id=<?php echo $game['game_id']; ?>"><?php echo $game['name']; ?></a></p>
              <p><span class="stars"><?php echo $game['rating']*5/10; ?></span></p>
              <script>$('span.stars').stars();</script>
              <?php $i++; ?>
            <?php } ?>
          </div>

      </div>


    </div>

  </div><!-- /.container -->

  <?php } ?>

    <?php include('template/footer.html'); ?>
