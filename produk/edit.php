<?php
include '../config/koneksi.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

$data = mysqli_fetch_assoc(
    mysqli_query($conn, "SELECT * FROM dim_produk WHERE id_produk='$id'")
);

if(!$data){
    header("Location:index.php");
    exit;
}

$error = '';

if(isset($_POST['update'])){

    $kode_produk = mysqli_real_escape_string($conn, $_POST['kode_produk']);
    $nama_produk = mysqli_real_escape_string($conn, $_POST['nama_produk']);
    $kategori    = mysqli_real_escape_string($conn, $_POST['kategori']);
    $harga       = mysqli_real_escape_string($conn, $_POST['harga']);

    if($kode_produk === '' || $nama_produk === '' || $harga === ''){
        $error = 'Semua field wajib diisi.';
    } else {
        mysqli_query($conn, "
            UPDATE dim_produk SET
                kode_produk='$kode_produk',
                nama_produk='$nama_produk',
                kategori='$kategori',
                harga='$harga'
            WHERE id_produk='$id'
        ");
        header("Location:index.php?msg=updated");
        exit;
    }
}

$kategori_options = ['Elektronik','Pakaian','Makanan','Aksesoris'];

$base = '../';
$page_title = 'Edit Produk';
$active_menu = 'produk';
$active_sub  = 'tabel';
include '../includes/header.php';
?>

<div class="page-heading">
    <div>
        <h2>Edit Produk</h2>
        <p>Perbarui data produk: <?= htmlspecialchars($data['nama_produk']) ?></p>
    </div>
</div>

<div class="surface-card form-shell">

    <?php if($error): ?>
        <div class="alert-app danger"><i class="bi bi-exclamation-circle me-1"></i><?= $error ?></div>
    <?php endif; ?>

    <form method="POST">

        <div class="field">
            <label>Kode Produk</label>
            <input type="text" name="kode_produk" class="form-control" value="<?= htmlspecialchars($data['kode_produk']) ?>" required>
        </div>

        <div class="field">
            <label>Nama Produk</label>
            <input type="text" name="nama_produk" class="form-control" value="<?= htmlspecialchars($data['nama_produk']) ?>" required>
        </div>

        <div class="field">
            <label>Kategori</label>
            <select name="kategori" class="form-select">
                <?php foreach($kategori_options as $opt): ?>
                    <option value="<?= $opt ?>" <?= $data['kategori']===$opt?'selected':'' ?>><?= $opt ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="field">
            <label>Harga</label>
            <input type="number" name="harga" class="form-control" min="0" value="<?= htmlspecialchars($data['harga']) ?>" required>
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
