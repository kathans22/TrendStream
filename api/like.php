<?php
session_start();

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
//header('Access-Control-Allow-Methods: DELETE');
//header('Access-Control-Allow-Methods: PUT');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');


$data = json_decode(file_get_contents("php://input"), true);

$fkey = $data['fkey'];

include "./config.php";


//usid lese jene notification mokalvano chhe      
function getusid($blog_id, $conn)
{
    $sql_fetch_blog_usid = "select usid from blogs where blog_id = '$blog_id'";

    $result_fetch_blog_usid = mysqli_query($conn, $sql_fetch_blog_usid) or die("query for fetching id failed");

    $rows_fetch_blog_usid = mysqli_fetch_assoc($result_fetch_blog_usid);

    return $rows_fetch_blog_usid['usid'];
}

//like lese jyaa like thayu chhe
function getlikeid($sql, $conn)
{
    $sqlfetchid = $sql;

    $resultfetchid = mysqli_query($conn, $sqlfetchid) or die("query for fetching id failed");

    $rows = mysqli_fetch_assoc($resultfetchid);

    return $rows["blog_like_id"];
}

function gettotallike($conn, $blog_id)
{

    $sql = "select b.blog_id,(select count(*) from blog_likes bl where bl.blog_id = b.blog_id and bl.status_like_dislike = 'like') as likes 
            from blogs b where b.blog_id = $blog_id";
    $result = mysqli_query($conn, $sql) or die("error");

    $result = mysqli_fetch_all($result, MYSQLI_ASSOC);
    return $result;
}
function blog_like_insert($data, $conn)
{
    $blog_id = $data['blog_id'];
    // $usid = $data['usid'];
    $usid = $_SESSION['buid'];

    // echo json_encode(array('blogid' => $blog_id , 'userid' => $usid));  

    $sql = "select * from blog_likes where usid = '$usid' and blog_id = '$blog_id' and status_like_dislike = 'like'" or die("sql query failed");

    $result = mysqli_query($conn, $sql) or die("query failed");

    //---------------------------------------------------------------------------------------------------------------------------------------------------------

    $sql1 = "select * from blog_likes where usid = '$usid' and blog_id = '$blog_id' and status_like_dislike = 'dislike'" or die("sql query failed");

    $result1 = mysqli_query($conn, $sql1) or die("query failed");


    // //-----------------------------------------------------------------------------------------------------------------------------------------------------------
    // //-----------------------------------------------------------------------------------------------------------------------------------------------------------
    // //-----------------------------------------------------------------------------------------------------------------------------------------------------------
    // //-----------------------------------------------------------------------------------------------------------------------------------------------------------


    if (mysqli_num_rows($result) > 0) {
        // $sqldislike = "update blog_likes set status_like_dislike = 'dislike' where usid = '$usid' and blog_id = '$blog_id'" or die("sql update failed");
        $sqldislike = "update blog_likes set status_like_dislike = 'dislike', time = current_timestamp where usid = '$usid' and blog_id = '$blog_id'" or die("sql update failed");
        $resultdislike = mysqli_query($conn, $sqldislike) or die("query update failed");

        if ($resultdislike) {
            $result12 = gettotallike($conn, $blog_id);

            echo json_encode(array('message' => 'Blog DisLiked.', 'status' => 'disliked', "likes" => $result12));
            //------------------------------------------------------------------------------------------------------------------------

            $blog_like_id = getlikeid($sql1, $conn); // aatle dislike thai gayu chhe etle dislike wali id mokal vani chhe

            //--------------------------------------------------------------------------------------------------------------------------------------

            $sqlnotification_del = "delete from notifications where notify_type = 'like' and notify_type_id = '$blog_like_id'";

            $resultnotify_del = mysqli_query($conn, $sqlnotification_del) or die("query for notification failed");

            // if($resultnotify_del)
            // {
            //     //echo json_encode(array('message' => 'Blog DisLiked.' , 'status' => 1));
            //     echo json_encode(array('message' => 'Notifcation Deleted.' , 'status' => 1));
            // }
            // else
            // {
            //     echo json_encode(array('message' => 'Error In Sending Notifcations.' , 'status' => 0));
            // }

        } else {
            echo json_encode(array('message' => 'Error in DisLiking a Blog.', 'status' => 0));
        }
    } else if (mysqli_num_rows($result1) > 0) {
        // $sqllike = "update blog_likes set status_like_dislike = 'like' where usid = '$usid' and blog_id = '$blog_id'" or die("sql update failed");
        $sqllike = "update blog_likes set status_like_dislike = 'like', time = current_timestamp where usid = '$usid' and blog_id = '$blog_id'" or die("sql update failed");
        $resultlike = mysqli_query($conn, $sqllike) or die("query update failed");

        if ($resultlike) {

            $result1 = gettotallike($conn, $blog_id);
            echo json_encode(array('message' => 'Blog Liked else.', 'status' => 'liked', "likes" => $result1));
            // echo json_encode(array('message' => 'Blog Liked else if.' , 'status' => 'liked'));


            //-----------------------------------------------------------------------------------------
            $blog_usid = getusid($blog_id, $conn);

            //---------------------------------------------------------- part one

            //------------------------------------------------------------------------------------------------------------------------

            $blog_like_id = getlikeid($sql, $conn); // aatle like thai gayu chhe etle like wali id mokal vani chhe

            //--------------------------------------------------------------------------------------------------------------------------------------

            //select * from blog_likes where usid = '$usid' and blog_id = '$blog_id' and status_like_dislike = 'like'" or die("sql query failed")

            $sqlnotification = "insert into notifications(usid, notify_type, notify_type_id) values('$blog_usid','like','$blog_like_id')";

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
            echo json_encode(array('message' => 'Error in Liking a Blog.', 'status' => 0));
        }
    } else {
        $status_like_dislike = 'like';

        $sqlinsertlike = "insert into blog_likes(blog_id,usid,status_like_dislike) values('$blog_id','$usid','$status_like_dislike')";

        $resultinsertlike = mysqli_query($conn, $sqlinsertlike) or die("query failed");

        if ($resultinsertlike) {
            $result1 = gettotallike($conn, $blog_id);
            echo json_encode(array('message' => 'Blog Liked else.', 'status' => 'liked', "likes" => $result1));

            //-----------------------------------------------------------------------------------------
            $blog_usid = getusid($blog_id, $conn);

            //---------------------------------------------------------- part one

            //------------------------------------------------------------------------------------------------------------------------

            $blog_like_id = getlikeid($sql, $conn); // aatle like thai gayu chhe etle like wali id mokal vani chhe

            //--------------------------------------------------------------------------------------------------------------------------------------

            //select * from blog_likes where usid = '$usid' and blog_id = '$blog_id' and status_like_dislike = 'like'" or die("sql query failed")

            $sqlnotification = "insert into notifications(usid, notify_type, notify_type_id) values('$blog_usid','like','$blog_like_id')";

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
            echo json_encode(array('message' => 'Error in Liking a Blog.', 'status' => 0));
        }
    }
}

//usid thi, user like karela blogs dsiplay karse.
function user_blog_likes($data, $conn)
{
    //id leva mate 'as' alias use karje.

    $usid = $data['usid'];
    $sql = "select b.,l. from blogs b, blog_likes l where b.blog_id = l.blog_id and  l.usid = '$usid' and l.status_like_dislike = 'like'" or die("sql failed");

    $result1 = mysqli_query($conn, $sql) or die("query failed");

    $result = mysqli_fetch_all($result1, MYSQLI_ASSOC);

    if ($result1) {
        echo json_encode(array('message' => 'Displaying Users Liked Blog', 'status' => '1', 'likedblogdata' => $result));
    } else {
        echo json_encode(array('message' => 'Please Like Some Blogs', 'status' => 0));

    }
}


if ($fkey == "blog_like_insert") {
    blog_like_insert($data, $conn);
} elseif ($fkey == "user_blog_likes") {
    user_blog_likes($data, $conn);
} else {
    echo json_encode(array('message' => 'Error in sending Like Api key', 'status' => false));
}


?>