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


function gettotalcomment($conn, $blog_id)
{

    $sql = "select b.blog_id, (select count(*) from blog_comments bc where bc.blog_id = b.blog_id and bc.status_up_del = 'inserted') as comments
    from blogs b where b.blog_id = $blog_id";
    // $sql ="select b.blog_id,(select count(*) from blog_likes bl where bl.blog_id = b.blog_id and bl.status_like_dislike = 'like') as likes 
    // from blogs b where b.blog_id = $blog_id";
    $result = mysqli_query($conn, $sql) or die("error");

    $result = mysqli_fetch_all($result, MYSQLI_ASSOC);
    return $result;
}
function getusid($blog_id, $conn, $type)
{
    if ($type == "comment") {
        $sql_fetch_blog_usid = "select usid from blogs where blog_id = '$blog_id'";

        $result_fetch_blog_usid = mysqli_query($conn, $sql_fetch_blog_usid) or die("query for fetching id failed");

        $rows_fetch_blog_usid = mysqli_fetch_assoc($result_fetch_blog_usid);

        return $rows_fetch_blog_usid['usid'];
    } elseif ($type == "reply") {
        $parent_comment_id = $blog_id;

        $sqlfetchid = "select usid from blog_comments where blog_comment_id = '$parent_comment_id'" or die("sql failed");

        $resultfetchid = mysqli_query($conn, $sqlfetchid) or die("query for fetching id failed");

        $rows = mysqli_fetch_assoc($resultfetchid);

        return $rows["usid"];
    } else {
        return json_encode(array('message' => 'Error IN Sending Key For Comment Or Reply.', 'status' => 0));
    }

}

function getcommentid($blog_id, $usid, $parent_comment_id, $comment, $conn)
{
    $sqlfetchid = "select blog_comment_id from blog_comments where blog_id = '$blog_id' and usid = '$usid' and parent_comment_id = '$parent_comment_id' and comment = '$comment'" or die("sql failed");

    $resultfetchid = mysqli_query($conn, $sqlfetchid) or die("query for fetching id failed");

    $rows = mysqli_fetch_assoc($resultfetchid);

    return $rows["blog_comment_id"];
}


//save blog or readlater blog
function blog_comment($data, $conn)
{
    $blog_id = $data['blog_id'];
    $usid = $_SESSION['buid'];
    // $usid = $data['usid'];
    $parent_comment_id = 0;
    $comment = $data['comment'];

    $sql = "insert into blog_comments(blog_id,usid,parent_comment_id,comment) values('$blog_id','$usid','$parent_comment_id','$comment')" or die("sql failed");

    $result = mysqli_query($conn, $sql) or die("query for blog_comment failed");

    if ($result) {
        // echo json_encode(array('message' => 'Comment Added To A Blog', 'status' => true));
        //-----------------------------------------------------------------------------------------
        $blog_usid = getusid($blog_id, $conn, 'comment');

        //---------------------------------------------------------- part one

        //------------------------------------------------------------------------------------------------------------------------

        $blog_comment_id = getcommentid($blog_id, $usid, $parent_comment_id, $comment, $conn);

        //--------------------------------------------------------------------------------------------------------------------------------------

        $content = "";
        // $sql = "SELECT b.*,u.* FROM blog_comments b, users u where blog_id = '$blog_id' and parent_comment_id = 0 and u.usid=b.usid order by blog_comment_id desc LIMIT 1";
        $sql = "select bc.*,u.*,(select COUNT(*) from blog_comment_like_tb bcl where bcl.blog_comment_id =  bc.blog_comment_id and status_clike = 'clike') as likes,(select COUNT(*) from blog_comments bcr where bcr.parent_comment_id =  bc.blog_comment_id and bcr.status_up_del='inserted') AS comments from blog_comments bc,users u WHERE u.usid= bc.usid and bc.status_up_del = 'inserted' ORDER BY bc.blog_comment_id desc LIMIT 1";

        // $sql = "select bc.*,u.*,(select COUNT(*) from blog_comment_like_tb bcl where bcl.blog_comment_id =  bc.blog_comment_id and status_clike = 'clike') as likes,(select COUNT(*) from blog_comments bcr where bcr.parent_comment_id =  bc.blog_comment_id and bcr.status_up_del='inserted') AS comments from blog_comments bc,users u WHERE u.usid= bc.usid bc.status_up_del = 'inserted' ORDER BY bc.blog_comment_id desc limit 1";

        $result = mysqli_query($conn, $sql) or die("query failed");
        // $result =  mysqli_fetch_all($result,MYSQLI_ASSOC);
        $content = get_comment_content($data, $conn, $result, $blog_id, $usid);

        $result = gettotalcomment($conn, $blog_id);
        echo json_encode(array('message' => 'Comment Added To A Blog', 'content' => $content, 'comments' => $result, 'status' => true));

        $sqlnotification = "insert into notifications(usid, notify_type, notify_type_id) values('$blog_usid','comment','$blog_comment_id')";

        $resultnotify = mysqli_query($conn, $sqlnotification) or die("query for notification failed");

        // if ($resultnotify) {
        //     echo json_encode(array('message' => 'Notifcation Sended.', 'status' => 1));
        // } else {
        //     echo json_encode(array('message' => 'Error In Sending Notifcations.', 'status' => 0));
        // }
    } else {
        echo json_encode(array('message' => 'Error In Adding A Comment To A Blog', 'status' => false));
    }
}

function notifydelete($blog_comment_id, $conn)
{
    $sqlgetreplyid = "select blog_comment_id from blog_comments where parent_comment_id = '$blog_comment_id'" or die("sql failed");

    $flag = true;

    $resultgetreplyid = mysqli_query($conn, $sqlgetreplyid);

    if (mysqli_num_rows($resultgetreplyid) > 0) {
        while ($rows = mysqli_fetch_assoc($resultgetreplyid)) {
            $replyid = $rows['blog_comment_id'];
            if ($flag == true) {
                $sql_notification_reply_del = "delete from notifications where notify_type = 'reply' and notify_type_id = '$replyid'" or die("sql reply delete notification failed");

                $result_notification_reply_del = mysqli_query($conn, $sql_notification_reply_del) or die("query failed for reply delete notifications");

                if ($result_notification_reply_del) {
                    $flag = true;
                } else {
                    $flag = false;
                }
            } else {
                echo json_encode(array('message' => 'Some Error Occurred In Deleting The Replies Notifications', 'status' => 0));
            }
        }

        if ($flag == true) {
            $sql_notification_comment_del = "delete from notifications where notify_type = 'comment' and notify_type_id = '$blog_comment_id'" or die("sql comment delete notification failed");

            $result_notification_comment_del = mysqli_query($conn, $sql_notification_comment_del) or die("query failed for comment delete notifications");

            if ($result_notification_comment_del) {
                $flag = true;
            } else {
                $flag = false;
            }
        }
    } else {
        $sql_notification_comment_del = "delete from notifications where notify_type = 'comment' and notify_type_id = '$blog_comment_id'" or die("sql comment delete notification failed");

        $result_notification_comment_del = mysqli_query($conn, $sql_notification_comment_del) or die("query failed for comment delete notifications");

        if ($result_notification_comment_del) {
            $flag = true;
        } else {
            $flag = false;
        }
    }

    return $flag;
}

function blog_child_comment_delete1($cid, $conn)
{

    $blog_comment_id = $cid;

    //$check = notifydelete($blog_comment_id,$conn);

    $sqlgetreplyid = "select blog_comment_id from blog_comments where parent_comment_id = '$blog_comment_id'" or die("sql failed");

    $flag = true;

    $resultgetreplyid = mysqli_query($conn, $sqlgetreplyid);

    if (mysqli_num_rows($resultgetreplyid) > 0) {
        while ($rows = mysqli_fetch_assoc($resultgetreplyid)) {
            $replyid = $rows['blog_comment_id'];

            $sql_notification_reply_del = "delete from notifications where notify_type_id = '$replyid' and (notify_type = 'reply' or notify_type = 'comment')" or die("sql reply delete notification failed");

            $result_notification_reply_del = mysqli_query($conn, $sql_notification_reply_del) or die("query failed for reply delete notifications");

            $sql = "update blog_comments set status_up_del = 'deleted' where blog_comment_id = '$replyid'" or die("sql delete comment failed");

            $result = mysqli_query($conn, $sql) or die("query for delete comment failed");

            blog_child_comment_delete1($replyid, $conn);

        }


    }



}

