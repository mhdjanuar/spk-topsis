<?php
$host = "127.0.0.1";
$user = "root";
$pass = "";
$db   = "spk-topsis";

$koneksi = mysqli_connect($host, $user, '', $db);
if (!$koneksi) {
  echo "Belum Terkoneksi";
}
?>