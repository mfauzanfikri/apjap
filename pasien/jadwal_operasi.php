<?php

session_start();

require_once '../dashboard/services/db.php';
require_once '../dashboard/utils/utils.php';

$isAuthorized = authorization([
    'role' => Role::PASIEN
]);

if (!$isAuthorized) {
    redirect('/');
}


$jadwalOperasi = getJadwalOperasi();

?>

<?php include './layouts/header.php'; ?>

<script>
    // ubah page title
    $(document).prop('title', 'Jadwal Operasi')
</script>

<main id="main" class="main">

    <section class="pagetitle">
        <h1>Jadwal Operasi</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
                <li class="breadcrumb-item active">Jadwal Operasi</li>
            </ol>
        </nav>
    </section><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Tabel Jadwal Operasi</h5>
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
                                <!-- table jadwal operasi -->
                                <table id="jadwal-operasi-table" class="table table-striped" style="width: 100%;">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th>Tanggal Operasi</th>
                                            <th>Nama Pengaju</th>
                                            <th>Nama Dokter</th>
                                            <th>Validator</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($jadwalOperasi as $jo) : ?>
                                            <?php
                                            if ($jo['id_pasien'] !== $_SESSION['id_pasien']) continue;
                                            $validator = $jo['nama_validator'] ? $jo['nama_validator'] . "/" . $jo['nip_validator'] : "-";
                                            ?>
                                            <tr>
                                                <td></td>
                                                <td><?= $jo['tanggal']; ?></td>
                                                <td><?= $jo['nama_pengaju']; ?>/<?= $jo['nip_pengaju']; ?></td>
                                                <td><?= $jo['nama_dokter']; ?>/<?= $jo['nip_dokter']; ?></td>
                                                <td><?= $validator; ?></td>
                                                <td><span class="badge text-bg-<?= getStatusColor($jo['status']); ?>"><?= $jo['status'] ?></span></td>
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
    // table jadwal operasi
    const tableJo = $('#jadwal-operasi-table').DataTable({
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
                            columns: [1, 2, 3, 4, 5]
                        }
                    }
                ]
            }
        },
        order: [
            [1, 'desc']
        ]
    });

    tableJo
        .on('order.dt search.dt', function() {
            var i = 1;

            tableJo
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