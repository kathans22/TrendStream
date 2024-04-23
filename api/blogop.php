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

function blog_insert($data, $conn)
{
    //$blog_id - increment;
    $usid = 0;
    if (isset($_SESSION['buid'])) {
        $usid = $_SESSION['buid'];
    }
    $bcid = $data['bcid'];
    // // $bcname = $data['bcname'];
    $blog_title = $data['blog_title'];
    $blog_cover_photo = $data['blog_cover_photo'];
    $blog_content = $data['blog_content'];
    $blog_status = $data['blog_status'];
    // //blog_post_time

    $lcode = $data['lcode'];
    $tags = $data['tags'];
    //blog_view
    // echo json_encode(array('data'=> $bcid.$blog_title.$blog_cover_photo.$blog_content.$blog_status.$lcode));

    //INSERT INTO blogs(`usid`, `bcid`, `blog_title`, `blog_cover_photo`, `blog_content`, `blog_status`, `lcode`) VALUES ('9', '1', 'php intro2', 'hi1', 'hello ji2', '1', 'en-GB');

    $sql = "insert into blogs(usid,bcid,blog_title,blog_cover_photo,blog_content,blog_status,lcode,tags) values('$usid','$bcid','$blog_title','$blog_cover_photo','$blog_content','$blog_status','$lcode','$tags')";

    if (mysqli_query($conn, $sql) > 0) {
        $sql = "select * from blogs order by blog_id desc limit 1" or die("query failed");


        $result1 = mysqli_query($conn, $sql) or die("sql query failed");
        $content = "";
        if ($result1) {
            while ($rows = mysqli_fetch_assoc($result1)) {
                $content = $rows['blog_content'];
            }
        }
        echo json_encode(array('message' => 'Blog shared successfully.', 'status' => true, 'content' => $content));
    } else {
        echo json_encode(array('message' => 'Error in Posting a Blog.', 'status' => false));
    }
}


function blog_delete($data, $conn)
{
    $blog_id = $data['blog_id'];

    $sql = "update blogs set blog_status = 'deleted' where blog_id = '$blog_id'";

    if (mysqli_query($conn, $sql) > 0) {
        echo json_encode(array('message' => 'Blog Deleted Successfully.', 'status' => 1));
    } else {
        echo json_encode(array('message' => 'Error in Deleting a Blog.', 'status' => 0));
    }
}

function blog_update($data, $conn)
{
    $blog_id = $data['blog_id'];

    $bcid = $data['bcid'];

    $blog_title = $data['blog_title'];

    $blog_cover_photo = $data['blog_cover_photo'];

    $blog_content = $data['blog_content'];

    $blog_status = $data['blog_status'];

    $tags = $data['tags'];
    //blog_post_time
    $lcode = $data['lcode'];
    $sql = "";
    if ($blog_cover_photo == null) {
        $sql = "update blogs set bcid = '$bcid', blog_title = '$blog_title', tags = '$tags', blog_content = '$blog_content',blog_status = '$blog_status', lcode = '$lcode' where blog_id = '$blog_id'";
    } else {
        $sql = "update blogs set bcid = '$bcid', tags = '$tags',blog_title = '$blog_title',blog_cover_photo = '$blog_cover_photo', blog_content = '$blog_content',blog_status = '$blog_status', lcode = '$lcode' where blog_id = '$blog_id'";
    }
    if (mysqli_query($conn, $sql) > 0) {
        echo json_encode(array('message' => 'Blog Details Updated Successfully.', 'status' => 1));
    } else {
        echo json_encode(array('message' => 'Error in Updating a Blog.', 'status' => 0));
    }
}

