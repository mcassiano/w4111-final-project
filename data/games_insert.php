<?php
require_once('include/connection.php');

$getGames = "http://thegamesdb.net/api/PlatformGames.php?platform=Sony%20Playstation%20Vita";
$getGame = "http://thegamesdb.net/api/GetGame.php?id=";

function genre_exists($name) {

  $sql = "select * from genre where name = '$name'";
  $db_connection->select($sql);
  if ($db_connection) {
    return TRUE;
  }
  else {
    return FALSE;
  }
}

function genre_insert($name) {

  $sql = "insert into genre values (1, '$name')";
  $db_connection->insert($sql);
}

$response_xml_data = file_get_contents($getGames);
$data = simplexml_load_string($response_xml_data);
foreach ($data as $game) {
  $response_xml_data = file_get_contents($getGame . $game->id);
  $data = simplexml_load_string($response_xml_data);

 // print_r($data);

  $img = $data->baseImgUrl.$data->Game->Images->boxart;
  $name = htmlspecialchars($data->Game->GameTitle);
  $rating = 0;
  $desc = htmlspecialchars($data->Game->Overview);
  $coop = ($data->Game->{'Co-op'} == 'No') ? 0 : 1;
  $release_date = $data->Game->ReleaseDate;

  $genres = $data->Game->Genres->genre;

  foreach ($genres as $key) {
    if (genre_exists($key)) {
      echo 'exists';
    }
    else {
      genre_insert($key);
    }
    
  }
  exit();

  $sql = "insert into Game VALUES (1,'$name',$rating,$coop,'$img',to_date('$release_date', 'mm/dd/yyyy'),'$desc')";
  $db_connection->insert($sql);

}

$db_connection->close();


?>
