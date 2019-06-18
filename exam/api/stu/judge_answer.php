<?php
include '../config.php';
include '../conn.php';
include '../utils/judge_answer.php';
//连接数据库
$answer = isset($_POST["answer"]) ? $_POST["answer"] : '';
if ($answer == '') {
    die(1);
}
if (!isset($answer['radio'])) {
    $answer['radio'] = array();
}
if (!isset($answer['multiple'])) {
    $answer['multiple'] = array();
}
if (!isset($answer['judge'])) {
    $answer['judge'] = array();
}
// echo json_encode($answer);
// echo json_encode($_SESSION["TRUE_RADIO"]);
// echo json_encode($_SESSION["TRUE_MULTIPLE"]);
// echo json_encode($_SESSION["TRUE_JUDGE"]);

if (isset($_SESSION['name'])) {
    echo proofreading_answer($conn, $answer);
}
