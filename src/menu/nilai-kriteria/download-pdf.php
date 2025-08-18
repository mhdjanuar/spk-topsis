<?php
    include('../../../koneksi.php');

    require_once('../../../public/plugins/tcpdf/tcpdf.php');

    function formatTanggalIndonesia($tanggal = null)
    {
        // Kalau $tanggal null → pakai tanggal hari ini
        $date = $tanggal ? new DateTime($tanggal) : new DateTime();

        $bulan = [
            1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
                'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
        ];

        return $date->format('d') . ' ' .
            $bulan[(int)$date->format('m')] . ' ' .
            $date->format('Y');
    }

    class MyPDF extends TCPDF {
      public function Footer() {
          $this->SetY(-40);
          $this->SetFont('helvetica', 'I', 8);

          setlocale(LC_TIME, 'id_ID.UTF-8');
          $date = new DateTime();
          $formattedDate = formatTanggalIndonesia($date->format('Y-m-d'));

          $footerHtml = '
              <div>
                  <p align="right">Cimanggis, ' . $formattedDate . '</p>
                  <p align="right">Pimpinan</p>
                  <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
                  <p align="right">(Yogi Rizkyansyah S.E)</p>
              </div>';
          // Print text using writeHTMLCell
          $this->writeHTMLCell(0, 0, '', '', $footerHtml, 0, 1, 0, true, 'C', true);
      }
  }

    // Step 2: Create an instance of the TCPDF class
    $pdf = new MyPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
    
    // Step 3: Set document information
    $pdf->SetTitle('Data Tabel Penilaian');

    $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
    $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
    
    // Step 4: Add a page to the PDF
    $pdf->AddPage();
    
    $sql = $koneksi->query("SELECT tab_perusahaan.nama_perusahaan, tab_kriteria.nama_kriteria, tab_topsis.nilai
      FROM tab_topsis
      JOIN tab_perusahaan ON tab_topsis.id_perusahaan = tab_perusahaan.id_perusahaan
      JOIN tab_kriteria ON tab_topsis.id_kriteria = tab_kriteria.id_kriteria
      ORDER BY tab_perusahaan.id_perusahaan, tab_topsis.nilai DESC");
    
    $html = '
    <div>
      <h1 align="center">Laporan Hasil Penilaian</h1>
      <table border="1" cellpadding="4">
        <thead>
          <tr>
            <th><b>PERUSAHAAN</b></th>
            <th><b>KRITERIA</b></th>
            <th><b>NILAI</b></th>
          </tr>
        </thead>
        <tbody>';

    $no = 1;
    $currentPerusahaan = "";

    while ($row = $sql->fetch_array()) {
      if ($row['nama_perusahaan'] != $currentPerusahaan) {
        if ($currentPerusahaan != "") {
          $html .= '<tr><td colspan="4">&nbsp;</td></tr>';
        }

        $currentPerusahaan = $row['nama_perusahaan'];
        $html .= '<tr><td colspan="4"><strong>' . $currentPerusahaan . '</strong></td></tr>';
      }

      $html .= '<tr>
                  <td align="left"></td>
                  <td align="left">' . $row['nama_kriteria'] . '</td>
                  <td align="left">' . $row['nilai'] . '</td>
                </tr>';

      $no++;
    }
    
    $html .= '
        </tbody>
      </table>
    </div>';
    
    $pdf->writeHTML($html, true, false, true, false, '');

    // Step 6: Output the PDF to the browser
    $pdf->Output('data-penilaian.pdf', 'I');
?>