<?php
/*
$_SESSION["TRUE_RADIO"] 单选题答案信息
$_SESSION["TRUE_MULTIPLE"] 多选题答案信息
$_SESSION["TRUE_JUDGE"] 判断题答案信息
内有 id,true_answer,score,analysis
 */
$score = 0;
function proofreading_answer($conn, $answer)
{
    global $response, $score;
    $response["data"]["radio"] =  $answer['radio'];
    $response["data"]["multiple"] = $answer['multiple'];
    $response["data"]["judge"] = $answer['judge'];

    $student_id = $_SESSION['student-id']; //学生id
    $paper_id = $answer['paper-id']; //试卷id

    $sql = "";
    $sql = pro_repeat($conn,$sql, $answer, 'radio', 'TRUE_RADIO', $student_id, $paper_id);
    $sql = pro_repeat($conn,$sql, $answer, 'multiple', 'TRUE_MULTIPLE', $student_id, $paper_id);
    $sql = pro_repeat($conn,$sql, $answer, 'judge', 'TRUE_JUDGE', $student_id, $paper_id);

    $value = array();
    $value["radio"] = $response["data"]["radio"];
    $value["multiple"] = $response["data"]["multiple"];
    $value["judge"] = $response["data"]["judge"];
    $data = json_encode($value);

    $sql_2 = insert_stu_paper($conn,$student_id, $paper_id, $score, $data);
    mysqli_query($conn, "SET AUTOCOMMIT=0"); // 设置为不自动提交，因为MYSQL默认立即执行
    mysqli_begin_transaction($conn);
    //开始执行
    $res1 = mysqli_query($conn, $sql);
    $res2 = mysqli_query($conn, $sql_2);
    if (!$res1 || !$res2) {
        mysqli_query($conn, "ROLLBACK"); // 判断当执行失败时回滚
        mysqli_commit($conn);
        mysqli_close($conn);
        $arr=[
            'code'=>500,
            'msg'=>"提交失败",
            'data'=>[
                "status"=>0
            ]
        ];
        return json_encode($arr, JSON_UNESCAPED_UNICODE);
    } else {
        mysqli_commit($conn);
        mysqli_close($conn);
        $arr=[
            'code'=>200,
            'msg'=>"提交成功",
            'data'=>[
                "status"=>1
            ]
        ];
        return json_encode($arr, JSON_UNESCAPED_UNICODE);
    }
}
/*
$type_1:radio,multiple,judge
$type_2:TRUE_RADIO,TRUE_MULTIPLE,TRUE_JUDGE
俩者应一一对应
 */
function pro_repeat($conn,$sql, $answer, $type_1, $type_2, $student_id, $paper_id)
{
    global $response, $score;
    $len = count($answer[$type_1]);
    for ($i = 0; $i < $len; $i++) {
        $stu_answer = $answer[$type_1][$i]["answer"]; //学生答案
        $true_answer = $_SESSION[$type_2][$i]["true_answer"]; //正确答案
        $ques_id = $answer[$type_1][$i]["id"]; //试题id
        $question_score = $_SESSION[$type_2][$i]["score"]; //试题分数
        $question_analysis = $_SESSION[$type_2][$i]["analysis"]; //试题分析

        if ($stu_answer == $true_answer) {
            $score += $question_score;
            $response["data"][$type_1][$i]["true_or_false"] = "true"; //是否正确
        } else {
            $response["data"][$type_1][$i]["true_or_false"] = "false"; //是否正确
        }
        $response["data"][$type_1][$i]["score"] = $question_score;
        $response["data"][$type_1][$i]["true_answer"] = $true_answer;
        $response["data"][$type_1][$i]["analysis"] = $question_analysis;
        $sql = insert_stu_question($conn, $sql, $student_id, $ques_id, $paper_id, $stu_answer, $true_answer);
    }
    return $sql;
}

function insert_stu_paper($conn,$student_id, $paper_id, $score, $data)
{
    $student_id = mysqli_real_escape_string($conn, $student_id);
    $paper_id = mysqli_real_escape_string($conn, $paper_id);
    $score = mysqli_real_escape_string($conn, $score);
    $data = mysqli_real_escape_string($conn, $data);

    $sql = "INSERT INTO stu_paper (`student_ID`,`paper_ID`,`score`,`answer`,`time`)
            VALUES('$student_id','$paper_id','$score','$data',NOW())";
    return $sql;
}

// $sql = '';
// $sql = insert_stu_question($sql, $student_id,$ques_id, $paper_id, $stu_answer,$true_answer);
function insert_stu_question($conn, $sql, $student_id, $ques_id, $paper_id, $stu_answer, $true_answer)
{
    $student_id = mysqli_real_escape_string($conn, $student_id);
    $ques_id = mysqli_real_escape_string($conn, $ques_id);
    $paper_id = mysqli_real_escape_string($conn, $paper_id);
    $stu_answer = mysqli_real_escape_string($conn, $stu_answer);
    $true_answer = mysqli_real_escape_string($conn, $true_answer);

    if ($sql == '') {
        $sql = "INSERT INTO stu_ques (`student_ID`,`ques_ID`,`paper_ID`,`stu_answer`,`true_answer`,`time`)
        VALUES('$student_id','$ques_id','$paper_id','$stu_answer','$true_answer',NOW())";
    } else {
        $sql .= ", ('$student_id','$ques_id','$paper_id','$stu_answer','$true_answer',NOW())";
    }
    return $sql;
}