function blog_display($data, $conn)
{
    // $uid = $_SESSION['buid'];

    $sql = "";
    $uid = 0;
    if (isset($_SESSION['buid'])) {
        $uid = $_SESSION['buid'];
    }
    // $sql = "select b.*,u.*,(select count(*) from blog_likes bl where bl.blog_id = b.blog_id and bl.status_like_dislike = 'like' ) as likes,
    // (select count(*) from blog_comments bc, users uc where bc.blog_id = b.blog_id and bc.status_up_del = 'inserted' and bc.usid = uc.usid and (uc.user_type = 'user' or uc.user_type = 'blogger')) as comments,
    // (select b.blog_view + COUNT(bv.blog_views_id) from blog_viewstb bv where b.blog_id = bv.blog_id) as totalviews
    // from blogs b,users u where u.usid=b.usid and b.blog_status = 'posted' and b.blog_id NOT IN (SELECT r.report_type_id FROM reports r WHERE r.report_type in ('blog','blog_updated') and r.usid = $uid) order by b.blog_id desc ";
    // $sql = "SELECT b.*,u.username FROM blogs b,users u where u.usid = b.usid ORDER BY b.blog_id DESC";
    $sql = "select b.*,u.*,(select count(*) from blog_likes bl,users ul where bl.blog_id = b.blog_id and bl.status_like_dislike = 'like' and bl.usid = ul.usid and (ul.user_type = 'user' or ul.user_type = 'blogger')) as likes,
    (select count(*) from blog_comments bc, users uc where bc.blog_id = b.blog_id and bc.status_up_del = 'inserted' and bc.usid = uc.usid and (uc.user_type = 'user' or uc.user_type = 'blogger')) as comments,
    (select b.blog_view + COUNT(bv.blog_views_id) from blog_viewstb bv where b.blog_id = bv.blog_id) as totalviews
    from blogs b,users u where u.usid=b.usid and b.blog_status = 'posted' and b.blog_id NOT IN (SELECT r.report_type_id FROM reports r WHERE r.report_type in ('blog','blog_updated') and r.usid = $uid) and u.user_type = 'blogger' order by b.blog_id desc ";

    $result1 = mysqli_query($conn, $sql);
    $result1 = mysqli_fetch_all($result1, MYSQLI_ASSOC);

    $sql = "select *from users where usid = '$uid'";
    $result2 = mysqli_query($conn, $sql);
    $result2 = mysqli_fetch_all($result2, MYSQLI_ASSOC);
    echo json_encode(array('message' => 'Displaying Blogs', 'status' => '1', 'userdata' => $result2, 'allblogsdata' => $result1));

}

function blog_display_for_blogger($data, $conn)
{
    //$usid = $_SESSION['buid'];

    $usid = $data['usid'];

    $sql = "select * from blogs where usid = '$usid'";

    $result = mysqli_query($conn, $sql);

    $result = mysqli_fetch_all($result, MYSQLI_ASSOC);

    echo json_encode(array('message' => 'Displaying Blogs To Blogger', 'status' => '1', 'userallblogsdata' => $result));


}

function blogupdateone($data, $conn)
{

    $blog_id = $data['blog_id'];

    $sql = "select * from blogs where blog_id = '$blog_id'";

    $result = mysqli_query($conn, $sql);

    $result = mysqli_fetch_all($result, MYSQLI_ASSOC);

    echo json_encode(array('message' => 'Single Blog Detail Fetched', 'status' => '1', 'singledata' => $result));

}

