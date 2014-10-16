<?php
include('include/nav.php');
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

if (isset($_GET['logout']) && $_GET['logout'] == 'true') {
  session_destroy();
  header('Location: ?');
}

$sactive = "my_account";
$active = $user ? "dashboard" : "reg";
$title = $nav[$active]['title'];
include('template/header.html');

?>

<body>
  <?php include('template/nav.html'); ?>

  <?php if ($user) { ?>
  <div class="container-fluid">

    <div class="row">

      <?php include('template/sidebar.html'); ?>

      <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">

        <h1>Welcome home</h1>
        <p class="lead">Good to see you again!</p>
        <p>You are already registred, <?php echo $user_profile['first_name']; ?>. <a href="?logout=true">Logout</a>?</p>


      </div>


    </div>

  </div><!-- /.container -->

  <?php } else {?>

  <div class="container">

    <div style="padding: 40px 15px; text-align: center;">
      <div class="row">
        <h1>Register for GameGifter</h1>
        <p class="lead">And start getting recomendations of games for your friends!</p>

        <?php $loginUrl = $facebook->getLoginUrl(array(
        "scope" => "email, user_birthday",
        "redirect_uri" => "$website_url/create_password.php")
        ); ?>
        <div class="col-md-4">
        </div>
        <div class="col-md-4">

          <a class="btn btn-block btn-social btn-lg btn-facebook" href="<?php echo $loginUrl; ?>">
            <i class="fa fa-facebook"></i> Start with Facebook
          </a>
        </div>
        <div class="col-md-4">
        </div>
        </div>
      </div>
    </div><!-- /.container -->

    <?php } ?>

    <?php include('template/footer.html'); ?>
