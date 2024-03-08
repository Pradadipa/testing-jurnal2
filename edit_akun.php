<?php
// Include file koneksi ke database
include 'dbconn.php';

// Initialize variables
$id = $nama_akun = $pos_laporan = $saldo_debit_awal = $saldo_kredit_awal = $lvl = $lvl_diatas = '';

// Function to retrieve account data by ID
function getAccountData($conn, $id)
{
    $id = mysqli_real_escape_string($conn, $id);
    $sql = "SELECT * FROM `daftar_akun` WHERE `id` = '$id'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        return $result->fetch_assoc();
    }
    return false;
}

// Check if parameter ID is provided in URL
if (isset($_GET['id'])) {
    // Retrieve account data
    $accountData = getAccountData($conn, $_GET['id']);
    if ($accountData) {
        // Assign values to variables
        $id = $accountData['id'];
        $nama_akun = $accountData['nama_akun'];
        $pos_laporan = $accountData['pos_laporan'];
        $saldo_debit_awal = $accountData['saldo_debit_awal'];
        $saldo_kredit_awal = $accountData['saldo_kredit_awal'];
        $lvl = $accountData['lvl'];
        $lvl_diatas = $accountData['lvl_diatas'];
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Akun</title>
</head>

<body>
    <h1>Edit Akun</h1>
    <form class="form" method="POST" action="action_update_akun.php">
        <!-- Hidden field to pass ID -->
        <input type="hidden" name="id" value="<?php echo $id; ?>">

        <!-- Form fields -->
        <label for="nama_akun">Nama Akun:</label>
        <input type="text" id="nama_akun" name="nama_akun" value="<?php echo $nama_akun; ?>"><br><br>

        <label for="pos_laporan">Posisi Laporan:</label>
        <select name="pos_laporan" id="pos_laporan">
            <option value="">Pilih Pos Laporan</option>
            <option value="Db" <?php if ($pos_laporan == 'Db')
                echo 'selected'; ?>>Debit</option>
            <option value="Kr" <?php if ($pos_laporan == 'Kr')
                echo 'selected'; ?>>Kredit</option>
        </select><br><br>

        <label for="saldo_debit_awal">Saldo Debit Awal:</label>
        <input type="text" id="saldo_debit_awal" name="saldo_debit_awal"
            value="<?php echo $saldo_debit_awal; ?>"><br><br>

        <label for="saldo_kredit_awal">Saldo Kredit Awal:</label>
        <input type="text" id="saldo_kredit_awal" name="saldo_kredit_awal"
            value="<?php echo $saldo_kredit_awal; ?>"><br><br>

        <label for="lvl">Level Akun:</label>
        <select name="lvl" id="lvl">
            <option value="">Pilih Level Akun</option>
            <?php for ($i = 1; $i <= 5; $i++) {
                echo "<option value=\"$i\"";
                if ($lvl == $i)
                    echo ' selected';
                echo ">$i</option>";
            } ?>
        </select><br><br>

        <label for="lvl_diatas">Sub Akun dari:</label>
        <select name="lvl_diatas" id="lvl_diatas">
            <option value="">Pilih Sub Akun Dari</option>
            <!-- Options will be populated dynamically via AJAX -->
        </select><br><br>

        <input type="submit" value="Update">
    </form>
    <div id="delete-jurnal">
        <form method="POST" action="action_delete_akun.php">
            <input type="hidden" name="id" value="<?php echo $id?>">
            <button>Hapus</button>
        </form>
    </div>

    <a href="master_akun.php">Master Akun</a>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <script>
        // Initially disable the "Sub Akun dari" select element

        var selectedValue = <?php echo $lvl; ?>;
        console.log(selectedValue);
        // Check if there's a selected value for Sub Akun dari
        var selectedLvlDiatas = '<?php echo $lvl_diatas; ?>';
        if (selectedLvlDiatas !== '') {
            $('#lvl_diatas').val(selectedLvlDiatas);
        }

        $.ajax({
            url: 'load_lvl.php',
            method: 'post',
            data: {
                level: selectedValue
            },
            success: function (response) {

                // Parse JSON response
                var options = JSON.parse(response);

                // Clear existing options
                $('#lvl_diatas').empty();

                $('#lvl_diatas').append('<option value="">' + "Pilih Sub Akun Dari" + '</option>');
                // Append new options
                options.forEach(function (option) {
                    $('#lvl_diatas').append('<option value="' + option.id + '">[' + option.id + ']' + option.nama_akun + '</option>');
                });

                // Select the previously selected Sub Akun dari, if any
                $('#lvl_diatas').val(selectedLvlDiatas);
            },
            error: function (xhr, status, error) {
                // Handle errors here
            }
        });

        console.log(selectedLvlDiatas);

        $('#lvl').on('change', function () {
            selectedValue = $(this).val();

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

                        // Parse JSON response
                        var options = JSON.parse(response);

                        // Clear existing options
                        $('#lvl_diatas').empty();

                        $('#lvl_diatas').append('<option value="">' + "Pilih Sub Akun Dari" + '</option>');
                        // Append new options
                        options.forEach(function (option) {
                            $('#lvl_diatas').append('<option value="' + option.id + '">[' + option.id + ']' + option.nama_akun + '</option>');
                        });

                        // Select the previously selected Sub Akun dari, if any
                    },
                    error: function (xhr, status, error) {
                        // Handle errors here
                    }
                });
            }
        });
    </script>
</body>

</html>