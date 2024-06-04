<?php

session_start();

require_once './services/db.php';
require_once './utils/utils.php';

checkNotifikasiJadwalPerawat();

$isAuthorized = authorization([
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
    $(document).prop('title', 'Kelola Jadwal Perawat')
</script>

<main id="main" class="main">

    <section class="pagetitle">
        <h1>Kelola Jadwal Perawat</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
                <li class="breadcrumb-item active">Kelola Jadwal Perawat</li>
            </ol>
        </nav>
    </section><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-body">

                        <h5 class="card-title">Tabel Jadwal Perawat</h5>
                        <div class="row justify-content-end">
                            <div class="col">
                                <div class="d-flex justify-content-end">
                                    <!-- tambah jadwal perawat modal -->
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambah-jp">
                                        Tambah Jadwal Perawat
                                    </button>

                                    <div class="modal fade" id="tambah-jp" tabindex="-1">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Tambah Jadwal Perawat</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <!-- tambah jadwal perawat  form -->
                                                <form action="./actions/kelola_jadwal_perawat.php" method="post">
                                                    <input type="hidden" value="tambah" name="jenis">
                                                    <div class="modal-body">
                                                        <div class="row gap-3">
                                                            <div class="col-12">
                                                                <label for="tanggal">Tanggal</label>
                                                                <input id="tanggal" class="form-control" type="date" name="tanggal" required />
                                                            </div>
                                                            <div class="col-12">
                                                                <label for="id_perawat" class="form-label">Perawat</label>
                                                                <select id="id_perawat" class="form-select" name="id_perawat" required>
                                                                    <option selected disabled value="0">Pilih Perawat</option>
                                                                    <?php foreach ($perawat as $p) : ?>
                                                                        <?php if ($p['status_pegawai'] === 'cuti' || getLiburTodayByPegawaiId($p['id_pegawai']) !== false) ?>
                                                                        <option value="<?= $p['id_perawat'] ?>"><?= $p['nama'] ?>/<?= $p['nip'] ?></option>
                                                                    <?php endforeach; ?>
                                                                </select>
                                                            </div>
                                                            <div class="col-12">
                                                                <label for="shift" class="form-label">Shift</label>
                                                                <select id="shift" class="form-select" name="shift" required>
                                                                    <option selected disabled value="0">Pilih Shift</option>
                                                                    <option value="<?= ShiftPerawat::PAGI_SYMBOL ?>">Shift Pagi <?= implode(' - ', ShiftPerawat::PAGI) ?> WIB</option>
                                                                    <option value="<?= ShiftPerawat::MALAM_SYMBOL ?>">Shift malam <?= implode(' - ', ShiftPerawat::MALAM) ?> WIB</option>
                                                                </select>
                                                            </div>
                                                            <div class="col-12">
                                                                <label for="poli" class="form-label">Poli</label>
                                                                <select id="poli" class="form-select" name="poli" required>
                                                                    <option selected value="0">Pilih Poli</option>
                                                                    <option value="Gigi">Gigi</option>
                                                                    <option value="THT">THT</option>
                                                                    <option value="PDL">PDL</option>
                                                                    <option value="Saraf">Saraf</option>
                                                                    <option value="Anak">Anak</option>
                                                                    <option value="Mata">Mata</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                                        <button type="submit" class="btn btn-primary" name="submit">Tambah</button>
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
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($jadwalPerawat as $jp) : ?>
                                            <tr>
                                                <td></td>
                                                <td><?= $jp['nama']; ?></td>
                                                <td><?= $jp['nip']; ?></td>
                                                <td><?= $jp['tanggal']; ?></td>
                                                <td><?= $jp['waktu_mulai']; ?> - <?= $jp['waktu_selesai']; ?> WIB</td>
                                                <td><?= $jp['shift'] ?></td>
                                                <td><?= $jp['poli']; ?></td>
                                                <td><span class="badge text-bg-<?= getStatusColor($jp['status']); ?>"><?= $jp['status']; ?></span></td>
                                                <td class="d-flex justify-content-center gap-2 text-start">
                                                    <!-- button edit -->
                                                    <div>
                                                        <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target=<?= "#edit-jp-" . $jp['id_jadwal_perawat']; ?>>
                                                            Edit
                                                        </button>

                                                        <div class="modal fade" id=<?= "edit-jp-" . $jp['id_jadwal_perawat']; ?> tabindex="-1">
                                                            <div class="modal-dialog modal-dialog-centered">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title">Edit jadwal perawat</h5>
                                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                    </div>
                                                                    <form action="./actions/kelola_jadwal_perawat.php" method="post">
                                                                        <input type="hidden" name="jenis" value="edit">
                                                                        <input type="hidden" name="id_jadwal_perawat" value=<?= (string) $jp['id_jadwal_perawat'] ?>>
                                                                        <div class="modal-body">
                                                                            <div class="alert alert-warning" role="alert">
                                                                                Isi kolom yang hanya ingin diubah.
                                                                            </div>
                                                                            <div class="row gap-3">
                                                                                <div class="col-12">
                                                                                    <label for="tanggal" class="form-label">Tanggal</label>
                                                                                    <input id="tanggal" class="form-control" type="date" name="tanggal" />
                                                                                </div>
                                                                                <div class="col-12">
                                                                                    <label for="shift" class="form-label">Shift</label>
                                                                                    <select id="shift" class="form-select" name="shift" required>
                                                                                        <option selected disabled value="0">Pilih Shift</option>
                                                                                        <option value="<?= ShiftPerawat::PAGI_SYMBOL ?>">Shift Pagi <?= implode(' - ', ShiftPerawat::PAGI) ?> WIB</option>
                                                                                        <option value="<?= ShiftPerawat::MALAM_SYMBOL ?>">Shift malam <?= implode(' - ', ShiftPerawat::MALAM) ?> WIB</option>
                                                                                    </select>
                                                                                </div>
                                                                                <div class="col-12">
                                                                                    <label for="poli" class="form-label">Poli</label>
                                                                                    <select id="poli" class="form-select" name="poli">
                                                                                        <option selected value="0">Pilih Poli</option>
                                                                                        <option value="Gigi">Gigi</option>
                                                                                        <option value="THT">THT</option>
                                                                                        <option value="PDL">PDL</option>
                                                                                        <option value="Saraf">Saraf</option>
                                                                                        <option value="Anak">Anak</option>
                                                                                        <option value="Mata">Mata</option>
                                                                                    </select>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                                                            <button type="submit" class="btn btn-warning" name="submit">Edit</button>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- button hapus -->
                                                    <div>
                                                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target=<?= "#hapus-jp-" . $jp['id_jadwal_perawat']; ?>>
                                                            Hapus
                                                        </button>

                                                        <div class="modal fade" id=<?= "hapus-jp-" . $jp['id_jadwal_perawat']; ?> tabindex="-1">
                                                            <div class="modal-dialog modal-dialog-centered">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title">Hapus jadwal perawat</h5>
                                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                    </div>
                                                                    <form action="./actions/kelola_jadwal_perawat.php" method="post">
                                                                        <input type="hidden" name="jenis" value="delete">
                                                                        <input type="hidden" name="id_jadwal_perawat" value="<?= $jp['id_jadwal_perawat'] ?>">
                                                                        <div class="modal-body">
                                                                            <p>Apakah Anda yakin ingin menghapus <b>jadwal perawat</b> dengan nama <b><?= $jp['nama']; ?></b> dan NIP <b><?= $jp['nip']; ?></b> tanggal <b><?= $jp['tanggal'] ?></b> jam <b><?= $jp['waktu_mulai'] ?> - <?= $jp['waktu_selesai'] ?></b>?</p>
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                                                            <button type="submit" class="btn btn-danger" name="submit">Hapus</button>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
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
                            columns: [1, 2, 3, 4, 5, 6, 7]
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