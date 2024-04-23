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

function getlistid($usid, $conn, $type)
{
    $sql = "SELECT * FROM lists WHERE usid = '$usid' ORDER BY list_id LIMIT 2" or die("sql failed");

    $result = mysqli_query($conn, $sql) or die("query failed");

    if (mysqli_num_rows($result) > 0) {
        while ($rows = mysqli_fetch_assoc($result)) {
            if ($type == $rows['list_title']) {
                return $rows['list_id'];
            }
        }
    }
    return null;
}

function add_content_to_readlist($data, $conn)
{
    $list_id = $data['list_id'];
    $blog_id = $data['blog_id'];
    $sql = "SELECT l.*,(SELECT lcid FROM lists_content lc WHERE lc.list_id = l.list_id and lc.blog_id = $blog_id) as lcid,(SELECT COUNT(*) from lists_content lc WHERE l.list_id = lc.list_id) as totalblog FROM lists l where l.list_id = $list_id";

    // $sql = "SELECT l.*,(SELECT lcid FROM lists_content lc WHERE lc.list_id = l.list_id and lc.blog_id = $blog_id) as lcid,(SELECT COUNT(*) from lists_content lc WHERE l.list_id = lc.list_id) as totalblog FROM lists l where l.list_id = $list_id";
// $sql = "SELECT l.*,(SELECT lcid FROM lists_content lc WHERE lc.list_id = l.list_id and lc.blog_id = $blog_id) as lcid FROM lists l where l.usid = $usid";
    $result = mysqli_query($conn, $sql) or die("query failed");
    // $result = mysqli_fetch_all($result,MYSQLI_ASSOC);
    $result = mysqli_fetch_assoc($result);
    if ($result['lcid'] != null) {
        echo json_encode(array('message' => 'Blog alredy in readlist', 'status' => true, 'listcontent' => $result));
    } else {
        $sql = "insert into lists_content(list_id,blog_id) values('$list_id','$blog_id')" or die("sql failed");

        $result = mysqli_query($conn, $sql) or die("query failed");

        if ($result) {
            $sql = "SELECT l.*,(SELECT lcid FROM lists_content lc WHERE lc.list_id = l.list_id and lc.blog_id = $blog_id) as lcid,(SELECT COUNT(*) from lists_content lc WHERE l.list_id = lc.list_id) as totalblog FROM lists l where l.list_id = $list_id";

            // $sql = "SELECT l.*,(SELECT lcid FROM lists_content lc WHERE lc.list_id = l.list_id and lc.blog_id = $blog_id) as lcid,(SELECT COUNT(*) from lists_content lc WHERE l.list_id = lc.list_id) as totalblog FROM lists l where l.list_id = $list_id";
            // $sql = "SELECT l.*,(SELECT lcid FROM lists_content lc WHERE lc.list_id = l.list_id and lc.blog_id = $blog_id) as lcid FROM lists l where l.usid = $usid";
            $result = mysqli_query($conn, $sql) or die("query failed");
            $result = mysqli_fetch_all($result, MYSQLI_ASSOC);
            echo json_encode(array('message' => 'Blog Added To ReadList Successfully.', 'status' => true, 'listcontent' => $result));
        } else {
            echo json_encode(array('message' => 'Error In Adding A Blog To ReadList.', 'status' => false));
        }
    }

}

