<?php
require_once('../db/connect.php');

$doc_title = "%" . $_GET['title'] . "%";

$sql = "SELECT *
        FROM documents
        WHERE doc_title
        LIKE ?
        ORDER BY id DESC";
$stmt = $dbconn->prepare($sql);
$stmt->bind_param("s", $doc_title);
$stmt->execute();
$result = $stmt->get_result();

$doc_list = $result->fetch_all(MYSQLI_ASSOC);
$doc_count = count($doc_list);
?>
<?php if ($doc_count > 0) : ?>
    <span class="text-primary">ค้นพบ <?php echo $doc_count ?></span>
    <?php foreach ($doc_list as $doc) : ?>
        <tr>
            <td><?php echo $doc['doc_num'] ?></td>
            <td><?php echo $doc['doc_title'] ?></td>
            <td><?php echo $doc['doc_frdate'] ?></td>
            <td><?php echo $doc['doc_todate'] ?></td>
            <td>
                <?php if ($doc['doc_exp_sts'] === 'Y') : ?>
                    <span class="label gradient-2 rounded">หมดอายุแล้ว</span>
                <?php elseif ($doc['doc_exp_sts'] === 'N') : ?>
                    <span class="label gradient-1 rounded">ยังไม่หมดอายุ</span>
                <?php endif; ?>
            </td>
            <td>
                <a href="/assets/order/<?php echo $doc['doc_filename'] ?>" class="text-primary">
                    <?php echo $doc['doc_filename'] ?>
                </a>
            </td>
        </tr>
    <?php endforeach; ?>
<?php else : ?>
    <span class="text-danger">*ไม่พบคำสั่งแต่งตั้ง</span>
<?php endif; ?>