<?php
require 'php_functions.php';

if (isset($_GET["disable_sound"])) {
  disable_sound();
  echo json_encode(array(
    'status' => 'disabled'
  ));
}

if (isset($_GET["enable_sound"])) {
  enable_sound();
  echo json_encode(array(
    'status' => 'enabled'
  ));
}

if (isset($_GET["check_sound_status"])) {
  $status = get_sound();
  echo json_encode(array(
    'status' => $status
  ));
}

?>
