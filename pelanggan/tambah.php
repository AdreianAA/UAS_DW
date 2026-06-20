<?php
include '../config/koneksi.php';

$error = '';

if(isset($_POST['simpan'])){

    $kode_pelanggan = mysqli_real_escape_string($conn, $_POST['kode_pelanggan']);
    $nama_pelanggan = mysqli_real_escape_string($conn, $_POST['nama_pelanggan']);
    $jenis_kelamin  = mysqli_real_escape_string($conn, $_POST['jenis_kelamin']);
    $kota           = mysqli_real_escape_string($conn, $_POST['kota']);

    if($kode_pelanggan === '' || $nama_pelanggan === '' || $kota === ''){
        $error = 'Semua field wajib diisi.';
    } else {
        mysqli_query($conn, "
            INSERT INTO dim_pelanggan (kode_pelanggan, nama_pelanggan, jenis_kelamin, kota)
            VALUES ('$kode_pelanggan', '$nama_pelanggan', '$jenis_kelamin', '$kota')
        ");
        header("Location:index.php?msg=added");
        exit;
    }
}

$base = '../';
$page_title = 'Tambah Pelanggan';
$active_menu = 'pelanggan';
$active_sub  = 'tambah';
include '../includes/header.php';
?>

<div class="page-heading">
    <div>
        <h2>Tambah Pelanggan</h2>
        <p>Tambahkan data pelanggan baru ke dimensi pelanggan</p>
    </div>
</div>

<div class="surface-card form-shell">

    <?php if($error): ?>
        <div class="alert-app danger"><i class="bi bi-exclamation-circle me-1"></i><?= $error ?></div>
    <?php endif; ?>

    <form method="POST">

        <div class="field">
            <label>Kode Pelanggan</label>
            <input type="text" name="kode_pelanggan" class="form-control" placeholder="Contoh: PL006"
                   value="<?= isset($_POST['kode_pelanggan']) ? htmlspecialchars($_POST['kode_pelanggan']) : '' ?>" required>
        </div>

        <div class="field">
            <label>Nama Pelanggan</label>
            <input type="text" name="nama_pelanggan" class="form-control" placeholder="Contoh: Budi Saputra"
                   value="<?= isset($_POST['nama_pelanggan']) ? htmlspecialchars($_POST['nama_pelanggan']) : '' ?>" required>
        </div>

        <div class="field">
            <label>Jenis Kelamin</label>
            <select name="jenis_kelamin" class="form-select">
                <option value="L">Laki-laki</option>
                <option value="P">Perempuan</option>
            </select>
        </div>

        <div class="field">
            <label>Kota</label>
            <input type="text" name="kota" class="form-control" placeholder="Contoh: Sidoarjo"
                   value="<?= isset($_POST['kota']) ? htmlspecialchars($_POST['kota']) : '' ?>" required>
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
