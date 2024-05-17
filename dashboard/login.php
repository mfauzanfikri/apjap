<?php

require './services/auth.php';

session_start();

$isError = false;

if (isset($_POST) && isset($_POST['submit'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $user = verifyUserDashboard($username, $password);

    if (!$user) {
        global $isError;

        $isError = true;
    } else {
        $_SESSION['username'] = $user['username'];
        $_SESSION['email'] = $user['email'];
        $_SESSION['role'] = $user['role'];

        header("Location: /dashboard");
        die();
    }
}

?>


<!DOCTYPE html>
<html lang="en" data-bs-theme="light">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login</title>

    <link rel="shortcut icon" href="./assets/compiled/svg/favicon.svg" type="image/x-icon" />
    <link rel="stylesheet" href="./assets/compiled/css/app.css" />
    <link rel="stylesheet" href="./assets/compiled/css/app-dark.css" />
    <link rel="stylesheet" href="./assets/compiled/css/auth.css" />
</head>

<body>
    <script src="assets/static/js/initTheme.js"></script>
    <div id="auth">
        <div class="row h-100">
            <div class="col-lg-5 col-12">
                <div id="auth-left">
                    <div class="auth-logo">
                        <a href="index.html"><img src="./assets/compiled/svg/logo.svg" alt="Logo" /></a>
                    </div>
                    <h1 class="auth-title">Sistem Informasi Penjadwalan Rumah Sakit</h1>
                    <p class="auth-subtitle mb-5">
                        Log in untuk mengakses sistem.
                    </p>
                    <?php if ($isError) : ?>
                        <div class="alert alert-danger alert-dismissible show fade">
                            Username atau password salah.
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>

                    <form action="" method="post">
                        <div class="form-group position-relative has-icon-left mb-4">
                            <input required type="text" class="form-control form-control-xl" placeholder="Username" name="username" />
                            <div class="form-control-icon">
                                <i class="bi bi-person"></i>
                            </div>
                        </div>
                        <div class="form-group position-relative has-icon-left mb-4">
                            <input required type="password" class="form-control form-control-xl" placeholder="Password" name="password" />
                            <div class="form-control-icon">
                                <i class="bi bi-shield-lock"></i>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block btn-lg shadow-lg mt-5" name="submit">
                            Log in
                        </button>
                    </form>
                </div>
            </div>
            <div class="col-lg-7 d-none d-lg-block">
                <div id="auth-right"></div>
            </div>
        </div>
    </div>

    <script src="assets/compiled/js/app.js"></script>
</body>

</html>