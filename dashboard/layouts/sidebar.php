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

        <li class="nav-heading">Sumber Daya</li>

        <!-- kelola user -->
        <li class="nav-item">
            <a class="nav-link <?= $url === '/dashboard/kelola_user.php' ? '' : 'collapsed' ?>" href="/dashboard/kelola_user.php">
                <i class="bi bi-person"></i>
                <span>Kelola User</span>
            </a>
        </li>

        <!-- kelola pegawai -->
        <li class="nav-item">
            <a class="nav-link <?= $url === '/dashboard/kelola_pegawai.php' ? '' : 'collapsed' ?>" href="/dashboard/kelola_pegawai.php">
                <i class="bi bi-people"></i>
                <span>Kelola Pegawai</span>
            </a>
        </li>

        <!-- kelola dokter -->
        <li class="nav-item">
            <a class="nav-link <?= $url === '/dashboard/kelola_dokter.php' ? '' : 'collapsed' ?>" href="/dashboard/kelola_dokter.php">
                <i class="bi bi-person-badge"></i>
                <span>Kelola Dokter</span>
            </a>
        </li>

        <!-- kelola perawat -->
        <li class="nav-item">
            <a class="nav-link <?= $url === '/dashboard/kelola_perawat.php' ? '' : 'collapsed' ?>" href="/dashboard/kelola_perawat.php">
                <i class="bi bi-person-badge-fill"></i>
                <span>Kelola Perawat</span>
            </a>
        </li>

        <!-- kelola ruangan -->
        <li class="nav-item">
            <a class="nav-link <?= $url === '/dashboard/kelola_ruangan.php' ? '' : 'collapsed' ?>" href="/dashboard/kelola_ruangan.php">
                <i class="bi bi-hospital"></i>
                <span>Kelola Ruangan</span>
            </a>
        </li>

        <li class="nav-heading">Penjadwalan Kerja</li>

        <!-- kelola jadwal dokter -->
        <li class="nav-item">
            <a class="nav-link <?= $url === '/dashboard/kelola_jadwal_dokter.php' ? '' : 'collapsed' ?>" href="/dashboard/kelola_jadwal_dokter.php">
                <i class="bi bi-calendar"></i>
                <span>Kelola Jadwal Dokter</span>
            </a>
        </li>

        <!-- kelola jadwal perawat -->
        <li class="nav-item">
            <a class="nav-link <?= $url === '/dashboard/kelola_jadwal_perawat.php' ? '' : 'collapsed' ?>" href="/dashboard/kelola_jadwal_perawat.php">
                <i class="bi bi-calendar-fill"></i>
                <span>Kelola Jadwal Perawat</span>
            </a>
        </li>
        </li>

        <!-- kelola jadwal libur -->
        <li class="nav-item">
            <a class="nav-link <?= $url === '/dashboard/kelola_libur.php' ? '' : 'collapsed' ?>" href="/dashboard/kelola_libur.php">
                <i class="bi bi-calendar-check"></i>
                <span>Kelola Jadwal Libur</span>
            </a>
        </li>

        <!-- kelola jadwal cuti -->
        <li class="nav-item">
            <a class="nav-link <?= $url === '/dashboard/kelola_cuti.php' ? '' : 'collapsed' ?>" href="/dashboard/kelola_cuti.php">
                <i class="bi bi-calendar-check-fill"></i>
                <span>Kelola Jadwal Cuti</span>
            </a>
        </li>

        <li class="nav-heading">Jadwal Kerja</li>

        <li class="nav-item">
            <a class="nav-link <?= $url === '/dashboard/jadwal_dokter.php' ? '' : 'collapsed' ?>" href="/dashboard/jadwal_dokter.php">
                <i class="bi bi-calendar-plus"></i>
                <span>Jadwal Dokter</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link <?= $url === '/dashboard/jadwal_perawat.php' ? '' : 'collapsed' ?>" href="/dashboard/jadwal_perawat.php">
                <i class="bi bi-calendar-plus-fill"></i>
                <span>Jadwal Perawat</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link <?= $url === '/dashboard/jadwal_pemeriksaan_pasien.php' ? '' : 'collapsed' ?>" href="/dashboard/jadwal_pemeriksaan_pasien.php">
                <i class="bi bi-calendar3-event"></i>
                <span>Jadwal Pemeriksaan Pasien</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link <?= $url === '/dashboard/jadwal_operasi_pasien.php' ? '' : 'collapsed' ?>" href="/dashboard/jadwal_operasi_pasien.php">
                <i class="bi bi-calendar3-event-fill"></i>
                <span>Jadwal Operasi Pasien</span>
            </a>
        </li>


        <li class="nav-heading">Pengajuan Jadwal</li>

        <li class="nav-item">
            <a class="nav-link <?= $url === '/dashboard/pengajuan_jadwal_perawat.php' ? '' : 'collapsed' ?>" href="/dashboard/pengajuan_jadwal_perawat.php">
                <i class="bi bi-calendar2"></i>
                <span>Pengajuan Jadwal Perawat</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link <?= $url === '/dashboard/pengajuan_jadwal_cuti.php' ? '' : 'collapsed' ?>" href="/dashboard/pengajuan_jadwal_cuti.php">
                <i class="bi bi-calendar2-event-fill"></i>
                <span>Pengajuan Jadwal Cuti</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link <?= $url === '/dashboard/pengajuan_jadwal_operasi.php' ? '' : 'collapsed' ?>" href="/dashboard/pengajuan_jadwal_operasi.php">
                <i class="bi bi-calendar2-heart"></i>
                <span>Pengajuan Jadwal Operasi</span>
            </a>
        </li>

        <li class="nav-heading">Laporan</li>

        <!-- laporan jadwal kerja -->
        <li class="nav-item">
            <a class="nav-link <?= $url === '/dashboard/laporan_jadwal_kerja.php' ? '' : 'collapsed' ?>" href="/dashboard/laporan_jadwal_kerja.php">
                <i class="bi bi-file-earmark-zip"></i>
                <span>Laporan Jadwal kerja</span>
            </a>
        </li>
    </ul>

</aside><!-- End Sidebar-->