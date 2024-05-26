<?php

session_start();

require_once './services/db.php';
require_once './utils/utils.php';

$ruangan = getRuangan();

$jadwalDokter = getJadwalDokter();
$jadwalPerawat = getJadwalPerawat();

?>

<?php include './layouts/header.php'; ?>

<script>
    // ubah page title
    $(document).prop('title', 'Laporan Jadwal Kerja')
</script>

<main id="main" class="main">

    <section class="pagetitle">
        <h1>Laporan Jadwal Kerja</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
                <li class="breadcrumb-item active">Laporan Jadwal Kerja</li>
            </ol>
        </nav>
    </section><!-- End Page Title -->

    <section class="section">
        <!-- jadwal kerja dokter -->
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title">Jadwal Kerja Dokter</div>
                        <div class="row mt-2">
                            <div class="col">
                                <table id="jd-table" class="table table-striped" style="width: 100%;">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th>Nama Dokter</th>
                                            <th>NIP</th>
                                            <th>Tanggal</th>
                                            <th>Waktu</th>
                                            <th>poli</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($jadwalDokter as $jd) : ?>
                                            <tr>
                                                <td></td>
                                                <td><?= $jd['nama']; ?></td>
                                                <td><?= $jd['nip']; ?></td>
                                                <td><?= $jd['tanggal']; ?></td>
                                                <td><?= $jd['waktu_mulai']; ?> - <?= $jd['waktu_selesai']; ?> WIB</td>
                                                <td><?= $jd['poli']; ?></td>
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
        <!-- jadwal kerja perawat -->
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title">Jadwal Kerja Perawat</div>
                        <div class="row mt-2">
                            <div class="col">
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
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($jadwalPerawat as $jp) : ?>
                                            <?php //if ($jp['status'] !== 'diterima') continue; 
                                            ?>
                                            <tr>
                                                <td></td>
                                                <td><?= $jp['nama']; ?></td>
                                                <td><?= $jp['nip']; ?></td>
                                                <td><?= $jp['tanggal']; ?></td>
                                                <td><?= $jp['waktu_mulai']; ?> - <?= $jp['waktu_selesai']; ?> WIB</td>
                                                <td><?= $jp['shift']; ?></td>
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
    // table jadwal dokter
    const tableJd = $('#jd-table').DataTable({
        columnDefs: [{
                searchable: false,
                orderable: false,
                width: '10%',
                targets: 0
            },
            {
                className: "dt-head-center dt-body-center",
                targets: ['_all']
            }
        ],
        layout: {
            topStart: {
                buttons: [
                    'pageLength',
                    {
                        extend: 'searchBuilder',
                        config: {
                            columns: [1, 2, 3, 4, 5]
                        }
                    },
                    {
                        extend: 'pdf',
                        text: 'PDF',
                        title: 'Jadwal Kerja Dokter',
                        exportOptions: {
                            modifier: {
                                page: 'current'
                            }
                        },
                        customize: function(doc) {
                            doc.content[1].margin = [10, 0, 10, 0] //left, top, right, bottom
                            doc.content[1].table.widths = ['5%', '30%', '10%', '20%', '*', '10%'];
                        }
                    }
                ]
            }
        },
        order: [
            [3, 'desc']
        ]
    });

    tableJd
        .on('order.dt search.dt', function() {
            var i = 1;

            tableJd
                .cells(null, 0, {
                    search: 'applied',
                    order: 'applied'
                })
                .every(function(cell) {
                    this.data(i++);
                });
        })
        .draw();

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
                    },
                    {
                        extend: 'pdf',
                        text: 'PDF',
                        title: 'Jadwal Kerja Perawat',
                        exportOptions: {
                            modifier: {
                                page: 'current'
                            }
                        },
                        customize: function(doc) {
                            doc.content[1].margin = [10, 0, 10, 0] //left, top, right, bottom
                            doc.content[1].table.widths = ['5%', '20%', '15%', '20%', '25%', '*', '*'];
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