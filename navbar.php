<?php
$current_page = basename($_SERVER['PHP_SELF']);
?>

<nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow">
    <div class="container">

        <a class="navbar-brand fw-bold" href="/dw-retail/index.php">
            📊 DW Retail
        </a>

        <button class="navbar-toggler"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#navbarNav">

            <span class="navbar-toggler-icon"></span>

        </button>

        <div class="collapse navbar-collapse" id="navbarNav">

            <ul class="navbar-nav ms-auto">

                <li class="nav-item">
                    <a class="nav-link <?= ($current_page=='index.php' ? 'active' : '') ?>"
                       href="/dw-retail/index.php">
                        Home
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link"
                       href="/dw-retail/produk/index.php">
                        Produk
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link"
                       href="/dw-retail/pelanggan/index.php">
                        Pelanggan
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link"
                       href="/dw-retail/waktu/index.php">
                        Dimensi Waktu
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link"
                       href="/dw-retail/transaksi/index.php">
                        Transaksi
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link"
                       href="/dw-retail/dashboard/index.php">
                        Dashboard
                    </a>
                </li>

            </ul>

        </div>

    </div>
</nav>