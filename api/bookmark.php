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

include "./config.php";


//save blog or readlater blog
function bh($data,$conn)
{

    $usid = $_SESSION['buid'];

    $blog_id = $data['blog_id'];

    $word = $data['word'];

    $pos = $data['pos'];

    $type = $data['type']; //bh

    $sql = "select * from bookmarktb where blog_id = '$blog_id' and usid = '$usid' and type = '$type'" or die("query failed");


    $result = mysqli_query($conn,$sql) or die("query failed");

    if(mysqli_num_rows($result) > 0 && $type = 'bookmark')
    {
	    $sqlu = "update bookmarktb set word = '$word', pos = '$pos' where usid = '$usid' and blog_id = '$blog_id' and type = '$type'";

        $resultu = mysqli_query($conn,$sqlu);

        if($resultu)
        {
            echo json_encode(array('message'=>$type.' Updated','status'=>true,'k1'=>'update'));
        }
        else
        {
            echo json_encode(array('message'=>$type.' Not Updated','status'=>false));
        } 
    
    }
    else
    {
        $sqli = "insert into bookmarktb(usid,blog_id,word,pos,type) values('$usid','$blog_id','$word','$pos','$type')" or die("query failed");

        $resulti = mysqli_query($conn,$sqli);

        if($resulti)
        {
            echo json_encode(array('message'=>$type.' Inserted','status'=>true,'k1'=>'insert'));
        }
        else
        {
            echo json_encode(array('message'=>$type.' Not Inserted','status'=>false));
        }
    }

    // $result1 = mysqli_fetch_all($result,MYSQLI_ASSOC);

    // if($result)
    // {
    //     echo json_encode(array('message'=>'Reading a Blog','status'=>true,'all'=> $result1,'k1'=>'all data'));

    // }
    // else
    // {
    //     echo json_encode(array('message' => 'No Treding Blogs Found.' , 'status' => false));
    // }
}

function deletedh($data,$conn)
{

    $usid = $_SESSION['buid'];

    $blog_id = $data['blog_id'];

    // $sql = "select Word from bookmarktb "
    $sql = "delete from bookmarktb where usid = '$usid' and blog_id = '$blog_id'" or die("query failed");

    $result = mysqli_query($conn,$sql);

    if($result)
    {
        echo json_encode(array('message'=>'Deleted','status'=>true));

    }
    else
    {
        echo json_encode(array('message'=>'Not Deleted','status'=>false));
    }


}

function get_bookmark($data,$conn)
{
    $usid = $_SESSION['buid'];

    $blog_id = $data['blog_id'];

    $type = $data['type']; 
    

    $sql = "select * from bookmarktb where usid = '$usid' and blog_id = '$blog_id' and type = 'bookmark'" or die("query failed");

    $result = mysqli_query($conn,$sql);
    $result1 =  mysqli_fetch_all($result,MYSQLI_ASSOC);
    
    if($result)
    {
        echo json_encode(array('message'=>'Displaying Bookmark','status'=>true,'bdata'=> $result1,'k1'=>'displaybookmark'));
    }
    else
    {
        echo json_encode(array('message'=>'Error In Displaying Bookmark Details Or Else No Record Found','status'=>false));   
    }

}

function get_highlight($data,$conn)
{
    $usid = $data['usid'];

    $blog_id = $data['blog_id'];

    $type = $data['type']; 
    

    $sql = "select * from bookmarktb where usid = '$usid' and blog_id = '$blog_id' and type = 'highlight'" or die("query failed");

    $result = mysqli_query($conn,$sql);
    $result1 =  mysqli_fetch_all($result,MYSQLI_ASSOC);
    
    if($result)
    {
        echo json_encode(array('message'=>'Displaying Highlight','status'=>true,'bdata'=> $result1,'k1'=>'displaybookmark'));
    }
    else
    {
        echo json_encode(array('message'=>'Error In Displaying Highlight Details Or Else No Record Found','status'=>false));   
    }
}

if($fkey == "bookmark_delete")
{
    deletedh($data,$conn);
}
elseif($fkey == "get_boomark")
{
    get_bookmark($data,$conn);
}
elseif($fkey == "get_highlight")
{
    get_highlight($data,$conn);
}
elseif($fkey == "bookmark")
{
    bh($data,$conn);
}
else
{
    echo json_encode(array('message' => 'Error in sending bh Api key' , 'status' => false));
}


?>