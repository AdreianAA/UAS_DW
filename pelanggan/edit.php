<?php
include '../config/koneksi.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

$data = mysqli_fetch_assoc(
    mysqli_query($conn, "SELECT * FROM dim_pelanggan WHERE id_pelanggan='$id'")
);

if(!$data){
    header("Location:index.php");
    exit;
}

$error = '';

if(isset($_POST['update'])){

    $kode_pelanggan = mysqli_real_escape_string($conn, $_POST['kode_pelanggan']);
    $nama_pelanggan = mysqli_real_escape_string($conn, $_POST['nama_pelanggan']);
    $jenis_kelamin  = mysqli_real_escape_string($conn, $_POST['jenis_kelamin']);
    $kota           = mysqli_real_escape_string($conn, $_POST['kota']);

    if($kode_pelanggan === '' || $nama_pelanggan === '' || $kota === ''){
        $error = 'Semua field wajib diisi.';
    } else {
        mysqli_query($conn, "
            UPDATE dim_pelanggan SET
                kode_pelanggan='$kode_pelanggan',
                nama_pelanggan='$nama_pelanggan',
                jenis_kelamin='$jenis_kelamin',
                kota='$kota'
            WHERE id_pelanggan='$id'
        ");
        header("Location:index.php?msg=updated");
        exit;
    }
}

$base = '../';
$page_title = 'Edit Pelanggan';
$active_menu = 'pelanggan';
$active_sub  = 'tabel';
include '../includes/header.php';
?>

<div class="page-heading">
    <div>
        <h2>Edit Pelanggan</h2>
        <p>Perbarui data pelanggan: <?= htmlspecialchars($data['nama_pelanggan']) ?></p>
    </div>
</div>

<div class="surface-card form-shell">

    <?php if($error): ?>
        <div class="alert-app danger"><i class="bi bi-exclamation-circle me-1"></i><?= $error ?></div>
    <?php endif; ?>

    <form method="POST">

        <div class="field">
            <label>Kode Pelanggan</label>
            <input type="text" name="kode_pelanggan" class="form-control" value="<?= htmlspecialchars($data['kode_pelanggan']) ?>" required>
        </div>

        <div class="field">
            <label>Nama Pelanggan</label>
            <input type="text" name="nama_pelanggan" class="form-control" value="<?= htmlspecialchars($data['nama_pelanggan']) ?>" required>
        </div>

        <div class="field">
            <label>Jenis Kelamin</label>
            <select name="jenis_kelamin" class="form-select">
                <option value="L" <?= $data['jenis_kelamin']==='L'?'selected':'' ?>>Laki-laki</option>
                <option value="P" <?= $data['jenis_kelamin']==='P'?'selected':'' ?>>Perempuan</option>
            </select>
        </div>

        <div class="field">
            <label>Kota</label>
            <input type="text" name="kota" class="form-control" value="<?= htmlspecialchars($data['kota']) ?>" required>
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
