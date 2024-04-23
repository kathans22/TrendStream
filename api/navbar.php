<?php
session_start();

// blog_status = 0 // incomplete blog or draft blog
// blog_status = 1 // display blog which are active
// blog_status = 2 // delete a blog for user not for database;

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Methods: DELETE');
header('Access-Control-Allow-Methods: PUT');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');


$data = json_decode(file_get_contents("php://input"), true);

$fkey = $data['fkey'];

include "./config.php";

function navbar_data($data, $conn)
{
    //$blog_id - increment;
    $usid = 0;
    if (isset($_SESSION['buid'])) {
        $usid = $_SESSION['buid'];
    }
    $sql = "select * from blog_categorys";
    $result = mysqli_query($conn, $sql);
    $result1 = mysqli_fetch_all($result, MYSQLI_ASSOC);
    $sql = "select * from languages";
    $result = mysqli_query($conn, $sql);
    $result2 = mysqli_fetch_all($result, MYSQLI_ASSOC);
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
    $result = mysqli_query($conn, $sql);
    $result3 = mysqli_fetch_all($result, MYSQLI_ASSOC);
    echo json_encode(array('message' => 'get navbar data', 'status' => true, 'categorys' => $result1, 'languages' => $result2, 'notifications' => $result3));
}
function load_cat_lag($data, $conn)
{

}

if ($fkey == "navbar_data") {
    navbar_data($data, $conn);
} else {
    echo json_encode(array('message' => 'Error in sending Blog Api key', 'status' => false));
}

?>