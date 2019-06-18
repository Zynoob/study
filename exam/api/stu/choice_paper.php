<?php
include '../config.php';
include '../conn.php';
include '../utils/query.php';
//连接数据库
$subject_id = isset($_POST["id"]) ? $_POST["id"] : '';
$offset = isset($_POST["offset"]) ? $_POST["offset"] : 0;
if ($subject_id == '') {
    die(1);
}
// echo json_encode($info);
if (isset($_SESSION['name'])) {
    echo query_subject_paper($conn, $subject_id, $offset);
}
