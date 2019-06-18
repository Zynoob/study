<?php
include '../config.php';
include '../conn.php';
include '../utils/query.php';
//连接数据库
if(isset($_SESSION['name'])) 
{
    echo query_paper($conn,$_SESSION["admin-id"],'admin');
}