function blogreadone($data, $conn)
{
    $blog_id = $data['blog_id'];
    $sql = "SELECT b.*,u.* FROM blogs b,users u where u.usid = b.usid and blog_id = '$blog_id'";

    $result = mysqli_query($conn, $sql);

    $result = mysqli_fetch_all($result, MYSQLI_ASSOC);

    $uid = 0;
    if (isset($_SESSION['buid'])) {
        $uid = $_SESSION['buid'];
    }

    $sql = "select *from users where usid = '$uid'";
    $result2 = mysqli_query($conn, $sql);
    $result2 = mysqli_fetch_all($result2, MYSQLI_ASSOC);
    echo json_encode(array('message' => 'Reading a Blog', 'status' => '1', 'readblogdata' => $result, 'userdata' => $result2));
}
function blogupdateviews($data, $conn)
{
    $blog_id = $data['blog_id'];

    $usid = 0;
    if (isset($_SESSION['buid'])) {
        $usid = $_SESSION['buid'];
    }
    $list_id = "";
    //$sql1 = "insert into save_and_history_blogs(usid,blog_id,type_history_save) values('$usid','$blog_id','history')" or die("sql for insertion in save_and_history_blogs table, failed");


    // if (mysqli_query($conn, $sql) > 0) {
    // $sql = "select * from blogs where blog_id = '$blog_id'";

    // $result = mysqli_query($conn,$sql);

    // $result =  mysqli_fetch_all($result,MYSQLI_ASSOC);

    // echo json_encode(array('message'=>'Reading a Blog','status'=>'1','readblogdata'=> $result));
    // select b.*,u.*,l.lname,c.bcname,(select count(*) from blog_likes bl,users ul where bl.blog_id = b.blog_id and bl.status_like_dislike = 'like' and bl.usid = ul.usid and (ul.user_type = 'user' or ul.user_type = 'blogger')) as likes,
    //         (select count(*) from blog_comments bc, users uc where bc.blog_id = b.blog_id and bc.status_up_del = 'inserted' and bc.usid = uc.usid and (uc.user_type = 'user' or uc.user_type = 'blogger')) as comments
    //         from blogs b,users u,languages l,blog_categorys c where c.bcid = b.bcid and l.lcode=b.lcode and u.usid=b.usid
    $sql1 = "select b.*,u.*,l.lname,c.bcname,(select count(*) from blog_likes bl,users ul where bl.blog_id = b.blog_id and bl.status_like_dislike = 'like' and bl.usid = ul.usid and (ul.user_type = 'user' or ul.user_type = 'blogger')) as likes,
    (select count(*) from blog_comments bc, users uc where bc.blog_id = b.blog_id and bc.status_up_del = 'inserted' and bc.usid = uc.usid and (uc.user_type = 'user' or uc.user_type = 'blogger')) as comments,
    (select b.blog_view + COUNT(bv.blog_views_id) from blog_viewstb bv where b.blog_id = bv.blog_id) as totalviews
    from blogs b,users u,languages l,blog_categorys c where c.bcid = b.bcid and l.lcode=b.lcode and u.usid=b.usid and b.blog_status = 'posted' and b.blog_id NOT IN (SELECT r.report_type_id FROM reports r WHERE r.report_type in ('blog','blog_updated') and r.usid = $usid) and u.user_type = 'blogger' and b.blog_id= $blog_id";
    // $sql1 = "select b.*,u.* from blogs b,users u where b.usid = u.usid and b.blog_id = '$blog_id'";

    //ama blog ni badhi details with views.
    //join query thi users ni details aavse ama.

    $result1 = mysqli_query($conn, $sql1);

    if (mysqli_num_rows($result1) > 0) {
        if ($usid != 0) {
            $sqlnew = "SELECT * FROM lists WHERE usid = '$usid' ORDER BY list_id LIMIT 2 " or die("sql failed");

            $resultnew = mysqli_query($conn, $sqlnew) or die("query failed");

            if (mysqli_num_rows($resultnew) > 0) {
                while ($rows = mysqli_fetch_assoc($resultnew)) {
                    if ('History' == $rows['list_title']) {
                        $list_id = $rows['list_id'];
                    }
                }
            }

            $sqlselect = "select * from lists_content where list_id = '$list_id' and blog_id = '$blog_id'" or die("sql failed");

            $resultselect = mysqli_query($conn, $sqlselect) or die("query failed");

            if (mysqli_num_rows($resultselect) > 0) {
                $sqldel = "delete from lists_content where list_id = '$list_id' and blog_id = '$blog_id'" or die("sql failed");

                $resultdel = mysqli_query($conn, $sqldel) or die("query failed");

            }


            $sql = "select * from blog_viewstb where blog_id = $blog_id and usid = $usid" or die("sql failed");

            $result = mysqli_query($conn, $sql) or die("query failed");

            $count = mysqli_num_rows($result);

            if ($count < 5) {
                $sqli = "insert into blog_viewstb(blog_id,usid) values($blog_id,$usid)" or die("sql failed");

                $result = mysqli_query($conn, $sqli) or die("query failed");
            }


            $sql1 = "insert into lists_content(list_id,blog_id) values('$list_id','$blog_id')" or die("sql for insertion in lists table, failed");
            $result = mysqli_query($conn, $sql1) or die("query failed");
        } else {
            $sql = "update blogs set blog_view = blog_view + 1 where blog_id = '$blog_id'";
            $result = mysqli_query($conn, $sql) or die("query failed");
        }
        $result1 = mysqli_fetch_all($result1, MYSQLI_ASSOC);


        //aa query total likes count kare. blog na
        $sql2 = "select count(*) as 'total_likes in blog' from blog_likes where blog_id = '$blog_id'and status_like_dislike = 'like'";

        $result2 = mysqli_query($conn, $sql2);

        $result2 = mysqli_fetch_all($result2, MYSQLI_ASSOC);


        //aa query total comment count kare. blog na.
        $sql3 = "select count(*) as 'total_comments' from blog_comments where blog_id = '$blog_id'";

        $result3 = mysqli_query($conn, $sql3);

        $result3 = mysqli_fetch_all($result3, MYSQLI_ASSOC);

        //elect blog_id, count(*) from blog_likes GROUP BY blog_id

        //aa query ma darrek comment or reply par ni like male
        $sql4 = "select bc.blog_comment_id, comment ,count(*) as 'total_comment_likes' from blog_comments bc, blog_comment_like_tb bcl where bc.blog_comment_id = bcl.blog_comment_id and bc.blog_id = 2 GROUP by bc.blog_comment_id,comment";

        $result4 = mysqli_query($conn, $sql4);

        $result4 = mysqli_fetch_all($result4, MYSQLI_ASSOC);
        $sql5 = "select *from blog_likes where usid = '$usid' and blog_id = '$blog_id'";

        $result5 = mysqli_query($conn, $sql5);

        $result5 = mysqli_fetch_all($result5, MYSQLI_ASSOC);

        $sql = "select *from users where usid = '$usid'";
        $result6 = mysqli_query($conn, $sql);
        $result6 = mysqli_fetch_all($result6, MYSQLI_ASSOC);

        $sql = "select *from users where usid = '$usid'";
        $result6 = mysqli_query($conn, $sql);
        $result6 = mysqli_fetch_all($result6, MYSQLI_ASSOC);

        $sql = "select b.*,u.*,l.lname,c.bcname,(select count(*) from blog_likes bl,users ul where bl.blog_id = b.blog_id and bl.status_like_dislike = 'like' and bl.usid = ul.usid and (ul.user_type = 'user' or ul.user_type = 'blogger')) as likes,
            (select count(*) from blog_comments bc, users uc where bc.blog_id = b.blog_id and bc.status_up_del = 'inserted' and bc.usid = uc.usid and (uc.user_type = 'user' or uc.user_type = 'blogger')) as comments
            from blogs b,users u,languages l,blog_categorys c where c.bcid = b.bcid and l.lcode=b.lcode and u.usid=b.usid order by blog_view desc";
        $result7 = mysqli_query($conn, $sql);
        $result7 = mysqli_fetch_all($result7, MYSQLI_ASSOC);

        $sql = "select DISTINCT u.*,(select count(bl.blog_id) from blogs bl where bl.usid = u.usid and bl.blog_status = 'posted') as totalblogs 
        from users u,blogs b 
        where 
        b.usid=u.usid and(
        b.blog_status='posted'  
        AND b.bcid in (select bcid FROM blogs where blog_id = $blog_id) or b.lcode in(SELECT lcode FROM blogs WHERE blog_id = $blog_id))";
        $result8 = mysqli_query($conn, $sql);
        $result8 = mysqli_fetch_all($result8, MYSQLI_ASSOC);

        $sql = "SELECT u.*,b.time as liketime from blog_likes b,users u where u.usid=b.usid and b.blog_id = $blog_id and b.status_like_dislike = 'like' order by b.blog_like_id desc";
        $result9 = mysqli_query($conn, $sql);
        $result9 = mysqli_fetch_all($result9, MYSQLI_ASSOC);
        if ($usid != 0) {
            echo json_encode(array('message' => 'Reading a Blog', 'status' => '1', 'readblogdata' => $result1, 'userdata' => $result6, 'likeusersdata' => $result9, 'bloggersdata' => $result8, 'blogsdata' => $result7, 'likedata' => $result5, 'tl' => $result2, 'tc' => $result3, 'tcl' => $result4));
        } else {
            echo json_encode(array('message' => 'Reading a Blog', 'status' => '1', 'readblogdata' => $result1, 'userdata' => [['usid' => 0]], 'likeusersdata' => $result9, 'bloggersdata' => $result8, 'blogsdata' => $result7, 'likedata' => $result5, 'tl' => $result2, 'tc' => $result3, 'tcl' => $result4));
        }
    } else {
        echo json_encode(array('message' => 'Error in Displaying a Blog.', 'status' => 0));
    }
    // } else {
    //     echo json_encode(array('message' => 'Error in Displaying a Blog.', 'status' => 0));
    // }
}
// function blogupdateviews($data,$conn)
// {
//     $blog_id = $data['blog_id'];

