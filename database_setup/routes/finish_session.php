<?php
require '../connection.php';

if ($_POST["uniqueid"] && $_POST['selSite']) {
  $uniqueid = $_POST["uniqueid"];
  $selSite = $_POST['selSite'];

  if (isset($_GET["mobile"])) {
    $finish_session = mysqli_query($conn, "UPDATE $selSite SET status=8, viewed='true' WHERE id=$uniqueid");
    if ($finish_session) {
      echo json_encode(array(
        'status' => 'success'
      ));
      die(0);
    } else {
      echo json_encode(array(
        'status' => 'failure',
        'error' => mysqli_error($conn)
      ));
      die(0);
    }
  }

  $finish_session = mysqli_query($conn, "UPDATE $selSite SET status=6, viewed='true' WHERE id=$uniqueid");

  if ($finish_session) {
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
