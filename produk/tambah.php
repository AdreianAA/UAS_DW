<?php
include '../config/koneksi.php';

$error = '';

if(isset($_POST['simpan'])){

    $kode_produk = mysqli_real_escape_string($conn, $_POST['kode_produk']);
    $nama_produk = mysqli_real_escape_string($conn, $_POST['nama_produk']);
    $kategori    = mysqli_real_escape_string($conn, $_POST['kategori']);
    $harga       = mysqli_real_escape_string($conn, $_POST['harga']);

    if($kode_produk === '' || $nama_produk === '' || $harga === ''){
        $error = 'Semua field wajib diisi.';
    } else {
        mysqli_query($conn, "
            INSERT INTO dim_produk (kode_produk, nama_produk, kategori, harga)
            VALUES ('$kode_produk', '$nama_produk', '$kategori', '$harga')
        ");
        header("Location:index.php?msg=added");
        exit;
    }
}

$base = '../';
$page_title = 'Tambah Produk';
$active_menu = 'produk';
$active_sub  = 'tambah';
include '../includes/header.php';
?>

<div class="page-heading">
    <div>
        <h2>Tambah Produk</h2>
        <p>Tambahkan data produk baru ke dimensi produk</p>
    </div>
</div>

<div class="surface-card form-shell">

    <?php if($error): ?>
        <div class="alert-app danger"><i class="bi bi-exclamation-circle me-1"></i><?= $error ?></div>
    <?php endif; ?>

    <form method="POST">

        <div class="field">
            <label>Kode Produk</label>
            <input type="text" name="kode_produk" class="form-control" placeholder="Contoh: PR006"
                   value="<?= isset($_POST['kode_produk']) ? htmlspecialchars($_POST['kode_produk']) : '' ?>" required>
        </div>

        <div class="field">
            <label>Nama Produk</label>
            <input type="text" name="nama_produk" class="form-control" placeholder="Contoh: Baju Polos Biru"
                   value="<?= isset($_POST['nama_produk']) ? htmlspecialchars($_POST['nama_produk']) : '' ?>" required>
        </div>

        <div class="field">
            <label>Kategori</label>
            <select name="kategori" class="form-select">
                <option value="Elektronik">Elektronik</option>
                <option value="Pakaian">Pakaian</option>
                <option value="Makanan">Makanan</option>
                <option value="Aksesoris">Aksesoris</option>
            </select>
        </div>

        <div class="field">
            <label>Harga</label>
            <input type="number" name="harga" class="form-control" placeholder="0" min="0" required>
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
