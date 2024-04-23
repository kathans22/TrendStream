<?php

use PHPMailer\PHPMailer\Exception;

use PHPMailer\PHPMailer\PHPMailer;


require '../phpmailer/src/Exception.php';
require '../phpmailer/src/PHPMailer.php';
require '../phpmailer/src/SMTP.php';


header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Methods: DELETE');
header('Access-Control-Allow-Methods: PUT');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

$data = json_decode(file_get_contents("php://input"), true);

$fkey = $data['key'];

include "../config.php";

function display_all_blog($conn)
{
    $sql = "select * from blogs" or die("query failed");

    $result = mysqli_query($conn, $sql) or die("query failed");

    $result1 = mysqli_fetch_all($result, MYSQLI_ASSOC);

    if ($result) {
        echo json_encode(array('message' => 'Displaying All Blogs Details', 'status' => true, 'allblogsdata' => $result1, 'k1' => 'allblogsdisplay'));
    } else {
        echo json_encode(array('message' => 'Error In Displaying All Blogs Details', 'status' => false));
    }



}


function display_draft($data, $conn)
{
    $index = $data['index'];

    $limit = 10;

    $offset = $index * $limit;
    $category = $data['category'];
    $language = $data['language'];
    $search = $data['searchvalue'];
    if ($category != null || $language != null || $search != null) {
        if ($category != null && $language != null && $search != null) {
            $sql = "select b.*,u.*,l.lname,c.bcname,(select count(*) from blog_likes bl where bl.blog_id = b.blog_id and bl.status_like_dislike = 'like') as likes,
            (select count(*) from blog_comments bc where bc.blog_id = b.blog_id and bc.status_up_del = 'inserted') as comments
            from blogs b,users u,languages l,blog_categorys c where b.blog_status = 'drafted' and c.bcid = b.bcid and l.lcode=b.lcode and u.usid=b.usid and b.bcid = $category and b.lcode = '$language' and (b.blog_title LIKE '%$search%' or b.usid in (select usid from users where username LIKE '%$search%')) LIMIT $limit OFFSET $offset";
        } else if ($category != null && $language != null) {
            $sql = "select b.*,u.*,l.lname,c.bcname,(select count(*) from blog_likes bl where bl.blog_id = b.blog_id and bl.status_like_dislike = 'like') as likes,
            (select count(*) from blog_comments bc where bc.blog_id = b.blog_id and bc.status_up_del = 'inserted') as comments
            from blogs b,users u,languages l,blog_categorys c where b.blog_status = 'drafted' and c.bcid = b.bcid and l.lcode=b.lcode and u.usid=b.usid and b.bcid = $category and b.lcode = '$language' LIMIT $limit OFFSET $offset";
        } else if ($category != null && $search != null) {
            $sql = "select b.*,u.*,l.lname,c.bcname,(select count(*) from blog_likes bl where bl.blog_id = b.blog_id and bl.status_like_dislike = 'like') as likes,
            (select count(*) from blog_comments bc where bc.blog_id = b.blog_id and bc.status_up_del = 'inserted') as comments
            from blogs b,users u,languages l,blog_categorys c where b.blog_status = 'drafted' and c.bcid = b.bcid and l.lcode=b.lcode and u.usid=b.usid and b.bcid = $category and (b.blog_title LIKE '%$search%' or b.usid in (select usid from users where username LIKE '%$search%')) LIMIT $limit OFFSET $offset";
        } else if ($language != null && $search != null) {
            $sql = "select b.*,u.*,l.lname,c.bcname,(select count(*) from blog_likes bl where bl.blog_id = b.blog_id and bl.status_like_dislike = 'like') as likes,
            (select count(*) from blog_comments bc where bc.blog_id = b.blog_id and bc.status_up_del = 'inserted') as comments
            from blogs b,users u,languages l,blog_categorys c where b.blog_status = 'drafted' and c.bcid = b.bcid and l.lcode=b.lcode and u.usid=b.usid and b.lcode = '$language' and (b.blog_title LIKE '%$search%' or b.usid in (select usid from users where username LIKE '%$search%')) LIMIT $limit OFFSET $offset";
        } else if ($language == null && $search == null) {
            $sql = "select b.*,u.*,l.lname,c.bcname,(select count(*) from blog_likes bl where bl.blog_id = b.blog_id and bl.status_like_dislike = 'like') as likes,
            (select count(*) from blog_comments bc where bc.blog_id = b.blog_id and bc.status_up_del = 'inserted') as comments
            from blogs b,users u,languages l,blog_categorys c where b.blog_status = 'drafted' and c.bcid = b.bcid and l.lcode=b.lcode and u.usid=b.usid and b.bcid = $category LIMIT $limit OFFSET $offset";
        } else if ($category == null && $search == null) {
            $sql = "select b.*,u.*,l.lname,c.bcname,(select count(*) from blog_likes bl where bl.blog_id = b.blog_id and bl.status_like_dislike = 'like') as likes,
            (select count(*) from blog_comments bc where bc.blog_id = b.blog_id and bc.status_up_del = 'inserted') as comments
            from blogs b,users u,languages l,blog_categorys c where b.blog_status = 'drafted' and c.bcid = b.bcid and l.lcode=b.lcode and u.usid=b.usid and b.lcode = '$language' LIMIT $limit OFFSET $offset";
        } else if ($category == null && $language == null) {
            $sql = "select b.*,u.*,l.lname,c.bcname,(select count(*) from blog_likes bl where bl.blog_id = b.blog_id and bl.status_like_dislike = 'like') as likes,
            (select count(*) from blog_comments bc where bc.blog_id = b.blog_id and bc.status_up_del = 'inserted') as comments
            from blogs b,users u,languages l,blog_categorys c where b.blog_status = 'drafted' and c.bcid = b.bcid and l.lcode=b.lcode and u.usid=b.usid and (b.blog_title LIKE '%$search%' or b.usid in (select usid from users where username LIKE '%$search%')) LIMIT $limit OFFSET $offset";
        }
    } else {
        $sql = "select b.*,u.*,l.lname,c.bcname,(select count(*) from blog_likes bl where bl.blog_id = b.blog_id and bl.status_like_dislike = 'like') as likes,
        (select count(*) from blog_comments bc where bc.blog_id = b.blog_id and bc.status_up_del = 'inserted') as comments
        from blogs b,users u,languages l,blog_categorys c where b.blog_status = 'drafted' and c.bcid = b.bcid and l.lcode=b.lcode and u.usid=b.usid LIMIT $limit OFFSET $offset";
    }

    $result = mysqli_query($conn, $sql) or die("query failed");
    $sql = "select * from blog_categorys";
    $result1 = mysqli_query($conn, $sql);
    $result1 = mysqli_fetch_all($result1, MYSQLI_ASSOC);
    $sql = "select * from languages";
    $result2 = mysqli_query($conn, $sql);
    $result2 = mysqli_fetch_all($result2, MYSQLI_ASSOC);

    if ($result) {
        $result = mysqli_fetch_all($result, MYSQLI_ASSOC);
        echo json_encode(array('message' => 'Displaying Active Blogs Details', 'status' => true, 'blogs' => $result, 'categorys' => $result1, 'languages' => $result2));
    } else {
        echo json_encode(array('message' => 'Error In Displaying Active Blogs Details Or Else No Record Founded', 'status' => false));
    }
}