//     $usid = $_SESSION['buid'];

//     $sql = "update blogs set blog_view = blog_view + 1 where blog_id = '$blog_id'";

//     $sql1 = "insert into save_and_history_blogs(usid,blog_id,type_history_save) values('$usid','$blog_id','history')" or die("sql for insertion in save_and_history_blogs table, failed");

//     $result = mysqli_query($conn,$sql1) or die("query failed");

//     if((mysqli_query($conn, $sql) > 0) && $result > 0)
//     {
// 	    // $sql = "select * from blogs where blog_id = '$blog_id'";

//         // $result = mysqli_query($conn,$sql);

//         // $result =  mysqli_fetch_all($result,MYSQLI_ASSOC);

//         // echo json_encode(array('message'=>'Reading a Blog','status'=>'1','readblogdata'=> $result));

//         $sql1 = "select b.*,u.* from blogs b,users u where b.usid = u.usid and b.blog_id = '$blog_id'";

//         //ama blog ni badhi details with views.
//         //join query thi users ni details aavse ama.

//         $result1 = mysqli_query($conn,$sql1);

//         $result1 =  mysqli_fetch_all($result1,MYSQLI_ASSOC);

//         //aa query total likes count kare. blog na
//         $sql2 = "select count(*) as 'total_likes' from blog_likes where blog_id = '$blog_id'and status_like_dislike = 'like'";

