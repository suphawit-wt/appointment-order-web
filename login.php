<?php
session_start();

if (isset($_SESSION['loggedin']) && $_SESSION['uGroup'] === 'S') {
    header("location: /staff/dashboard.php");
} else if (isset($_SESSION['loggedin']) && $_SESSION['uGroup'] === 'P') {
    header("location: /person/dashboard.php");
}
?>
<!DOCTYPE html>
<html class="h-100" lang="th">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Appointment Order</title>
    <link rel="icon" type="image/png" sizes="16x16" href="/assets/images/favicon.png">
    <link href="/assets/css/style.min.css" rel="stylesheet">
</head>

<body class="h-100">
    <?php require_once "./components/loader.php"; ?>

    <div class="login-form-bg h-100">
        <div class="container h-100">
            <div class="row justify-content-center h-100">
                <div class="col-xl-6">
                    <div class="form-input-content">
                        <a href="/" class="btn btn-rounded btn-outline-primary mb-3">
                            <span><i class="fa fa-arrow-left" aria-hidden="true"></i> กลับสู่หน้าหลัก</span>
                        </a>
                        <div class="card login-form mb-0">
                            <div class="card-body pt-5">
                                <span class="btn btn-rounded btn-info">
                                    <i class="fa fa-user-o" aria-hidden="true"></i>&nbsp;&nbsp;เข้าสู่ระบบ
                                </span>
                                <form action="/users/check.php" method="post" class="mt-5 mb-5 login-input">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <input type="text" name="username" class="form-control" placeholder="Username">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="input-group">
                                            <input type="password" name="password" class="form-control" placeholder="Password">
                                        </div>
                                    </div>
                                    <button type="submit" class="btn login-form__btn submit w-100">
                                        <i class="fa fa-sign-in" aria-hidden="true"></i>&nbsp;&nbsp;เข้าสู่ระบบ
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="/assets/js/common.min.js"></script>
    <script src="/assets/js/custom.min.js"></script>
</body>

</html>