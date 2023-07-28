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

$person_id = $_GET['id'];

$sql = "SELECT p.id, ps_name, u.id as user_id, username, user_group, d.id as dep_id, dep_name
        FROM persons p
        INNER JOIN users u ON p.id = u.persons_id
        INNER JOIN departments d ON p.departments_id = d.id
        WHERE p.id = ?";
$stmt = $dbconn->prepare($sql);
$stmt->bind_param("s", $person_id);
$stmt->execute();
$result = $stmt->get_result();

$person = $result->fetch_assoc();

$sql = "SELECT * FROM departments ORDER BY dep_name ASC";
$stmt = $dbconn->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();

$dep_list = $result->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Appointment Order</title>
    <link rel="icon" type="image/png" sizes="16x16" href="/assets/images/favicon.png">
    <link href="/assets/css/style.min.css" rel="stylesheet">
    <link href="/assets/icons/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <script src="/assets/js/validation.js"></script>

    <script>
        function checkUsername() {
            var ajax = new XMLHttpRequest();
            ajax.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("showCheckUsername").innerHTML = this.responseText;
                }
            };
            var username = document.getElementById('username').value;
            ajax.open("GET", "/users/check.php?username=" + username);
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
                    <a href="/staff/users/manage.php" class="btn btn-rounded btn-outline-primary mb-1">
                        <i class="fa fa-arrow-left mr-1" aria-hidden="true"></i> Back to previous page
                    </a>
                    <div class="col p-md-0">
                        <ol class="breadcrumb">
                            <ul>
                                <b>
                                    <span class="text-dark">Role : </span>
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
                                <h4 class="card-title">Edit User</h4>
                                <form action="/staff/users/update.php?id=<?php echo $person['id'] ?>" method="post" name="person_form" onSubmit="return formValidation();">
                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 col-sm-12">
                                            <div class="form-group">
                                                <label class="col-md-12 col-form-label text-md-left">Username</label>
                                                <div class="input-group">
                                                    <input value="<?php echo $person['username'] ?>" type="text" id="username" name="username" onkeyup="checkUsername();" class="form-control input-rounded">
                                                </div>
                                                <div id="showCheckUsername"></div>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-md-4 col-sm-12">
                                            <div class="form-group">
                                                <label class="col-md-12 col-form-label text-md-left">Password</label>
                                                <div class="input-group">
                                                    <input type="password" id="password" name="password" class="form-control input-rounded">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-md-4 col-sm-12">
                                            <div class="form-group">
                                                <label class="col-md-12 col-form-label text-md-left">Confirm Password</label>
                                                <div class="input-group">
                                                    <input type="password" id="confirm_password" name="confirm_password" class="form-control input-rounded">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-5 col-sm-12">
                                            <div class="form-group">
                                                <label class="col-md-12 col-form-label text-md-left">Full Name</label>
                                                <div class="input-group">
                                                    <input value="<?php echo $person['ps_name'] ?>" type="text" id="fullname" name="fullname" class="form-control input-rounded">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-md-4 col-sm-12">
                                            <div class="form-group">
                                                <label class="col-md-12 col-form-label text-md-left">Department</label>
                                                <div class="input-group">
                                                    <select class="form-control input-rounded" name="department_id">
                                                        <?php foreach ($dep_list as $dep) : ?>
                                                            <option value="<?php echo $dep['id'] ?>" <?php echo ($person['dep_id'] === $dep['id'] ? "selected" : "") ?>><?php echo $dep['dep_name'] ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-2 col-md-3 col-sm-12">
                                            <div class="form-group">
                                                <label class="col-md-12 col-form-label text-md-left">Role</label>
                                                <label class="radio-inline mr-3">
                                                    <input type="radio" name="user_group" value="P" <?php echo ($person['user_group'] === 'P' ? "checked" : "") ?>> Person</label>
                                                <label class="radio-inline mr-3">
                                                    <input type="radio" name="user_group" value="S" <?php echo ($person['user_group'] === 'S' ? "checked" : "") ?>> Staff</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                            <div class="form-group mt-2">
                                                <div class="input-group">
                                                    <button type="submit" class="btn btn-warning text-white">
                                                        Update
                                                    </button>
                                                    &nbsp;&nbsp;
                                                    <a href="/staff/users/delete.php?id=<?php echo $person['id'] ?>" onclick="return confirm('Do you want to delete this documents?')" class="btn btn-sm btn-danger">
                                                        Delete
                                                    </a>
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
</body>

</html>