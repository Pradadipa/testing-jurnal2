<?php

// Koneksi ke database
include 'dbconn.php';

// Inisialisasi respon
$response = "";

// Menerima parameter
if(isset($_POST['id'])) {
    // Sanitize input
    $id = $_POST['id'];

    // Membuat kueri untuk menghapus data dari tabel jurnal_detail
    $sql = "DELETE FROM `daftar_akun` WHERE  `daftar_akun`.`id`= '$id'";
    $result = $conn->query($sql);


    // Periksa apakah kueri berhasil
    if($result) {
        $response = "Akun berhasil dihapus.";
    } else {
        $response = "Gagal melakukan penghapusan.";
    }
}

// Keluarkan respons
echo $response;
?>