function timeConvert($value)
{
    $timeDiff = abs(strtotime(date("Y-m-d H:i:s")) - strtotime($value));

    $result = "";

    if ($timeDiff < 60) { // Less than 1 minute
        $secondsAgo = floor($timeDiff);
        $result = $secondsAgo . " seconds ago";
    } elseif ($timeDiff < 3600) { // Less than 1 hour
        $minutesAgo = floor($timeDiff / 60);
        $result = $minutesAgo . " minutes ago";
    } elseif ($timeDiff < 86400) { // Less than 1 day
        $hoursAgo = floor($timeDiff / 3600);
        $result = $hoursAgo . " hours ago";
    } elseif ($timeDiff < 2592000) { // Less than 1 month
        $daysAgo = floor($timeDiff / 86400);
        $result = $daysAgo . " days ago";
    } elseif ($timeDiff < 31536000) { // Less than 1 year
        $monthsAgo = floor($timeDiff / 2592000);
        $result = $monthsAgo . " months ago";
    } else {
        $yearsAgo = floor($timeDiff / 31536000);
        $result = $yearsAgo . " years ago";
    }
    return $result;
}

function blog_comment_delete($data, $conn)
{
    $blog_comment_id = $data['blog_comment_id'];
    $type = $data['type'];
    $cpid = $data['cpid'];
    $usid = $_SESSION['buid'];
    $blog_id = $data['blog_id'];

    $sql = "update blog_comments set status_up_del = 'deleted' where blog_comment_id = '$blog_comment_id'" or die("sql delete comment failed");

    $result = mysqli_query($conn, $sql) or die("query for delete comment failed");

    $sql_notification_reply_del = "delete from notifications where notify_type_id = '$blog_comment_id' and (notify_type = 'reply' or notify_type = 'comment')" or die("sql reply delete notification failed");

    blog_child_comment_delete1($blog_comment_id, $conn);

    $result_notification_reply_del = mysqli_query($conn, $sql_notification_reply_del) or die("query failed for reply delete notifications");
    if ($result) {
        if ($type == "reply") {
            $content = "";
            // $sql = "SELECT b.*,u.* FROM blog_comments b, users u where blog_comment_id = $cpid and u.usid=b.usid";
            // $sql = "SELECT blog_comments.*,users.username,
            // count(blog_comment_like_tb.blog_comment_like_id) as likes
            // FROM 
            // blog_comments
            // LEFT JOIN blog_comment_like_tb ON blog_comments.blog_comment_id= blog_comment_like_tb.blog_comment_id 
            // and blog_comment_like_tb.status_clike='clike'
            // LEFT JOIN users ON blog_comments.usid= users.usid
            // where 
            // blog_comments.blog_comment_id = '$cpid'
            // and status_up_del = 'inserted' 
            // GROUP BY blog_comments.blog_comment_id
            // order by blog_comment_id desc";
            //    $sql = "SELECT bc.*,users.username,
            //    count(blog_comment_like_tb.blog_comment_like_id) as likes,
            //    count(bcl.blog_comment_id) as comments
            //    FROM 
            //    blog_comments bc
            //    LEFT JOIN blog_comment_like_tb ON bc.blog_comment_id= blog_comment_like_tb.blog_comment_id 
            //    and blog_comment_like_tb.status_clike='clike'
            //    LEFT JOIN users ON bc.usid= users.usid
            //    LEFT JOIN blog_comments bcl ON bcl.parent_comment_id=bc.blog_comment_id and bcl.status_up_del='inserted'
            //    where
            //    bc.blog_comment_id = '$cpid'
            //    and bc.status_up_del = 'inserted' 
            //    GROUP BY bc.blog_comment_id
            //    order by blog_comment_id desc";
            $sql = "select bc.*,u.*,(select COUNT(*) from blog_comment_like_tb bcl where bcl.blog_comment_id =  bc.blog_comment_id and status_clike = 'clike') as likes,(select COUNT(*) from blog_comments bcr where bcr.parent_comment_id =  bc.blog_comment_id and bcr.status_up_del='inserted') AS comments from blog_comments bc,users u WHERE u.usid= bc.usid and bc.blog_comment_id = '$cpid' and bc.status_up_del = 'inserted' ORDER BY bc.blog_comment_id desc";

            $result = mysqli_query($conn, $sql) or die("query failed");
            // $content= get_comment_content($data,$conn,$result,$blog_id,$usid);
            if (mysqli_num_rows($result) >= 1) {
                while ($rows = mysqli_fetch_assoc($result)) {
                    $content .= '<div class="d-flex flex-row p-3">
                        <img src="'.(($rows['photo'] == NULL) ? ("../../images/faces/profile/default.png"): ("../../images/faces/profile/".$rows['photo'])).'"
                            width="40" height="40"
                            class="rounded-circle mr-3">
                        <div class="ms-3">
                        </div>
                        <div class="w-100">
                            <div
                                class="d-flex justify-content-between align-items-center">
                                <div
                                    class="d-flex flex-row align-items-center">
                                    <span
                                        class="mb-1 fw-bolder">' . $rows['username'] . '</span>
                                </div>
                                <div class="d-flex flex-row">
                                    <small>' . timeConvert($rows['time']) . '</small>';
                    $sql1 = "SELECT u.* FROM blogs b,users u where u.usid=b.usid and blog_id = '$blog_id'";
                    $result1 = mysqli_query($conn, $sql1) or die("query failed");
                    $result1 = mysqli_fetch_assoc($result1);
                    $busid = $result1['usid'];
                    $uphoto = $result1['photo'];
                    if ($usid == $busid) {
                        $content .= '<small class="ms-2">
                                            <div class="dropdown"
                                                align=center>
                                                <i class="mdi mdi-dots-vertical text-dark"
                                                    type="button"
                                                    id="dropdownMenuSizeButton3"
                                                    data-bs-toggle="dropdown"
                                                    aria-haspopup="true"
                                                        aria-expanded="false"></i>
                                                <div class="dropdown-menu"
                                                    aria-labelledby="dropdownMenuSizeButton3">
                                                    <h6
                                                        class="dropdown-header">
                                                        Settings
                                                    </h6>
                                                    <a class="dropdown-item delete-comment" data-id="' . $rows['blog_comment_id'] . '"
                                                data-type="main"
                                                >Delete</a>
                                                </div>
                                            </div>
                                        </small>';
                    } elseif ($usid == $rows['usid']) {
                        $content .= '<small class="ms-2">
                                            <div class="dropdown"
                                                align=center>
                                                <i class="mdi mdi-dots-vertical text-dark"
                                                    type="button"
                                                    id="dropdownMenuSizeButton3"
                                                    data-bs-toggle="dropdown"
                                                    aria-haspopup="true"
                                                    aria-expanded="false"></i>
                                                <div class="dropdown-menu"
                                                    aria-labelledby="dropdownMenuSizeButton3">
                                                    <h6
                                                        class="dropdown-header">
                                                        Settings
                                                    </h6>
                                                    <a class="dropdown-item delete-comment" data-id="' . $rows['blog_comment_id'] . '"
                                                data-type="main"
                                                >Delete</a>
                                                </div>
                                            </div>
                                        </small>';
                    }
                    $content .= '</div>
                                </div>
                                <p class="mb-0 text-muted">' . $rows['comment'] . '</p>
                                <div
                                    class="d-flex flex-row user-feed">
                                    <div>';
                    $content .= check_comment_like($conn, $rows['blog_comment_id'], $rows['likes']);
                    $content .= '<!-- <span class="ml-3 ms-3"></span> -->
                                        <a data-bs-toggle="collapse"
                                            data-id="comment-' . $rows['blog_comment_id'] . '"
                                            data-cid ="' . $rows['blog_comment_id'] . '"
                                            data-ruid="' . $rows['usid'] . '"
                                            data-username = "' . $rows['username'] . '"
                                            id="rcomment-' . $rows['blog_comment_id'] . '"
                                            href="#replay-' . $rows['blog_comment_id'] . '"
                                            aria-expanded="false"
                                            aria-controls="replay-' . $rows['blog_comment_id'] . '"
                                            class="collapsed ms-3 ml-3 show-reply">
                                            <span
                                                class="ml-3 text-black"><i
                                                    class="fa fa-comments-o">&nbsp;
                                                    Reply</i></span>
                                        </a>
                                    </div>';
                    $blog_comment_id = $rows['blog_comment_id'];
                    $pcid = $blog_comment_id;
                    // SELECT b.*,u.* FROM blog_comments b, users u where blog_id = 30 and parent_comment_id = 0 and u.usid=b.usid order by blog_comment_id asc;
                    // $sql = "SELECT b.*,u.* FROM blog_comments b, users u where blog_id = '$blog_id' and parent_comment_id = '$blog_comment_id' and status_up_del = 'inserted'  and u.usid=b.usid order by blog_comment_id asc";
                    // $sql = "SELECT blog_comments.*,users.username,
                    // count(blog_comment_like_tb.blog_comment_like_id) as likes
                    // FROM 
                    // blog_comments
                    // LEFT JOIN blog_comment_like_tb ON blog_comments.blog_comment_id= blog_comment_like_tb.blog_comment_id 
                    // and blog_comment_like_tb.status_clike='clike'
                    // LEFT JOIN users ON blog_comments.usid= users.usid
                    // where 
                    // blog_comments.blog_id = '$blog_id'
                    // and parent_comment_id = '$blog_comment_id'
                    // and status_up_del = 'inserted' 
                    // GROUP BY blog_comments.blog_comment_id
                    // order by blog_comment_id desc";
                    // $sql = "SELECT * FROM blog_comments where blog_id = '$blog_id' and parent_comment_id = '$blog_comment_id'";
                    // $sql = "SELECT bc.*,users.username,
                    // count(blog_comment_like_tb.blog_comment_like_id) as likes,
                    // count(bcl.blog_comment_id) as comments
                    // FROM 
                    // blog_comments bc
                    // LEFT JOIN blog_comment_like_tb ON bc.blog_comment_id= blog_comment_like_tb.blog_comment_id 
                    // and blog_comment_like_tb.status_clike='clike'
                    // LEFT JOIN users ON bc.usid= users.usid
                    // LEFT JOIN blog_comments bcl ON bcl.parent_comment_id=bc.blog_comment_id and bcl.status_up_del='inserted'
                    // where
                    // bc.blog_id = '$blog_id'
                    // and bc.blog_comment_id = '$blog_comment_id'
                    // and bc.status_up_del = 'inserted' 
                    // GROUP BY bc.blog_comment_id
                    // order by blog_comment_id desc";
                    $sql = "select bc.*,u.*,(select COUNT(*) from blog_comment_like_tb bcl where bcl.blog_comment_id =  bc.blog_comment_id and status_clike = 'clike') as likes,(select COUNT(*) from blog_comments bcr where bcr.parent_comment_id =  bc.blog_comment_id and bcr.status_up_del='inserted') AS comments from blog_comments bc,users u WHERE u.usid= bc.usid and bc.blog_id = '$blog_id' and bc.blog_comment_id = '$blog_comment_id' and bc.status_up_del = 'inserted' ORDER BY bc.blog_comment_id desc";

                    $resultreply = mysqli_query($conn, $sql);
                    if (mysqli_num_rows($resultreply) >= 1) {
                        $content .= '<a data-bs-toggle="collapse"
                                        data-id="comment-' . $rows['blog_comment_id'] . '" id="ccomment-' . $rows['blog_comment_id'] . '"
                                        href="#collapse-' . $rows['blog_comment_id'] . '" 
                                        aria-expanded="false"
                                        aria-controls="collapse-' . $rows['blog_comment_id'] . '"
                                        class="collapsed show-comment">
                                        <span class="ml-3"><i
                                                class="fa fa-comments-o">&nbsp;
                                                Show Reply (' . $rows['comments'] . ')</i></span>
                                    </a>';
                    }
                    $content .= '</div>
                            </div>
                        </div>';

                    if (mysqli_num_rows($resultreply) >= 1) {
                        $content .= '<div id="collapse-' . $rows['blog_comment_id'] . '" class="collapse"
                            role="tabpanel" aria-labelledby="heading-4"
                            data-bs-parent="#accordion-2">';
                        $content .= get_reply_comment($data, $conn, $blog_comment_id, $busid, $pcid);
                        $content .= '</div>';
                    }
                    $content .= '<div id="replay-' . $rows['blog_comment_id'] . '" class="collapse"
                            role="tabpanel"
                            aria-labelledby="heading-' . $rows['blog_comment_id'] . '"
                            data-bs-parent="#accordion-2">
                            <span
                                class="ms-5 p-3 text-muted text-medium" id="replyuserdata-' . $rows['blog_comment_id'] . '">reply
                                to username</span>
                            <div class="d-flex p-3 ms-5">
                                <img class="img-sm rounded-10"
                                    src="'.(($uphoto == NULL) ? ("../../images/faces/profile/default.png"): ("../../images/faces/profile/".$uphoto)).'"
                                    width="30"
                                    class="rounded-circle mr-2">
                                <div class="ms-3"></div>
                                <input type="text"
                                    class="comment-text-box form-control" id="replyibox-' . $rows['blog_comment_id'] . '"
                                    placeholder="Enter your comment">
                                <button
                                    class="btn btn-outline-success btn-rounded ms-3 addreply"
                                    data-id = "' . $rows['blog_comment_id'] . '"
                                    style="height: 48px;"><i
                                        class="mdi mdi-send text-dark"></i></button>
                            </div>
                        </div>';

                }
            }
            $result = gettotalcomment($conn, $blog_id);

            echo json_encode(array('message' => 'Comment deleted', 'type' => 'reply', 'comments' => $result, 'content' => $content, 'status' => true));
        } else {
            $result = gettotalcomment($conn, $blog_id);

            echo json_encode(array('message' => 'Comment deleted', 'type' => 'main', 'comments' => $result, 'status' => true));
        }
    } else {
        echo json_encode(array('message' => 'Error In Deleting A Comment', 'status' => false));
    }
    // $sql = "update blog_comments set status_up_del = 'deleted' where parent_comment_id = '$blog_comment_id'" or die("sql delete comment failed");



    // $result = mysqli_query($conn,$sql) or die("query for delete comment failed");
}


