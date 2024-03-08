<?php
$servername = "localhost:3307"; // Ganti dengan nama server database Anda
$username = "root"; // Ganti dengan nama pengguna database Anda
$password = ""; // Ganti dengan kata sandi database Anda
$database = "project"; // Ganti dengan nama database yang ingin Anda gunakan

// Membuat koneksi
$conn = new mysqli($servername, $username, $password, $database);

// if (mysqli_connect_error($conn)) {
//     echo "Kesalahan koneksi database";
// }