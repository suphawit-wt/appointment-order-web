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

$docID = $_GET['id'];
$today = date("Y-m-d");

$sql = "SELECT * FROM documents WHERE id = ?";
$stmt = $dbconn->prepare($sql);
$stmt->bind_param("s", $docID);
$stmt->execute();
$result = $stmt->get_result();

$doc = $result->fetch_assoc();

$sql = "SELECT * 
        FROM persons 
        WHERE id NOT IN (SELECT p.id
        FROM doc_persons dp
        INNER JOIN persons p ON dp.persons_id = p.id
        WHERE dp.documents_id = ?
        ORDER BY ps_name) ";
$stmt = $dbconn->prepare($sql);
$stmt->bind_param("s", $docID);
$stmt->execute();
$result = $stmt->get_result();

$person_list = $result->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT p.id, p.ps_name
        FROM doc_persons dp
        INNER JOIN persons p ON dp.persons_id = p.id
        WHERE dp.documents_id = ?
        ORDER BY ps_name";
$stmt = $dbconn->prepare($sql);
$stmt->bind_param("s", $docID);
$stmt->execute();
$result = $stmt->get_result();

$person_now_list = $result->fetch_all(MYSQLI_ASSOC);
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
    <link href="/assets/css/bootstrap-material-datetimepicker.css" rel="stylesheet">
    <link href="/assets/icons/font-awesome/css/font-awesome.min.css" rel="stylesheet">

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

        function checkDocNum() {
            var ajax = new XMLHttpRequest();
            ajax.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("showDocNumCheck").innerHTML = this.responseText;
                }
            };
            var docNum = document.getElementById('doc_num').value;
            ajax.open("GET", "/documents/check.php?num=" + docNum);
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
                    <a href="/staff/dashboard.php" class="btn btn-rounded btn-outline-primary mb-1">
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
                                <h4 class="card-title">Edit Document</h4>
                                <form action="/staff/documents/update.php?id=<?php echo $doc['id'] ?>" method="post">
                                    <div class="row">
                                        <div class="col-lg-2 col-md-3 col-sm-12">
                                            <div class="form-group">
                                                <label class="col-md-12 col-form-label text-md-left">No.</label>
                                                <div class="input-group mb-2">
                                                    <input value="<?php echo $doc['doc_num'] ?>" type="text" id="doc_num" name="doc_num" onkeyup="checkDocNum();" class="form-control input-rounded" placeholder="No.">
                                                </div>
                                                <div id="showDocNumCheck"></div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-9 col-sm-12">
                                            <div class="form-group">
                                                <label class="col-md-12 col-form-label text-md-left">Title</label>
                                                <div class="input-group">
                                                    <input value="<?php echo $doc['doc_title'] ?>" type="text" name="doc_title" class="form-control input-rounded" placeholder="Title" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-2 col-md-3 col-sm-12">
                                            <div class="form-group">
                                                <label class="col-md-12 col-form-label text-md-left">From Date</label>
                                                <div class="input-group">
                                                    <input value="<?php echo $doc['doc_frdate'] ?>" type="text" id="doc_from" name="doc_from" class="form-control input-rounded" placeholder="From Date" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-2 col-md-3 col-sm-12">
                                            <div class="form-group">
                                                <label class="col-md-12 col-form-label text-md-left">End Date</label>
                                                <div class="input-group">
                                                    <input value="<?php echo $doc['doc_todate'] ?>" type="text" id="doc_to" name="doc_to" onchange="checkStatus();" class="form-control input-rounded" placeholder="End Date" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-2 col-md-6 col-sm-12">
                                            <div class="form-group">
                                                <label class="col-md-12 col-form-label text-md-left">Status</label>
                                                <div id="doc_status" class="input-group">
                                                    <?php if ($today > $doc['doc_todate']) : ?>
                                                        <span class="label gradient-2 btn-rounded">Expired</span>
                                                    <?php else : ?>
                                                        <span class="label gradient-1 btn-rounded">Activate</span>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-md-6 col-sm-12">
                                            <div class="form-group">
                                                <label class="col-md-12 col-form-label text-md-left">Filename</label>
                                                <div class="input-group">
                                                    <input value="<?php echo $doc['doc_filename'] ?>" type="text" name="doc_filename" class="form-control input-rounded" placeholder="Such as 0001.pdf" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-6 col-sm-12">
                                            <div class="form-group">
                                                <label class="col-md-12 col-form-label text-md-left">Current Committee</label>
                                                <div class="input-group">
                                                    <select multiple="multiple" class="form-control" size="6" disabled>
                                                        <?php foreach ($person_now_list as $person_now) : ?>
                                                            <option><?php echo $person_now['ps_name'] ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-6 col-sm-12">
                                            <div class="form-group">
                                                <label class="col-md-12 col-form-label text-md-left">Add New Committee (Press "Ctrl" to select multiple committee.)</label>
                                                <div class="input-group">
                                                    <select multiple="multiple" class="form-control" size="6" name="person_list[]">
                                                        <?php foreach ($person_list as $person) : ?>
                                                            <option value="<?php echo $person['id'] ?>"><?php echo $person['ps_name'] ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
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
                                                    <a href="/staff/documents/delete.php?id=<?php echo $doc['id'] ?>" onclick="return confirm('Do you want to delete this documents?')" class="btn btn-sm btn-danger">
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
    <script src="/assets/js/moment.js"></script>
    <script src="/assets/js/bootstrap-material-datetimepicker.js"></script>
    <script src="/assets/js/form-pickers-init.js"></script>
</body>

</html>