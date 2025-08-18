<?php
  //untuk koneksi ke database
  session_start();
  include ("../../../koneksi.php");

  //proses delete
  $id_krit = $_GET['id_kriteria'];
  $sql     = "DELETE FROM tab_kriteria WHERE id_kriteria = '$id_krit' ";
  $hapus   = $koneksi->query($sql);

  if ($hapus) {
    echo "<script>alert('Hapus ID = ".$id_krit." Berhasil') </script>";
    echo "<script>window.location.href = \"kriteria.php\" </script>";
    
    $id_last = "SELECT id_kriteria FROM tab_kriteria ORDER BY id_kriteria DESC LIMIT 1";
    $sql2     = "ALTER TABLE tab_kriteria AUTO_INCREMENT='$id_last'";
    $alter   = $koneksi->query($sql2);
  } else {
    echo "Maaf Tidak Dapat Menghapus !";
  }
?>
