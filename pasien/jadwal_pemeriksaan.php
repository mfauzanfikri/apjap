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


$jadwalPemeriksaan = getJadwalPemeriksaan();

?>

<?php include './layouts/header.php'; ?>

<script>
    // ubah page title
    $(document).prop('title', 'Jadwal Pemeriksaan')
</script>

<main id="main" class="main">

    <section class="pagetitle">
        <h1>Jadwal Pemeriksaan</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/pasien">Home</a></li>
                <li class="breadcrumb-item active">Jadwal Pemeriksaan</li>
            </ol>
        </nav>
    </section><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Tabel Jadwal Pemeriksaan</h5>
                        <div class="row justify-content-end">
                            <div class="col">
                                <div class="d-flex justify-content-end">
                                    <!-- buat jadwal pemeriksaan modal -->
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#pengajuan-operasi-modal">
                                        Buat Jadwal Pemeriksaan
                                    </button>

                                    <div class="modal fade" id="pengajuan-operasi-modal" tabindex="-1">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Buat Jadwal Pemeriksaan</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <!-- buat jadwal pemeriksaan form -->
                                                <form action="./actions/jadwal_pemeriksaan.php" method="post">
                                                    <input type="hidden" name="id_pasien" value="<?= $_SESSION['id_pasien']; ?>">
                                                    <div class="modal-body">
                                                        <div class="row gap-3">
                                                            <div class="col-12">
                                                                <label for="poli" class="form-label">Poli</label>
                                                                <select id="poli" class="form-select" name="poli" required>
                                                                    <option selected disabled value="0">Pilih Poli</option>
                                                                    <option value="Gigi">Gigi</option>
                                                                    <option value="THT">Telinga, Hidung, dan Tenggorokan</option>
                                                                    <option value="PDL">Penyakit Dalam</option>
                                                                    <option value="Anak">Anak</option>
                                                                    <option value="Saraf">Saraf</option>
                                                                    <option value="Mata">Mata</option>
                                                                </select>
                                                            </div>
                                                            <div class="col-12">
                                                                <label for="tanggal">Tanggal Pemeriksaan</label>
                                                                <input id="tanggal" class="form-control" type="date" name="tanggal" required />
                                                            </div>

                                                            <div class="col-12">
                                                                <label for="shift" class="form-label">Waktu</label>
                                                                <select id="shift" class="form-select" name="shift" required>
                                                                    <option selected disabled value="0">Pilih Waktu</option>
                                                                    <option value="pagi">08:00 WIB</option>
                                                                    <option value="siang">14:00 WIB</option>
                                                                    <option value="malam">19:00 WIB</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                                        <button type="submit" class="btn btn-primary" name="submit">Buat</button>
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

                        <?php if (isset($_SESSION['warningMsg'])) : ?>
                            <div class="mt-2">
                                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                    <?= $_SESSION['warningMsg']; ?>
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
                                <!-- table jadwal pemeriksaan -->
                                <table id="jadwal-pemeriksaan-table" class="table table-striped" style="width: 100%;">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th>Tanggal Pemeriksaan</th>
                                            <th>Waktu</th>
                                            <th>Nama Dokter</th>
                                            <th>Poli</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($jadwalPemeriksaan as $jp) : ?>
                                            <?php if ($jp['id_pasien'] !== $_SESSION['id_pasien']) continue; ?>
                                            <tr>
                                                <td></td>
                                                <td><?= $jp['tanggal']; ?></td>
                                                <td><?= $jp['waktu']; ?></td>
                                                <td><?= $jp['nama_dokter']; ?>/<?= $jp['nip_dokter']; ?></td>
                                                <td><?= $jp['poli']; ?></td>
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
    // table jadwal pemeriksaan
    const tableJp = $('#jadwal-pemeriksaan-table').DataTable({
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