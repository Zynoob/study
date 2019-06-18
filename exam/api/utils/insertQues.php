<?php
//根据传入的$question与创建者身份$identity，创建试题
function buildQuestions($conn, $question, $identity = 'teacher-id')
{
    global $response;
    //处理数据
    $type = mysqli_real_escape_string($conn, $question['name']);
    $content = mysqli_real_escape_string($conn, $question['content']);
    $true_answer = mysqli_real_escape_string($conn, $question['trueAnswer']);
    $analysis = mysqli_real_escape_string($conn, $question['analysis']);
    $score = mysqli_real_escape_string($conn, $question['score']);
    if ($type != "判断题") {
        $A = mysqli_real_escape_string($conn, $question['A']);
        $B = mysqli_real_escape_string($conn, $question['B']);
        $C = mysqli_real_escape_string($conn, $question['C']);
        $D = mysqli_real_escape_string($conn, $question['D']);
    } else {
        $A = $B = $C = $D = 'null';
    }
    //处理学科id与是否来自管理员
    if ($identity == 'admin') {
        if (!isset($question["subject_id"]) ) {
            return;
        }
        $question["subject_id"] = mysqli_real_escape_string($conn, $question['subject_id']);
        $_SESSION["subject-id"] = $question["subject_id"];
    }
    $subject_id = $_SESSION["subject-id"];

    if ($identity == 'admin') {
        $User_id = $_SESSION["admin-id"];
        $from_admin = "t";
    } else {
        $User_id = $_SESSION["teacher-id"];
        $from_admin = "f";
    }

    mysqli_query($conn, "SET AUTOCOMMIT=0"); // 设置为不自动提交，因为MYSQL默认立即执行
    mysqli_begin_transaction($conn);

    $sql = "INSERT INTO `test_questions` (`type`,`content`,`time`,`true_answer`,`score`,`user_ID`,`paper_ID`,`paper_order`,`a`,`b`,`c`,`d`,`subject_id`,`analysis`,`admin`)
    VALUES ('$type','$content',NOW(),'$true_answer','$score','$User_id','null','null','$A','$B','$C','$D','$subject_id','$analysis','$from_admin')";
    $res = mysqli_query($conn, $sql);
    if (!$res) {
        $response['code'] = 500;
        $response['msg'] = "试题创建失败";
        $response['data']['status'] = 0;
        mysqli_query($conn, "ROLLBACK"); // 判断当执行失败时回滚
        mysqli_commit($conn);
        mysqli_close($conn);
        return json_encode($response, JSON_UNESCAPED_UNICODE);
    } else {
        $response['code'] = 200;
        $response['msg'] = "试题创建成功";
        $response['data']['status'] = 1;
        mysqli_commit($conn);
        mysqli_close($conn);
        return json_encode($response, JSON_UNESCAPED_UNICODE);
    }

}
