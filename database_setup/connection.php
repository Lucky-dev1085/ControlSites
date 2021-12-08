<?php
require 'config.php';

$conn = mysqli_connect($servername, $username, $password, $database);

if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

if (!function_exists('mysqli_fetch_all')) {
    function mysqli_fetch_all(mysqli_result $result) {
        $data = [];
        while ($data[] = $result->fetch_assoc()) {}
        return $data;
    }
}
?>
