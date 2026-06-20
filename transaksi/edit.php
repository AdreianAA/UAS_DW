<?php
include '../config/koneksi.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

$data = mysqli_fetch_assoc(
    mysqli_query($conn, "SELECT * FROM fact_penjualan WHERE id_penjualan='$id'")
);

if(!$data){
    header("Location:index.php");
    exit;
}

$error = '';

if(isset($_POST['update'])){

    $id_produk    = (int)$_POST['id_produk'];
    $id_pelanggan = (int)$_POST['id_pelanggan'];
    $id_waktu     = (int)$_POST['id_waktu'];
    $jumlah       = (int)$_POST['jumlah'];

    if($id_produk <= 0 || $id_pelanggan <= 0 || $id_waktu <= 0 || $jumlah <= 0){
        $error = 'Semua field wajib diisi dengan benar.';
    } else {
        $getHarga = mysqli_fetch_assoc(mysqli_query($conn, "
            SELECT harga FROM dim_produk WHERE id_produk='$id_produk'
        "));

        $harga_satuan = $getHarga['harga'];
        $total_harga  = $jumlah * $harga_satuan;

        mysqli_query($conn, "
            UPDATE fact_penjualan SET
                id_produk='$id_produk',
                id_pelanggan='$id_pelanggan',
                id_waktu='$id_waktu',
                jumlah='$jumlah',
                harga_satuan='$harga_satuan',
                total_harga='$total_harga'
            WHERE id_penjualan='$id'
        ");

        header("Location:index.php?msg=updated");
        exit;
    }
}

$base = '../';
$page_title = 'Edit Transaksi';
$active_menu = 'transaksi';
$active_sub  = 'tabel';
include '../includes/header.php';
?>

<div class="page-heading">
    <div>
        <h2>Edit Transaksi</h2>
        <p>Perbarui data transaksi #<?= $data['id_penjualan'] ?></p>
    </div>
</div>

<div class="surface-card form-shell">

    <?php if($error): ?>
        <div class="alert-app danger"><i class="bi bi-exclamation-circle me-1"></i><?= $error ?></div>
    <?php endif; ?>

    <form method="POST">

        <div class="field">
            <label>Produk</label>
            <select name="id_produk" class="form-select" required>
                <?php
                $produk = mysqli_query($conn, "SELECT * FROM dim_produk ORDER BY nama_produk");
                while($p = mysqli_fetch_assoc($produk)):
                ?>
                <option value="<?= $p['id_produk'] ?>" <?= $p['id_produk']==$data['id_produk']?'selected':'' ?>>
                    <?= htmlspecialchars($p['nama_produk']) ?> — Rp <?= number_format($p['harga'],0,',','.') ?>
                </option>
                <?php endwhile; ?>
            </select>
        </div>

        <div class="field">
            <label>Pelanggan</label>
            <select name="id_pelanggan" class="form-select" required>
                <?php
                $pelanggan = mysqli_query($conn, "SELECT * FROM dim_pelanggan ORDER BY nama_pelanggan");
                while($pl = mysqli_fetch_assoc($pelanggan)):
                ?>
                <option value="<?= $pl['id_pelanggan'] ?>" <?= $pl['id_pelanggan']==$data['id_pelanggan']?'selected':'' ?>>
                    <?= htmlspecialchars($pl['nama_pelanggan']) ?>
                </option>
                <?php endwhile; ?>
            </select>
        </div>

        <div class="field">
            <label>Tanggal</label>
            <select name="id_waktu" class="form-select" required>
                <?php
                $waktu = mysqli_query($conn, "SELECT * FROM dim_waktu ORDER BY tanggal DESC");
                while($w = mysqli_fetch_assoc($waktu)):
                ?>
                <option value="<?= $w['id_waktu'] ?>" <?= $w['id_waktu']==$data['id_waktu']?'selected':'' ?>>
                    <?= date('d/m/Y', strtotime($w['tanggal'])) ?>
                </option>
                <?php endwhile; ?>
            </select>
        </div>

        <div class="field">
            <label>Jumlah</label>
            <input type="number" name="jumlah" class="form-control" min="1" value="<?= $data['jumlah'] ?>" required>
        </div>

        <div class="form-actions">
            <button type="submit" name="update" class="btn-app-primary">
                <i class="bi bi-check-lg"></i> Update
            </button>
            <a href="index.php" class="btn-app-cancel">Batal</a>
        </div>

    </form>
</div>

<?php include '../includes/footer.php'; ?>
