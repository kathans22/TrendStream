<?php
session_start();

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
function report($data,$conn)
{
    // $usid = $data['usid'];
    $usid = $_SESSION['buid'];
    $report_type = $data['report_type'];
    $report_type_id = $data['report_type_id'];
    $reason = $data['reason'];


    $sql = "";

    if($report_type == "user")
    {
        $sql = "insert into reports(usid,report_type,report_type_id,reason) values('$usid','$report_type','$report_type_id','$reason')" or die("sql failed");

    }
    else
    {
        $sql = "insert into reports(usid,report_type,report_type_id,reason) values('$usid','$report_type','$report_type_id','$reason')" or die("sql failed");
    }

    $result = mysqli_query($conn,$sql) or die("query failed");

    if($result)
    {
        echo json_encode(array('message' => $report_type.' Reported Successfully.' , 'status' =>true));
    }
    else
    {
        echo json_encode(array('message' => 'Error In Reporting A '.$report_type.'.' , 'status' =>false));
    }
}

//report na trigger baaki chhe jene automatically delete karvana chhe database mathi


if($fkey == "reporting")
{
    report($data,$conn);
}
else
{
    echo json_encode(array('message' => 'Error in sending report Api key' , 'status' => false));
}


?>