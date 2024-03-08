<?php
include 'dbconn.php';

$tanggal = $_POST['tanggal'];
$jenis_pembayaran = $_POST['jenis_pembayaran'];
$nama_akun_array = $_POST['nama_akun'];
$bayar = $_POST['bayar'];
$debet = 0;
$kredit = 0;

echo $tanggal;
echo '<br>';
echo $jenis_pembayaran;
echo '<br>';
foreach ($nama_akun_array as $nama_akun) {
    echo $nama_akun;
    echo '<br>';
}
echo $bayar;
echo '<br>';

// Query untuk memasukkan data jurnal hanya sekali di luar loop foreach
$sql_insert_jurnal = "INSERT INTO `jurnal` (`tanggal`, `keterangan`) VALUES ('$tanggal','$jenis_pembayaran')";
if ($conn->query($sql_insert_jurnal) === TRUE) {
    $jurnal_id = $conn->insert_id; // Mendapatkan ID jurnal yang baru saja dimasukkan

    foreach ($nama_akun_array as $nama_akun) {
        // Query untuk mendapatkan posisi saldo dari akun saat ini
        $sql_pos_saldo = "SELECT pos_saldo FROM daftar_akun WHERE id = '$nama_akun'";
        $result_pos_saldo = $conn->query($sql_pos_saldo);

        if ($result_pos_saldo->num_rows > 0) {
            $row = $result_pos_saldo->fetch_assoc();
            $pos_saldo = $row['pos_saldo'];

            // Menentukan nilai debit dan kredit berdasarkan posisi saldo
            if ($pos_saldo == 'Db') {
                $debet = $bayar;
                $kredit = 0;
            } else if ($pos_saldo == 'Kr') {
                $debet = 0;
                $kredit = $bayar;
            } else {
                // Tangani kasus jika posisi saldo tidak valid
                echo "Error: Posisi saldo tidak valid untuk akun '$nama_akun'";
                continue; // Melanjutkan iterasi ke akun berikutnya
            }

            // Memasukkan data detil jurnal ke database
            $sql_detil = "INSERT INTO jurnal_detail (id_jurnal, id_akun, debit, kredit) VALUES ('$jurnal_id', '$nama_akun', '$debet', '$kredit')";
            if ($conn->query($sql_detil) !== TRUE) {
                echo "Error: " . $sql_detil . "<br>" . $conn->error;
                break;
            }

            $id_jurnal_detail = $conn->insert_id;

            // Query untuk mengambil saldo sebelumnya
            $sql_saldo_sebelumnya = "SELECT buku_besar.saldo FROM buku_besar JOIN jurnal ON buku_besar.id_jurnal = jurnal.id_jurnal JOIN jurnal_detail ON buku_besar.id_jurnal_detail = jurnal_detail.id_jurnal_detail WHERE jurnal_detail.id_akun = '$nama_akun' ORDER BY buku_besar.id_buku_besar DESC LIMIT 1";

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

            // Memasukkan data ke dalam tabel buku besar
            $sql_buku_besar = "INSERT INTO buku_besar (id_jurnal,id_jurnal_detail, saldo) VALUES ('$jurnal_id',$id_jurnal_detail ,'$saldo')";
            $result_buku_besar = $conn->query($sql_buku_besar);

            // Periksa apakah kueri berhasil dijalankan
            if (!$result_buku_besar) {
                // Jika gagal, tangani kesalahan
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
                    header("Location: penjualan.php");
                }
            }
        } else {
            echo "Error: Tidak dapat menemukan posisi saldo untuk akun '$nama_akun'";
        }
    }
} else {
    echo "Error: " . $sql_insert_jurnal . "<br>" . $conn->error;
}

// Tutup koneksi
$conn->close();
?>