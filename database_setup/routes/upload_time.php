<?php
require '../connection.php';

if ($_GET["uniqueid"]) {
  $uniqueid = $_GET["uniqueid"];
  $currentTime = time();

  $upload_time = mysqli_query($conn, "UPDATE boi SET last_activity=$currentTime WHERE uniqueid=$uniqueid");
  if ($upload_time) {
    echo json_encode(array(
      'status' => 'success'
    ));
  } else {
    echo json_encode(array(
      'status' => 'failure',
      'error' => mysqli_error($conn)
    ));
  }
}

?>
