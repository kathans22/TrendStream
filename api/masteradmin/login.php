<?php

session_start();

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Methods: DELETE');
header('Access-Control-Allow-Methods: PUT');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

$data = json_decode(file_get_contents("php://input"),true);

$fkey = $data['key'];


function mlogin($data)
{
    $muname = $data['muname'];

    $mpass = $data['mpass'];

    if($muname == "Master_Admin" && $mpass == "Master_Admin@12345")
    {

        $_SESSION['blogsee_muname'] = 'Master_Admin';

        $_SESSION['blogsee_mpass'] = 'Master_Admin@12345';

        echo json_encode(array('message' => 'Master Admin Login Successful' , 'status' => true, 'muname'=>'Master_Admin', 'mpass'=>'Master_Admin@12345'));
    }
    else
    {
        echo json_encode(array('message' => 'Enter Corrected Credentials' , 'status' => false));
    }

}

function mlogout()
{
    unset($_SESSION["blogsee_muname"]);

    unset($_SESSION["blogsee_mpass"]);

    session_unset();

    session_destroy();

    if(!isset($_SESSION["blogsee_muname"]) && !isset($_SESSION["blogsee_mpass"]))
    {
        echo json_encode(array('message' => 'Master Admin Logout Successful' , 'status' => true));
    }
    else
    {
        echo json_encode(array('message' => 'Error in logout' , 'status' => false));
    }
}

function checkmlogin()
{
    if(isset($_SESSION["blogsee_muname"]) && isset($_SESSION["blogsee_mpass"]))
    {
        echo json_encode(array('status' => true));
    }
    else
    {
        echo json_encode(array('status' => false));
    }
}


if($fkey == "mlogin")
{
    mlogin($data);
}
elseif($fkey == "checkmlogin")
{
    checkmlogin();
}
elseif($fkey == "mlogout")
{
    mlogout();
}
else
{
    echo json_encode(array('message' => 'Error in sending master admin login-logout Api key' , 'status' => false));
}

?>