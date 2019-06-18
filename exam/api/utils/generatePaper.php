<?php
/** 
 * $paper_id: 试卷id
 * 
 * 功能：根据试卷id，输出此试卷的全部题目
 */
function generatePaper($conn, $paper_id)
{
    global $response;
    //单选题
    $paper_id = mysqli_real_escape_string($conn,$paper_id);
    
    $sql = "SELECT id,content,true_answer,score,a,b,c,d,analysis
            FROM `test_questions` WHERE paper_ID='$paper_id' AND type='单选题' ORDER BY paper_order";
    $res1 = mysqli_query($conn, $sql);
    //多选题
    $sql = "SELECT id,content,true_answer,score,a,b,c,d,analysis
            FROM `test_questions` WHERE paper_ID='$paper_id' AND type='多选题' ORDER BY paper_order";
    $res2 = mysqli_query($conn, $sql);
    // 判断题
    $sql = "SELECT id,content,true_answer,score,analysis
            FROM `test_questions` WHERE paper_ID='$paper_id' AND type='判断题' ORDER BY paper_order";
    $res3 = mysqli_query($conn, $sql);

    if (!$res1 || !$res2 || !$res3) {
        $response['code'] = 500;
        if (!$res1) {
            $response['msg'] = "获取单选题失败";
        } else if (!$res2) {
            $response['msg'] = "获取多选题失败";
        } else {
            $response['msg'] = "获取判断题失败";
        }
        $response['data']['status'] = 0;

        mysqli_close($conn);
        return json_encode($response, JSON_UNESCAPED_UNICODE);
    } else {
        $response['code'] = 200;
        $response['msg'] = "试题获取成功";
        $response['data']['status'] = 1;
        $response['data']['paper-id'] = intval($paper_id);
        generatePaper_data($res1, 'radio');
        generatePaper_data($res2, 'multiple');
        generatePaper_data($res3, 'judge');

        mysqli_close($conn);
        return json_encode($response, JSON_UNESCAPED_UNICODE);
        // return $_SESSION["TRUE_RADIO"];
    }
}

function generatePaper_data($res, $type)
{
    global $response;
    $stroage_question = array("radio" => array(), "multiple" => array(), "judge" => array());
    switch ($type) {
        case 'radio':
            if (mysqli_num_rows($res) > 0) {
                $i = 0;
                while ($row = mysqli_fetch_assoc($res)) {
                    $response['data'][$type][$i]['id'] = intval($row['id']);
                    $response['data'][$type][$i]['content'] = $row['content'];
                    $response['data'][$type][$i]['score'] = intval($row['score']);
                    $response['data'][$type][$i]['a'] = $row['a'];
                    $response['data'][$type][$i]['b'] = $row['b'];
                    $response['data'][$type][$i]['c'] = $row['c'];
                    $response['data'][$type][$i]['d'] = $row['d'];

                    $stroage_question["radio"][$i]['id'] = intval($row['id']);
                    $stroage_question["radio"][$i]['true_answer'] = $row['true_answer'];
                    $stroage_question["radio"][$i]['score'] = intval($row['score']);
                    $stroage_question["radio"][$i]['analysis'] = $row['analysis'];
                    $i++;
                }
            } else {
                $response['data'][$type] = array();
            }
            $_SESSION["TRUE_RADIO"] = $stroage_question["radio"];
            break;
        case "multiple":
            if (mysqli_num_rows($res) > 0) {
                $i = 0;
                while ($row = mysqli_fetch_assoc($res)) {
                    $response['data'][$type][$i]['id'] = intval($row['id']);
                    $response['data'][$type][$i]['content'] = $row['content'];
                    $response['data'][$type][$i]['score'] = intval($row['score']);
                    $response['data'][$type][$i]['a'] = $row['a'];
                    $response['data'][$type][$i]['b'] = $row['b'];
                    $response['data'][$type][$i]['c'] = $row['c'];
                    $response['data'][$type][$i]['d'] = $row['d'];

                    $stroage_question["multiple"][$i]['id'] = intval($row['id']);
                    $stroage_question["multiple"][$i]['true_answer'] = $row['true_answer'];
                    $stroage_question["multiple"][$i]['score'] = intval($row['score']);
                    $stroage_question["multiple"][$i]['analysis'] = $row['analysis'];
                    $i++;
                }
            } else {
                $response['data'][$type] = array();
            }
            $_SESSION["TRUE_MULTIPLE"] = $stroage_question["multiple"];
            break;
        case "judge":
            if (mysqli_num_rows($res) > 0) {
                $i = 0;
                while ($row = mysqli_fetch_assoc($res)) {
                    $response['data'][$type][$i]['id'] = intval($row['id']);
                    $response['data'][$type][$i]['content'] = $row['content'];
                    $response['data'][$type][$i]['score'] = intval($row['score']);

                    $stroage_question["judge"][$i]['id'] = intval($row['id']);
                    $stroage_question["judge"][$i]['true_answer'] = $row['true_answer'];
                    $stroage_question["judge"][$i]['score'] = intval($row['score']);
                    $stroage_question["judge"][$i]['analysis'] = $row['analysis'];
                    
                    $i++;
                }
            } else {
                $response['data'][$type] = array();
            }
            $_SESSION["TRUE_JUDGE"] = $stroage_question["judge"];
            break;
    }
}
