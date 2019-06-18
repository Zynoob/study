<?php
include '../config.php';
include '../conn.php';
include '../utils/buildPaper.php';
$paper = isset($_POST["paper"]) ? $_POST["paper"] : '';
//连接数据库
if (isset($_SESSION['name'])) {
    echo buildPaper($conn, $paper, 'admin');
}
