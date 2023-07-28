<?php
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    require_once('../../db/connect.php');

    $person_id = $_GET['id'];

    $sql = "DELETE FROM users WHERE persons_id = ?";
    $stmt = $dbconn->prepare($sql);
    $stmt->bind_param("s", $person_id);
    $stmt->execute();

    $sql = "DELETE FROM doc_persons WHERE persons_id = ?";
    $stmt = $dbconn->prepare($sql);
    $stmt->bind_param("s", $person_id);
    $stmt->execute();

    $sql = "DELETE FROM persons WHERE id = ?";
    $stmt = $dbconn->prepare($sql);
    $stmt->bind_param("s", $person_id);
    $stmt->execute();

    header("location: /staff/users/manage.php");
} else {
    header("location: /");
}
