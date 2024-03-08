<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Include the database connection
    include 'dbconn.php';

    // Escape user inputs for security
    $id = mysqli_real_escape_string($conn, $_POST['id']);
    $nama_akun = mysqli_real_escape_string($conn, $_POST['nama_akun']);
    $pos_laporan = mysqli_real_escape_string($conn, $_POST['pos_laporan']);
    // Set default values for saldo_debit_awal and saldo_kredit_awal
    $saldo_debit_awal = isset($_POST['saldo_debit_awal']) ? mysqli_real_escape_string($conn, $_POST['saldo_debit_awal']) : 0;
    $saldo_kredit_awal = isset($_POST['saldo_kredit_awal']) ? mysqli_real_escape_string($conn, $_POST['saldo_kredit_awal']) : 0;

    $lvl = mysqli_real_escape_string($conn, $_POST['lvl']);
    $lvl_diatas = mysqli_real_escape_string($conn, $_POST['lvl_diatas']);

    // Attempt insert query execution
    $sql = "INSERT INTO daftar_akun (id, nama_akun, pos_laporan, saldo_debit_awal, saldo_kredit_awal, lvl, lvl_diatas) VALUES ('$id', '$nama_akun', '$pos_laporan', '$saldo_debit_awal', '$saldo_kredit_awal', '$lvl', '$lvl_diatas')";

    if (mysqli_query($conn, $sql)) {
        echo "Records added successfully.";
        header('location:master_akun.php');
    } else {
        echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
    }

    // Close connection
    mysqli_close($conn);
}
