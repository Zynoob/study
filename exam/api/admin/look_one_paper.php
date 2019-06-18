<?php
include '../config.php';
include '../conn.php';
include '../utils/query.php';
//连接数据库
$id = isset($_POST["id"]) ? $_POST["id"] : '';

if (isset($_SESSION['name'])) {
    echo admin_query_paper($conn, $id);
}
