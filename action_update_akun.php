<?php
// Menghubungkan ke databases
include 'dbconn.php';

// Inisialisasi respon
$response = "";

// Menerima parameter yang di POST melalui form edit.php
if (isset($_POST['id'], $_POST['nama_akun'], $_POST['pos_laporan'], $_POST['saldo_debit_awal'], $_POST['saldo_kredit_awal'], $_POST['lvl'], $_POST['lvl_diatas'])) {
    // Sanitize input
    $id = $_POST['id'];
    $nama_akun = $_POST['nama_akun'];
    $pos_laporan = $_POST["pos_laporan"];
    $saldo_debit_awal = $_POST['saldo_debit_awal'];
    $saldo_kredit_awal = $_POST['saldo_kredit_awal'];
    $lvl = $_POST['lvl'];
    $lvl_diatas = $_POST['lvl_diatas'];

    // Construct the SQL query and execute it
    $sql = "UPDATE 
            `daftar_akun` 
            SET 
            `nama_akun`='$nama_akun',
            `pos_laporan`='$pos_laporan',
            `saldo_debit_awal`='$saldo_debit_awal',
            `saldo_kredit_awal`='$saldo_kredit_awal',
            `lvl`='$lvl',
            `lvl_diatas`='$lvl_diatas' 
            WHERE 
            `daftar_akun`.`id`='$id'";
    $result = $conn->query($sql);

    // Check if the query was successful
    if ($result) {
        // Query executed successfully
        $response .= "Update for jurnal id '$id' was successful.";
    } else {
        // Query failed
        $response .= "Failed to update jurnal id '$id'.";
    }
} else {
    // Required parameters not received
    $response = "Required parameters are missing.";
}

// Send the response
echo $response;
?>
