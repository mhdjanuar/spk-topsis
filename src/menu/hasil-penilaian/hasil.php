<?php
  // koneksi ke database
  session_start();

  include "../../../koneksi.php";

  $base = "/spk-topsis-web/";

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
              <img src="public/style/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
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
                <a href="<?php echo $base; ?>src/menu/nilai-kriteria/nilmat.php" class="nav-link">
                  <i class="nav-icon fas fa-percentage"></i>
                  <p>Input Penilaian</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo $base; ?>src/menu/hasil-penilaian/hasil.php" class="nav-link active">
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
                <h1 class="m-0"><b>Hasil Penilaian</b></h1>
              </div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="#">Home</a></li>
                  <li class="breadcrumb-item active">Hasil Penilaian</li>
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
                    Evaluasi Matriks (x<sub>ij</sub>)
                    <a href="pdf/evaluation-pdf.php" class="btn btn-success float-right">
                      <i class="nav-icon fas fa-save"></i> Cetak Tabel
                    </a>
                  </div>
                  <div class="card-body">
                    <table class="table table-striped table-bordered table-hover">
                      <thead>
                        <tr>
                          <th rowspan='2'>No</th>
                          <th rowspan='2'>Nama Perusahaan</th>
                          <th colspan='<?php echo $jml_kriteria;?>'>Kriteria</th>
                        </tr>
                        <tr>
                          <?php
                          foreach($kriteria as $k)
                            echo "<th>$k</th>\n";
                          ?>
                        </tr>
                      </thead>
                      <tbody>
                        <?php 
                          $i=0; 
                          foreach($data as $nama=>$krit) {
                          echo "<tr>
                            <td>".(++$i)."</td>
                            <td>$nama</td>";
                          foreach($kriteria as $k){
                            echo "<td align='center'>" . (isset($krit[$k]) ? $krit[$k] : '-') . "</td>";
                          }
                          echo "</tr>\n";
                        }
                        ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-lg-12 mt-3">
                <div class="card">
                  <div class="card-header">
                    Rating Kinerja Ternormalisasi (r<sub>ij</sub>)
                    <a href="pdf/kinerja-pdf.php" class="btn btn-success float-right">
                      <i class="nav-icon fas fa-save"></i> Cetak Tabel
                    </a>
                  </div>
                  <div class="card-body">
                    <table class="table table-striped table-bordered table-hover">
                      <thead>
                        <tr>
                          <th rowspan='2'>No</th>
                          <th rowspan='2'>Nama Perusahaan</th>
                          <th colspan='<?php echo $jml_kriteria;?>'>Kriteria</th>
                        </tr>
                        <tr>
                          <?php
                          foreach($kriteria as $k)
                            echo "<th>$k</th>\n";
                          ?>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        $i=0;
                        foreach($data as $nama=>$krit){
                          echo "<tr>
                            <td>".(++$i)."</td>
                            <td>{$nama}</td>";
                          foreach($kriteria as $k){
                            $value = isset($krit[$k]) && isset($nilai_kuadrat[$k]) 
                            ? round(($krit[$k] / sqrt($nilai_kuadrat[$k])), 4) 
                            : '-';
                            echo "<td align='center'>{$value}</td>";
                          }
                          echo "</tr>\n";
                        }
                        ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-lg-12 mt-3">
                <div class="card">
                  <div class="card-header">
                    Rating Bobot Ternormalisasi(y<sub>ij</sub>)
                    <a href="pdf/bobot-pdf.php" class="btn btn-success float-right">
                      <i class="nav-icon fas fa-save"></i> Cetak Tabel
                    </a>
                  </div>
                  <div class="card-body">
                    <table class="table table-striped table-bordered table-hover">
                      <thead>
                        <tr>
                          <th rowspan='2'>No</th>
                          <th rowspan='2'>Nama Perusahaan</th>
                          <th colspan='<?php echo $jml_kriteria;?>'>Kriteria</th>
                        </tr>
                        <tr>
                          <?php
                          foreach($kriteria as $k)
                            echo "<th>$k</th>\n";
                          ?>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        $i=0;
                        $y=array();
                        foreach($data as $nama=>$krit){
                          echo "<tr>
                            <td>".(++$i)."</td>
                            <td>{$nama}</td>";
                          foreach($kriteria as $k){
                            // $y[$k][$i-1]=round(($krit[$k]/sqrt($nilai_kuadrat[$k])),4)*$bobot[$k];
                            // echo "<td align='center'>".$y[$k][$i-1]."</td>";
                            if (isset($krit[$k]) && isset($nilai_kuadrat[$k]) && isset($bobot[$k])) {
                              $y[$k][$i-1] = round(($krit[$k] / sqrt($nilai_kuadrat[$k])), 4) * $bobot[$k];
                              echo "<td align='center'>" . $y[$k][$i-1] . "</td>";
                            } else {
                                // Handle the case where any key doesn't exist, for example, by setting a default value or skipping.
                                $y[$k][$i-1] = '-';
                                echo "<td align='center'>-</td>";
                            }
                          }
                          echo "</tr>\n";
                        }
                        ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-lg-12 mt-3">
                <div class="card">
                  <div class="card-header">
                    Solusi Ideal positif (A<sup>+</sup>)
                    <a href="pdf/solusi-positif.php" class="btn btn-success float-right">
                      <i class="nav-icon fas fa-save"></i> Cetak Tabel
                    </a>
                  </div>
                  <div class="card-body">
                    <table class="table table-striped table-bordered table-hover">
                      <thead>
                        <tr>
                          <th colspan='<?php echo $jml_kriteria;?>'>Kriteria</th>
                        </tr>
                        <tr>
                          <?php
                          foreach($kriteria as $k)
                            echo "<th>$k</th>\n";
                          ?>
                        </tr>
                        <tr>
                          <?php
                          for($n=1;$n<=$jml_kriteria;$n++)
                            echo "<th>y<sub>{$n}</sub><sup>+</sup></th>";
                          ?>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <?php
                          $yplus=array();
                          foreach($kriteria as $k){
                            $yplus[$k]=($status[$k]=='Sangat Baik'?max($y[$k]):min($y[$k]));
                            echo "<th>$yplus[$k]</th>";
                          }
                          ?>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-lg-12 mt-3">
                <div class="card">
                  <div class="card-header">
                    Solusi Ideal negatif (A<sup>-</sup>)
                    <a href="pdf/solusi-negatif.php" class="btn btn-success float-right">
                      <i class="nav-icon fas fa-save"></i> Cetak Tabel
                    </a>
                  </div>
                  <div class="card-body">
                    <table class="table table-striped table-bordered table-hover">
                      <thead>
                        <tr>
                          <th colspan='<?php echo $jml_kriteria;?>'>Kriteria</th>
                        </tr>
                        <tr>
                          <?php
                          foreach($kriteria as $k)
                            echo "<th>{$k}</th>\n";
                          ?>
                        </tr>
                        <tr>
                          <?php
                          for($n=1;$n<=$jml_kriteria;$n++)
                            echo "<th>y<sub>{$n}</sub><sup>-</sup></th>";
                          ?>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <?php
                          $ymin=array();
                          foreach($kriteria as $k){
                            $ymin[$k]=($status[$k]=='Standar'?max($y[$k]):min($y[$k]));
                            echo "<th>{$ymin[$k]}</th>";
                          }

                          ?>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-lg-12 mt-3">
                <div class="card">
                  <div class="card-header">
                    Jarak positif (D<sub>i</sub><sup>+</sup>)
                    <a href="pdf/jarak-positif.php" class="btn btn-success float-right">
                      <i class="nav-icon fas fa-save"></i> Cetak Tabel
                    </a>
                  </div>
                  <div class="card-body">
                    <table class="table table-striped table-bordered table-hover">
                      <thead>
                        <tr>
                          <th>No</th>
                          <th>Nama Perusahaan</th>
                          <th>D<sup>+</sup></th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        $i=0;
                        $dplus=array();
                        foreach($data as $nama=>$krit){
                          echo "<tr>
                            <td>".(++$i)."</td>
                            <td>{$nama}</td>";
                          foreach($kriteria as $k){
                            // Ensure both $yplus[$k] and $y[$k][$i-1] are numeric before performing the operation
                            if (!isset($dplus[$i-1])) $dplus[$i-1] = 0;
                            
                            // Convert $yplus[$k] and $y[$k][$i-1] to float to avoid string issues
                            $yplusValue = isset($yplus[$k]) ? (float)$yplus[$k] : 0;
                            $yValue = isset($y[$k][$i-1]) ? (float)$y[$k][$i-1] : 0;

                            // Calculate the distance
                            $dplus[$i-1] += pow($yplusValue - $yValue, 2);
                          }
                          echo "<td>".round(sqrt($dplus[$i-1]),4)."</td>
                            </tr>\n";
                        }
                        ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-lg-12 mt-3">
                <div class="card">
                  <div class="card-header">
                    Jarak negatif (D<sub>i</sub><sup>-</sup>)
                    <a href="pdf/jarak-negatif.php" class="btn btn-success float-right">
                      <i class="nav-icon fas fa-save"></i> Cetak Tabel
                    </a>
                  </div>
                  <div class="card-body">
                    <table class="table table-striped table-bordered table-hover">
                      <thead>
                        <tr>
                          <th>No</th>
                          <th>Nama Perusahaan</th>
                          <th>D<suo>-</sup></th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        $i=0;
                        $dmin=array();
                        foreach($data as $nama=>$krit){
                          echo "<tr>
                            <td>".(++$i)."</td>
                            <td>{$nama}</td>";
                          foreach($kriteria as $k){
                            // Initialize $dmin[$i-1] if it hasn't been set
                            if (!isset($dmin[$i-1])) $dmin[$i-1] = 0;
                            
                            // Ensure $ymin[$k] and $y[$k][$i-1] are numeric before performing the operation
                            $yminValue = isset($ymin[$k]) ? (float)$ymin[$k] : 0;
                            $yValue = isset($y[$k][$i-1]) ? (float)$y[$k][$i-1] : 0;

                            // Calculate the distance
                            $dmin[$i-1] += pow($yminValue - $yValue, 2);
                          }
                          echo "<td>".round(sqrt($dmin[$i-1]),4)."</td>

                          </tr>\n";
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