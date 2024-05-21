<?php

require_once './services/db.php';

$dokter = getDokter();

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
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="poli-tht-tab" data-bs-toggle="tab" data-bs-target="#poli-tht" type="button" role="tab" aria-controls="profile" aria-selected="false">Poli THT</button>
                            </li>
                        </ul>
                        <div class="tab-content pt-2" id="poli-tab-content">
                            <!-- poli gigi -->
                            <div class="tab-pane fade show active" id="poli-gigi" role="tabpanel" aria-labelledby="poli-gigi-tab">
                                <h5 class="card-title">Jadwal Dokter Poli Gigi</h5>
                                <div class="row justify-content-end">
                                    <div class="col">
                                        <div class="d-flex justify-content-end">
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
                                                        <form action="/dashboard/actions/kelola_jadwal_dokter.php" method="post">
                                                            <input type="hidden" value="tambah" name="jenis">
                                                            <input type="hidden" value="Gigi" name="poli">
                                                            <div class="modal-body">
                                                                <div class="row gap-3">
                                                                    <div class="col-12">
                                                                        <label for="tanggal">Tanggal</label>
                                                                        <input id="tanggal" class="form-control" type="date" name="tanggal" />
                                                                    </div>
                                                                    <div class="col-12">
                                                                        <label for="id_pegawai_1" class="form-label">Dokter Praktek Pagi (08:00 - 10:00)</label>
                                                                        <select id="id_pegawai_1" class="form-select" name="id_pegawai_1">
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
                                                                        <label for="id_pegawai_2" class="form-label">Dokter Praktek Siang (14:00 - 16:00)</label>
                                                                        <select id="id_pegawai_2" class="form-select" name="id_pegawai_2">
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
                                                                        <label for="id_pegawai_3" class="form-label">Dokter Praktek Malam (19:00 - 21:00)</label>
                                                                        <select id="id_pegawai_3" class="form-select" name="id_pegawai_3">
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
                                        <table></table>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="poli-tht" role="tabpanel" aria-labelledby="poli-tht-tab">
                                <h5 class="card-title">Jadwal Dokter Poli THT</h5>
                                <div class="row justify-content-end">
                                    <div class="col">
                                        <div class="d-flex justify-content-end">
                                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambah-jadwal-dokter-poli-tht">
                                                Tambah Jadwal Dokter
                                            </button>

                                            <div class="modal fade" id="tambah-jadwal-dokter-poli-tht" tabindex="-1">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Tambah Jadwal Dokter Poli THT</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <form action="/dashboard/actions/kelola_jadwal_dokter.php" method="post">
                                                            <input type="hidden" value="tambah" name="jenis">
                                                            <input type="hidden" value="THT" name="poli">
                                                            <div class="modal-body">
                                                                <div class="row gap-3">
                                                                    <div class="col-12">
                                                                        <label for="tanggal">Tanggal</label>
                                                                        <input id="tanggal" class="form-control" type="date" name="tanggal" />
                                                                    </div>
                                                                    <div class="col-12">
                                                                        <label for="id_pegawai_1" class="form-label">Dokter Praktek Pagi (08:00 - 10:00)</label>
                                                                        <select id="id_pegawai_1" class="form-select" name="id_pegawai_1">
                                                                            <option selected disabled value="0">Pilih Dokter</option>
                                                                            <?php foreach ($dokter as $d) : ?>
                                                                                <?php if ($d['poli'] !== 'THT') {
                                                                                    continue;
                                                                                } ?>
                                                                                <option value="<?= $d['id_dokter'] ?>"><?= $d['nama'] ?>/<?= $d['nip'] ?></option>
                                                                            <?php endforeach; ?>
                                                                        </select>
                                                                    </div>
                                                                    <div class="col-12">
                                                                        <label for="id_pegawai_2" class="form-label">Dokter Praktek Siang (14:00 - 16:00)</label>
                                                                        <select id="id_pegawai_2" class="form-select" name="id_pegawai_2">
                                                                            <option selected disabled value="0">Pilih Dokter</option>
                                                                            <?php foreach ($dokter as $d) : ?>
                                                                                <?php if ($d['poli'] !== 'THT') {
                                                                                    continue;
                                                                                } ?>
                                                                                <option value="<?= $d['id_dokter'] ?>"><?= $d['nama'] ?>/<?= $d['nip'] ?></option>
                                                                            <?php endforeach; ?>
                                                                        </select>
                                                                    </div>
                                                                    <div class="col-12">
                                                                        <label for="id_pegawai_3" class="form-label">Dokter Praktek Malam (19:00 - 21:00)</label>
                                                                        <select id="id_pegawai_3" class="form-select" name="id_pegawai_3">
                                                                            <option selected disabled value="0">Pilih Dokter</option>
                                                                            <?php foreach ($dokter as $d) : ?>
                                                                                <?php if ($d['poli'] !== 'THT') {
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
                                        <table></table>
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
    // const table = $('#jadwal-dokter-table').DataTable({
    //     columnDefs: [{
    //         searchable: false,
    //         orderable: false,
    //         width: '10%',
    //         targets: 0
    //     }, {
    //         className: "dt-head-center",
    //         targets: [2]
    //     }, ],
    // });

    // table
    //     .on('order.dt search.dt', function() {
    //         var i = 1;

    //         table
    //             .cells(null, 0, {
    //                 search: 'applied',
    //                 order: 'applied'
    //             })
    //             .every(function(cell) {
    //                 this.data(i++);
    //             });
    //     })
    //     .draw();
</script>

<?php include './layouts/footer.php'; ?>