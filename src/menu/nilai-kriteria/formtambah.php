<?php
  // koneksi ke database
  session_start();
  include ("../../../koneksi.php");

    // base path project
  $base = "/spk-topsis-web/";

  //pemberian kode id secara otomatis
  $carikode = $koneksi->query("SELECT id_kriteria FROM tab_kriteria") or die(mysqli_error());
  $datakode = $carikode->fetch_array();
  $jumlah_data = mysqli_num_rows($carikode);

  if ($datakode) {
    if (isset($jumlah_data[0]) && is_string($jumlah_data[0])) {
        $nilaikode = substr($jumlah_data[0], 1);
    } else {
        $nilaikode = '';
    }
    $kode = (int) $nilaikode;
    $kode = $jumlah_data + 1;
    $kode_otomatis = str_pad($kode, 0, STR_PAD_LEFT);
  } else {
    $kode_otomatis = "1";
  }
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>LatarOutdoor | Beranda</title>

    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
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
                <img src="../../../public/style/img/pencatatan-logo.png" alt="LatarOutdoor Logo"
                    class="brand-image img-circle elevation-3">
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
                <a href="<?php echo $base; ?>src/data-master/kriteria/kriteria.php" class="nav-link">
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
                <a href="<?php echo $base; ?>src/menu/nilai-kriteria/nilmat.php" class="nav-link active">
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
                            <h1 class="m-0"><b>Input Penilaian</b></h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="../../../index.php">Beranda</a></li>
                                <li class="breadcrumb-item active">Input Penilaian</li>
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
                                Form Penilaian
                            </h3>
                        </div>
                        <div class="card-body">
                            <form class="form" action="fungsitambah.php" method="post">
                                <div class="form-group">
                                    <select class="form-control" name="alter">
                                        <option>Nama Perusahaan</option>
                                        <?php
                                        //ambil data dari database
                                        $nama = $koneksi->query('SELECT * FROM tab_perusahaan ORDER BY id_perusahaan ASC');
                                        while ($datalter = $nama->fetch_array())
                                        {
                                            echo "<option value=\"$datalter[id_perusahaan]\">$datalter[nama_perusahaan]</option>\n";
                                        }
                                        ?>
                                    </select>
                                </div>
                                <?php
                                // Fetch data from the database
                                $krit = $koneksi->query('SELECT * FROM tab_kriteria ORDER BY bobot DESC');
                                $current_selections = [
                                    1 => 1,
                                    2 => 2,
                                    3 => 3,
                                    4 => 4,
                                    5 => 5,
                                ];
                                ?>

                                <div class="row">
                                    <?php while ($datakrit = $krit->fetch_array()): ?>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="krit_<?php echo $datakrit['id_kriteria']; ?>">
                                                    <?php echo $datakrit['alias']; ?> - <?php echo $datakrit['nama_kriteria']; ?>
                                                </label>
                                                <select class="form-control" id="krit_<?php echo $datakrit['id_kriteria']; ?>" name="krit[]">
                                                    <?php
                                                    // For each kriteria, generate the options based on bobot and status
                                                    $options = $koneksi->query('SELECT * FROM tab_kriteria ORDER BY bobot DESC');
                                                    // while ($option = $options->fetch_array()) {
                                                    //     echo "<option value=\"{$option['id_kriteria']}\">{$option['alias']}</option>\n";
                                                    // }
                                                    while ($option = $options->fetch_array()) {
                                                        // Check if the current option is selected
                                                        $selected = ($option['id_kriteria'] == ($current_selections[$datakrit['id_kriteria']] ?? null)) ? 'selected' : '';
                                                        echo "<option value=\"{$option['id_kriteria']}\" $selected>{$option['alias']}</option>\n";
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="nilai_<?php echo $datakrit['id_kriteria']; ?>">
                                                    Nilai untuk <?php echo $datakrit['alias']; ?>
                                                </label>
                                                <select class="form-control" id="nilai_<?php echo $datakrit['id_kriteria']; ?>" name="nilai[]">
                                                    <option value="">Nilai</option>
                                                    <?php
                                                    // Fetch and display nilai options
                                                    $nilaiOptions = $koneksi->query('SELECT * FROM tab_kriteria ORDER BY bobot DESC');
                                                    while ($nilaiOption = $nilaiOptions->fetch_array()) {
                                                        echo "<option value=\"{$nilaiOption['nilai']}\">{$nilaiOption['bobot']} - {$nilaiOption['status']}</option>\n";
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    <?php endwhile; ?>
                                </div>

                                <div class="form-group float-right">
                                    <a href="<?php echo $base; ?>src/menu/nilai-kriteria/nilmat.php" class="btn btn-danger">
                                        Batal
                                    </a>
                                    <input type="submit" class="btn btn-success">
                                </div>
                            </form>
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