function blog_comment_update($data, $conn)
{
    $blog_comment_id = $data['blog_comment_id'];

    $comment = $data['comment'];

    $sql = "update blog_comments set comment = '$comment' where blog_comment_id = '$blog_comment_id'" or die("sql comment update failed");

    $result = mysqli_query($conn, $sql) or die("query for blog_comment_update failed");

    if ($result) {
        echo json_encode(array('message' => 'Comment Updated', 'status' => 1));
    } else {
        echo json_encode(array('message' => 'Error In Updating  A Comment', 'status' => 0));
    }
}


//------------------------------------------------------------------------------------------------------------------------------------------------------------------


function blog_reply($data, $conn)
{
    $blog_id = $data['blog_id'];
    $usid = $_SESSION['buid'];
    $parent_comment_id = $data['parent_comment_id'];
    $comment = $data['comment'];
    $mainid = $data['mainid'];

    $sql = "insert into blog_comments(blog_id,usid,parent_comment_id,comment) values('$blog_id','$usid','$parent_comment_id','$comment')" or die("sql failed");

    $result = mysqli_query($conn, $sql) or die("query for blog_reply failed");

    if ($result) {

        $content = "";
        // $sql = "SELECT b.*,u.* FROM blog_comments b, users u where blog_id = '$blog_id' and blog_comment_id = $mainid and u.usid=b.usid";
        // $sql = "SELECT blog_comments.*,users.username,
        // count(blog_comment_like_tb.blog_comment_like_id) as likes
        // FROM 
        // blog_comments
        // LEFT JOIN blog_comment_like_tb ON blog_comments.blog_comment_id= blog_comment_like_tb.blog_comment_id 
        // and blog_comment_like_tb.status_clike='clike'
        // LEFT JOIN users ON blog_comments.usid= users.usid
        // where 
        // blog_comments.blog_id = '$blog_id'
        // and  blog_comments.blog_comment_id = '$mainid'
        // and status_up_del = 'inserted' 
        // GROUP BY blog_comments.blog_comment_id
        // order by blog_comment_id desc";
        // $sql = "SELECT bc.*,users.username,
        // count(blog_comment_like_tb.blog_comment_like_id) as likes,
        // count(bcl.blog_comment_id) as comments
        // FROM 
        // blog_comments bc
        // LEFT JOIN blog_comment_like_tb ON bc.blog_comment_id= blog_comment_like_tb.blog_comment_id 
        // and blog_comment_like_tb.status_clike='clike'
        // LEFT JOIN users ON bc.usid= users.usid
        // LEFT JOIN blog_comments bcl ON bcl.parent_comment_id=bc.blog_comment_id and bcl.status_up_del='inserted'
        // where
        // bc.blog_id = '$blog_id'
        // and bc.blog_comment_id = '$mainid'
        // and bc.status_up_del = 'inserted' 
        // GROUP BY bc.blog_comment_id
        // order by blog_comment_id desc";
        $sql = "select bc.*,u.*,(select COUNT(*) from blog_comment_like_tb bcl where bcl.blog_comment_id =  bc.blog_comment_id and status_clike = 'clike') as likes,(select COUNT(*) from blog_comments bcr where bcr.parent_comment_id =  bc.blog_comment_id and bcr.status_up_del='inserted') AS comments from blog_comments bc,users u WHERE u.usid= bc.usid and bc.blog_id = '$blog_id' and bc.blog_comment_id = '$mainid' and bc.status_up_del = 'inserted' ORDER BY bc.blog_comment_id desc";
        $result = mysqli_query($conn, $sql) or die("query failed");

        // $content= get_comment_content($data,$conn,$result,$blog_id,$usid);
        if (mysqli_num_rows($result) >= 1) {
            while ($rows = mysqli_fetch_assoc($result)) {
                $content .= '<div class="d-flex flex-row p-3">
                    <img src="'.(($rows['photo'] == NULL) ? ("../../images/faces/profile/default.png"): ("../../images/faces/profile/".$rows['photo'])).'"
                        width="40" height="40"
                        class="rounded-circle mr-3">
                    <div class="ms-3">
                    </div>
                    <div class="w-100">
                        <div
                            class="d-flex justify-content-between align-items-center">
                            <div
                                class="d-flex flex-row align-items-center">
                                <span
                                    class="mb-1 fw-bolder">' . $rows['username'] . '</span>
                            </div>
                            <div class="d-flex flex-row">
                                <small>' . timeConvert($rows['time']) . '</small>';
                $sql1 = "SELECT u.* FROM blogs b,users u where u.usid=b.usid and blog_id = '$blog_id'";
                $result1 = mysqli_query($conn, $sql1) or die("query failed");
                $result1 = mysqli_fetch_assoc($result1);
                $busid = $result1['usid'];
                $uphoto = $result1['photo'];
                if ($usid == $busid) {
                    $content .= '<small class="ms-2">
                                        <div class="dropdown"
                                            align=center>
                                            <i class="mdi mdi-dots-vertical text-dark"
                                                type="button"
                                                id="dropdownMenuSizeButton3"
                                                data-bs-toggle="dropdown"
                                                aria-haspopup="true"
                                                    aria-expanded="false"></i>
                                            <div class="dropdown-menu"
                                                aria-labelledby="dropdownMenuSizeButton3">
                                                <h6
                                                    class="dropdown-header">
                                                    Settings
                                                </h6>
                                                <a class="dropdown-item delete-comment" data-id="' . $rows['blog_comment_id'] . '"
                                            data-type="main"
                                            >Delete</a>
                                            </div>
                                        </div>
                                    </small>';
                } elseif ($usid == $rows['usid']) {
                    $content .= '<small class="ms-2">
                                        <div class="dropdown"
                                            align=center>
                                            <i class="mdi mdi-dots-vertical text-dark"
                                                type="button"
                                                id="dropdownMenuSizeButton3"
                                                data-bs-toggle="dropdown"
                                                aria-haspopup="true"
                                                aria-expanded="false"></i>
                                            <div class="dropdown-menu"
                                                aria-labelledby="dropdownMenuSizeButton3">
                                                <h6
                                                    class="dropdown-header">
                                                    Settings
                                                </h6>
                                                <a class="dropdown-item delete-comment" data-id="' . $rows['blog_comment_id'] . '"
                                            data-type="main"
                                            >Delete</a>
                                            </div>
                                        </div>
                                    </small>';
                }
                $content .= '</div>
                            </div>
                            <p class="mb-0 text-muted">' . $rows['comment'] . '</p>
                            <div
                                class="d-flex flex-row user-feed">
                                <div>';
                $content .= check_comment_like($conn, $rows['blog_comment_id'], $rows['likes']);
                $content .= '<!-- <span class="ml-3 ms-3"></span> -->
                                    <a data-bs-toggle="collapse"
                                        data-id="comment-' . $rows['blog_comment_id'] . '"
                                        data-cid ="' . $rows['blog_comment_id'] . '"
                                        data-ruid="' . $rows['usid'] . '"
                                        data-username = "' . $rows['username'] . '"
                                        id="rcomment-' . $rows['blog_comment_id'] . '"
                                        href="#replay-' . $rows['blog_comment_id'] . '"
                                        aria-expanded="false"
                                        aria-controls="replay-' . $rows['blog_comment_id'] . '"
                                        class="collapsed ms-3 ml-3 show-reply">
                                        <span
                                            class="ml-3 text-black"><i
                                                class="fa fa-comments-o">&nbsp;
                                                Reply</i></span>
                                    </a>
                                </div>';
                $blog_comment_id = $rows['blog_comment_id'];
                $pcid = $blog_comment_id;
                // SELECT b.*,u.* FROM blog_comments b, users u where blog_id = 30 and parent_comment_id = 0 and u.usid=b.usid order by blog_comment_id asc;
                // $sql = "SELECT b.*,u.* FROM blog_comments b, users u where blog_id = '$blog_id' and parent_comment_id = '$blog_comment_id' and status_up_del = 'inserted'  and u.usid=b.usid order by blog_comment_id asc";
                // $sql = "SELECT blog_comments.*,users.username,
                // count(blog_comment_like_tb.blog_comment_like_id) as likes
                // FROM 
                // blog_comments
                // LEFT JOIN blog_comment_like_tb ON blog_comments.blog_comment_id= blog_comment_like_tb.blog_comment_id 
                // and blog_comment_like_tb.status_clike='clike'
                // LEFT JOIN users ON blog_comments.usid= users.usid
                // where 
                // blog_comments.blog_id = '$blog_id'
                // and parent_comment_id = '$blog_comment_id'
                // and status_up_del = 'inserted' 
                // GROUP BY blog_comments.blog_comment_id
                // order by blog_comment_id desc";
                //         $sql = "SELECT bc.*,users.username,
                // count(blog_comment_like_tb.blog_comment_like_id) as likes,
                // count(bcl.blog_comment_id) as comments
                // FROM 
                // blog_comments bc
                // LEFT JOIN blog_comment_like_tb ON bc.blog_comment_id= blog_comment_like_tb.blog_comment_id 
                // and blog_comment_like_tb.status_clike='clike'
                // LEFT JOIN users ON bc.usid= users.usid
                // LEFT JOIN blog_comments bcl ON bcl.parent_comment_id=bc.blog_comment_id and bcl.status_up_del='inserted'
                // where
                // bc.blog_id = '$blog_id'
                // and bc.parent_comment_id = '$blog_comment_id'
                // and bc.status_up_del = 'inserted' 
                // GROUP BY bc.blog_comment_id
                // order by blog_comment_id desc";
                $sql1 = "select bc.*,u.*,(select COUNT(*) from blog_comment_like_tb bcl where bcl.blog_comment_id =  bc.blog_comment_id and status_clike = 'clike') as likes,(select COUNT(*) from blog_comments bcr where bcr.parent_comment_id =  bc.blog_comment_id and bcr.status_up_del='inserted') AS comments from blog_comments bc,users u WHERE u.usid= bc.usid and bc.blog_id = '$blog_id' and bc.parent_comment_id = '$blog_comment_id' and bc.status_up_del = 'inserted' ORDER BY bc.blog_comment_id desc";

                // $sql = "SELECT * FROM blog_comments where blog_id = '$blog_id' and parent_comment_id = '$blog_comment_id'";
                $resultreply = mysqli_query($conn, $sql);
                if (mysqli_num_rows($resultreply) >= 1) {
                    $content .= '<a data-bs-toggle="collapse"
                                    data-id="comment-' . $rows['blog_comment_id'] . '" id="ccomment-' . $rows['blog_comment_id'] . '"
                                    href="#collapse-' . $rows['blog_comment_id'] . '" 
                                    aria-expanded="false"
                                    aria-controls="collapse-' . $rows['blog_comment_id'] . '"
                                    class="collapsed show-comment">
                                    <span class="ml-3"><i
                                            class="fa fa-comments-o">&nbsp;
                                            Show Reply (' . $rows['comments'] . ')</i></span>
                                </a>';
                }
                $content .= '</div>
                        </div>
                    </div>';

                if (mysqli_num_rows($resultreply) >= 1) {
                    $content .= '<div id="collapse-' . $rows['blog_comment_id'] . '" class="collapse"
                        role="tabpanel" aria-labelledby="heading-4"
                        data-bs-parent="#accordion-2">';
                    $content .= get_reply_comment($data, $conn, $blog_comment_id, $busid, $pcid);
                    $content .= '</div>';
                }
                $content .= '<div id="replay-' . $rows['blog_comment_id'] . '" class="collapse"
                        role="tabpanel"
                        aria-labelledby="heading-' . $rows['blog_comment_id'] . '"
                        data-bs-parent="#accordion-2">
                        <span
                            class="ms-5 p-3 text-muted text-medium" id="replyuserdata-' . $rows['blog_comment_id'] . '">reply
                            to username</span>
                        <div class="d-flex p-3 ms-5">
                            <img class="img-sm rounded-10"
                                src="'.(($uphoto == NULL) ? ("../../images/faces/profile/default.png"): ("../../images/faces/profile/".$uphoto)).'"
                                width="30"
                                class="rounded-circle mr-2">
                            <div class="ms-3"></div>
                            <input type="text"
                                class="comment-text-box form-control" id="replyibox-' . $rows['blog_comment_id'] . '"
                                placeholder="Enter your comment">
                            <button
                                class="btn btn-outline-success btn-rounded ms-3 addreply"
                                data-id = "' . $rows['blog_comment_id'] . '"
                                style="height: 48px;"><i
                                    class="mdi mdi-send text-dark"></i></button>
                        </div>
                    </div>';

            }
        }
        $result = gettotalcomment($conn, $blog_id);

        echo json_encode(array('message' => 'Reply Added To A Comment', 'content' => $content, 'comments' => $result, 'status' => true));

        //-----------------------------------------------------------------------------------------
        $reply_usid = getusid($parent_comment_id, $conn, 'reply');

        //---------------------------------------------------------- part one

        //------------------------------------------------------------------------------------------------------------------------

        $blog_reply_id = getcommentid($blog_id, $usid, $parent_comment_id, $comment, $conn);

        //--------------------------------------------------------------------------------------------------------------------------------------

        //select * from blog_likes where usid = '$usid' and blog_id = '$blog_id' and status_like_dislike = 'like'" or die("sql query failed")

        $sqlnotification = "insert into notifications(usid, notify_type, notify_type_id) values('$reply_usid','reply','$blog_reply_id')";

        $resultnotify = mysqli_query($conn, $sqlnotification) or die("query for notification failed");

        // if ($resultnotify) {
        //     echo json_encode(array('message' => 'Notifcation Sended.', 'status' => 1));
        // } else {
        //     echo json_encode(array('message' => 'Error In Sending Notifcations.', 'status' => 0));
        // }

    } else {
        echo json_encode(array('message' => 'Error In Adding A Reply To A Comment', 'status' => false));
    }
}

