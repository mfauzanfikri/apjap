<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">
        <?php $url = explode('?', $_SERVER['REQUEST_URI'])[0]; ?>

        <!-- dashboard -->
        <li class="nav-item">
            <a class="nav-link <?= $url === '/dashboard' || $url === '/dashboard/'  ? '' : 'collapsed' ?>" href="/dashboard">
                <i class="bi bi-grid"></i>
                <span>Dashboard</span>
            </a>
        </li>

        <!-- kelola user -->
        <li class="nav-item">
            <a class="nav-link <?= $url === '/dashboard/kelola_user.php' ? '' : 'collapsed' ?>" href="/dashboard/kelola_user.php">
                <i class="bi bi-file-earmark"></i>
                <span>Kelola User</span>
            </a>
        </li>

        <!-- kelola ruangan -->
        <li class="nav-item">
            <a class="nav-link <?= $url === '/dashboard/kelola_ruangan.php' ? '' : 'collapsed' ?>" href="/dashboard/kelola_ruangan.php">
                <i class="bi bi-file-earmark"></i>
                <span>Kelola Ruangan</span>
            </a>
        </li>
    </ul>

</aside><!-- End Sidebar-->