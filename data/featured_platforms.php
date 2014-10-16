<?php
require_once('connection.php');
$sql = "select * from (select * from Platform order by rating desc) where ROWNUM <= 5";
$results = $db_connection->select($sql);
?>
<!doctype html>

<html lang="en">
<head>
  <meta charset="utf-8">

  <title>Game Gifter - Featured Platforms</title>
  <meta name="description" content="">
  <meta name="author" content="">
  <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.3/jquery.min.js"></script>

  <!--<link rel="stylesheet" href="css/styles.css?v=1.0">-->
  <!--[if lt IE 9]>
  <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
  <![endif]-->

  <script type="text/javascript">
    $.fn.stars = function() {
      return $(this).each(function() {
        $(this).html($('<span />').width(Math.max(0, (Math.min(5, parseFloat($(this).html())))) * 16));
      });
    }
  </script>
  <style type="text/css">

    body {

      font-family: Helvetica, Arial;
      font-size: 10pt;
    }

    #content {
      margin: 0 auto;
      width: 400px;
    }

    .game_art {
      padding: 0px;
      margin-right: 10px;
      margin-bottom: 5px;
    }

    span.stars, span.stars span {
      display: block;
      background: url(images/stars.png) 0 -16px repeat-x;
      width: 80px;
      height: 16px;
    }

    span.stars span {
      background-position: 0 0;
    }
  </style>

</head>

<body>
  <div id="content">
  <?php
    foreach($results as $platform) {
  ?>
  <div style="clear: both">
    <h3><?php echo $platform['name']; ?></h3>
    <p>
   <span class="stars"><?php echo $platform['rating']*5/10; ?></span></p>
   <script>$('span.stars').stars();</script>


   <img class="game_art" src="<?php echo $platform['art']; ?>" width="100px" align="left">

   <p>
     <?php echo html_entity_decode($platform['description']); ?>
   </p>
 </div>

  <?php
    }
  ?>
</div>
</body>
</html>


<?php
$db_connection->close();
?>
