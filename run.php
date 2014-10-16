<?php
include('include/connection.php');
?>

<form method="post" action="">
<textarea name="query" style="width: 300px; height: 200px;">
</textarea>
<p>
<input type="submit" value="Run"></input>
</form>

<?php
if (isset($_POST['query'])) {
  echo '<pre>';
  print_r($db_connection->select($_POST['query']));
  echo '</pre>';
}
?>