<?php
  // koneksi ke database
  session_start();
  include ("../../../koneksi.php");

     // base path project
  $base = "/spk-topsis-web/";

  //perintah untuk menampilkan hasil edit
  $id_krit  = $_GET['id_kriteria'];
  $kriteria = $koneksi->query("SELECT * FROM tab_kriteria WHERE id_kriteria = '$id_krit' ");

  while ($row = $kriteria->fetch_row()) {
    $nama_kriteria  = $row[1];
    $bobot = $row[2];
    $nilai = $row[3];
    $status = $row[4];
  }
?>

<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>LatarOutdoor | Beranda</title>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="../../../public/plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="../../../public/style/css/adminlte.min.css">
    <link rel="stylesheet" href="../../../public/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <link rel="stylesheet" href="../../../public/plugins/daterangepicker/daterangepicker.css">
  </head>
  <body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

      <?php include "../../components/navbar.php"; ?>

      <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <a href="#" class="brand-link">
          <img src="../../../public/style/img/pencatatan-logo.png" alt="LatarOutdoor Logo" class="brand-image img-circle elevation-3">
          <span class="brand-text font-weight-light">
            LatarOutdoor
          </span>
        </a>

        <div class="sidebar">
          <!-- <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
              <img src="../../../public/style/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
              <a href="#" class="d-block">Alexander Pierce</a>
            </div>
          </div> -->

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
                  <li class="breadcrumb-item"><a href="../../../index.php">Beranda</a></li>
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
                <h3 class="card-title float-left">
                  Form Edit Kriteria
                </h3>
              </div>
              <div class="card-body">
                <form class="form" action="fungsiedit.php" method="post">
                  <input class="form-control" type="text" name="id_kriteria" value="<?php echo $_GET['id_kriteria']; ?>" hidden />
                  <div class="form-group">
                    <label for="nm_krit">Isi Nama Kriteria:</label>  
                    <input class="form-control" type="text" name="nama_kriteria" placeholder="Nama Kriteria" value="<?php echo $nama_kriteria; ?>">
                  </div>
                  <div class="form-group">
                    <label for="bobot">Isi Bobot Kriteria:</label>  
                    <input class="form-control" type="text" name="bobot" placeholder="Bobot" value="<?php echo $bobot; ?>">
                  </div>
                  <div class="form-group">
                    <label for="nilai">Isi Nilai Kriteria:</label>  
                    <input class="form-control" type="text" name="nilai" placeholder="Nilai" value="<?php echo $nilai; ?>">
                  </div>
                  <div class="form-group">
                    <label for="status">Isi Status Kriteria:</label>  
                    <input class="form-control" type="text" name="status" placeholder="Status" value="<?php echo $status; ?>">
                  </div>
                  <div class="form-group float-right">
                    <a href="<?php echo $base; ?>src/data-master/kriteria/kriteria.php" class="btn btn-danger">
                      Batal
                    </a>
                    <input class="btn btn-success" type="submit" name="simpan" value="Ubah">
                  </div>
                </form>
              </div>
              <div class="card-footer clearfix"></div>
            </div>
          </div>
        </section>
      </div>


      <aside class="control-sidebar control-sidebar-dark">
      </aside>
    </div>

    <script src="../../../public/plugins/jquery/jquery.min.js"></script>
    <script src="../../../public/plugins/jquery-ui/jquery-ui.min.js"></script>
    <script>
      $.widget.bridge('uibutton', $.ui.button)
    </script>
    <script src="../../../public/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../../../public/plugins/moment/moment.min.js"></script>
    <script src="../../../public/plugins/daterangepicker/daterangepicker.js"></script>
    <script src="../../../public/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
    <script src="../../../public/style/js/adminlte.js"></script>
    <script src="../../../public/style/js/pages/dashboard.js"></script>
  </body>
</html>