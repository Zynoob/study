<?php
//管理员查询学生全部科目成绩
function admin_query_student($conn, $id_or_name, $chocie = 'id', $offset = 0)
{
    global $response;
    $id_or_name = mysqli_real_escape_string($conn, $id_or_name);
    $offset = mysqli_real_escape_string($conn, $offset);
    switch ($chocie) {
        case 'id':
            $sql = "SELECT t1.`name`,t2.id,t1.time,t3.score,t2.title,t2.radio,t2.multiple,t2.judgement,t2.total_score,t2.duration,t2.content,t4.`name` AS subjectname
            FROM student AS t1,test_paper AS t2,stu_paper AS t3,`subject` AS t4
            WHERE t1.student_id='$id_or_name' AND t1.student_id=t3.student_ID AND t3.paper_ID=t2.id AND t4.id=t2.subject_id
            LIMIT 5 OFFSET $offset ";
            break;
        default:
            $sql = "SELECT t1.`name`,t2.id,t1.time,t3.score,t2.title,t2.radio,t2.multiple,t2.judgement,t2.total_score,t2.duration,t2.content,t4.`name` AS subjectname
            FROM student AS t1,test_paper AS t2,stu_paper AS t3,`subject` AS t4
            WHERE t1.name='$id_or_name' AND t1.student_id=t3.student_ID AND t3.paper_ID=t2.id AND t4.id=t2.subject_id
            LIMIT 5 OFFSET $offset ";
            break;
    }
    $res = mysqli_query($conn, $sql);
    if ($res) {
        $response["data"]["dataRows"] = mysqli_num_rows($res);
        if (mysqli_num_rows($res) > 0) {
            while ($row = mysqli_fetch_assoc($res)) {
                $temp = array();
                $temp["id"] = $row["id"]; //试卷id
                $temp["subjectName"] = $row["subjectname"]; //试卷标题
                $temp["title"] = $row["title"]; //试卷标题
                $temp["content"] = $row["content"]; //介绍
                $temp["score"] = $row["score"]; //考试分数
                $temp["totalScore"] = $row["total_score"]; //试卷总分数
                $temp["radio"] = $row["radio"]; //单选题数量
                $temp["multiple"] = $row["multiple"]; //多选题数量
                $temp["judgement"] = $row["judgement"]; //判断题数量
                $temp["duration"] = $row["duration"]; //考试持续时间
                $temp["time"] = $row["time"]; //试卷完成时间
                $response["data"]["info"][] = $temp;
            }
        } else {
            $response["data"]["info"] = array();
        }
    } else {
        $response["code"] = '500';
        $response['msg'] = "学生试卷信息查询失败";
        $response['data']['status'] = 0;
    }
    mysqli_close($conn);
    return json_encode($response, JSON_UNESCAPED_UNICODE);
}

//返回学生id与用户名
function query_id($conn, $student_id = null, $student_name = null)
{
    if ($student_id == null) {
        $student_name = mysqli_real_escape_string($conn, $student_name);
        $sql = "SELECT student_id,`name` FROM student WHERE `name`='$student_name'";
    } else {
        $student_id = mysqli_real_escape_string($conn, $student_id);
        $sql = "SELECT student_id,`name` FROM student WHERE student_id='$student_id'";
    }

    $res = mysqli_query($conn, $sql);
    if ($res) {
        if (mysqli_num_rows($res) > 0) {
            $row = mysqli_fetch_assoc($res);
            $data = [$row["student_id"], $row["name"]]; //学生id,姓名
        } else {
            $data = -1; //不存在此用户
        }
    } else {
        $data = -2; //数据库查询失败
    }
    return $data;
}
//教师所属试卷
function query_paper($conn, $user_id, $admin = null)
{
    global $response;
    $user_id = mysqli_real_escape_string($conn, $user_id);
    $from_admin = 'f';
    if ($admin == 'admin') {
        $from_admin = 't';
    } else {
        $from_admin = 'f';
    }
    $sql = "SELECT t1.id,t2.`name`,t1.title,t1.total_score AS score,t1.radio,t1.multiple,t1.judgement,t1.duration,t1.time,t1.content
    FROM test_paper AS t1,`subject` AS t2
    WHERE t1.from_admin='$from_admin' AND t1.subject_id=t2.id AND t1.user_id='$user_id' ORDER BY t1.time DESC";

    $res = mysqli_query($conn, $sql);
    if ($res) {
        if (mysqli_num_rows($res) > 0) {
            //科目名只记录一次的变量
            $count = 1;
            while ($row = mysqli_fetch_assoc($res)) {
                $temp = array();
                //科目名只记录一次
                while ($count == 1) {
                    $response["data"]["subjectName"] = $row["name"]; //科目名
                    $count = 0;
                }
                $temp["paper_id"] = $row["id"]; //试卷编号id
                $temp["title"] = $row["title"]; //试卷标题
                $temp["totalScore"] = $row["score"]; //总分分数
                $temp["radio"] = $row["radio"]; //单选题数量
                $temp["multiple"] = $row["multiple"]; //多选题数量
                $temp["judgement"] = $row["judgement"]; //判断题数量
                $temp["content"] = $row["content"]; //介绍
                $temp["duration"] = $row["duration"]; //考试时长
                $temp["time"] = $row["time"]; //创建完成时间
                $response["data"]["info"][] = $temp;
            }
        } else {
            $response["data"]["info"] = array();
        }
    } else {
        $response["code"] = '500';
        $response['msg'] = "试卷信息查询失败";
        $response['data']['status'] = 0;
    }
    mysqli_close($conn);
    return json_encode($response, JSON_UNESCAPED_UNICODE);
}

