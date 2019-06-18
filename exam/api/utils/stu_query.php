<?php
//查询学生某科目试卷分数
function stu_query_score($conn,$student_id,$subject_name){
    global $response;
    $student_id = mysqli_real_escape_string($conn,$student_id);
    $subject_name = mysqli_real_escape_string($conn,$subject_name);

    $sql ="SELECT t1.id,t1.score,t2.title,t1.time 
    FROM `stu_paper` AS t1,`test_paper` AS t2,`subject` AS t3
    WHERE t1.paper_ID=t2.id AND t2.subject_id=t3.id AND t1.student_ID='$student_id' AND t3.`name`='$subject_name' LIMIT 20";

    $res = mysqli_query($conn,$sql);
    if ($res) {
        if (mysqli_num_rows($res)>0) {
            while ($row = mysqli_fetch_assoc($res)) {
                $temp = array();
                $temp["id"] = $row["id"]; //学生考试试卷信息表编号id
                $temp["title"] = $row["title"]; //试卷标题
                $temp["score"] = $row["score"]; //学生获得分数
                $temp["time"] = $row["time"]; //学生完成时间
                $response["data"]["info"][] = $temp;
            }
        }else {
            $response["data"]["info"]= array();
        }
    } else {
        $response["code"] = '500';
        $response['msg'] = "学生分数查询失败";
        $response['data']['status'] = 0;
    }
    return json_encode($response, JSON_UNESCAPED_UNICODE);
}
// 根据考试试卷信息id，输出解析等信息
function view_parsing($conn,$id){
    $id = mysqli_real_escape_string($conn,$id);

    $sql = "SELECT answer FROM stu_paper WHERE id='$id'";

    $res = mysqli_query($conn,$sql);
    if ($res) {
        if (mysqli_num_rows($res)>0) {
            $row = mysqli_fetch_assoc($res);
            $response["data"]["info"] = json_decode($row["answer"],true) ;
            
        }else {
            $response["data"]["info"]= array();
        }
    } else {
        $response["code"] = '500';
        $response['msg'] = "学生解析查询失败";
        $response['data']['status'] = 0;
    }
    return json_encode($response, JSON_UNESCAPED_UNICODE);
}