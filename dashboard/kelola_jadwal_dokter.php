<?php

require_once './services/db.php';

$dokter = getDokter();

$jadwalDokter = getJadwalDokter();

?>

<?php include './layouts/header.php'; ?>

<main id="main" class="main">

    <section class="pagetitle">
        <h1>Kelola Jadwal Dokter</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
                <li class="breadcrumb-item active">Kelola Jadwal Dokter</li>
            </ol>
        </nav>
    </section><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-body">

                        <ul class="nav nav-tabs nav-tabs-bordered" id="poli-tab" role="tablist">
                            <!-- poli gigi -->
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="poli-gigi-tab" data-bs-toggle="tab" data-bs-target="#poli-gigi" type="button" role="tab" aria-controls="home" aria-selected="true">Poli Gigi</button>
                            </li>
                            <!-- poli tht -->
                            <!-- <li class="nav-item" role="presentation">
                                <button class="nav-link" id="poli-tht-tab" data-bs-toggle="tab" data-bs-target="#poli-tht" type="button" role="tab" aria-controls="profile" aria-selected="false">Poli THT</button>
                            </li> -->
                        </ul>
                        <div class="tab-content pt-2" id="poli-tab-content">
                            <!-- poli gigi content -->
                            <div class="tab-pane fade show active" id="poli-gigi" role="tabpanel" aria-labelledby="poli-gigi-tab">
                                <h5 class="card-title">Jadwal Dokter Poli Gigi</h5>
                                <div class="row justify-content-end">
                                    <div class="col">
                                        <div class="d-flex justify-content-end">
                                            <!-- tambah jadwal dokter poli gigi modal -->
                                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambah-jadwal-dokter-poli-gigi">
                                                Tambah Jadwal Dokter
                                            </button>

                                            <div class="modal fade" id="tambah-jadwal-dokter-poli-gigi" tabindex="-1">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Tambah Jadwal Dokter Poli Gigi</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <!-- tambah jadwal dokter poli gigi form -->
                                                        <form action="/dashboard/actions/kelola_jadwal_dokter.php" method="post">
                                                            <input type="hidden" value="tambah" name="jenis">
                                                            <input type="hidden" value="Gigi" name="poli">
                                                            <div class="modal-body">
                                                                <div class="row gap-3">
                                                                    <div class="col-12">
                                                                        <label for="tanggal">Tanggal</label>
                                                                        <input id="tanggal" class="form-control" type="date" name="tanggal" required />
                                                                    </div>
                                                                    <div class="col-12">
                                                                        <label for="id_dokter_1" class="form-label">Dokter Praktek Pagi (08:00 - 10:00)</label>
                                                                        <select id="id_dokter_1" class="form-select" name="id_dokter_1">
                                                                            <option selected disabled value="0">Pilih Dokter</option>
                                                                            <?php foreach ($dokter as $d) : ?>
                                                                                <?php if ($d['poli'] !== 'Gigi') {
                                                                                    continue;
                                                                                } ?>
                                                                                <option value="<?= $d['id_dokter'] ?>"><?= $d['nama'] ?>/<?= $d['nip'] ?></option>
                                                                            <?php endforeach; ?>
                                                                        </select>
                                                                    </div>
                                                                    <div class="col-12">
                                                                        <label for="id_dokter_2" class="form-label">Dokter Praktek Siang (14:00 - 16:00)</label>
                                                                        <select id="id_dokter_2" class="form-select" name="id_dokter_2">
                                                                            <option selected disabled value="0">Pilih Dokter</option>
                                                                            <?php foreach ($dokter as $d) : ?>
                                                                                <?php if ($d['poli'] !== 'Gigi') {
                                                                                    continue;
                                                                                } ?>
                                                                                <option value="<?= $d['id_dokter'] ?>"><?= $d['nama'] ?>/<?= $d['nip'] ?></option>
                                                                            <?php endforeach; ?>
                                                                        </select>
                                                                    </div>
                                                                    <div class="col-12">
                                                                        <label for="id_dokter_3" class="form-label">Dokter Praktek Malam (19:00 - 21:00)</label>
                                                                        <select id="id_dokter_3" class="form-select" name="id_dokter_3">
                                                                            <option selected disabled value="0">Pilih Dokter</option>
                                                                            <?php foreach ($dokter as $d) : ?>
                                                                                <?php if ($d['poli'] !== 'Gigi') {
                                                                                    continue;
                                                                                } ?>
                                                                                <option value="<?= $d['id_dokter'] ?>"><?= $d['nama'] ?>/<?= $d['nip'] ?></option>
                                                                            <?php endforeach; ?>
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
                                        <!-- table jadwal dokter gigi -->
                                        <table id="jdg-table" class="table table-striped" style="width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th></th>
                                                    <th>Nama Dokter</th>
                                                    <th>NIP</th>
                                                    <th>Tanggal</th>
                                                    <th>Waktu</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($jadwalDokter as $jd) : ?>
                                                    <?php if ($jd['poli'] !== 'Gigi') continue; ?>
                                                    <tr>
                                                        <td></td>
                                                        <td><?= $jd['nama']; ?></td>
                                                        <td><?= $jd['nip']; ?></td>
                                                        <td><?= $jd['tanggal']; ?></td>
                                                        <td><?= $jd['waktu_mulai']; ?> - <?= $jd['waktu_selesai']; ?> WIB</td>
                                                        <td class="d-flex justify-content-center gap-2">
                                                            <!-- button edit -->
                                                            <div>
                                                                <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target=<?= "#edit-jd-" . $jd['id_jadwal_dokter']; ?>>
                                                                    Edit
                                                                </button>

                                                                <div class="modal fade" id=<?= "edit-jd-" . $jd['id_jadwal_dokter']; ?> tabindex="-1">
                                                                    <div class="modal-dialog modal-dialog-centered">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <h5 class="modal-title">Edit jadwal dokter</h5>
                                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                            </div>
                                                                            <form action="/dashboard/actions/kelola_dokter.php" method="post">
                                                                                <input type="hidden" name="jenis" value="edit">
                                                                                <input type="hidden" name="id_jadwal_dokter" value=<?= (string) $jd['id_jadwal_dokter'] ?>>
                                                                                <div class="modal-body">
                                                                                    <div class="alert alert-warning" role="alert">
                                                                                        Isi kolom yang hanya ingin diubah.
                                                                                    </div>

                                                                                    <div class="row gap-3">
                                                                                        <div class="col-12">
                                                                                            <label for="id_dokter" class="form-label">Dokter</label>
                                                                                            <input type="text" class="form-control" id="id_dokter" name="id_dokter" placeholder="<?= $jd['id_dokter'] ?>" autocomplete="off">
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
                                                                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target=<?= "#hapus-jd-" . $jd['id_jadwal_dokter']; ?>>
                                                                    Hapus
                                                                </button>

                                                                <div class="modal fade" id=<?= "hapus-jd-" . $jd['id_jadwal_dokter']; ?> tabindex="-1">
                                                                    <div class="modal-dialog modal-dialog-centered">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <h5 class="modal-title">Hapus jadwal dokter</h5>
                                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                            </div>
                                                                            <form action="/dashboard/actions/kelola_dokter.php" method="post">
                                                                                <input type="hidden" name="jenis" value="delete">
                                                                                <input type="hidden" name="id_jadwal_dokter" value="<?= $jd['id_jadwal_dokter'] ?>">
                                                                                <div class="modal-body">
                                                                                    <p>Apakah Anda yakin ingin menghapus <b>jadwal dokter</b> dengan nama <b><?= $jd['nama']; ?></b> dan NIP <b><?= $jd['nip']; ?></b> tanggal <b><?= $jd['tanggal'] ?></b> jam <b><?= $jd['waktu_mulai'] ?> - <?= $jd['waktu_selesai'] ?></b>?</p>
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

                            <!-- poli THT content -->

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
    // table dokter gigi
    const tableJdg = $('#jdg-table').DataTable({
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
            [3, 'desc']
        ]
    });

    tableJdg
        .on('order.dt search.dt', function() {
            var i = 1;

            tableJdg
                .cells(null, 0, {
                    search: 'applied',
                    order: 'applied'
                })
                .every(function(cell) {
                    this.data(i++);
                });
        })
        .draw();

    // table dokter gigi
    const tableJdt = $('#jdt-table').DataTable({
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
            [3, 'desc']
        ]
    });

    tableJdt
        .on('order.dt search.dt', function() {
            var i = 1;

            tableJdt
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