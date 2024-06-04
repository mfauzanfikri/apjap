<?php

session_start();

require_once '../dashboard/services/db.php';
require_once '../dashboard/utils/utils.php';

$date = new DateTime('now', new DateTimeZone('Asia/Jakarta'));
$formatter = new IntlDateFormatter('id_ID', IntlDateFormatter::LONG, IntlDateFormatter::LONG, 'Asia/Jakarta');

$formatter->setPattern('EEEE');

$today = $formatter->format($date);

$formatter->setPattern('MMM');

$month = $formatter->format($date);

$formatter->setPattern('EEEE, d MMMM y');

$formattedDate = $formatter->format($date);

$jadwalDokter = getJadwalDokterThisMonth();

$eventJadwalDokter = [];

foreach ($jadwalDokter as $jd) {
    $id = $jd['id_jadwal_dokter'];
    $poli = $jd['poli'];
    $start = $jd['tanggal'] . 'T' . $jd['waktu_mulai'];
    $end = $jd['tanggal'] . 'T' . $jd['waktu_selesai'];

    $eventJadwalDokter[] = "{id:'$id',title:'Poli $poli',start:'$start',end:'$end'}";
}
// dd($eventJadwalDokter);

?>

<?php include './layouts/header.php'; ?>


<script src="assets/vendor/fullcalendar/dist/index.global.min.js"></script>

<!-- ======= #main ======= -->
<main id="main" class="main">

    <section class="pagetitle">
        <h1>Selamat Datang di Area Pasien RSUD Ogan Ilir</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html">Home</a></li>
            </ol>
        </nav>
    </section><!-- End Page Title -->

    <section class="section dashboard">
        <div class="row">
            <!-- calendar -->
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Jadwal Praktek Dokter <span>| <?= $formattedDate ?></span></h5>
                        <p style="font-size: smaller;">
                            keterangan: a = AM, p = PM
                        </p>
                        <div id="calendar"></div>
                    </div>
                </div>
            </div>

        </div>
    </section>

</main><!-- End #main -->

<script>
    document.addEventListener('DOMContentLoaded', function() {
        let calendarEl = document.getElementById('calendar');
        let calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            events: [<?= implode(',', $eventJadwalDokter) ?>]
        });
        calendar.render();
    });
</script>

<?php include './layouts/footer.php'; ?>