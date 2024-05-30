<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">
        <?php $url = explode('?', $_SERVER['REQUEST_URI'])[0]; ?>

        <!-- pasien -->
        <li class="nav-item">
            <a class="nav-link <?= $url === '/pasien' || $url === '/pasien/' || $url === '/apkjadwal/pasien' || $url === '/apkjadwal/pasien/' || $url === '/apkjadwal/pasien/index.php' ? '' : 'collapsed' ?>" href="/pasien">
                <i class="bi bi-grid"></i>
                <span>Home</span>
            </a>
        </li>

        <li class="nav-heading">Jadwal Pasien</li>

        <!-- jadwal pemeriksaan -->
        <li class="nav-item">
            <a class="nav-link <?= $url === '/pasien/jadwal_pemeriksaan.php' || $url === '/apkjadwal/pasien/jadwal_pemeriksaan.php' ? '' : 'collapsed' ?>" href="/pasien/jadwal_pemeriksaan.php">
                <i class="bi bi-clipboard2-pulse"></i>
                <span>Jadwal Pemeriksaan</span>
            </a>
        </li>

        <!-- jadwal operasi -->
        <li class="nav-item">
            <a class="nav-link <?= $url === '/pasien/jadwal_operasi.php' || $url === '/apkjadwal/pasien/jadwal_operasi.php' ? '' : 'collapsed' ?>" href="/pasien/jadwal_operasi.php">
                <i class="bi bi-file-medical-fill"></i>
                <span>Jadwal Operasi</span>
            </a>
        </li>
    </ul>

</aside><!-- End Sidebar-->