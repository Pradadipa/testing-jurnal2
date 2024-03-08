<?php

include 'dbconn.php';

// Ensure the level is set and not empty
if (isset($_POST['level']) && !empty($_POST['level'])) {
    // Escape the input to prevent SQL injection
    $level = mysqli_real_escape_string($conn, $_POST['level']);

    // Your SQL query
    $sql = "SELECT `id`, `nama_akun`, `pos_saldo`, `pos_laporan`, `saldo_debit_awal`, `saldo_kredit_awal`, `lvl`, `lvl_diatas` FROM `daftar_akun` WHERE `lvl` = ($level - 1)";

    // Perform the query
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        // Initialize an empty array to store the data
        $data = array();

        // Fetch data row by row using a while loop
        while ($row = mysqli_fetch_assoc($result)) {
            // Append each row to the data array
            $data[] = $row;
        }

        // Encode the data array as JSON and output it
        echo json_encode($data);
    } else {
        // Handle query error or empty result set
        echo json_encode(array('error' => 'No records found'));
    }
} else {
    // Handle missing or empty level parameter
    echo json_encode(array('error' => 'Level parameter is missing or empty'));
}
?>