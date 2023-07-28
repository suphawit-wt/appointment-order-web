<?php
session_start();
require_once('../db/connect.php');

$doc_num = "%" . $_GET['num'] . "%";
$doc_title = "%" . $_GET['title'] . "%";
$doc_from = $_GET['from'];
$doc_to = $_GET['to'];

$person_id = $_SESSION['pID'];
$doc_count = 0;

if ($_GET['num'] == '' && $_GET['title'] == '' && $doc_from == '' && $doc_to == '') {
    $sql = "SELECT d.*
    FROM documents d
    INNER JOIN doc_persons dc ON d.id = dc.documents_id
    WHERE dc.persons_id = ?
    ORDER BY d.id DESC";
    $stmt = $dbconn->prepare($sql);
    $stmt->bind_param("s", $person_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $doc_list = $result->fetch_all(MYSQLI_ASSOC);
    $doc_count = count($doc_list);
}

if ($_GET['num'] != '') {
    $sql = "SELECT d.*
        FROM documents d
        INNER JOIN doc_persons dp ON d.id = dp.documents_id
        WHERE persons_id = ?
        AND (doc_num LIKE ?)
        ORDER BY d.id DESC";
    $stmt = $dbconn->prepare($sql);
    $stmt->bind_param("ss", $person_id, $doc_num);
    $stmt->execute();
    $result = $stmt->get_result();

    $doc_list = $result->fetch_all(MYSQLI_ASSOC);
    $doc_count = count($doc_list);
}

if ($_GET['title'] != '') {
    $sql = "SELECT d.*
        FROM documents d
        INNER JOIN doc_persons dp ON d.id = dp.documents_id
        WHERE persons_id = ?
        AND (doc_title LIKE ?)
        ORDER BY d.id DESC";
    $stmt = $dbconn->prepare($sql);
    $stmt->bind_param("ss", $person_id, $doc_title);
    $stmt->execute();
    $result = $stmt->get_result();

    $doc_list = $result->fetch_all(MYSQLI_ASSOC);
    $doc_count = count($doc_list);
}

if ($doc_from != '' && $doc_to != '') {
    $sql = "SELECT d.*
        FROM documents d
        INNER JOIN doc_persons dp ON d.id = dp.documents_id
        WHERE persons_id = ?
        AND (doc_frdate BETWEEN ? AND ?)
        ORDER BY d.id DESC";
    $stmt = $dbconn->prepare($sql);
    $stmt->bind_param("sss", $person_id, $doc_from, $doc_to);
    $stmt->execute();
    $result = $stmt->get_result();

    $doc_list = $result->fetch_all(MYSQLI_ASSOC);
    $doc_count = count($doc_list);
}
?>
<?php if ($doc_count > 0) : ?>
    <span class="text-primary">Found <?php echo $doc_count ?> documents</span>
    <?php foreach ($doc_list as $doc) : ?>
        <tr>
            <td><?php echo $doc['doc_num'] ?></td>
            <td><?php echo $doc['doc_title'] ?></td>
            <td><?php echo $doc['doc_frdate'] ?></td>
            <td><?php echo $doc['doc_todate'] ?></td>
            <td>
                <?php if ($doc['doc_exp_sts'] === 'Y') : ?>
                    <span class="label gradient-2 rounded">Expired</span>
                <?php elseif ($doc['doc_exp_sts'] === 'N') : ?>
                    <span class="label gradient-1 rounded">Activate</span>
                <?php endif; ?>
            </td>
            <td>
                <a href="/assets/order/<?php echo $doc['doc_filename'] ?>" class="text-primary">
                    <?php echo $doc['doc_filename'] ?>
                </a>
            </td>
            <td>
                <a href="/person/documents/edit.php?id=<?php echo $doc['id'] ?>" class="btn btn-sm btn-warning text-white">
                    Edit
                </a>
                &nbsp;
                <a href="/person/documents/delete.php?id=<?php echo $doc['id'] ?>" onclick="return confirm('Do you want to delete this documents?')" class="btn btn-sm btn-danger">
                    Delete
                </a>
            </td>
        </tr>
    <?php endforeach; ?>
<?php else : ?>
    <span class="text-danger">*Document not found</span>
<?php endif; ?>