function addmultipleblog_show_readlist($conn)
{
    $usid = 0;
    if (isset($_SESSION['buid'])) {
        $usid = $_SESSION['buid'];
    }
    $sql = "SELECT l.*,(SELECT COUNT(*) from lists_content lc WHERE l.list_id = lc.list_id) as totalblog FROM lists l where l.usid = $usid";
    // $sql = "SELECT l.*,(SELECT lcid FROM lists_content lc WHERE lc.list_id = l.list_id and lc.blog_id = $blog_id) as lcid FROM lists l where l.usid = $usid";
    $result = mysqli_query($conn, $sql) or die("query failed");
    if ($result) {
        $result = mysqli_fetch_all($result, MYSQLI_ASSOC);
        echo json_encode(array('message' => 'Saved to read later', 'status' => true, 'listcontent' => $result));
    } else {
        echo json_encode(array('message' => 'Some error', 'status' => false));
    }
}
function add_multiplecontent_to_readlist($data, $conn)
{
    $list_id = $data['list_id'];

    $usid = 0;
    if (isset($_SESSION['buid'])) {
        $usid = $_SESSION['buid'];
    }
    $blog_ids = $data['blog_id'];
    $flag = false;
    foreach ($blog_ids as $blog_id) {
        $sql = "select lcid from lists_content where blog_id = '$blog_id' and list_id = '$list_id'" or die("sql failed");
        $result = mysqli_query($conn, $sql) or die("query failed");
        if (mysqli_num_rows($result) <= 0) {
            $sql = "insert into lists_content(list_id,blog_id) values('$list_id','$blog_id')" or die("sql for insertion in lists table, failed");
            $result = mysqli_query($conn, $sql) or die("sql failed");
            if ($result < 0) {
                $flag = true;
            }
        }
    }
    if ($flag) {
        echo json_encode(array('message' => 'Error in Saving a Blog', 'status' => false));
    } else {
        $sql = "SELECT l.*,(SELECT COUNT(*) from lists_content lc WHERE l.list_id = lc.list_id) as totalblog FROM lists l where l.list_id = '$list_id'";
        $result = mysqli_query($conn, $sql) or die("query failed");
        $result = mysqli_fetch_assoc($result);
        echo json_encode(array('message' => 'All Blogs Are Added To ' . $result['list_title'], 'status' => true, 'listcontent' => $result));
    }
}
function addblog_show_readlist($data, $conn)
{
    $usid = 0;
    if (isset($_SESSION['buid'])) {
        $usid = $_SESSION['buid'];
    }
    $blog_id = $data['blog_id'];
    $sql = "SELECT l.*,(SELECT lcid FROM lists_content lc WHERE lc.list_id = l.list_id and lc.blog_id = $blog_id) as lcid,(SELECT COUNT(*) from lists_content lc WHERE l.list_id = lc.list_id) as totalblog FROM lists l where l.usid = $usid";
    // $sql = "SELECT l.*,(SELECT lcid FROM lists_content lc WHERE lc.list_id = l.list_id and lc.blog_id = $blog_id) as lcid FROM lists l where l.usid = $usid";
    $result = mysqli_query($conn, $sql) or die("query failed");
    if ($result) {
        $result = mysqli_fetch_all($result, MYSQLI_ASSOC);
        echo json_encode(array('message' => 'Saved to read later', 'status' => true, 'listcontent' => $result));
    } else {
        echo json_encode(array('message' => 'Some error', 'status' => false));
    }
}
function addmultiblog_show_readlist($data, $conn)
{
    $usid = 0;
    if (isset($_SESSION['buid'])) {
        $usid = $_SESSION['buid'];
    }
    $blog_id = $data['blog_id'];
    $sql = "SELECT l.*,(SELECT COUNT(*) from lists_content lc WHERE l.list_id = lc.list_id) as totalblog FROM lists l where l.usid = $usid";
    // $sql = "SELECT l.*,(SELECT lcid FROM lists_content lc WHERE lc.list_id = l.list_id and lc.blog_id = $blog_id) as lcid FROM lists l where l.usid = $usid";
    $result = mysqli_query($conn, $sql) or die("query failed");
    if ($result) {
        $result = mysqli_fetch_all($result, MYSQLI_ASSOC);
        echo json_encode(array('message' => 'Saved to read later', 'status' => true, 'listcontent' => $result));
    } else {
        echo json_encode(array('message' => 'Some error', 'status' => false));
    }
}
function delete_readlist($data, $conn)
{
    $list_id = $data['list_id'];

    $sql = "delete from lists where list_id = '$list_id'" or die("sql failed");

    $result = mysqli_query($conn, $sql) or die("query failed");

    if ($result) {
        echo json_encode(array('message' => 'ReadList Deleted Successfully.', 'status' => true));
    } else {
        echo json_encode(array('message' => 'Error In Deleting ReadList.', 'status' => false));
    }
}
function update_readlist_status($data, $conn)
{
    $list_id = $data['list_id'];
    $sql = "SELECT *FROM lists where list_id = $list_id";
    $result = mysqli_query($conn, $sql) or die("query failed");
    $row = mysqli_fetch_assoc($result);
    if ($row['list_status'] == "private") {
        $sql = "update lists set list_status = 'public' where list_id = '$list_id'" or die("sql failed");
    } else {
        $sql = "update lists set list_status = 'private' where list_id = '$list_id'" or die("sql failed");
    }
    $result = mysqli_query($conn, $sql) or die("query failed");
    if ($result) {
        echo json_encode(array('message' => 'ReadList Status Updated Successfully.', 'status' => true, 'pstatus' => $row['list_status']));
    } else {
        echo json_encode(array('message' => 'Error In Updating ReadList Status.', 'status' => false));
    }
}
function display_one_readlist($data, $conn)
{
    $usid = 0;
    if (isset($_SESSION['buid'])) {
        $usid = $_SESSION['buid'];
    }
    $list_id = $data['list_id'];
    $sql = "SELECT usid FROM lists where list_id = $list_id";
    $result = mysqli_query($conn, $sql) or die("query failed");
    $row = mysqli_fetch_assoc($result);
    if (mysqli_num_rows($result) == 1) {
        $rusid = $row["usid"];
        if ($usid == $rusid) {
            $sql = "SELECT l.*,u.username,(SELECT COUNT(*) from lists_content lc WHERE l.list_id = lc.list_id) as totalblog FROM lists l,users u where u.usid=l.usid and l.list_id = $list_id";
        } else {
            $sql = "SELECT l.*,u.username,(SELECT COUNT(*) from lists_content lc WHERE l.list_id = lc.list_id and lc.contant_status= 'public') as totalblog FROM lists l,users u where u.usid=l.usid and l.list_id = $list_id";
        }
    } else {
        $sql = "SELECT l.*,u.username,(SELECT COUNT(*) from lists_content lc WHERE l.list_id = lc.list_id and lc.contant_status= 'public') as totalblog FROM lists l,users u where u.usid=l.usid and l.list_id = $list_id";
    }
    $result = mysqli_query($conn, $sql) or die("query failed");
    if ($result) {
        $result = mysqli_fetch_all($result, MYSQLI_ASSOC);
        $sql = "select *from users where usid = '$usid'";
        $result1 = mysqli_query($conn, $sql);
        $result1 = mysqli_fetch_all($result1, MYSQLI_ASSOC);
        $sql = "select lc.lcid,lc.contant_status,b.*,u.*,l.list_id, 
        (select count(*) from blog_likes bl,users ul where bl.blog_id = b.blog_id and bl.status_like_dislike = 'like' and bl.usid = ul.usid and (ul.user_type = 'user' or ul.user_type = 'blogger')) as likes,
        (select count(*) from blog_comments bc, users uc where bc.blog_id = b.blog_id and bc.status_up_del = 'inserted' and bc.usid = uc.usid and (uc.user_type = 'user' or uc.user_type = 'blogger')) as comments,
        (select b.blog_view + COUNT(bv.blog_views_id) from blog_viewstb bv where b.blog_id = bv.blog_id) as totalviews
        from 
        blogs b,users u ,lists_content lc,lists l, users us
        where b.blog_status = 'posted' and u.usid=b.usid and l.usid = us.usid and l.list_id = lc.list_id and b.blog_id = lc.blog_id and l.list_id = $list_id
        ORDER by lc.lcid DESC";
        $result2 = mysqli_query($conn, $sql);
        $result2 = mysqli_fetch_all($result2, MYSQLI_ASSOC);
        echo json_encode(array('message' => 'readlist Content data', 'status' => true, 'listdata' => $result, 'listcontent' => $result2, 'userdata' => $result1, 'usid' => $usid));
    } else {
        echo json_encode(array('message' => 'Some error', 'status' => false));
    }
}
function update_content_status_of_readlist($data, $conn)
{
    $lcid = $data['lcid'];

    $sql = "SELECT *FROM lists_content where lcid = $lcid";
    $result = mysqli_query($conn, $sql) or die("query failed");
    $row = mysqli_fetch_assoc($result);
    if ($row['contant_status'] == "private") {
        $sql = "update lists_content set contant_status = 'public' where lcid = '$lcid'" or die("sql failed");
    } else {
        $sql = "update lists_content set contant_status = 'private' where lcid = '$lcid'" or die("sql failed");
    }
    // $sql = "update lists_content set content_status = '$content_status' where lcid = '$lcid'" or die("sql failed");

    $result = mysqli_query($conn, $sql) or die("query failed");

    if ($result) {
        echo json_encode(array('message' => 'Status Updated.', 'status' => true, 'pstatus' => $row['contant_status']));
    } else {
        echo json_encode(array('message' => 'Error In Updating Status.', 'status' => false));
    }
}
function delete_content_from_readlist($data, $conn)
{
    $lcid = $data['lcid'];

    $sql = "delete from lists_content where lcid = '$lcid'" or die("sql failed");

    $result = mysqli_query($conn, $sql) or die("query failed");

    if ($result) {
        echo json_encode(array('message' => 'Blog Deleted From ReadList Successfully.', 'status' => true));
    } else {
        echo json_encode(array('message' => 'Error In deleting A Blog From ReadList.', 'status' => false));
    }
}
function update_readlist_title($data, $conn)
{
    $list_id = $data['list_id'];
    $list_title = $data['list_title'];

    $sql = "update lists set list_title = '$list_title' where list_id = '$list_id'" or die("sql failed");

    $result = mysqli_query($conn, $sql) or die("query failed");

    if ($result) {
        echo json_encode(array('message' => 'ReadList Title Updated Successfully.', 'status' => true, 'k1' => 'update title'));
    } else {
        echo json_encode(array('message' => 'Error In Updating ReadList Title.', 'status' => false));
    }
}

