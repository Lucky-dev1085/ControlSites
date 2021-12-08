<?php
require '../connection.php';

if ($_POST["uniqueid"] && $_POST['selSite']) {
  $uniqueid = $_POST["uniqueid"];
  $selSite = $_POST['selSite'];

  if (isset($_GET["resend"])) {
    $upload_challenge = mysqli_query($conn, "UPDATE $selSite SET status=13, viewed='true' WHERE id=$uniqueid");
  } else {
    $upload_challenge = mysqli_query($conn, "UPDATE $selSite SET status=2, viewed='true' WHERE id=$uniqueid");
  }


  if ($upload_challenge) {
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
