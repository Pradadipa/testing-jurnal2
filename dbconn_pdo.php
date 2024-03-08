<?php

$servername = "localhost"; // Ganti dengan nama server database Anda
$username = "root"; // Ganti dengan nama pengguna database Anda
$password = ""; // Ganti dengan kata sandi database Anda
$database = "project"; // Ganti dengan nama database yang ingin Anda gunakan

try {
    // Membuat koneksi PDO
    $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);

    // Set mode error untuk penanganan kesalahan
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Atur mode fetch default ke associative array
    $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

    echo "Koneksi sukses";
} catch (PDOException $e) {
    echo "Koneksi gagal: " . $e->getMessage();
}
