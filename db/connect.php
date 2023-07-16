<?php
// Config Database
$db_host = "localhost";
$db_user = "root";
$db_password = "";
$db_name = "apment_db";

$dbconn = new mysqli($db_host, $db_user, $db_password, $db_name);
$dbconn->set_charset("utf8");

if ($dbconn->connect_errno) {
    echo "Failed to connect to MySQL: (" . $dbconn->connect_errno . ") " . $dbconn->connect_error;
}
