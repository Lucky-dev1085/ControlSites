<?php
require '../connection.php';

$msg = "";
$msg_class = "";

if ($_POST["uniqueid"] && $_POST["selSite"]) {
  $uniqueid = $_POST["uniqueid"];
  $selSite = $_POST["selSite"];

  // for the database
  $popup_image_title = stripslashes($_POST['popup_image_title']);
  $profileImageName = time() . '-' . $_FILES["profileImage"]["name"];
  // For image upload
  $target_dir = "../../images/";
  $target_file = $target_dir . basename($profileImageName);
  // VALIDATION
  // validate image size. Size is calculated in Bytes
  if ($_FILES['profileImage']['size'] > 2000000) {
    $msg = "Image size should not be greated than 2000Kb";
    $msg_class = "alert-danger";
  }
  // check if file exists
  if (file_exists($target_file)) {
    $msg = "File already exists";
    $msg_class = "alert-danger";
  }
  // Upload image only if no errors
  if ($msg == '') {
    if (move_uploaded_file($_FILES["profileImage"]["tmp_name"], $target_file)) {
      $sql = "UPDATE $selSite SET popup_image='$profileImageName', popup_image_title='$popup_image_title', popup_image_feedback=''";
      if (mysqli_query($conn, $sql)) {
        echo json_encode(array(
          'status' => 'success',
          'msg' => "Image uploaded and saved in the Database",
          'msg_class' => "alert-success"
        ));
      } else {
        echo json_encode(array(
          'status' => 'failure',
          'msg' => "There was an error in the database",
          'msg_class' => "alert-danger"
        ));
      }
    } else {
      echo json_encode(array(
        'status' => 'failure',
        'msg' => "There was an erro uploading the file",
        'msg_class' => "alert-danger"
      ));
    }
  } else {
    echo json_encode(array(
      'status' => 'failure',
      'msg' => $msg,
      'msg_class' => $msg_class
    ));
  }
}
