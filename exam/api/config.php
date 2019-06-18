<?php
    $origin = isset($_SERVER['HTTP_ORIGIN']) ? $_SERVER['HTTP_ORIGIN'] : ''; 
    header('Access-Control-Allow-Origin:'.$origin);  
    header('Access-Control-Allow-Credentials:true');
    header('Access-Control-Allow-Methods:POST,GET'); 
    header('Access-Control-Allow-Headers:x-requested-with,content-type');  
    header("content-type:application/json");//将返回内容类型设置为JSON形式
    date_default_timezone_set("PRC");//设置时区为中华人民共和国
    session_start();
    // ini_set('session.gc_maxlifetime', "3600"); 
    // ini_set("session.cookie_lifetime","3600"); 
?>