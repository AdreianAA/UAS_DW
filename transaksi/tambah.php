<?php
include '../config/koneksi.php';

$error = '';

if(isset($_POST['simpan'])){

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
            INSERT INTO fact_penjualan
            (id_produk, id_pelanggan, id_waktu, jumlah, harga_satuan, total_harga)
            VALUES
            ('$id_produk', '$id_pelanggan', '$id_waktu', '$jumlah', '$harga_satuan', '$total_harga')
        ");

        header("Location:index.php?msg=added");
        exit;
    }
}

$base = '../';
$page_title = 'Tambah Transaksi';
$active_menu = 'transaksi';
$active_sub  = 'tambah';
include '../includes/header.php';
?>

<div class="page-heading">
    <div>
        <h2>Tambah Transaksi</h2>
        <p>Catat transaksi penjualan baru ke fact_penjualan</p>
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
                <option value="">-- Pilih Produk --</option>
                <?php
                $produk = mysqli_query($conn, "SELECT * FROM dim_produk ORDER BY nama_produk");
                while($p = mysqli_fetch_assoc($produk)):
                ?>
                <option value="<?= $p['id_produk'] ?>">
                    <?= htmlspecialchars($p['nama_produk']) ?> — Rp <?= number_format($p['harga'],0,',','.') ?>
                </option>
                <?php endwhile; ?>
            </select>
        </div>

        <div class="field">
            <label>Pelanggan</label>
            <select name="id_pelanggan" class="form-select" required>
                <option value="">-- Pilih Pelanggan --</option>
                <?php
                $pelanggan = mysqli_query($conn, "SELECT * FROM dim_pelanggan ORDER BY nama_pelanggan");
                while($pl = mysqli_fetch_assoc($pelanggan)):
                ?>
                <option value="<?= $pl['id_pelanggan'] ?>"><?= htmlspecialchars($pl['nama_pelanggan']) ?></option>
                <?php endwhile; ?>
            </select>
        </div>

        <div class="field">
            <label>Tanggal</label>
            <select name="id_waktu" class="form-select" required>
                <option value="">-- Pilih Tanggal --</option>
                <?php
                $waktu = mysqli_query($conn, "SELECT * FROM dim_waktu ORDER BY tanggal DESC");
                while($w = mysqli_fetch_assoc($waktu)):
                ?>
                <option value="<?= $w['id_waktu'] ?>"><?= date('d/m/Y', strtotime($w['tanggal'])) ?></option>
                <?php endwhile; ?>
            </select>
        </div>

        <div class="field">
            <label>Jumlah</label>
            <input type="number" name="jumlah" class="form-control" min="1" placeholder="0" required>
        </div>

        <div class="form-actions">
            <button type="submit" name="simpan" class="btn-app-primary">
                <i class="bi bi-check-lg"></i> Simpan
            </button>
            <a href="index.php" class="btn-app-cancel">Batal</a>
        </div>

    </form>
</div>

<?php include '../includes/footer.php'; ?>
