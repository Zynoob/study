<?php
include '../config.php';
include '../conn.php';
include '../utils/register.php';

$name = isset($_POST['name']) ? $_POST['name'] : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';

echo register($conn,'student',$name,$password);