<?php
$sql = "UPDATE documents SET doc_exp_sts = 'Y' WHERE CURDATE() > doc_todate";
$stmt = $dbconn->prepare($sql);
$stmt->execute();

$sql = "UPDATE documents SET doc_exp_sts = 'N' WHERE CURDATE() < doc_todate";
$stmt = $dbconn->prepare($sql);
$stmt->execute();
