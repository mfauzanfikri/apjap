<?php

session_start();

require_once './services/db.php';
require_once './utils/utils.php';

$perawat = getPerawat();

$jadwalPerawat = getJadwalPerawat();

?>

<?php include './layouts/header.php'; ?>

<script>
    // ubah page title
    $(document).prop('title', 'Pengajuan Jadwal Perawat')
</script>

<main id="main" class="main">

    <section class="pagetitle">
        <h1>Pengajuan Jadwal Perawat</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
                <li class="breadcrumb-item active">Pengajuan Jadwal Perawat</li>
            </ol>
        </nav>
    </section><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <!-- tab nav -->
                        <ul class="nav nav-tabs nav-tabs-bordered" id="pengajuan-jp" role="tablist">
                            <!-- pengajuan tab -->
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="pengajuan-tab" data-bs-toggle="tab" data-bs-target="#pengajuan" type="button" role="tab" aria-controls="home" aria-selected="true">Pengajuan</button>
                            </li>
                            <!-- selesai tab -->
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="selesai-tab" data-bs-toggle="tab" data-bs-target="#selesai" type="button" role="tab" aria-controls="profile" aria-selected="false">Selesai</button>
                            </li>
                        </ul>
                        <div class="tab-content pt-2" id="pengajuan-jp-content">
                            <!-- pengajuan content -->
                            <div class="tab-pane fade show active" id="pengajuan" role="tabpanel" aria-labelledby="pengajuan-tab">
                                <h5 class="card-title">Tabel Pengajuan Jadwal Perawat</h5>
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
                                        <table id="pengajuan-table" class="table table-striped" style="width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th></th>
                                                    <th>Nama Perawat</th>
                                                    <th>NIP</th>
                                                    <th>Tanggal</th>
                                                    <th>Waktu</th>
                                                    <th>Shift</th>
                                                    <th>Poli</th>
                                                    <?php if (authorization(['jabatan' => Jabatan::ATASAN])) : ?>
                                                        <th>Aksi</th>
                                                    <?php endif; ?>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($jadwalPerawat as $jp) : ?>
                                                    <?php if ($jp['status'] !== 'proses') continue; ?>
                                                    <tr>
                                                        <td></td>
                                                        <td><?= $jp['nama']; ?></td>
                                                        <td><?= $jp['nip']; ?></td>
                                                        <td><?= $jp['tanggal']; ?></td>
                                                        <td><?= $jp['waktu_mulai']; ?> - <?= $jp['waktu_selesai']; ?> WIB</td>
                                                        <td><?= $jp['shift'] ?></td>
                                                        <td><?= $jp['poli']; ?></td>
                                                        <?php if (authorization(['jabatan' => Jabatan::ATASAN])) : ?>
                                                            <td class="d-flex justify-content-center gap-2 text-start">
                                                                <!-- button terima -->
                                                                <form action="./actions/pengajuan_jadwal_perawat.php" method="post">
                                                                    <input type="hidden" name="jenis" value="terima">
                                                                    <input type="hidden" name="status" value="disetujui">
                                                                    <input type="hidden" name="id_validator" value="<?= $_SESSION['id_pegawai']; ?>">
                                                                    <input type="hidden" name="id_jadwal_perawat" value="<?= $jp['id_jadwal_perawat']; ?>">
                                                                    <button type="submit" name="submit" class="btn btn-success">
                                                                        Terima
                                                                    </button>
                                                                </form>
                                                                <!-- button tolak -->
                                                                <form action="./actions/pengajuan_jadwal_perawat.php" method="post">
                                                                    <input type="hidden" name="jenis" value="tolak">
                                                                    <input type="hidden" name="status" value="ditolak">
                                                                    <input type="hidden" name="id_validator" value="<?= $_SESSION['id_pegawai']; ?>">
                                                                    <input type="hidden" name="id_jadwal_perawat" value="<?= $jp['id_jadwal_perawat']; ?>">
                                                                    <button type="submit" name="submit" class="btn btn-danger">
                                                                        Tolak
                                                                    </button>
                                                                </form>
                                                            </td>
                                                        <?php endif; ?>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <!-- selesai content -->
                            <div class="tab-pane fade show" id="selesai" role="tabpanel" aria-labelledby="selesai-tab">
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
                                        <table id="selesai-table" class="table table-striped" style="width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th></th>
                                                    <th>Nama Perawat</th>
                                                    <th>NIP</th>
                                                    <th>Tanggal</th>
                                                    <th>Waktu</th>
                                                    <th>Shift</th>
                                                    <th>Poli</th>
                                                    <th>Status</th>
                                                    <th>Validator</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($jadwalPerawat as $jp) : ?>
                                                    <?php if ($jp['status'] === 'proses') continue; ?>
                                                    <tr>
                                                        <td></td>
                                                        <td><?= $jp['nama']; ?></td>
                                                        <td><?= $jp['nip']; ?></td>
                                                        <td><?= $jp['tanggal']; ?></td>
                                                        <td><?= $jp['waktu_mulai']; ?> - <?= $jp['waktu_selesai']; ?> WIB</td>
                                                        <td><?= $jp['shift'] ?></td>
                                                        <td><?= $jp['poli']; ?></td>
                                                        <td><span class="badge text-bg-<?= getStatusColor($jp['status']); ?>"><?= $jp['status'] ?></span></td>
                                                        <td><?= $jp['nama_validator']; ?>/<?= $jp['nip_validator']; ?></td>
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
    // table pengajuan jadwal perawat
    const tablePjp = $('#pengajuan-table').DataTable({
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
            [3, 'asc']
        ]
    });

    tablePjp
        .on('order.dt search.dt', function() {
            var i = 1;

            tablePjp
                .cells(null, 0, {
                    search: 'applied',
                    order: 'applied'
                })
                .every(function(cell) {
                    this.data(i++);
                });
        })
        .draw();

    // table jadwal perawat
    const tableJp = $('#selesai-table').DataTable({
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
                            columns: [1, 2, 3, 4, 5, 6, 7]
                        }
                    }
                ]
            }
        },
        order: [
            [3, 'asc']
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