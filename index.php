<?php
session_start();
require_once('./db/connect.php');
require_once('./documents/update_status.php');

$sql = "SELECT * FROM documents ORDER BY id DESC LIMIT 0, 10";
$stmt = $dbconn->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();

$doc_list = $result->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Appointment Order</title>
    <link rel="icon" type="image/png" sizes="16x16" href="/assets/images/favicon.png">
    <link href="/assets/css/style.min.css" rel="stylesheet" />
    <link href="/assets/icons/font-awesome/css/font-awesome.min.css" rel="stylesheet">

    <script>
        function search() {
            var ajax = new XMLHttpRequest();
            ajax.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("display_doc").innerHTML = this.responseText;
                }
            };
            var docTitle = document.getElementById('doc_title').value;
            ajax.open("GET", "/documents/search.php?title=" + docTitle);
            ajax.send();
        }
    </script>
</head>

<body>
    <?php require_once "./components/loader.php"; ?>

    <div id="main-wrapper">

        <?php require_once "./components/header.php"; ?>

        <div class="content-body">
            <div class="container-fluid">

                <div class="row mt-3">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Search by Title</h4>
                                <div class="form-group">
                                    <div class="input-group">
                                        <input type="text" id="doc_title" onkeyup="search();" class="form-control input-rounded" placeholder="Enter the title you want to search." />
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
                                <h4 class="card-title">Documents (Last 10 documents)</h4>
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
                                                        <a class="text-primary" href="/assets/order/<?php echo $doc['doc_filename'] ?>">
                                                            <?php echo $doc['doc_filename'] ?>
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

        <?php require_once "./components/footer.php"; ?>

    </div>

    <script src="/assets/js/common.min.js"></script>
    <script src="/assets/js/custom.min.js"></script>
    <script src="/assets/js/settings.js"></script>
    <script src="/assets/js/gleek.js"></script>
</body>

</html>