<?php

include '../config/koneksi.php';

$id = $_GET['id'];

mysqli_query(
    $conn,
    "DELETE FROM dim_pelanggan
     WHERE id_pelanggan='$id'"
);

header("Location:index.php");