function blog_reply_update($data, $conn)
{
    $blog_comment_id = $data['blog_comment_id'];
    $comment = $data['comment'];

    $sql = "update blog_comments set comment = '$comment' where blog_comment_id = '$blog_comment_id'" or die("sql reply update failed");

    $result = mysqli_query($conn, $sql) or die("query for blog_reply_update failed");

    if ($result) {
        echo json_encode(array('message' => 'Reply Updated', 'status' => 1));
    } else {
        echo json_encode(array('message' => 'Error In Updating A Reply', 'status' => 0));
    }
}

function notify_reply_delete($blog_reply_id, $conn)
{
    $flag = "";

    $sqlnotification_del = "delete from notifications where notify_type = 'reply' and notify_type_id = '$blog_reply_id'";

    $resultnotify_del = mysqli_query($conn, $sqlnotification_del) or die("query for notification failed");

    if ($resultnotify_del) {
        $flag = true;
    } else {
        $flag = false;
    }

    return $flag;
}

function blog_reply_delete($data, $conn)
{
    $blog_reply_id = $data['blog_reply_id'];

    $check = notify_reply_delete($blog_reply_id, $conn);

    if ($check == true) {
        $sql = "update blog_comments set status_up_del = 'deleted' where blog_comment_id = '$blog_reply_id'" or die("sql delete reply failed");

        $result = mysqli_query($conn, $sql) or die("query for delete reply failed");

        if ($result) {
            echo json_encode(array('message' => 'Reply deleted', 'status' => 1));
        } else {

            echo json_encode(array('message' => 'Error In Deleting A Reply', 'status' => 0));
        }
    }


}