//         $result2 = mysqli_query($conn,$sql2);

//         $result2 =  mysqli_fetch_all($result2,MYSQLI_ASSOC);


//         //aa query total comment count kare. blog na.
//         $sql3 = "select count(*) as 'total_comments' from blog_comments where blog_id = '$blog_id'";

//         $result3 = mysqli_query($conn,$sql3);

//         $result3 =  mysqli_fetch_all($result3,MYSQLI_ASSOC);

//         //elect blog_id, count(*) from blog_likes GROUP BY blog_id

//         //aa query ma darrek comment or reply par ni like male
//         $sql4 = "select bc.blog_comment_id, comment ,count(*) as 'total_comment_likes' from blog_comments bc, blog_comment_like_tb bcl where bc.blog_comment_id = bcl.blog_comment_id and bc.blog_id = {$blog_id} GROUP by bc.blog_comment_id,comment";

//         $result4 = mysqli_query($conn,$sql4);

//         $result4 =  mysqli_fetch_all($result4,MYSQLI_ASSOC);

//         $sql5 = "select *from blog_likes where usid = '$usid' and blog_id = '$blog_id'";

//         $result5 = mysqli_query($conn,$sql5);

//         $result5 =  mysqli_fetch_all($result5,MYSQLI_ASSOC);

//         $sql = "select *from users where usid = '$usid'";
//         $result6 = mysqli_query($conn,$sql);
//         $result6 =  mysqli_fetch_all($result6,MYSQLI_ASSOC);

//         echo json_encode(array('message'=>'Reading a Blog','status'=>'1','readblogdata'=> $result1,'userdata'=>$result6,'likedata'=>$result5 ,'tl'=> $result2,'tc'=>$result3,'tcl'=>$result4));
//     }
//     else
//     {
// 	    echo json_encode(array('message' => 'Error in Displaying a Blog.' , 'status' => 0));
//     }
// }

// function blogsearch($data,$conn)
// {

// }

