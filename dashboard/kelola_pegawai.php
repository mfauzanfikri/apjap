<?php

session_start();

require_once './services/db.php';
require_once './utils/utils.php';

$pegawai = getPegawai();

$userSelect = getUsersWithNoPegawai();

?>

<?php include './layouts/header.php'; ?>

<script>
    // ubah page title
    $(document).prop('title', 'Kelola Pegawai')
</script>

<main id="main" class="main">

    <section class="pagetitle">
        <h1>Kelola Pegawai</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
                <li class="breadcrumb-item active">Kelola Pegawai</li>
            </ol>
        </nav>
    </section><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Tabel Pegawai</h5>
                        <div class="row justify-content-end">
                            <div class="col">
                                <div class="d-flex justify-content-end">
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambah-pegawai">
                                        Tambah Pegawai
                                    </button>

                                    <div class="modal fade" id="tambah-pegawai" tabindex="-1">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Tambah pegawai</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <form action="/dashboard/actions/kelola_pegawai.php" method="post">
                                                    <input type="hidden" value="tambah" name="jenis">
                                                    <div class="modal-body">
                                                        <div class="row gap-3">
                                                            <div class="col-12">
                                                                <label for="nip" class="form-label">NIP</label>
                                                                <input type="text" class="form-control" id="nip" name="nip" autocomplete="off" required>
                                                            </div>
                                                            <div class="col-12">
                                                                <label for="nama" class="form-label">Nama</label>
                                                                <input type="text" class="form-control" id="nama" name="nama" autocomplete="off" required>
                                                            </div>
                                                            <div class="col-12">
                                                                <label for="alamat" class="form-label">Alamat</label>
                                                                <input type="text" class="form-control" id="alamat" name="alamat" autocomplete="off" required>
                                                            </div>
                                                            <div class="col-12">
                                                                <label for="no_telepon" class="form-label">No. Telepon</label>
                                                                <input type="text" class="form-control" id="no_telepon" name="no_telepon" autocomplete="off" required>
                                                            </div>
                                                            <div class="col-12">
                                                                <label for="jabatan" class="form-label">Jabatan</label>
                                                                <select id="jabatan" class="form-select" name="jabatan" required>
                                                                    <option selected disabled value="0">Pilih Jabatan</option>
                                                                    <option value="kepala bidang">Kepala Bidang</option>
                                                                    <option value="kepala seksi">Kepala Seksi</option>
                                                                    <option value="staff">Staff</option>
                                                                </select>
                                                            </div>
                                                            <div class="col-12">
                                                                <label for="status_pegawai" class="form-label">Status Pegawai</label>
                                                                <select id="status_pegawai" class="form-select" name="status_pegawai" required>
                                                                    <option disabled value="0">Pilih Status Pegawai</option>
                                                                    <option selected value="aktif">Aktif</option>
                                                                    <option value="nonaktif">Nonaktif</option>
                                                                </select>
                                                            </div>
                                                            <div class="col-12">
                                                                <label for="id_user" class="form-label">User</label>
                                                                <select id="id_user" class="form-select" name="id_user" required>
                                                                    <option selected disabled value="0">Pilih User</option>
                                                                    <?php foreach ($userSelect as $user) : ?>
                                                                        <option value="<?= $user['id_user'] ?>"><?= $user['username'] ?></option>
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
                                <table id="pegawai-table" class="table table-striped" style="width: 100%;">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th>Nama</th>
                                            <th>NIP</th>
                                            <th>Username</th>
                                            <th>Jabatan</th>
                                            <th>Status</th>
                                            <th>Alamat</th>
                                            <th>No. Telepon</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($pegawai as $pegawai) : ?>
                                            <tr>
                                                <td></td>
                                                <td><?= $pegawai['nama']; ?></td>
                                                <td><?= $pegawai['nip']; ?></td>
                                                <td><?= $pegawai['username']; ?></td>
                                                <td><?= ucwords($pegawai['jabatan']); ?></td>
                                                <td><?= $pegawai['status_pegawai']; ?></td>
                                                <td><?= $pegawai['alamat']; ?></td>
                                                <td><?= $pegawai['no_telepon']; ?></td>
                                                <td class="d-flex justify-content-center gap-2">
                                                    <!-- button edit -->
                                                    <div>
                                                        <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target=<?= "#edit-pegawai-" . $pegawai['id_pegawai']; ?>>
                                                            Edit
                                                        </button>

                                                        <div class="modal fade" id=<?= "edit-pegawai-" . $pegawai['id_pegawai']; ?> tabindex="-1">
                                                            <div class="modal-dialog modal-dialog-centered">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title">Edit pegawai</h5>
                                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                    </div>
                                                                    <form action="/dashboard/actions/kelola_pegawai.php" method="post">
                                                                        <input type="hidden" name="jenis" value="edit">
                                                                        <input type="hidden" name="id_pegawai" value=<?= (string) $pegawai['id_pegawai'] ?>>
                                                                        <div class="modal-body">
                                                                            <div class="alert alert-warning" role="alert">
                                                                                Isi kolom yang hanya ingin diubah.
                                                                            </div>

                                                                            <div class="row gap-3">
                                                                                <div class="col-12">
                                                                                    <label for="nip" class="form-label">NIP</label>
                                                                                    <input type="text" class="form-control" id="nip" name="nip" placeholder="<?= $pegawai['nip'] ?>" autocomplete="off">
                                                                                </div>
                                                                                <div class="col-12">
                                                                                    <label for="nama" class="form-label">Nama</label>
                                                                                    <input type="text" class="form-control" id="nama" name="nama" placeholder="<?= $pegawai['nama'] ?>" autocomplete="off">
                                                                                </div>
                                                                                <div class="col-12">
                                                                                    <label for="alamat" class="form-label">Alamat</label>
                                                                                    <input type="text" class="form-control" id="alamat" name="alamat" placeholder="<?= $pegawai['alamat'] ?>" autocomplete="off">
                                                                                </div>
                                                                                <div class="col-12">
                                                                                    <label for="no_telepon" class="form-label">No. Telepon</label>
                                                                                    <input type="text" class="form-control" id="no_telepon" name="no_telepon" placeholder="<?= $pegawai['no_telepon'] ?>" autocomplete="off">
                                                                                </div>
                                                                                <div class="col-12">
                                                                                    <label for="jabatan" class="form-label">Jabatan</label>
                                                                                    <select id="jabatan" class="form-select" name="jabatan">
                                                                                        <option selected disabled value="0">Pilih Jabatan</option>
                                                                                        <option value="kepala bidang">Kepala Bidang</option>
                                                                                        <option value="kepala seksi">Kepala Seksi</option>
                                                                                        <option value="staff">Staff</option>
                                                                                    </select>
                                                                                </div>
                                                                                <div class="col-12">
                                                                                    <label for="status_pegawai" class="form-label">Status Pegawai</label>
                                                                                    <select id="status_pegawai" class="form-select" name="status_pegawai">
                                                                                        <option selected disabled value="0">Pilih Status Pegawai</option>
                                                                                        <option value="aktif">Aktif</option>
                                                                                        <option value="nonaktif">Nonaktif</option>
                                                                                    </select>
                                                                                </div>
                                                                                <div class="col-12">
                                                                                    <label for="id_user" class="form-label">User</label>
                                                                                    <select id="id_user" class="form-select" name="id_user">
                                                                                        <option selected disabled value="0">Pilih User</option>
                                                                                        <?php foreach ($userSelect as $user) : ?>
                                                                                            <?php if ($user['username'] === $pegawai['username']) {
                                                                                                continue;
                                                                                            } ?>
                                                                                            <option value="<?= $user['id_user'] ?>"><?= $user['username'] ?></option>
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
                                                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target=<?= "#hapus-pegawai-" . $pegawai['id_pegawai']; ?>>
                                                            Hapus
                                                        </button>

                                                        <div class="modal fade" id=<?= "hapus-pegawai-" . $pegawai['id_pegawai']; ?> tabindex="-1">
                                                            <div class="modal-dialog modal-dialog-centered">
                                                                <div class="modal-content">

                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title">Hapus pegawai</h5>
                                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                    </div>
                                                                    <form action="/dashboard/actions/kelola_pegawai.php" method="post">
                                                                        <input type="hidden" name="jenis" value="delete">
                                                                        <input type="hidden" name="id_pegawai" value="<?= $pegawai['id_pegawai'] ?>">
                                                                        <div class="modal-body">
                                                                            <p>Apakah Anda yakin ingin menghapus pegawai dengan nama <b><?= $pegawai['nama']; ?></b> dan NIP <b><?= $pegawai['nip'] ?></b>?</p>
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
    const table = $('#pegawai-table').DataTable({
        columnDefs: [{
            searchable: false,
            orderable: false,
            width: '10%',
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
                    },
                ]
            }
        }
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