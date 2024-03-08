<?php
include 'dbconn.php';

// Tangani data yang dikirim dari formulir
$tanggal = $_POST['tanggal'];
$nama_akun_array = $_POST['nama_akun']; // Gunakan nama yang berbeda untuk array
$keterangan = $_POST['keterangan'];
$debet_array = $_POST['debet']; // Gunakan nama yang berbeda untuk array
$kredit_array = $_POST['kredit']; // Gunakan nama yang berbeda untuk array

$sql = "INSERT INTO `jurnal` (`tanggal`, `keterangan`) VALUES ('$tanggal','$keterangan')";
if ($conn->query($sql) === TRUE) {
    $jurnal_id = $conn->insert_id; // Mendapatkan ID jurnal yang baru saja dimasukkan
    // Loop melalui setiap nama akun, debet, dan kredit
    for ($i = 0; $i < count($debet_array); $i++) { // Gunakan nama array yang benar
        $nama_akun = $nama_akun_array[$i]; // Gunakan nama variabel yang berbeda untuk elemen individu
        $debet = $debet_array[$i]; // Gunakan nama variabel yang berbeda untuk elemen individu
        $kredit = $kredit_array[$i]; // Gunakan nama variabel yang berbeda untuk elemen individu

        echo "Proses nama akun" . $i . $nama_akun;
        echo "<br>";
        echo "Proses debet" . $i . $debet;
        echo "<br>";
        echo "Proses kredit " . $i . $kredit;
        echo "<br>";

        // Memasukkan data detil jurnal ke database
        $sql_detil = "INSERT INTO jurnal_detail (id_jurnal, id_akun, debit, kredit) VALUES ('$jurnal_id', '$nama_akun', '$debet', '$kredit')";
        if ($conn->query($sql_detil) !== TRUE) {
            echo "Error: " . $sql_detil . "<br>" . $conn->error;
            break;
        }

        $id_jurnal_detail = $conn->insert_id;

        $sql_saldo_sebelumnya = "SELECT 
    buku_besar.saldo
FROM 
    buku_besar
JOIN
    jurnal ON buku_besar.id_jurnal = jurnal.id_jurnal
JOIN 
    jurnal_detail ON buku_besar.id_jurnal_detail = jurnal_detail.id_jurnal_detail
WHERE jurnal_detail.id_akun = '$nama_akun'
ORDER BY 
    buku_besar.id_buku_besar DESC
LIMIT 1";

        $result_saldo_sebelumnya = $conn->query($sql_saldo_sebelumnya);

        // Periksa apakah kueri berhasil dieksekusi
        if ($result_saldo_sebelumnya) {
            // Ambil baris pertama dari hasil kueri
            $row = $result_saldo_sebelumnya->fetch_assoc();
            // Ambil nilai saldo dari baris tersebut
            $saldo_sebelumnya = isset($row['saldo']) ? $row['saldo'] : 0;
        } else {
            // Jika kueri gagal, tangani kesalahan
            echo "Error: " . $sql_saldo_sebelumnya . "<br>" . $conn->error;
        }

        $saldo = $saldo_sebelumnya + ($debet - $kredit);

        echo "Proses saldo sebelumnya" . $i . $saldo_sebelumnya;
        echo "<br>";
        echo "Proses saldo setelah dikurangi" . $i . $saldo;
        echo "<br>";

        // Gunakan ID jurnal dan saldo tersebut untuk memasukkan data ke dalam tabel buku besar
        $sql_buku_besar = "INSERT INTO buku_besar (id_jurnal,id_jurnal_detail, saldo) VALUES ('$jurnal_id',$id_jurnal_detail ,'$saldo')";
        $result_buku_besar = $conn->query($sql_buku_besar);

        //     // Periksa apakah kueri berhasil dijalankan
        if (!$result_buku_besar) {
            //         // Jika gagal, tangani kesalahan
            echo "Error: " . $sql_buku_besar . "<br>" . $conn->error;
        } else {
            $id_buku_besar = $conn->insert_id;

            $sql_select_neraca = "SELECT neraca.id_neraca, 
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
            INNER JOIN jurnal_detail ON buku_besar.id_jurnal_detail = jurnal_detail.id_jurnal_detail
            INNER JOIN daftar_akun ON jurnal_detail.id_akun = daftar_akun.id
            WHERE daftar_akun.id = '$nama_akun'";

            $result_select_neraca = $conn->query($sql_select_neraca);

            // Periksa apakah ada hasil seleksi
            if ($result_select_neraca->num_rows > 0) {
                // Jika data sudah ada, lakukan update
                $sql_neraca = "UPDATE neraca SET total_saldo = '$saldo' , id_buku_besar = $id_buku_besar WHERE id_akun = '$nama_akun'";
            } else {
                // Jika data belum ada, lakukan insert
                $sql_neraca = "INSERT INTO neraca (id_buku_besar,id_akun , total_saldo) VALUES ('$id_buku_besar','$nama_akun', '$saldo')";
            }

            // Jalankan kueri SQL untuk insert atau update
            $result_neraca = $conn->query($sql_neraca);

            // Periksa apakah kueri berhasil dijalankan
            if (!$result_neraca) {
                // Jika gagal, tangani kesalahan
                echo "Error: " . $sql_neraca . "<br>" . $conn->error;
            } else {
                // Jika berhasil, kembalikan ke halaman sebelumnya atau arahkan ke halaman lain
                echo "Data neraca berhasil ditambahkan";
                // Contoh: Kembalikan ke halaman utama
                header("Location: jurnal.php");
            }


        }
    }
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// Tutup koneksi
$conn->close();
