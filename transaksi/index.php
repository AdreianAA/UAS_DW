<?php
include '../config/koneksi.php';

$per_page = 6;
$page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$offset = ($page - 1) * $per_page;

$total_rows = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) n FROM fact_penjualan"))['n'];
$total_pages = max(1, ceil($total_rows / $per_page));

$query = mysqli_query($conn, "
    SELECT f.*, p.nama_produk, pl.nama_pelanggan, w.tanggal
    FROM fact_penjualan f
    JOIN dim_produk p ON f.id_produk = p.id_produk
    JOIN dim_pelanggan pl ON f.id_pelanggan = pl.id_pelanggan
    JOIN dim_waktu w ON f.id_waktu = w.id_waktu
    ORDER BY f.id_penjualan DESC
    LIMIT $per_page OFFSET $offset
");

$base = '../';
$page_title = 'Data Transaksi';
$active_menu = 'transaksi';
$active_sub  = 'tabel';
include '../includes/header.php';
?>

<div class="page-heading">
    <div>
        <h2>Data Transaksi</h2>
        <p>Kelola tabel fakta penjualan (fact_penjualan) pada Data Warehouse</p>
    </div>
</div>

<?php if(isset($_GET['msg'])): ?>
    <div class="alert-app success"><i class="bi bi-check-circle me-1"></i>
        <?php
        $m = $_GET['msg'];
        echo $m==='added' ? 'Transaksi berhasil ditambahkan.' : ($m==='updated' ? 'Transaksi berhasil diperbarui.' : 'Transaksi berhasil dihapus.');
        ?>
    </div>
<?php endif; ?>

<div class="surface-card">
    <div class="toolbar">
        <div class="search-box">
            <i class="bi bi-search"></i>
            <input type="text" placeholder="Cari transaksi..." data-search-input="tabelTransaksi">
        </div>

        <a href="tambah.php" class="btn-app-primary">
            <i class="bi bi-plus-lg"></i> Tambah Transaksi
        </a>
    </div>

    <div class="table-responsive">
        <table class="table-app" id="tabelTransaksi">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>Pelanggan</th>
                    <th>Produk</th>
                    <th>Jumlah</th>
                    <th>Harga Satuan</th>
                    <th>Total</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
            <?php if($total_rows === 0): ?>
                <tr><td colspan="8" class="empty-state"><i class="bi bi-inbox"></i>Belum ada data transaksi.</td></tr>
            <?php endif; ?>

            <tr class="js-empty-search" style="display:none;">
                <td colspan="8" class="empty-state"><i class="bi bi-search"></i>Transaksi tidak ditemukan.</td>
            </tr>

            <?php $no = $offset + 1; while($data = mysqli_fetch_assoc($query)): ?>
                <tr data-row>
                    <td><?= $no++ ?></td>
                    <td><?= date('d/m/Y', strtotime($data['tanggal'])) ?></td>
                    <td><?= htmlspecialchars($data['nama_pelanggan']) ?></td>
                    <td><?= htmlspecialchars($data['nama_produk']) ?></td>
                    <td><?= $data['jumlah'] ?></td>
                    <td>Rp <?= number_format($data['harga_satuan'],0,',','.') ?></td>
                    <td><strong>Rp <?= number_format($data['total_harga'],0,',','.') ?></strong></td>
                    <td>
                        <div class="row-actions">
                            <a href="edit.php?id=<?= $data['id_penjualan'] ?>" class="action-btn edit" title="Edit">
                                <i class="bi bi-pencil-fill"></i>
                            </a>
                            <a href="hapus.php?id=<?= $data['id_penjualan'] ?>" class="action-btn delete" title="Hapus"
                               onclick="return confirm('Yakin ingin menghapus transaksi ini?')">
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
        <div class="info">Menampilkan <?= $offset+1 ?>–<?= min($offset+$per_page,$total_rows) ?> dari <?= $total_rows ?> transaksi</div>
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
