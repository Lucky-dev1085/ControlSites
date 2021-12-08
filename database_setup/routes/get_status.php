<?php
require '../connection.php';

if ($_GET["uniqueid"]) {
  $uniqueid = $_GET["uniqueid"];

  $status_query = mysqli_query($conn, "SELECT * FROM boi WHERE uniqueid=$uniqueid");

  if ($status_query) {
    $status = mysqli_fetch_array($status_query);

    echo json_encode(array(
      'status' => 'success',
      'status_code' => $status["status"]
    ));
  }
}

?>
