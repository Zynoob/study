<?php
include '../config.php';
include '../conn.php';
include '../utils/update_personal_info.php';
//连接数据库
$oldPassword = isset($_POST["oldPassword"]) ? $_POST["oldPassword"] : '';
$password = isset($_POST["password"]) ? $_POST["password"] : '';

if (isset($_SESSION['name'])) {
    echo modify_password($conn, $_SESSION["teacher-id"], 'teacher', $password, $oldPassword);
}
