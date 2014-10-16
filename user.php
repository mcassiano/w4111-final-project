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

if (isset($_GET['id'])) {
  $id = $_GET['id'];
}

$sactive = "friends";
$active = $user ? "dashboard" : "reg";
$title = $nav[$active]['title'];
include('template/header.html');

$sql = "select * from GGUser where user_id = $id";
$results = $db_connection->select($sql);
?>

<script type="text/javascript">
  function user_add_friend(obj) {
    $.ajax({
      url: 'user_add_friend.php',
      type: 'get',
      data: {'username': "<?php echo $user_profile['username']; ?>", 'uid': "<?php echo $id; ?>"},
      success: function(data, status) {
      }
    });
  }
</script>

<body>
  <?php include('template/nav.html'); ?>

  <?php if ($user) { ?>
  <div class="container-fluid">

    <div class="row">

      <?php include('template/sidebar.html'); ?>

      <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">


        <?php foreach ($results as $user) { ?>

        <h1><?php echo $user['first_name'].' '.$user['last_name']; ?> | <small><?php echo $user['username']; ?></small></h1>
        born <?php echo $user['date_of_birth']; ?>, user since <?php echo $user['user_since']; ?> 
        <p>
        

        <div class="row">
          <div class="col-md-8">
          </div>
          <div class="col-md-4">
              <p><?php echo $user['points']; ?> points</p>
              <p><a href="wishlist.php?id=<?php echo $user['user_id']; ?>">go to wishlist</a></p>
              <button onclick="user_add_friend(this)" type="button" class="btn btn-primary">add friend</button>
          </div>

        </div>

      <?php } ?>


    </div>

  </div><!-- /.container -->

  <?php } ?>


    <?php include('template/footer.html'); ?>