function clear_readlist($data, $conn)
{
    $list_id = $data['list_id'];
    $sql = "delete from lists_content where list_id = $list_id";
    $result = mysqli_query($conn, $sql) or die("query failed");
    if ($result) {
        echo json_encode(array('message' => 'Read list cleared.', 'status' => true));
    } else {
        echo json_encode(array('message' => 'Some problem in server.', 'status' => false));
    }
}

function display_readlist($conn)
{
    $usid = 0;
    if (isset($_SESSION['buid'])) {
        $usid = $_SESSION['buid'];
    }

    

    $sql = "SELECT l.*,(SELECT COUNT(*) from lists_content lc WHERE l.list_id = lc.list_id) as totalblog FROM lists l where l.usid = $usid";
    // $sql = "SELECT l.*,(SELECT lcid FROM lists_content lc WHERE lc.list_id = l.list_id and lc.blog_id = $blog_id) as lcid FROM lists l where l.usid = $usid";
    $result = mysqli_query($conn, $sql) or die("query failed");
    if ($result) {
        $result1 = mysqli_fetch_all($result, MYSQLI_ASSOC);
        $sql = "select *from users where usid = '$usid'";
        $result = mysqli_query($conn, $sql);
        $result2 = mysqli_fetch_all($result, MYSQLI_ASSOC);

        $sql = "select count(bl.blog_like_id) as totalblogs
        from 
        blogs b,users u,blog_likes bl,users ul
        where b.blog_status = 'posted' and u.usid=b.usid and b.blog_id=bl.blog_id and ul.usid = $usid and ul.usid = bl.usid and u.user_type = 'blogger'";
        $result = mysqli_query($conn, $sql) or die("query failed");

        $result3 = mysqli_fetch_all($result, MYSQLI_ASSOC);

        $sql = "select count(bk.bmid) as totalblogs
        from 
        blogs b,users u,bookmarktb bk,users uk
        where b.blog_status = 'posted' and u.usid=b.usid and b.blog_id = bk.blog_id and bk.usid = $usid and uk.usid = bk.usid and u.user_type = 'blogger'";

        $result = mysqli_query($conn, $sql) or die("query failed");

        $result4 = mysqli_fetch_all($result, MYSQLI_ASSOC);

        echo json_encode(array('message' => 'Saved to read later', 'status' => true, 'listcontent' => $result1, 'userdata' => $result2,'likedblogs' => $result3,'bookmarkedblogs'=>$result4));
    } else {
        echo json_encode(array('message' => 'Some error', 'status' => false));
    }
}
function create_readlist($data, $conn)
{
    $usid = 0;
    if (isset($_SESSION['buid'])) {
        $usid = $_SESSION['buid'];
    }
    $list_title = $data['list_title'];
    //$readlist_status = 'private';// check
    $list_status = $data['list_status'];

    $sql = "insert into lists(usid,list_title,list_status) values('$usid','$list_title','$list_status')" or die("sql failed");

    $result = mysqli_query($conn, $sql) or die("query failed");

    if ($result) {
        $list_id = mysqli_insert_id($conn);
        $sql = "SELECT l.*,(SELECT COUNT(*) from lists_content lc WHERE l.list_id = lc.list_id) as totalblog FROM lists l where l.list_id = $list_id";

        // $sql = "SELECT l.*,(SELECT lcid FROM lists_content lc WHERE lc.list_id = l.list_id and lc.blog_id = $blog_id) as lcid,(SELECT COUNT(*) from lists_content lc WHERE l.list_id = lc.list_id) as totalblog FROM lists l where l.list_id = $list_id";
        // $sql = "SELECT l.*,(SELECT lcid FROM lists_content lc WHERE lc.list_id = l.list_id and lc.blog_id = $blog_id) as lcid FROM lists l where l.usid = $usid";
        $result = mysqli_query($conn, $sql) or die("query failed");
        $result = mysqli_fetch_all($result, MYSQLI_ASSOC);

        echo json_encode(array('message' => 'ReadList Created Successfully.', 'status' => true, 'listcontent' => $result));
    } else {
        echo json_encode(array('message' => 'Error In Creating ReadList.', 'status' => false));
    }
}

