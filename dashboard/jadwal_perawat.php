<?php

session_start();

require_once './services/db.php';
require_once './utils/utils.php';

checkNotifikasiJadwalPerawat();

$isAuthorized = authorization([
    'profesi' => Profesi::PERAWAT
]) || authorization([
    'role' => Role::ADMIN
]);

if (!$isAuthorized) {
    redirect('./');
}

$perawat = getPerawat();

$jadwalPerawat = getJadwalPerawat();

?>

<?php include './layouts/header.php'; ?>

<script>
    // ubah page title
    $(document).prop('title', 'Jadwal Perawat')
</script>

<main id="main" class="main">

    <section class="pagetitle">
        <h1>Jadwal Perawat</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
                <li class="breadcrumb-item active">Jadwal Perawat</li>
            </ol>
        </nav>
    </section><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-body">

                        <h5 class="card-title">Tabel Jadwal Perawat</h5>

                        <?php if (isset($_SESSION['successMsg'])) : ?>
                            <div class="mt-2">
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <?= $_SESSION['successMsg']; ?>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            </div>
                        <?php endif; ?>

                        <?php if (isset($_SESSION['errorMsg'])) : ?>
                            <div class="mt-2">
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <?= $_SESSION['errorMsg']; ?>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            </div>
                        <?php endif; ?>

                        <div class="row mt-2">
                            <div class="col">
                                <!-- table jadwal perawat gigi -->
                                <table id="jp-table" class="table table-striped" style="width: 100%;">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th>Nama Perawat</th>
                                            <th>NIP</th>
                                            <th>Tanggal</th>
                                            <th>Waktu</th>
                                            <th>Shift</th>
                                            <th>Poli</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($jadwalPerawat as $jp) : ?>
                                            <?php if ($jp['status'] === 'proses') continue; ?>
                                            <?php if ($jp['nip'] !== $_SESSION['nip']) continue; ?>
                                            <tr>
                                                <td></td>
                                                <td><?= $jp['nama']; ?></td>
                                                <td><?= $jp['nip']; ?></td>
                                                <td><?= $jp['tanggal']; ?></td>
                                                <td><?= $jp['waktu_mulai']; ?> - <?= $jp['waktu_selesai']; ?> WIB</td>
                                                <td><?= $jp['shift'] ?></td>
                                                <td><?= $jp['poli']; ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>

</main><!-- End #main -->

<?php

if (isset($_SESSION['successMsg'])) {
    unset($_SESSION['successMsg']);
}

if (isset($_SESSION['errorMsg'])) {
    unset($_SESSION['errorMsg']);
}

if (isset($_SESSION['warningMsg'])) {
    unset($_SESSION['warningMsg']);
}

?>

<script src="assets/vendor/datatables/datatables.min.js"></script>

<script>
    // table jadwal perawat
    const tableJp = $('#jp-table').DataTable({
        columnDefs: [{
            searchable: false,
            orderable: false,
            width: '1%',
            targets: 0
        }, {
            className: "dt-head-center dt-body-center",
            targets: ['_all']
        }, ],
        layout: {
            topStart: {
                buttons: [
                    'pageLength',
                    {
                        extend: 'searchBuilder',
                        config: {
                            columns: [1, 2, 3, 4, 5, 6]
                        }
                    }
                ]
            }
        },
        order: [
            [3, 'desc']
        ]
    });

    tableJp
        .on('order.dt search.dt', function() {
            var i = 1;

            tableJp
                .cells(null, 0, {
                    search: 'applied',
                    order: 'applied'
                })
                .every(function(cell) {
                    this.data(i++);
                });
        })
        .draw();
</script>

<?php include './layouts/footer.php'; ?>