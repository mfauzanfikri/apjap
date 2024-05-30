<?php

session_start();

require_once '../dashboard/utils/utils.php';

?>

<?php include './layouts/header.php'; ?>

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

    <section class="section">
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Veniam, sequi.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

</main><!-- End #main -->

<?php include './layouts/footer.php'; ?>