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

$sactive = "games";
$active = $user ? "dashboard" : "reg";
$title = $nav[$active]['title'];
include('template/header.html');

$sql = "select * from Game where game_id = $id";
$results = $db_connection->select($sql);

$sql = "select game_id, game.name, count(*) as nplayers from Game natural join GGUser where game_id=$id
group by game_id, game.name";
$players = $db_connection->select($sql)[0]['nplayers'];

?>

<script type="text/javascript">
  function user_add_game(obj) {
    $.ajax({
      url: 'user_add_game.php',
      type: 'get',
      data: {'username': "<?php echo $user_profile['username']; ?>", 'gid': "<?php echo $id; ?>"},
      success: function(data, status) {
        reload();
      }
    });
  }

  function user_add_wishlist(obj) {
    $.ajax({
      url: 'user_add_wishlist.php',
      type: 'get',
      data: {'username': "<?php echo $user_profile['username']; ?>", 'gid': "<?php echo $id; ?>"},
      success: function(data, status) {
        reload();
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


        <?php foreach ($results as $game) { ?>

        <h1><?php echo $game['name']; ?></h1>
        <?php } ?>

        <div class="row">
          <div class="col-md-8">
            <p><span class="stars"><?php echo $game['rating']*5/10; ?></span></p>
              <script>$('span.stars').stars();</script>
            <?php echo $game['description']; ?>

            <?php
            $sql = "select * from Genre natural join (select * from Game_Genre_belongs natural join (select game_id, game.name as game_name from game)) where game_id = $id";
            $genres = $db_connection->select($sql);
            ?>
            <p></p>

            <?php foreach ($genres as $genre) { ?>
              <span class="btn btn-default"><?php echo $genre['name']; ?></span>
            <? } ?>

            <h3>Reviews</h3>
            <p></p>

            <?php
            $sql = "select * from GGUser G inner join (select * from Review where game_id=$id) C on  G.user_id = C.user_id";
            $reviews = $db_connection->select($sql);
            ?>

            <?php foreach ($reviews as $review) { ?>
              <p><a href="user.php?id=<?php echo $review['user_id']; ?>"><?php echo $review['first_name'].' '.$review['last_name']; ?></a><br>
                <p><span class="stars"><?php echo $review['rating']; ?></span></p>
              <script>$('span.stars').stars();</script>
              <p>
               <?php echo $review['review_text']; ?>
             </p>
            <? } ?>

            <?php if(!$reviews) { ?>
            No reviews yet.
            <?php } ?>

            <?php
              $username = $user_profile['username'];
              $sql = "select user_id from GGUser where username = '$username'";
              $uid = $db_connection->select($sql)[0]['user_id'];
              $sql = "select * from user_game_has where user_id = $uid";
              $games = $db_connection->select($sql);
              $can_write = FALSE;

              foreach ($games as $value)
                if ($value['game_id'] == $id) $can_write = TRUE;
            ?>

            <?php if ($can_write) { ?>
            <h4>Write a review</h4>

            <form method="post" action="publish_review.php">
              <textarea name="text" class="form-control" rows="3"></textarea>
              <div class="row">
                <div class="col-md-10">
                  <p></p>
                   <input type="radio" name="rating" value="1"> 1
                   <input type="radio" name="rating" value="2"> 2
                   <input type="radio" name="rating" value="3"> 3 
                   <input type="radio" name="rating" value="4"> 4
                   <input type="radio" name="rating" value="5"> 5

                   <input type="hidden" name="game_id" value="<?php echo $id; ?>">
                </div>

                <div class="col-md-2">
                  <p></p>
                  <button type="submit" class="btn btn-primary">Publish</button>
                </div>

            </form>

            </div>
            <?php } ?>

          </div>
          <div class="col-md-4">
            <?php echo $players.' person/people have this game<p>'; ?>
              <button onclick="user_add_game(this)" type="button" class="btn btn-primary">add to library</button>
              <button onclick="user_add_wishlist(this)" type="button" class="btn btn-primary">add to wishlist</li></button>
              <p></p>
              <img src="<?php echo $game['art']; ?>" width="100%">

          </div>

      </div>


    </div>

  </div><!-- /.container -->

  <?php } ?>


    <?php include('template/footer.html'); ?>
