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


//save blog or readlater blog
function userdata($conn)
{
    $usid = 0;
    if (isset($_SESSION['buid'])) {
        $uid = $_SESSION['buid'];
        $sql = "select *from users where usid = '$uid'";
        $result = mysqli_query($conn, $sql);
        $result = mysqli_fetch_all($result, MYSQLI_ASSOC);
        return $result;
    } else {
        return [['usename' => 'guest', 'usid' => 0, 'usertype' => 'guest']];
    }
}
function trending($conn)
{
    $sql = "
    select b.*,u.*,(select count(*) from blog_likes bl,users ul where bl.blog_id = b.blog_id and bl.status_like_dislike = 'like' and bl.usid = ul.usid and (ul.user_type = 'user' or ul.user_type = 'blogger')) as likes,
    (select count(*) from blog_comments bc, users uc where bc.blog_id = b.blog_id and bc.status_up_del = 'inserted' and bc.usid = uc.usid and (uc.user_type = 'user' or uc.user_type = 'blogger')) as comments,
    (select b.blog_view + COUNT(bv.blog_views_id) from blog_viewstb bv where b.blog_id = bv.blog_id) as totalviews
    from blogs b,users u where u.usid=b.usid and u.user_type = 'blogger' and b.blog_status = 'posted' and b.blog_post_time >= DATE_SUB(NOW(), INTERVAL 7 DAY) order by b.blog_view desc" or die("sql failed");
    $result = mysqli_query($conn, $sql) or die("query failed");
    $result1 = mysqli_fetch_all($result, MYSQLI_ASSOC);

    $sql = "select * from blog_categorys";
    $result = mysqli_query($conn, $sql);
    $result2 = mysqli_fetch_all($result, MYSQLI_ASSOC);

    $sql = "select * from languages";
    $result = mysqli_query($conn, $sql);
    $result3 = mysqli_fetch_all($result, MYSQLI_ASSOC);

    $result4 = userdata($conn);

    if ($result) {
        echo json_encode(array('message' => 'Reading a Blog', 'status' => true, 'blogs' => $result1, 'categorys' => $result2, 'languages' => $result3, 'userdata' => $result4));
    } else {
        echo json_encode(array('message' => 'No Treding Blogs Found.', 'status' => false));
    }
}

function category($conn)
{
    $sql = "SELECT * FROM blog_categorys" or die("sql failed");

    $result = mysqli_query($conn, $sql) or die("query failed");

    $result1 = mysqli_fetch_all($result, MYSQLI_ASSOC);

    if ($result) {
        echo json_encode(array('message' => 'Reading a Blog', 'status' => true, 'cd' => $result1, 'k1' => 'cd data'));

    } else {
        echo json_encode(array('message' => 'No Treding Blogs Found In This Category.', 'status' => false));
    }


}

function filter_category($data, $conn)
{

    $bcid = $data['id'];
    $sql = "
    select b.*,u.*,(select count(*) from blog_likes bl,users ul where bl.blog_id = b.blog_id and bl.status_like_dislike = 'like' and bl.usid = ul.usid and (ul.user_type = 'user' or ul.user_type = 'blogger')) as likes,
    (select count(*) from blog_comments bc, users uc where bc.blog_id = b.blog_id and bc.status_up_del = 'inserted' and bc.usid = uc.usid and (uc.user_type = 'user' or uc.user_type = 'blogger')) as comments,
    (select b.blog_view + COUNT(bv.blog_views_id) from blog_viewstb bv where b.blog_id = bv.blog_id) as totalviews
    from blogs b,users u where u.usid=b.usid and u.user_type = 'blogger' and b.blog_status = 'posted' and b.bcid = '$bcid' and b.blog_post_time >= DATE_SUB(NOW(), INTERVAL 7 DAY) order by b.blog_view desc";
    $result = mysqli_query($conn, $sql) or die("query failed");

    $result1 = mysqli_fetch_all($result, MYSQLI_ASSOC);

    $result2 = userdata($conn);


    if ($result) {
        echo json_encode(array('message' => 'Displaying Filter Category', 'status' => true, 'blogs' => $result1, 'userdata' => $result2));

    } else {
        echo json_encode(array('message' => 'Error In Displaying Filter Category Details Or Else No Record Found', 'status' => false));
    }

}

function filter_language($data, $conn)
{
    $lcode = $data['id'];

    $sql = "
    select b.*,u.*,(select count(*) from blog_likes bl,users ul where bl.blog_id = b.blog_id and bl.status_like_dislike = 'like' and bl.usid = ul.usid and (ul.user_type = 'user' or ul.user_type = 'blogger')) as likes,
    (select count(*) from blog_comments bc, users uc where bc.blog_id = b.blog_id and bc.status_up_del = 'inserted' and bc.usid = uc.usid and (uc.user_type = 'user' or uc.user_type = 'blogger')) as comments,
    (select b.blog_view + COUNT(bv.blog_views_id) from blog_viewstb bv where b.blog_id = bv.blog_id) as totalviews
    from blogs b,users u where u.usid=b.usid and u.user_type = 'blogger' and b.blog_status = 'posted' and lcode = '$lcode' and b.blog_post_time >= DATE_SUB(NOW(), INTERVAL 7 DAY) order by b.blog_view desc";
    $result = mysqli_query($conn, $sql) or die("query failed");

    $result1 = mysqli_fetch_all($result, MYSQLI_ASSOC);

    $result2 = userdata($conn);

    if ($result) {
        echo json_encode(array('message' => 'Displaying Filter Language', 'status' => true, 'blogs' => $result1, 'userdata' => $result2));
    } else {
        echo json_encode(array('message' => 'Error In Displaying Language Category Details Or Else No Record Found', 'status' => false));
    }
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


if ($fkey == "filter_category") {
    filter_category($data, $conn);
} elseif ($fkey == "filter_language") {
    filter_language($data, $conn);
} elseif ($fkey == "trending") {
    trending($conn);
} else {
    echo json_encode(array('message' => 'Error in sending Trending Api key', 'status' => false));
}


?>