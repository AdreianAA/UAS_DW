<?php
include '../config/koneksi.php';

$kategori_filter = isset($_GET['kategori']) ? mysqli_real_escape_string($conn, $_GET['kategori']) : '';
$filter_sql = $kategori_filter !== '' ? "WHERE p.kategori = '$kategori_filter'" : "";

/* ==================== STAT STRIP ==================== */
$jml_produk    = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) n FROM dim_produk"))['n'];
$jml_pelanggan = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) n FROM dim_pelanggan"))['n'];
$jml_transaksi = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) n FROM fact_penjualan"))['n'];
$total_omzet   = mysqli_fetch_assoc(mysqli_query($conn, "SELECT IFNULL(SUM(total_harga),0) n FROM fact_penjualan"))['n'];

/* ==================== DAFTAR KATEGORI UNTUK FILTER ==================== */
$kategori_list = [];
$qk = mysqli_query($conn, "SELECT DISTINCT kategori FROM dim_produk WHERE kategori IS NOT NULL ORDER BY kategori");
while($k = mysqli_fetch_assoc($qk)) $kategori_list[] = $k['kategori'];

/* ==================== CHART 1: TOTAL PENJUALAN PER PRODUK ==================== */
$q_produk = mysqli_query($conn, "
    SELECT p.nama_produk, SUM(f.total_harga) AS total_pendapatan
    FROM fact_penjualan f
    INNER JOIN dim_produk p ON f.id_produk = p.id_produk
    $filter_sql
    GROUP BY p.id_produk, p.nama_produk
    ORDER BY total_pendapatan DESC
");
$produk = [];
$pendapatan_produk = [];
while($row = mysqli_fetch_assoc($q_produk)){
    $produk[] = $row['nama_produk'];
    $pendapatan_produk[] = $row['total_pendapatan'];
}

/* ==================== CHART 2: TREN PENJUALAN BULANAN ==================== */
$q_bulan = mysqli_query($conn, "
    SELECT w.bulan, w.bulan_nama, SUM(f.total_harga) AS total_pendapatan
    FROM fact_penjualan f
    INNER JOIN dim_waktu w ON f.id_waktu = w.id_waktu
    INNER JOIN dim_produk p ON f.id_produk = p.id_produk
    $filter_sql
    GROUP BY w.bulan, w.bulan_nama
    ORDER BY w.bulan
");
$bulan = [];
$pendapatan_bulan = [];
while($row = mysqli_fetch_assoc($q_bulan)){
    $bulan[] = $row['bulan_nama'];
    $pendapatan_bulan[] = $row['total_pendapatan'];
}

/* ==================== TABEL TRANSAKSI TERBARU ==================== */
$q_recent = mysqli_query($conn, "
    SELECT f.id_penjualan, w.tanggal, pl.nama_pelanggan, p.nama_produk, f.total_harga
    FROM fact_penjualan f
    INNER JOIN dim_produk p ON f.id_produk = p.id_produk
    INNER JOIN dim_pelanggan pl ON f.id_pelanggan = pl.id_pelanggan
    INNER JOIN dim_waktu w ON f.id_waktu = w.id_waktu
    ORDER BY f.id_penjualan DESC
    LIMIT 7
");

/* ==================== TOP PELANGGAN ==================== */
$q_pelanggan = mysqli_query($conn, "
    SELECT pl.nama_pelanggan, SUM(f.total_harga) AS total_belanja, COUNT(f.id_penjualan) AS jml
    FROM fact_penjualan f
    INNER JOIN dim_pelanggan pl ON f.id_pelanggan = pl.id_pelanggan
    GROUP BY pl.id_pelanggan, pl.nama_pelanggan
    ORDER BY total_belanja DESC
    LIMIT 5
");

$base = '../';
$page_title = 'Dashboard';
$active_menu = 'dashboard';
include '../includes/header.php';
?>

<div class="page-heading mb-4 align-items-center">
    <div>
        <h2>Dashboard</h2>
        <p>Ringkasan performa penjualan dari Data Warehouse Retail</p>
    </div>

    <form method="GET" class="d-flex">
        <select name="kategori" class="select-filter" onchange="this.form.submit()">
            <option value="">Semua Kategori</option>
            <?php foreach($kategori_list as $k): ?>
                <option value="<?= htmlspecialchars($k) ?>" <?= $kategori_filter===$k?'selected':'' ?>>
                    <?= htmlspecialchars($k) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </form>
</div>

<div class="stat-strip mb-4">
    <div class="stat-card">
        <div class="stat-icon" style="background:#E8ECFF;color:#3D5AFE;"><i class="bi bi-box-seam-fill"></i></div>
        <div class="stat-label">Total Produk</div>
        <div class="stat-value"><?= $jml_produk ?></div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background:#E6F8EE;color:#18B26B;"><i class="bi bi-people-fill"></i></div>
        <div class="stat-label">Total Pelanggan</div>
        <div class="stat-value"><?= $jml_pelanggan ?></div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background:#FFF4DD;color:#B8860B;"><i class="bi bi-receipt"></i></div>
        <div class="stat-label">Total Transaksi</div>
        <div class="stat-value"><?= $jml_transaksi ?></div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background:#FFE3E8;color:#FF4D6D;"><i class="bi bi-cash-coin"></i></div>
        <div class="stat-label">Total Penjualan</div>
        <div class="stat-value" style="font-size:1.05rem;">Rp <?= number_format($total_omzet,0,',','.') ?></div>
    </div>
</div>

<div class="row g-4 mb-4">
    <div class="col-lg-6">
        <div class="surface-card h-100">
            <div class="surface-head">
                <h6>Total Penjualan per Produk</h6>
            </div>
            <?php if(count($produk) > 0): ?>
                <canvas id="chartProduk" height="220"></canvas>
            <?php else: ?>
                <div class="empty-state"><i class="bi bi-bar-chart"></i>Belum ada data untuk kategori ini.</div>
            <?php endif; ?>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="surface-card h-100">
            <div class="surface-head">
                <h6>Tren Penjualan per Bulan</h6>
            </div>
            <?php if(count($bulan) > 0): ?>
                <canvas id="chartBulan" height="220"></canvas>
            <?php else: ?>
                <div class="empty-state"><i class="bi bi-graph-up"></i>Belum ada data untuk kategori ini.</div>
            <?php endif; ?>
        </div>
    </div>
</div>

<div class="row g-4 mb-4">
    <div class="col-lg-7">
        <div class="surface-card h-100"> <div class="surface-head">
                <h6>Transaksi Terbaru</h6>
                <a href="../transaksi/index.php" class="select-filter" style="text-decoration:none;">Lihat Semua</a>
            </div>

            <div class="table-responsive">
                <table class="table-app">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Nama Pelanggan</th>
                            <th>Produk</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php if(mysqli_num_rows($q_recent) === 0): ?>
                        <tr><td colspan="4" class="empty-state"><i class="bi bi-inbox"></i>Belum ada transaksi.</td></tr>
                    <?php endif; ?>
                    <?php while($r = mysqli_fetch_assoc($q_recent)): ?>
                        <tr>
                            <td><?= date('d/m/Y', strtotime($r['tanggal'])) ?></td>
                            <td><?= htmlspecialchars($r['nama_pelanggan']) ?></td>
                            <td><?= htmlspecialchars($r['nama_produk']) ?></td>
                            <td>Rp <?= number_format($r['total_harga'],0,',','.') ?></td>
                        </tr>
                    <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-lg-5">
        <div class="surface-card h-100"> <div class="surface-head">
                <h6>Pelanggan Belanja Tertinggi</h6>
            </div>

            <div class="table-responsive">
                <table class="table-app">
                    <thead>
                        <tr><th>Pelanggan</th><th>Transaksi</th><th>Total</th></tr>
                    </thead>
                    <tbody>
                    <?php if(mysqli_num_rows($q_pelanggan) === 0): ?>
                        <tr><td colspan="3" class="empty-state"><i class="bi bi-inbox"></i>Belum ada data.</td></tr>
                    <?php endif; ?>
                    <?php while($p = mysqli_fetch_assoc($q_pelanggan)): ?>
                        <tr>
                            <td><?= htmlspecialchars($p['nama_pelanggan']) ?></td>
                            <td><?= $p['jml'] ?>x</td>
                            <td>Rp <?= number_format($p['total_belanja'],0,',','.') ?></td>
                        </tr>
                    <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
<?php if(count($produk) > 0): ?>
new Chart(document.getElementById('chartProduk'), {
    type: 'bar',
    data: {
        labels: <?= json_encode($produk) ?>,
        datasets: [{
            label: 'Total Pendapatan',
            data: <?= json_encode($pendapatan_produk) ?>,
            backgroundColor: ['#3D5AFE','#7C8CFF','#18B26B','#FFB13D','#FF4D6D','#22C3D6','#A06CFF'],
            borderRadius: 8,
            maxBarThickness: 42
        }]
    },
    options: {
        responsive: true,
        plugins: { legend: { display:false } },
        scales: { y: { ticks:{ callback:v=>'Rp '+v.toLocaleString('id-ID') } } }
    }
});
<?php endif; ?>

<?php if(count($bulan) > 0): ?>
new Chart(document.getElementById('chartBulan'), {
    type: 'line',
    data: {
        labels: <?= json_encode($bulan) ?>,
        datasets: [{
            label: 'Pendapatan',
            data: <?= json_encode($pendapatan_bulan) ?>,
            borderColor: '#3D5AFE',
            backgroundColor: 'rgba(61,90,254,0.12)',
            borderWidth: 3,
            tension: 0.35,
            fill: true,
            pointBackgroundColor:'#3D5AFE',
            pointRadius: 4
        }]
    },
    options: {
        responsive: true,
        plugins: { legend: { display:false } },
        scales: { y: { ticks:{ callback:v=>'Rp '+v.toLocaleString('id-ID') } } }
    }
});
<?php endif; ?>
</script>

<?php include '../includes/footer.php'; ?>