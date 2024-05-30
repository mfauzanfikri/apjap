<?php

session_start();

require_once './services/db.php';
require_once './utils/utils.php';

$isAuthorized = authorization([
    'role' => Role::ADMIN
]);

if (!$isAuthorized) {
    redirect('/dashboard');
}

$dokter = getDokter();

$jadwalDokter = getJadwalDokter();

?>

<?php include './layouts/header.php'; ?>

<script>
    // ubah page title
    $(document).prop('title', 'Kelola Jadwal Dokter')
</script>

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
                            </li>
                            <!-- poli pdl -->
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="poli-pdl-tab" data-bs-toggle="tab" data-bs-target="#poli-pdl" type="button" role="tab" aria-controls="profile" aria-selected="false">Poli PDL</button>
                            </li>
                            </li>
                            <!-- poli anak -->
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="poli-anak-tab" data-bs-toggle="tab" data-bs-target="#poli-anak" type="button" role="tab" aria-controls="profile" aria-selected="false">Poli Anak</button>
                            </li>
                            </li>
                            <!-- poli saraf -->
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="poli-saraf-tab" data-bs-toggle="tab" data-bs-target="#poli-saraf" type="button" role="tab" aria-controls="profile" aria-selected="false">Poli Saraf</button>
                            </li>
                            </li>
                            <!-- poli mata -->
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="poli-mata-tab" data-bs-toggle="tab" data-bs-target="#poli-mata" type="button" role="tab" aria-controls="profile" aria-selected="false">Poli Mata</button>
                            </li>
                        </ul>
                        <div class="tab-content pt-2" id="poli-tab-content">
                            <!-- poli gigi content -->
                            <div class="tab-pane fade show active" id="poli-gigi" role="tabpanel" aria-labelledby="poli-gigi-tab">
                                <h5 class="card-title">Jadwal Dokter Poli Gigi</h5>
                                <div class="row justify-content-end">
                                    <div class="col">
                                        <div class="d-flex justify-content-end">
                                            <!-- tambah jadwal dokter poli gigi modal -->
                                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambah-jdg">
                                                Tambah Jadwal Dokter
                                            </button>

                                            <div class="modal fade" id="tambah-jdg" tabindex="-1">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Tambah Jadwal Dokter Poli Gigi</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <!-- tambah jadwal dokter poli gigi form -->
                                                        <form action="./actions/kelola_jadwal_dokter.php" method="post">
                                                            <input type="hidden" value="tambah" name="jenis">
                                                            <div class="modal-body">
                                                                <div class="alert alert-warning" role="alert">
                                                                    Kolom jadwal praktek dokter harus diisi minimal satu.
                                                                </div>

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
                                                                                <?php if ($d['poli'] !== 'Gigi' || $d['status_pegawai'] === 'cuti' || getLiburTodayByPegawaiId($d['id_pegawai']) !== false) {
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
                                                                                <?php if ($d['poli'] !== 'Gigi' || $d['status_pegawai'] === 'cuti' || getLiburTodayByPegawaiId($d['id_pegawai']) !== false) {
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
                                                                                <?php if ($d['poli'] !== 'Gigi' || $d['status_pegawai'] === 'cuti' || getLiburTodayByPegawaiId($d['id_pegawai']) !== false) {
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
                                                        <td class="d-flex justify-content-center gap-2 text-start">
                                                            <!-- button edit -->
                                                            <div>
                                                                <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target=<?= "#edit-jdg-" . $jd['id_jadwal_dokter']; ?>>
                                                                    Edit
                                                                </button>

                                                                <div class="modal fade" id=<?= "edit-jdg-" . $jd['id_jadwal_dokter']; ?> tabindex="-1">
                                                                    <div class="modal-dialog modal-dialog-centered">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <h5 class="modal-title">Edit jadwal dokter</h5>
                                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                            </div>
                                                                            <form action="./actions/kelola_jadwal_dokter.php" method="post">
                                                                                <input type="hidden" name="jenis" value="edit">
                                                                                <input type="hidden" name="id_jadwal_dokter" value=<?= (string) $jd['id_jadwal_dokter'] ?>>
                                                                                <div class="modal-body">
                                                                                    <div class="alert alert-warning" role="alert">
                                                                                        Isi kolom yang hanya ingin diubah.
                                                                                    </div>

                                                                                    <div class="row gap-3">
                                                                                        <div class="col">
                                                                                            <label for="tanggal" class="form-label">Tanggal</label>
                                                                                            <input type="date" class="form-control" name="tanggal" id="tanggal">
                                                                                        </div>
                                                                                        <div class="col-12">
                                                                                            <label for="id_dokter" class="form-label">Dokter praktek</label>
                                                                                            <select id="id_dokter" class="form-select" name="id_dokter">
                                                                                                <option selected value="0">Pilih Dokter</option>
                                                                                                <?php foreach ($dokter as $d) : ?>
                                                                                                    <?php if ($d['nip'] === $jd['nip']) continue; ?>
                                                                                                    <?php if ($d['poli'] !== 'Gigi') {
                                                                                                        continue;
                                                                                                    } ?>
                                                                                                    <option value="<?= $d['id_dokter'] ?>"><?= $d['nama'] ?>/<?= $d['nip'] ?></option>
                                                                                                <?php endforeach; ?>
                                                                                            </select>
                                                                                        </div>
                                                                                        <div class="col-12">
                                                                                            <label for="waktu" class="form-label">Waktu</label>
                                                                                            <select id="waktu" class="form-select" name="waktu">
                                                                                                <option selected value="0">Pilih Waktu</option>
                                                                                                <option value="pagi">Pagi 08:00 - 16:00 WIB</option>
                                                                                                <option value="siang">Siang 14:00:00 - 16:00:00 WIB</option>
                                                                                                <option value="malam">Malam 19:00:00 - 21:00:00 WIB</option>
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
                                                                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target=<?= "#hapus-jdg-" . $jd['id_jadwal_dokter']; ?>>
                                                                    Hapus
                                                                </button>

                                                                <div class="modal fade" id=<?= "hapus-jdg-" . $jd['id_jadwal_dokter']; ?> tabindex="-1">
                                                                    <div class="modal-dialog modal-dialog-centered">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <h5 class="modal-title">Hapus jadwal dokter</h5>
                                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                            </div>
                                                                            <form action="./actions/kelola_jadwal_dokter.php" method="post">
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

                            <!-- poli tht content -->
                            <div class="tab-pane fade" id="poli-tht" role="tabpanel" aria-labelledby="poli-tht-tab">
                                <h5 class="card-title">Jadwal Dokter Poli THT</h5>
                                <div class="row justify-content-end">
                                    <div class="col">
                                        <div class="d-flex justify-content-end">
                                            <!-- tambah jadwal dokter poli tht modal -->
                                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambah-jdt">
                                                Tambah Jadwal Dokter
                                            </button>

                                            <div class="modal fade" id="tambah-jdt" tabindex="-1">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Tambah Jadwal Dokter Poli THT</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <!-- tambah jadwal dokter poli tht form -->
                                                        <form action="./actions/kelola_jadwal_dokter.php" method="post">
                                                            <input type="hidden" value="tambah" name="jenis">
                                                            <div class="modal-body">
                                                                <div class="alert alert-warning" role="alert">
                                                                    Kolom jadwal praktek dokter harus diisi minimal satu.
                                                                </div>

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
                                                                                <?php if ($d['poli'] !== 'THT' || $d['status_pegawai'] === 'cuti' || getLiburTodayByPegawaiId($d['id_pegawai']) !== false) {
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
                                                                                <?php if ($d['poli'] !== 'THT' || $d['status_pegawai'] === 'cuti' || getLiburTodayByPegawaiId($d['id_pegawai']) !== false) {
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
                                                                                <?php if ($d['poli'] !== 'THT' || $d['status_pegawai'] === 'cuti' || getLiburTodayByPegawaiId($d['id_pegawai']) !== false) {
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
                                        <!-- table jadwal dokter tht -->
                                        <table id="jdt-table" class="table table-striped" style="width: 100%;">
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
                                                    <?php if ($jd['poli'] !== 'THT') continue; ?>
                                                    <tr>
                                                        <td></td>
                                                        <td><?= $jd['nama']; ?></td>
                                                        <td><?= $jd['nip']; ?></td>
                                                        <td><?= $jd['tanggal']; ?></td>
                                                        <td><?= $jd['waktu_mulai']; ?> - <?= $jd['waktu_selesai']; ?> WIB</td>
                                                        <td class="d-flex justify-content-center gap-2 text-start">
                                                            <!-- button edit -->
                                                            <div>
                                                                <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target=<?= "#edit-jdt-" . $jd['id_jadwal_dokter']; ?>>
                                                                    Edit
                                                                </button>

                                                                <div class="modal fade" id=<?= "edit-jdt-" . $jd['id_jadwal_dokter']; ?> tabindex="-1">
                                                                    <div class="modal-dialog modal-dialog-centered">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <h5 class="modal-title">Edit jadwal dokter</h5>
                                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                            </div>
                                                                            <form action="./actions/kelola_jadwal_dokter.php" method="post">
                                                                                <input type="hidden" name="jenis" value="edit">
                                                                                <input type="hidden" name="id_jadwal_dokter" value=<?= (string) $jd['id_jadwal_dokter'] ?>>
                                                                                <div class="modal-body">
                                                                                    <div class="alert alert-warning" role="alert">
                                                                                        Isi kolom yang hanya ingin diubah.
                                                                                    </div>

                                                                                    <div class="row gap-3">
                                                                                        <div class="col">
                                                                                            <label for="tanggal" class="form-label">Tanggal</label>
                                                                                            <input type="date" class="form-control" name="tanggal" id="tanggal">
                                                                                        </div>
                                                                                        <div class="col-12">
                                                                                            <label for="id_dokter" class="form-label">Dokter praktek</label>
                                                                                            <select id="id_dokter" class="form-select" name="id_dokter">
                                                                                                <option selected value="0">Pilih Dokter</option>
                                                                                                <?php foreach ($dokter as $d) : ?>
                                                                                                    <?php if ($d['nip'] === $jd['nip']) continue; ?>
                                                                                                    <?php if ($d['poli'] !== 'THT') {
                                                                                                        continue;
                                                                                                    } ?>
                                                                                                    <option value="<?= $d['id_dokter'] ?>"><?= $d['nama'] ?>/<?= $d['nip'] ?></option>
                                                                                                <?php endforeach; ?>
                                                                                            </select>
                                                                                        </div>
                                                                                        <div class="col-12">
                                                                                            <label for="waktu" class="form-label">Waktu</label>
                                                                                            <select id="waktu" class="form-select" name="waktu">
                                                                                                <option selected value="0">Pilih Waktu</option>
                                                                                                <option value="pagi">Pagi 08:00 - 16:00 WIB</option>
                                                                                                <option value="siang">Siang 14:00:00 - 16:00:00 WIB</option>
                                                                                                <option value="malam">Malam 19:00:00 - 21:00:00 WIB</option>
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
                                                                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target=<?= "#hapus-jdt-" . $jd['id_jadwal_dokter']; ?>>
                                                                    Hapus
                                                                </button>

                                                                <div class="modal fade" id=<?= "hapus-jdt-" . $jd['id_jadwal_dokter']; ?> tabindex="-1">
                                                                    <div class="modal-dialog modal-dialog-centered">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <h5 class="modal-title">Hapus jadwal dokter</h5>
                                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                            </div>
                                                                            <form action="./actions/kelola_jadwal_dokter.php" method="post">
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

                            <!-- poli pdl content -->
                            <div class="tab-pane fade" id="poli-pdl" role="tabpanel" aria-labelledby="poli-pdl-tab">
                                <h5 class="card-title">Jadwal Dokter Poli PDL</h5>
                                <div class="row justify-content-end">
                                    <div class="col">
                                        <div class="d-flex justify-content-end">
                                            <!-- tambah jadwal dokter poli pdl modal -->
                                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambah-jdp">
                                                Tambah Jadwal Dokter
                                            </button>

                                            <div class="modal fade" id="tambah-jdp" tabindex="-1">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Tambah Jadwal Dokter Poli PDL</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <!-- tambah jadwal dokter poli pdl form -->
                                                        <form action="./actions/kelola_jadwal_dokter.php" method="post">
                                                            <input type="hidden" value="tambah" name="jenis">
                                                            <div class="modal-body">
                                                                <div class="alert alert-warning" role="alert">
                                                                    Kolom jadwal praktek dokter harus diisi minimal satu.
                                                                </div>

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
                                                                                <?php if ($d['poli'] !== 'PDL' || $d['status_pegawai'] === 'cuti' || getLiburTodayByPegawaiId($d['id_pegawai']) !== false) {
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
                                                                                <?php if ($d['poli'] !== 'PDL' || $d['status_pegawai'] === 'cuti' || getLiburTodayByPegawaiId($d['id_pegawai']) !== false) {
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
                                                                                <?php if ($d['poli'] !== 'PDL' || $d['status_pegawai'] === 'cuti' || getLiburTodayByPegawaiId($d['id_pegawai']) !== false) {
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
                                        <!-- table jadwal dokter pdl -->
                                        <table id="jdp-table" class="table table-striped" style="width: 100%;">
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
                                                    <?php if ($jd['poli'] !== 'PDL') continue; ?>
                                                    <tr>
                                                        <td></td>
                                                        <td><?= $jd['nama']; ?></td>
                                                        <td><?= $jd['nip']; ?></td>
                                                        <td><?= $jd['tanggal']; ?></td>
                                                        <td><?= $jd['waktu_mulai']; ?> - <?= $jd['waktu_selesai']; ?> WIB</td>
                                                        <td class="d-flex justify-content-center gap-2 text-start">
                                                            <!-- button edit -->
                                                            <div>
                                                                <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target=<?= "#edit-jdp-" . $jd['id_jadwal_dokter']; ?>>
                                                                    Edit
                                                                </button>

                                                                <div class="modal fade" id=<?= "edit-jdp-" . $jd['id_jadwal_dokter']; ?> tabindex="-1">
                                                                    <div class="modal-dialog modal-dialog-centered">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <h5 class="modal-title">Edit jadwal dokter</h5>
                                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                            </div>
                                                                            <form action="./actions/kelola_jadwal_dokter.php" method="post">
                                                                                <input type="hidden" name="jenis" value="edit">
                                                                                <input type="hidden" name="id_jadwal_dokter" value=<?= (string) $jd['id_jadwal_dokter'] ?>>
                                                                                <div class="modal-body">
                                                                                    <div class="alert alert-warning" role="alert">
                                                                                        Isi kolom yang hanya ingin diubah.
                                                                                    </div>

                                                                                    <div class="row gap-3">
                                                                                        <div class="col">
                                                                                            <label for="tanggal" class="form-label">Tanggal</label>
                                                                                            <input type="date" class="form-control" name="tanggal" id="tanggal">
                                                                                        </div>
                                                                                        <div class="col-12">
                                                                                            <label for="id_dokter" class="form-label">Dokter praktek</label>
                                                                                            <select id="id_dokter" class="form-select" name="id_dokter">
                                                                                                <option selected value="0">Pilih Dokter</option>
                                                                                                <?php foreach ($dokter as $d) : ?>
                                                                                                    <?php if ($d['nip'] === $jd['nip']) continue; ?>
                                                                                                    <?php if ($d['poli'] !== 'PDL') {
                                                                                                        continue;
                                                                                                    } ?>
                                                                                                    <option value="<?= $d['id_dokter'] ?>"><?= $d['nama'] ?>/<?= $d['nip'] ?></option>
                                                                                                <?php endforeach; ?>
                                                                                            </select>
                                                                                        </div>
                                                                                        <div class="col-12">
                                                                                            <label for="waktu" class="form-label">Waktu</label>
                                                                                            <select id="waktu" class="form-select" name="waktu">
                                                                                                <option selected value="0">Pilih Waktu</option>
                                                                                                <option value="pagi">Pagi 08:00 - 16:00 WIB</option>
                                                                                                <option value="siang">Siang 14:00:00 - 16:00:00 WIB</option>
                                                                                                <option value="malam">Malam 19:00:00 - 21:00:00 WIB</option>
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
                                                                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target=<?= "#hapus-jdp-" . $jd['id_jadwal_dokter']; ?>>
                                                                    Hapus
                                                                </button>

                                                                <div class="modal fade" id=<?= "hapus-jdp-" . $jd['id_jadwal_dokter']; ?> tabindex="-1">
                                                                    <div class="modal-dialog modal-dialog-centered">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <h5 class="modal-title">Hapus jadwal dokter</h5>
                                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                            </div>
                                                                            <form action="./actions/kelola_jadwal_dokter.php" method="post">
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

                            <!-- poli anak content  -->
                            <div class="tab-pane fade" id="poli-anak" role="tabpanel" aria-labelledby="poli-anak-tab">
                                <h5 class="card-title">Jadwal Dokter Poli Anak</h5>
                                <div class="row justify-content-end">
                                    <div class="col">
                                        <div class="d-flex justify-content-end">
                                            <!-- tambah jadwal dokter poli anak modal -->
                                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambah-jda">
                                                Tambah Jadwal Dokter
                                            </button>

                                            <div class="modal fade" id="tambah-jda" tabindex="-1">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Tambah Jadwal Dokter Poli Anak</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <!-- tambah jadwal dokter poli anak form -->
                                                        <form action="./actions/kelola_jadwal_dokter.php" method="post">
                                                            <input type="hidden" value="tambah" name="jenis">
                                                            <div class="modal-body">
                                                                <div class="alert alert-warning" role="alert">
                                                                    Kolom jadwal praktek dokter harus diisi minimal satu.
                                                                </div>

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
                                                                                <?php if ($d['poli'] !== 'Anak' || $d['status_pegawai'] === 'cuti' || getLiburTodayByPegawaiId($d['id_pegawai']) !== false) {
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
                                                                                <?php if ($d['poli'] !== 'Anak' || $d['status_pegawai'] === 'cuti' || getLiburTodayByPegawaiId($d['id_pegawai']) !== false) {
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
                                                                                <?php if ($d['poli'] !== 'Anak' || $d['status_pegawai'] === 'cuti' || getLiburTodayByPegawaiId($d['id_pegawai']) !== false) {
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
                                        <!-- table jadwal dokter anak -->
                                        <table id="jda-table" class="table table-striped" style="width: 100%;">
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
                                                    <?php if ($jd['poli'] !== 'Anak') continue; ?>
                                                    <tr>
                                                        <td></td>
                                                        <td><?= $jd['nama']; ?></td>
                                                        <td><?= $jd['nip']; ?></td>
                                                        <td><?= $jd['tanggal']; ?></td>
                                                        <td><?= $jd['waktu_mulai']; ?> - <?= $jd['waktu_selesai']; ?> WIB</td>
                                                        <td class="d-flex justify-content-center gap-2 text-start">
                                                            <!-- button edit -->
                                                            <div>
                                                                <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target=<?= "#edit-jda-" . $jd['id_jadwal_dokter']; ?>>
                                                                    Edit
                                                                </button>

                                                                <div class="modal fade" id=<?= "edit-jda-" . $jd['id_jadwal_dokter']; ?> tabindex="-1">
                                                                    <div class="modal-dialog modal-dialog-centered">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <h5 class="modal-title">Edit jadwal dokter</h5>
                                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                            </div>
                                                                            <form action="./actions/kelola_jadwal_dokter.php" method="post">
                                                                                <input type="hidden" name="jenis" value="edit">
                                                                                <input type="hidden" name="id_jadwal_dokter" value=<?= (string) $jd['id_jadwal_dokter'] ?>>
                                                                                <div class="modal-body">
                                                                                    <div class="alert alert-warning" role="alert">
                                                                                        Isi kolom yang hanya ingin diubah.
                                                                                    </div>

                                                                                    <div class="row gap-3">
                                                                                        <div class="col">
                                                                                            <label for="tanggal" class="form-label">Tanggal</label>
                                                                                            <input type="date" class="form-control" name="tanggal" id="tanggal">
                                                                                        </div>
                                                                                        <div class="col-12">
                                                                                            <label for="id_dokter" class="form-label">Dokter praktek</label>
                                                                                            <select id="id_dokter" class="form-select" name="id_dokter">
                                                                                                <option selected value="0">Pilih Dokter</option>
                                                                                                <?php foreach ($dokter as $d) : ?>
                                                                                                    <?php if ($d['nip'] === $jd['nip']) continue; ?>
                                                                                                    <?php if ($d['poli'] !== 'Anak') {
                                                                                                        continue;
                                                                                                    } ?>
                                                                                                    <option value="<?= $d['id_dokter'] ?>"><?= $d['nama'] ?>/<?= $d['nip'] ?></option>
                                                                                                <?php endforeach; ?>
                                                                                            </select>
                                                                                        </div>
                                                                                        <div class="col-12">
                                                                                            <label for="waktu" class="form-label">Waktu</label>
                                                                                            <select id="waktu" class="form-select" name="waktu">
                                                                                                <option selected value="0">Pilih Waktu</option>
                                                                                                <option value="pagi">Pagi 08:00 - 16:00 WIB</option>
                                                                                                <option value="siang">Siang 14:00:00 - 16:00:00 WIB</option>
                                                                                                <option value="malam">Malam 19:00:00 - 21:00:00 WIB</option>
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
                                                                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target=<?= "#hapus-jda-" . $jd['id_jadwal_dokter']; ?>>
                                                                    Hapus
                                                                </button>

                                                                <div class="modal fade" id=<?= "hapus-jda-" . $jd['id_jadwal_dokter']; ?> tabindex="-1">
                                                                    <div class="modal-dialog modal-dialog-centered">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <h5 class="modal-title">Hapus jadwal dokter</h5>
                                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                            </div>
                                                                            <form action="./actions/kelola_jadwal_dokter.php" method="post">
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

                            <!-- poli saraf content -->
                            <div class="tab-pane fade" id="poli-saraf" role="tabpanel" aria-labelledby="poli-saraf-tab">
                                <h5 class="card-title">Jadwal Dokter Poli Saraf</h5>
                                <div class="row justify-content-end">
                                    <div class="col">
                                        <div class="d-flex justify-content-end">
                                            <!-- tambah jadwal dokter poli saraf modal -->
                                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambah-jds">
                                                Tambah Jadwal Dokter
                                            </button>

                                            <div class="modal fade" id="tambah-jds" tabindex="-1">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Tambah Jadwal Dokter Poli Saraf</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <!-- tambah jadwal dokter poli saraf form -->
                                                        <form action="./actions/kelola_jadwal_dokter.php" method="post">
                                                            <input type="hidden" value="tambah" name="jenis">
                                                            <div class="modal-body">
                                                                <div class="alert alert-warning" role="alert">
                                                                    Kolom jadwal praktek dokter harus diisi minimal satu.
                                                                </div>

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
                                                                                <?php if ($d['poli'] !== 'Saraf') {
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
                                                                                <?php if ($d['poli'] !== 'Saraf') {
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
                                                                                <?php if ($d['poli'] !== 'Saraf') {
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
                                        <!-- table jadwal dokter saraf -->
                                        <table id="jds-table" class="table table-striped" style="width: 100%;">
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
                                                    <?php if ($jd['poli'] !== 'Saraf') continue; ?>
                                                    <tr>
                                                        <td></td>
                                                        <td><?= $jd['nama']; ?></td>
                                                        <td><?= $jd['nip']; ?></td>
                                                        <td><?= $jd['tanggal']; ?></td>
                                                        <td><?= $jd['waktu_mulai']; ?> - <?= $jd['waktu_selesai']; ?> WIB</td>
                                                        <td class="d-flex justify-content-center gap-2 text-start">
                                                            <!-- button edit -->
                                                            <div>
                                                                <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target=<?= "#edit-jds-" . $jd['id_jadwal_dokter']; ?>>
                                                                    Edit
                                                                </button>

                                                                <div class="modal fade" id=<?= "edit-jds-" . $jd['id_jadwal_dokter']; ?> tabindex="-1">
                                                                    <div class="modal-dialog modal-dialog-centered">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <h5 class="modal-title">Edit jadwal dokter</h5>
                                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                            </div>
                                                                            <form action="./actions/kelola_jadwal_dokter.php" method="post">
                                                                                <input type="hidden" name="jenis" value="edit">
                                                                                <input type="hidden" name="id_jadwal_dokter" value=<?= (string) $jd['id_jadwal_dokter'] ?>>
                                                                                <div class="modal-body">
                                                                                    <div class="alert alert-warning" role="alert">
                                                                                        Isi kolom yang hanya ingin diubah.
                                                                                    </div>

                                                                                    <div class="row gap-3">
                                                                                        <div class="col">
                                                                                            <label for="tanggal" class="form-label">Tanggal</label>
                                                                                            <input type="date" class="form-control" name="tanggal" id="tanggal">
                                                                                        </div>
                                                                                        <div class="col-12">
                                                                                            <label for="id_dokter" class="form-label">Dokter praktek</label>
                                                                                            <select id="id_dokter" class="form-select" name="id_dokter">
                                                                                                <option selected value="0">Pilih Dokter</option>
                                                                                                <?php foreach ($dokter as $d) : ?>
                                                                                                    <?php if ($d['nip'] === $jd['nip']) continue; ?>
                                                                                                    <?php if ($d['poli'] !== 'Saraf') {
                                                                                                        continue;
                                                                                                    } ?>
                                                                                                    <option value="<?= $d['id_dokter'] ?>"><?= $d['nama'] ?>/<?= $d['nip'] ?></option>
                                                                                                <?php endforeach; ?>
                                                                                            </select>
                                                                                        </div>
                                                                                        <div class="col-12">
                                                                                            <label for="waktu" class="form-label">Waktu</label>
                                                                                            <select id="waktu" class="form-select" name="waktu">
                                                                                                <option selected value="0">Pilih Waktu</option>
                                                                                                <option value="pagi">Pagi 08:00 - 16:00 WIB</option>
                                                                                                <option value="siang">Siang 14:00:00 - 16:00:00 WIB</option>
                                                                                                <option value="malam">Malam 19:00:00 - 21:00:00 WIB</option>
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
                                                                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target=<?= "#hapus-jds-" . $jd['id_jadwal_dokter']; ?>>
                                                                    Hapus
                                                                </button>

                                                                <div class="modal fade" id=<?= "hapus-jds-" . $jd['id_jadwal_dokter']; ?> tabindex="-1">
                                                                    <div class="modal-dialog modal-dialog-centered">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <h5 class="modal-title">Hapus jadwal dokter</h5>
                                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                            </div>
                                                                            <form action="./actions/kelola_jadwal_dokter.php" method="post">
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

                            <!-- poli mata content -->
                            <div class="tab-pane fade" id="poli-mata" role="tabpanel" aria-labelledby="poli-mata-tab">
                                <h5 class="card-title">Jadwal Dokter Poli Mata</h5>
                                <div class="row justify-content-end">
                                    <div class="col">
                                        <div class="d-flex justify-content-end">
                                            <!-- tambah jadwal dokter poli mata modal -->
                                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambah-jdm">
                                                Tambah Jadwal Dokter
                                            </button>

                                            <div class="modal fade" id="tambah-jdm" tabindex="-1">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Tambah Jadwal Dokter Poli Mata</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <!-- tambah jadwal dokter poli mata form -->
                                                        <form action="./actions/kelola_jadwal_dokter.php" method="post">
                                                            <input type="hidden" value="tambah" name="jenis">
                                                            <div class="modal-body">
                                                                <div class="alert alert-warning" role="alert">
                                                                    Kolom jadwal praktek dokter harus diisi minimal satu.
                                                                </div>

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
                                                                                <?php if ($d['poli'] !== 'Mata' || $d['status_pegawai'] === 'cuti' || getLiburTodayByPegawaiId($d['id_pegawai']) !== false) {
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
                                                                                <?php if ($d['poli'] !== 'Mata' || $d['status_pegawai'] === 'cuti' || getLiburTodayByPegawaiId($d['id_pegawai']) !== false) {
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
                                                                                <?php if ($d['poli'] !== 'Mata' || $d['status_pegawai'] === 'cuti' || getLiburTodayByPegawaiId($d['id_pegawai']) !== false) {
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
                                        <!-- table jadwal dokter mata -->
                                        <table id="jdm-table" class="table table-striped" style="width: 100%;">
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
                                                    <?php if ($jd['poli'] !== 'Mata') continue; ?>
                                                    <tr>
                                                        <td></td>
                                                        <td><?= $jd['nama']; ?></td>
                                                        <td><?= $jd['nip']; ?></td>
                                                        <td><?= $jd['tanggal']; ?></td>
                                                        <td><?= $jd['waktu_mulai']; ?> - <?= $jd['waktu_selesai']; ?> WIB</td>
                                                        <td class="d-flex justify-content-center gap-2 text-start">
                                                            <!-- button edit -->
                                                            <div>
                                                                <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target=<?= "#edit-jdm-" . $jd['id_jadwal_dokter']; ?>>
                                                                    Edit
                                                                </button>

                                                                <div class="modal fade" id=<?= "edit-jdm-" . $jd['id_jadwal_dokter']; ?> tabindex="-1">
                                                                    <div class="modal-dialog modal-dialog-centered">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <h5 class="modal-title">Edit jadwal dokter</h5>
                                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                            </div>
                                                                            <form action="./actions/kelola_jadwal_dokter.php" method="post">
                                                                                <input type="hidden" name="jenis" value="edit">
                                                                                <input type="hidden" name="id_jadwal_dokter" value=<?= (string) $jd['id_jadwal_dokter'] ?>>
                                                                                <div class="modal-body">
                                                                                    <div class="alert alert-warning" role="alert">
                                                                                        Isi kolom yang hanya ingin diubah.
                                                                                    </div>

                                                                                    <div class="row gap-3">
                                                                                        <div class="col">
                                                                                            <label for="tanggal" class="form-label">Tanggal</label>
                                                                                            <input type="date" class="form-control" name="tanggal" id="tanggal">
                                                                                        </div>
                                                                                        <div class="col-12">
                                                                                            <label for="id_dokter" class="form-label">Dokter praktek</label>
                                                                                            <select id="id_dokter" class="form-select" name="id_dokter">
                                                                                                <option selected value="0">Pilih Dokter</option>
                                                                                                <?php foreach ($dokter as $d) : ?>
                                                                                                    <?php if ($d['nip'] === $jd['nip']) continue; ?>
                                                                                                    <?php if ($d['poli'] !== 'Mata') {
                                                                                                        continue;
                                                                                                    } ?>
                                                                                                    <option value="<?= $d['id_dokter'] ?>"><?= $d['nama'] ?>/<?= $d['nip'] ?></option>
                                                                                                <?php endforeach; ?>
                                                                                            </select>
                                                                                        </div>
                                                                                        <div class="col-12">
                                                                                            <label for="waktu" class="form-label">Waktu</label>
                                                                                            <select id="waktu" class="form-select" name="waktu">
                                                                                                <option selected value="0">Pilih Waktu</option>
                                                                                                <option value="pagi">Pagi 08:00 - 16:00 WIB</option>
                                                                                                <option value="siang">Siang 14:00:00 - 16:00:00 WIB</option>
                                                                                                <option value="malam">Malam 19:00:00 - 21:00:00 WIB</option>
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
                                                                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target=<?= "#hapus-jdm-" . $jd['id_jadwal_dokter']; ?>>
                                                                    Hapus
                                                                </button>

                                                                <div class="modal fade" id=<?= "hapus-jdm-" . $jd['id_jadwal_dokter']; ?> tabindex="-1">
                                                                    <div class="modal-dialog modal-dialog-centered">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <h5 class="modal-title">Hapus jadwal dokter</h5>
                                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                            </div>
                                                                            <form action="./actions/kelola_jadwal_dokter.php" method="post">
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

    // table dokter tht
    const tableJdt = $('#jdt-table').DataTable({
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

    // table dokter pdl
    const tableJdp = $('#jdp-table').DataTable({
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

    tableJdp
        .on('order.dt search.dt', function() {
            var i = 1;

            tableJdp
                .cells(null, 0, {
                    search: 'applied',
                    order: 'applied'
                })
                .every(function(cell) {
                    this.data(i++);
                });
        })
        .draw();

    // table dokter anak
    const tableJda = $('#jda-table').DataTable({
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

    tableJda
        .on('order.dt search.dt', function() {
            var i = 1;

            tableJda
                .cells(null, 0, {
                    search: 'applied',
                    order: 'applied'
                })
                .every(function(cell) {
                    this.data(i++);
                });
        })
        .draw();

    // table dokter saraf
    const tableJds = $('#jds-table').DataTable({
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

    tableJds
        .on('order.dt search.dt', function() {
            var i = 1;

            tableJds
                .cells(null, 0, {
                    search: 'applied',
                    order: 'applied'
                })
                .every(function(cell) {
                    this.data(i++);
                });
        })
        .draw();

    // table dokter mata
    const tableJdm = $('#jdm-table').DataTable({
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

    tableJdm
        .on('order.dt search.dt', function() {
            var i = 1;

            tableJdm
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