<?php
//根据传入的$paper与创建者身份$identity，创建试卷试题
function buildPaper($conn, $paper, $identity = 'teacher-id')
{
    global $response;
    $paper['title']=mysqli_real_escape_string($conn, $paper['title']);
    $paper['desc']=mysqli_real_escape_string($conn, $paper['desc']);
    $paper['radioNum']=mysqli_real_escape_string($conn, $paper['radioNum']);
    $paper['multipleNum']=mysqli_real_escape_string($conn, $paper['multipleNum']);
    $paper['judgeNum']=mysqli_real_escape_string($conn, $paper['judgeNum']);
    $paper['duration']=mysqli_real_escape_string($conn, $paper['duration']);
    $paper['radioScore']=mysqli_real_escape_string($conn, $paper['radioScore']);
    $paper['mulScore']=mysqli_real_escape_string($conn, $paper['mulScore']);
    $paper['judgeScore']=mysqli_real_escape_string($conn, $paper['judgeScore']);

    $title =  $paper['title'];
    $desc =  $paper['desc'];
    $rN = intval($paper['radioNum'], 10);
    $mN = intval($paper['multipleNum'], 10);
    $jN = intval($paper['judgeNum'], 10);
    $dT = $paper['duration'];
    $nowtime = date("Y-m-d G:i:s");
    $radioScore = intval($paper["radioScore"]);
    $mulScore = intval($paper["mulScore"]);
    $judgeScore = intval($paper["judgeScore"]);
    $total_score = $rN * $radioScore + $mN * $mulScore + $jN * $judgeScore;
    if ($identity == 'admin') {
        if (!isset($paper["subject_id"]) ) {
            return;
        }
        $paper["subject_id"] = mysqli_real_escape_string($conn, $paper["subject_id"]);
        $_SESSION["subject-id"] = $paper["subject_id"];
    }
    if ($identity == 'admin') {
        $User_id = $_SESSION["admin-id"];
        $from_admin = "t";
    } else {
        $User_id = $_SESSION["teacher-id"];
        $from_admin = "f";
    }

    mysqli_query($conn, "SET AUTOCOMMIT=0"); // 设置为不自动提交，因为MYSQL默认立即执行
    mysqli_begin_transaction($conn);

    //创建试卷
    $sql = insertPaper($conn, $User_id, $_SESSION["subject-id"], $title, $desc, $rN, $mN, $jN, $dT, $total_score, $nowtime, $from_admin);
    $res1 = mysqli_query($conn, $sql);
    //创建的试卷的试卷ID
    $sql = "SELECT id FROM test_paper WHERE `time`='$nowtime'";
    $retval = mysqli_query($conn, $sql);
    if (!$retval) {
        $response['code'] = 500;
        $response['msg'] = "数据库查询连接失败";
        $response['data']['status'] = 0;
        die(json_encode($response));
    }
    $row = mysqli_fetch_array($retval, MYSQLI_ASSOC);
    $paper_id = $row['id'];
    //单选题
    $start = 1;
    $end = $rN;
    $sql = insertRadio($conn, $start, $end, $paper, $nowtime, $radioScore, $User_id, $paper_id, $_SESSION["subject-id"], $from_admin);
    $res2 = true;
    if ($sql != "") {
        $res2 = mysqli_query($conn, $sql);
    }

    // 多选题
    $start = $rN + 1;
    $end = $rN + $mN;
    $sql = insertMultiple($conn, $start, $end, $paper, $nowtime, $mulScore, $User_id, $paper_id, $_SESSION["subject-id"], $from_admin);
    $res3 = true;
    if ($sql != "") {
        $res3 = mysqli_query($conn, $sql);
    }
    // 判断题
    $start = $rN + $mN + 1;
    $end = $rN + $mN + $jN;
    $sql = insertJudge($conn, $start, $end, $paper, $nowtime, $judgeScore, $User_id, $paper_id, $_SESSION["subject-id"], $from_admin);
    $res4 = true;
    if ($sql != "") {
        $res4 = mysqli_query($conn, $sql);
    }

    if (!$res1 || !$res2 || !$res3 || !$res4) {
        $response['code'] = 500;
        if (!$res1) {
            $response['msg'] = "试卷创建失败";
        } else {
            $response['msg'] = "试题创建失败";
        }
        $response['data']['status'] = 0;
        mysqli_query($conn, "ROLLBACK"); // 判断当执行失败时回滚
        mysqli_commit($conn);
        mysqli_close($conn);
        return json_encode($response, JSON_UNESCAPED_UNICODE);
    } else {
        $response['code'] = 200;
        $response['msg'] = "试卷创建成功";
        $response['data']['status'] = 1;
        mysqli_commit($conn);
        mysqli_close($conn);
        return json_encode($response, JSON_UNESCAPED_UNICODE);
    }
}

// 以下为生成SQL语句

