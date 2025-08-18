<?php
  session_start();
  include ("../../../koneksi.php");

  if (isset($_POST['simpan'])) {
    $id_krit  = $_POST['id_krit'];
    $kriteria = $_POST['nm_krit'];
    $bobot    = $_POST['bobot'];
    $nilai    = $_POST['nilai'];
    $status    = $_POST['status'];
    $sql    = "SELECT * FROM tab_kriteria";
    $tambah = $koneksi->query($sql);

    if ($row = $tambah->fetch_row()) {
      $masuk = "INSERT INTO tab_kriteria (id_kriteria, nama_kriteria, bobot, nilai, status) VALUES ('".$id_krit."','".$kriteria."','".$bobot."','".$nilai."','".$status."')";
      $buat  = $koneksi->query($masuk);

      echo "<script>alert('Input Data Berhasil') </script>";
      echo "<script>window.location.href = \"kriteria.php\" </script>";
    }
  }

?>