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
                    <form action="" method="post">
                        <div class="form-group">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" id="username" name="username" class="form-control form-control-xl" placeholder="Username" required />
                        </div>
                        <div class="form-group mt-4">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" id="password" name="password" class="form-control form-control-xl" placeholder="Password" required />
                        </div>
                        <div class="form-group mt-4">
                            <label for="konfirmasi_password" class="form-label">Konfirmasi Password</label>
                            <input type="text" id="konfirmasi_password" name="konfirmasi_password" class="form-control form-control-xl" placeholder="Password" required />
                        </div>
                        <div class="form-group mt-4">
                            <label for="nama" class="form-label">Nama</label>
                            <input type="tel" id="nama" name="nama" class="form-control form-control-xl" placeholder="Nama" required />
                        </div>
                        <div class="form-group mt-4">
                            <label for="alamat" class="form-label">Alamat</label>
                            <textarea maxlength="100" id="alamat" name="alamat" class="form-control form-control-xl" placeholder="Alamat" required></textarea>
                        </div>
                        <button class="btn btn-primary btn-block shadow-lg mt-4">
                            Register
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>

</main><!-- End #main -->

<?php include './layouts/footer.php' ?>