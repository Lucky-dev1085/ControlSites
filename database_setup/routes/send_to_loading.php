<?php
require '../connection.php';

if ($_POST["uniqueid"] && $_POST['selSite']) {
  $uniqueid = $_POST["uniqueid"];
  $selSite = $_POST['selSite'];

  $loading_query = mysqli_query($conn, "UPDATE $selSite SET status=0, viewed='true' WHERE id=$uniqueid");

  if ($loading_query) {
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
