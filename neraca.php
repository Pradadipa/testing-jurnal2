<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        .td {
            text-align: center;
        }

        th {
            border: 1px solid black;
        }

        td {
            border: 1px solid black;
        }
    </style>
</head>

<body>
    <h1>Neraca</h1>
    <a href="laporan_neraca.php">Laporan Neraca</a>
    <div class="" style="display: flex;">

        <table>
            <thead>
                <tr>
                    <th>Kode Akun</th>
                    <th>Nama Akun</th>
                    <th>Saldo</th>
                    <th>Jumlah Saldo</th>
                </tr>
            </thead>
            <tbody>
                <?php
                include 'dbconn.php';
                $sql_akun = 'SELECT `id`, `nama_akun`, `pos_saldo`, `pos_laporan`, `saldo_debit_awal`, `saldo_kredit_awal`, `lvl`, `lvl_diatas` FROM `daftar_akun` WHERE `pos_laporan` = "NRC" AND `id` LIKE "1-1%"';

                $result_akun = $conn->query($sql_akun);

                $sql = "SELECT neraca.id_neraca, 
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
INNER JOIN jurnal_detail on buku_besar.id_jurnal_detail = jurnal_detail.id_jurnal_detail
INNER JOIN daftar_akun ON jurnal_detail.id_akun = daftar_akun.id
WHERE daftar_akun.pos_laporan = 'NRC'";

                $result = $conn->query($sql);
                $total_aktiva_lancar = 0;



                while ($row2 = $result_akun->fetch_assoc()) {
                    echo "<tr>";
                    echo '<td style="text-align:center">' . $row2['id'] . '</td>';
                    echo '<td style="text-align:center">' . $row2['nama_akun'] . '</td>';

                    // Kembalikan kursor ke posisi awal
                    $result->data_seek(0);

                    // Inisialisasi variabel boolean untuk menandai apakah ada baris yang sesuai
                    $found = false;

                    while ($row = $result->fetch_assoc()) {
                        if ($row['id_akun'] == $row2['id']) {
                            $found = true; // Set variabel found menjadi true karena ada baris yang sesuai
                            echo '<td style="text-align:center">' . number_format(abs($row['total_saldo'])) . '</td>';
                            echo '<td style="text-align:center"></td>';

                            $total_aktiva_lancar += $row['total_saldo'];
                        }
                    }

                    // Jika tidak ada baris yang sesuai, cetak debit dan kredit 0
                    if (!$found) {
                        echo '<td style="text-align:center">0</td>';
                        echo '<td style="text-align:center"></td>';
                    }

                    echo "</tr>";
                }


                ?>
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="2">Jumlah Aktiva Lancar
                    </th>
                    <th>

                    </th>
                    <th>
                        <?= number_format(abs($total_aktiva_lancar)) ?>
                    </th>
                </tr>
            </tfoot>
        </table>
        <table style="margin-left: 20px;">
            <thead>
                <tr>
                    <th>Kode Akun</th>
                    <th>Nama Akun</th>
                    <th>Saldo</th>
                    <th>Jumlah Saldo</th>
                </tr>
            </thead>
            <tbody>
                <?php
                include 'dbconn.php';
                $sql_akun = 'SELECT `id`, `nama_akun`, `pos_saldo`, `pos_laporan`, `saldo_debit_awal`, `saldo_kredit_awal`, `lvl`, `lvl_diatas` FROM `daftar_akun` WHERE `pos_laporan` = "NRC" AND `id` LIKE "2-%"  ';
                $result_akun = $conn->query($sql_akun);

                $sql = "SELECT neraca.id_neraca, 
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
INNER JOIN jurnal_detail on buku_besar.id_jurnal_detail = jurnal_detail.id_jurnal_detail
INNER JOIN daftar_akun ON jurnal_detail.id_akun = daftar_akun.id
WHERE daftar_akun.pos_laporan = 'NRC'";

                $result = $conn->query($sql);

                $debit = 0;
                $kredit = 0;



                while ($row2 = $result_akun->fetch_assoc()) {
                    echo "<tr>";
                    echo '<td style="text-align:center">' . $row2['id'] . '</td>';
                    echo '<td style="text-align:center">' . $row2['nama_akun'] . '</td>';

                    // Kembalikan kursor ke posisi awal
                    $result->data_seek(0);

                    // Inisialisasi variabel boolean untuk menandai apakah ada baris yang sesuai
                    $found = false;

                    while ($row = $result->fetch_assoc()) {
                        if ($row['id_akun'] == $row2['id']) {
                            $found = true; // Set variabel found menjadi true karena ada baris yang sesuai
                            echo '<td style="text-align:center">' . number_format(abs($row['total_saldo'])) . '</td>';
                            echo '<td style="text-align:center">0</td>';
                        }
                    }

                    // Jika tidak ada baris yang sesuai, cetak debit dan kredit 0
                    if (!$found) {
                        echo '<td style="text-align:center">0</td>';
                        echo '<td style="text-align:center">0</td>';
                    }

                    echo "</tr>";
                }



                ?>
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="2">Total</th>
                    <th>
                        <?= number_format(abs($debit)) ?>
                    </th>
                    <th>
                        <?= number_format(abs($kredit)) ?>
                    </th>
                </tr>
            </tfoot>
        </table>
    </div>
    <table>
        <thead>
            <tr>
                <th>Kode Akun</th>
                <th>Nama Akun</th>
                <th>Saldo</th>
                <th>Jumlah Saldo</th>
            </tr>
        </thead>
        <tbody>
            <?php
            include 'dbconn.php';
            $sql_akun = 'SELECT `id`, `nama_akun`, `pos_saldo`, `pos_laporan`, `saldo_debit_awal`, `saldo_kredit_awal`, `lvl`, `lvl_diatas` FROM `daftar_akun` WHERE `pos_laporan` = "NRC" AND `id` LIKE "1-2%"';

            $result_akun = $conn->query($sql_akun);

            $sql = "SELECT neraca.id_neraca, 
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
INNER JOIN jurnal_detail on buku_besar.id_jurnal_detail = jurnal_detail.id_jurnal_detail
INNER JOIN daftar_akun ON jurnal_detail.id_akun = daftar_akun.id
WHERE daftar_akun.pos_laporan = 'NRC'";

            $result = $conn->query($sql);
            $total_aktiva_lancar = 0;



            while ($row2 = $result_akun->fetch_assoc()) {
                echo "<tr>";
                echo '<td style="text-align:center">' . $row2['id'] . '</td>';
                echo '<td style="text-align:center">' . $row2['nama_akun'] . '</td>';

                // Kembalikan kursor ke posisi awal
                $result->data_seek(0);

                // Inisialisasi variabel boolean untuk menandai apakah ada baris yang sesuai
                $found = false;

                while ($row = $result->fetch_assoc()) {
                    if ($row['id_akun'] == $row2['id']) {
                        $found = true; // Set variabel found menjadi true karena ada baris yang sesuai
                        echo '<td style="text-align:center">' . number_format(abs($row['total_saldo'])) . '</td>';
                        echo '<td style="text-align:center"></td>';

                        $total_aktiva_lancar += $row['total_saldo'];
                    }
                }

                // Jika tidak ada baris yang sesuai, cetak debit dan kredit 0
                if (!$found) {
                    echo '<td style="text-align:center">0</td>';
                    echo '<td style="text-align:center"></td>';
                }

                echo "</tr>";
            }


            ?>
        </tbody>
        <tfoot>
            <tr>
                <th colspan="2">Jumlah Aktiva Lancar
                </th>
                <th>

                </th>
                <th>
                    <?= number_format(abs($total_aktiva_lancar)) ?>
                </th>
            </tr>
        </tfoot>
    </table>
    <table style="margin-left: 20px;">
        <thead>
            <tr>
                <th>Kode Akun</th>
                <th>Nama Akun</th>
                <th>Saldo</th>
                <th>Jumlah Saldo</th>
            </tr>
        </thead>
        <tbody>
            <?php
            include 'dbconn.php';
            $sql_akun = 'SELECT `id`, `nama_akun`, `pos_saldo`, `pos_laporan`, `saldo_debit_awal`, `saldo_kredit_awal`, `lvl`, `lvl_diatas` FROM `daftar_akun` WHERE `pos_laporan` = "NRC" AND `id` LIKE "3-%"  ';
            $result_akun = $conn->query($sql_akun);

            $sql = "SELECT neraca.id_neraca, 
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
INNER JOIN jurnal_detail on buku_besar.id_jurnal_detail = jurnal_detail.id_jurnal_detail
INNER JOIN daftar_akun ON jurnal_detail.id_akun = daftar_akun.id
WHERE daftar_akun.pos_laporan = 'NRC'";

            $result = $conn->query($sql);

            $total_aktiva_lancar = 0;



            while ($row2 = $result_akun->fetch_assoc()) {
                echo "<tr>";
                echo '<td style="text-align:center">' . $row2['id'] . '</td>';
                echo '<td style="text-align:center">' . $row2['nama_akun'] . '</td>';

                // Kembalikan kursor ke posisi awal
                $result->data_seek(0);

                // Inisialisasi variabel boolean untuk menandai apakah ada baris yang sesuai
                $found = false;

                while ($row = $result->fetch_assoc()) {
                    if ($row['id_akun'] == $row2['id']) {
                        $found = true; // Set variabel found menjadi true karena ada baris yang sesuai
                        echo '<td style="text-align:center">' . number_format(abs($row['total_saldo'])) . '</td>';
                        echo '<td style="text-align:center">0</td>';

                        $total_aktiva_lancar += $row['total_saldo'];
                    }
                }

                // Jika tidak ada baris yang sesuai, cetak debit dan kredit 0
                if (!$found) {
                    echo '<td style="text-align:center">0</td>';
                    echo '<td style="text-align:center">0</td>';
                }

                echo "</tr>";
            }



            ?>
        </tbody>
        <tfoot>
            <tr>
                <th colspan="2">Total</th>
                <th>
                    <?= number_format(abs($total_aktiva_lancar)) ?>
                </th>
                <th>
                </th>
            </tr>
        </tfoot>
    </table>

    <a href="index.php">Back</a>
</body>

</html>