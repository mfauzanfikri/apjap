<?php

session_start();

require_once './services/db.php';
require_once './utils/utils.php';

$cuti = getCuti();

?>

<?php include './layouts/header.php'; ?>

<script>
    // ubah page title
    $(document).prop('title', 'Pengajuan Cuti')
</script>

<main id="main" class="main">

    <section class="pagetitle">
        <h1>Pengajuan Jadwal Cuti</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
                <li class="breadcrumb-item active">Pengajuan Jadwal Cuti</li>
            </ol>
        </nav>
    </section><!-- End Page Title -->
    <!-- admin dan kepala bidang saja -->
    <?php if (authorization(['role' => [Role::ADMIN]]) || authorization(['jabatan' => [Jabatan::KEPALA_BIDANG]])) : ?>
        <section class="section">
            <div class="row">
                <div class="col">
                    <div class="card">
                        <div class="card-body">
                            <!-- tab nav -->
                            <ul class="nav nav-tabs nav-tabs-bordered" id="pengajuan-jc" role="tablist">
                                <!-- pengajuan tab -->
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="pengajuan-tab" data-bs-toggle="tab" data-bs-target="#pengajuan" type="button" role="tab" aria-controls="home" aria-selected="true">Pengajuan</button>
                                </li>
                                <!-- selesai tab -->
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="selesai-tab" data-bs-toggle="tab" data-bs-target="#selesai" type="button" role="tab" aria-controls="profile" aria-selected="false">Selesai</button>
                                </li>
                            </ul>
                            <div class="tab-content pt-2" id="pengajuan-jc-content">
                                <!-- pengajuan content -->
                                <div class="tab-pane fade show active" id="pengajuan" role="tabpanel" aria-labelledby="pengajuan-tab">
                                    <h5 class="card-title">Tabel Pengajuan Cuti oleh Pegawai</h5>
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
                                            <!-- table cuti -->
                                            <table id="pengajuan-table" class="table table-striped" style="width: 100%;">
                                                <thead>
                                                    <tr>
                                                        <th></th>
                                                        <th>Nama Pegawai</th>
                                                        <th>NIP</th>
                                                        <th>Tanggal Cuti</th>
                                                        <th>Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($cuti as $c) : ?>
                                                        <?php if ($c['status'] !== 'proses') continue; ?>
                                                        <tr>
                                                            <td></td>
                                                            <td><?= $c['nama']; ?></td>
                                                            <td><?= $c['nip']; ?></td>
                                                            <td><?= $c['tanggal_mulai']; ?> s.d. <?= $c['tanggal_selesai'] ?></td>
                                                            <td class="d-flex justify-content-center gap-2">
                                                                <!-- button terima -->
                                                                <form action="/dashboard/actions/pengajuan_jadwal_cuti.php" method="post">
                                                                    <input type="hidden" name="jenis" value="terima">
                                                                    <input type="hidden" name="status" value="disetujui">
                                                                    <input type="hidden" name="id_validator" value="<?= $_SESSION['id_pegawai']; ?>">
                                                                    <input type="hidden" name="id_cuti" value="<?= $c['id_cuti']; ?>">
                                                                    <button type="submit" name="submit" value="" class="btn btn-success">
                                                                        Terima
                                                                    </button>
                                                                </form>
                                                                <!-- button tolak -->
                                                                <form action="/dashboard/actions/pengajuan_jadwal_cuti.php" method="post">
                                                                    <input type="hidden" name="jenis" value="tolak">
                                                                    <input type="hidden" name="status" value="ditolak">
                                                                    <input type="hidden" name="id_validator" value="<?= $_SESSION['id_pegawai']; ?>">
                                                                    <input type="hidden" name="id_cuti" value="<?= $c['id_cuti']; ?>">
                                                                    <button type="submit" name="submit" value="" class="btn btn-danger">
                                                                        Tolak
                                                                    </button>
                                                                </form>
                                                            </td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <!-- selesai content -->
                                <div class="tab-pane fade show" id="selesai" role="tabpanel" aria-labelledby="selesai-tab">
                                    <h5 class="card-title">Tabel Cuti</h5>
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
                                            <!-- table cuti -->
                                            <table id="selesai-table" class="table table-striped" style="width: 100%;">
                                                <thead>
                                                    <tr>
                                                        <th></th>
                                                        <th>Nama Pegawai</th>
                                                        <th>NIP</th>
                                                        <th>Tanggal Cuti</th>
                                                        <th>Status</th>
                                                        <th>Validator</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($cuti as $c) : ?>
                                                        <?php if ($c['status'] === 'proses') continue; ?>
                                                        <tr>
                                                            <td></td>
                                                            <td><?= $c['nama']; ?></td>
                                                            <td><?= $c['nip']; ?></td>
                                                            <td><?= $c['tanggal_mulai']; ?> s.d. <?= $c['tanggal_selesai']; ?></td>
                                                            <td><span class="badge text-bg-<?= getStatusColor($c['status']); ?>"><?= $c['status'] ?></span></td>
                                                            <td><?= $c['nama_validator']; ?>/<?= $c['nip_validator']; ?></td>
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
                </div>
            </div>
        </section>
    <?php endif; ?>

    <section class="section">
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <!-- tab nav -->
                        <ul class="nav nav-tabs nav-tabs-bordered" id="pengajuan-jc-staff" role="tablist">
                            <!-- pengajuan staff tab -->
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="pengajuan-staff-tab" data-bs-toggle="tab" data-bs-target="#pengajuan-staff" type="button" role="tab" aria-controls="home" aria-selected="true">Pengajuan</button>
                            </li>
                            <!-- selesai staff tab -->
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="selesai-staff-tab" data-bs-toggle="tab" data-bs-target="#selesai-staff" type="button" role="tab" aria-controls="profile" aria-selected="false">Selesai</button>
                            </li>
                        </ul>
                        <div class="tab-content pt-2" id="pengajuan-jc-staff-content">
                            <!-- pengajuan staff content -->
                            <div class="tab-pane fade show active" id="pengajuan-staff" role="tabpanel" aria-labelledby="pengajuan-jc-staff-tab">
                                <h5 class="card-title">Tabel Pengajuan Cuti</h5>
                                <div class="row justify-content-end">
                                    <div class="col">
                                        <div class="d-flex justify-content-end">
                                            <!-- pengajuan jadwal operasi modal -->
                                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#pengajuan-cuti-modal">
                                                Ajukan Cuti
                                            </button>

                                            <div class="modal fade" id="pengajuan-cuti-modal" tabindex="-1">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Pengajuan Jadwal Operasi</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <!-- pengajuan jadwal operasi  form -->
                                                        <form action="/dashboard/actions/pengajuan_jadwal_cuti.php" method="post">
                                                            <input type="hidden" name="jenis" value="tambah">
                                                            <input type="hidden" name="id_pegawai" value="<?= $_SESSION['id_pegawai']; ?>">
                                                            <div class="modal-body">
                                                                <div class="row gap-3">
                                                                    <div class="col-12">
                                                                        <label for="tanggal_mulai">Tanggal Mulai</label>
                                                                        <input id="tanggal_mulai" class="form-control" type="date" name="tanggal_mulai" required />
                                                                    </div>
                                                                    <div class="col-12">
                                                                        <label for="tanggal_selesai">Tanggal Selesai</label>
                                                                        <input id="tanggal_selesai" class="form-control" type="date" name="tanggal_selesai" required />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                                                <button type="submit" class="btn btn-primary" name="submit">Ajukan</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

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
                                        <!-- table cuti -->
                                        <table id="pengajuan-staff-table" class="table table-striped" style="width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th></th>
                                                    <th>Nama Pegawai</th>
                                                    <th>NIP</th>
                                                    <th>Tanggal Cuti</th>
                                                    <th>status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($cuti as $c) : ?>
                                                    <?php if ($c['status'] !== 'proses') continue; ?>
                                                    <?php if ($c['id_pegawai'] !== $_SESSION['id_pegawai']) continue; ?>
                                                    <tr>
                                                        <td></td>
                                                        <td><?= $c['nama']; ?></td>
                                                        <td><?= $c['nip']; ?></td>
                                                        <td><?= $c['tanggal_mulai']; ?> s.d. <?= $c['tanggal_selesai'] ?></td>
                                                        <td><span class="badge text-bg-<?= getStatusColor($c['status']); ?>"><?= $c['status'] ?></span></td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <!-- selesai staff content -->
                            <div class="tab-pane fade show" id="selesai-staff" role="tabpanel" aria-labelledby="selesai-tab">
                                <h5 class="card-title">Tabel Cuti</h5>
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
                                        <!-- table cuti -->
                                        <table id="selesai-staff-table" class="table table-striped" style="width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th></th>
                                                    <th>Nama Pegawai</th>
                                                    <th>NIP</th>
                                                    <th>Tanggal Cuti</th>
                                                    <th>Status</th>
                                                    <th>Validator</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($cuti as $c) : ?>
                                                    <?php if ($c['status'] === 'proses') continue; ?>
                                                    <?php if ($c['id_pegawai'] !== $_SESSION['id_pegawai']) continue; ?>
                                                    <tr>
                                                        <td></td>
                                                        <td><?= $c['nama']; ?></td>
                                                        <td><?= $c['nip']; ?></td>
                                                        <td><?= $c['tanggal_mulai']; ?> s.d. <?= $c['tanggal_selesai']; ?></td>
                                                        <td><span class="badge text-bg-<?= getStatusColor($c['status']); ?>"><?= $c['status'] ?></span></td>
                                                        <td><?= $c['nama_validator']; ?>/<?= $c['nip_validator']; ?></td>
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
    // table pengajuan cuti
    const tablePjc = $('#pengajuan-table').DataTable({
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
                            columns: [1, 2, 3]
                        }
                    }
                ]
            }
        },
        order: [
            [3, 'asc']
        ]
    });

    tablePjc
        .on('order.dt search.dt', function() {
            var i = 1;

            tablePjc
                .cells(null, 0, {
                    search: 'applied',
                    order: 'applied'
                })
                .every(function(cell) {
                    this.data(i++);
                });
        })
        .draw();

    // table cuti
    const tableJc = $('#selesai-table').DataTable({
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
                            columns: [1, 2, 3, 4]
                        }
                    }
                ]
            }
        },
        order: [
            [3, 'desc']
        ]
    });

    tableJc
        .on('order.dt search.dt', function() {
            var i = 1;

            tableJc
                .cells(null, 0, {
                    search: 'applied',
                    order: 'applied'
                })
                .every(function(cell) {
                    this.data(i++);
                });
        })
        .draw();

    // table pengajuan cuti staff
    const tablePjcs = $('#pengajuan-staff-table').DataTable({
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
                            columns: [1, 2, 3]
                        }
                    }
                ]
            }
        },
        order: [
            [3, 'asc']
        ]
    });

    tablePjcs
        .on('order.dt search.dt', function() {
            var i = 1;

            tablePjcs
                .cells(null, 0, {
                    search: 'applied',
                    order: 'applied'
                })
                .every(function(cell) {
                    this.data(i++);
                });
        })
        .draw();

    // table cuti
    const tableJcs = $('#selesai-staff-table').DataTable({
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
                            columns: [1, 2, 3, 4]
                        }
                    }
                ]
            }
        },
        order: [
            [3, 'desc']
        ]
    });

    tableJcs
        .on('order.dt search.dt', function() {
            var i = 1;

            tableJcs
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