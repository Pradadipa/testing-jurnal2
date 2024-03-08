<?php

// include '../inc/dbconn.php';
// include '../inc/dbconn_crm.php';
include 'dbconn_pdo.php';

//============================================================+
// File name   : example_048.php
// Begin       : 2009-03-20
// Last Update : 2013-05-14
//
// Description : Example 048 for TCPDF class
//               HTML tables and table headers
//
// Author: Nicola Asuni
//
// (c) Copyright:
//               Nicola Asuni
//               Tecnick.com LTD
//               www.tecnick.com
//               info@tecnick.com
//============================================================+

/**
 * Creates an example PDF TEST document using TCPDF
 * @package com.tecnick.tcpdf
 * @abstract TCPDF - Example: HTML tables and table headers
 * @author Nicola Asuni
 * @since 2009-03-20
 */

// Create a new PDO instance
// try {
//     $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
//     $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
// } catch (PDOException $e) {
//     die("Database connection failed: " . $e->getMessage());
// }

// Get the date parameters and idBarang from the URL
$date1 = $_GET['date1'] ?? '';
$date2 = $_GET['date2'] ?? '';
$idBarang = $_GET['id'] ?? '';

// Fetch data from the database
$sql_akun = "SELECT `id`, `nama_akun`, `pos_saldo`, `pos_laporan`, `saldo_debit_awal`, `saldo_kredit_awal`, `lvl`, `lvl_diatas` FROM `daftar_akun` WHERE `pos_laporan` = 'NRC' AND `id` LIKE '1-1%'";
$stmt_akun = $conn->prepare($sql_akun);

$sql_akun2 = "SELECT `id`, `nama_akun`, `pos_saldo`, `pos_laporan`, `saldo_debit_awal`, `saldo_kredit_awal`, `lvl`, `lvl_diatas` FROM `daftar_akun` WHERE `pos_laporan` = 'NRC' AND `id` LIKE '2%'";
$stmt_akun2 = $conn->prepare($sql_akun2);

$sql_akun3 = "SELECT `id`, `nama_akun`, `pos_saldo`, `pos_laporan`, `saldo_debit_awal`, `saldo_kredit_awal`, `lvl`, `lvl_diatas` FROM `daftar_akun` WHERE `pos_laporan` = 'NRC' AND `id` LIKE '1-2%'";
$stmt_akun3 = $conn->prepare($sql_akun3);

$sql_akun4 = "SELECT `id`, `nama_akun`, `pos_saldo`, `pos_laporan`, `saldo_debit_awal`, `saldo_kredit_awal`, `lvl`, `lvl_diatas` FROM `daftar_akun` WHERE `pos_laporan` = 'NRC' AND `id` LIKE '3%'";
$stmt_akun4 = $conn->prepare($sql_akun4);

$sql_neraca = "SELECT neraca.id_neraca, 
    neraca.id_buku_besar, 
    neraca.total_saldo, 
    buku_besar.id_jurnal, 
    buku_besar.saldo, 
    jurnal.tanggal, 
    jurnal.nomor_bukti, 
    jurnal.keterangan, 
    jurnal_detail.debit, 
    jurnal_detail.kredit, 
    jurnal_detail.id_akun,
    daftar_akun.id AS id_akun_daftar,
    daftar_akun.nama_akun AS nama_akun_daftar,
    daftar_akun.pos_saldo,
    daftar_akun.pos_laporan,
    daftar_akun.saldo_debit_awal,
    daftar_akun.saldo_kredit_awal
    FROM neraca
    INNER JOIN buku_besar ON neraca.id_buku_besar = buku_besar.id_buku_besar
    INNER JOIN jurnal ON buku_besar.id_jurnal = jurnal.id_jurnal
    INNER JOIN jurnal_detail on buku_besar.id_jurnal_detail = jurnal_detail.id_jurnal_detail
    INNER JOIN daftar_akun ON jurnal_detail.id_akun = daftar_akun.id
    WHERE daftar_akun.pos_laporan = 'NRC'";
$stmt_neraca = $conn->prepare($sql_neraca);

