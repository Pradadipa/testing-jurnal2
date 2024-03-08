<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
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
    <h1>Master Akun</h1>
    <form class="form" method="post" action="insert_akun.php">
        <label for="id">id:</label>
        <input type="text" id="id" name="id"><br><br>

        <label for="nama_akun">Nama Akun:</label>
        <input type="text" id="nama_akun" name="nama_akun"><br><br>


        <label for="pos_laporan">Posisi Laporan:</label>
        <select name="pos_laporan" id="pos_laporan">
            <option value="">Pilih Pos Laporan</option>
            <option value="Db">Debit</option>
            <option value="Kr">Kredit</option>
        </select><br><br>

        <label for="pos_laporan">Saldo debit awal:</label>
        <input type="text" id="pos_laporan" value="0" name="pos_laporan"><br><br>

        <label for="pos_laporan">Saldo kredit awal:</label>
        <input type="text" id="pos_laporan" value="0" name="pos_laporan"><br><br>

        <label for="pos_laporan">Level Akun:</label>
        <select name="lvl" id="lvl">
            <option value="">Pilih Level Akun</option>
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
        </select><br><br>

        <label for="pos_laporan">Sub Akun dari:</label>
        <select name="lvl_diatas" id="lvl_diatas">
            <option value="">Pilih Sub Akun Dari</option>

        </select><br><br>

        <input type="submit" value="Submit">
    </form>

    <table id="table_akun" class="table">
        <thead>
            <tr>
                <th>id</th>
                <th>Nama Akun</th>
                <th>Posisi Saldo</th>
                <th>Posisi Laporan</th>
                <th>Saldo Debet Awal</th>
                <th>Saldo Kredit Awal</th>
                <th>Level Akun</th>
                <th>Sub Akun Dari</th>
            </tr>
        </thead>
        <tbody>
            <?php
            include 'dbconn.php';

            $sql = "SELECT `id`, `nama_akun`, `pos_saldo`, `pos_laporan`, `saldo_debit_awal`, `saldo_kredit_awal`,`lvl`,`lvl_diatas` FROM `daftar_akun` WHERE 1";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo '<td style="text-align:center">' . $row['id'] . '</td>';
                    echo '<td style="text-align:left">' . $row['nama_akun'] . '</td>';
                    echo '<td style="text-align:center">' . $row['pos_saldo'] . '</td>';
                    echo '<td style="text-align:center">' . $row['pos_laporan'] . '</td>';
                    echo '<td style="text-align:center">' . $row['saldo_debit_awal'] . '</td>';
                    echo '<td style="text-align:center">' . $row['saldo_kredit_awal'] . '</td>';
                    echo '<td style="text-align:center">' . $row['lvl'] . '</td>';
                    echo '<td style="text-align:center">' . $row['lvl_diatas'] . '</td>';
                    echo '<td style="text-align:center"><button class="edit-btn" data-id="' . $row['id'] . '">Edit</button></td>';
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='4'>Tidak ada data</td></tr>";
            }
            ?>
        </tbody>
    </table>


    <div>
        <a href="index.php">Back</a>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#lvl_diatas').prop('disabled', true);

            $('#lvl').on('change', function () {
                var selectedValue = $(this).val();
                console.log(selectedValue);

                if (selectedValue === '1' || selectedValue === '') {
                    // If Level Akun is 1, disable the Sub Akun dari select element
                    $('#lvl_diatas').prop('disabled', true);
                } else {
                    // Otherwise, enable the Sub Akun dari select element
                    $('#lvl_diatas').prop('disabled', false);

                    // Perform AJAX request to populate the options in the Sub Akun dari select element
                    $.ajax({
                        url: 'load_lvl.php',
                        method: 'post',
                        data: {
                            level: selectedValue
                        },
                        success: function (response) {
                            try {
                                console.log(response);
                                // Parse JSON response
                                var options = JSON.parse(response);

                                // Clear existing options
                                $('#lvl_diatas').empty();

                                // Append new options if available
                                if (options.length > 0) {
                                    $('#lvl_diatas').append('<option value="">Pilih Sub Akun Dari</option>');
                                    options.forEach(function (option) {
                                        $('#lvl_diatas').append('<option value="' + option.id + '">' + option.nama_akun + '</option>');
                                    });
                                } else {
                                    $('#lvl_diatas').append('<option value="">Tidak ada Sub Akun</option>');
                                }
                            } catch (error) {
                                console.error('Error parsing JSON:', error);
                                $('#lvl_diatas').empty().append('<option value="">Error fetching data</option>');
                            }
                        },
                        error: function (xhr, status, error) {
                            console.error('AJAX error:', error);
                            $('#lvl_diatas').empty().append('<option value="">Error fetching data</option>');
                        }
                    });
                }
            });

            // Tangani klik pada tombol "Edit"
            $('.edit-btn').click(function () {
                // Ambil nilai ID dari atribut data-id
                var id = $(this).data('id');
                window.location.href = 'edit_akun.php?id=' + id;
            });
        });



        // $.ajax({
        //     url: 'https://reqres.in/api/users',
        //     dataType: 'json',
        //     success: function (response) {
        //         console.log('Data berhasil diterima:', response);

        //         $('#table_akun');

        //         var table = $('#table_akun');

        //         // Iterasi melalui data yang diterima
        //         $.each(response.data, function (index, user) {
        //             // Membuat baris baru untuk setiap pengguna
        //             var row = $('<tr>');

        //             // Menambahkan sel-sel dengan data pengguna
        //             row.append($('<td>').text(user.id));
        //             row.append($('<td>').text(user.email));
        //             row.append($('<td>').text(user.first_name));
        //             row.append($('<td>').text(user.last_name));
        //             row.append($('<td>').text(user.avatar));

        //             // Menambahkan baris ke dalam tubuh tabel
        //             table.find('tbody').append(row);
        //         });

        //     },
        //     error: function (xhr, status, error) {
        //         console.log('Terjadi kesalahan:', error);
        //     }
        // });
    </script>
</body>

</html>