function delete_content_from_readlist_h($data, $conn)
{
    $lcid = $data['lcid'];
    $list_id = $data['list_id'];
    $blog_id = $data['blog_id'];
    $sql = "delete from lists_content where lcid = '$lcid'" or die("sql failed");

    $result = mysqli_query($conn, $sql) or die("query failed");

    if ($result) {
        $sql = "SELECT l.*,(SELECT lcid FROM lists_content lc WHERE lc.list_id = l.list_id and lc.blog_id = $blog_id) as lcid,(SELECT COUNT(*) from lists_content lc WHERE l.list_id = lc.list_id) as totalblog FROM lists l where l.list_id = $list_id";
        $result = mysqli_query($conn, $sql) or die("query failed");
        $result = mysqli_fetch_all($result, MYSQLI_ASSOC);
        echo json_encode(array('message' => 'Blog Deleted From ReadList Successfully.', 'status' => true, 'listcontent' => $result));
    } else {
        echo json_encode(array('message' => 'Error In deleting A Blog From ReadList.', 'status' => false));
    }
}


//save blog or readlater blog
function blog_save($data, $conn)
{
    $usid = 0;
    if (isset($_SESSION['buid'])) {
        $usid = $_SESSION['buid'];
    }

    $list_id = getlistid($usid, $conn, 'Read Later');

    $blog_id = $data['blog_id'];
    $sqlselect = "select * from lists_content where list_id = '$list_id' and blog_id = '$blog_id'" or die("sql failed");

    $resultselect = mysqli_query($conn, $sqlselect) or die("query failed");

    if (mysqli_num_rows($resultselect) > 0) {
        $sqldel = "delete from lists_content where list_id = '$list_id' and blog_id = '$blog_id'" or die("sql failed");

        $resultdel = mysqli_query($conn, $sqldel) or die("query failed");

    }

    $sql = "insert into lists_content(list_id,blog_id) values('$list_id','$blog_id')" or die("sql for insertion in lists table, failed");

    $result = mysqli_query($conn, $sql) or die("query failed");

    if ($result) {
        $lastid = mysqli_insert_id($conn);
        echo json_encode(array('message' => 'Saved to read later', 'status' => true, 'key1' => 'Saved', 'lcid' => $lastid));
    } else {
        echo json_encode(array('message' => 'Error in Saving a Blog', 'status' => false));
    }

}



