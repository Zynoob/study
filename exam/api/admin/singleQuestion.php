<?php
include('../config.php');
include('../conn.php');
include('../utils/insertQues.php');

$question = isset($_POST["question"]) ? $_POST["question"] : '';

if(isset($_SESSION['name'])) 
{
    echo buildQuestions($conn,$question,'admin');
}else{
    echo "请登录";
}