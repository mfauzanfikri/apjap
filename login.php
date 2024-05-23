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
                    <h2 class="card-title">Rumah Sakit Umum Daerah OKI</h2>
                    <p>Isi Email dan password untuk log in.</p>
                    <form action="" method="post">
                        <div class="form-group position-relative has-icon-left mb-4">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" id="email" name="email" class="form-control form-control-xl" placeholder="Username" required />
                        </div>
                        <div class="form-group position-relative has-icon-left">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" id="password" name="password" class="form-control form-control-xl" placeholder="Password" required />
                        </div>
                        <button class="btn btn-primary btn-block shadow-lg mt-4">
                            Log in
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>

</main><!-- End #main -->

<?php include './layouts/footer.php' ?>