function my_blog_show($conn)
{
    $usid = 0;
    if(isset($_SESSION['buid']))
    {
        $usid = $_SESSION['buid'];
    }
    // $sql = "select b.*,u.*,(select count(*) from blog_likes bl,users ul where bl.blog_id = b.blog_id and bl.status_like_dislike = 'like' and bl.usid = ul.usid and (ul.user_type = 'user' or ul.user_type = 'blogger')) as likes,
    // (select count(*) from blog_comments bc, users uc where bc.blog_id = b.blog_id and bc.status_up_del = 'inserted' and bc.usid = uc.usid and (uc.user_type = 'user' or uc.user_type = 'blogger')) as comments,
    // (select b.blog_view + COUNT(bv.blog_views_id) from blog_viewstb bv where b.blog_id = bv.blog_id) as totalviews
    // from blogs b,users u where u.usid=b.usid and b.blog_status = 'posted' and b.blog_id NOT IN (SELECT r.report_type_id FROM reports r WHERE r.report_type in ('blog','blog_updated') and r.usid = $uid) and u.user_type = 'blogger' order by b.blog_id desc"
    $sql = "select b.*,u.*,(select count(*) from blog_likes bl,users ul where bl.blog_id = b.blog_id and bl.status_like_dislike = 'like' and bl.usid = ul.usid and (ul.user_type = 'user' or ul.user_type = 'blogger')) as likes,
    (select count(*) from blog_comments bc, users uc where bc.blog_id = b.blog_id and bc.status_up_del = 'inserted' and bc.usid = uc.usid and (uc.user_type = 'user' or uc.user_type = 'blogger')) as comments,
    (select b.blog_view + COUNT(bv.blog_views_id) from blog_viewstb bv where b.blog_id = bv.blog_id) as totalviews
    from blogs b,users u where u.usid=b.usid and b.usid = $usid order by b.blog_id desc";
    // $sql = "SELECT b.*,u.username FROM blogs b,users u where u.usid = b.usid ORDER BY b.blog_id DESC";
    $result1 = mysqli_query($conn, $sql);
    if ($result1) {
        $sql = "select *from users where usid = '$usid'";
        $result2 = mysqli_query($conn, $sql);
        if ($result2) {
            $result1 = mysqli_fetch_all($result1, MYSQLI_ASSOC);
            $result2 = mysqli_fetch_all($result2, MYSQLI_ASSOC);
            echo json_encode(array('message' => 'Displaying Blogs', 'status' => true, 'userdata' => $result2, 'allblogsdata' => $result1));
        } else
            echo json_encode(array('message' => 'Displaying Blogs in error.', 'status' => false));
    } else
        echo json_encode(array('message' => 'Displaying Blogs in error.', 'status' => false));

}

function load_cat_lag($data, $conn)
{
    $sql = "select * from blog_categorys";
    $result1 = mysqli_query($conn, $sql);
    $result1 = mysqli_fetch_all($result1, MYSQLI_ASSOC);
    $sql = "select * from languages";
    $result2 = mysqli_query($conn, $sql);
    $result2 = mysqli_fetch_all($result2, MYSQLI_ASSOC);
    echo json_encode(array('message' => 'Displaying category and language', 'status' => '1', 'categorydata' => $result1, 'languagesdata' => $result2));
}

function blog_like_data($data, $conn)
{
    $blog_id = $data['blogid'];
    $sql = "SELECT * from users u where u.usid in(SELECT usid from blog_likes b where b.blog_id = $blog_id)";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        $result = mysqli_fetch_all($result, MYSQLI_ASSOC);
        echo json_encode(array('message' => 'Get likes data error in query.', 'status' => true, 'usersdata' => $result));
    } else {
        echo json_encode(array('message' => 'Get likes data error in query.', 'status' => false));
    }
}

