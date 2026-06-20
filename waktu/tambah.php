<?php
include '../config/koneksi.php';

$per_page = 6;
$page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$offset = ($page - 1) * $per_page;

$total_rows = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) n FROM dim_waktu"))['n'];
$total_pages = max(1, ceil($total_rows / $per_page));

$query = mysqli_query($conn, "
    SELECT * FROM dim_waktu
    ORDER BY tanggal DESC
    LIMIT $per_page OFFSET $offset
");

$base = '../';
$page_title = 'Dimensi Waktu';
$active_menu = 'waktu';
$active_sub  = 'tabel';
include '../includes/header.php';
?>

<div class="page-heading">
    <div>
        <h2>Dimensi Waktu</h2>
        <p>Kelola dimensi waktu (dim_waktu) pada Data Warehouse</p>
    </div>
</div>

<?php if(isset($_GET['msg'])): ?>
    <div class="alert-app success"><i class="bi bi-check-circle me-1"></i>
        <?php
        $m = $_GET['msg'];
        echo $m==='added' ? 'Tanggal berhasil ditambahkan.' : ($m==='updated' ? 'Tanggal berhasil diperbarui.' : 'Tanggal berhasil dihapus.');
        ?>
    </div>
<?php endif; ?>

<div class="surface-card">
    <div class="toolbar">
        <div class="search-box">
            <i class="bi bi-search"></i>
            <input type="text" placeholder="Cari tanggal / bulan..." data-search-input="tabelWaktu">
        </div>

        <a href="tambah.php" class="btn-app-primary">
            <i class="bi bi-plus-lg"></i> Tambah Waktu
        </a>
    </div>

    <div class="table-responsive">
        <table class="table-app" id="tabelWaktu">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>Tahun</th>
                    <th>Bulan</th>
                    <th>Kuartal</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
            <?php if($total_rows === 0): ?>
                <tr><td colspan="6" class="empty-state"><i class="bi bi-inbox"></i>Belum ada data waktu.</td></tr>
            <?php endif; ?>

            <tr class="js-empty-search" style="display:none;">
                <td colspan="6" class="empty-state"><i class="bi bi-search"></i>Data tidak ditemukan.</td>
            </tr>

            <?php $no = $offset + 1; while($data = mysqli_fetch_assoc($query)): ?>
                <tr data-row>
                    <td><?= $no++ ?></td>
                    <td><?= date('d/m/Y', strtotime($data['tanggal'])) ?></td>
                    <td><?= $data['tahun'] ?></td>
                    <td><?= htmlspecialchars($data['bulan_nama']) ?></td>
                    <td><span class="badge-kategori">Q<?= $data['kuartal'] ?></span></td>
                    <td>
                        <div class="row-actions">
                            <a href="edit.php?id=<?= $data['id_waktu'] ?>" class="action-btn edit" title="Edit">
                                <i class="bi bi-pencil-fill"></i>
                            </a>
                            <a href="hapus.php?id=<?= $data['id_waktu'] ?>" class="action-btn delete" title="Hapus"
                               onclick="return confirm('Yakin ingin menghapus data waktu ini?')">
                                <i class="bi bi-trash-fill"></i>
                            </a>
                        </div>
                    </td>
                </tr>
            <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <?php if($total_rows > 0): ?>
    <div class="pagination-app">
        <div class="info">Menampilkan <?= $offset+1 ?>–<?= min($offset+$per_page,$total_rows) ?> dari <?= $total_rows ?> data</div>
        <div class="pages">
            <a href="?page=<?= max(1,$page-1) ?>"><i class="bi bi-chevron-left"></i></a>
            <?php for($i=1; $i<=$total_pages; $i++): ?>
                <a href="?page=<?= $i ?>" class="<?= $i===$page?'active':'' ?>"><?= $i ?></a>
            <?php endfor; ?>
            <a href="?page=<?= min($total_pages,$page+1) ?>"><i class="bi bi-chevron-right"></i></a>
        </div>
    </div>
    <?php endif; ?>
</div>

<?php include '../includes/footer.php'; ?>
