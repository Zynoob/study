<?php
include '../config.php';
include '../conn.php';
include '../utils/update_personal_info.php';
//连接数据库
if(isset($_SESSION['name'])) 
{
    echo get_tea_personal_info($conn);
}
