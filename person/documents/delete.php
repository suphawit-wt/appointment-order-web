<?php
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    session_start();
    require_once('../../db/connect.php');

    $docID = $_GET['id'];
    $person_id = $_SESSION['pID'];

    $sql = "DELETE FROM doc_persons WHERE documents_id = ? AND persons_id = ?";
    $stmt = $dbconn->prepare($sql);
    $stmt->bind_param("ss", $docID, $person_id);
    $stmt->execute();

    if ($stmt->get_result() != false) {
        $sql = "DELETE FROM documents WHERE id = ?";
        $stmt = $dbconn->prepare($sql);
        $stmt->bind_param("s", $docID);
        $stmt->execute();
    }

    header("location: /person/dashboard.php");
} else {
    header("location: /");
}
