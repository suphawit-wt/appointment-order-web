<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once('../../db/connect.php');

    $username = $_POST['username'];
    $password = md5($_POST['password']);
    $fullname = $_POST['fullname'];
    $user_group = $_POST['user_group'];
    $department_id = $_POST['department_id'];

    $sql = "SELECT username FROM users WHERE username = ?";
    $stmt = $dbconn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    $user = $result->fetch_assoc();

    if (empty($user)) {
        $sql = "INSERT INTO persons (ps_name, departments_id) VALUES (?, ?)";
        $stmt = $dbconn->prepare($sql);
        $stmt->bind_param("ss", $fullname, $department_id);
        $stmt->execute();

        $lastPersonID = $dbconn->insert_id;

        $sql = "INSERT INTO users (username, passwd, user_group, persons_id)
                VALUES (?, ?, ?, ?)";
        $stmt = $dbconn->prepare($sql);
        $stmt->bind_param("ssss", $username, $password, $user_group, $lastPersonID);
        $stmt->execute();

        header("location: /staff/users/manage.php");
    } else {
        echo "<script type='text/javascript'>alert('*Username $username already in use!');history.go(-1);</script>";
    }
} else {
    header("location: /");
}
