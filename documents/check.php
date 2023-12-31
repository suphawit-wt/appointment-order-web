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
        <span class="text-danger">*This No. "<?php echo $doc['doc_num'] ?>" is already in use!</span>
    <?php endif; ?>
<?php
} else {
    header("location: /");
} ?>