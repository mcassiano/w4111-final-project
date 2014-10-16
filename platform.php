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

$sactive = "platforms";
$active = "platforms";
$title = $nav[$active]['title'];
include('template/header.html');

$sql = "select * from Platform where platform_id = $id";
$results = $db_connection->select($sql);
?>

<script type="text/javascript">
  function user_add_platform(obj) {
    $.ajax({
      url: 'user_add_platform.php',
      type: 'get',
      data: {'username': "<?php echo $user_profile['username']; ?>", 'pid': "<?php echo $id; ?>"},
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


        <?php foreach ($results as $platform) { ?>

        <h1><?php echo $platform['name']; ?></h1>
        <?php } ?>

        <div class="row">
          <div class="col-md-8">
            <p><span class="stars"><?php echo $platform['rating']*5/10; ?></span></p>
              <script>$('span.stars').stars();</script>
            <?php echo $platform['description']; ?>

          </div>
          <div class="col-md-4">
              <button onclick="user_add_platform(this)" type="button" class="btn btn-primary">add to my platforms</button>
              <p></p>
              <img src="<?php echo $platform['art']; ?>" width="100%">

          </div>

      </div>


    </div>

  </div><!-- /.container -->

  <?php } ?>


    <?php include('template/footer.html'); ?>
