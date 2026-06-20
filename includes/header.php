<?php
/**
 * includes/header.php
 * Dipanggil dari tiap halaman. Sebelum include, halaman WAJIB set:
 *   $base       = '../'  (jika file ada di dalam subfolder) atau '' (jika di root)
 *   $page_title = 'Judul Halaman'
 *   $active_menu = 'dashboard' | 'produk' | 'pelanggan' | 'waktu' | 'transaksi'
 *   $active_sub  = (opsional) 'tambah' | 'tabel'  -> untuk highlight submenu
 */
if(!isset($base))        $base = '';
if(!isset($page_title))  $page_title = 'Inventory App';
if(!isset($active_menu)) $active_menu = '';
if(!isset($active_sub))  $active_sub = '';

function dwActive($menu, $target){ return $menu === $target ? ' active' : ''; }
function dwOpen($menu, $target){ return $menu === $target ? ' open' : ''; }
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= htmlspecialchars($page_title) ?> · Inventory App</title>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
<link rel="stylesheet" href="<?= $base ?>assets/css/style.css">
</head>
<body>

<div class="app-shell">

    <!-- ===================== SIDEBAR ===================== -->
    <aside class="sidebar" id="sidebar">

        <div class="sidebar-brand">
            <span class="brand-icon"><span>◆</span></span>
            Inventory App
        </div>

        <div class="sidebar-section-label">Menu</div>

        <!-- Dashboard -->
        <div class="nav-group">
            <a class="nav-top-link no-children<?= dwActive($active_menu,'dashboard') ?>"
               href="<?= $base ?>dashboard/index.php">
                <i class="bi bi-grid-1x2-fill"></i> Dashboard
            </a>
        </div>

        <!-- Produk -->
        <div class="nav-group<?= dwOpen($active_menu,'produk') ?>">
            <a class="nav-top-link<?= dwActive($active_menu,'produk') ?>" data-toggle-submenu>
                <i class="bi bi-box-seam-fill"></i> Produk
                <i class="bi bi-chevron-down chev"></i>
            </a>
            <ul class="submenu">
                <li><a href="<?= $base ?>produk/tambah.php" class="<?= ($active_menu=='produk'&&$active_sub=='tambah')?'active':'' ?>">Tambah Produk</a></li>
                <li><a href="<?= $base ?>produk/index.php" class="<?= ($active_menu=='produk'&&$active_sub=='tabel')?'active':'' ?>">Edit Produk</a></li>
                <li><a href="<?= $base ?>produk/index.php">Hapus Produk</a></li>
                <li><a href="<?= $base ?>produk/index.php">Tabel Produk</a></li>
            </ul>
        </div>

        <!-- Pelanggan -->
        <div class="nav-group<?= dwOpen($active_menu,'pelanggan') ?>">
            <a class="nav-top-link<?= dwActive($active_menu,'pelanggan') ?>" data-toggle-submenu>
                <i class="bi bi-people-fill"></i> Pelanggan
                <i class="bi bi-chevron-down chev"></i>
            </a>
            <ul class="submenu">
                <li><a href="<?= $base ?>pelanggan/tambah.php" class="<?= ($active_menu=='pelanggan'&&$active_sub=='tambah')?'active':'' ?>">Tambah Pelanggan</a></li>
                <li><a href="<?= $base ?>pelanggan/index.php" class="<?= ($active_menu=='pelanggan'&&$active_sub=='tabel')?'active':'' ?>">Tabel Pelanggan</a></li>
            </ul>
        </div>

        <!-- Waktu -->
        <div class="nav-group<?= dwOpen($active_menu,'waktu') ?>">
            <a class="nav-top-link<?= dwActive($active_menu,'waktu') ?>" data-toggle-submenu>
                <i class="bi bi-calendar3"></i> Waktu
                <i class="bi bi-chevron-down chev"></i>
            </a>
            <ul class="submenu">
                <li><a href="<?= $base ?>waktu/tambah.php" class="<?= ($active_menu=='waktu'&&$active_sub=='tambah')?'active':'' ?>">Tambah Waktu</a></li>
                <li><a href="<?= $base ?>waktu/index.php" class="<?= ($active_menu=='waktu'&&$active_sub=='tabel')?'active':'' ?>">Tabel Waktu</a></li>
            </ul>
        </div>

        <!-- Transaksi -->
        <div class="nav-group<?= dwOpen($active_menu,'transaksi') ?>">
            <a class="nav-top-link<?= dwActive($active_menu,'transaksi') ?>" data-toggle-submenu>
                <i class="bi bi-receipt"></i> Transaksi
                <i class="bi bi-chevron-down chev"></i>
            </a>
            <ul class="submenu">
                <li><a href="<?= $base ?>transaksi/tambah.php" class="<?= ($active_menu=='transaksi'&&$active_sub=='tambah')?'active':'' ?>">Tambah Transaksi</a></li>
                <li><a href="<?= $base ?>transaksi/index.php" class="<?= ($active_menu=='transaksi'&&$active_sub=='tabel')?'active':'' ?>">Tabel Transaksi</a></li>
            </ul>
        </div>

    </aside>

    <div class="main-col">

        <!-- ===================== TOPBAR ===================== -->
        <header class="topbar">
            <button class="toggle-sidebar" id="toggleSidebar">
                <i class="bi bi-list"></i>
            </button>
            <div class="topbar-title"><?= htmlspecialchars($page_title) ?></div>

            <div class="topbar-right">
                <button class="icon-btn"><i class="bi bi-bell-fill"></i><span class="dot"></span></button>
                <div class="avatar-circle"><i class="bi bi-person-fill"></i></div>
            </div>
        </header>

        <main class="content">
