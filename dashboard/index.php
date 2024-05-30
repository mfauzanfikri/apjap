<?php

session_start();

require_once './utils/utils.php';
require_once './services/db.php';

$date = new DateTime('now', new DateTimeZone('Asia/Jakarta'));
$formatter = new IntlDateFormatter('id_ID', IntlDateFormatter::LONG, IntlDateFormatter::LONG, 'Asia/Jakarta');

$formatter->setPattern('EEEE');

$today = $formatter->format($date);

$formatter->setPattern('MMM');

$month = $formatter->format($date);

$formatter->setPattern('EEEE, d MMM y');

$formattedDate = $formatter->format($date);

$isDayOff = getLiburTodayByPegawaiId($_SESSION['id_pegawai']);

$isWorkingToday = 'Bekerja';

if ($isDayOff !== false) {
    $isWorkingToday = 'Libur';
} elseif ($_SESSION['status_pegawai'] === 'cuti') {
    $isWorkingToday = 'Cuti';
}

$firstDay = (new \DateTime('first day of this month 00:00:00'));
$lastDay = (new \DateTime('last day of this month 00:00:00'));

$period = new DatePeriod($firstDay, new DateInterval('P1D'), $lastDay->modify('+1 day'));

$daysOfMonth = [];
$pasienCountDailyOfMonth = [];

foreach ($period as $day) {
    $date = $day->format('Y-m-d\\TH:i:s.v\\Z');
    $daysOfMonth[] = "'$date'";
    $pasienCountDailyOfMonth[] = (getJadwalPemeriksaanCountByDate($date))['count'];
}

$liburThisMonth = getLiburThisMonthByPegawaiId($_SESSION['id_pegawai']);
$cutiThisMonth = getCutiThisMonthByPegawaiId($_SESSION['id_pegawai']);

$eventsThisMonth = [];
foreach ($liburThisMonth as $key => $value) {
    $date = $value['tanggal'];
    $eventsThisMonth[] = "{id:'libur_$key',title:'libur',start:'$date'}";
}

foreach ($cutiThisMonth as $key => $value) {
    $start = $value['tanggal_mulai'];
    $end = $value['tanggal_selesai'];
    $eventsThisMonth[] = "{id:'cuti_$key',title:'cuti',start:'$start',end:'$end',backgroundColor:'#adb5bd'}";
}

?>

<?php include './layouts/header.php'; ?>

<!-- ======= #main ======= -->
<main id="main" class="main">

    <div class="pagetitle">
        <h1>Dashboard</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                <li class="breadcrumb-item active">Dashboard</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
        <div class="row">
            <div class="col-md-6">
                <div class="card info-card revenue-card">
                    <div class="card-body">
                        <h5 class="card-title">Jadwal Kerja <span>| <?= $formattedDate ?></span></h5>

                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                <i class="bi bi-calendar"></i>
                            </div>
                            <div class="ps-3">
                                <h6><?= $isWorkingToday ?></h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card info-card sales-card">
                    <div class="card-body">
                        <h5 class="card-title">Status Pegawai <span>| Per hari ini</span></h5>

                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                <i class="bi bi-calendar2"></i>
                            </div>
                            <div class="ps-3">
                                <h6><?= ucwords($_SESSION['status_pegawai']) ?></h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- calendar -->
            <div class="col-12 col-lg-5">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Jadwal Kerja <span>| Bulan ini</span></h5>

                        <!-- Line Chart -->
                        <div id="calendar"></div>

                        <script>
                            document.addEventListener('DOMContentLoaded', function() {
                                var calendarEl = document.getElementById('calendar');
                                var calendar = new FullCalendar.Calendar(calendarEl, {
                                    initialView: 'dayGridMonth',
                                    events: [<?= implode(',', $eventsThisMonth) ?>]
                                });
                                calendar.render();
                            });
                        </script>
                        <!-- End Line Chart -->

                    </div>

                </div>
            </div>

            <!-- chart -->
            <div class="col-12 col-lg-7">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Jumlah Pasien <span>/Bulan ini</span></h5>

                        <!-- Line Chart -->
                        <div id="reportsChart"></div>

                        <script>
                            document.addEventListener("DOMContentLoaded", () => {
                                new ApexCharts(document.querySelector("#reportsChart"), {
                                    series: [{
                                        name: 'Sales',
                                        data: [<?= implode(',', $pasienCountDailyOfMonth) ?>],
                                    }],
                                    chart: {
                                        height: 350,
                                        type: 'area',
                                        toolbar: {
                                            show: false
                                        },
                                    },
                                    markers: {
                                        size: 4
                                    },
                                    colors: ['#4154f1'],
                                    fill: {
                                        type: "gradient",
                                        gradient: {
                                            shadeIntensity: 1,
                                            opacityFrom: 0.3,
                                            opacityTo: 0.4,
                                            stops: [0, 90, 100]
                                        }
                                    },
                                    dataLabels: {
                                        enabled: false
                                    },
                                    stroke: {
                                        curve: 'smooth',
                                        width: 2
                                    },
                                    xaxis: {
                                        type: 'datetime',
                                        categories: [<?= implode(',', $daysOfMonth) ?>]
                                    },
                                    tooltip: {
                                        x: {
                                            format: 'dd/MM/yy'
                                        },
                                    },
                                    zoom: {
                                        enabled: false
                                    }
                                }).render();
                            });
                        </script>
                        <!-- End Line Chart -->

                    </div>

                </div>
            </div>


        </div>
    </section>

</main><!-- End #main -->

<?php include './layouts/footer.php'; ?>