<?php
  // koneksi ke database
  session_start();

  if (!isset($_SESSION['username'])) {
    header("Location: src/auth/login.php");
    exit();
  }
  include "koneksi.php";

  $username = $_SESSION['username'];

  $tampil = $koneksi->query("SELECT b.nama_perusahaan,c.nama_kriteria,a.nilai,c.bobot,c.status
        FROM
          tab_topsis a
          JOIN
            tab_perusahaan b USING(id_perusahaan)
          JOIN
            tab_kriteria c USING(id_kriteria)");

  $data = array();
  $kriterias = array();
  $bobot = array();
  $nilai_kuadrat = array();
  $status = array();

  if ($tampil) {
    while($row = $tampil->fetch_object()){
      if(!isset($data[$row->nama_perusahaan])){
        $data[$row->nama_perusahaan]=array();
      }
      if(!isset($data[$row->nama_perusahaan][$row->nama_kriteria])){
        $data[$row->nama_perusahaan][$row->nama_kriteria]=array();
      }
      if(!isset($nilai_kuadrat[$row->nama_kriteria])){
        $nilai_kuadrat[$row->nama_kriteria]=0;
      }
      $bobot[$row->nama_kriteria]=$row->bobot;
      $data[$row->nama_perusahaan][$row->nama_kriteria]=$row->nilai;
      $nilai_kuadrat[$row->nama_kriteria]+=pow($row->nilai,2);
      $kriterias[]=$row->nama_kriteria;
      $status[$row->nama_kriteria]=$row->status;
    }
  }

  $kriteria     = array_unique($kriterias);
  $jml_kriteria = count($kriteria);
?>

<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>LatarOutdoor | Beranda</title>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="public/plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="public/style/css/adminlte.min.css">
    <link rel="stylesheet" href="public/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <link rel="stylesheet" href="public/plugins/daterangepicker/daterangepicker.css">
  </head>
  <body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

      <?php include "./src/components/navbar.php"; ?>

      <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <a href="#" class="brand-link">
          <img src="public/style/img/pencatatan-logo.png" alt="LatarOutdoor Logo" class="brand-image img-circle elevation-3">
          <span class="brand-text font-weight-light">
            LatarOutdoor
          </span>
        </a>

        <div class="sidebar">
          <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
              <li class="nav-item">
                <a href="#" class="nav-link active">
                  <i class="nav-icon fas fa-tachometer-alt"></i>
                  <p>
                    Beranda
                  </p>
                </a>
              </li>
              <div class="dropdown-divider"></div>
              <li class="nav-header">DATA MASTER</li>
              <li class="nav-item">
                <a href="src/data-master/kriteria/kriteria.php" class="nav-link">
                  <i class="nav-icon far fa-plus-square"></i>
                  <p>
                    Kriteria Supplier
                  </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="src/data-master/perusahaan/perusahaan.php" class="nav-link">
                  <i class="nav-icon fas fa-store"></i>
                  <p>
                    Perusahaan
                  </p>
                </a>
              </li>
              <div class="dropdown-divider"></div>
              <li class="nav-header">MENU</li>
              <li class="nav-item">
                <a href="src/menu/nilai-kriteria/nilmat.php" class="nav-link">
                  <i class="nav-icon fas fa-percentage"></i>
                  <p>
                    Input Penilaian
                  </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="src/menu/hasil-penilaian/hasil.php" class="nav-link">
                  <i class="nav-icon fas fa-receipt"></i>
                  <p>
                    Hasil Penilaian
                  </p>
                </a>
              </li>
            </ul>
          </nav>
        </div>
      </aside>

      <div class="content-wrapper">
        <div class="content-header">
          <div class="container-fluid">
            <div class="row mb-2">
              <div class="col-sm-6">
                <h1 class="m-0"><b>Beranda</b></h1>
              </div>
              <!-- <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="#">Home</a></li>
                  <li class="breadcrumb-item active">Beranda</li>
                </ol>
              </div> -->
            </div>
          </div>
        </div>

        <section class="content">
          <div class="container">
            <img src="public/style/img/banner.png" width="1100">
          </div>
        </section>

      </div>

      <footer class="main-footer text-center">
        <strong>Copyright &copy; 2024.</strong>
        All rights reserved.
      </footer>

      <aside class="control-sidebar control-sidebar-dark">
      </aside>
    </div>

    <script src="public/plugins/jquery/jquery.min.js"></script>
    <script src="public/plugins/jquery-ui/jquery-ui.min.js"></script>
    <script>
      $.widget.bridge('uibutton', $.ui.button)
    </script>
    <script src="public/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="public/plugins/moment/moment.min.js"></script>
    <script src="public/plugins/daterangepicker/daterangepicker.js"></script>
    <script src="public/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
    <script src="public/style/js/adminlte.js"></script>
    <script src="public/style/js/pages/dashboard.js"></script>
  </body>
</html>