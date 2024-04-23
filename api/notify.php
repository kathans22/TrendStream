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


//notifcations display karse aa function usid pramane
function display_notifications($conn)
{
    $usid = 0;
    if(isset($_SESSION['buid'])){
        $usid = $_SESSION['buid'];
    }
    // $sql = "select notification_id,n.usid,u1.username,blog_title,u.username,notify_type from users u, users u1, blogs b, blog_likes l, notifications n where u.usid = l.usid and u1.usid = n.usid and l.blog_like_id = n.notify_type_id and b.blog_id = l.blog_id and notify_type = 'like' and n.usid = '$usid'
    // UNION
    // select notification_id,n.usid,u1.username,blog_title,u.username,notify_type from users u, users u1, blogs b, blog_comments c, notifications n where u.usid = c.usid and u1.usid = n.usid and c.blog_comment_id = n.notify_type_id and b.blog_id = c.blog_id and notify_type = 'comment' and n.usid = '$usid'
    // UNION
    // select notification_id,n.usid,u1.username,blog_title,u.username,notify_type from users u, users u1, blogs b, blog_comments c, notifications n where u.usid = c.usid and u1.usid = n.usid and c.blog_comment_id = n.notify_type_id and b.blog_id = c.blog_id and notify_type = 'reply' and n.usid = '$usid'
    // UNION
    // select notification_id,n.usid,u1.username,blog_title,u.username,notify_type from users u, users u1 ,blogs b, blog_comment_like_tb cl, notifications n where u.usid = cl.usid and u1.usid = n.usid and cl.blog_comment_like_id = n.notify_type_id and b.blog_id = cl.blog_id and n.notify_type = 'clike' and n.usid = '$usid'
    // UNION
    // select notification_id,n.usid,u1.username,blog_title,u.username,notify_type from users u, users u1 ,blogs b, blog_comment_like_tb cl, notifications n where u.usid = cl.usid and u1.usid = n.usid and cl.blog_comment_like_id = n.notify_type_id and b.blog_id = cl.blog_id and n.notify_type = 'rlike' and n.usid = '$usid'
    // ORDER by notification_id
    // " or die("sql failed");

    // $sql = "select notification_id,n.usid,u1.username as 'receiver',blog_title,u.username as 'sender',notify_type from users u, users u1, blogs b, blog_likes l, notifications n where u.usid = l.usid and u1.usid = n.usid and l.blog_like_id = n.notify_type_id and b.blog_id = l.blog_id and notify_type = 'like' and n.usid = '$usid' and status_of_seen = 'unseen'
    // UNION
    // select notification_id,n.usid,u1.username as 'receiver',blog_title,u.username as 'sender',notify_type from users u, users u1, blogs b, blog_comments c, notifications n where u.usid = c.usid and u1.usid = n.usid and c.blog_comment_id = n.notify_type_id and b.blog_id = c.blog_id and notify_type = 'comment' and n.usid = '$usid' and status_of_seen = 'unseen'
    // UNION
    // select notification_id,n.usid,u1.username as 'receiver',blog_title,u.username as 'sender',notify_type from users u, users u1, blogs b, blog_comments c, notifications n where u.usid = c.usid and u1.usid = n.usid and c.blog_comment_id = n.notify_type_id and b.blog_id = c.blog_id and notify_type = 'reply' and n.usid = '$usid' and status_of_seen = 'unseen'
    // UNION
    // select notification_id,n.usid,u1.username as 'receiver',blog_title,u.username as 'sender',notify_type from users u, users u1 ,blogs b, blog_comment_like_tb cl, notifications n where u.usid = cl.usid and u1.usid = n.usid and cl.blog_comment_like_id = n.notify_type_id and b.blog_id = cl.blog_id and n.notify_type = 'clike' and n.usid = '$usid' and status_of_seen = 'unseen'
    // UNION
    // select notification_id,n.usid,u1.username as 'receiver',blog_title,u.username as 'sender',notify_type from users u, users u1 ,blogs b, blog_comment_like_tb cl, notifications n where u.usid = cl.usid and u1.usid = n.usid and cl.blog_comment_like_id = n.notify_type_id and b.blog_id = cl.blog_id and n.notify_type = 'rlike' and n.usid = '$usid' and status_of_seen = 'unseen'
    // ORDER by notification_id" or die("sql failed");
    $sql = "SELECT b.blog_id,n.*,u.usid as e_usid,u.username as e_username,u.photo, clc.blog_comment_id as liked_comment_id,rlc.blog_comment_id AS reply_liked_comment_id,c.comment as comments,cr.comment as replycomment,clc.comment as liked_comment,rlc.comment as liked_reply_comment, u.username,b.blog_title,crc.comment as reply_p_comment,clt.status_clike
    FROM notifications n
    LEFT JOIN blog_likes l ON n.notify_type_id = l.blog_like_id AND n.notify_type = 'like'
    LEFT JOIN blog_comments c ON n.notify_type_id = c.blog_comment_id AND n.notify_type = 'comment'
    LEFT JOIN blog_comments cr ON n.notify_type_id = cr.blog_comment_id AND n.notify_type = 'reply'
    LEFT JOIN blog_comments crc ON crc.blog_comment_id = cr.parent_comment_id
    LEFT JOIN blog_comment_like_tb cl ON n.notify_type_id = cl.blog_comment_like_id AND n.notify_type = 'clike'
    LEFT JOIN blog_comment_like_tb crl ON n.notify_type_id = crl.blog_comment_like_id AND n.notify_type = 'rlike'
    LEFT JOIN blog_comments clc ON clc.blog_comment_id = cl.blog_comment_id
    LEFT JOIN blog_comments rlc ON rlc.blog_comment_id = crl.blog_comment_id
    LEFT JOIN blog_comment_like_tb clt ON clt.blog_comment_id = c.blog_comment_id or clt.blog_comment_id = cr.blog_comment_id
    LEFT JOIN users u ON l.usid = u.usid or c.usid = u.usid or cr.usid = u.usid or cl.usid = u.usid or crl.usid = u.usid
    LEFT JOIN blogs b ON b.blog_id = l.blog_id or c.blog_id = b.blog_id or cr.blog_id=b.blog_id or cl.blog_id = b.blog_id or crl.blog_id = b.blog_id
    WHERE n.usid = $usid and (n.status_of_seen in ('unseen','seen','new'))
    ORDER BY `n`.`notification_id` DESC"; 
    // SELECT n.*, l.usid AS liked_user_id, c.usid AS commented_user_id, cr.usid AS replied_user_id,cl.blog_comment_like_id as commentlikeid,crl.blog_comment_like_id as replycommentlikeid, c.comment as comments,cr.comment as replycomment, cl.blog_comment_like_id as clid, crl.blog_comment_like_id as crlid, u.username,b.blog_title
    // FROM notifications n
    // LEFT JOIN blog_likes l ON n.notify_type_id = l.blog_like_id AND n.notify_type = 'like'
    // LEFT JOIN blog_comments c ON n.notify_type_id = c.blog_comment_id AND n.notify_type = 'comment'
    // LEFT JOIN blog_comments cr ON n.notify_type_id = cr.blog_comment_id AND n.notify_type = 'reply'
    // LEFT JOIN blog_comment_like_tb cl ON n.notify_type_id = cl.blog_comment_like_id AND n.notify_type = 'clike'
    // LEFT JOIN blog_comment_like_tb crl ON n.notify_type_id = crl.blog_comment_like_id AND n.notify_type = 'rlike'
    // LEFT JOIN users u ON l.usid = u.usid or c.usid = u.usid or cr.usid = u.usid or cl.usid = u.usid or crl.usid = u.usid
    // LEFT JOIN blogs b ON b.blog_id = l.blog_id or c.blog_id = b.blog_id or cr.blog_id=b.blog_id or cl.blog_id = b.blog_id or crl.blog_id = b.blog_id
    // WHERE n.usid = 31
    // ORDER BY n.notification_id DESC;
    $result = mysqli_query($conn, $sql) or die("query failed");
    $result = mysqli_fetch_all($result, MYSQLI_ASSOC);
    echo json_encode(array('message' => 'Notifications Displayed Successfully.', 'status' => 1, 'notifications' => $result));
    $sql = "update notifications set status_of_seen = 'seen' where status_of_seen in ('unseen','new') and usid = '$usid'" or die("sql failed");
    $result = mysqli_query($conn, $sql) or die("query failed");
}

