<?php
//id为会话存储用户id的变量（admin-id，student-id，teacher-id）三种值
function login($conn, $table, $name, $password, $id)
{
    global $response;
    //处理参数
    $table = mysqli_real_escape_string($conn,$table);
    $name = mysqli_real_escape_string($conn,$name);
    $password = mysqli_real_escape_string($conn,$password);

    $sql = "SELECT * FROM `$table` WHERE `name`='$name' AND `password`='$password'";
    $retval = mysqli_query($conn, $sql);
    if ($retval) {
        $response['code'] = 200;
        $response['msg'] = "数据库查询成功";
        if (mysqli_num_rows($retval) > 0) {
            $row = mysqli_fetch_array($retval, MYSQLI_ASSOC);
            $_SESSION['name'] = $row['name'];
            $_SESSION['password'] = $row['password'];
            $response['data']['status'] = 1; //代表存在此用户
            //存储各用户id以及教师科目id
            switch ($id) {
                case "admin-id":
                    $response['data']['page'] = "admin";
                    $_SESSION['admin-id'] = $row["id"];
                    break;
                case "student-id":
                    $_SESSION['student-id'] = $row["student_id"];
                    $response['data']['page'] = "student";
                    break;
                case "teacher-id":
                    {
                        $response['data']['page'] = "teacher";
                        $_SESSION['teacher-id'] = $row["teacher_id"];
                        $sql = "SELECT `subject_id` FROM `teacher_info` WHERE `name`='$name'";
                        $retval_2 = mysqli_query($conn, $sql);
                        if ($retval_2) {
                            $row2 = mysqli_fetch_assoc($retval_2);
                            $_SESSION["subject-id"] = $row2["subject_id"];
                        }
                    }
                    break;
            }
            mysqli_close($conn);
            return json_encode($response, JSON_UNESCAPED_UNICODE);
        } else {
            $response['data']['status'] = 0; //代表不存在此用户
            mysqli_close($conn);
            return json_encode($response, JSON_UNESCAPED_UNICODE);
        }
    } else {
        $response['code'] = 500;
        $response['msg'] = "数据库查询失败";
        $response['data']['status'] = 0;
        mysqli_close($conn);
        return json_encode($response, JSON_UNESCAPED_UNICODE);
    }
}
