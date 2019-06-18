<?php
include '../config.php';
include '../conn.php';
include '../utils/register.php';

$name = isset($_POST['name']) ? $_POST['name'] : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';
$subject_id = isset($_POST['subject_id']) ? $_POST['subject_id'] : '';
$truename = isset($_POST['truename']) ? $_POST['truename'] : '';
$email = isset($_POST['email']) ? $_POST['email'] : '';
$address = isset($_POST['address']) ? $_POST['address'] : '';
$phone = isset($_POST['phone']) ? $_POST['phone'] : '';
if (isset($_SESSION['name'])) {
    echo register($conn, 'teacher', $name, $password, $subject_id, $truename, $email, $address, $phone);
}