function clear_notification($conn)
{
    $usid = $_SESSION['buid'];
    $sql = "update notifications set status_of_seen = 'unseen' where usid = $usid" or die("sql failed");
    $result = mysqli_query($conn, $sql) or die("query failed");
    if ($result) {
        echo json_encode(array('message' => 'Notifications cleared successfully.', 'status' => true));
    } else {
        echo json_encode(array('message' => 'Error In clearing notifications.', 'status' => false));
    }
}
function delete_notification($data, $conn)
{
    $type = $data['type'];
    $id = $data['id'];
    if ($type == "comment" || $type == "onecommentlike" || $type == "onebloglike" || $type == "onereplylike" || $type == "allcommentlike" || $type == "allreplylike" || $type == "allbloglike") {
        $sql = "";
        if ($type == "comment" || $type == "onecommentlike" || $type == "onebloglike" || $type == "onereplylike") {
            if($type == "comment"){
                $sql = "update notifications set status_of_seen = 'deleted' where notify_type = 'comment' and notification_id = '$id'" or die("sql failed");
            }elseif($type == "onecommentlike"){
                $sql = "update notifications set status_of_seen = 'deleted' where notify_type = 'clike' and notification_id = '$id'" or die("sql failed");
            }elseif($type == "onebloglike"){
                $sql = "update notifications set status_of_seen = 'deleted' where notify_type = 'like' and notification_id = '$id'" or die("sql failed");
            }elseif($type == "onereplylike"){
                $sql = "update notifications set status_of_seen = 'deleted' where notify_type = 'rlike' and notification_id = '$id'" or die("sql failed");
            }
        } else if ($type == "allcommentlike") {
            $sql = "update notifications SET status_of_seen = 'deleted' 
            where notify_type = 'clike' and notification_id IN (SELECT n.notification_id FROM notifications n 
            where n.notify_type_id IN (SELECT blog_comment_like_id FROM `blog_comment_like_tb` WHERE blog_comment_id = $id))";
        } else if ($type == "allreplylike") {
            $sql = "update notifications SET status_of_seen = 'deleted' 
            where notify_type = 'rlike' and notification_id IN (SELECT n.notification_id FROM notifications n 
            where n.notify_type_id IN (SELECT blog_comment_like_id FROM `blog_comment_like_tb` WHERE blog_comment_id = $id))";
        } else if ($type == "allbloglike") {
            $sql = "update notifications SET status_of_seen='deleted' 
            where notify_type = 'like' AND notification_id IN (SELECT n.notification_id FROM notifications n 
            where n.notify_type_id IN (select blog_like_id from blog_likes where blog_id = $id ))";
        }
        $result = mysqli_query($conn, $sql) or die("query failed");
        if ($result) {
            echo json_encode(array('message' => 'Notifications deleted successfully.', 'status' => true));
        } else {
            echo json_encode(array('message' => 'Error In deleting notifications.', 'status' => false));
        }
    } else {
        echo json_encode(array('message' => 'Sending type key wrong.', 'status' => false));
    }





}

