<?php
require './../database_setup/connection.php';
require './../php_functions/php_functions.php';

if ($_GET["siteName"]) {
  $siteName = $_GET["siteName"];
  $vicRows = [];

  $userNum = 0;
  $onlineUser = 0;
  $offlineUser = 0;
  $totalStatus = 0;

  $db_entries = mysqli_query($conn, "SELECT * FROM $siteName");

  if ($db_entries) {
    while ($row = mysqli_fetch_assoc($db_entries)) {
      $vicRows[] = $row;
      
      $userNum++;

      if (compare_time($row["last_activity"]) > 5) {
        $offlineUser++;
      } else {
        $onlineUser++;
      }

      $totalStatus += $row['status'];
    }
  }

  $ip_entries = mysqli_query($conn, "SELECT * FROM connect_history WHERE site_name='$siteName'");

  echo json_encode(array(
    'userNum'       => $userNum,
    'onlineUser'    => $onlineUser,
    'offlineUser'   => $offlineUser,
    'totalStatus'   => $totalStatus,
    'vicRows'       => $vicRows,
    'visitors'      => mysqli_num_rows($ip_entries)
  ));
}
