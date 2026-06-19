<?php

$conn = mysqli_connect(
"localhost",
"root",
"",
"uas_dw"
);

if(!$conn){
    die("Koneksi gagal");
}
?>