//notifications count thase je unseen chhe usid pramane
function count_notifications($data, $conn)
{
    $usid = $data['usid'];

    $sql = "select count(*) from notifications n where usid = '$usid' and n.status_of_seen = 'unseen'" or die("sql failed");


    $result = mysqli_query($conn, $sql) or die("query failed");


    $result1 = mysqli_fetch_all($result, MYSQLI_ASSOC);

    if (mysqli_num_rows($result) > 0) {
        echo json_encode(array('message' => 'Notifications Count Displayed Successfully.', 'status' => 1, 'ncount' => $result1));
    } else {
        echo json_encode(array('message' => 'Error In Counting Notifications', 'status' => 0));
    }
}


//notifications status update thase jem notifications jovase emm , usid pramane.
function status_update_notifications($data, $conn)
{
    $usid = $data['usid'];

    $notification_id = $data['notification_id'];

    $sql = "update notifications set status_of_seen = 'seen' where usid = '$usid' and notification_id = '$notification_id'" or die("sql failed");

    $result = mysqli_query($conn, $sql) or die("query failed");

    if ($result) {
        echo json_encode(array('message' => 'Notifications Status Updated Successfully.', 'status' => 1));
    } else {
        echo json_encode(array('message' => 'Error In UpdatIng Notifications Status.', 'status' => 0));
    }
}

