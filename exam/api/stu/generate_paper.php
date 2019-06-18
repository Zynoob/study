<?php
include '../config.php';
include '../conn.php';
include '../utils/generatePaper.php';
//连接数据库
$paper_id = isset($_POST["id"]) ? $_POST["id"] : '';
if ($paper_id == '') {
    die(1);
}
// echo json_encode($info);
if (isset($_SESSION['name'])) {
    echo generatePaper($conn, $paper_id);
}
