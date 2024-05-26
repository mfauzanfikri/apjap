<?php

session_start();

require_once './services/db.php';
require_once './utils/utils.php';

$cuti = getCuti();

$pegawai = getPegawai();

?>

<?php include './layouts/header.php'; ?>

<script>
    // ubah page title
    $(document).prop('title', 'Kelola Cuti')
</script>

<main id="main" class="main">

    <section class="pagetitle">
        <h1>Kelola Cuti</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
                <li class="breadcrumb-item active">Kelola Cuti</li>
            </ol>
        </nav>
    </section><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-body">

                        <h5 class="card-title">Tabel Cuti</h5>
                        <div class="row justify-content-end">
                            <div class="col">
                                <div class="d-flex justify-content-end">
                                    <!-- tambah cuti modal -->
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambah-cuti">
                                        Tambah Cuti
                                    </button>

                                    <div class="modal fade" id="tambah-cuti" tabindex="-1">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Tambah Cuti</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <!-- tambah cuti  form -->
                                                <form action="/dashboard/actions/kelola_cuti.php" method="post">
                                                    <input type="hidden" value="tambah" name="jenis">
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
                                <!-- table cuti -->
                                <table id="jp-table" class="table table-striped" style="width: 100%;">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th>Nama</th>
                                            <th>NIP</th>
                                            <th>Tanggal Cuti</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($cuti as $c) : ?>
                                            <tr>
                                                <td></td>
                                                <td><?= $c['nama']; ?></td>
                                                <td><?= $c['nip']; ?></td>
                                                <td><?= $c['tanggal_mulai']; ?> - <?= $c['tanggal_selesai']; ?></td>
                                                <td class="text-center"><span class="badge text-bg-<?= getStatusColor($c['status']); ?>"><?= $c['status'] ?></span></td>
                                                <td class="d-flex justify-content-center">
                                                    <!-- button hapus -->
                                                    <div>
                                                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target=<?= "#hapus-cuti-" . $c['id_cuti']; ?>>
                                                            Hapus
                                                        </button>

                                                        <div class="modal fade" id=<?= "hapus-cuti-" . $c['id_cuti']; ?> tabindex="-1">
                                                            <div class="modal-dialog modal-dialog-centered">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title">Hapus cuti</h5>
                                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                    </div>
                                                                    <form action="/dashboard/actions/kelola_cuti.php" method="post">
                                                                        <input type="hidden" name="jenis" value="delete">
                                                                        <input type="hidden" name="id_cuti" value="<?= $c['id_cuti'] ?>">
                                                                        <div class="modal-body">
                                                                            <p>Apakah Anda yakin ingin menghapus <b>cuti</b> dengan nama <b><?= $c['nama']; ?></b> dan NIP <b><?= $c['nip']; ?></b> tanggal <b><?= $c['tanggal'] ?></b> jam <b><?= $c['waktu_mulai'] ?> - <?= $c['waktu_selesai'] ?></b>?</p>
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
    // table cuti
    const tableCuti = $('#jp-table').DataTable({
        columnDefs: [{
            searchable: false,
            orderable: false,
            width: '1%',
            targets: 0
        }, {
            className: "dt-head-center",
            targets: [4, 5]
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

    tableCuti
        .on('order.dt search.dt', function() {
            var i = 1;

            tableCuti
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