<?php
include '../config/koneksi.php';

$data = mysqli_query(
$conn,
"SELECT * FROM dim_produk"
);
?>

<a href="tambah.php"
class="btn btn-success">
Tambah Produk
</a>

<table class="table">

<tr>
<th>ID</th>
<th>Kode</th>
<th>Nama</th>
<th>Kategori</th>
<th>Harga</th>
<th>Aksi</th>
</tr>

<?php while($d=mysqli_fetch_array($data)){ ?>

<tr>

<td><?= $d['id_produk']?></td>
<td><?= $d['kode_produk']?></td>
<td><?= $d['nama_produk']?></td>
<td><?= $d['kategori']?></td>
<td><?= $d['harga']?></td>

<td>
<a href="edit.php?id=<?=$d['id_produk']?>">Edit</a>
|
<a href="hapus.php?id=<?=$d['id_produk']?>">Hapus</a>
</td>

</tr>

<?php } ?>

</table>