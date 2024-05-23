<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">
        <?php $url = explode('?', $_SERVER['REQUEST_URI'])[0]; ?>

        <!-- pasien -->
        <li class="nav-item">
            <a class="nav-link <?= $url === '/pasien' || $url === '/pasien/'  ? '' : 'collapsed' ?>" href="/pasien">
                <i class="bi bi-grid"></i>
                <span>Dashboard</span>
            </a>
        </li>

        <li class="nav-heading">Jadwal Pasien</li>

        <!-- jadwal pemeriksaan -->
        <li class="nav-item">
            <a class="nav-link <?= $url === '/pasien/jadwal_pasien.php' ? '' : 'collapsed' ?>" href="/dashboard/jadwal_pasien.php">
                <i class="bi bi-person"></i>
                <span>Jadwal Pasien</span>
            </a>
        </li>
    </ul>

</aside><!-- End Sidebar-->