function get_reply_comment($data, $conn, $blog_comment_id, $busid, $pcid)
{
    $content = "";
    $usid = 0;
    if (isset($_SESSION['buid'])) {
        $usid = $_SESSION['buid'];
    }
    $blog_id = $data['blog_id'];
    // // $sql = "SELECT b.*,u.* FROM blog_comments b, users u where blog_id = '$blog_id' and parent_comment_id = '$blog_comment_id' and status_up_del = 'inserted'  and u.usid=b.usid order by blog_comment_id asc";
    // $sql = "SELECT blog_comments.*,users.username,
    // count(blog_comment_like_tb.blog_comment_like_id) as likes
    // FROM 
    // blog_comments
    // LEFT JOIN blog_comment_like_tb ON blog_comments.blog_comment_id= blog_comment_like_tb.blog_comment_id 
    // and blog_comment_like_tb.status_clike='clike'
    // LEFT JOIN users ON blog_comments.usid= users.usid
    // where 
    // blog_comments.blog_id = '$blog_id'
    // and parent_comment_id = '$blog_comment_id'
    // and status_up_del = 'inserted' 
    // GROUP BY blog_comments.blog_comment_id
    // order by blog_comment_id desc";
    // $sql = "SELECT bc.*,users.username,
    // count(blog_comment_like_tb.blog_comment_like_id) as likes,
    // count(bcl.blog_comment_id) as comments
    // FROM 
    // blog_comments bc
    // LEFT JOIN blog_comment_like_tb ON bc.blog_comment_id= blog_comment_like_tb.blog_comment_id 
    // and blog_comment_like_tb.status_clike='clike'
    // LEFT JOIN users ON bc.usid= users.usid
    // LEFT JOIN blog_comments bcl ON bcl.parent_comment_id=bc.blog_comment_id and bcl.status_up_del='inserted'
    // where
    // bc.blog_id = '$blog_id'
    // and bc.parent_comment_id = '$blog_comment_id'
    // and bc.status_up_del = 'inserted' 
    // GROUP BY bc.blog_comment_id
    // order by blog_comment_id desc";
    $sql = "select bc.*,u.*,(select COUNT(*) from blog_comment_like_tb bcl where bcl.blog_comment_id =  bc.blog_comment_id and status_clike = 'clike') as likes,(select COUNT(*) from blog_comments bcr where bcr.parent_comment_id =  bc.blog_comment_id and bcr.status_up_del='inserted') AS comments from blog_comments bc,users u WHERE u.usid= bc.usid and bc.blog_id = '$blog_id' and bc.parent_comment_id = '$blog_comment_id' and bc.status_up_del = 'inserted' ORDER BY bc.blog_comment_id desc";

    // $sql = "SELECT * FROM blog_comments where blog_id = '$blog_id' and parent_comment_id = '$blog_comment_id'";
    $resultreply = mysqli_query($conn, $sql);
    // $sql = "SELECT * FROM blog_comments where blog_id = '$blog_id' and parent_comment_id = '$blog_comment_id'";
    // $resultreply = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_assoc($resultreply)) {
        $parid = $row['parent_comment_id'];
        $sqlu = "select username FROM users where usid =(SELECT usid FROM blog_comments WHERE blog_comment_id = '$parid')";
        $resulu = mysqli_query($conn, $sqlu);
        $rows = mysqli_fetch_assoc($resulu);
        $content .= '<div class="d-flex flex-row p-3 ms-5  id = "replyid-' . $row['blog_comment_id'] . '">
                <img src="'.(($row['photo'] == NULL) ? ("../../images/faces/profile/default.png"): ("../../images/faces/profile/".$row['photo'])).'"
                    width="40" height="40"
                    class="rounded-circle mr-3">
                <div class="ms-3">
                </div>
                <div class="w-100">
                    <div
                        class="d-flex justify-content-between align-items-center">
                        <div
                            class="d-flex flex-row align-items-center">
                            <span class="mb-1 fw-bold">' . $row['username'] . '
                            </span>
                            <span class="mb-1 ms-1 text-muted"> to ' . $rows['username'] . '</span>
                        </div>
                        <div class="d-flex flex-row">
                            <small>' . timeConvert($row['time']) . '</small>';
        if ($usid == $busid) {
            $content .= '<small class="ms-2">
                                                    <div class="dropdown"
                                                        align=center>
                                                        <i class="mdi mdi-dots-vertical text-dark"
                                                            type="button"
                                                            id="dropdownMenuSizeButton3"
                                                            data-bs-toggle="dropdown"
                                                            aria-haspopup="true"
                                                            aria-expanded="false"></i>
                                                        <div class="dropdown-menu"
                                                            aria-labelledby="dropdownMenuSizeButton3">
                                                            <h6
                                                                class="dropdown-header">
                                                                Settings
                                                            </h6>
                                            <a class="dropdown-item delete-comment" 
                                            data-id="' . $row['blog_comment_id'] . '"
                                            data-cpid = "' . $pcid . '"
                                            data-type="reply"
                                            >Delete</a>
                                                            
                                                        </div>
                                                    </div>
                                                </small>';
        } elseif ($usid == $row['usid']) {
            $content .= '<small class="ms-2">
                                                    <div class="dropdown"
                                                        align=center>
                                                        <i class="mdi mdi-dots-vertical text-dark"
                                                            type="button"
                                                            id="dropdownMenuSizeButton3"
                                                            data-bs-toggle="dropdown"
                                                            aria-haspopup="true"
                                                            aria-expanded="false"></i>
                                                        <div class="dropdown-menu"
                                                            aria-labelledby="dropdownMenuSizeButton3">
                                                            <h6
                                                                class="dropdown-header">
                                                                Settings
                                                            </h6>
                                            <a class="dropdown-item delete-comment" 
                                            data-id="' . $row['blog_comment_id'] . '"
                                            data-type="reply"
                                            data-cpid = "' . $pcid . '"
                                            >Delete</a>
                                                        </div>
                                                    </div>
                                                </small>';
        }
        $content .= '</div>
                    </div>
                    <span></span>
                    <p class="mb-0 text-muted">
                        <!-- <a class="b">ahdh</a> -->
                        ' . $row['comment'] . '
                    </p>
                    <div class="d-flex flex-row user-feed">';
        $content .= check_comment_like($conn, $row['blog_comment_id'], $row['likes']);
        $content .= '<!-- <span class="ml-3 ms-3"></span> -->
                        <a data-bs-toggle="collapse"
                            data-id="comment-' . $blog_comment_id . '"
                            data-ruid="' . $row['usid'] . '"
                            data-cpid = "' . $pcid . '"
                            data-cid ="' . $row['blog_comment_id'] . '"
                            data-username = "' . $row['username'] . '"
                            id="rcomment-' . $blog_comment_id . '" href="#replay-' . $pcid . '"
                            aria-expanded="false"
                            aria-controls="replay-' . $pcid . '"
                            data-bs-parent="#accordion-2"
                            class="collapsed ms-3 ml-3 show-reply">
                            <span class="ml-3 text-black"><i
                                    class="fa fa-comments-o">&nbsp;
                                    Reply</i></span>
                        </a>
                    </div>
                </div>
            </div>';
        $blog_comment_id1 = $row['blog_comment_id'];
        // $sql1 = "SELECT b.*,u.* FROM blog_comments b, users u where blog_id = '$blog_id' and parent_comment_id = '$blog_comment_id1' and status_up_del = 'inserted' and u.usid=b.usid order by blog_comment_id asc";
        // $sql1 = "SELECT bc.*,users.username,
        // count(blog_comment_like_tb.blog_comment_like_id) as likes,
        // count(bcl.blog_comment_id) as comments
        // FROM 
        // blog_comments bc
        // LEFT JOIN blog_comment_like_tb ON bc.blog_comment_id= blog_comment_like_tb.blog_comment_id 
        // and blog_comment_like_tb.status_clike='clike'
        // LEFT JOIN users ON bc.usid= users.usid
        // LEFT JOIN blog_comments bcl ON bcl.parent_comment_id=bc.blog_comment_id and bcl.status_up_del='inserted'
        // where
        // bc.blog_id = '$blog_id'
        // and bc.parent_comment_id = '$blog_comment_id1'
        // and bc.status_up_del = 'inserted' 
        // GROUP BY bc.blog_comment_id
        // order by blog_comment_id desc";
        $sql1 = "select bc.*,u.*,(select COUNT(*) from blog_comment_like_tb bcl where bcl.blog_comment_id =  bc.blog_comment_id and status_clike = 'clike') as likes,(select COUNT(*) from blog_comments bcr where bcr.parent_comment_id =  bc.blog_comment_id and bcr.status_up_del='inserted') AS comments from blog_comments bc,users u WHERE u.usid= bc.usid and bc.blog_id = '$blog_id' and bc.parent_comment_id = '$blog_comment_id1' and bc.status_up_del = 'inserted' ORDER BY bc.blog_comment_id desc";

        // $sql = "SELECT * FROM blog_comments where blog_id = '$blog_id' and parent_comment_id = '$blog_comment_id'";
        $resultreply1 = mysqli_query($conn, $sql1);
        if (mysqli_num_rows($resultreply1) >= 1) {
            $content .= get_reply_comment($data, $conn, $blog_comment_id1, $busid, $pcid);
        }
    }
    return $content;
}
function check_comment_like($conn, $blog_comment_id, $totallikes)
{
    $usid = 0;
    if (isset($_SESSION['buid'])) {
        $usid = $_SESSION['buid'];
    }
    $content = "";
    $sql = "select *from blog_comment_like_tb where usid = '$usid' and blog_comment_id = '$blog_comment_id' and status_clike='clike'";

    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        $content = '<span class="wish"><a href="" class = "wish addcommentlike" id="commentlike-' . $blog_comment_id . '" data-id="' . $blog_comment_id . '"><i
            class="fa fa-thumbs-up ">&nbsp;' . $totallikes . '</i></a></span>';
    } else {
        $content = '<span class="wish"><a href="" class = "wish addcommentlike" id="commentlike-' . $blog_comment_id . '" data-id="' . $blog_comment_id . '"><i
        class="fa fa-thumbs-o-up ">&nbsp;' . $totallikes . '</i></a></span>';
    }
    return $content;
    //     if (data.likedata.length == 0) {
