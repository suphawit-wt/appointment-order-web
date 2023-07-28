<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once('../../db/connect.php');

    $username = $_POST['username'];
    $password = md5($_POST['password']);
    $fullname = $_POST['fullname'];
    $user_group = $_POST['user_group'];
    $department_id = $_POST['department_id'];

    $person_id = $_GET['id'];

    $sql = "UPDATE persons SET ps_name = ?, departments_id = ? WHERE id = ?";
    $stmt = $dbconn->prepare($sql);
    $stmt->bind_param("sss", $fullname, $department_id, $person_id);
    $stmt->execute();

    $sql = "UPDATE users SET username = ?, passwd = ?, user_group = ? WHERE persons_id = ?";
    $stmt = $dbconn->prepare($sql);
    $stmt->bind_param("ssss", $username, $password, $user_group, $person_id);
    $stmt->execute();

    header("location: /staff/users/manage.php");
} else {
    header("location: /");
}
