<?php
session_start();

if (!isset($_SESSION['loggedin'])) {
    header("location: /login.php");
} else {
    if ($_SESSION['uGroup'] === 'P') {
        header("location: /person/dashboard.php");
    }
}

require_once('../../db/connect.php');

$sql = "SELECT p.id, ps_name, username, user_group, dep_name
        FROM persons p
        INNER JOIN users u ON p.id = u.persons_id
        INNER JOIN departments d ON p.departments_id = d.id
        ORDER BY username ASC";
$stmt = $dbconn->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();

$person_list = $result->fetch_all(MYSQLI_ASSOC);
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
</head>

<body>
    <?php require_once "../../components/loader.php"; ?>

    <div id="main-wrapper">

        <?php require_once "../../components/header.php"; ?>

        <div class="content-body">
            <div class="container-fluid">

                <div class="row page-titles mx-0">
                    <a href="/staff/dashboard.php" class="btn btn-rounded btn-outline-primary mb-1">
                        <i class="fa fa-arrow-left" aria-hidden="true"></i> กลับไปยังหน้าที่แล้ว
                    </a>
                    <div class="col p-md-0">
                        <ol class="breadcrumb">
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
                                <h4 class="card-title">
                                    บุคลากรทั้งหมด
                                    <a href="/staff/persons/new.php" class="btn btn-sm btn-rounded btn-info ml-2">
                                        เพิ่มบุคลากร
                                    </a>
                                </h4>
                                <div class="table-responsive">
                                    <table class="table header-border">
                                        <thead>
                                            <tr>
                                                <th>บัญชีผู้ใช้</th>
                                                <th>ชื่อผู้ใช้</th>
                                                <th>แผนก</th>
                                                <th>ประเภท</th>
                                                <th>การดำเนินการ</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($person_list as $person) : ?>
                                                <tr>
                                                    <td><?php echo $person['username'] ?></td>
                                                    <td><?php echo $person['ps_name'] ?></td>
                                                    <td><?php echo $person['dep_name'] ?></td>
                                                    <td>
                                                        <?php if ($person['user_group'] === 'S') : ?>
                                                            <span>Staff</span>
                                                        <?php elseif ($person['user_group'] === 'P') : ?>
                                                            <span>Person</span>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td>
                                                        <a href="/staff/persons/edit.php?id=<?php echo $person['id'] ?>" class="btn btn-sm btn-warning text-white">
                                                            แก้ไข
                                                        </a>
                                                        &nbsp;
                                                        <a href="/staff/persons/delete.php?id=<?php echo $person['id'] ?>" onclick="return confirm('คุณต้องการลบข้อมูลนี้ใช่หรือไม่?')" class="btn btn-sm btn-danger">
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

        <?php require_once "../../components/footer.php"; ?>

    </div>

    <script src="/assets/js/common.min.js"></script>
    <script src="/assets/js/custom.min.js"></script>
    <script src="/assets/js/settings.js"></script>
    <script src="/assets/js/gleek.js"></script>
</body>

</html>