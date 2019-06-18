<?php
session_start();
if(isset($_SESSION['name'])) 
{
    $_SESSION=array();
    if( isset($_COOKIE[session_name()]))
    {
        setCookie(session_name(),'',time()-3600,'/');
    }
    session_destroy();
}

$data = array('status'=>'1');
echo json_encode($data);
?>

