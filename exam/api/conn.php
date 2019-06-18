<?php

$servername = "localhost";
$username = "root";
$password = "";

// 创建连接
$conn = mysqli_connect($servername, $username, $password);//建立与MySQL数据库的连接

// 检测连接
if (!$conn) {
    $response['code'] = 500;
    $response['msg'] = "数据库连接失败";
    $response['status'] = "0";
    die(json_encode($response));
}
mysqli_query($conn , "set names utf8");
mysqli_select_db($conn, 'phpems' );//选择数据库
$response = array("code"=>'200',"msg"=>"成功","data"=>array("status"=>1));
//mysqli_free_result($result);
// mysqli_close($conn); 
?>