try {
    // Execute the first query
    $stmt_akun->execute();
    // Fetch the data
    $data_akun = $stmt_akun->fetchAll(PDO::FETCH_ASSOC);

    $stmt_akun2->execute();
    // Fetch the data
    $data_akun2 = $stmt_akun2->fetchAll(PDO::FETCH_ASSOC);

    $stmt_akun3->execute();
    // Fetch the data
    $data_akun3 = $stmt_akun3->fetchAll(PDO::FETCH_ASSOC);

    $stmt_akun4->execute();
    // Fetch the data
    $data_akun4 = $stmt_akun4->fetchAll(PDO::FETCH_ASSOC);

    // Execute the second query
    $stmt_neraca->execute();
    // Fetch the data
    $data_neraca = $stmt_neraca->fetchAll(PDO::FETCH_ASSOC);

    // Display the data

    // Rest of your code for PDF generation...

    // Include the main TCPDF library (search for installation path).
    require_once('report/tcpdf/tcpdf.php');

    class MYPDF extends TCPDF
    {

        //Page header
        public function Header()
        {
            // Set font
            $this->SetFont('helvetica', 'B', 13);
            // Title
            $this->SetY(10);
            $this->Cell(0, 15, 'PETAPAN PARK', 0, false, 'C', 0, '', 0, false, 'M', 'M');

            $this->SetFont('helvetica', '', 10);
            $this->SetY(15);
            $this->Cell(0, 15, ' BR PETAPAN, DSN SWELAGIRI DS AAN, KEC BANJARANGKAN-KLK', 0, false, 'C', 0, '', 0, false, 'M', 'M');

            $this->SetFont('helvetica', 'B', 13);
            $this->SetY(20);
            $this->Cell(0, 15, 'NERACA', 0, false, 'C', 0, '', 0, false, 'M', 'M');
            // Line break
            $this->SetY(25);
            // Address
            $this->SetFont('helvetica', 'B', 10); // Set smaller font for address
            $this->Cell(0, 15, '02-08-2023 s/d 31-08-2023', 0, false, 'C', 0, '', 0, false, 'M', 'M');

            // // Draw line under the address
            // $this->SetY(14);
            // $this->SetLineWidth(0.2); // Set line width
            // $this->SetDrawColor(0, 0, 0); // Set line color (black)
            // $this->Line(35, $this->GetY() + 2, 205, $this->GetY() + 2); // Draw line
        }

        //Table with horizontal alignment
        public function AddTable($data_akun, $data_neraca, $data_akun2, $data_akun3, $data_akun4)
        {
            $w = array(16, 40, 20, 20);
            $x1 = 5; // X position for the first table
            $x2 = $x1 + array_sum($w) + 5; // X position for the second table
            $y = 30; // Initial Y position

            // Header for the first table
            $this->SetFont('helvetica', 'B', 7);
            $this->SetXY($x1, $y);
            $this->Cell($w[0], 2, 'Kode Akun', 1, 0, 'C');
            $this->Cell($w[1], 2, 'Nama Akun', 1, 0, 'C');
            $this->Cell($w[2], 2, 'Saldo', 1, 0, 'C');
            $this->Cell($w[3], 2, 'Jumlah Saldo', 1, 1, 'C'); // Change 0 to 1 for line break

            // Data for the first table
            foreach ($data_akun as $row) {
                $this->SetX($x1);
                $this->Cell($w[0], 2, $row['id'], 'LR', 0, 'C');
                $this->Cell($w[1], 2, $row['nama_akun'], 'LR', 0, 'L');
                $found = false;
                foreach ($data_neraca as $row2) {
                    if ($row2['id_akun'] == $row['id']) {
                        $found = true;
                        // Output saldo dari neraca
                        $this->Cell($w[2], 2, number_format($row2['total_saldo']), 'LR', 0, 'R');
                        // Output jumlah saldo
                        $this->Cell($w[3], 2, '', 'LR', 1, 'R');
                        $total_aktiva_lancar += $row2['total_saldo'];
                    }
                }
                // Jika tidak ada data neraca yang cocok, output saldo kosong
                if (!$found) {
                    $this->Cell($w[2], 2, '0', 'LR', 0, 'R');
                    // Output jumlah saldo kosong
                    $this->Cell($w[3], 2, '', 'LR', 1, 'L');
                }

            }
            $this->Line($x1, $this->GetY(), $x1 + array_sum($w), $this->GetY());
            $this->Cell(76, 2, "Jumlah Aktiva Lancar", 1, 0, 'L');
            $this->Cell(20, 2, number_format($total_aktiva_lancar), 1, 1, 'R');

            // Tambahkan total saldo di baris terakhir tabel pertama
            $this->SetX($x1);
            // $this->Cell(array_sum($w), 2, number_format($total_aktiva_lancar), 1, 1, 'C');

            // Gambar garis horizontal di bawah tabel pertama
            $this->Line($x1, $this->GetY(), $x1 + array_sum($w), $this->GetY());

            // // Header for the second table
            // $this->SetFont('helvetica', 'B', 7);
            // $this->SetXY($x1, $this->GetY()); // Posisi X diatur kembali ke $x1 dan Y dinaikkan untuk memulai di bawah tabel pertama
            // $this->Cell($w[0], 2, 'Kode Akun', 1, 0, 'C');
            // $this->Cell($w[1], 2, 'Nama Akun', 1, 0, 'C');
            // $this->Cell($w[2], 2, 'Saldo', 1, 0, 'C');
            // $this->Cell($w[3], 2, 'Total Saldo', 1, 1, 'C'); // Change 0 to 1 for line break

            // Data for the second table
            foreach ($data_akun3 as $row) {
                $this->SetX($x1);
                $this->Cell($w[0], 2, $row['id'], 'LR', 0, 'C');
                $this->Cell($w[1], 2, $row['nama_akun'], 'LR', 0, 'L');
                $found = false;
                foreach ($data_neraca as $row2) {
                    if ($row2['id_akun'] == $row['id']) {
                        $found = true;
                        // Output saldo dari neraca
                        $this->Cell($w[2], 2, number_format($row2['total_saldo']), 'LR', 0, 'R');
                        // Output jumlah saldo
                        $this->Cell($w[3], 2, '', 'LR', 1, 'R');
                        $total_aktiva_tetap += $row2['total_saldo'];
                    }
                }
                // Jika tidak ada data neraca yang cocok, output saldo kosong
                if (!$found) {
                    $this->Cell($w[2], 2, '0', 'LR', 0, 'R');
                    // Output jumlah saldo kosong
                    $this->Cell($w[3], 2, '', 'LR', 1, 'R');
                }
            }

            // Tambahkan total saldo di baris terakhir tabel kedua
            $this->SetX($x1);
            $this->Cell(array_sum($w) - 20, 2, "Jumlah Aktiva Tetap", 1, 0, 'L');
            $this->Cell(20, 2, number_format($total_aktiva_tetap), 1, 1, 'R');
            $this->Cell(array_sum($w) - 20, 2, "Jumlah Aktiva", 1, 0, 'L');
            $this->Cell(20, 2, number_format($total_aktiva_lancar + $total_aktiva_tetap), 1, 1, 'R');

            // Gambar garis horizontal di bawah tabel kedua
            $this->Line($x1, $this->GetY(), $x1 + array_sum($w), $this->GetY());



            // Header for the second table
            $this->SetFont('helvetica', 'B', 7);
            $this->SetXY($x2, $y);
            $this->Cell($w[0], 2, 'Kode Akun', 1, 0, 'C');
            $this->Cell($w[1], 2, 'Nama Akun', 1, 0, 'C');
            $this->Cell($w[2], 2, 'Saldo', 1, 0, 'C');
            $this->Cell($w[3], 2, 'Total Saldo', 1, 1, 'C'); // Change 0 to 1 for line break

            // Data for the second table
            foreach ($data_akun2 as $row) {
                $this->SetX($x2);
                $this->Cell($w[0], 2, $row['id'], 'LR', 0, 'C');
                $this->Cell($w[1], 2, $row['nama_akun'], 'LR', 0, 'L');
                $found = false;
                foreach ($data_neraca as $row2) {
                    if ($row2['id_akun'] == $row['id']) {
                        $found = true;
                        // Output saldo dari neraca
                        $this->Cell($w[2], 2, number_format($row2['total_saldo']), 'LR', 0, 'R');
                        // Output jumlah saldo
                        $this->Cell($w[3], 2, '', 'LR', 1, 'R');
                        $total_kewajiban += $row2['total_saldo'];
                    }
                }
                // Jika tidak ada data neraca yang cocok, output saldo kosong
                if (!$found) {
                    $this->Cell($w[2], 2, '0', 'LR', 0, 'R');
                    // Output jumlah saldo kosong
                    $this->Cell($w[3], 2, '', 'LR', 1, 'R');
                }
            }

            $this->SetX($x2);
            $this->Cell(array_sum($w) - 20, 2, "Jumlah Kewajiban", 1, 0, 'L');
            $this->Cell(20, 2, number_format($total_kewajiban), 1, 1, 'R');


            // Hitung tinggi tabel kedua
            $table2_height = ($this->GetY() - $y);

            // Tentukan posisi Y untuk tabel ketiga
            $y3 = $y + $table2_height; // Sesuaikan jarak vertikal antara tabel kedua dan ketiga

            // Header for the third table
            $this->SetFont('helvetica', 'B', 7);
            // $this->SetXY($x2, $y3);
            // $this->Cell($w[0], 2, 'Kode Akun', 1, 0, 'C');
            // $this->Cell($w[1], 2, 'Nama Akun', 1, 0, 'C');
            // $this->Cell($w[2], 2, 'Saldo', 1, 0, 'C');
            // $this->Cell($w[3], 2, 'Total Saldo', 1, 1, 'C'); // Change 0 to 1 for line break

            // Data for the third table
            foreach ($data_akun4 as $row) {
                $this->SetX($x2);
                $this->Cell($w[0], 2, $row['id'], 'LR', 0, 'C');
                $this->Cell($w[1], 2, $row['nama_akun'], 'LR', 0, 'L');
                $found = false;
                foreach ($data_neraca as $row2) {
                    if ($row2['id_akun'] == $row['id']) {
                        $found = true;
                        // Output saldo dari neraca
                        $this->Cell($w[2], 2, number_format(abs($row2['total_saldo'])), 'LR', 0, 'R');
                        // Output jumlah saldo
                        $this->Cell($w[3], 2, '', 'LR', 1, 'L');
                        $total_ekuitas += $row2['total_saldo'];
                    }
                }
                // Jika tidak ada data neraca yang cocok, output saldo kosong
                if (!$found) {
                    $this->Cell($w[2], 2, '0', 'LR', 0, 'R');
                    // Output jumlah saldo kosong
                    $this->Cell($w[3], 2, '', 'LR', 1, 'R');
                }
            }

            // Tambahkan total saldo di baris terakhir tabel ketiga
            $this->SetX($x2);
            $this->Cell(array_sum($w) - 20, 2, "Jumlah Ekuitas", 1, 0, 'L');
            $this->Cell(20, 2, number_format(abs($total_ekuitas)), 1, 1, 'R');
            $this->SetX($x2);
            $this->Cell(array_sum($w) - 20, 2, "Jumlah Kewajiban & Ekuitas", 1, 0, 'L');
            $this->Cell(20, 2, number_format(abs($total_kewajiban + $total_ekuitas)), 1, 1, 'R');


            $this->Line($x2, $this->GetY(), $x2 + array_sum($w), $this->GetY());

            // Gambar garis horizontal di bawah tabel ketiga

            // Gambar garis horizontal di bawah tabel kedua
            // Draw lines to separate tables
        }

        // Page footer
        public function Footer()
        {
            $this->SetY(-15);
            // Set font
            $this->SetFont('helvetica', '', 7);
            // Printed date on the left
            date_default_timezone_set('Asia/Makassar');
            $printedDate = date('d-m-Y H:i:s');
            $this->Cell(0, 10, 'Printed : ' . $printedDate, 0, false, 'L');
            // Page number on the right
            $this->SetFont('helvetica', '', 7);
            $this->setX(195);
            $this->Cell(0, 10, 'Page ' . $this->getAliasNumPage() . '/' . $this->getAliasNbPages(), 0, false, 'L'); // Margin kanan: 5
        }
    }

    // create new PDF document
    $pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

    // set document information
    // $pdf->SetCreator('PT.Berliando Mitra Abadi');
    // $pdf->SetAuthor($_SESSION['username'] ?? '');
    // $pdf->SetTitle('Barang_KSO_' . $data[0]['kso_kode_barang']);
    // $pdf->SetSubject('Barang KSO');
    // $pdf->SetKeywords('Barang_KSO, PDF, ' . $data[0]['kso_kode_barang']);

    // set header and footer fonts
    $pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
    $pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

    // set default monospaced font
    $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

    // set margins
    $pdf->SetMargins(5, PDF_MARGIN_TOP, 5);
    $pdf->setFooterMargin();
    // set auto page breaks
    $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

    // set image scale factor
    $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
    // set some language-dependent strings (optional)
    if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
        require_once(dirname(__FILE__) . '/lang/eng.php');
        $pdf->setLanguageArray($l);
    }

    // ---------------------------------------------------------

    // add a page
    $pdf->AddPage();

    // $pdf->SetFont('helvetica', '', 8);
    // $pdf->MultiCell(0, 0, 'Code', 0, 'L', 0, 0, 5, 25, true);
    // $pdf->SetFont('helvetica', 'B', 8);
    // $pdf->MultiCell(0, 0, ': ' . $idBarang, 0, 'L', 0, 0, 21, 25, true);

    $pdf->Ln(8);

    $pdf->SetFont('helvetica', 'N', 7);

    // Add table to the page
    $pdf->AddTable($data_akun, $data_neraca, $data_akun2, $data_akun3, $data_akun4);

    // Close and output PDF document
    ob_end_clean();
    $pdf->Output('kso_barang.pdf', 'I');
} catch (PDOException $e) {
    echo 'Error: ' . $e->getMessage();
}

//============================================================+
// END OF FILE
//============================================================+
