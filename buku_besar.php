<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <style>
        table {
            margin: 0 auto;
            /* Mengatur margin secara otomatis di kiri dan kanan */
        }

        th,
        td {
            /* Memberikan padding agar konten tidak terlalu berdekatan dengan border */
            border: 1px solid black;
            /* Menambahkan border pada sel */
        }
    </style>
</head>

<body style="text-align: center;">
    <h1>Buku Besar</h1>
    <h3>Periode : 02/02/2023 s/d 31-08-2023</h3>
    <h3>Seluruh Akun</h3>
    <h3>Pilih Akun</h3>
    <select name="akun" id="akun">
        <option value="">Pilih Akun</option>
        <?php
        include 'dbconn.php';
        $sql = "SELECT `id`, `nama_akun`, `pos_saldo`, `pos_laporan`, `saldo_debit_awal`, `saldo_kredit_awal` FROM `daftar_akun`";

        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<option value='" . $row['id'] . "'>[" . $row['id'] . '] ' . $row['nama_akun'] . "</option>";
            }
        }
        ?>
    </select>

    <div>

    </div>
    <table style="margin-top: 20px;">
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>No Bukti</th>
                <th>Keterangan</th>
                <th>Debet</th>
                <th>Kredit</th>
                <th>Saldo</th>
            </tr>
        </thead>
        <tbody id="buku-besar-table-body">
            <tr>
                <td colspan="7">Pilih Akun</td>
            </tr>

        </tbody>
    </table>
    <a style="text-align: start !important;" href="index.php">Back</a>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        // Skrip Anda yang menggunakan jQuery
        var selectAccount = document.getElementById('akun').value;
        $(document).ready(function () {
            document.getElementById('akun').addEventListener('change', function () {
                // Mengambil nilai yang dipilih dari dropdown
                var selectAccount = this.value;
                // Menampilkan nilai yang dipilih dalam konsol
                console.log(selectAccount);

                // Setelah Anda menerima respons dari permintaan Ajax
                $.ajax({
                    url: 'load_bukuBesar.php',
                    type: 'post',
                    dataType: 'html', // Ubah menjadi html jika Anda merespons dengan HTML
                    data: { id_akun: selectAccount },
                    success: function (response) {
                        // Menampilkan respons di dalam elemen tbody
                        $('#buku-besar-table-body').html(response);
                    },
                    error: function () {
                        // Tangani kesalahan jika terjadi
                    }
                });

            });
        });
    </script>

</body>

</html>