function display_active($data, $conn)
{
    $index = $data['index'];

    $limit = 10;

    $offset = $index * $limit;
    $category = $data['category'];
    $language = $data['language'];
    $search = $data['searchvalue'];
    if ($category != null || $language != null || $search != null) {
        if ($category != null && $language != null && $search != null) {
            $sql = "select b.*,u.*,l.lname,c.bcname,(select count(*) from blog_likes bl where bl.blog_id = b.blog_id and bl.status_like_dislike = 'like') as likes,
            (select count(*) from blog_comments bc where bc.blog_id = b.blog_id and bc.status_up_del = 'inserted') as comments
            from blogs b,users u,languages l,blog_categorys c where b.blog_status = 'posted' and c.bcid = b.bcid and l.lcode=b.lcode and u.usid=b.usid and b.bcid = $category and b.lcode = '$language' and (b.blog_title LIKE '%$search%' or b.usid in (select usid from users where username LIKE '%$search%')) LIMIT $limit OFFSET $offset";
        } else if ($category != null && $language != null) {
            $sql = "select b.*,u.*,l.lname,c.bcname,(select count(*) from blog_likes bl where bl.blog_id = b.blog_id and bl.status_like_dislike = 'like') as likes,
            (select count(*) from blog_comments bc where bc.blog_id = b.blog_id and bc.status_up_del = 'inserted') as comments
            from blogs b,users u,languages l,blog_categorys c where b.blog_status = 'posted' and c.bcid = b.bcid and l.lcode=b.lcode and u.usid=b.usid and b.bcid = $category and b.lcode = '$language' LIMIT $limit OFFSET $offset";
        } else if ($category != null && $search != null) {
            $sql = "select b.*,u.*,l.lname,c.bcname,(select count(*) from blog_likes bl where bl.blog_id = b.blog_id and bl.status_like_dislike = 'like') as likes,
            (select count(*) from blog_comments bc where bc.blog_id = b.blog_id and bc.status_up_del = 'inserted') as comments
            from blogs b,users u,languages l,blog_categorys c where b.blog_status = 'posted' and c.bcid = b.bcid and l.lcode=b.lcode and u.usid=b.usid and b.bcid = $category and (b.blog_title LIKE '%$search%' or b.usid in (select usid from users where username LIKE '%$search%')) LIMIT $limit OFFSET $offset";
        } else if ($language != null && $search != null) {
            $sql = "select b.*,u.*,l.lname,c.bcname,(select count(*) from blog_likes bl where bl.blog_id = b.blog_id and bl.status_like_dislike = 'like') as likes,
            (select count(*) from blog_comments bc where bc.blog_id = b.blog_id and bc.status_up_del = 'inserted') as comments
            from blogs b,users u,languages l,blog_categorys c where b.blog_status = 'posted' and c.bcid = b.bcid and l.lcode=b.lcode and u.usid=b.usid and b.lcode = '$language' and (b.blog_title LIKE '%$search%' or b.usid in (select usid from users where username LIKE '%$search%')) LIMIT $limit OFFSET $offset";
        } else if ($language == null && $search == null) {
            $sql = "select b.*,u.*,l.lname,c.bcname,(select count(*) from blog_likes bl where bl.blog_id = b.blog_id and bl.status_like_dislike = 'like') as likes,
            (select count(*) from blog_comments bc where bc.blog_id = b.blog_id and bc.status_up_del = 'inserted') as comments
            from blogs b,users u,languages l,blog_categorys c where b.blog_status = 'posted' and c.bcid = b.bcid and l.lcode=b.lcode and u.usid=b.usid and b.bcid = $category LIMIT $limit OFFSET $offset";
        } else if ($category == null && $search == null) {
            $sql = "select b.*,u.*,l.lname,c.bcname,(select count(*) from blog_likes bl where bl.blog_id = b.blog_id and bl.status_like_dislike = 'like') as likes,
            (select count(*) from blog_comments bc where bc.blog_id = b.blog_id and bc.status_up_del = 'inserted') as comments
            from blogs b,users u,languages l,blog_categorys c where b.blog_status = 'posted' and c.bcid = b.bcid and l.lcode=b.lcode and u.usid=b.usid and b.lcode = '$language' LIMIT $limit OFFSET $offset";
        } else if ($category == null && $language == null) {
            $sql = "select b.*,u.*,l.lname,c.bcname,(select count(*) from blog_likes bl where bl.blog_id = b.blog_id and bl.status_like_dislike = 'like') as likes,
            (select count(*) from blog_comments bc where bc.blog_id = b.blog_id and bc.status_up_del = 'inserted') as comments
            from blogs b,users u,languages l,blog_categorys c where b.blog_status = 'posted' and c.bcid = b.bcid and l.lcode=b.lcode and u.usid=b.usid and (b.blog_title LIKE '%$search%' or b.usid in (select usid from users where username LIKE '%$search%')) LIMIT $limit OFFSET $offset";
        }
    } else {
        $sql = "select b.*,u.*,l.lname,c.bcname,(select count(*) from blog_likes bl where bl.blog_id = b.blog_id and bl.status_like_dislike = 'like') as likes,
        (select count(*) from blog_comments bc where bc.blog_id = b.blog_id and bc.status_up_del = 'inserted') as comments
        from blogs b,users u,languages l,blog_categorys c where b.blog_status = 'posted' and c.bcid = b.bcid and l.lcode=b.lcode and u.usid=b.usid LIMIT $limit OFFSET $offset";
    }

    $result = mysqli_query($conn, $sql) or die("query failed");
    $sql = "select * from blog_categorys";
    $result1 = mysqli_query($conn, $sql);
    $result1 = mysqli_fetch_all($result1, MYSQLI_ASSOC);
    $sql = "select * from languages";
    $result2 = mysqli_query($conn, $sql);
    $result2 = mysqli_fetch_all($result2, MYSQLI_ASSOC);

    if ($result) {
        $result = mysqli_fetch_all($result, MYSQLI_ASSOC);
        echo json_encode(array('message' => 'Displaying Active Blogs Details', 'status' => true, 'blogs' => $result, 'categorys' => $result1, 'languages' => $result2));
    } else {
        echo json_encode(array('message' => 'Error In Displaying Active Blogs Details Or Else No Record Founded', 'status' => false));
    }
}
function display_deleted($data, $conn)
{
    $index = $data['index'];

    $limit = 10;

    $offset = $index * $limit;
    $category = $data['category'];
    $language = $data['language'];
    $search = $data['searchvalue'];
    if ($category != null || $language != null || $search != null) {
        if ($category != null && $language != null && $search != null) {
            $sql = "select b.*,u.*,l.lname,c.bcname,(select count(*) from blog_likes bl where bl.blog_id = b.blog_id and bl.status_like_dislike = 'like') as likes,
            (select count(*) from blog_comments bc where bc.blog_id = b.blog_id and bc.status_up_del = 'inserted') as comments
            from blogs b,users u,languages l,blog_categorys c where b.blog_status = 'deleted' and c.bcid = b.bcid and l.lcode=b.lcode and u.usid=b.usid and b.bcid = $category and b.lcode = '$language' and (b.blog_title LIKE '%$search%' or b.usid in (select usid from users where username LIKE '%$search%')) LIMIT $limit OFFSET $offset";
        } else if ($category != null && $language != null) {
            $sql = "select b.*,u.*,l.lname,c.bcname,(select count(*) from blog_likes bl where bl.blog_id = b.blog_id and bl.status_like_dislike = 'like') as likes,
            (select count(*) from blog_comments bc where bc.blog_id = b.blog_id and bc.status_up_del = 'inserted') as comments
            from blogs b,users u,languages l,blog_categorys c where b.blog_status = 'deleted' and c.bcid = b.bcid and l.lcode=b.lcode and u.usid=b.usid and b.bcid = $category and b.lcode = '$language' LIMIT $limit OFFSET $offset";
        } else if ($category != null && $search != null) {
            $sql = "select b.*,u.*,l.lname,c.bcname,(select count(*) from blog_likes bl where bl.blog_id = b.blog_id and bl.status_like_dislike = 'like') as likes,
            (select count(*) from blog_comments bc where bc.blog_id = b.blog_id and bc.status_up_del = 'inserted') as comments
            from blogs b,users u,languages l,blog_categorys c where b.blog_status = 'deleted' and c.bcid = b.bcid and l.lcode=b.lcode and u.usid=b.usid and b.bcid = $category and (b.blog_title LIKE '%$search%' or b.usid in (select usid from users where username LIKE '%$search%')) LIMIT $limit OFFSET $offset";
        } else if ($language != null && $search != null) {
            $sql = "select b.*,u.*,l.lname,c.bcname,(select count(*) from blog_likes bl where bl.blog_id = b.blog_id and bl.status_like_dislike = 'like') as likes,
            (select count(*) from blog_comments bc where bc.blog_id = b.blog_id and bc.status_up_del = 'inserted') as comments
            from blogs b,users u,languages l,blog_categorys c where b.blog_status = 'deleted' and c.bcid = b.bcid and l.lcode=b.lcode and u.usid=b.usid and b.lcode = '$language' and (b.blog_title LIKE '%$search%' or b.usid in (select usid from users where username LIKE '%$search%')) LIMIT $limit OFFSET $offset";
        } else if ($language == null && $search == null) {
            $sql = "select b.*,u.*,l.lname,c.bcname,(select count(*) from blog_likes bl where bl.blog_id = b.blog_id and bl.status_like_dislike = 'like') as likes,
            (select count(*) from blog_comments bc where bc.blog_id = b.blog_id and bc.status_up_del = 'inserted') as comments
            from blogs b,users u,languages l,blog_categorys c where b.blog_status = 'deleted' and c.bcid = b.bcid and l.lcode=b.lcode and u.usid=b.usid and b.bcid = $category LIMIT $limit OFFSET $offset";
        } else if ($category == null && $search == null) {
            $sql = "select b.*,u.*,l.lname,c.bcname,(select count(*) from blog_likes bl where bl.blog_id = b.blog_id and bl.status_like_dislike = 'like') as likes,
            (select count(*) from blog_comments bc where bc.blog_id = b.blog_id and bc.status_up_del = 'inserted') as comments
            from blogs b,users u,languages l,blog_categorys c where b.blog_status = 'deleted' and c.bcid = b.bcid and l.lcode=b.lcode and u.usid=b.usid and b.lcode = '$language' LIMIT $limit OFFSET $offset";
        } else if ($category == null && $language == null) {
            $sql = "select b.*,u.*,l.lname,c.bcname,(select count(*) from blog_likes bl where bl.blog_id = b.blog_id and bl.status_like_dislike = 'like') as likes,
            (select count(*) from blog_comments bc where bc.blog_id = b.blog_id and bc.status_up_del = 'inserted') as comments
            from blogs b,users u,languages l,blog_categorys c where b.blog_status = 'deleted' and c.bcid = b.bcid and l.lcode=b.lcode and u.usid=b.usid and (b.blog_title LIKE '%$search%' or b.usid in (select usid from users where username LIKE '%$search%')) LIMIT $limit OFFSET $offset";
        }
    } else {
        $sql = "select b.*,u.*,l.lname,c.bcname,(select count(*) from blog_likes bl where bl.blog_id = b.blog_id and bl.status_like_dislike = 'like') as likes,
        (select count(*) from blog_comments bc where bc.blog_id = b.blog_id and bc.status_up_del = 'inserted') as comments
        from blogs b,users u,languages l,blog_categorys c where b.blog_status = 'deleted' and c.bcid = b.bcid and l.lcode=b.lcode and u.usid=b.usid LIMIT $limit OFFSET $offset";
    }

    $result = mysqli_query($conn, $sql) or die("query failed");
    $sql = "select * from blog_categorys";
    $result1 = mysqli_query($conn, $sql);
    $result1 = mysqli_fetch_all($result1, MYSQLI_ASSOC);
    $sql = "select * from languages";
    $result2 = mysqli_query($conn, $sql);
    $result2 = mysqli_fetch_all($result2, MYSQLI_ASSOC);

    if ($result) {
        $result = mysqli_fetch_all($result, MYSQLI_ASSOC);
        echo json_encode(array('message' => 'Displaying Active Blogs Details', 'status' => true, 'blogs' => $result, 'categorys' => $result1, 'languages' => $result2));
    } else {
        echo json_encode(array('message' => 'Error In Displaying Active Blogs Details Or Else No Record Founded', 'status' => false));
    }
}
function display_reported($data, $conn)
{
    $index = $data['index'];

    $limit = 10;

    $offset = $index * $limit;
    $category = $data['category'];
    $language = $data['language'];
    $search = $data['searchvalue'];
    if ($category != null || $language != null || $search != null) {
        if ($category != null && $language != null && $search != null) {
            $sql = "select DISTINCT b.*,u.*,l.lname,c.bcname,(select count(*) from blog_likes bl where bl.blog_id = b.blog_id and bl.status_like_dislike = 'like') as likes,
            (select count(*) from blog_comments bc where bc.blog_id = b.blog_id and bc.status_up_del = 'inserted') as comments,
            (select count(*) from reports rt where rt.report_type_id = b.blog_id and rt.report_type = 'blog') as totalreports
            from blogs b,users u,languages l,blog_categorys c, reports r where b.blog_status = 'posted'and b.blog_id = r.report_type_id and r.report_type = 'blog' and c.bcid = b.bcid and l.lcode=b.lcode and u.usid=b.usid  and b.bcid = $category and b.lcode = '$language' and (b.blog_title LIKE '%$search%' or b.usid in (select usid from users where username LIKE '%$search%')) LIMIT $limit OFFSET $offset";
        } else if ($category != null && $language != null) {
            $sql = "select DISTINCT b.*,u.*,l.lname,c.bcname,(select count(*) from blog_likes bl where bl.blog_id = b.blog_id and bl.status_like_dislike = 'like') as likes,
        (select count(*) from blog_comments bc where bc.blog_id = b.blog_id and bc.status_up_del = 'inserted') as comments,
        (select count(*) from reports rt where rt.report_type_id = b.blog_id and rt.report_type = 'blog') as totalreports
        from blogs b,users u,languages l,blog_categorys c, reports r where b.blog_status = 'posted'and b.blog_id = r.report_type_id and r.report_type = 'blog' and c.bcid = b.bcid and l.lcode=b.lcode and u.usid=b.usid  and b.bcid = $category and b.lcode = '$language' LIMIT $limit OFFSET $offset";
        } else if ($category != null && $search != null) {
            $sql = "select DISTINCT b.*,u.*,l.lname,c.bcname,(select count(*) from blog_likes bl where bl.blog_id = b.blog_id and bl.status_like_dislike = 'like') as likes,
        (select count(*) from blog_comments bc where bc.blog_id = b.blog_id and bc.status_up_del = 'inserted') as comments,
        (select count(*) from reports rt where rt.report_type_id = b.blog_id and rt.report_type = 'blog') as totalreports
        from blogs b,users u,languages l,blog_categorys c, reports r where b.blog_status = 'posted'and b.blog_id = r.report_type_id and r.report_type = 'blog' and c.bcid = b.bcid and l.lcode=b.lcode and u.usid=b.usid  and b.bcid = $category and (b.blog_title LIKE '%$search%' or b.usid in (select usid from users where username LIKE '%$search%')) LIMIT $limit OFFSET $offset";
        } else if ($language != null && $search != null) {
            $sql = "select DISTINCT b.*,u.*,l.lname,c.bcname,(select count(*) from blog_likes bl where bl.blog_id = b.blog_id and bl.status_like_dislike = 'like') as likes,
        (select count(*) from blog_comments bc where bc.blog_id = b.blog_id and bc.status_up_del = 'inserted') as comments,
        (select count(*) from reports rt where rt.report_type_id = b.blog_id and rt.report_type = 'blog') as totalreports
        from blogs b,users u,languages l,blog_categorys c, reports r where b.blog_status = 'posted'and b.blog_id = r.report_type_id and r.report_type = 'blog' and c.bcid = b.bcid and l.lcode=b.lcode and u.usid=b.usid  and b.lcode = '$language' and (b.blog_title LIKE '%$search%' or b.usid in (select usid from users where username LIKE '%$search%')) LIMIT $limit OFFSET $offset";
        } else if ($language == null && $search == null) {
            $sql = "select DISTINCT b.*,u.*,l.lname,c.bcname,(select count(*) from blog_likes bl where bl.blog_id = b.blog_id and bl.status_like_dislike = 'like') as likes,
        (select count(*) from blog_comments bc where bc.blog_id = b.blog_id and bc.status_up_del = 'inserted') as comments,
        (select count(*) from reports rt where rt.report_type_id = b.blog_id and rt.report_type = 'blog') as totalreports
        from blogs b,users u,languages l,blog_categorys c, reports r where b.blog_status = 'posted'and b.blog_id = r.report_type_id and r.report_type = 'blog' and c.bcid = b.bcid and l.lcode=b.lcode and u.usid=b.usid  and b.bcid = $category LIMIT $limit OFFSET $offset";
        } else if ($category == null && $search == null) {
            $sql = "select DISTINCT b.*,u.*,l.lname,c.bcname,(select count(*) from blog_likes bl where bl.blog_id = b.blog_id and bl.status_like_dislike = 'like') as likes,
        (select count(*) from blog_comments bc where bc.blog_id = b.blog_id and bc.status_up_del = 'inserted') as comments,
        (select count(*) from reports rt where rt.report_type_id = b.blog_id and rt.report_type = 'blog') as totalreports
        from blogs b,users u,languages l,blog_categorys c, reports r where b.blog_status = 'posted'and b.blog_id = r.report_type_id and r.report_type = 'blog' and c.bcid = b.bcid and l.lcode=b.lcode and u.usid=b.usid  and b.lcode = '$language' LIMIT $limit OFFSET $offset";
        } else if ($category == null && $language == null) {
            $sql = "select DISTINCT b.*,u.*,l.lname,c.bcname,(select count(*) from blog_likes bl where bl.blog_id = b.blog_id and bl.status_like_dislike = 'like') as likes,
        (select count(*) from blog_comments bc where bc.blog_id = b.blog_id and bc.status_up_del = 'inserted') as comments,
        (select count(*) from reports rt where rt.report_type_id = b.blog_id and rt.report_type = 'blog') as totalreports
        from blogs b,users u,languages l,blog_categorys c, reports r where b.blog_status = 'posted'and b.blog_id = r.report_type_id and r.report_type = 'blog' and c.bcid = b.bcid and l.lcode=b.lcode and u.usid=b.usid  and (b.blog_title LIKE '%$search%' or b.usid in (select usid from users where username LIKE '%$search%')) LIMIT $limit OFFSET $offset";
        }
    } else {
        // $sql = "select b.*,r.reason,u.*,l.lname,c.bcname,(select count(*) from blog_likes bl where bl.blog_id = b.blog_id and bl.status_like_dislike = 'like') as likes,
        // (select count(*) from blog_comments bc where bc.blog_id = b.blog_id and bc.status_up_del = 'inserted') as comments
        // from blogs b,users u,languages l,blog_categorys c, reports r where b.blog_status = 'posted'and b.blog_id = r.report_type_id and c.bcid = b.bcid and l.lcode=b.lcode and u.usid=b.usid LIMIT $limit OFFSET $offset";
        $sql = "select DISTINCT b.*,u.*,l.lname,c.bcname,(select count(*) from blog_likes bl where bl.blog_id = b.blog_id and bl.status_like_dislike = 'like') as likes,
        (select count(*) from blog_comments bc where bc.blog_id = b.blog_id and bc.status_up_del = 'inserted') as comments,
        (select count(*) from reports rt where rt.report_type_id = b.blog_id and rt.report_type = 'blog') as totalreports
        from blogs b,users u,languages l,blog_categorys c, reports r where b.blog_status = 'posted'and b.blog_id = r.report_type_id and r.report_type = 'blog' and c.bcid = b.bcid and l.lcode=b.lcode and u.usid=b.usid LIMIT $limit OFFSET $offset";
    }

    $result = mysqli_query($conn, $sql) or die("query failed");
    $sql = "select * from blog_categorys";
    $result1 = mysqli_query($conn, $sql);
    $result1 = mysqli_fetch_all($result1, MYSQLI_ASSOC);
    $sql = "select * from languages";
    $result2 = mysqli_query($conn, $sql);
    $result2 = mysqli_fetch_all($result2, MYSQLI_ASSOC);

    if ($result) {
        $result = mysqli_fetch_all($result, MYSQLI_ASSOC);
        echo json_encode(array('message' => 'Displaying Active Blogs Details', 'status' => true, 'blogs' => $result, 'categorys' => $result1, 'languages' => $result2));
    } else {
        echo json_encode(array('message' => 'Error In Displaying Active Blogs Details Or Else No Record Founded', 'status' => false));
    }
}
function delete_blog($data, $conn)
{
    $blog_id = $data['blog_id'];

    $sql = "update blogs set blog_status='deleted' where blog_id = '$blog_id'" or die("sql failed");

    $result = mysqli_query($conn, $sql) or die("query failed");

    if ($result) {
        echo json_encode(array('message' => 'Details Deleted', 'status' => true));
    } else {
        echo json_encode(array('message' => 'Error In Deletion', 'status' => false));
    }
}