function getblogid($lcid, $conn)
{
    $sql = "SELECT blog_id FROM lists_content WHERE lcid = '$lcid'" or die("sql failed");

    $result = mysqli_query($conn, $sql) or die("query failed");

    if (mysqli_num_rows($result) > 0) {
        $rows = mysqli_fetch_assoc($result);
        return $rows['blog_id'];
    }

    return null;

}

function blog_save_delete($data, $conn)
{
    $lcid = $data['lcid'];
    $blog_id = getblogid($lcid, $conn);

    $sql = "delete from lists_content where lcid = '$lcid'" or die("sql for Deletion in lists_content table, failed");

    $result = mysqli_query($conn, $sql) or die("query failed");

    if ($result) {
        echo json_encode(array('message' => 'Blog Removed From Saved', 'status' => true, 'key1' => 'deleted', 'blog_id' => $blog_id));

    } else {
        echo json_encode(array('message' => 'Error in Remvoing a Saved Blog', 'status' => false));
    }

}

function clear_history($conn)
{
    $usid = 0;
    if (isset($_SESSION['buid'])) {
        $usid = $_SESSION['buid'];
    }
    $list_id = getlistid($usid, $conn, 'History');
    $sql = "delete from lists_content where list_id = $list_id";
    $result = mysqli_query($conn, $sql) or die("query failed");
    if ($result) {
        echo json_encode(array('message' => 'Read history cleared.', 'status' => true));
    } else {
        echo json_encode(array('message' => 'Some problem in server.', 'status' => false));
    }
}

