<?php
  //untuk koneksi ke database
    session_start();
    include ("../../../koneksi.php");

    //proses edit
    $id_perusahaan  = $_POST['id_perusahaan'];
    $nama_perusahaan = $_POST['nama_perusahaan'];

    // $ubah = mysql_query("UPDATE tab_kriteria SET nama_kriteria ='".$nama_kriteria."',bobot ='".$bobot."',status ='".$status."' WHERE id_kriteria='".$id_krit."' ");

    //Ini gw pake mysqli_query tadi elu pake mysql_query setau gw itu php5 gw coba pake yg mysqli bisa wkwkwk

    $query = "UPDATE tab_perusahaan SET nama_perusahaan ='$nama_perusahaan' WHERE id_perusahaan='$id_perusahaan' ";
    $result = mysqli_query($koneksi, $query);
    if ($result) {
        // code...
        echo "<script>alert('Ubah Data Dengan ID = ".$id_perusahaan." Berhasil') </script>";
        echo "<script>window.location.href = \"perusahaan.php\" </script>";
    } else {
        // code...
        echo "<script>alert Gagal </script>";
    }
?>
