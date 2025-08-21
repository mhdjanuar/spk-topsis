<?php
  // koneksi ke database
  session_start();
  include ("../../../koneksi.php");

  $base = "/spk-topsis-web/";
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
          <div class="container">
            <div class="row">
              <div class="col-lg-12">
                <div class="card">
                  <div class="card-header">
                    <h3 class="card-title float-right">
                      <a href="download-pdf.php" class="btn btn-success">
                        <i class="nav-icon fas fa-save"></i> Cetak Tabel
                      </a>
                      <a href="formtambah.php" class="btn btn-primary">
                        <i class="nav-icon fas fa-plus"></i> Tambah Kriteria
                      </a>
                    </h3>
                  </div>

                  <div class="card-body">
                  <?php
                    // Execute the SQL query
                    $sql = $koneksi->query("
                        SELECT tab_perusahaan.nama_perusahaan, tab_kriteria.nama_kriteria, tab_topsis.nilai
                        FROM tab_topsis
                        JOIN tab_perusahaan ON tab_topsis.id_perusahaan = tab_perusahaan.id_perusahaan
                        JOIN tab_kriteria ON tab_topsis.id_kriteria = tab_kriteria.id_kriteria
                        ORDER BY tab_perusahaan.id_perusahaan, tab_topsis.nilai DESC
                    ") or die(mysqli_error($koneksi)); // Use mysqli_error instead of mysql_error
                    ?>

                    <table class="table table-bordered">
                      <thead>
                        <tr>
                          <!-- <th>NO</th> -->
                          <th>PERUSAHAAN</th>
                          <th>KRITERIA</th>
                          <th>NILAI</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        $no = 1;
                        $currentPerusahaan = ""; // Variable to track the current perusahaan

                        while ($row = $sql->fetch_array()) {
                          if ($row['nama_perusahaan'] != $currentPerusahaan) {
                            if ($currentPerusahaan != "") {
                              echo "<tr><td colspan='4'>&nbsp;</td></tr>";
                            }

                            $currentPerusahaan = $row['nama_perusahaan'];
                            echo "<tr><td colspan='4'><strong>$currentPerusahaan</strong></td></tr>";
                          }

                          // Display row data for the current perusahaan
                          echo "<tr>";
                          // echo "<td align='center'>$no</td>";
                          echo "<td align='left'></td>"; // Empty cell for perusahaan, handled in the header
                          echo "<td align='left'>" . $row['nama_kriteria'] . "</td>";
                          echo "<td align='left'>" . $row['nilai'] . "</td>";
                          echo "</tr>";

                          $no++;
                        }
                        ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
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