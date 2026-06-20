<?php
include '../config/koneksi.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

mysqli_query($conn, "DELETE FROM dim_waktu WHERE id_waktu='$id'");

header("Location:index.php?msg=deleted");
