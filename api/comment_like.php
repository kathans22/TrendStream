<?php
session_start();

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
//header('Access-Control-Allow-Methods: DELETE');
//header('Access-Control-Allow-Methods: PUT');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');


$data = json_decode(file_get_contents("php://input"), true);

$fkey = $data['key'];

include "./config.php";


function getusid($blog_comment_id, $conn)
{
    $sql_fetch_comment_usid = "select usid from blog_comments where blog_comment_id = '$blog_comment_id'";

    $result_fetch_comment_usid = mysqli_query($conn, $sql_fetch_comment_usid) or die("query for fetching id failed");

    $rows_fetch_blog_usid = mysqli_fetch_assoc($result_fetch_comment_usid);

    return $rows_fetch_blog_usid['usid'];
}

function get_type($blog_comment_id, $conn)
{
    $type = "";

    $sql_fetch_comment_usid = "select parent_comment_id from blog_comments where blog_comment_id = '$blog_comment_id'";

    $result_fetch_comment_usid = mysqli_query($conn, $sql_fetch_comment_usid) or die("query for fetching id failed");

    $rows_fetch_blog_usid = mysqli_fetch_assoc($result_fetch_comment_usid);

    $parent_comment_id = $rows_fetch_blog_usid['parent_comment_id'];

    if ($parent_comment_id == 0) {
        //$type = "cliked";
        $type = "clike";
    } else {
        //$type = "rliked";

        $type = "rlike";
    }

    return $type;
}


function getcommentid($sql, $conn)
{
    $sqlfetchid = $sql;

    $resultfetchid = mysqli_query($conn, $sqlfetchid) or die("query for fetching id failed");

    $rows = mysqli_fetch_assoc($resultfetchid);

    return $rows["blog_comment_like_id"];
}





