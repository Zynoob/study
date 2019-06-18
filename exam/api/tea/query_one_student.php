<?php
include '../config.php';
include '../conn.php';
include '../utils/query.php';

$id = isset($_POST["id"]) ? $_POST["id"] : null;
$user_name = isset($_POST["name"]) ? $_POST["name"] : null;

if (isset($_SESSION['name'])) {
    $data = query_id($conn, $id, $user_name);
    if (!is_array($data)) {
        if ($data == -1) {
            $response['msg'] = "不存在此用户";
            $response['data']['status'] = 0;
            die(json_encode($response, JSON_UNESCAPED_UNICODE));
        } else {
            $response['msg'] = "数据库查询失败";
            $response['data']['status'] = 0;
            die(json_encode($response, JSON_UNESCAPED_UNICODE));
        }
    }
    $student_id = $data[0];
    $student_name = $data[1];
    $response['data']['studentId']=$student_id;
    $response['data']['studentName']=$student_name;
    echo tea_query_stu_paper($conn, $_SESSION['teacher-id'], $student_id);
} else {
    echo "请登录";
}