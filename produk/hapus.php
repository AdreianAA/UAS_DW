<?php

include '../config/koneksi.php';

$id = $_GET['id'];

mysqli_query(
    $conn,
    "DELETE FROM dim_produk
     WHERE id_produk='$id'"
);

header("Location:index.php");