function comment_like_insert($data, $conn)
{
    $blog_comment_id = $data['blog_comment_id'];
    // $usid = $data['usid'];
    $blog_id = $data['blog_id'];
    $usid = $_SESSION['buid'];

    //change clike to like //clike use for testing purpose

    $sql = "select * from blog_comment_like_tb where usid = '$usid' and blog_id = '$blog_id' and blog_comment_id = '$blog_comment_id' and status_clike = 'clike'" or die("sql query failed");

    $result = mysqli_query($conn, $sql) or die("query failed");

    //---------------------------------------------------------------------------------------------------------------------------------------------------------

    $sql1 = "select * from blog_comment_like_tb where usid = '$usid' and blog_id = '$blog_id' and blog_comment_id = '$blog_comment_id' and status_clike = 'cdislike'" or die("sql query failed");

    $result1 = mysqli_query($conn, $sql1) or die("query failed");


    //-----------------------------------------------------------------------------------------------------------------------------------------------------------
    //-----------------------------------------------------------------------------------------------------------------------------------------------------------
    //-----------------------------------------------------------------------------------------------------------------------------------------------------------
    //-----------------------------------------------------------------------------------------------------------------------------------------------------------


    if (mysqli_num_rows($result) > 0) {
        $sqldislike = "update blog_comment_like_tb set status_clike = 'cdislike' where usid = '$usid' and blog_id = '$blog_id' and blog_comment_id = '$blog_comment_id'" or die("sql update failed");

        $resultdislike = mysqli_query($conn, $sqldislike) or die("query update failed");

        if ($resultdislike) {
            // $sql = "select count(*) as 'likes' from blog_comment_like_tb where blog_comment_id = '$blog_comment_id'";

            $sql12 = "select count(*) as likes from blog_comment_like_tb where blog_comment_id = '$blog_comment_id' and status_clike = 'clike'";
            $result12 = mysqli_query($conn, $sql12) or die("query update failed");
            // $row = mysqli_fetch_assoc($result);
            $row = mysqli_fetch_all($result12,MYSQLI_ASSOC);

            // $likes = $row['likes'];
            echo json_encode(array('message' => 'Comment DisLiked.', 'status' => 'disliked', 'likes' => $row));
            //------------------------------------------------------------------------------------------------------------------------

            $blog_comment_like_id = getcommentid($sql1, $conn);

            //--------------------------------------------------------------------------------------------------------------------------------------

            $sqlnotification_del = "delete from notifications where (notify_type = 'clike' or notify_type = 'rlike') and notify_type_id = '$blog_comment_like_id'";

            $resultnotify_del = mysqli_query($conn, $sqlnotification_del) or die("query for notification failed");

            // if($resultnotify_del)
            // {
            //     echo json_encode(array('message' => 'Notifcation Deleted.' , 'status' => 1));
            // }
            // else
            // {
            //     echo json_encode(array('message' => 'Error In Sending Notifcations.' , 'status' => 0));
            // }
        } else {
            echo json_encode(array('message' => 'Error in DisLiking a Comment.', 'status' => 0));
        }
    } else if (mysqli_num_rows($result1) > 0) {
        $sqllike = "update blog_comment_like_tb set status_clike = 'clike' where usid = '$usid' and blog_id = '$blog_id' and blog_comment_id = '$blog_comment_id'" or die("sql update failed");

        $resultlike = mysqli_query($conn, $sqllike) or die("query update failed");

        if ($resultlike) {
            // $sql = "select count(*) as 'likes' from blog_comment_like_tb where blog_comment_id = '$blog_comment_id'";

            $sql12 = "select count(*) as likes from blog_comment_like_tb where blog_comment_id = '$blog_comment_id' and status_clike = 'clike'";
            $result12 = mysqli_query($conn, $sql12) or die("query update failed");
            // $row = mysqli_fetch_assoc($result);
            $row = mysqli_fetch_all($result12,MYSQLI_ASSOC);
            

            // $likes = $row['likes'];
            echo json_encode(array('message' => 'Comment Liked else if.', 'status' => 'liked', 'likes' => $row));

            //-----------------------------------------------------------------------------------------
            $comment_usid = getusid($blog_comment_id, $conn);
            //---------------------------------------------------------------------------
            $type = get_type($blog_comment_id, $conn);
            //--------------------------------------------------------------------------
            //---------------------------------------------------------- part one

            //------------------------------------------------------------------------------------------------------------------------

            $blog_comment_like_id = getcommentid($sql, $conn);

            //--------------------------------------------------------------------------------------------------------------------------------------


            $sqlnotification = "insert into notifications(usid, notify_type, notify_type_id) values('$comment_usid','$type','$blog_comment_like_id')";

            $resultnotify = mysqli_query($conn, $sqlnotification) or die("query for notification failed");

            // if($resultnotify)
            // {
            //     echo json_encode(array('message' => 'Notifcation Sended.' , 'status' => 1));
            // }
            // else
            // {
            //     echo json_encode(array('message' => 'Error In Sending Notifcations.' , 'status' => 0));
            // }
        } else {
            echo json_encode(array('message' => 'Error in Liking a Comment.', 'status' => 0));
        }
    } else {
        $status_like_dislike = 'clike';

        $sqlinsertlike = "insert into blog_comment_like_tb(blog_comment_id,blog_id,usid,status_clike) values('$blog_comment_id','$blog_id','$usid','$status_like_dislike')";

        $resultinsertlike = mysqli_query($conn, $sqlinsertlike) or die("query failed");

        if ($resultinsertlike) {
            $sql12 = "select count(*) as 'likes' from blog_comment_like_tb where blog_comment_id = '$blog_comment_id' and status_clike = 'clike' ";
            $result12 = mysqli_query($conn, $sql12) or die("query update failed");
            $row = mysqli_fetch_all($result12,MYSQLI_ASSOC);
            
            echo json_encode(array('message' => 'Comment Liked else.', 'status' => 'liked',  'likes' => $row));

            //-----------------------------------------------------------------------------------------
            $comment_usid = getusid($blog_comment_id, $conn);

            //---------------------------------------------------------------------------
            $type = get_type($blog_comment_id, $conn);
            //--------------------------------------------------------------------------

            //---------------------------------------------------------- part one

            //------------------------------------------------------------------------------------------------------------------------

            $blog_comment_like_id = getcommentid($sql, $conn);

            //--------------------------------------------------------------------------------------------------------------------------------------


            $sqlnotification = "insert into notifications(usid, notify_type, notify_type_id) values('$comment_usid','$type','$blog_comment_like_id')";

            $resultnotify = mysqli_query($conn, $sqlnotification) or die("query for notification failed");

            // if($resultnotify)
            // {
            //     echo json_encode(array('message' => 'Notifcation Sended.' , 'status' => 1));
            // }
            // else
            // {
            //     echo json_encode(array('message' => 'Error In Sending Notifcations.' , 'status' => 0));
            // }
        } else {
            echo json_encode(array('message' => 'Error in Liking a Comment.', 'status' => 0));
        }
    }
}


if ($fkey == "comment_like_insert") {
    comment_like_insert($data, $conn);
} else {
    echo json_encode(array('message' => 'Error in sending Comment Like Api key', 'status' => false));
}


?>