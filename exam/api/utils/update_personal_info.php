<?php
/**
 * $conn: 数据库连接
 * $name: 用户名
 * $type： 用户类型(admin,teacher,student)
 * $email 邮箱
 * $address: 地址
 * $phone: 手机号
 * $$truename: 姓名
 * 
 * 功能：修改个人基本信息
 */
function set_personal_info($conn, $name, $type, $email = null, $address = null, $phone = null, $truename = null)
{
    global $response;

    $email = mysqli_real_escape_string($conn, $email);
    $address = mysqli_real_escape_string($conn, $address);
    $phone = mysqli_real_escape_string($conn, $phone);
    $truename = mysqli_real_escape_string($conn, $truename);

    switch ($type) {
        case 'admin':
            $sql = "UPDATE `admin` SET `email`='$email',`address`='$address',`phone`='$phone',`truename`='$truename'
            WHERE `name`='$name'";
            break;

        case 'teacher':
            $sql = "UPDATE `teacher_info` SET `truename`='$truename',`email`='$email',`address`='$address',`phone`='$phone'
            WHERE `name`='$name'";
            break;

        case 'student':
            $sql = "UPDATE `student_info` SET `truename`='$truename',`email`='$email',`address`='$address',`phone`='$phone'
            WHERE `name`='$name'";
            break;
    }
    $res = mysqli_query($conn, $sql);
    if ($res) {
        $response['code'] = 200;
        if (mysqli_affected_rows($conn) == 0) {
            $response['msg'] = "无数据可更新";
            $response['data']['status'] = 0;
        } else {
            $response['msg'] = "数据库更新成功";
            $response['data']['status'] = 1;
        }
    } else {
        $response['code'] = 500;
        $response['msg'] = "数据库更新失败";
        $response['data']['status'] = 0;
    }
    mysqli_close($conn);
    return json_encode($response, JSON_UNESCAPED_UNICODE);
}



/**
 * $conn: 数据库连接
 * $id: 用户id
 * $type： 用户类型(admin,teacher,student)
 * $password： 用户新密码
 * $oldpassword:用户旧密码
 *
 * 功能：修改密码
 */
function modify_password($conn, $id, $type, $password, $oldpassword)
{
    global $response;
    $type = mysqli_real_escape_string($conn, $type);
    $password = mysqli_real_escape_string($conn, $password);
    $oldpassword = mysqli_real_escape_string($conn, $oldpassword);

    switch ($type) {
        case 'admin':
            $sql = "UPDATE `admin` SET `password`='$password' WHERE id='$id' AND `password`='$oldpassword'";
            break;

        case 'teacher':
            $sql = "UPDATE `teacher` SET `password`='$password' WHERE teacher_id='$id' AND `password`='$oldpassword'";
            break;

        case 'student':
            $sql = "UPDATE `student` SET `password`='$password' WHERE student_id='$id' AND `password`='$oldpassword'";
            break;
    }
    $res = mysqli_query($conn, $sql);
    if ($res) {
        $response['code'] = 200;
        if (mysqli_affected_rows($conn) == 0) {
            $sql_2="SELECT `name` FROM $type WHERE `password`='$oldpassword'";
            $res_2 = mysqli_query($conn, $sql_2);
            if (mysqli_num_rows($res_2) > 0) {
                $response['msg'] = "新旧密码一样";
                $response['data']['status'] = 0;
            }else {
                $response['msg'] = "旧密码不正确";
                $response['data']['status'] = 0;
            }
        } else {
            $response['msg'] = "更改密码成功";
            $response['data']['status'] = 1;
        }
    } else {
        $response['code'] = 500;
        $response['msg'] = "数据库更新失败";
        $response['data']['status'] = 0;
    }
    mysqli_close($conn);
    return json_encode($response, JSON_UNESCAPED_UNICODE);
}

/**
 *
 * 功能：获得教师用户个人信息
 */
function get_tea_personal_info($conn)
{
    global $response;
    $name = $_SESSION["name"];
    $sql = "SELECT t1.teacher_id AS id,t1.`name`,t3.`name` AS subjectName,t2.truename,t2.email,t2.address,t2.phone
    FROM `teacher` AS t1,teacher_info AS t2,`subject` AS t3
    WHERE t1.teacher_id=t2.teacher_id AND t2.subject_id=t3.id
    AND t1.`name`='$name'";

    $res = mysqli_query($conn, $sql);
    if ($res) {
        $response['code'] = 200;
        if (mysqli_num_rows($res) > 0) {
            $row = mysqli_fetch_assoc($res);
            $response['data']['status'] = 1;
            $response['data']['id'] = $row["id"];
            $response['data']['name'] = $row["name"];
            $response['data']['subjectName'] = $row["subjectName"];
            $response['data']['truename'] = $row["truename"];
            $response['data']['email'] = $row["email"];
            $response['data']['address'] = $row["address"];
            $response['data']['phone'] = $row["phone"];
        } else {
            $response['msg'] = "不存在此用户";
            $response['data']['status'] = 0;
        }
    } else {
        $response['code'] = 500;
        $response['msg'] = "数据库读取失败";
        $response['data']['status'] = 0;
    }
    mysqli_close($conn);
    return json_encode($response, JSON_UNESCAPED_UNICODE);
}

/**
 *
 * 功能：获得管理员用户个人信息
 */
function get_admin_personal_info($conn)
{
    global $response;
    $name = $_SESSION["name"];
    $sql = "SELECT id,`name`,truename,email,address,phone
    FROM `admin`
    WHERE `name`='$name'";

    $res = mysqli_query($conn, $sql);
    if ($res) {
        $response['code'] = 200;
        if (mysqli_num_rows($res) > 0) {
            $row = mysqli_fetch_assoc($res);
            $response['data']['status'] = 1;
            $response['data']['id'] = $row["id"];
            $response['data']['name'] = $row["name"];
            $response['data']['truename'] = $row["truename"];
            $response['data']['email'] = $row["email"];
            $response['data']['address'] = $row["address"];
            $response['data']['phone'] = $row["phone"];
        } else {
            $response['msg'] = "不存在此用户";
            $response['data']['status'] = 0;
        }
    } else {
        $response['code'] = 500;
        $response['msg'] = "数据库读取失败";
        $response['data']['status'] = 0;
    }
    mysqli_close($conn);
    return json_encode($response, JSON_UNESCAPED_UNICODE);
}

/**
 *
 * 功能：获得学生用户个人信息
 */
function get_student_personal_info($conn)
{
    global $response;
    $student_id = $_SESSION["student-id"];
    $sql = "SELECT t1.student_id AS id,t1.`name`,t2.truename,t2.email,t2.address,t2.phone
    FROM `student` AS t1,student_info AS t2
    WHERE t1.student_id=t2.student_id AND t1.student_id='$student_id'";

    $res = mysqli_query($conn, $sql);
    if ($res) {
        $response['code'] = 200;
        if (mysqli_num_rows($res) > 0) {
            $row = mysqli_fetch_assoc($res);
            $response['data']['status'] = 1;
            $response['data']['id'] = $row["id"];
            $response['data']['name'] = $row["name"];
            $response['data']['truename'] = $row["truename"];
            $response['data']['email'] = $row["email"];
            $response['data']['address'] = $row["address"];
            $response['data']['phone'] = $row["phone"];
        } else {
            $response['msg'] = "不存在此用户";
            $response['data']['status'] = 0;
        }
    } else {
        $response['code'] = 500;
        $response['msg'] = "数据库读取失败";
        $response['data']['status'] = 0;
    }
    mysqli_close($conn);
    return json_encode($response, JSON_UNESCAPED_UNICODE);
}