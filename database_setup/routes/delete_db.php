<?php
require '../connection.php';

if (isset($_GET["single"])) {
  $uniqueid = $_POST["uniqueid"];
  $query = mysqli_query($conn, "DELETE FROM boi WHERE uniqueid=$uniqueid");
  if ($query) {
    echo json_encode(array(
      'status' => 'success'
    ));
  }
  die(0);
}

$query = mysqli_query($conn, "DELETE FROM boi");

if ($query) {
  echo json_encode(array(
    'status' => 'success'
  ));
} else {
  echo json_encode(array(
    'status' => 'failure',
    'error' => mysqli_error($conn)
  ));
}
?>
