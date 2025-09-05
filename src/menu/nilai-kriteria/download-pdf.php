<?php
include('../../../koneksi.php');
require_once('../../../public/plugins/tcpdf/tcpdf.php');

// =================== FUNGSI FORMAT TANGGAL ===================
function formatTanggalIndonesia($tanggal = null)
{
    $date = $tanggal ? new DateTime($tanggal) : new DateTime();

    $hari = [
        1 => 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'
    ];

    $bulan = [
        1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
        'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
    ];

    return $hari[(int)$date->format('N')] . ', ' .
        $date->format('d') . ' ' .
        $bulan[(int)$date->format('m')] . ' ' .
        $date->format('Y');
}

// =================== CUSTOM CLASS TCPDF ===================
class MyPDF extends TCPDF {
    public function Header() {
        // Logo
        $image_file = __DIR__ . '/../../../public/style/img/pencatatan-logo.png';
        if (file_exists($image_file)) {
            $this->Image($image_file, 15, 5, 12, '', 'PNG');
        }

        // Judul Perusahaan
        $this->SetFont('helvetica', 'B', 14);
        $this->Cell(0, 7, 'LatarOutdoor', 0, 1, 'C');
        $this->SetFont('helvetica', '', 10);
        $this->Cell(0, 6, 'Jl. Raya Cimanggis No. 123, Depok - Jawa Barat', 0, 1, 'C');
        $this->Cell(0, 6, 'Telp: (021) 1234567 | Email: info@perusahaan.com', 0, 1, 'C');

        // Garis pemisah
        $this->Ln(2);
        $this->Cell(0, 0, '', 'T');
        $this->Ln(5);
    }

    // Kosongkan footer default
    public function Footer() {}
}

// =================== INSTANSIASI PDF ===================
$pdf = new MyPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// Info Dokumen
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('LatarOutdoor');
$pdf->SetTitle('Data Tabel Penilaian');

// Margin
$pdf->SetMargins(15, 50, 15);   // kiri, atas, kanan
$pdf->SetAutoPageBreak(TRUE, 60); // sisakan 60 mm di bawah untuk tanda tangan

$pdf->AddPage();

// =================== QUERY DATA ===================
$sql = $koneksi->query("
    SELECT tab_perusahaan.nama_perusahaan, tab_kriteria.nama_kriteria, tab_topsis.nilai
    FROM tab_topsis
    JOIN tab_perusahaan ON tab_topsis.id_perusahaan = tab_perusahaan.id_perusahaan
    JOIN tab_kriteria ON tab_topsis.id_kriteria = tab_kriteria.id_kriteria
    ORDER BY tab_perusahaan.id_perusahaan, tab_topsis.nilai DESC
");

// =================== ISI KONTEN PDF ===================
$html = '
<h2 align="center" style="margin-bottom:15px;">Laporan Hasil Penilaian</h2>
<table border="1" cellpadding="4">
  <thead>
    <tr style="background-color:#f2f2f2; font-weight:bold; text-align:center;">
      <th width="200">PERUSAHAAN</th>
      <th width="180">KRITERIA</th>
      <th width="100">NILAI</th>
    </tr>
  </thead>
  <tbody>';

$currentPerusahaan = "";
while ($row = $sql->fetch_array()) {
    if ($row['nama_perusahaan'] != $currentPerusahaan) {
        if ($currentPerusahaan != "") {
            $html .= '<tr><td colspan="3">&nbsp;</td></tr>';
        }
        $currentPerusahaan = $row['nama_perusahaan'];
        $html .= '<tr><td colspan="3"><strong>' . $currentPerusahaan . '</strong></td></tr>';
    }

    $html .= '<tr>
                <td></td>
                <td>' . $row['nama_kriteria'] . '</td>
                <td align="center">' . $row['nilai'] . '</td>
              </tr>';
}
$html .= '</tbody></table>';

// Cetak tabel
$pdf->writeHTML($html, true, false, true, false, '');

// =================== TANDA TANGAN ===================
$ttd = '
    <br><br><br>
    <p align="right">Cimanggis, ' . formatTanggalIndonesia() . '</p>
    <p align="right">Pimpinan</p>
    <br><br><br>
    <p align="right">(Yogi Rizkyansyah S.E)</p>
';

// Cetak tanda tangan (akan selalu muat karena AutoPageBreak sudah sisakan ruang)
$pdf->writeHTML($ttd, true, false, true, false, '');

// =================== OUTPUT PDF ===================
$pdf->Output('data-penilaian.pdf', 'I');
?>
