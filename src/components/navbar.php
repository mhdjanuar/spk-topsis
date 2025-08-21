<?php
// Base URL project
$base_url = "http://localhost/spk-topsis-web/";

// cek login
if (!isset($_SESSION['username'])) {
    header("Location: " . $base_url . "src/auth/login.php");
    exit();
}

// ambil username dari session
$username = $_SESSION['username'];

// kalau user klik logout
if (isset($_GET['logout'])) {
    session_unset();
    session_destroy();
    header("Location: " . $base_url . "src/auth/login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Dashboard - SPK Supplier Petshop</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- AdminLTE + Bootstrap -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body class="hold-transition sidebar-mini layout-fixed">

<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button">
                <i class="fas fa-bars"></i>
            </a>
        </li>
    </ul>

    <!-- Right navbar -->
    <ul class="navbar-nav ml-auto">
        <!-- User dropdown -->
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                Welcome, <?= htmlspecialchars($username); ?> <i class="fas fa-caret-down"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-right">
                <a href="<?= $base_url ?>index.php?logout=1" class="dropdown-item">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
            </div>
        </li>

        <!-- Fullscreen -->
        <li class="nav-item">
            <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                <i class="fas fa-expand-arrows-alt"></i>
            </a>
        </li>
    </ul>
</nav>
<!-- /.navbar -->