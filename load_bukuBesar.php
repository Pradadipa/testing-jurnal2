<?php
include 'dbconn.php';

// Ambil nilai id_akun dari $_POST
$id_akun = $_POST['id_akun'];

$sql = "SELECT 
buku_besar.id_buku_besar, 
buku_besar.id_jurnal_detail, 
buku_besar.saldo,
jurnal.id_jurnal,
jurnal.nomor_bukti,
jurnal.tanggal,
jurnal.keterangan,
jurnal_detail.id_jurnal_detail,
jurnal_detail.id_akun,
jurnal_detail.debit,
jurnal_detail.kredit
FROM 
buku_besar
JOIN
jurnal ON buku_besar.id_jurnal = jurnal.id_jurnal
JOIN 
jurnal_detail ON buku_besar.id_jurnal_detail = jurnal_detail.id_jurnal_detail

WHERE jurnal_detail.id_akun =  '$id_akun'";

$result = $conn->query($sql);

$response = ''; // Inisialisasi variabel response

if ($result->num_rows > 0) {
    $no = 1; // Untuk nomor urut
    while ($row = $result->fetch_assoc()) {
        $response .= "<tr>";
        $response .= "<td>" . $no++ . "</td>";
        $response .= "<td>" . $row['tanggal'] . "</td>";
        $response .= "<td>" . $row['nomor_bukti'] . "</td>";
        $response .= "<td>" . $row['keterangan'] . "</td>";
        $response .= "<td>" . number_format($row['debit'], 0, ',', '.') . "</td>";
        $response .= "<td>" . number_format($row['kredit'], 0, ',', '.') . "</td>";
        $response .= "<td>" . number_format(abs($row['saldo']), 0, ',', '.') . "</td>";
        $response .= "</tr>";
    }
} else {
    $response .= "<tr><td colspan='7'>Belum ada transaksi</td></tr>";
}

// Keluarkan response
echo $response;