function single_fetch_blog($data, $conn)
{
    $blog_id = $data['blog_id'];
    //$sql = "select * from blogs where blog_id = '$blog_id'" or die("query failed");

    $sql = "select blog_title,blog_content from blogs where blog_id = $blog_id" or die("sql failed");
    // $sql = "select b.*,l.*,bc.* from blogs b, languages l, blog_categorys bc  where b.bcid = bc.bcid and l.lcode = b.lcode and blog_id = '$blog_id'" or die("sql failed");

    // $sql2 = "select b.*,l.*from blogs b, languages l where l.lcode = b.lcode and blog_id = '$blog_id'" or die("sql failed");

    // $sql3 = "select b.*,bc.* from blogs b, blog_categorys bc  where b.bcid = bc.bcid and blog_id = '$blog_id'" or die("sql failed");

    $result = mysqli_query($conn, $sql) or die("query failed");

    $result = mysqli_fetch_all($result, MYSQLI_ASSOC);

    // $result2 = mysqli_query($conn, $sql2) or die("query failed");

    // $r2 = mysqli_fetch_all($result2, MYSQLI_ASSOC);

    // $result3 = mysqli_query($conn, $sql3) or die("query failed");

    // $r3 = mysqli_fetch_all($result3, MYSQLI_ASSOC);

    if ($result) {
        echo json_encode(array('message' => 'Displaying Single Blog Details', 'status' => true, 'blog' => $result));
    } else {
        echo json_encode(array('message' => 'Error In Displaying Single Blog Details Or Else No Record Founded', 'status' => false));
    }
    // if ($result1 > 0 && $result2 > 0 && $result3 > 0) {
    //     echo json_encode(array('message' => 'Displaying Single Blog Details', 'status' => true, 'singleblogdata' => $r1, 'singlecategorydata' => $r2, 'singlelanguagedata' => $r3, 'k1' => 'singleblogdisplay'));
    // } else {
    //     echo json_encode(array('message' => 'Error In Displaying Single Blog Details Or Else No Record Founded', 'status' => false));
    // }
}


