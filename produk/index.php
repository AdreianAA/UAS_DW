<?php
include '../config/koneksi.php';

/* ==================== PAGINATION ==================== */
$per_page = 5;
$page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$offset = ($page - 1) * $per_page;

$total_rows = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) n FROM dim_produk"))['n'];
$total_pages = max(1, ceil($total_rows / $per_page));

$query = mysqli_query($conn, "
    SELECT * FROM dim_produk
    ORDER BY id_produk DESC
    LIMIT $per_page OFFSET $offset
");

$base = '../';
$page_title = 'Data Produk';
$active_menu = 'produk';
$active_sub  = 'tabel';
include '../includes/header.php';
?>

<div class="page-heading">
    <div>
        <h2>Data Produk</h2>
        <p>Kelola dimensi produk (dim_produk) pada Data Warehouse</p>
    </div>
</div>

<?php if(isset($_GET['msg'])): ?>
    <div class="alert-app success"><i class="bi bi-check-circle me-1"></i>
        <?= $_GET['msg']==='added' ? 'Produk berhasil ditambahkan.' : 'Produk berhasil diperbarui.' ?>
    </div>
<?php endif; ?>

<div class="surface-card">
    <div class="toolbar">
        <div class="search-box">
            <i class="bi bi-search"></i>
            <input type="text" placeholder="Cari produk..." data-search-input="tabelProduk">
        </div>

        <a href="tambah.php" class="btn-app-primary">
            <i class="bi bi-plus-lg"></i> Tambah Produk
        </a>
    </div>

    <div class="table-responsive">
        <table class="table-app" id="tabelProduk">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kode Produk</th>
                    <th>Nama Produk</th>
                    <th>Kategori</th>
                    <th>Harga</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
            <?php if($total_rows === 0): ?>
                <tr><td colspan="6" class="empty-state"><i class="bi bi-inbox"></i>Belum ada data produk.</td></tr>
            <?php endif; ?>

            <tr class="js-empty-search" style="display:none;">
                <td colspan="6" class="empty-state"><i class="bi bi-search"></i>Produk tidak ditemukan.</td>
            </tr>

            <?php $no = $offset + 1; while($data = mysqli_fetch_assoc($query)): ?>
                <tr data-row>
                    <td><?= $no++ ?></td>
                    <td><?= htmlspecialchars($data['kode_produk']) ?></td>
                    <td><?= htmlspecialchars($data['nama_produk']) ?></td>
                    <td><span class="badge-kategori"><?= htmlspecialchars($data['kategori']) ?></span></td>
                    <td>Rp <?= number_format($data['harga'],0,',','.') ?></td>
                    <td>
                        <div class="row-actions">
                            <a href="edit.php?id=<?= $data['id_produk'] ?>" class="action-btn edit" title="Edit">
                                <i class="bi bi-pencil-fill"></i>
                            </a>
                            <a href="hapus.php?id=<?= $data['id_produk'] ?>" class="action-btn delete" title="Hapus"
                               onclick="return confirm('Yakin ingin menghapus produk ini?')">
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
        <div class="info">Menampilkan <?= $offset+1 ?>–<?= min($offset+$per_page,$total_rows) ?> dari <?= $total_rows ?> produk</div>
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