function delete_history($data, $conn)
{

    $lcid = $data['lcid'];
    $sql = "delete from lists_content where lcid = $lcid";
    $result = mysqli_query($conn, $sql) or die("query failed");

    $usid = 0;
    if (isset($_SESSION['buid'])) {
        $usid = $_SESSION['buid'];
    }
    if ($result) {

        //select b.,u.username,(select count() from blog_likes bl where bl.blog_id = b.blog_id and bl.status_like_dislike = 'like') as 'likes',(select count(*) from  blog_comments bc where bc.blog_id = b.blog_id and bc.status_up_del = 'inserted') as 'comments'from blogs b,users u,save_and_history_blogs sh where u.usid = sh.usid and b.blog_id = sh.blog_id and sh.usid = '$blog_id' and sh.type_history_save = 'save'; 

        //$sql = "select * from users u, blogs b,save_and_history_blogs sh where u.usid = sh.usid and b.blog_id = sh.blog_id and sh.usid = '$usid' " or die("sql failed");

        $list_id = getlistid($usid, $conn, 'History');
        $sql = "select lc.lcid,b.*,u.*,l.list_id, 
        (select count(*) from blog_likes bl,users ul where bl.blog_id = b.blog_id and bl.status_like_dislike = 'like' and bl.usid = ul.usid and (ul.user_type = 'user' or ul.user_type = 'blogger')) as likes,
        (select count(*) from blog_comments bc, users uc where bc.blog_id = b.blog_id and bc.status_up_del = 'inserted' and bc.usid = uc.usid and (uc.user_type = 'user' or uc.user_type = 'blogger')) as comments,
        (select b.blog_view + COUNT(bv.blog_views_id) from blog_viewstb bv where b.blog_id = bv.blog_id) as totalviews
        from 
        blogs b,users u ,lists_content lc,lists l, users us
        where u.usid=b.usid and l.usid = us.usid and u.user_type = 'blogger' and  l.list_id = lc.list_id and b.blog_id = lc.blog_id and l.list_id = $list_id and us.usid = $usid
        ORDER by lc.lcid DESC";
        $result = mysqli_query($conn, $sql) or die("query failed");
        $result = mysqli_fetch_all($result, MYSQLI_ASSOC);
        echo json_encode(array('message' => 'Removed from history.', 'status' => true, 'blogdata' => $result));
    } else {
        echo json_encode(array('message' => 'Some problem in server.', 'status' => false));
    }
}
function display_history($data, $conn)
{
    $usid = 0;
    if (isset($_SESSION['buid'])) {
        $usid = $_SESSION['buid'];
    }

    //select b.,u.username,(select count() from blog_likes bl where bl.blog_id = b.blog_id and bl.status_like_dislike = 'like') as 'likes',(select count(*) from  blog_comments bc where bc.blog_id = b.blog_id and bc.status_up_del = 'inserted') as 'comments'from blogs b,users u,save_and_history_blogs sh where u.usid = sh.usid and b.blog_id = sh.blog_id and sh.usid = '$blog_id' and sh.type_history_save = 'save'; 

    //$sql = "select * from users u, blogs b,save_and_history_blogs sh where u.usid = sh.usid and b.blog_id = sh.blog_id and sh.usid = '$usid' " or die("sql failed");

    $list_id = getlistid($usid, $conn, 'History');
    $sql = "select lc.lcid,b.*,u.*,l.list_id, 
    (select count(*) from blog_likes bl,users ul where bl.blog_id = b.blog_id and bl.status_like_dislike = 'like' and bl.usid = ul.usid and (ul.user_type = 'user' or ul.user_type = 'blogger')) as likes,
    (select count(*) from blog_comments bc, users uc where bc.blog_id = b.blog_id and bc.status_up_del = 'inserted' and bc.usid = uc.usid and (uc.user_type = 'user' or uc.user_type = 'blogger')) as comments,
    (select b.blog_view + COUNT(bv.blog_views_id) from blog_viewstb bv where b.blog_id = bv.blog_id) as totalviews
    from 
    blogs b,users u ,lists_content lc,lists l, users us
    where b.blog_status = 'posted' and  u.usid=b.usid and u.user_type = 'blogger' and l.usid = us.usid and l.list_id = lc.list_id and b.blog_id = lc.blog_id and l.list_id = $list_id and us.usid = $usid
    ORDER by lc.lcid DESC";
    // $sql ="select b.*,u.*,(select count(*) from blog_likes bl,users ul where bl.blog_id = b.blog_id and bl.status_like_dislike = 'like' and bl.usid = ul.usid and (ul.user_type = 'user' or ul.user_type = 'blogger')) as likes,
    // (select count(*) from blog_comments bc, users uc where bc.blog_id = b.blog_id and bc.status_up_del = 'inserted' and bc.usid = uc.usid and (uc.user_type = 'user' or uc.user_type = 'blogger')) as comments
    // from blogs b,users u where u.usid=b.usid and b.blog_id in (select blog_id from lists_content where list_id in (select list_id from lists where usid = '$usid' and list_id = '$list_id') order by lcid desc)";
    // $sql = "select b.*,u.username,(select count(*) from blog_likes bl,users ul where bl.blog_id = b.blog_id and bl.status_like_dislike = 'like' and bl.usid = ul.usid and (ul.user_type = 'user' or ul.user_type = 'blogger')) as 'likes',(select count(*) from  blog_comments bc where bc.blog_id = b.blog_id and bc.status_up_del = 'inserted') as 'comments'from blogs b,users u where u.usid = b.usid and b.blog_id in (select blog_id from lists_content where list_id in (select list_id from lists where usid = '$usid' and list_id = '$list_id'))";
    $result = mysqli_query($conn, $sql) or die("query failed");
    if ($result) {
        $result1 = mysqli_fetch_all($result, MYSQLI_ASSOC);
        $uid = $_SESSION['buid'];
        $sql = "select *from users where usid = '$uid'";
        $result2 = mysqli_query($conn, $sql);
        $result2 = mysqli_fetch_all($result2, MYSQLI_ASSOC);
        echo json_encode(array('message' => 'Displaying Blogs', 'status' => '1', 'userdata' => $result2, 'allblogsdata' => $result1));
        // echo json_encode(array('message' => 'ReadList Displayed Successfully.' , 'status' =>true,'historylists'=>$result1));
    } else {
        echo json_encode(array('message' => 'Error In Displaying ReadList.', 'status' => false));
    }
}
function delete_content_from_readlater($data, $conn)
{
    $lcid = $data['lcid'];
    $sql = "delete from lists_content where lcid = $lcid";
    $result = mysqli_query($conn, $sql) or die("query failed");
    $usid = 0;
    if (isset($_SESSION['buid'])) {
        $usid = $_SESSION['buid'];
    }
    if ($result) {

        //select b.,u.username,(select count() from blog_likes bl where bl.blog_id = b.blog_id and bl.status_like_dislike = 'like') as 'likes',(select count(*) from  blog_comments bc where bc.blog_id = b.blog_id and bc.status_up_del = 'inserted') as 'comments'from blogs b,users u,save_and_history_blogs sh where u.usid = sh.usid and b.blog_id = sh.blog_id and sh.usid = '$blog_id' and sh.type_history_save = 'save'; 

        //$sql = "select * from users u, blogs b,save_and_history_blogs sh where u.usid = sh.usid and b.blog_id = sh.blog_id and sh.usid = '$usid' " or die("sql failed");

        $list_id = getlistid($usid, $conn, 'Read Later');
        $sql = "select lc.lcid,b.*,u.*,l.list_id, 
        (select count(*) from blog_likes bl,users ul where bl.blog_id = b.blog_id and bl.status_like_dislike = 'like' and bl.usid = ul.usid and (ul.user_type = 'user' or ul.user_type = 'blogger')) as likes,
        (select count(*) from blog_comments bc, users uc where bc.blog_id = b.blog_id and bc.status_up_del = 'inserted' and bc.usid = uc.usid and (uc.user_type = 'user' or uc.user_type = 'blogger')) as comments,
        (select b.blog_view + COUNT(bv.blog_views_id) from blog_viewstb bv where b.blog_id = bv.blog_id) as totalviews
        from 
        blogs b,users u ,lists_content lc,lists l, users us
        where u.usid=b.usid and l.usid = us.usid and u.user_type = 'blogger' and  l.list_id = lc.list_id and b.blog_id = lc.blog_id and l.list_id = $list_id and us.usid = $usid
        ORDER by lc.lcid DESC";
        $result = mysqli_query($conn, $sql) or die("query failed");
        $result = mysqli_fetch_all($result, MYSQLI_ASSOC);
        echo json_encode(array('message' => 'Removed from read later.', 'status' => true, 'blogdata' => $result));
    } else {
        echo json_encode(array('message' => 'Some problem in server.', 'status' => false));
    }
}
function clear_readlater($conn)
{
    $usid = 0;
    if (isset($_SESSION['buid'])) {
        $usid = $_SESSION['buid'];
    }
    $list_id = getlistid($usid, $conn, 'Read Later');
    $sql = "delete from lists_content where list_id = $list_id";
    $result = mysqli_query($conn, $sql) or die("query failed");
    if ($result) {
        echo json_encode(array('message' => 'Read list cleared.', 'status' => true));
    } else {
        echo json_encode(array('message' => 'Some problem in server.', 'status' => false));
    }
}
function display_readlater($conn)
{
    $usid = 0;
    if (isset($_SESSION['buid'])) {
        $usid = $_SESSION['buid'];
    }

    //select b.,u.username,(select count() from blog_likes bl where bl.blog_id = b.blog_id and bl.status_like_dislike = 'like') as 'likes',(select count(*) from  blog_comments bc where bc.blog_id = b.blog_id and bc.status_up_del = 'inserted') as 'comments'from blogs b,users u,save_and_history_blogs sh where u.usid = sh.usid and b.blog_id = sh.blog_id and sh.usid = '$blog_id' and sh.type_history_save = 'save'; 

    //$sql = "select * from users u, blogs b,save_and_history_blogs sh where u.usid = sh.usid and b.blog_id = sh.blog_id and sh.usid = '$usid' " or die("sql failed");

    $list_id = getlistid($usid, $conn, 'Read Later');
    $sql = "select lc.lcid,b.*,u.*,l.list_id, 
    (select count(*) from blog_likes bl,users ul where bl.blog_id = b.blog_id and bl.status_like_dislike = 'like' and bl.usid = ul.usid and (ul.user_type = 'user' or ul.user_type = 'blogger')) as likes,
    (select count(*) from blog_comments bc, users uc where bc.blog_id = b.blog_id and bc.status_up_del = 'inserted' and bc.usid = uc.usid and (uc.user_type = 'user' or uc.user_type = 'blogger')) as comments,
    (select b.blog_view + COUNT(bv.blog_views_id) from blog_viewstb bv where b.blog_id = bv.blog_id) as totalviews
    from 
    blogs b,users u ,lists_content lc,lists l, users us
    where u.usid=b.usid and l.usid = us.usid and u.user_type = 'blogger' and  l.list_id = lc.list_id and b.blog_id = lc.blog_id and l.list_id = $list_id and us.usid = $usid
    ORDER by lc.lcid DESC";
    // $sql ="select b.*,u.*,(select count(*) from blog_likes bl,users ul where bl.blog_id = b.blog_id and bl.status_like_dislike = 'like' and bl.usid = ul.usid and (ul.user_type = 'user' or ul.user_type = 'blogger')) as likes,
    // (select count(*) from blog_comments bc, users uc where bc.blog_id = b.blog_id and bc.status_up_del = 'inserted' and bc.usid = uc.usid and (uc.user_type = 'user' or uc.user_type = 'blogger')) as comments
    // from blogs b,users u where u.usid=b.usid and b.blog_id in (select blog_id from lists_content where list_id in (select list_id from lists where usid = '$usid' and list_id = '$list_id') order by lcid desc)";
    // $sql = "select b.*,u.username,(select count(*) from blog_likes bl,users ul where bl.blog_id = b.blog_id and bl.status_like_dislike = 'like' and bl.usid = ul.usid and (ul.user_type = 'user' or ul.user_type = 'blogger')) as 'likes',(select count(*) from  blog_comments bc where bc.blog_id = b.blog_id and bc.status_up_del = 'inserted') as 'comments'from blogs b,users u where u.usid = b.usid and b.blog_id in (select blog_id from lists_content where list_id in (select list_id from lists where usid = '$usid' and list_id = '$list_id'))";
    $result = mysqli_query($conn, $sql) or die("query failed");
    if ($result) {
        $result1 = mysqli_fetch_all($result, MYSQLI_ASSOC);
        $uid = $_SESSION['buid'];
        $sql = "select *from users where usid = '$uid'";
        $result2 = mysqli_query($conn, $sql);
        $result2 = mysqli_fetch_all($result2, MYSQLI_ASSOC);
        echo json_encode(array('message' => 'Displaying Blogs', 'status' => '1', 'userdata' => $result2, 'allblogsdata' => $result1));
        // echo json_encode(array('message' => 'ReadList Displayed Successfully.' , 'status' =>true,'historylists'=>$result1));
    } else {
        echo json_encode(array('message' => 'Error In Displaying ReadList.', 'status' => false));
    }
}

