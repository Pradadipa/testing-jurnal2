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
    <h1>Neraca Percobaan</h1>
    <h3>Periode : 22/02/2024 s/d 31/02/2024</h3>
    <table>
        <thead>
            <tr>
                <th>No Akun</th>
                <th>Nama Akun</th>
                <th>Debit</th>
                <th>Kredit</th>
            </tr>
        </thead>
        <tbody>
            <?php
            include 'dbconn.php';
            $sql_akun = 'SELECT id, nama_akun FROM daftar_akun';
            $result_akun = $conn->query($sql_akun);

            $sql = 'SELECT neraca.id_neraca, 
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
            INNER JOIN daftar_akun ON jurnal_detail.id_akun = daftar_akun.id';

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
                        if ($row['pos_saldo'] == 'Db') {
                            echo '<td style="text-align:center">' . number_format(abs($row['total_saldo'])) . '</td>';
                            echo '<td style="text-align:center">0</td>';
                            $debit = $debit + $row['total_saldo'];
                        } else {
                            echo '<td style="text-align:center">0</td>';
                            echo '<td style="text-align:center">' . number_format(abs($row['total_saldo'])) . '</td>';
                            $kredit = $kredit + $row['total_saldo'];
                        }
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
    <a href="index.php">back</a>
</body>

</html>