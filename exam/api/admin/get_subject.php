<?php
include '../config.php';
include '../conn.php';
include '../utils/subject.php';
//连接数据库

if (isset($_SESSION['name'])) {
    echo allsubject($conn);
}
