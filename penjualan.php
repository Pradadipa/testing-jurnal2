<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <h1>Penjualan</h1>

    <form action="insert_penjualan.php" method="post">
        <div class="form-input">
            <label for="">Tanggal Transaksi</label>
            <input type="date" id="tanggal" name="tanggal" format-date="dd-mm-yyyy" value="<?= date('Y-m-d') ?>">
        </div>

        <div class="form-input">
            <label for="">Jenis Pembayaran</label>
            <select name="jenis_pembayaran" id="jenis_pembayaran">
                <option value="">Pilih Jenis Pembayaran</option>
                <?php
                include 'dbconn.php';
                $sql = "SELECT `id_penjualan`, `nama_penjualan`, `id_akun` FROM `penjualan` WHERE 1";
                $result = $conn->query($sql);

                while ($row = $result->fetch_assoc()) {
                    echo '<option value="' . $row['id'] . '">' . $row['nama_penjualan'] . '</option>';
                }

                ?>
                <!-- <option value="Pendapatan Ticket Masuk">Penjualan Ticket Masuk</option>
                <option value="Pendapatan Camping">Pendapatan Camping</option>
                <option value="Pendapatan Tubing">Pendapatan Tubing</option>
                <option value="Penjualan Makanan & Minuman">Penjualan Makanan & Minuman</option> -->
            </select>
        </div>

        <div class="form-input">
            <label for="">Tipe Pembayaran</label>
            <select name="nama_akun[]" id="nama_akun">
                <option value="">Pilih Tipe Pembayaran</option>
                <option value="1-1110">Cash</option>
                <option value="1-1200">Bank</option>
            </select>
        </div>

        <!-- Correcting the attribute name to "name" -->
        <input id="nama_akun" name="nama_akun[]" type="hidden" value="4-0000">

        <label for="">Jumlah Penjualan</label>
        <input type="number" id="bayar" name="bayar">

        <div>
            <button type="submit">Simpan</button>
        </div>
    </form>
    <a href="index.php">back</a>
</body>

</html>