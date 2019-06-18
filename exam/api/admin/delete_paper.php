<?php
include '../config.php';
include '../conn.php';
include '../utils/delete.php';
//连接数据库
$paper_id = isset($_POST["id"]) ? $_POST["id"] : '';

if (isset($_SESSION['name'])) {
    echo delete_paper($conn, $paper_id, "admin");
}