function display_save($data, $conn)
{
    $usid = $data['usid'];

    //select b.,u.username,(select count() from blog_likes bl where bl.blog_id = b.blog_id and bl.status_like_dislike = 'like') as 'likes',(select count(*) from  blog_comments bc where bc.blog_id = b.blog_id and bc.status_up_del = 'inserted') as 'comments'from blogs b,users u,save_and_history_blogs sh where u.usid = sh.usid and b.blog_id = sh.blog_id and sh.usid = '$blog_id' and sh.type_history_save = 'save'; 

    //$sql = "select * from users u, blogs b,save_and_history_blogs sh where u.usid = sh.usid and b.blog_id = sh.blog_id and sh.usid = '$usid' " or die("sql failed");

    $list_id = getlistid($usid, $conn, 'Read Later');

    $sql = "select b.,u.username,(select count() from blog_likes bl where bl.blog_id = b.blog_id and bl.status_like_dislike = 'like') as 'likes',(select count(*) from  blog_comments bc where bc.blog_id = b.blog_id and bc.status_up_del = 'inserted') as 'comments'from blogs b,users u where u.usid = b.usid and b.blog_id in (select blog_id from lists_content where list_id in (select list_id from lists where usid = '$usid' and list_id = '$list_id'))";

    $result = mysqli_query($conn, $sql) or die("query failed");

    $result1 = mysqli_fetch_all($result, MYSQLI_ASSOC);

    if ($result) {
        echo json_encode(array('message' => 'ReadList Displayed Successfully.', 'status' => true, 'savelists' => $result1));
    } else {
        echo json_encode(array('message' => 'Error In Displaying ReadList.', 'status' => false));
    }
}



