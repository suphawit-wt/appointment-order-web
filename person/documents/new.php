<?php
session_start();

if (!isset($_SESSION['loggedin'])) {
    header("location: /login.php");
} else {
    if ($_SESSION['uGroup'] === 'S') {
        header("location: /staff/dashboard.php");
    }
}
?>
<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Appointment Order</title>
    <link rel="icon" type="image/png" sizes="16x16" href="/assets/images/favicon.png">
    <link href="/assets/css/style.min.css" rel="stylesheet">
    <link href="/assets/css/bootstrap-material-datetimepicker.css" rel="stylesheet">

    <script>
        function checkStatus() {
            var ajax = new XMLHttpRequest();
            ajax.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("doc_status").innerHTML = this.responseText;
                }
            };
            var docTo = document.getElementById('doc_to').value;
            ajax.open("GET", "/documents/expire_check.php?to=" + docTo);
            ajax.send();
        }
    </script>
</head>

<body>
    <?php require_once "../../components/loader.php"; ?>

    <div id="main-wrapper">

        <?php require_once "../../components/header.php"; ?>

        <div class="content-body">
            <div class="container-fluid">

                <div class="row page-titles mx-0">
                    <a href="/person/dashboard.php" class="btn btn-rounded btn-outline-primary mb-1">
                        <i class="fa fa-arrow-left" aria-hidden="true"></i> กลับไปยังหน้าที่แล้ว
                    </a>
                    <div class="col p-md-0">
                        <ol class="breadcrumb">
                            <b>
                                <span class="text-dark">ประเภทบัญชีผู้ใช้ : </span>
                                <span class="text-primary">Person</span>
                            </b>
                        </ol>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">เพิ่มคำสั่งแต่งตั้ง</h4>
                                <form action="/person/documents/create.php" method="post">
                                    <div class="row">
                                        <div class="col-lg-2 col-md-3 col-sm-12">
                                            <div class="form-group">
                                                <label class="col-md-12 col-form-label text-md-left">เลขที่คำสั่ง</label>
                                                <div class="input-group">
                                                    <input type="text" name="doc_num" class="form-control input-rounded" placeholder="เลขที่คำสั่ง" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-9 col-sm-12">
                                            <div class="form-group">
                                                <label class="col-md-12 col-form-label text-md-left">ชื่อคำสั่ง</label>
                                                <div class="input-group">
                                                    <input type="text" name="doc_title" class="form-control input-rounded" placeholder="ชื่อคำสั่ง" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-2 col-md-3 col-sm-12">
                                            <div class="form-group">
                                                <label class="col-md-12 col-form-label text-md-left">วันที่มีผลบังคับใช้</label>
                                                <div class="input-group">
                                                    <input type="text" id="doc_from" name="doc_from" class="form-control input-rounded" placeholder="วันที่มีผลบังคับใช้" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-2 col-md-3 col-sm-12">
                                            <div class="form-group">
                                                <label class="col-md-12 col-form-label text-md-left">วันที่คำสั่งสิ้นสุด</label>
                                                <div class="input-group">
                                                    <input type="text" id="doc_to" name="doc_to" onchange="checkStatus();" class="form-control input-rounded" placeholder="วันที่คำสั่งสิ้นสุด" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-2 col-md-6 col-sm-12">
                                            <div class="form-group">
                                                <label class="col-md-12 col-form-label text-md-left">สถานะคำสั่ง</label>
                                                <div id="doc_status" class="input-group">
                                                    <span class="label gradient-1 btn-rounded">...</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-md-6 col-sm-12">
                                            <div class="form-group">
                                                <label class="col-md-12 col-form-label text-md-left">ชื่อไฟล์คำสั่ง</label>
                                                <div class="input-group">
                                                    <input type="text" name="doc_filename" class="form-control input-rounded" placeholder="เช่น 0001.pdf" required>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                            <div class="form-group mt-2">
                                                <div class="input-group">
                                                    <button type="submit" class="btn btn-info text-white">
                                                        เพิ่มคำสั่ง
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <?php require_once "../../components/footer.php"; ?>

    </div>

    <script src="/assets/js/common.min.js"></script>
    <script src="/assets/js/custom.min.js"></script>
    <script src="/assets/js/settings.js"></script>
    <script src="/assets/js/gleek.js"></script>
    <script src="/assets/js/moment.js"></script>
    <script src="/assets/js/bootstrap-material-datetimepicker.js"></script>
    <script src="/assets/js/form-pickers-init.js"></script>
</body>

</html>