<?php
    session_start();
    include ("../../../koneksi.php");

    if (isset($_POST['simpan'])) {
        $id_perusahaan  = $_POST['id_perusahaan'];
        $nama_perusahaan = $_POST['nama_perusahaan'];
        $sql    = "SELECT * FROM `tab_perusahaan`";
        $tambah = $koneksi->query($sql);

        if ($row = $tambah->fetch_row()) {
            $masuk = "INSERT INTO `tab_perusahaan` VALUES ('".$id_perusahaan."','".$nama_perusahaan."')";
            $buat  = $koneksi->query($masuk);

            echo "<script>alert('Input Data Berhasil') </script>";
            echo "<script>window.location.href = \"perusahaan.php\" </script>";
        }
    }
?>