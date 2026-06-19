<?php
include '../config/koneksi.php';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Data Produk</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<?php include '../navbar.php'; ?>

<div class="container mt-4">

    <h3>Data Produk</h3>

    <a href="tambah.php" class="btn btn-primary mb-3">
        Tambah Produk
    </a>

    <table class="table table-bordered table-striped">

        <thead class="table-dark">

        <tr>
            <th>ID</th>
            <th>Kode Produk</th>
            <th>Nama Produk</th>
            <th>Kategori</th>
            <th>Harga</th>
            <th width="180">Aksi</th>
        </tr>

        </thead>

        <tbody>

        <?php

        $query = mysqli_query(
            $conn,
            "SELECT * FROM dim_produk ORDER BY id_produk DESC"
        );

        while($data = mysqli_fetch_assoc($query)){

        ?>

        <tr>

            <td><?= $data['id_produk']; ?></td>

            <td><?= $data['kode_produk']; ?></td>

            <td><?= $data['nama_produk']; ?></td>

            <td><?= $data['kategori']; ?></td>

            <td>
                Rp <?= number_format($data['harga'],0,',','.'); ?>
            </td>

            <td>

                <a href="edit.php?id=<?= $data['id_produk']; ?>"
                   class="btn btn-warning btn-sm">
                    Edit
                </a>

                <a href="hapus.php?id=<?= $data['id_produk']; ?>"
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