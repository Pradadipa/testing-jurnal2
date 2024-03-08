<?php
// Include file koneksi ke database
include 'dbconn.php';

// Initialize variables
$id_penjualan = $nama_penjualan = $id_akun = '';

// Function to retrieve account data by ID
function getPenjualanData($conn, $id_penjualan)
{
    $id_penjualan = mysqli_real_escape_string($conn, $id_penjualan);
    $sql = "SELECT * FROM `penjualan` WHERE `id_penjualan` = '$id_penjualan'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        return $result->fetch_assoc();
    }
    return false;
}

// Check if parameter ID is provided in URL
if (isset($_GET['id_penjualan'])) {
    // Retrieve account data
    $penjualanData = getPenjualanData($conn, $_GET['id_penjualan']);
    if ($penjualanData) {
        // Assign values to variables
        $id_penjualan = $penjualanData['id_penjualan'];
        $nama_penjualan = $penjualanData['nama_penjualan'];
        $id_akun = $penjualanData['id_akun'];
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Penjualan</title>
</head>

<body>
    <h1>Edit Penjualan</h1>
    <form class="form" method="POST" action="action_update_akun.php">
        <!-- Hidden field to pass ID -->
        <input type="hidden" name="id_penjualan" value="<?php echo $id_penjualan; ?>">

        <!-- Form fields -->
        <label for="nama_penjualan">Nama Penjualan:</label>
        <input type="text" id="nama_penjualan" name="nama_penjualan" value="<?php echo $nama_penjualan; ?>"><br><br>
        <label for="id_akun">Pilih Akun</label>
        <select name="id_akun" id="id_akun">
            <option value="">Pilih Akun</option>
            <?php
            $sql = "SELECT `id`, `nama_akun` FROM `daftar_akun` WHERE 1";
            $result = $conn->query($sql);
            while ($row = $result->fetch_assoc()) {
                $selected = ($row['id'] == $id_akun) ? 'selected' : '';
                echo '<option value="' . $row['id'] . '" ' . $selected . '>[' . $row['id'] . '] ' . $row['nama_akun'] . '</option>';
            }
            ?>
        </select><br><br>
        <input type="submit" value="Update">
    </form>
    <div id="delete-jurnal">
        <form method="POST" action="action_delete_akun.php">
            <input type="hidden" name="id_penjualan" value="<?php echo $id_penjualan; ?>">
            <button>Hapus</button>
        </form>
    </div>

    <a href="master_akun.php">Master Akun</a>
</body>

</html>
