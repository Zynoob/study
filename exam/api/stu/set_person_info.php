<?php
include '../config.php';
include '../conn.php';
include '../utils/update_personal_info.php';
//连接数据库
$info = isset($_POST["info"]) ? $_POST["info"] : '';
// echo json_encode($info);
if (isset($_SESSION['name'])) {
    echo set_personal_info($conn, $_SESSION["name"], 'student', $info["email"], $info["address"], $info["phone"], $info["truename"]);
}
