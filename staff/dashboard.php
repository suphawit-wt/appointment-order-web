<?php
session_start();

if (!isset($_SESSION['loggedin'])) {
    header("location: /login.php");
} else {
    if ($_SESSION['uGroup'] === 'P') {
        header("location: /person/dashboard.php");
    }
}

require_once('../db/connect.php');

$sql = "SELECT *
        FROM documents
        ORDER BY id DESC
        LIMIT 0, 30";
$stmt = $dbconn->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();

$doc_list = $result->fetch_all(MYSQLI_ASSOC);
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
    <link href="/assets/css/style.css" rel="stylesheet">

    <script>
        function search() {
            var ajax = new XMLHttpRequest();
            ajax.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("display_doc").innerHTML = this.responseText;
                }
            };
            var docNum = document.getElementById('doc_num').value;
            ajax.open("GET", "/documents/search_staff.php?num=" + docNum);
            ajax.send();
        }
    </script>
</head>

<body>
    <?php require_once "../components/loader.php"; ?>

    <div id="main-wrapper">

        <?php require_once "../components/header.php"; ?>

        <div class="content-body">
            <div class="container-fluid">

                <div class="row page-titles mx-0">
                    <a href="/" class="btn btn-rounded btn-outline-primary mb-1">
                        <i class="fa fa-arrow-left" aria-hidden="true"></i> กลับสู่หน้าหลัก
                    </a>
                    <div class="col p-md-0">
                        <ol class="breadcrumb">
                            <ul class="mr-2">
                                <a href="/staff/persons/manage.php" class="btn btn-sm btn-rounded btn-info text-white">
                                    จัดการข้อมูลบุคลากร
                                </a>
                            </ul>
                            <ul>
                                <b>
                                    <span class="text-dark">ประเภทบัญชีผู้ใช้ : </span>
                                    <span class="text-primary">Staff</span>
                                </b>
                            </ul>
                        </ol>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">ค้นหาคำสั่งแต่งตั้งด้วยเลขที่คำสั่ง</h4>
                                <div class="form-group">
                                    <div class="input-group">
                                        <input type="text" id="doc_num" onkeyup="search();" class="form-control input-rounded" placeholder="ป้อนเลขที่ของคำสั่งแต่งตั้งที่ต้องการค้นหา">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">
                                    คำสั่งแต่งตั้ง (ล่าสุด 30 คำสั่ง)
                                    <a href="/staff/documents/new.php" class="btn btn-sm btn-rounded btn-info ml-2">
                                        เพิ่มคำสั่งแต่งตั้ง
                                    </a>
                                </h4>
                                <div class="table-responsive">
                                    <table class="table header-border">
                                        <thead>
                                            <tr>
                                                <th>เลขที่คำสั่ง</th>
                                                <th>ชื่อคำสั่ง</th>
                                                <th>วันที่มีผลบังคับใช้</th>
                                                <th>วันที่คำสั่งสิ้นสุด</th>
                                                <th>สถานะ</th>
                                                <th>ไฟล์คำสั่ง</th>
                                                <th>การดำเนินการ</th>
                                            </tr>
                                        </thead>
                                        <tbody id="display_doc">
                                            <?php foreach ($doc_list as $doc) : ?>
                                                <tr>
                                                    <td><?php echo $doc['doc_num'] ?></td>
                                                    <td><?php echo $doc['doc_title'] ?></td>
                                                    <td><?php echo $doc['doc_frdate'] ?></td>
                                                    <td><?php echo $doc['doc_todate'] ?></td>
                                                    <td>
                                                        <?php if ($doc['doc_exp_sts'] === 'Y') : ?>
                                                            <span class="label gradient-2 rounded">หมดอายุแล้ว</span>
                                                        <?php elseif ($doc['doc_exp_sts'] === 'N') : ?>
                                                            <span class="label gradient-1 rounded">ยังไม่หมดอายุ</span>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td>
                                                        <a href="/assets/order/<?php echo $doc['doc_filename'] ?>" class="text-primary">
                                                            <?php echo $doc['doc_filename'] ?>
                                                        </a>
                                                    </td>
                                                    <td>
                                                        <a href="/staff/documents/edit.php?id=<?php echo $doc['id'] ?>" class="btn btn-sm btn-warning text-white">
                                                            แก้ไข
                                                        </a>
                                                        &nbsp;
                                                        <a href="/staff/documents/delete.php?id=<?php echo $doc['id'] ?>" onclick="return confirm('คุณต้องการลบข้อมูลนี้ใช่หรือไม่?')" class="btn btn-sm btn-danger">
                                                            ลบ
                                                        </a>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <?php require_once "../components/footer.php"; ?>

    </div>

    <script src="/assets/js/common.min.js"></script>
    <script src="/assets/js/custom.min.js"></script>
    <script src="/assets/js/settings.js"></script>
    <script src="/assets/js/gleek.js"></script>
</body>

</html>