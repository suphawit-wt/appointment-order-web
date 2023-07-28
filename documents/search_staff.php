<?php
require_once('../db/connect.php');

$doc_num = "%" . $_GET['num'] . "%";

$doc_count = 0;

if ($_GET['num'] != '') {
    $sql = "SELECT *
            FROM documents
            WHERE doc_num LIKE ?
            ORDER BY id DESC";
    $stmt = $dbconn->prepare($sql);
    $stmt->bind_param("s", $doc_num);
    $stmt->execute();
    $result = $stmt->get_result();

    $doc_list = $result->fetch_all(MYSQLI_ASSOC);
    $doc_count = count($doc_list);
} else {
    $sql = "SELECT *
    FROM documents
    ORDER BY id DESC
    LIMIT 0, 30";
    $stmt = $dbconn->prepare($sql);
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
                <a href="/staff/documents/edit.php?id=<?php echo $doc['id'] ?>" class="btn btn-sm btn-warning text-white">
                    Edit
                </a>
                &nbsp;
                <a href="/staff/documents/delete.php?id=<?php echo $doc['id'] ?>" onclick="return confirm('Do you want to delete this documents?')" class="btn btn-sm btn-danger">
                    Delete
                </a>
            </td>
        </tr>
    <?php endforeach; ?>
<?php else : ?>
    <span class="text-danger">*Document not found</span>
<?php endif; ?>