if ($fkey == "blog_save") {
    blog_save($data, $conn);
} elseif ($fkey == "blog_save_delete") {
    blog_save_delete($data, $conn);
} elseif ($fkey == "display_save") {
    display_save($data, $conn);
} elseif ($fkey == "delete_history") {
    delete_history($data, $conn);
} elseif ($fkey == "display_history") {
    display_history($data, $conn);
} elseif ($fkey == "clear_history") {
    clear_history($conn);
} elseif ($fkey == "add_content_to_readlist") {
    add_content_to_readlist($data, $conn);
} elseif ($fkey == "delete_content_from_readlist_h") {
    delete_content_from_readlist_h($data, $conn);
} elseif ($fkey == "create_readlist") {
    create_readlist($data, $conn);
} elseif ($fkey == "delete_readlist") {
    delete_readlist($data, $conn);
} elseif ($fkey == "update_readlist_status") {
    update_readlist_status($data, $conn);
} elseif ($fkey == "display_one_readlist") {
    display_one_readlist($data, $conn);
} elseif ($fkey == "update_readlist_title") {
    update_readlist_title($data, $conn);
} elseif ($fkey == "update_content_status_of_readlist") {
    update_content_status_of_readlist($data, $conn);
} elseif ($fkey == "clear_readlist") {
    clear_readlist($data, $conn);
} elseif ($fkey == "display_readlist") {
    display_readlist($conn);
} elseif ($fkey == "delete_content_from_readlist") {
    delete_content_from_readlist($data, $conn);
} elseif ($fkey == "addblog_show_readlist") {
    addblog_show_readlist($data, $conn);
} elseif ($fkey == "addmultipleblog_show_readlist") {
    addmultipleblog_show_readlist($conn);
} elseif ($fkey == "add_multiplecontent_to_readlist") {
    add_multiplecontent_to_readlist($data, $conn);
} elseif ($fkey == "delete_content_from_readlater") {
    delete_content_from_readlater($data, $conn);
} elseif ($fkey == "clear_readlater") {
    clear_readlater($conn);
} elseif ($fkey == "display_readlater") {
    display_readlater($conn);
} else {
    echo json_encode(array('message' => 'Error in sending Lists Api key', 'status' => false));
}



?>