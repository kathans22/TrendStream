<?php
//session_start();

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
//header('Access-Control-Allow-Methods: DELETE');
//header('Access-Control-Allow-Methods: PUT');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');


$data = json_decode(file_get_contents("php://input"),true);

$fkey = $data['key'];

include "./config.php";

//save blog or readlater blog
function user_update($data,$conn)
{
    $usid = $data['usid'];
    $ufname = $data['ufname'];
    $ulname = $data['ulname'];
    $email = $data['email'];
    $username = $data['username'];
    $mbno = $data['mbno'];
    $password = $data['password'];
    $photo = $data['photo'];
    $onlinestatus = $data['onlinestatus'];
    $birthdate = $data['birthdate'];
    $gender = $data['gender'];
    $location_js = $data['location_js'];
    $user_type = $data['user_type'];
    
    $sql = "update users set ufname = '$ufname', ulname = '$ulname',email = '$email', username = '$username', mbno = '$mbno', password = '$password', photo = '$photo', onlinestatus = '$onlinestatus',birthdate = '$birthdate', gender = '$gender', location_js = '$location_js', user_type = '$user_type' where usid = '$usid'" or die("sql failed");

    $result = mysqli_query($conn,$sql) or die("query failed");

    if($result)
    {
        echo json_encode(array('message' => 'Information Updated Successfully.' , 'status' =>1));
    }
    else
    {
        echo json_encode(array('message' => 'Error In Updating The Information.' , 'status' =>0));
    }
}
// user deletion baaki discuss karvanu chhe ke delete karvanu ke pachi status updatr karvanu delete mate user nu
if($fkey == "user_update")
{
    user_update($data,$conn);
}
else
{
    echo json_encode(array('message' => 'Error in sending users Api key' , 'status' => false));
}


?>