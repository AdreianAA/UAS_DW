<?php

include '../config/koneksi.php';

$error = '';

if(isset($_POST['simpan'])){

    $tanggal = mysqli_real_escape_string(
        $conn,
        $_POST['tanggal']
    );

    if($tanggal == ''){

        $error = 'Tanggal wajib diisi';

    } else {

        $tahun = date(
            'Y',
            strtotime($tanggal)
        );

        $bulan = date(
            'n',
            strtotime($tanggal)
        );

        $nama_bulan = [
            1=>'Januari',
            2=>'Februari',
            3=>'Maret',
            4=>'April',
            5=>'Mei',
            6=>'Juni',
            7=>'Juli',
            8=>'Agustus',
            9=>'September',
            10=>'Oktober',
            11=>'November',
            12=>'Desember'
        ];

        $bulan_nama =
        $nama_bulan[$bulan];

        $kuartal =
        ceil($bulan/3);

        mysqli_query(
            $conn,
            "
            INSERT INTO dim_waktu
            (
                tanggal,
                tahun,
                bulan,
                bulan_nama,
                kuartal
            )
            VALUES
            (
                '$tanggal',
                '$tahun',
                '$bulan',
                '$bulan_nama',
                '$kuartal'
            )
            "
        );

        header(
            "Location:index.php?msg=added"
        );

        exit;
    }
}

$base = '../';
$page_title = 'Tambah Waktu';
$active_menu = 'waktu';
$active_sub  = 'tambah';

include '../includes/header.php';
?>

<div class="page-heading">
    <div>
        <h2>Tambah Dimensi Waktu</h2>
        <p>Tambahkan data tanggal baru</p>
    </div>
</div>

<div class="surface-card form-shell">

    <?php if($error): ?>
        <div class="alert-app danger">
            <?= $error ?>
        </div>
    <?php endif; ?>

    <form method="POST">

        <div class="field">

            <label>Tanggal</label>

            <input
                type="date"
                name="tanggal"
                class="form-control"
                required>

        </div>

        <div class="form-actions">

            <button
                type="submit"
                name="simpan"
                class="btn-app-primary">

                Simpan

            </button>

            <a
                href="index.php"
                class="btn-app-cancel">

                Batal

            </a>

        </div>

    </form>

</div>

<?php include '../includes/footer.php'; ?>