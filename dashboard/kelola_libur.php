<?php

session_start();

require_once './services/db.php';
require_once './utils/utils.php';

$isAuthorized = authorization([
    'role' => Role::ADMIN
]);

if (!$isAuthorized) {
    redirect('./');
}

$libur = getLibur();

$pegawai = getPegawai();

?>

<?php include './layouts/header.php'; ?>

<script>
    // ubah page title
    $(document).prop('title', 'Kelola Libur')
</script>

<main id="main" class="main">

    <section class="pagetitle">
        <h1>Kelola Libur</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
                <li class="breadcrumb-item active">Kelola Libur</li>
            </ol>
        </nav>
    </section><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-body">

                        <h5 class="card-title">Tabel Libur</h5>
                        <div class="row justify-content-end">
                            <div class="col">
                                <div class="d-flex justify-content-end">
                                    <!-- tambah libur modal -->
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambah-libur">
                                        Tambah Libur
                                    </button>

                                    <div class="modal fade" id="tambah-libur" tabindex="-1">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Tambah Libur</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <!-- tambah libur  form -->
                                                <form action="./actions/kelola_libur.php" method="post">
                                                    <input type="hidden" value="tambah" name="jenis">
                                                    <div class="modal-body">
                                                        <div class="row gap-3">
                                                            <div class="col-12">
                                                                <label for="tanggal">Tanggal</label>
                                                                <input id="tanggal" class="form-control" type="date" name="tanggal" required />
                                                            </div>
                                                            <div class="col-12">
                                                                <label for="id_pegawai" class="form-label">Pegawai</label>
                                                                <select id="id_pegawai" class="form-select" name="id_pegawai" required>
                                                                    <option selected disabled value="0">Pilih Pegawai</option>
                                                                    <?php foreach ($pegawai as $p) : ?>
                                                                        <option value="<?= $p['id_pegawai'] ?>"><?= $p['nama'] ?>/<?= $p['nip'] ?></option>
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
                                <!-- table libur -->
                                <table id="jp-table" class="table table-striped" style="width: 100%;">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th>Nama</th>
                                            <th>NIP</th>
                                            <th>Tanggal Libur</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($libur as $l) : ?>
                                            <tr>
                                                <td></td>
                                                <td><?= $l['nama']; ?></td>
                                                <td><?= $l['nip']; ?></td>
                                                <td><?= $l['tanggal']; ?></td>
                                                <td class="d-flex justify-content-center gap-2 text-start">
                                                    <!-- button edit -->
                                                    <div>
                                                        <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target=<?= "#edit-libur-" . $l['id_libur']; ?>>
                                                            Edit
                                                        </button>

                                                        <div class="modal fade" id=<?= "edit-libur-" . $l['id_libur']; ?> tabindex="-1">
                                                            <div class="modal-dialog modal-dialog-centered">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title">Edit libur</h5>
                                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                    </div>
                                                                    <form action="./actions/kelola_libur.php" method="post">
                                                                        <input type="hidden" name="jenis" value="edit">
                                                                        <input type="hidden" name="id_libur" value=<?= (string) $l['id_libur'] ?>>
                                                                        <div class="modal-body">
                                                                            <div class="alert alert-warning" role="alert">
                                                                                Isi kolom yang hanya ingin diubah.
                                                                            </div>
                                                                            <div class="row gap-3">
                                                                                <div class="col-12">
                                                                                    <label for="tanggal">Tanggal</label>
                                                                                    <input id="tanggal" class="form-control" type="date" name="tanggal" />
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
                                                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target=<?= "#hapus-libur-" . $l['id_libur']; ?>>
                                                            Hapus
                                                        </button>

                                                        <div class="modal fade" id=<?= "hapus-libur-" . $l['id_libur']; ?> tabindex="-1">
                                                            <div class="modal-dialog modal-dialog-centered">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title">Hapus libur</h5>
                                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                    </div>
                                                                    <form action="./actions/kelola_libur.php" method="post">
                                                                        <input type="hidden" name="jenis" value="delete">
                                                                        <input type="hidden" name="id_libur" value="<?= $l['id_libur'] ?>">
                                                                        <div class="modal-body">
                                                                            <p>Apakah Anda yakin ingin menghapus <b>libur</b> dengan nama <b><?= $l['nama']; ?></b> dan NIP <b><?= $l['nip']; ?></b> tanggal <b><?= $l['tanggal'] ?>?</p>
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
    // table libur
    const tableLibur = $('#jp-table').DataTable({
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
            [3, 'desc']
        ]
    });

    tableLibur
        .on('order.dt search.dt', function() {
            var i = 1;

            tableLibur
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