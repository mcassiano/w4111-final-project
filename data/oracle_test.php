<?php
require_once('connection.php');

$sql = "select * from Platform";
$results = $db_connection->select($sql);

?>
<?php foreach ($results as $result) { ?>
		<input type="checkbox" name="console" value="<?php echo $result['platform_id'];?>"><?php echo $result['name']; ?></input>
<? } ?>

<?
$db_connection->close();
?>
