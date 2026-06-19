<?php
include '../config/koneksi.php';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Data Pelanggan</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-4">

    <h3>Data Pelanggan</h3>

    <a href="tambah.php" class="btn btn-primary mb-3">
        Tambah Pelanggan
    </a>

    <table class="table table-bordered table-striped">

        <thead class="table-dark">

        <tr>
            <th>ID</th>
            <th>Kode Pelanggan</th>
            <th>Nama Pelanggan</th>
            <th>Jenis Kelamin</th>
            <th>Kota</th>
            <th width="180">Aksi</th>
        </tr>

        </thead>

        <tbody>

        <?php

        $query = mysqli_query(
            $conn,
            "SELECT * FROM dim_pelanggan
             ORDER BY id_pelanggan DESC"
        );

        while($data = mysqli_fetch_assoc($query)){

        ?>

        <tr>

            <td><?= $data['id_pelanggan']; ?></td>

            <td><?= $data['kode_pelanggan']; ?></td>

            <td><?= $data['nama_pelanggan']; ?></td>

            <td><?= $data['jenis_kelamin']; ?></td>

            <td><?= $data['kota']; ?></td>

            <td>

                <a href="edit.php?id=<?= $data['id_pelanggan']; ?>"
                   class="btn btn-warning btn-sm">
                    Edit
                </a>

                <a href="hapus.php?id=<?= $data['id_pelanggan']; ?>"
                   class="btn btn-danger btn-sm"
                   onclick="return confirm('Yakin hapus data?')">
                    Hapus
                </a>

            </td>

        </tr>

        <?php } ?>

        </tbody>

    </table>

</div>

</body>
</html>