function update_blog($data, $conn)
{
    $blog_id = $data['blog_id'];

    $bcid = $data['bcid'];

    $blog_title = $data['blog_title'];

    $blog_cover_photo = $data['blog_cover_photo'];

    $blog_content = $data['blog_content'];

    $blog_status = $data['blog_status'];
    //blog_post_time
    $lcode = $data['lcode'];

    $sql = "update blogs set bcid = '$bcid', blog_title = '$blog_title',blog_cover_photo = '$blog_cover_photo', blog_content = '$blog_content',blog_status = '$blog_status', lcode = '$lcode' where blog_id = '$blog_id'";

    if (mysqli_query($conn, $sql) > 0) {
        echo json_encode(array('message' => 'Blog Details Updated Successfully.', 'status' => 1));
    } else {
        echo json_encode(array('message' => 'Error in Updating a Blog.', 'status' => 0));
    }
}


function search_blog($data, $conn)
{
    $search = $data['search'];

    $sql = "select * from blogs where bcid like '%$search%' or blog_title like '%$search%' or blog_cover_photo like '%$search%' or blog_content like '%$search%' or blog_status like '%$search%' or lcode like '%$search%' or like blog_id = '%$search%'";

    $result = mysqli_query($conn, $sql) or die("query failed");

    $result1 = mysqli_fetch_all($result, MYSQLI_ASSOC);

    if ($result) {
        echo json_encode(array('message' => 'Displaying Searched Blog Details', 'status' => true, 'searchdata' => $result1, 'k1' => 'search'));
    } else {
        echo json_encode(array('message' => 'Error In Displaying Searched Blog Details Or Else No Record Founded', 'status' => false));
    }
}
function report_show($data, $conn)
{
    $blog_id = $data['blog_id'];
    $sql = "SELECT r.reason, count(*) as totalreport from reports r where r.report_type_id = $blog_id GROUP by r.reason";

    $result = mysqli_query($conn, $sql) or die("query failed");
    if ($result) {
        $result = mysqli_fetch_all($result, MYSQLI_ASSOC);
        echo json_encode(array('message' => 'Report Blog Deleted', 'status' => true, 'reports' => $result));
    } else {
        echo json_encode(array('message' => 'Error In Deleting the Reported Blog', 'status' => false));
    }
}

