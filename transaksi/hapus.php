<?php

include '../config/koneksi.php';

$id = $_GET['id'];

mysqli_query(
$conn,
"DELETE FROM fact_penjualan
WHERE id_penjualan='$id'"
);

header("Location:index.php");