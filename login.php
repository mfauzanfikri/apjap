<?php

session_start();

require_once './dashboard/utils/utils.php';

if (isset($_SESSION['username'])) {
    redirect('./pasien/logout.php');
}

?>

<?php include './layouts/header.php' ?>

<main id="main">

    <!-- ======= Breadcrumbs Section ======= -->
    <section class="breadcrumbs">
        <div class="container">

            <div class="d-flex justify-content-between align-items-center">
                <h2>Login</h2>
                <ol>
                    <li><a href="index.html">Home</a></li>
                    <li>Login</li>
                </ol>
            </div>

        </div>
    </section><!-- End Breadcrumbs Section -->

    <section class="inner-page">
        <div class="container">
            <div class="card">
                <div class="card-body">
                    <h2 class="card-title">Rumah Sakit Umum Daerah OGAN ILIR</h2>
                    <p>Isi Email dan password untuk log in.</p>

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

                    <form action="./actions/login.php" method="post">
                        <div class="form-group position-relative has-icon-left mb-4">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" id="email" name="email" class="form-control form-control-xl" placeholder="Email" required />
                        </div>
                        <div class="form-group position-relative has-icon-left">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" id="password" name="password" class="form-control form-control-xl" placeholder="Password" required />
                        </div>
                        <button type="submit" name="submit" class="btn btn-primary btn-block shadow-lg mt-4">
                            Log in
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>

</main><!-- End #main -->

<?php include './layouts/footer.php' ?>

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