//教师查询自己试卷某个学生的试卷信息
function tea_query_stu_paper($conn, $teacher_id, $student_id)
{
    global $response;
    $sql = "SELECT t2.id,t1.time,t1.score,t2.title,t2.radio,t2.multiple,t2.judgement,t2.total_score,t2.duration,t2.content,t3.`name`
    FROM stu_paper AS t1,`test_paper` AS t2,`subject` AS t3
    WHERE t2.from_admin='f' AND t2.id=t1.paper_ID AND t3.id=t2.subject_id " .
        "AND t2.user_id='$teacher_id' AND t1.student_ID='$student_id'
    ORDER BY t1.time DESC LIMIT 10";

    $res = mysqli_query($conn, $sql);
    if ($res) {
        if (mysqli_num_rows($res) > 0) {
            //科目名只记录一次的变量
            $count = 1;
            while ($row = mysqli_fetch_assoc($res)) {
                $temp = array();
                //科目名只记录一次
                while ($count == 1) {
                    $response["data"]["subjectName"] = $row["name"]; //科目名
                    $count = 0;
                }
                $temp["id"] = $row["id"]; //试卷id
                $temp["title"] = $row["title"]; //试卷标题
                $temp["content"] = $row["content"]; //介绍
                $temp["score"] = $row["score"]; //考试分数
                $temp["totalScore"] = $row["total_score"]; //试卷总分数
                $temp["radio"] = $row["radio"]; //单选题数量
                $temp["multiple"] = $row["multiple"]; //多选题数量
                $temp["judgement"] = $row["judgement"]; //判断题数量
                $temp["duration"] = $row["duration"]; //考试持续时间
                $temp["time"] = $row["time"]; //试卷完成时间
                $response["data"]["info"][] = $temp;
            }
        } else {
            $response["data"]["info"] = array();
        }
    } else {
        $response["code"] = '500';
        $response['msg'] = "试卷信息查询失败";
        $response['data']['status'] = 0;
    }
    mysqli_close($conn);
    return json_encode($response, JSON_UNESCAPED_UNICODE);
}

//管理员查看指定编号的试卷
function admin_query_paper($conn, $paper_id)
{
    global $response;
    $paper_id = mysqli_real_escape_string($conn, $paper_id);

    $sql = "SELECT t1.id,t2.`name`,t1.title,t1.total_score AS score,t1.radio,t1.multiple,t1.judgement,t1.duration,t1.time,t1.content
    FROM `test_paper` AS t1,`subject` AS t2 WHERE t1.subject_id=t2.id AND t1.id='$paper_id'";

    $res = mysqli_query($conn, $sql);
    if ($res) {
        if (mysqli_num_rows($res) > 0) {
            //科目名只记录一次的变量

            $row = mysqli_fetch_assoc($res);
            $temp = array();
            //科目名只记录一次
            $response["data"]["subjectName"] = $row["name"]; //科目名

            $temp["paper_id"] = $row["id"]; //试卷编号id
            $temp["title"] = $row["title"]; //试卷标题
            $temp["totalScore"] = $row["score"]; //总分分数
            $temp["radio"] = $row["radio"]; //单选题数量
            $temp["multiple"] = $row["multiple"]; //多选题数量
            $temp["judgement"] = $row["judgement"]; //判断题数量
            $temp["content"] = $row["content"]; //介绍
            $temp["duration"] = $row["duration"]; //考试时长
            $temp["time"] = $row["time"]; //创建完成时间
            $response["data"]["info"][] = $temp;

        } else {
            $response["data"]["info"] = array();
        }
    } else {
        $response["code"] = '500';
        $response['msg'] = "试卷信息查询失败";
        $response['data']['status'] = 0;
    }
    mysqli_close($conn);
    return json_encode($response, JSON_UNESCAPED_UNICODE);
}

/**
 * $subject_id: 科目id
 * $offset: 偏移量
 * 
 *  功能：查询某科目试卷
 */
function query_subject_paper($conn, $subject_id,$offset=0)
{
    global $response;
    $subject_id = mysqli_real_escape_string($conn, $subject_id);
    $offset = mysqli_real_escape_string($conn, $offset);

    $sql = "SELECT id,title,content,duration,total_score AS score
    FROM test_paper 
    WHERE subject_id='$subject_id'
    LIMIT 5 OFFSET $offset";

    $res = mysqli_query($conn, $sql);
    if ($res) {
        $response["data"]["dataRows"] = mysqli_num_rows($res);
        if (mysqli_num_rows($res) > 0) {
            while ($row = mysqli_fetch_assoc($res)) {
                $temp = array();
                //科目名只记录一次
                $temp["paper_id"] = $row["id"]; //试卷编号id
                $temp["title"] = $row["title"]; //试卷标题
                $temp["totalScore"] = $row["score"]; //总分分数
                $temp["content"] = $row["content"]; //介绍
                $temp["duration"] = $row["duration"]; //考试时长
                $response["data"]["info"][] = $temp;
            }
        } else {
            $response["data"]["info"] = array();
        }
    } else {
        $response["code"] = '500';
        $response['msg'] = "试卷信息查询失败";
        $response['data']['status'] = 0;
    }
    mysqli_close($conn);
    return json_encode($response, JSON_UNESCAPED_UNICODE);
}
