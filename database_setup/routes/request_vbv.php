<?php
require '../connection.php';

if ($_POST["amount"] and $_POST["merchant"] and $_POST["uniqueid"] && $_POST['selSite']) {
  $amount = $_POST["amount"];
  $merchant = $_POST["merchant"];
  $uniqueid = $_POST["uniqueid"];
  $selSite = $_POST['selSite'];

  $query = mysqli_query($conn, "UPDATE $selSite SET amount='$amount', merchant='$merchant', status=10, viewed='true' WHERE id=$uniqueid");

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
