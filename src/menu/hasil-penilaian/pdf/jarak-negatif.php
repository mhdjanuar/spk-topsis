<?php
    include('../../../../koneksi.php');

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

    require_once('../../../../public/plugins/tcpdf/tcpdf.php');

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
    $pdf->SetTitle('Data Tabel Jarak Negatif');

    $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
    $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
    
    // Step 4: Add a page to the PDF
    $pdf->AddPage();
    
    $html = '
    <div>
        <h1 align="center">Laporan Hasil Jarak Negatif</h1>
        <table border="1" cellpadding="4">
            <thead>
                <tr>
                    <th><b>No</b></th>
                    <th><b>Nama Perusahaan</b></th>
                    <th><b>D</b><sup>-</sup></th>
                </tr>
            </thead>
            <tbody>';

            $i = 0; 
            $y = array();
            foreach($data as $nama => $krit){
                foreach($kriteria as $k){
                    if (isset($krit[$k]) && isset($nilai_kuadrat[$k]) && isset($bobot[$k])) {
                        $y[$k][$i] = round(($krit[$k] / sqrt($nilai_kuadrat[$k])), 4) * $bobot[$k];
                    } else {
                        $y[$k][$i] = '-';
                    }
                }
                $i++;
            }
            
            $ymin = array();
            foreach($kriteria as $k){
                $ymin[$k] = ($status[$k] == 'Standar' ? max($y[$k]) : min($y[$k]));
            }
            
            $i = 0;
            $dmin = array();
            foreach($data as $nama => $krit) {
                $html .= '<tr>
                            <td>'.(++$i).'</td>
                            <td>'.$nama.'</td>';
                foreach($kriteria as $k){
                    // Ensure both $yplus[$k] and $y[$k][$i-1] are numeric before performing the operation
                    if (!isset($dmin[$i-1])) $dmin[$i-1] = 0;
                            
                    // Ensure $ymin[$k] and $y[$k][$i-1] are numeric before performing the operation
                    $yminValue = isset($ymin[$k]) ? (float)$ymin[$k] : 0;
                    $yValue = isset($y[$k][$i-1]) ? (float)$y[$k][$i-1] : 0;

                    // Calculate the distance
                    $dmin[$i-1] += pow($yminValue - $yValue, 2);
                }
                
                $html .= '<td>'.round(sqrt($dmin[$i-1]),4).'</td>';
                $html .= '</tr>';
            }
    
    $html .= '
            </tbody>
        </table>
    </div>';
    
    $pdf->writeHTML($html, true, false, true, false, '');

    // Step 6: Output the PDF to the browser
    $pdf->Output('data-jarak-negatif.pdf', 'I');
?>