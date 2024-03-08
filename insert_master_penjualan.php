<?php
include 'dbconn.php';
$nama_penjualan = $_POST['nama_penjualan'];
$nama_akun = $_POST['id_akun'];

$sql = "INSERT INTO `penjualan`( `nama_penjualan`, `id_akun`) VALUES ('$nama_penjualan','$nama_akun')";
$result = $conn->query($sql);

if ($result) {
    header("location:master_penjualan.php");
}