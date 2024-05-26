<?php

session_start();

require_once './services/db.php';
require_once './utils/utils.php';

$perawat = getPerawat();

$pegawaiSelect = getPegawaiWithNoPerawat();

?>

<?php include './layouts/header.php'; ?>

<script>
    // ubah page title
    $(document).prop('title', 'Kelola Perawat')
</script>

<main id="main" class="main">

    <section class="pagetitle">
        <h1>Kelola Perawat</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
                <li class="breadcrumb-item active">Kelola Perawat</li>
            </ol>
        </nav>
    </section><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Tabel Perawat</h5>
                        <div class="row justify-content-end">
                            <div class="col">
                                <div class="d-flex justify-content-end">
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambah-perawat">
                                        Tambah Perawat
                                    </button>

                                    <div class="modal fade" id="tambah-perawat" tabindex="-1">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Tambah perawat</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <form action="/dashboard/actions/kelola_perawat.php" method="post">
                                                    <input type="hidden" value="tambah" name="jenis">
                                                    <div class="modal-body">
                                                        <div class="row gap-3">
                                                            <div class="col-12">
                                                                <label for="no_sip" class="form-label">No. SIP</label>
                                                                <input type="text" class="form-control" id="no_sip" name="no_sip" autocomplete="off" required>
                                                            </div>
                                                            <div class="col-12">
                                                                <label for="id_pegawai" class="form-label">Pegawai</label>
                                                                <select id="id_pegawai" class="form-select" name="id_pegawai" required>
                                                                    <option selected disabled value="0">Pilih Pegawai</option>
                                                                    <?php foreach ($pegawaiSelect as $pegawai) : ?>
                                                                        <option value="<?= $pegawai['id_pegawai'] ?>"><?= $pegawai['nama'] ?>/<?= $pegawai['nip'] ?></option>
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
                                <table id="perawat-table" class="table table-striped" style="width: 100%;">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th>Nama</th>
                                            <th>NIP</th>
                                            <th>No. SIP</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($perawat as $perawat) : ?>
                                            <tr>
                                                <td></td>
                                                <td><?= $perawat['nama']; ?></td>
                                                <td><?= $perawat['nip']; ?></td>
                                                <td><?= $perawat['no_sip']; ?></td>
                                                <td class="d-flex justify-content-center gap-2">
                                                    <!-- button edit -->
                                                    <div>
                                                        <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target=<?= "#edit-perawat-" . $perawat['id_perawat']; ?>>
                                                            Edit
                                                        </button>

                                                        <div class="modal fade" id=<?= "edit-perawat-" . $perawat['id_perawat']; ?> tabindex="-1">
                                                            <div class="modal-dialog modal-dialog-centered">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title">Edit perawat</h5>
                                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                    </div>
                                                                    <form action="/dashboard/actions/kelola_perawat.php" method="post">
                                                                        <input type="hidden" name="jenis" value="edit">
                                                                        <input type="hidden" name="id_perawat" value=<?= (string) $perawat['id_perawat'] ?>>
                                                                        <div class="modal-body">
                                                                            <div class="alert alert-warning" role="alert">
                                                                                Isi kolom yang hanya ingin diubah.
                                                                            </div>

                                                                            <div class="row gap-3">
                                                                                <div class="col-12">
                                                                                    <label for="no_sip" class="form-label">No. SIP</label>
                                                                                    <input type="text" class="form-control" id="no_sip" name="no_sip" autocomplete="off">
                                                                                </div>
                                                                                <div class="col-12">
                                                                                    <label for="id_pegawai" class="form-label">Pegawai</label>
                                                                                    <select id="id_pegawai" class="form-select" name="id_pegawai">
                                                                                        <option selected disabled value="0">Pilih Pegawai</option>
                                                                                        <?php foreach ($pegawaiSelect as $pegawai) : ?>
                                                                                            <?php if ($pegawai['nip'] === $perawat['nip']) {
                                                                                                continue;
                                                                                            } ?>
                                                                                            <option value="<?= $pegawai['id_pegawai'] ?>"><?= $pegawai['nama'] ?></option>
                                                                                        <?php endforeach; ?>
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
                                                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target=<?= "#hapus-perawat-" . $perawat['id_perawat']; ?>>
                                                            Hapus
                                                        </button>

                                                        <div class="modal fade" id=<?= "hapus-perawat-" . $perawat['id_perawat']; ?> tabindex="-1">
                                                            <div class="modal-dialog modal-dialog-centered">
                                                                <div class="modal-content">

                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title">Hapus perawat</h5>
                                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                    </div>
                                                                    <form action="/dashboard/actions/kelola_perawat.php" method="post">
                                                                        <input type="hidden" name="jenis" value="delete">
                                                                        <input type="hidden" name="id_perawat" value="<?= $perawat['id_perawat'] ?>">
                                                                        <div class="modal-body">
                                                                            <p>Apakah Anda yakin ingin menghapus perawat dengan nama <b><?= $perawat['nama']; ?></b> dan NIP <b><?= $perawat['nip']; ?></b>?</p>
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
    const table = $('#perawat-table').DataTable({
        columnDefs: [{
            searchable: false,
            orderable: false,
            width: '10%',
            targets: 0
        }, {
            className: "dt-head-center dt-body-center",
            targets: ['_all']
        }, ],
    });

    table
        .on('order.dt search.dt', function() {
            var i = 1;

            table
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