function filter_blog($data, $conn)
{
    $lcode = $data['language'];
    $bcid = $data['category'];
    $sql = "";
    $uid = 0;
    if (isset($_SESSION['buid'])) {
        $uid = $_SESSION['buid'];
    }
    if ($lcode != null || $bcid != null) {
        if ($lcode != null && $bcid != null) {
            $sql = "select b.*,u.*,(select count(*) from blog_likes bl,users ul where bl.blog_id = b.blog_id and bl.status_like_dislike = 'like' and bl.usid = ul.usid and (ul.user_type = 'user' or ul.user_type = 'blogger')) as likes,
            (select count(*) from blog_comments bc, users uc where bc.blog_id = b.blog_id and bc.status_up_del = 'inserted' and bc.usid = uc.usid and (uc.user_type = 'user' or uc.user_type = 'blogger')) as comments,
            (select b.blog_view + COUNT(bv.blog_views_id) from blog_viewstb bv where b.blog_id = bv.blog_id) as totalviews
            from blogs b,users u where u.usid=b.usid and u.user_type = 'blogger' and b.blog_status = 'posted' and b.lcode = '$lcode' and b.bcid = $bcid and b.blog_id NOT IN (SELECT r.report_type_id FROM reports r WHERE r.report_type in ('blog','blog_updated') and r.usid = $uid) order by b.blog_id desc ";
        } else if ($lcode == null) {
            $sql = "select b.*,u.*,(select count(*) from blog_likes bl,users ul where bl.blog_id = b.blog_id and bl.status_like_dislike = 'like' and bl.usid = ul.usid and (ul.user_type = 'user' or ul.user_type = 'blogger')) as likes,
            (select count(*) from blog_comments bc, users uc where bc.blog_id = b.blog_id and bc.status_up_del = 'inserted' and bc.usid = uc.usid and (uc.user_type = 'user' or uc.user_type = 'blogger')) as comments,
            (select b.blog_view + COUNT(bv.blog_views_id) from blog_viewstb bv where b.blog_id = bv.blog_id) as totalviews
            from blogs b,users u where u.usid=b.usid and u.user_type = 'blogger' and b.blog_status = 'posted' and b.bcid = $bcid and b.blog_id NOT IN (SELECT r.report_type_id FROM reports r WHERE r.report_type in ('blog','blog_updated') and r.usid = $uid) order by b.blog_id desc ";
        } else if ($bcid == null) {
            $sql = "select b.*,u.*,(select count(*) from blog_likes bl,users ul where bl.blog_id = b.blog_id and bl.status_like_dislike = 'like' and bl.usid = ul.usid and (ul.user_type = 'user' or ul.user_type = 'blogger')) as likes,
            (select count(*) from blog_comments bc, users uc where bc.blog_id = b.blog_id and bc.status_up_del = 'inserted' and bc.usid = uc.usid and (uc.user_type = 'user' or uc.user_type = 'blogger')) as comments,
            (select b.blog_view + COUNT(bv.blog_views_id) from blog_viewstb bv where b.blog_id = bv.blog_id) as totalviews
            from blogs b,users u where u.usid=b.usid and u.user_type = 'blogger' and b.blog_status = 'posted' and b.lcode = '$lcode' and b.blog_id NOT IN (SELECT r.report_type_id FROM reports r WHERE r.report_type in ('blog','blog_updated') and r.usid = $uid) order by b.blog_id desc ";
        }
    } else {
        $sql = "select b.*,u.*,(select count(*) from blog_likes bl,users ul where bl.blog_id = b.blog_id and bl.status_like_dislike = 'like' and bl.usid = ul.usid and (ul.user_type = 'user' or ul.user_type = 'blogger')) as likes,
        (select count(*) from blog_comments bc, users uc where bc.blog_id = b.blog_id and bc.status_up_del = 'inserted' and bc.usid = uc.usid and (uc.user_type = 'user' or uc.user_type = 'blogger')) as comments,
        (select b.blog_view + COUNT(bv.blog_views_id) from blog_viewstb bv where b.blog_id = bv.blog_id) as totalviews
        from blogs b,users u where u.usid=b.usid and u.user_type = 'blogger' and b.blog_status = 'posted' and b.blog_id NOT IN (SELECT r.report_type_id FROM reports r WHERE r.report_type in ('blog','blog_updated') and r.usid = $uid) order by b.blog_id desc ";
    }
    // $sql = "SELECT b.*,u.username FROM blogs b,users u where u.usid = b.usid ORDER BY b.blog_id DESC";

    $result1 = mysqli_query($conn, $sql);
    $result1 = mysqli_fetch_all($result1, MYSQLI_ASSOC);

    $sql = "select *from users where usid = '$uid'";
    $result2 = mysqli_query($conn, $sql);
    $result2 = mysqli_fetch_all($result2, MYSQLI_ASSOC);
    echo json_encode(array('message' => 'Displaying Blogs', 'status' => true, 'userdata' => $result2, 'allblogsdata' => $result1));
}
function liked_blog_display($data, $conn)
{
    $usid = 0;
    if (isset($_SESSION['buid'])) {
        $usid = $_SESSION['buid'];
    }
    
    $sql = "select b.*,u.*,bl.blog_like_id,
        (select count(*) from blog_likes bll,users ul where bll.blog_id = b.blog_id and bll.status_like_dislike = 'like' and bl.usid = ul.usid and (ul.user_type = 'user' or ul.user_type = 'blogger')) as likes,
        (select count(*) from blog_comments bc, users uc where bc.blog_id = b.blog_id and bc.status_up_del = 'inserted' and bc.usid = uc.usid and (uc.user_type = 'user' or uc.user_type = 'blogger')) as comments,
        (select b.blog_view + COUNT(bv.blog_views_id) from blog_viewstb bv where b.blog_id = bv.blog_id) as totalviews
        from 
        blogs b,users u,blog_likes bl
        where b.blog_status = 'posted' and u.usid=b.usid and b.blog_id=bl.blog_id and bl.usid = $usid and u.user_type = 'blogger'
        ORDER by bl.blog_like_id DESC";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        $result = mysqli_fetch_all($result, MYSQLI_ASSOC);
        echo json_encode(array('message' => 'Liked blog data', 'status' => true, 'listcontent' => $result));
    } else {
        echo json_encode(array('message' => 'Liked blog data', 'status' => false));
    }
}
function bookmarked_blog_display($conn)
{
    $usid = 0;
    if (isset($_SESSION['buid'])) {
        $usid = $_SESSION['buid'];
    }

    $sql = "select b.*,u.*,bk.bmid,
        (select count(*) from blog_likes bl,users ul where bl.blog_id = b.blog_id and bl.status_like_dislike = 'like' and bl.usid = ul.usid and (ul.user_type = 'user' or ul.user_type = 'blogger')) as likes,
        (select count(*) from blog_comments bc, users uc where bc.blog_id = b.blog_id and bc.status_up_del = 'inserted' and bc.usid = uc.usid and (uc.user_type = 'user' or uc.user_type = 'blogger')) as comments,
        (select b.blog_view + COUNT(bv.blog_views_id) from blog_viewstb bv where b.blog_id = bv.blog_id) as totalviews
        from 
        blogs b,users u,bookmarktb bk
        where b.blog_status = 'posted' and u.usid=b.usid and b.blog_id=bk.blog_id and bk.usid = $usid and u.user_type = 'blogger'
        ORDER by bk.bmid DESC";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        $result = mysqli_fetch_all($result, MYSQLI_ASSOC);
        echo json_encode(array('message' => 'Liked blog data', 'status' => true, 'listcontent' => $result));
    } else {
        echo json_encode(array('message' => 'Liked blog data', 'status' => false));
    }
}

