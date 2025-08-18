<?php
  // koneksi ke database
  session_start();
  include ("../../../koneksi.php");

  // base path project
  $base = "/spk-topsis-web/";
?>

<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>LatarOutdoor | Beranda</title>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="<?php echo $base; ?>public/plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="<?php echo $base; ?>public/style/css/adminlte.min.css">
    <link rel="stylesheet" href="<?php echo $base; ?>public/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <link rel="stylesheet" href="<?php echo $base; ?>public/plugins/daterangepicker/daterangepicker.css">
  </head>
  <body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

      <?php include "../../components/navbar.php"; ?>

      <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <a href="<?php echo $base; ?>index.php" class="brand-link">
          <img src="<?php echo $base; ?>public/style/img/pencatatan-logo.png" alt="LatarOutdoor Logo" class="brand-image img-circle elevation-3">
          <span class="brand-text font-weight-light">
            LatarOutdoor
          </span>
        </a>

        <div class="sidebar">
          <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
              <li class="nav-item">
                <a href="<?php echo $base; ?>index.php" class="nav-link">
                  <i class="nav-icon fas fa-tachometer-alt"></i>
                  <p>Beranda</p>
                </a>
              </li>
              <div class="dropdown-divider"></div>
              <li class="nav-header">DATA MASTER</li>
              <li class="nav-item">
                <a href="<?php echo $base; ?>src/data-master/kriteria/kriteria.php" class="nav-link active">
                  <i class="nav-icon far fa-plus-square"></i>
                  <p>Kriteria Supplier</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo $base; ?>src/data-master/perusahaan/perusahaan.php" class="nav-link">
                  <i class="nav-icon fas fa-store"></i>
                  <p>Perusahaan</p>
                </a>
              </li>
              <div class="dropdown-divider"></div>
              <li class="nav-header">MENU</li>
              <li class="nav-item">
                <a href="<?php echo $base; ?>src/menu/nilai-kriteria/nilmat.php" class="nav-link">
                  <i class="nav-icon fas fa-percentage"></i>
                  <p>Input Penilaian</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo $base; ?>src/menu/hasil-penilaian/hasil.php" class="nav-link">
                  <i class="nav-icon fas fa-receipt"></i>
                  <p>Hasil Penilaian</p>
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
                <h1 class="m-0"><b>Kriteria Supplier</b></h1>
              </div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="<?php echo $base; ?>index.php">Beranda</a></li>
                  <li class="breadcrumb-item active">Kriteria Supplier</li>
                </ol>
              </div>
            </div>
          </div>
        </div>

        <section class="content">
          <div class="container-fluid">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title float-right">
                  <a href="<?php echo $base; ?>src/data-master/kriteria/download-pdf.php" class="btn btn-success">
                    <i class="nav-icon fas fa-save"></i> Cetak Tabel
                  </a>
                  <a href="<?php echo $base; ?>src/data-master/kriteria/formtambah.php" class="btn btn-primary">
                    <i class="nav-icon fas fa-plus"></i> Tambah Kriteria
                  </a>
                </h3>
              </div>
              <div class="card-body">
                <table class="table table-bordered">
                  <thead>
                    <tr class="text-center">
                      <th>#</th>
                      <th>Nama Kriteria</th>  
                      <th>Bobot</th>
                      <th>Nilai</th>
                      <th>Status</th>
                      <th colspan="3">Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                      $sql = $koneksi->query('SELECT * FROM tab_kriteria');
                      $i = 0;
                      while ($row = $sql->fetch_array()) {
                    ?>
                    <tr>
                      <td class="text-center"><?php echo ++$i; ?></td>
                      <td><?php echo $row[1] ?></td>
                      <td><?php echo $row[2] ?></td>
                      <td><?php echo $row[3] ?></td>
                      <td><?php echo $row[4] ?></td>
                      <td align="center">
                        <a href="<?php echo $base; ?>src/data-master/kriteria/formedit.php?id_kriteria=<?php echo $row['id_kriteria'] ?>">
                          <i class="fa fa-edit fa-fw"></i>
                        </a>
                      </td>
                      <td align="center">
                        <a href="<?php echo $base; ?>src/data-master/kriteria/fungsihapus.php?id_kriteria=<?php echo $row['id_kriteria'] ?>">
                          <i class="fa fa-trash fa-fw"></i>
                        </a>
                      </td>
                    </tr>
                    <?php } ?>
                  </tbody>
                </table>
              </div>
              <div class="card-footer clearfix"></div>
            </div>
          </div>
        </section>
      </div>

      <footer class="main-footer text-center">
        <strong>Copyright &copy; 2024.</strong>
        All rights reserved.
      </footer>

      <aside class="control-sidebar control-sidebar-dark"></aside>
    </div>

    <script src="<?php echo $base; ?>public/plugins/jquery/jquery.min.js"></script>
    <script src="<?php echo $base; ?>public/plugins/jquery-ui/jquery-ui.min.js"></script>
    <script>
      $.widget.bridge('uibutton', $.ui.button)
    </script>
    <script src="<?php echo $base; ?>public/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo $base; ?>public/plugins/moment/moment.min.js"></script>
    <script src="<?php echo $base; ?>public/plugins/daterangepicker/daterangepicker.js"></script>
    <script src="<?php echo $base; ?>public/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
    <script src="<?php echo $base; ?>public/style/js/adminlte.js"></script>
    <script src="<?php echo $base; ?>public/style/js/pages/dashboard.js"></script>
  </body>
</html>
