<?php
  //untuk koneksi ke database
  session_start();
  include ("../../../koneksi.php");

  //proses delete
  $id_perusahaan = $_GET['id_perusahaan'];
  $sql     = "DELETE FROM tab_perusahaan WHERE id_perusahaan = '$id_perusahaan' ";
  $hapus   = $koneksi->query($sql);

  if ($hapus) {
    echo "<script>alert('Hapus ID = ".$id_perusahaan." Berhasil') </script>";
    echo "<script>window.location.href = \"perusahaan.php\" </script>";
    
    $id_last = "SELECT id_perusahaan FROM tab_perusahaan ORDER BY id_perusahaan DESC LIMIT 1";
    $sql2     = "ALTER TABLE tab_perusahaan AUTO_INCREMENT='$id_last'";
    $alter   = $koneksi->query($sql2);
  } else {
    echo "Maaf Tidak Dapat Menghapus !";
  }
?>
