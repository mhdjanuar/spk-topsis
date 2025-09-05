<?php
    include('../../../koneksi.php');

    require_once('../../../public/plugins/tcpdf/tcpdf.php');

    function formatTanggalIndonesia($tanggal = null)
    {
        // Kalau $tanggal null → pakai tanggal hari ini
        $date = $tanggal ? new DateTime($tanggal) : new DateTime();

        $hari = [
            1 => 'Senin',
            2 => 'Selasa',
            3 => 'Rabu',
            4 => 'Kamis',
            5 => 'Jumat',
            6 => 'Sabtu',
            7 => 'Minggu',
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
    $pdf->SetTitle('Data Tabel Perusahaan');

    $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
    $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
    
    // Step 4: Add a page to the PDF
    $pdf->AddPage();
    
    $sql = $koneksi->query("SELECT * FROM tab_perusahaan");
    
    $html = '
    <div>
        <h1 align="center">Laporan Perusahaan</h1>
        <table border="1" cellpadding="2">
            <thead>
                <tr>
                    <th><b>NO</b></th>
                    <th><b>NAMA</b></th>  
                </tr>
            </thead>
            <tbody>';

            $no = 1;
            while ($row = $sql->fetch_array()) {
                $html .= '<tr>
                            <td align="left">' . $no . '</td>
                            <td align="left">' . $row['nama_perusahaan'] . '</td>
                        </tr>';
                $no++;
            }
    
    $html .= '
            </tbody>
        </table>
    </div>
    ';
    
    $pdf->writeHTML($html, true, false, true, false, '');

    // Step 6: Output the PDF to the browser
    $pdf->Output('data-perusahaan.pdf', 'I');
?>