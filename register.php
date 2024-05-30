<?php include './layouts/header.php' ?>

<main id="main">

    <!-- ======= Breadcrumbs Section ======= -->
    <section class="breadcrumbs">
        <div class="container">

            <div class="d-flex justify-content-between align-items-center">
                <h2>Register</h2>
                <ol>
                    <li><a href="index.html">Home</a></li>
                    <li>Register</li>
                </ol>
            </div>

        </div>
    </section><!-- End Breadcrumbs Section -->

    <section class="inner-page">
        <div class="container">
            <div class="card">
                <div class="card-body">
                    <h2 class="card-title">Rumah Sakit Umum Daerah OKI</h2>
                    <p>Isi data di bawah untuk register.</p>

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

                    <form action="./actions/register.php" method="post">
                        <div class="form-group">
                            <label for="email" class="form-label">Email</label>
                            <input type="text" id="email" name="email" class="form-control form-control-xl" placeholder="email@example.com" autocomplete="off" required />
                        </div>
                        <div class="form-group mt-4">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" id="username" name="username" class="form-control form-control-xl" placeholder="Username" autocomplete="off" required />
                        </div>
                        <div class="form-group mt-4">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" id="password" name="password" class="form-control form-control-xl" placeholder="Password" autocomplete="off" required />
                        </div>
                        <div class="form-group mt-4">
                            <label for="konfirmasi_password" class="form-label">Konfirmasi Password</label>
                            <input type="password" id="konfirmasi_password" name="konfirmasi_password" class="form-control form-control-xl" placeholder="Password" autocomplete="off" required />
                        </div>
                        <div class="form-group mt-4">
                            <label for="nama" class="form-label">Nama</label>
                            <input type="text" id="nama" name="nama" class="form-control form-control-xl" placeholder="Nama" autocomplete="off" required />
                        </div>
                        <div class="form-group mt-4">
                            <label for="no_telepon" class="form-label">No. Telepon</label>
                            <input type="text" id="no_telepon" name="no_telepon" class="form-control form-control-xl" placeholder="08xxx" autocomplete="off" required />
                        </div>
                        <div class="form-group mt-4">
                            <label for="alamat" class="form-label">Alamat</label>
                            <textarea maxlength="100" id="alamat" name="alamat" class="form-control form-control-xl" placeholder="Alamat" autocomplete="off" required></textarea>
                            <p style="font-size: small;">Maks. 100 karakter</p>
                        </div>
                        <button type="submit" name="submit" class="btn btn-primary btn-block shadow-lg mt-4">
                            Register
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>

</main><!-- End #main -->

<?php include './layouts/footer.php' ?>