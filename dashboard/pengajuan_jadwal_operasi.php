<?php

session_start();

require_once './services/db.php';
require_once './utils/utils.php';


$jadwalOperasi = getJadwalOperasi();
$dokterSelect = getDokter();
$pasienSelect = getPasien();
$ruanganSelect = getRuangan();

?>

<?php include './layouts/header.php'; ?>

<script>
    // ubah page title
    $(document).prop('title', 'Pengajuan Jadwal Operasi')
</script>

<main id="main" class="main">

    <section class="pagetitle">
        <h1>Pengajuan Jadwal Operasi</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
                <li class="breadcrumb-item active">Pengajuan Jadwal Operasi</li>
            </ol>
        </nav>
    </section><!-- End Page Title -->

    <?php if (authorization(['role' => [Role::ADMIN]]) || authorization(['jabatan' => [Jabatan::KEPALA_BIDANG]])) : ?>
        <section class="section">
            <div class="row">
                <div class="col">
                    <div class="card">
                        <div class="card-body">
                            <!-- tab nav -->
                            <ul class="nav nav-tabs nav-tabs-bordered" id="pengajuan-jo" role="tablist">
                                <!-- pengajuan tab -->
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="pengajuan-tab" data-bs-toggle="tab" data-bs-target="#pengajuan" type="button" role="tab" aria-controls="home" aria-selected="true">Pengajuan</button>
                                </li>
                                <!-- selesai tab -->
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="selesai-tab" data-bs-toggle="tab" data-bs-target="#selesai" type="button" role="tab" aria-controls="profile" aria-selected="false">Selesai</button>
                                </li>
                            </ul>
                            <div class="tab-content pt-2" id="pengajuan-jo-content">
                                <!-- pengajuan content -->
                                <div class="tab-pane fade show active" id="pengajuan" role="tabpanel" aria-labelledby="pengajuan-tab">
                                    <h5 class="card-title">Tabel Pengajuan Jadwal Operasi</h5>
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
                                            <table id="pengajuan-table" class="table table-striped" style="width: 100%;">
                                                <thead>
                                                    <tr>
                                                        <th></th>
                                                        <th>Nama Pasien/No. Telp</th>
                                                        <th>Tanggal Operasi</th>
                                                        <th>Nama Pengaju</th>
                                                        <th>Nama Dokter</th>
                                                        <th>Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($jadwalOperasi as $jo) : ?>
                                                        <?php if ($jo['status'] !== 'proses') continue; ?>
                                                        <tr>
                                                            <td></td>
                                                            <td><?= $jo['nama_pasien']; ?>/<?= $jo['no_telepon_pasien']; ?></td>
                                                            <td><?= $jo['tanggal']; ?></td>
                                                            <td><?= $jo['nama_pengaju']; ?>/<?= $jo['nip_pengaju']; ?></td>
                                                            <td><?= $jo['nama_dokter']; ?>/<?= $jo['nip_dokter']; ?></td>
                                                            <td class="d-flex justify-content-center gap-2">
                                                                <!-- button terima -->
                                                                <form action="/dashboard/actions/pengajuan_jadwal_operasi.php" method="post">
                                                                    <input type="hidden" name="jenis" value="terima">
                                                                    <input type="hidden" name="status" value="disetujui">
                                                                    <input type="hidden" name="id_validator" value="<?= $_SESSION['id_pegawai']; ?>">
                                                                    <input type="hidden" name="id_jadwal_operasi" value="<?= $jo['id_jadwal_operasi']; ?>">
                                                                    <button type="submit" name="submit" value="" class="btn btn-success">
                                                                        Terima
                                                                    </button>
                                                                </form>
                                                                <!-- button tolak -->
                                                                <form action="/dashboard/actions/pengajuan_jadwal_operasi.php" method="post">
                                                                    <input type="hidden" name="jenis" value="tolak">
                                                                    <input type="hidden" name="status" value="ditolak">
                                                                    <input type="hidden" name="id_validator" value="<?= $_SESSION['id_pegawai']; ?>">
                                                                    <input type="hidden" name="id_jadwal_operasi" value="<?= $jo['id_jadwal_operasi']; ?>">
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
                                            <table id="selesai-table" class="table table-striped" style="width: 100%;">
                                                <thead>
                                                    <tr>
                                                        <th></th>
                                                        <th>Nama Pasien/No. Telp</th>
                                                        <th>Tanggal Operasi</th>
                                                        <th>Nama Pengaju</th>
                                                        <th>Nama Dokter</th>
                                                        <th>Validator</th>
                                                        <th>Status</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($jadwalOperasi as $jo) : ?>
                                                        <?php if ($jo['status'] === 'proses') continue; ?>
                                                        <tr>
                                                            <td></td>
                                                            <td><?= $jo['nama_pasien']; ?>/<?= $jo['no_telepon_pasien']; ?></td>
                                                            <td><?= $jo['tanggal']; ?></td>
                                                            <td><?= $jo['nama_pengaju']; ?>/<?= $jo['nip_pengaju']; ?></td>
                                                            <td><?= $jo['nama_dokter']; ?>/<?= $jo['nip_dokter']; ?></td>
                                                            <td><?= $jo['nama_validator']; ?>/<?= $jo['nip_validator']; ?></td>
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
                        <ul class="nav nav-tabs nav-tabs-bordered" id="pengajuan-jo-staff" role="tablist">
                            <!-- pengajuan tab -->
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="pengajuan-tab" data-bs-toggle="tab" data-bs-target="#pengajuan-staff" type="button" role="tab" aria-controls="home" aria-selected="true">Pengajuan</button>
                            </li>
                            <!-- selesai tab -->
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="selesai-tab" data-bs-toggle="tab" data-bs-target="#selesai-staff" type="button" role="tab" aria-controls="profile" aria-selected="false">Selesai</button>
                            </li>
                        </ul>
                        <div class="tab-content pt-2" id="pengajuan-jo-staff-content">
                            <!-- pengajuan content -->
                            <div class="tab-pane fade show active" id="pengajuan-staff" role="tabpanel" aria-labelledby="pengajuan-tab">
                                <h5 class="card-title">Tabel Pengajuan Jadwal Operasi</h5>
                                <div class="row justify-content-end">
                                    <div class="col">
                                        <div class="d-flex justify-content-end">
                                            <!-- pengajuan jadwal operasi modal -->
                                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#pengajuan-operasi-modal">
                                                Ajukan Jadwal Operasi
                                            </button>

                                            <div class="modal fade" id="pengajuan-operasi-modal" tabindex="-1">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Pengajuan Jadwal Operasi</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <!-- pengajuan jadwal operasi  form -->
                                                        <form action="/dashboard/actions/pengajuan_jadwal_operasi.php" method="post">
                                                            <input type="hidden" name="jenis" value="tambah">
                                                            <input type="hidden" name="id_pengaju" value="<?= $_SESSION['id_pegawai']; ?>">
                                                            <div class="modal-body">
                                                                <div class="row gap-3">
                                                                    <div class="col-12">
                                                                        <label for="tanggal">Tanggal Operasi</label>
                                                                        <input id="tanggal" class="form-control" type="date" name="tanggal" required />
                                                                    </div>
                                                                    <div class="col-12">
                                                                        <label for="id_pasien" class="form-label">Pasien</label>
                                                                        <select id="id_pasien" class="form-select" name="id_pasien" required>
                                                                            <option selected disabled value="0">Pilih Pasien</option>
                                                                            <?php foreach ($pasienSelect as $p) : ?>
                                                                                <option value="<?= $p['id_pasien'] ?>"><?= $p['nama'] ?>/<?= $p['no_telepon'] ?></option>
                                                                            <?php endforeach; ?>
                                                                        </select>
                                                                    </div>
                                                                    <div class="col-12">
                                                                        <label for="id_dokter" class="form-label">Dokter</label>
                                                                        <select id="id_dokter" class="form-select" name="id_dokter" required>
                                                                            <option selected disabled value="0">Pilih Dokter</option>
                                                                            <?php foreach ($dokterSelect as $d) : ?>
                                                                                <option value="<?= $d['id_dokter'] ?>"><?= $d['nama'] ?>/<?= $d['nip'] ?></option>
                                                                            <?php endforeach; ?>
                                                                        </select>
                                                                    </div>
                                                                    <div class="col-12">
                                                                        <label for="id_ruangan" class="form-label">Ruangan</label>
                                                                        <select id="id_ruangan" class="form-select" name="id_ruangan" required>
                                                                            <option selected disabled value="0">Pilih Ruangan</option>
                                                                            <?php foreach ($ruanganSelect as $r) : ?>
                                                                                <option value="<?= $r['id_ruangan'] ?>"><?= $r['nama'] ?></option>
                                                                            <?php endforeach; ?>
                                                                        </select>
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
                                        <!-- table jadwal operasi -->
                                        <table id="pengajuan-staff-table" class="table table-striped" style="width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th></th>
                                                    <th>Nama Pasien/No. Telp</th>
                                                    <th>Tanggal Operasi</th>
                                                    <th>Nama Pengaju</th>
                                                    <th>Nama Dokter</th>
                                                    <th>Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($jadwalOperasi as $jo) : ?>
                                                    <?php if ($jo['id_pengaju'] !== $_SESSION['id_pegawai']) continue; ?>
                                                    <tr>
                                                        <td></td>
                                                        <td><?= $jo['nama_pasien']; ?>/<?= $jo['no_telepon_pasien']; ?></td>
                                                        <td><?= $jo['tanggal']; ?></td>
                                                        <td><?= $jo['nama_pengaju']; ?>/<?= $jo['nip_pengaju']; ?></td>
                                                        <td><?= $jo['nama_dokter']; ?>/<?= $jo['nip_dokter']; ?></td>
                                                        <td class="text-center"><span class="badge text-bg-<?= getStatusColor($jo['status']); ?>"><?= $jo['status'] ?></span></td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <!-- selesai content -->
                            <div class="tab-pane fade show" id="selesai-staff" role="tabpanel" aria-labelledby="selesai-tab">
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
                                        <table id="selesai-staff-table" class="table table-striped" style="width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th></th>
                                                    <th>Nama Pasien/No. Telp</th>
                                                    <th>Tanggal Operasi</th>
                                                    <th>Nama Pengaju</th>
                                                    <th>Nama Dokter</th>
                                                    <th>Validator</th>
                                                    <th>Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($jadwalOperasi as $jo) : ?>
                                                    <?php if ($jo['status'] === 'proses') continue; ?>
                                                    <?php if ($jo['id_pengaju'] !== $_SESSION['id_pegawai']) continue; ?>
                                                    <tr>
                                                        <td></td>
                                                        <td><?= $jo['nama_pasien']; ?>/<?= $jo['no_telepon_pasien']; ?></td>
                                                        <td><?= $jo['tanggal']; ?></td>
                                                        <td><?= $jo['nama_pengaju']; ?>/<?= $jo['nip_pengaju']; ?></td>
                                                        <td><?= $jo['nama_dokter']; ?>/<?= $jo['nip_dokter']; ?></td>
                                                        <td><?= $jo['nama_validator']; ?>/<?= $jo['nip_validator']; ?></td>
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
    // table pengajuan jadwal operasi
    const tablePjo = $('#pengajuan-table').DataTable({
        columnDefs: [{
            searchable: false,
            orderable: false,
            width: '1%',
            targets: 0
        }, {
            className: "dt-head-center",
            targets: [5]
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
            [2, 'asc']
        ]
    });

    tablePjo
        .on('order.dt search.dt', function() {
            var i = 1;

            tablePjo
                .cells(null, 0, {
                    search: 'applied',
                    order: 'applied'
                })
                .every(function(cell) {
                    this.data(i++);
                });
        })
        .draw();

    // table jadwal operasi
    const tableJo = $('#selesai-table').DataTable({
        columnDefs: [{
            searchable: false,
            orderable: false,
            width: '1%',
            targets: 0
        }, {
            className: "dt-head-center",
            targets: [6]
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
            [2, 'desc']
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

    // table pengajuan jadwal operasi staff
    const tablePjos = $('#pengajuan-staff-table').DataTable({
        columnDefs: [{
            searchable: false,
            orderable: false,
            width: '1%',
            targets: 0
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
            [2, 'asc']
        ]
    });

    tablePjos
        .on('order.dt search.dt', function() {
            var i = 1;

            tablePjos
                .cells(null, 0, {
                    search: 'applied',
                    order: 'applied'
                })
                .every(function(cell) {
                    this.data(i++);
                });
        })
        .draw();

    // table jadwal operasi
    const tableJos = $('#selesai-staff-table').DataTable({
        columnDefs: [{
            searchable: false,
            orderable: false,
            width: '1%',
            targets: 0
        }],
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
            [2, 'desc']
        ]
    });

    tableJos
        .on('order.dt search.dt', function() {
            var i = 1;

            tableJos
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