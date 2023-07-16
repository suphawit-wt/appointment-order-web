<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once('../../db/connect.php');

    $today = date("Y-m-d");

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

    $sql = "INSERT INTO documents (doc_num, doc_title, doc_frdate, doc_todate, doc_filename, doc_exp_sts)
            VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $dbconn->prepare($sql);
    $stmt->bind_param("ssssss", $docNum, $docTitle, $docFrom, $docTo, $docFilename, $docExpire);
    $stmt->execute();

    $lastID = $dbconn->insert_id;

    foreach ($personList as $personID) {
        $sql = "INSERT INTO doc_persons (documents_id, persons_id) VALUES (?, ?)";
        $stmt = $dbconn->prepare($sql);
        $stmt->bind_param("ss", $lastID, $personID);
        $stmt->execute();
    }

    header("location: /staff/dashboard.php");
} else {
    header("location: /");
}
