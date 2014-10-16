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

if (isset($_GET['s'])) {
  $term = $_GET['s'];
}

$sactive = "";
$active = "search";
$title = $nav[$active]['title'];
include('template/header.html');

$sql = "select * from Platform where lower(name) LIKE lower('%$term%')";
$results['platform'] = $db_connection->select($sql);

$sql = "select * from Game where lower(name) LIKE lower('%$term%')";
$results['game'] = $db_connection->select($sql);

$sql = "select * from Genre where lower(name) LIKE lower('%$term%')";
$results['genre'] = $db_connection->select($sql);

$sql = "select * from GGUser where lower(first_name) LIKE lower('%$term%') or lower(last_name) LIKE lower('%$term%')";
$results['user'] = $db_connection->select($sql);

?>

<body>
  <?php include('template/nav.html'); ?>

  <?php if ($user) { ?>
  <div class="container-fluid">

    <div class="row">

      <?php include('template/sidebar.html'); ?>

      <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">

        <h1>Search results</h1>

        <?php foreach ($results as $key => $items) { ?>

        <h3><?php echo $key ?>s</h3>

        <?php foreach ($items as $item) { ?>

        <?php if ($key == 'user') $item['name'] = $item['first_name'].' '.$item['last_name']; ?>

        <p><a href="<?php echo $key; ?>.php?id=<?php echo $item[$key.'_id']; ?>"><?php echo $item['name']; ?></a></p>

        <?php } } ?>


    </div>

  </div><!-- /.container -->

  <?php } ?>


    <?php include('template/footer.html'); ?>