//         profilecontent += `<i class="fa fa-thumbs-o-up">&nbsp;11</i>`;
//     } else if (data.likedata[0].status_like_dislike == "like") {
//         profilecontent += `<i class="fa fa-thumbs-up">&nbsp;11</i>`;
//     } else {
//         profilecontent += `<i class="fa fa-thumbs-o-up">&nbsp;11</i>`;
//     }
}
function get_comment_content($data, $conn, $result, $blog_id, $usid)
{
    $content = "";
    if (mysqli_num_rows($result) >= 1) {
        while ($rows = mysqli_fetch_assoc($result)) {
            $content .= '<div class="card mb-2" id="comment-' . $rows['blog_comment_id'] . '">
            <div class="d-flex flex-row p-3">
                <img src="'.(($rows['photo'] == NULL) ? ("../../images/faces/profile/default.png"): ("../../images/faces/profile/".$rows['photo'])).'"
                    width="40" height="40"
                    class="rounded-circle mr-3">
                <div class="ms-3">
                </div>
                <div class="w-100">
                    <div
                        class="d-flex justify-content-between align-items-center">
                        <div
                            class="d-flex flex-row align-items-center">
                            <span
                                class="mb-1 fw-bolder">' . $rows['username'] . '</span>
                        </div>
                        <div class="d-flex flex-row">
                            <small>' . timeConvert($rows['time']) . '</small>';
            $sql1 = "SELECT u.* FROM blogs b,users u where u.usid= b.usid and blog_id = '$blog_id'";
            $result1 = mysqli_query($conn, $sql1) or die("query failed");
            $result1 = mysqli_fetch_assoc($result1);
            $busid = $result1['usid'];
            $uphoto = $result1['photo'];
            if ($usid == $busid) {
                $content .= '<small class="ms-2">
                                    <div class="dropdown"
                                        align=center>
                                        <i class="mdi mdi-dots-vertical text-dark"
                                            type="button"
                                            id="dropdownMenuSizeButton3"
                                            data-bs-toggle="dropdown"
                                            aria-haspopup="true"
                                                aria-expanded="false"></i>
                                        <div class="dropdown-menu"
                                            aria-labelledby="dropdownMenuSizeButton3">
                                            <h6
                                                class="dropdown-header">
                                                Settings
                                            </h6>
                                            <a class="dropdown-item delete-comment" 
                                            data-id="' . $rows['blog_comment_id'] . '"
                                            data-type="main"
                                            >Delete</a>
                                        </div>
                                    </div>
                                </small>';
            } elseif ($usid == $rows['usid']) {
                $content .= '<small class="ms-2">
                                    <div class="dropdown"
                                        align=center>
                                        <i class="mdi mdi-dots-vertical text-dark"
                                            type="button"
                                            id="dropdownMenuSizeButton3"
                                            data-bs-toggle="dropdown"
                                            aria-haspopup="true"
                                            aria-expanded="false"></i>
                                        <div class="dropdown-menu"
                                            aria-labelledby="dropdownMenuSizeButton3">
                                            <h6
                                                class="dropdown-header">
                                                Settings
                                            </h6>
                                            <a class="dropdown-item delete-comment" 
                                            data-id="' . $rows['blog_comment_id'] . '"
                                            data-type="main"
                                            >Delete</a>
                                        </div>
                                    </div>
                                </small>';
            }
            $content .= '</div>
                        </div>
                        <p class="mb-0 text-muted">' . $rows['comment'] . '</p>
                        <div
                            class="d-flex flex-row user-feed">
                            <div>';
            $content .= check_comment_like($conn, $rows['blog_comment_id'], $rows['likes']);
            $content .= '<!-- <span class="ml-3 ms-3"></span> -->
                                <a data-bs-toggle="collapse"
                                    data-id="comment-' . $rows['blog_comment_id'] . '"
                                    data-cid ="' . $rows['blog_comment_id'] . '"
                                    data-ruid="' . $rows['usid'] . '"
                                    data-username = "' . $rows['username'] . '"
                                    id="rcomment-' . $rows['blog_comment_id'] . '"
                                    href="#replay-' . $rows['blog_comment_id'] . '"
                                    aria-expanded="false"
                                    aria-controls="replay-' . $rows['blog_comment_id'] . '"
                                    class="collapsed ms-3 ml-3 show-reply">
                                    <span
                                        class="ml-3 text-black"><i
                                            class="fa fa-comments-o">&nbsp;
                                            Reply</i></span>
                                </a>
                            </div>';
            $blog_comment_id = $rows['blog_comment_id'];
            $pcid = $blog_comment_id;
            // SELECT b.*,u.* FROM blog_comments b, users u where blog_id = 30 and parent_comment_id = 0 and u.usid=b.usid order by blog_comment_id asc;
            // $sql = "SELECT b.*,u.* FROM blog_comments b, users u where blog_id = '$blog_id' and parent_comment_id = '$blog_comment_id' and status_up_del = 'inserted' and u.usid=b.usid order by blog_comment_id asc";
            // $sql = "SELECT bc.*,users.username,
            // count(blog_comment_like_tb.blog_comment_like_id) as likes,
            // count(bcl.blog_comment_id) as comments
            // FROM 
            // blog_comments bc
            // LEFT JOIN blog_comment_like_tb ON bc.blog_comment_id= blog_comment_like_tb.blog_comment_id 
            // and blog_comment_like_tb.status_clike='clike'
            // LEFT JOIN users ON bc.usid= users.usid
            // LEFT JOIN blog_comments bcl ON bcl.parent_comment_id=bc.blog_comment_id and bcl.status_up_del='inserted'
            // where
            // bc.blog_id = '$blog_id'
            // and bc.parent_comment_id = '$blog_comment_id'
            // and bc.status_up_del = 'inserted' 
            // GROUP BY bc.blog_comment_id
            // order by blog_comment_id desc";
            $sql = "select bc.*,u.*,(select COUNT(*) from blog_comment_like_tb bcl where bcl.blog_comment_id =  bc.blog_comment_id and status_clike = 'clike') as likes,(select COUNT(*) from blog_comments bcr where bcr.parent_comment_id =  bc.blog_comment_id and bcr.status_up_del='inserted') AS comments from blog_comments bc,users u WHERE u.usid= bc.usid and bc.blog_id = '$blog_id' and bc.parent_comment_id = '$blog_comment_id' and bc.status_up_del = 'inserted' ORDER BY bc.blog_comment_id desc";

            // blog_comments.blog_id = '$blog_id'
            // and parent_comment_id = '$blog_comment_id'
            // $sql = "SELECT * FROM blog_comments where blog_id = '$blog_id' and parent_comment_id = '$blog_comment_id'";
            $resultreply = mysqli_query($conn, $sql);
            if (mysqli_num_rows($resultreply) >= 1) {
                $content .= '<a data-bs-toggle="collapse"
                                data-id="comment-' . $rows['blog_comment_id'] . '" id="ccomment-' . $rows['blog_comment_id'] . '"
                                href="#collapse-' . $rows['blog_comment_id'] . '" 
                                aria-expanded="false"
                                aria-controls="collapse-' . $rows['blog_comment_id'] . '"
                                class="collapsed show-comment">
                                <span class="ml-3"><i
                                        class="fa fa-comments-o">&nbsp;
                                        Show Reply (' . $rows['comments'] . ')</i></span>
                            </a>';
            }
            $content .= '</div>
                    </div>
                </div>';

            if (mysqli_num_rows($resultreply) >= 1) {
                $content .= '<div id="collapse-' . $rows['blog_comment_id'] . '" class="collapse"
                    role="tabpanel" aria-labelledby="heading-4"
                    data-bs-parent="#accordion-2">';
                $content .= get_reply_comment($data, $conn, $blog_comment_id, $busid, $pcid);
                // while ($row = mysqli_fetch_assoc($resultreply)) {
                //     $content .= '<div class="d-flex flex-row p-3 ms-5  id = "replyid-'.$row['blog_comment_id'].'">
                //         <img src="https://i.imgur.com/zQZSWrt.jpg"
                //             width="40" height="40"
                //             class="rounded-circle mr-3">
                //         <div class="ms-3">
                //         </div>
                //         <div class="w-100">
                //             <div
                //                 class="d-flex justify-content-between align-items-center">
                //                 <div
                //                     class="d-flex flex-row align-items-center">
                //                     <span class="mb-1 fw-bold">' . $row['username'] . '</span>
                //                 </div>
                //                 <div class="d-flex flex-row">
                //                     <small>'. timeConvert($value) .'</small>';
                //     if ($usid == $busid) {
                //         $content .= '<small class="ms-2">
                //                                             <div class="dropdown"
                //                                                 align=center>
                //                                                 <i class="mdi mdi-dots-vertical text-dark"
                //                                                     type="button"
                //                                                     id="dropdownMenuSizeButton3"
                //                                                     data-bs-toggle="dropdown"
                //                                                     aria-haspopup="true"
                //                                                     aria-expanded="false"></i>
                //                                                 <div class="dropdown-menu"
                //                                                     aria-labelledby="dropdownMenuSizeButton3">
                //                                                     <h6
                //                                                         class="dropdown-header">
                //                                                         Settings
                //                                                     </h6>
                //                                                     <a class="dropdown-item delete-comment" data-id="' . $row['blog_comment_id'] . '"
                //                                                         href="#">Delete</a>
                //                                                 </div>
                //                                             </div>
                //                                         </small>';
                //     } elseif ($usid == $row['usid']) {
                //         $content .= '<small class="ms-2">
                //                                             <div class="dropdown"
                //                                                 align=center>
                //                                                 <i class="mdi mdi-dots-vertical text-dark"
                //                                                     type="button"
                //                                                     id="dropdownMenuSizeButton3"
                //                                                     data-bs-toggle="dropdown"
                //                                                     aria-haspopup="true"
                //                                                     aria-expanded="false"></i>
                //                                                 <div class="dropdown-menu"
                //                                                     aria-labelledby="dropdownMenuSizeButton3">
                //                                                     <h6
                //                                                         class="dropdown-header">
                //                                                         Settings
                //                                                     </h6>
                //                                                     <a class="dropdown-item delete-comment" data-id="' . $row['blog_comment_id'] . '"
                //                                                         href="#">Delete</a>
                //                                                 </div>
                //                                             </div>
                //                                         </small>';
                //     }
                //     $content .= '</div>
                //             </div>
                //             <span></span>
                //             <p class="mb-0 text-muted">
                //                 <!-- <a class="b">ahdh</a> -->
                //                 ' . $row['comment'] . '
                //             </p>
                //             <div class="d-flex flex-row user-feed">
                //                 <span class="wish"><i
                //                         class="fa fa-thumbs-o-up">&nbsp;11</i></span>
                //                 <a data-bs-toggle="collapse"
                //                     data-id="comment-' . $rows['blog_comment_id'] . '"
                //                     data-ruid="' . $row['usid'] . '"
                //                     data-cpid = "' . $rows['blog_comment_id'] . '"
                //                     data-cid ="' . $row['blog_comment_id'] . '"
                //                     data-username = "'.$row['username'].'"
                //                     id="rcomment-' . $rows['blog_comment_id'] . '" href="#replay-' . $rows['blog_comment_id'] . '"
                //                     aria-expanded="false"
                //                     aria-controls="replay-' . $rows['blog_comment_id'] . '"
                //                     data-bs-parent="#accordion-2"
                //                     class="collapsed ms-3 ml-3 show-reply">
                //                     <span class="ml-3 text-black"><i
                //                             class="fa fa-comments-o">&nbsp;
                //                             Reply</i></span>
                //                 </a>
                //             </div>
                //         </div>
                //     </div>';
                // }

                $content .= '</div>';
            }
            $content .= '<div id="replay-' . $rows['blog_comment_id'] . '" class="collapse"
                    role="tabpanel"
                    aria-labelledby="heading-' . $rows['blog_comment_id'] . '"
                    data-bs-parent="#accordion-2">
                    <span
                        class="ms-5 p-3 text-muted text-medium" id="replyuserdata-' . $rows['blog_comment_id'] . '">reply
                        to username</span>
                    <div class="d-flex p-3 ms-5">
                        <img class="img-sm rounded-10"
                            src="'.(($uphoto == NULL) ? ("../../images/faces/profile/default.png"): ("../../images/faces/profile/".$uphoto)).'"
                            width="30"
                            class="rounded-circle mr-2">
                        <div class="ms-3"></div>
                        <input type="text"
                            class="comment-text-box form-control" id="replyibox-' . $rows['blog_comment_id'] . '"
                            placeholder="Enter your comment">
                        <button
                            class="btn btn-outline-success btn-rounded ms-3 addreply"
                            data-id = "' . $rows['blog_comment_id'] . '"
                            style="height: 48px;"><i
                                class="mdi mdi-send text-dark"></i></button>
                    </div>
                </div>
            </div>';

        }
    }
    return $content;
}
function blog_comment_display($data, $conn)
{
    $content = "";
    $usid = 0;
    if (isset($_SESSION['buid'])) {
        $usid = $_SESSION['buid'];
    }
    $blog_id = $data['blog_id'];
    // $sql = "SELECT bc.*,users.username,
    // count(blog_comment_like_tb.blog_comment_like_id) as likes,
    // count(bcl.blog_comment_id) as comments
    // FROM 
    // blog_comments bc
    // LEFT JOIN blog_comment_like_tb ON bc.blog_comment_id= blog_comment_like_tb.blog_comment_id 
    // and blog_comment_like_tb.status_clike='clike'
    // LEFT JOIN users ON bc.usid= users.usid
    // LEFT JOIN blog_comments bcl ON bcl.parent_comment_id=bc.blog_comment_id and bcl.status_up_del='inserted'
    // where
    // bc.blog_id = '$blog_id'
    // and bc.parent_comment_id = 0
    // and bc.status_up_del = 'inserted' 
    // GROUP BY bc.blog_comment_id
    // order by blog_comment_id desc";
    $sql = "select bc.*,u.*,(select COUNT(*) from blog_comment_like_tb bcl where bcl.blog_comment_id =  bc.blog_comment_id and status_clike = 'clike') as likes,(select COUNT(*) from blog_comments bcr where bcr.parent_comment_id =  bc.blog_comment_id and bcr.status_up_del='inserted') AS comments from blog_comments bc,users u WHERE u.usid= bc.usid and bc.blog_id = '$blog_id' and bc.parent_comment_id = 0 and bc.status_up_del = 'inserted' ORDER BY bc.blog_comment_id desc";

    // $sql = "SELECT b.*,u.* FROM blog_comments b, users u where blog_id = '$blog_id' and parent_comment_id = 0 and status_up_del = 'inserted'  and u.usid=b.usid order by blog_comment_id desc";
    $result = mysqli_query($conn, $sql) or die("query failed");
    // $result =  mysqli_fetch_all($result,MYSQLI_ASSOC);    
    $content = get_comment_content($data, $conn, $result, $blog_id, $usid);
    echo json_encode(array('message' => 'Display comment', 'status' => true, "content" => $content));
}

if ($fkey == "blog_comment") {
    blog_comment($data, $conn);
} elseif ($fkey == "blog_reply") {
    blog_reply($data, $conn);
} elseif ($fkey == "blog_comment_update") {
    blog_comment_update($data, $conn);
} elseif ($fkey == "blog_reply_update") {
    blog_reply_update($data, $conn);
} elseif ($fkey == "blog_comment_delete") {
    blog_comment_delete($data, $conn);
} elseif ($fkey == "blog_reply_delete") {
    blog_reply_delete($data, $conn);
} elseif ($fkey = "blog_comment_display") {
    blog_comment_display($data, $conn);
} else {
    echo json_encode(array('message' => 'Error in sending Comment Api key', 'status' => false));
}
?>