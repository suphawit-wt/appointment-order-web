<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    session_start();
    require_once('../../db/connect.php');

    $docID = $_GET['id'];
    $person_id = $_SESSION['pID'];

    $sql = "SELECT * FROM doc_persons WHERE documents_id = ? AND persons_id = ?";
    $stmt = $dbconn->prepare($sql);
    $stmt->bind_param("ss", $docID, $person_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $doc = $result->fetch_assoc();

    if (empty($doc)) {
        echo "<script type='text/javascript'>alert('*คุณไม่มีสิทธิ์ในการเข้าถึงข้อมูลนี้');history.go(-1);</script>";
    }

    $today = date("Y-m-d");

    $docNum = $_POST['doc_num'];
    $docTitle = $_POST['doc_title'];
    $docFrom = $_POST['doc_from'];
    $docTo = $_POST['doc_to'];
    $docFilename = $_POST['doc_filename'];

    $docExpire = "";

    if ($today > $docTo) {
        $docExpire = "Y";
    } else {
        $docExpire = "N";
    }

    $sql = "UPDATE documents
            SET doc_num = ?,
                doc_title = ?,
                doc_frdate = ?,
                doc_todate = ?,
                doc_filename = ?,
                doc_exp_sts = ?
            WHERE id = ?";
    $stmt = $dbconn->prepare($sql);
    $stmt->bind_param("sssssss", $docNum, $docTitle, $docFrom, $docTo, $docFilename, $docExpire, $docID);
    $stmt->execute();

    header("location: /person/dashboard.php");
} else {
    header("location: /");
}