function delete_blog_report($data, $conn)
{

    $blog_id = $data['blog_id'];


    $sql = "UPDATE blogs b set b.blog_status = 'deleted' where b.blog_id = '$blog_id'" or die("sql failed");

    $result = mysqli_query($conn, $sql);

    if ($result) {
        //$sql = "delete from reports where report_id = '$report_id'" or die("sql failed");
        $sql1 = "UPDATE reports r set r.report_type = 'blogdeleted' where r.report_type_id = '$blog_id'" or die("sql failed");

        $result1 = mysqli_query($conn, $sql1);

        if ($result1) {
            $sql = "select email,blog_title from users u,blogs b where u.usid = b.usid and b.blog_id = $blog_id";
            $result = mysqli_query($conn, $sql);
            $row = mysqli_fetch_assoc($result);
            $email = $row['email'];
            $blog_title = $row['blog_title'];
            $msg = '<div class="container" style="max-width: 500px;margin: 0 auto;padding: 20px;background-color: #ffffff;border: 1px solid #cccccc;border-radius: 4px;box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">
                        <h1 style = "color: #ff0000;text-align: center;">Strike !!!</h1>
                        <p class="strike-info" style="font-weight: bold;margin-bottom: 10px;">Your Blog ' . $blog_title . ' with blog_id : ' . $blog_id . ' has received a strike!</p>
                        
                        <p class="strike-reason" style="color: #ff0000;margin-bottom: 10px;">Reason: Mass Reporting By Multi-Users From
                            The Portal Due To Violation of Community Guidelines</p>
                        
                        <p class="strike-date" style="font-style: italic;">Strike Date: ' . date("d-m-Y") . '</p>
                        
                        <p style="color: #333333;line-height: 1.5;margin-bottom: 15px;">Please review the strike and take necessary actions to resolve
                            the issue.</p>
                        
                        <p style="color: #333333;line-height: 1.5;margin-bottom: 15px;">If you have any questions, please contact TrendStream Help And
                            Support.</p>
                        
                        <p style="color: #333333;line-height: 1.5;margin-bottom: 15px;">The link is provided below</p>
                        
                        
                        <a href="http://localhost/mycode/template/project/pages/help/help.html">help and support</a>
                    </div>';
            mailsend($email, $msg, 'Strike by TrendStream');
            echo json_encode(array('message' => 'Report Blog Deleted', 'status' => true));
        } else {
            echo json_encode(array('message' => 'Error In Deleting the Reported Blog', 'status' => false));
        }
    } else {
        echo json_encode(array('message' => 'Error In Deletion Of Reported Blog', 'status' => false));
    }
}
function recover_blog($data, $conn)
{
    $blog_id = $data['blog_id'];


    $sql = "UPDATE blogs b set b.blog_status = 'drafted' where b.blog_id = '$blog_id'" or die("sql failed");

    $result = mysqli_query($conn, $sql);

    if ($result) {
        //$sql = "delete from reports where report_id = '$report_id'" or die("sql failed");
        $sql1 = "UPDATE reports r set r.report_type = 'blog_updated' where r.report_type_id = '$blog_id'" or die("sql failed");

        $result1 = mysqli_query($conn, $sql1);

        if ($result1) {
            $sql = "select email,blog_title from users u,blogs b where u.usid = b.usid and b.blog_id = $blog_id";
            $result = mysqli_query($conn, $sql);
            $row = mysqli_fetch_assoc($result);
            $email = $row['email'];
            $blog_title = $row['blog_title'];
            $msg = '<div class="container" style="max-width: 500px;margin: 0 auto;padding: 20px;background-color: #ffffff;border: 1px solid #cccccc;border-radius: 4px;box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">
        
                        <h1 style="color: #00aa00;text-align: center;">Recovery!!!</h1>
                        
                        <p class="strike-info" style="font-weight: bold;margin-bottom: 10px;">Congratulations! Your TrendStream Blog has been recovered from blog named '.$blog_title.'.</p>
                        
                        <p class="strike-reason" style="color: #00aa00;margin-bottom: 10px;">Reason: Mass Reporting By Multi-Users From The Portal Due To Violation of Community Guidelines or may be by mistake deleted by you.</p>
                        
                        <p class="strike-date" style="font-style: italic;">Recovery Date: ' . date("d-m-Y") . '</p>
                        
                        <p style="color: #473a3a;line-height: 1.5;margin-bottom: 15px;">Your Blog is now back online and accessible to your viewers.</p>
                        
                        <p style="color: #473a3a;line-height: 1.5;margin-bottom: 15px;">We appreciate your cooperation and adherence to TrendStream`s policies.</p>
                        
                        <p style="color: #473a3a;line-height: 1.5;margin-bottom: 15px;">If you have any further questions, please don`t hesitate to contact us.</p>
                        
                        <p style="color: #473a3a;line-height: 1.5;margin-bottom: 15px;">The link is provided below</p>
                        
                        <a href="http://localhost/mycode/template/project/pages/blogs/myblogs.html">Check in your drafted blog</a>
                    </div>';
            mailsend($email, $msg, 'Strike by TrendStream');
            echo json_encode(array('message' => 'Report Blog Deleted', 'status' => true));
        } else {
            echo json_encode(array('message' => 'Error In Deleting the Reported Blog', 'status' => false));
        }
    } else {
        echo json_encode(array('message' => 'Error In Deletion Of Reported Blog', 'status' => false));
    }
}
function mailsend($email, $msg, $subject)
{
    $mail = new PHPMailer(true);
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    // Email password
    $mail->Username = 'kathanshah.mscit20@vnsgu.ac.in';
    //$mail->Password = 'fyydlhwavfhdoady';
    $mail->Password = 'bszgfblwxrhahkiz';
    $mail->SMTPSecure = 'ssl';
    $mail->Port = 465;
    $mail->setFrom('kathanshah.mscit20@vnsgu.ac.in');
    $mail->addAddress($email);
    $mail->isHTML(true);
    $mail->Subject = $subject;
    $mail->Body = $msg;
    $mail->send();
}
if ($fkey == "display_all_blog") {
    display_all_blog($data);
} elseif ($fkey == "display_draft") {
    display_draft($data, $conn);
} elseif ($fkey == "display_active") {
    display_active($data, $conn);
} elseif ($fkey == "display_deleted") {
    display_deleted($data, $conn);
} elseif ($fkey == "display_reported") {
    display_reported($data, $conn);
} elseif ($fkey == "delete_blog") {
    delete_blog($data, $conn);
} elseif ($fkey == "single_fetch_blog") {
    single_fetch_blog($data, $conn);
} elseif ($fkey == "update_blog") {
    update_blog($data, $conn);
} elseif ($fkey == "search_blog") {
    search_blog($data, $conn);
} elseif ($fkey == "delete_blog_report") {
    delete_blog_report($data, $conn);
} elseif ($fkey == "recover_blog") {
    recover_blog($data, $conn);
} elseif ($fkey == "report_show") {
    report_show($data, $conn);
} else {
    echo json_encode(array('message' => 'Error in sending Usermaster Api key', 'status' => false));
}

?>