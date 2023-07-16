<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once('../../db/connect.php');

    $today = date("Y-m-d");
    $docID = $_GET['id'];

    $docNum = $_POST['doc_num'];
    $docTitle = $_POST['doc_title'];
    $docFrom = $_POST['doc_from'];
    $docTo = $_POST['doc_to'];
    $docFilename = $_POST['doc_filename'];
    $personList = $_POST['person_list'];

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

    foreach ($personList as $personID) {
        $sql = "INSERT INTO doc_persons (documents_id, persons_id) VALUES (?, ?)";
        $stmt = $dbconn->prepare($sql);
        $stmt->bind_param("ss", $docID, $personID);
        $stmt->execute();
    }

    header("location: /staff/dashboard.php");
} else {
    header("location: /");
}
