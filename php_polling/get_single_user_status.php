<?php
require '../database_setup/connection.php';

if ($_POST["uniqueid"] and $_POST["load_status"] != "" && $_POST['selSite']) {
  $load_status = $_POST["load_status"];
  $uniqueid = $_POST["uniqueid"];
  $current_status = 0;
  $selSite = $_POST['selSite'];

  $get_status = mysqli_query($conn, "SELECT status FROM $selSite WHERE id=$uniqueid");

  if ($get_status) {

    $array = mysqli_fetch_array($get_status);
    $current_status = $array["status"];

    if ($current_status != $load_status) {
      echo json_encode(array(
        'status' => 'reload'
      ));
    } else {
      echo json_encode(array(
        'status' => 'nil'
      ));
    }
  } else {
    echo json_encode(array(
      'failure' => mysqli_error($conn)
    ));
  }
}
?>
