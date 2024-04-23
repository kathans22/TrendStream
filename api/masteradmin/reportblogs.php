<?php

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Methods: DELETE');
header('Access-Control-Allow-Methods: PUT');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');


// SELECT r.reason, count(*) from reports r,blogs b where r.report_type_id = b.blog_id AND r.report_type = 'blog' and b.blog_id = 27 GROUP by r.reason 

$data = json_decode(file_get_contents("php://input"),true);

$fkey = $data['key'];

include "config.php";

function display_user_report($conn)
{
    $sql = "select r.*,u.username as 'reported username',u.usid as 'reported usid',u1.username as 'reported by username'  from users u, users u1, reports r where u.usid = r.report_type_id and r.report_type = 'user' and u1.usid = r.usid" or die("sql failed");

    $result = mysqli_query($conn,$sql);
    
    $result1 =  mysqli_fetch_all($result,MYSQLI_ASSOC);

    if($result)
    {
        echo json_encode(array('message'=>'Displaying Users Report','status'=>true,'reportedusersdata'=> $result1, 'k1'=>'userreportdisplay'));
    }
    else
    {
        echo json_encode(array('message'=>'Error In Displaying Users Report Details Or Else No Record Found','status'=>false));   
    }
}

function display_blog_report($conn)
{

    $sql = "select r.*,b.*,u1.username as 'reported by' from users u,users u1, blogs b, reports r where u.usid = r.usid and b.blog_id = r.report_type_id and r.report_type = 'blog' and b.usid = u1.usid" or die("sql failed");

    $result = mysqli_query($conn,$sql);
    
    $result1 =  mysqli_fetch_all($result,MYSQLI_ASSOC);

    if($result)
    {
        echo json_encode(array('message'=>'Displaying Blogs Report','status'=>true,'reportedblogdata'=> $result1, 'k1'=>'blogreportdisplay'));
    }
    else
    {
        echo json_encode(array('message'=>'Error In Displaying Blogs Report Details Or Else No Record Found','status'=>false));   
    }
}


function delete_user_report($data,$conn)
{

    $usid = $data['usid'];
    
    //$report_id = $data['report_id'];

    $sql = "delete from users where usid = '$usid'" or die("sql failed");

    $result = mysqli_query($conn,$sql);

    if($result)
    {
        //$sql = "delete from reports where report_id = '$report_id'" or die("sql failed");
        $sql1 = "delete from reports where report_type_id = '$usid' and report_type = 'user'" or die("sql failed");
        
        $result1 = mysqli_query($conn,$sql1);

        if($result1)
        {
            echo json_encode(array('message'=>'Report User Deleted','status'=>true, 'k1'=>'userdelete'));
        }
        else
        {
            echo json_encode(array('message'=>'Error In Deleting the Reported User','status'=>false, 'k2'=>'nodeletion1'));
        }
    }
    else
    {
        echo json_encode(array('message'=>'Error In Deletion Of Reported User','status'=>false, 'k2'=>'nodeletion2'));
    }
}

function delete_blog_report($data,$conn)
{

    $blog_id = $data['blog_id'];
    
    //$report_id = $data['report_id']; 

    $sql = "UPDATE blogs b set b.blog_status = 'deleted' where b.blog_id = '$blog_id'" or die("sql failed");

    $result = mysqli_query($conn,$sql);

    if($result)
    {
        //$sql = "delete from reports where report_id = '$report_id'" or die("sql failed");
        $sql1 = "UPDATE reports r set r.report_type = 'blogdeleted' where b.blog_id = '$blog_id'" or die("sql failed");

        $result1 = mysqli_query($conn,$sql1);

        if($result1)
        {
            echo json_encode(array('message'=>'Report Blog Deleted','status'=>true, 'k1'=>'blogdelete'));
        }
        else
        {
            echo json_encode(array('message'=>'Error In Deleting the Reported Blog','status'=>false, 'k2'=>'nodeletion2'));
        }
    }
    else
    {
        echo json_encode(array('message'=>'Error In Deletion Of Reported Blog','status'=>false, 'k3'=>'nodeletion1'));
    }
}


if($fkey == "display_user_report")
{
    display_user_report($conn);
}
elseif($fkey == "display_blog_report")
{
    display_blog_report($conn);
}
elseif($fkey == "delete_user_report")
{
    delete_user_report($data,$conn);
}
elseif($fkey == "delete_blog_report")
{
    delete_blog_report($data,$conn);
}
else
{
    echo json_encode(array('message' => 'Error in sending Categorymaster Api key' , 'status' => false));
}

?>