function insertPaper($conn, $user_id, $subject_id, $title, $content, $radio, $multiple, $judgement, $duration, $total_score, $nowtime, $from_admin)
{
    $title = mysqli_real_escape_string($conn, $title);
    $content = mysqli_real_escape_string($conn, $content);
    $title = mysqli_real_escape_string($conn, $title);

    $sql = "INSERT INTO `test_paper` (`user_id`,`subject_id`,`title`,`content`,`radio`,`multiple`,`judgement`,`duration`,`total_score`,`time`,`from_admin`) " .
        "VALUES ('$user_id','$subject_id','$title','$content','$radio','$multiple','$judgement','$duration','$total_score','$nowtime','$from_admin')";
    return $sql;
}

function insertRadio($conn, $start, $end, $paper, $nowtime, $score, $user_ID, $paper_ID, $subject_id, $admin)
{
    $sql = "";
    for ($i = $start; $i <= $end; $i++) {
        $index = "n" . $i;

        $content = mysqli_real_escape_string($conn, $paper[$index][0]);
        $A = mysqli_real_escape_string($conn, $paper[$index][1]);
        $B = mysqli_real_escape_string($conn, $paper[$index][2]);
        $C = mysqli_real_escape_string($conn, $paper[$index][3]);
        $D = mysqli_real_escape_string($conn, $paper[$index][4]);
        $true_answer = mysqli_real_escape_string($conn, $paper[$index][5]);
        $analysis = mysqli_real_escape_string($conn, $paper[$index][6]);

        if ($i == $start) {
            $sql .= "INSERT INTO `test_questions` " .
                "(`type`,`content`,`time`,`true_answer`,`score`,`user_ID`,`paper_ID`,`paper_order`,`a`,`b`,`c`,`d`,`subject_id`,`analysis`,`admin`) " .
                "VALUES ('单选题','$content','$nowtime','$true_answer','$score','$user_ID','$paper_ID','$i'," .
                "'$A','$B','$C','$D','$subject_id','$analysis','$admin')";
        } else {
            $sql .= ", ('单选题','$content','$nowtime','$true_answer','$score','$user_ID','$paper_ID','$i'," .
                "'$A','$B','$C','$D','$subject_id','$analysis','$admin')";
        }
    }
    return $sql;
}

function insertMultiple($conn, $start, $end, $paper, $nowtime, $score, $user_ID, $paper_ID, $subject_id, $admin)
{
    $sql = "";
    for ($i = $start; $i <= $end; $i++) {
        $index = "n" . $i;

        $content = mysqli_real_escape_string($conn, $paper[$index][0]);
        $A = mysqli_real_escape_string($conn, $paper[$index][1]);
        $B = mysqli_real_escape_string($conn, $paper[$index][2]);
        $C = mysqli_real_escape_string($conn, $paper[$index][3]);
        $D = mysqli_real_escape_string($conn, $paper[$index][4]);
        $true_answer = mysqli_real_escape_string($conn, $paper[$index][5]);
        $analysis = mysqli_real_escape_string($conn, $paper[$index][6]);

        if ($i == $start) {
            $sql .= "INSERT INTO `test_questions` " .
                "(`type`,`content`,`time`,`true_answer`,`score`,`user_ID`,`paper_ID`,`paper_order`,`a`,`b`,`c`,`d`,`subject_id`,`analysis`,`admin`) " .
                "VALUES ('多选题',$content','$nowtime','$true_answer','$score','$user_ID','$paper_ID','$i'," .
                "'$A','$B','$C','$D','$subject_id','$analysis','$admin')";
        } else {
            $sql .= ", ('多选题','$content','$nowtime','$true_answer','$score','$user_ID','$paper_ID','$i'," .
                "'$A','$B','$C','$D','$subject_id','$analysis','$admin')";
        }
    }
    return $sql;
}

function insertJudge($conn, $start, $end, $paper, $nowtime, $score, $user_ID, $paper_ID, $subject_id, $admin)
{
    $sql = "";
    for ($i = $start; $i <= $end; $i++) {
        $index = "n" . $i;

        $content = mysqli_real_escape_string($conn, $paper[$index][0]);
        $true_answer = mysqli_real_escape_string($conn, $paper[$index][1]);
        $analysis = mysqli_real_escape_string($conn, $paper[$index][2]);

        if ($i == $start) {
            $sql .= "INSERT INTO `test_questions` " .
                "(`type`,`content`,`time`,`true_answer`,`score`,`user_ID`,`paper_ID`,`paper_order`,`a`,`b`,`c`,`d`,`subject_id`,`analysis`,`admin`) " .
                "VALUES ('判断题','$content','$nowtime','$true_answer','$score','$user_ID','$paper_ID','$i'," .
                "'null','null','null','null','$subject_id','$analysis','$admin')";
        } else {
            $sql .= ", ('判断题','$content','$nowtime','$true_answer','$score','$user_ID','$paper_ID','$i'," .
                "'null','null','null','null','$subject_id','$analysis','$admin')";
        }
    }
    return $sql;
}
