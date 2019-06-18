<?php
include './config.php';
include './conn.php';

$name = isset($_POST["name"]) ? $_POST["name"] : '';
$password = isset($_POST["password"]) ? $_POST["password"] : '';
$identity = isset($_POST["identity"]) ? $_POST["identity"] : '';

// var_dump($name);
// var_dump($password);
// var_dump($identity);
if ($name == '' || $password == '' || $identity == '') {
    $response['code'] = '406';
    $response['msg'] = '缺少参数，应该有三个参数';
    die(json_encode($response));
}

include './utils/login.php';

switch ($identity){
    case 'student':
        $json = login($conn,$identity,$name,$password,'student-id');
    break;
    case 'teacher':
        $json = login($conn,$identity,$name,$password,'teacher-id');
    break;
    case 'admin':
        $json = login($conn,$identity,$name,$password,'admin-id');
    break;
}

echo $json;
