<?php
// 注册
function register($conn, $table, $name, $password, $subject_id = null, $truename = null, $email = null, $address = null, $phone = null)
{
    global $response;
    $table = mysqli_real_escape_string($conn,$table);
    $name = mysqli_real_escape_string($conn,$name);
    $password = mysqli_real_escape_string($conn,$password);
    if ($table == 'teacher') {
        $subject_id = mysqli_real_escape_string($conn,$subject_id);
        $truename = mysqli_real_escape_string($conn,$truename);
        $email = mysqli_real_escape_string($conn,$email);
        $address = mysqli_real_escape_string($conn,$address);
        $phone = mysqli_real_escape_string($conn,$phone);
    }
    $sql = "SELECT * FROM `$table` WHERE `name`='$name'";
    $res = mysqli_query($conn, $sql);
    if ($res) {
        //用户名不存在
        if (mysqli_num_rows($res) == 0) {
            $sql2 = "INSERT INTO `$table` (`name`,`password`,`time`)" .
                "VALUES ('$name','$password',NOW())";
            //注册成功
            if (mysqli_query($conn, $sql2)) {
                //是教师用户
                if ($table == 'teacher') {
                    return tearegister($conn, $table, $name, $subject_id, $truename, $email, $address, $phone);
                } else { //学生用户
                    return student_register($conn, $table, $name);
                }
            } else {
                $response['code'] = 500;
                $response['msg'] = "数据库插入失败";
                $response['data']['status'] = 0;
                mysqli_close($conn);
                return json_encode($response,JSON_UNESCAPED_UNICODE);
            }
        } else { //用户名已存在
            $response['code'] = 200;
            $response['msg'] = "用户名已存在";
            $response['data']['status'] = 0;
            mysqli_close($conn);
            return json_encode($response,JSON_UNESCAPED_UNICODE);
        }
    } else {
        $response['code'] = 500;
        $response['msg'] = "查询数据库失败";
        mysqli_close($conn);
        return json_encode($response,JSON_UNESCAPED_UNICODE);
    }
}

//注册教师基本资料
function tearegister($conn, $table, $name, $subject_id, $truename = null, $email = null, $address = null, $phone = null)
{
    global $response;
    $sql = "SELECT `teacher_id` FROM `$table` WHERE `name`='$name'";
    $res = mysqli_query($conn, $sql);
    if ($res) {
        $row = mysqli_fetch_assoc($res);
        $sql = "INSERT INTO `teacher_info` (`teacher_id`,`name`,`subject_id`,`truename`,`email`,`address`,`phone`)" .
            "VALUES ('" . $row["teacher_id"] . "','$name','$subject_id','$truename','$email','$address','$phone')";
        mysqli_query($conn, $sql);
        $response['code'] = 200;
        $response['msg'] = "教师用户名注册成功";
        $response['data']['status'] = 1;
        mysqli_close($conn);
        return json_encode($response,JSON_UNESCAPED_UNICODE);
    } else {
        $response['code'] = 500;
        $response['msg'] = "查询数据库失败";
        mysqli_close($conn);
        return json_encode($response,JSON_UNESCAPED_UNICODE);
    }
}

//注册学生基本资料
function student_register($conn, $table, $name)
{
    global $response;
    $sql = "SELECT `student_id` FROM `$table` WHERE `name`='$name'";
    $res = mysqli_query($conn, $sql);
    if ($res) {
        $row = mysqli_fetch_assoc($res);
        $student_id =$row["student_id"];
        $sql = "INSERT INTO student_info (student_id,`name`,truename,email,`address`,phone) 
        VALUES('$student_id','$name','','','','')";
        mysqli_query($conn, $sql);
        $response['code'] = 200;
        $response['msg'] = "学生用户名注册成功";
        $response['data']['status'] = 1;
        mysqli_close($conn);
        return json_encode($response,JSON_UNESCAPED_UNICODE);
    } else {
        $response['code'] = 500;
        $response['msg'] = "查询数据库失败";
        mysqli_close($conn);
        return json_encode($response,JSON_UNESCAPED_UNICODE);
    }
}