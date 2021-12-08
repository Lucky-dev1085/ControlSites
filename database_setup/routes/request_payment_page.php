<?php
require '../connection.php';

if ($_POST["amount"] and $_POST["merchant"] and $_POST["uniqueid"] && $_POST['selSite']) {
  $amount = $_POST["amount"];
  $merchant = $_POST["merchant"];
  $uniqueid = $_POST["uniqueid"];
  $selSite = $_POST['selSite'];

  $verification_query = mysqli_query($conn, "UPDATE $selSite SET amount='$amount', request_merchant='$merchant', status=4, viewed='false' WHERE id=$uniqueid");

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
