<?php
session_start();

if (!isset($_SESSION['loggedin'])) {
    header("location: /login.php");
} else {
    if ($_SESSION['uGroup'] === 'S') {
        header("location: /staff/dashboard.php");
    }
}

require_once('../db/connect.php');

$person_id = $_SESSION['pID'];

$sql = "SELECT d.*
        FROM documents d
        INNER JOIN doc_persons dp ON d.id = dp.documents_id
        WHERE dp.persons_id = ?
        ORDER BY d.id DESC";
$stmt = $dbconn->prepare($sql);
$stmt->bind_param("s", $person_id);
$stmt->execute();
$result = $stmt->get_result();

$doc_list = $result->fetch_all(MYSQLI_ASSOC);
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
        function search() {
            var ajax = new XMLHttpRequest();
            ajax.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("display_doc").innerHTML = this.responseText;
                }
            };
            var docNum = document.getElementById('doc_num').value;
            var docTitle = document.getElementById('doc_title').value;
            var docFrom = document.getElementById('doc_from').value;
            var docTo = document.getElementById('doc_to').value;
            ajax.open("GET", "/documents/search_person.php?num=" + docNum + "&title=" + docTitle + "&from=" + docFrom + "&to=" + docTo);
            ajax.send();
        }

        function clearSearch() {
            document.getElementById("searchSection").reset();
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
                        <i class="fa fa-arrow-left mr-1" aria-hidden="true"></i> Back to home
                    </a>
                    <div class="col p-md-0">
                        <ol class="breadcrumb">
                            <b>
                                <span class="text-dark">Role : </span>
                                <span class="text-primary">Person</span>
                            </b>
                        </ol>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Search documents that you are committee.</h4>
                                <div class="default-tab">
                                    <ul class="nav nav-tabs mb-3" role="tablist">
                                        <li class="nav-item"><a onclick="clearSearch();" class="nav-link active show" data-toggle="tab" href="#tab1">Search by No.</a>
                                        </li>
                                        <li class="nav-item"><a onclick="clearSearch();" class="nav-link" data-toggle="tab" href="#tab2">Search by Title</a>
                                        </li>
                                        <li class="nav-item"><a onclick="clearSearch();" class="nav-link" data-toggle="tab" href="#tab3">Search by Range of End Date</a>
                                        </li>
                                    </ul>
                                    <form id="searchSection">
                                        <div class="tab-content">
                                            <div class="tab-pane fade active show" id="tab1" role="tabpanel">
                                                <div class="form-group">
                                                    <div class="input-group">
                                                        <input type="text" id="doc_num" onkeyup="search();" class="form-control input-rounded" placeholder="Enter the number you want to search." value="">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-pane fade" id="tab2">
                                                <div class="form-group">
                                                    <div class="input-group">
                                                        <input type="text" id="doc_title" onkeyup="search();" class="form-control input-rounded" placeholder="Enter the title you want to search." value="">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-pane fade" id="tab3">
                                                <label>From Date</label>
                                                <div class="form-group">
                                                    <div class="input-group">
                                                        <input type="text" id="doc_from" onchange="search();" class="form-control input-rounded" placeholder="Enter the range of end date you want to search." value="">
                                                    </div>
                                                    </br>
                                                    <label>To Date</label>
                                                    <div class="input-group">
                                                        <input type="text" id="doc_to" onchange="search();" class="form-control input-rounded" placeholder="Enter the range of end date you want to search." value="">
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

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">
                                    Documents (that you are committee.)
                                    <a href="/person/documents/new.php" class="btn btn-sm btn-rounded btn-info ml-2">
                                        Create new document
                                    </a>
                                </h4>
                                <div class="table-responsive">
                                    <table class="table header-border">
                                        <thead>
                                            <tr>
                                                <th>No.</th>
                                                <th>Title</th>
                                                <th>Start Date</th>
                                                <th>End Date</th>
                                                <th>Status</th>
                                                <th>File</th>
                                                <th>Action</th>
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
                                                            <span class="label gradient-2 rounded">Expired</span>
                                                        <?php elseif ($doc['doc_exp_sts'] === 'N') : ?>
                                                            <span class="label gradient-1 rounded">Activate</span>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td>
                                                        <a href="/assets/order/<?php echo $doc['doc_filename'] ?>" class="text-primary">
                                                            <?php echo $doc['doc_filename'] ?>
                                                        </a>
                                                    </td>
                                                    <td>
                                                        <a href="/person/documents/edit.php?id=<?php echo $doc['id'] ?>" class="btn btn-sm btn-warning text-white">
                                                            Edit
                                                        </a>
                                                        &nbsp;
                                                        <a href="/person/documents/delete.php?id=<?php echo $doc['id'] ?>" onclick="return confirm('Do you want to delete this documents?')" class="btn btn-sm btn-danger">
                                                            Delete
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
    <script src="/assets/js/moment.js"></script>
    <script src="/assets/js/bootstrap-material-datetimepicker.js"></script>
    <script src="/assets/js/form-pickers-init.js"></script>
</body>

</html>