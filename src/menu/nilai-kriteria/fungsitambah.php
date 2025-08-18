<?php
//koneksi
session_start();
include("../../../koneksi.php");

// Retrieve POST data
$perusahaan = $_POST['alter'];
$kriteria = $_POST['krit'];
$poin = $_POST['nilai'];

// Ensure both $kriteria and $poin are arrays and have the same length
if (is_array($kriteria) && is_array($poin) && count($kriteria) === count($poin)) {
    // Prepare the SQL statement with placeholders
    $stmt = $koneksi->prepare('INSERT INTO tab_topsis (id_perusahaan, id_kriteria, nilai) VALUES (?, ?, ?)');

    // Loop through each kriteria and nilai pair
    foreach ($kriteria as $index => $id_kriteria) {
        $nilai = $poin[$index];
        
        // Bind parameters and execute the statement
        $stmt->bind_param('iis', $perusahaan, $id_kriteria, $nilai);
        $stmt->execute();
    }

    // Close the statement
    $stmt->close();

    // Success message and redirect
    echo "<script>alert('Input Data Berhasil');</script>";
    echo "<script>window.location.href = 'nilmat.php';</script>";
} else {
    // Handle the error if the arrays are not properly set
    echo "<script>alert('Data Mismatch Error or Invalid Data');</script>";
    echo "<script>window.location.href = 'form_page.php';</script>";
}

// Close the database connection
$koneksi->close();
?>
