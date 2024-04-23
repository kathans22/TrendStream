<?php

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Methods: DELETE');
header('Access-Control-Allow-Methods: PUT');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');


$data = json_decode(file_get_contents("php://input"), true);

$fkey = $data['key'];

include "../config.php";

function display_category($data, $conn)
{
    $index = $data['index'];
    $search = $data['searchvalue'];

    $limit = 10;

    $offset = $index * $limit;
    $sql = "";
    if ($search != null) {
        $sql = "select bc.*,(select count(*) from blogs b where b.bcid = bc.bcid) as totalblogs from blog_categorys bc where bcname like '%$search%' LIMIT $limit OFFSET $offset";
    } else {
        $sql = "select bc.*,(select count(*) from blogs b where b.bcid = bc.bcid and b.blog_status = 'posted') as totalblogs from blog_categorys bc LIMIT $limit OFFSET $offset";
        // $sql = "select  * from blog_categorys"; 
    }
    $result = mysqli_query($conn, $sql) or die("query failed");
    if ($result) {
        $result = mysqli_fetch_all($result, MYSQLI_ASSOC);
        echo json_encode(array('message' => 'Displaying languages', 'status' => true, 'categorys' => $result));
    } else {
        echo json_encode(array('message' => 'Error In Displaying Languages Details Or Else No Record Found', 'status' => false));
    }
}
function add_category($data, $conn)
{
    $bcname = $data['bcname'];
    $sql = "insert into blog_categorys(bcname) values('$bcname')";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        echo json_encode(array('message' => $bcname . ' is inserted successfully.', 'status' => true));
    } else {
        echo json_encode(array('message' => 'server error..', 'status' => false, 'error' => 'server'));
    }
}
function delete_category($data, $conn)
{
    $bcid = $data['bcid'];

    $sql = "delete from blog_categorys where bcid = '$bcid'" or die("sql failed");

    $result = mysqli_query($conn, $sql) or die("query failed");

    if ($result) {
        echo json_encode(array('message' => 'Details Deleted', 'status' => true));
    } else {
        echo json_encode(array('message' => 'Error In Deletion', 'status' => false));
    }
}

function single_fetch_category($data, $conn)
{
    $bcid = $data['bcid'];

    $sql = "select * from blog_categorys where bcid = '$bcid'" or die("query failed");

    $result = mysqli_query($conn, $sql) or die("query failed");


    if ($result) {
        $result = mysqli_fetch_all($result, MYSQLI_ASSOC);
        echo json_encode(array('message' => 'Displaying Single Category Details', 'status' => true, 'category' => $result));
    } else {
        echo json_encode(array('message' => 'Error In Displaying Category Details Or Else No Record Founded', 'status' => false));
    }
}


function update_category($data, $conn)
{
    $bcid = $data['bcid'];
    $bcname = $data['bcname'];

    $sql = "update blog_categorys set bcname = '$bcname' where bcid = '$bcid'" or die("sql failed");
    
    $result = mysqli_query($conn, $sql) or die("query failed");
    
    if ($result) {
        echo json_encode(array('message' => 'Information Updated Successfully.', 'status' => true));
    } else {
        echo json_encode(array('message' => 'Error In Updating The Information.', 'status' => false));
    }
}

function search_category($data, $conn)
{
    $search = $data['search'];

    $sql = "select * blog_categorys from where bcname = '%$search%' or bcid = '%$search%'" or die("sql failed");

    $result = mysqli_query($conn, $sql) or die("query failed");

    $result1 = mysqli_fetch_all($result, MYSQLI_ASSOC);

    if ($result) {
        echo json_encode(array('message' => 'Displaying Searched Category Details', 'status' => true, 'searchcategorydata' => $result1, 'k1' => 'search'));
    } else {
        echo json_encode(array('message' => 'Error In Displaying Searched Category Details Or Else No Record Founded', 'status' => false));
    }
}

if ($fkey == "display_category") {
    display_category($data, $conn);
} elseif ($fkey == "add_category") {
    add_category($data, $conn);
} elseif ($fkey == "delete_category") {
    delete_category($data, $conn);
} elseif ($fkey == "single_fetch_category") {
    single_fetch_category($data, $conn);
} elseif ($fkey == "update_category") {
    update_category($data, $conn);
} elseif ($fkey == "search_category") {
    search_category($data, $conn);
} else {
    echo json_encode(array('message' => 'Error in sending Categorymaster Api key', 'status' => false));
}

?>