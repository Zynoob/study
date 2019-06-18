<?php
include './config.php';
$arr = [
    "code" => 200,
    "msg" => "仍在联络",
    "data" => [
        "status" => 1,
    ],
];
echo json_encode($arr, JSON_UNESCAPED_UNICODE);
