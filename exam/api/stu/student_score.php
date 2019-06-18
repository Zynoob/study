<?php
include '../config.php';
include '../conn.php';
include '../utils/query.php';
//连接数据库
$offset = isset($_POST["offset"]) ? $_POST["offset"] : 0;
if (isset($_SESSION['name'])) {
    echo admin_query_student($conn, $_SESSION["student-id"], 'id', $offset);
}
