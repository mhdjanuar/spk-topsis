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
    $pdf->SetTitle('Data Tabel Kriteria');

    $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
    $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
    
    // Step 4: Add a page to the PDF
    $pdf->AddPage();
    
    $sql = $koneksi->query("SELECT * FROM tab_kriteria");
    
    $html = '
    <div>
        <h1 align="center">Laporan Kriteria Supplier</h1>
        <table border="1" cellpadding="4">
            <thead>
                <tr>
                    <th><b>NO</b></th>
                    <th><b>NAMA</b></th>
                    <th><b>BOBOT</b></th>
                    <th><b>NILAI</b></th>
                    <th><b>STATUS</b></th>
                </tr>
            </thead>
            <tbody>';

            $no = 1;
            while ($row = $sql->fetch_array()) {
                $html .= '<tr>
                            <td align="left">' . $no . '</td>
                            <td align="left">' . $row['nama_kriteria'] . '</td>
                            <td align="left">' . $row['bobot'] . '</td>
                            <td align="left">' . $row['nilai'] . '</td>
                            <td align="left">' . $row['status'] . '</td>
                        </tr>';
                $no++;
            }
    
    $html .= '
            </tbody>
        </table>
    </div>';
    
        $pdf->writeHTML($html, true, false, true, false, '');
    
        // Step 6: Output the PDF to the browser
        $pdf->Output('data-kriteria.pdf', 'I');
?>