if ($fkey == "blog_insert") {
    blog_insert($data, $conn);
} elseif ($fkey == "blog_update") {
    blog_update($data, $conn);
} elseif ($fkey == "blog_delete") {
    blog_delete($data, $conn);
} elseif ($fkey == "blog_display") {
    blog_display($data, $conn);
} elseif ($fkey == "filter_blog") {
    filter_blog($data, $conn);
} elseif ($fkey == "blog_display_for_blogger") {
    blog_display_for_blogger($data, $conn);
} elseif ($fkey == "blog_update_one") {
    blogupdateone($data, $conn);
} elseif ($fkey == "blog_read_one") {
    blogreadone($data, $conn);
} elseif ($fkey == "blog_update_views") {
    blogupdateviews($data, $conn);
} elseif ($fkey == "blog_cat_lan") {
    load_cat_lag($data, $conn);
} elseif ($fkey == "my_blog_show") {
    my_blog_show($conn);
} elseif ($fkey == "blog_like_data") {
    blog_like_data($data, $conn);
} elseif ($fkey == "liked_blog_display") {
    liked_blog_display($data, $conn);
} elseif($fkey == "bookmarked_blog_display"){
    bookmarked_blog_display($conn);
}else {
    echo json_encode(array('message' => 'Error in sending Blog Api key', 'status' => false));
}

?>