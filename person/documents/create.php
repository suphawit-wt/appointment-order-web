<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    session_start();
    require_once('../../db/connect.php');

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

    $sql = "INSERT INTO documents (doc_num, doc_title, doc_frdate, doc_todate, doc_filename, doc_exp_sts)
            VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $dbconn->prepare($sql);
    $stmt->bind_param("ssssss", $docNum, $docTitle, $docFrom, $docTo, $docFilename, $docExpire);
    $stmt->execute();

    $lastID = $dbconn->insert_id;
    $person_id = $_SESSION['pID'];

    $sql = "INSERT INTO doc_persons (documents_id, persons_id) VALUES (?, ?)";
    $stmt = $dbconn->prepare($sql);
    $stmt->bind_param("ss", $lastID, $person_id);
    $stmt->execute();

    header("location: /person/dashboard.php");
} else {
    header("location: /");
}
