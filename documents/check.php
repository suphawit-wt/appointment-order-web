<?php
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    require_once('../db/connect.php');

    $docNum = $_GET['num'];

    $sql = "SELECT * FROM documents WHERE doc_num = ?";
    $stmt = $dbconn->prepare($sql);
    $stmt->bind_param("s", $docNum);
    $stmt->execute();
    $result = $stmt->get_result();

    $doc = $result->fetch_assoc();
?>
    <?php if (!empty($doc)) : ?>
        <span class="text-danger">*เลขที่คำสั่งนี้ถูกใช้แล้ว!</span>
    <?php endif; ?>
<?php
} else {
    header("location: /");
} ?>