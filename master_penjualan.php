<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <h1>Master Penjualan</h1>

    <form class="form" method="post" action="insert_master_penjualan.php">
        <input type="hidden" id="id_penjualan" name="id_penjualan"><br><br>
        <label for="nama_akun">Nama Penjualan</label>
        <input type="text" id="nama_penjualan" name="nama_penjualan"><br><br>
        <label for="id_akun">Pilih Akun</label>
        <select name="id_akun" id="id_akun">
            <option value="">Pilih Akun</option>
            <?php
            include 'dbconn.php';
            $sql = "SELECT `id`, `nama_akun` FROM `daftar_akun` WHERE 1";
            $result = $conn->query($sql);
            while ($row = $result->fetch_assoc()) {
                echo '<option value="' . $row['id'] . '">[' . $row['id'] . '] ' . $row['nama_akun'] . '</option>';
            }
            ?>

        </select><br><br>

        <input type="submit" value="Submit">
    </form>

    <table>
        <thead>
            <tr>
                <th>Nomor</th>
                <th>Nama Penjualan</th>
                <th>Id Akun</th>
            </tr>
        </thead>
        <tbody>
            <?php

            include 'dbconn.php';
            $sql = " SELECT `id_penjualan`, `nama_penjualan`, `id_akun` FROM `penjualan` WHERE 1";
            $result = $conn->query($sql);


            while ($row = $result->fetch_assoc()) {
                echo '<tr>';
                echo '<td>' . $row['id_penjualan'] . '</td>';
                echo '<td>' . $row['nama_penjualan'] . '</td>';
                echo '<td>' . $row['id_akun'] . '</td>';
                echo '<td style="text-align:center"><button class="edit-btn-penjualan" data-id="' . $row['id_penjualan'] . '">Edit</button></td>';
                echo '</tr>';
            }
            ?>
        </tbody>
    </table>
    <a href="index.php">back</a>
</body>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    // Handle click on the "Edit" button
    $('.edit-btn-penjualan').click(function () {
        // Get the ID from the data-id attribute
        var id = $(this).data('id');
        // Redirect to the edit page with the ID parameter
        window.location.href = 'edit_penjualan.php?id=' + id;
    });
</script>

</html>