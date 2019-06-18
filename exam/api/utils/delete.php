<?php
function delete_paper($conn, $paper_id, $identity = 'teacher')
{
    $paper_id = mysqli_real_escape_string($conn, $paper_id);
    if ($identity == 'admin') {
        $User_id = $_SESSION["admin-id"];
        $from_admin = "t";
    } else {
        $User_id = $_SESSION["teacher-id"];
        $from_admin = "f";
    }
    // 删除试卷
    $sql_paper = "DELETE FROM test_paper
    WHERE id='$paper_id' AND user_id='$User_id' AND from_admin='$from_admin'";
    // 删除试题
    $sql_question = "DELETE FROM test_questions
    WHERE paper_ID='$paper_id' AND user_ID='$User_id' AND `admin`='$from_admin'";

    mysqli_query($conn, "SET AUTOCOMMIT=0"); // 设置为不自动提交，因为MYSQL默认立即执行
    mysqli_begin_transaction($conn);

    $res1 = mysqli_query($conn, $sql_paper);
    $res2 = mysqli_query($conn, $sql_question);
    if (!$res1 || !$res2) {
        $response['code'] = 500;
        $response['msg'] = "试卷删除失败";
        $response['data']['status'] = 0;
        mysqli_query($conn, "ROLLBACK"); // 判断当执行失败时回滚
        mysqli_commit($conn);
        mysqli_close($conn);
        return json_encode($response, JSON_UNESCAPED_UNICODE);
    } else {
        $response['code'] = 200;
        $response['msg'] = "试卷删除成功";
        $response['data']['status'] = 1;
        mysqli_commit($conn);
        mysqli_close($conn);
        return json_encode($response, JSON_UNESCAPED_UNICODE);
    }
}
