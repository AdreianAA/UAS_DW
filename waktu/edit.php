<?php
include '../config/koneksi.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

$data = mysqli_fetch_assoc(
    mysqli_query($conn, "SELECT * FROM dim_waktu WHERE id_waktu='$id'")
);

if(!$data){
    header("Location:index.php");
    exit;
}

$error = '';

if(isset($_POST['update'])){

    $tanggal = mysqli_real_escape_string($conn, $_POST['tanggal']);

    if($tanggal === ''){
        $error = 'Tanggal wajib diisi.';
    } else {
        $tahun      = date('Y', strtotime($tanggal));
        $bulan      = date('n', strtotime($tanggal));
        $bulan_nama = date('F', strtotime($tanggal));
        $kuartal    = ceil($bulan / 3);

        mysqli_query($conn, "
            UPDATE dim_waktu SET
                tanggal='$tanggal', tahun='$tahun', bulan='$bulan',
                bulan_nama='$bulan_nama', kuartal='$kuartal'
            WHERE id_waktu='$id'
        ");
        header("Location:index.php?msg=updated");
        exit;
    }
}

$base = '../';
$page_title = 'Edit Waktu';
$active_menu = 'waktu';
$active_sub  = 'tabel';
include '../includes/header.php';
?>

<div class="page-heading">
    <div>
        <h2>Edit Dimensi Waktu</h2>
        <p>Perbarui tanggal: <?= date('d/m/Y', strtotime($data['tanggal'])) ?></p>
    </div>
</div>

<div class="surface-card form-shell">

    <?php if($error): ?>
        <div class="alert-app danger"><i class="bi bi-exclamation-circle me-1"></i><?= $error ?></div>
    <?php endif; ?>

    <form method="POST">

        <div class="field">
            <label>Tanggal</label>
            <input type="date" name="tanggal" class="form-control" value="<?= $data['tanggal'] ?>" required>
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
