<?php
// Include database connection
include 'dbconn.php';

// Initialize response variable
$response = "";

// Check if the required parameters are received
if (isset($_POST['tanggal_awal'], $_POST['tanggal_akhir'])) {
    // Sanitize input
    $tanggal_awal = $_POST['tanggal_awal'];
    $tanggal_akhir = $_POST['tanggal_akhir'];

    $sql = "SELECT `id_jurnal`, `nomor_bukti`, `tanggal`, `keterangan` FROM `jurnal` WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'";
    $result = $conn->query($sql);

    $total_debet = 0;
    $total_kredit = 0;

    if ($result->num_rows > 0) {
        while ($row_jurnal = $result->fetch_assoc()) {
            $response .= "<tr>";
            $response .= '<td colspan="5" style="text-align:left">' . $row_jurnal['keterangan'] . '</td>';
            $response .= "</tr>";
            $response .= "<tr>";
            $response .= '<td rowspan="2" style="text-align:center">' . $row_jurnal['tanggal'] . '</td>';
            $response .= '<td rowspan="2" style="text-align:left">' . $row_jurnal['nomor_bukti'] . '</td>';

            // Lakukan query untuk detail jurnal berdasarkan ID jurnal saat ini
            $jurnal_id = $row_jurnal['id_jurnal'];
            $sql_detail = "SELECT * FROM jurnal_detail WHERE id_jurnal = '$jurnal_id'";
            $result_detail = $conn->query($sql_detail);

            // Periksa apakah ada data detail jurnal untuk jurnal saat ini
            if ($result_detail->num_rows > 0) {
                while ($row_detail = $result_detail->fetch_assoc()) {
                    $response .= '<td style="text-align:center">' . $row_detail['id_akun'] . '</td>';
                    $response .= '<td style="text-align:left">' . number_format($row_detail['debit'], 0, ',', '.') . '</td>';
                    $response .= '<td style="text-align:left">' . number_format($row_detail['kredit'], 0, ',', '.') . '</td>';
                    $response .= "</tr>";

                    $total_debet += $row_detail['debit'];
                    $total_kredit += $row_detail['kredit'];
                }

            } else {
                // Tidak ada data detail jurnal untuk jurnal saat ini
                $response .= "<tr><td colspan='5'>Tidak ada detail jurnal</td></tr>";
            }
        }
    } else {
        $response .= "<tr><td colspan='6'>Tidak ada data</td></tr>";
    }
    $response .= "<tr>";
    $response .= "<td colspan='3'><strong>Total</strong></td>";
    $response .= "<td style='text-align:center'><strong>" . number_format($total_debet, 0, ',', '.') . "</strong></td>";
    $response .= "<td style='text-align:center'><strong>" . number_format($total_kredit, 0, ',', '.') . "</strong></td>";
    $response .= "</tr>";

} else {
    // Handle missing parameters
    $response .= "Required parameters are missing!";
}

// Return the response
echo $response;
