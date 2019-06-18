<?php
// 输出全部科目id、科目name
function allsubject($conn)
{
    global $response;
    $sql = "SELECT * FROM `subject`";
    $res = mysqli_query($conn, $sql);
    if ($res) {
        $response['code'] = 200;
        $response['msg'] = "数据库查询成功";
        $response['data']['status'] = 1;
        $response['data']['subject'] = array();
        $i = 0;
        while ($row = mysqli_fetch_assoc($res)) {
            $response['data']['subject'][$i]['id'] = intval($row['id']);
            $response['data']['subject'][$i]['name'] = $row['name'];
            $i++;
        }
        mysqli_close($conn);
        return json_encode($response, JSON_UNESCAPED_UNICODE);
    } else {
        $response['code'] = 500;
        $response['msg'] = "数据库查询失败";
        $response['data']['status'] = 0;
        mysqli_close($conn);
        return json_encode($response, JSON_UNESCAPED_UNICODE);
    }
}

//根据科目id，输出此科目的全部试卷
function choiceSubjectPaper($conn, $subject_id)
{
    global $response;
    $subject_id = mysqli_real_escape_string($conn, $subject_id);

    $sql = "SELECT `id`,`title`,`content`,`radio`,`multiple`,`judgement`,`duration`,`total_score` AS `score`,`time`
            FROM `test_paper` WHERE subject_id='$subject_id'";
    $res = mysqli_query($conn, $sql);
    if ($res) {
        $response['code'] = 200;
        $response['msg'] = "数据库查询成功";
        $response['data']['status'] = 1;
        $response['data']['paper'] = array();
        $i = 0;
        while ($row = mysqli_fetch_assoc($res)) {
            $response['data']['paper'][$i]['id'] = intval($row['id']);
            $response['data']['paper'][$i]['title'] = $row['title'];
            $response['data']['paper'][$i]['content'] = $row['content'];
            $response['data']['paper'][$i]['sum'] = intval($row['radio']) + intval($row['multiple']) + intval($row['judgement']);
            $response['data']['paper'][$i]['score'] = intval($row['score']);
            $response['data']['paper'][$i]['duration'] = intval($row['duration']);
            $response['data']['paper'][$i]['time'] = $row['time'];
            $i++;
        }
        mysqli_close($conn);
        return json_encode($response, JSON_UNESCAPED_UNICODE);
    } else {
        $response['code'] = 500;
        $response['msg'] = "数据库查询失败";
        $response['data']['status'] = 0;
        mysqli_close($conn);
        return json_encode($response, JSON_UNESCAPED_UNICODE);
    }
}