function notify($conn){
    $usid = 0;
    if(isset($_SESSION['buid'])){
        $usid = $_SESSION['buid'];
    }
    $sql = "SELECT b.blog_id,n.*,u.usid as e_usid,u.username as e_username,u.photo, clc.blog_comment_id as liked_comment_id,rlc.blog_comment_id AS reply_liked_comment_id,c.comment as comments,cr.comment as replycomment,clc.comment as liked_comment,rlc.comment as liked_reply_comment, u.username,b.blog_title,crc.comment as reply_p_comment,clt.status_clike
    FROM notifications n
    LEFT JOIN blog_likes l ON n.notify_type_id = l.blog_like_id AND n.notify_type = 'like'
    LEFT JOIN blog_comments c ON n.notify_type_id = c.blog_comment_id AND n.notify_type = 'comment'
    LEFT JOIN blog_comments cr ON n.notify_type_id = cr.blog_comment_id AND n.notify_type = 'reply'
    LEFT JOIN blog_comments crc ON crc.blog_comment_id = cr.parent_comment_id
    LEFT JOIN blog_comment_like_tb cl ON n.notify_type_id = cl.blog_comment_like_id AND n.notify_type = 'clike'
    LEFT JOIN blog_comment_like_tb crl ON n.notify_type_id = crl.blog_comment_like_id AND n.notify_type = 'rlike'
    LEFT JOIN blog_comments clc ON clc.blog_comment_id = cl.blog_comment_id
    LEFT JOIN blog_comments rlc ON rlc.blog_comment_id = crl.blog_comment_id
    LEFT JOIN blog_comment_like_tb clt ON clt.blog_comment_id = c.blog_comment_id or clt.blog_comment_id = cr.blog_comment_id
    LEFT JOIN users u ON l.usid = u.usid or c.usid = u.usid or cr.usid = u.usid or cl.usid = u.usid or crl.usid = u.usid
    LEFT JOIN blogs b ON b.blog_id = l.blog_id or c.blog_id = b.blog_id or cr.blog_id=b.blog_id or cl.blog_id = b.blog_id or crl.blog_id = b.blog_id
    WHERE n.usid = $usid and n.status_of_seen = 'new'
    ORDER BY `n`.`notification_id` DESC"; 
    // SELECT n.*, l.usid AS liked_user_id, c.usid AS commented_user_id, cr.usid AS replied_user_id,cl.blog_comment_like_id as commentlikeid,crl.blog_comment_like_id as replycommentlikeid, c.comment as comments,cr.comment as replycomment, cl.blog_comment_like_id as clid, crl.blog_comment_like_id as crlid, u.username,b.blog_title
    // FROM notifications n
    // LEFT JOIN blog_likes l ON n.notify_type_id = l.blog_like_id AND n.notify_type = 'like'
    // LEFT JOIN blog_comments c ON n.notify_type_id = c.blog_comment_id AND n.notify_type = 'comment'
    // LEFT JOIN blog_comments cr ON n.notify_type_id = cr.blog_comment_id AND n.notify_type = 'reply'
    // LEFT JOIN blog_comment_like_tb cl ON n.notify_type_id = cl.blog_comment_like_id AND n.notify_type = 'clike'
    // LEFT JOIN blog_comment_like_tb crl ON n.notify_type_id = crl.blog_comment_like_id AND n.notify_type = 'rlike'
    // LEFT JOIN users u ON l.usid = u.usid or c.usid = u.usid or cr.usid = u.usid or cl.usid = u.usid or crl.usid = u.usid
    // LEFT JOIN blogs b ON b.blog_id = l.blog_id or c.blog_id = b.blog_id or cr.blog_id=b.blog_id or cl.blog_id = b.blog_id or crl.blog_id = b.blog_id
    // WHERE n.usid = 31
    // ORDER BY n.notification_id DESC;
    $result = mysqli_query($conn, $sql) or die("query failed");
    $result = mysqli_fetch_all($result, MYSQLI_ASSOC);
    $sql = "SELECT count(*) as totalnotifications
    FROM notifications n
    WHERE n.usid = $usid and (n.status_of_seen in ('unseen','seen','new'))
    ORDER BY `n`.`notification_id` DESC";
    $result1 = mysqli_query($conn, $sql) or die("query failed");
    $result1 = mysqli_fetch_all($result1, MYSQLI_ASSOC);
    echo json_encode(array('message' => 'Notifications Displayed Successfully.', 'status' => true, 'notifications' => $result,'totalnotifications'=>$result1));
    $sql = "update notifications set status_of_seen = 'unseen' where status_of_seen = 'new' and usid = '$usid'" or die("sql failed");
    $result = mysqli_query($conn, $sql) or die("query failed");

}

if ($fkey == "display_notifications") {
    display_notifications($conn);
} elseif ($fkey == "count_notifications") {
    count_notifications($data, $conn);
} elseif ($fkey == "status_update_notifications") {
    status_update_notifications($data, $conn);
} else if ($fkey == "delete_notification") {
    delete_notification($data, $conn);
} else if ($fkey == "clear_notification") {
    clear_notification($conn);
}else if($fkey == "notify"){
    notify($conn);
} else {
    echo json_encode(array('message' => 'Error in sending notification Api key', 'status' => false));
}


?>