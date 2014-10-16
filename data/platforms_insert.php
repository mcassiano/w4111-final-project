<?php

$db = "(DESCRIPTION =
    (ADDRESS = (PROTOCOL = TCP)(HOST = w4111f.cs.columbia.edu)(PORT = 1521))
    (CONNECT_DATA =
      (SERVER = DEDICATED)
      (SERVICE_NAME = ADB)
    )
  )";
$conn = oci_connect("bag2136", "MrPotatoHead", $db);

$getPlatformsURL = "http://thegamesdb.net/api/GetPlatformsList.php";
$getPlatformURL = "http://thegamesdb.net/api/GetPlatform.php?id=";

$response_xml_data = file_get_contents($getPlatformsURL);
$data = simplexml_load_string($response_xml_data);
$platforms = $data->Platforms->Platform;

//$sql = "insert into Platform
//values (1, '$platform->name', 2, TIMESTAMP '1992-12-12 12:23:45', 'http://2.bp.blogspot.com/-qJn9oVQrj1o/UqAGHnSzzYI/AAAAAAAAANc/B_hWxzvXhig/s1600/PSX.png', 'None yet');


foreach ($platforms as $platform) {
  $response_xml_data = file_get_contents($getPlatformURL . $platform->id);
  $data = simplexml_load_string($response_xml_data);

  $img = $data->baseImgUrl.$data->Platform->Images->boxart;
  $name = $data->Platform->Platform;
  $rating = ($data->Platform->Rating) ? $data->Platform->Rating : 0;
  $desc = htmlspecialchars($data->Platform->overview);

  $sql = "insert into Platform values (1, '$name', $rating, TIMESTAMP '1992-12-12 12:23:45', '$img', '$desc')";

  //echo '<p>'.$sql.'</p>';

  $stid = oci_parse($conn, $sql);
  oci_execute($stid);

  $err = oci_error($stid);
  if ($err) {
    echo $sql;
  }

}

oci_commit($conn);
oci_close($conn);

?>
