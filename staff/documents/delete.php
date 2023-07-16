<?php
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    require_once('../../db/connect.php');

    $docID = $_GET['id'];

    $sql = "DELETE FROM doc_persons WHERE documents_id = ?";
    $stmt = $dbconn->prepare($sql);
    $stmt->bind_param("s", $docID);
    $stmt->execute();

    $sql = "DELETE FROM documents WHERE id = ?";
    $stmt = $dbconn->prepare($sql);
    $stmt->bind_param("s", $docID);
    $stmt->execute();

    header("location: /staff/dashboard.php");
} else {
    header("location: /");
}
