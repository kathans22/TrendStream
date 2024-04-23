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

function display_language($data, $conn)
{
    $index = $data['index'];
    $search = $data['searchvalue'];

    $limit = 10;

    $offset = $index * $limit;
    $sql = "";
    if ($search != null) {
        $sql = "select l.*,(select count(*) from blogs b where l.lcode = b.lcode and b.blog_status = 'posted') as totalblogs from languages l where l.lname like '%$search%' or l.lcode like '%$search%' LIMIT $limit OFFSET $offset";
    } else {
        $sql = "select l.*,(select count(*) from blogs b where l.lcode = b.lcode and b.blog_status = 'posted') as totalblogs from languages l LIMIT $limit OFFSET $offset";
        // $sql = "select * from languages LIMIT $limit OFFSET $offset" or die("sql failed");
    }
    $result = mysqli_query($conn, $sql) or die("query failed");
    if ($result) {
        $result = mysqli_fetch_all($result, MYSQLI_ASSOC);
        echo json_encode(array('message' => 'Displaying languages', 'status' => true, 'languages' => $result));
    } else {
        echo json_encode(array('message' => 'Error In Displaying Languages Details Or Else No Record Found', 'status' => false));
    }
}

function add_language($data, $conn)
{
    $lcode = $data['lcode'];
    $lname = $data['lname'];
    $sql = "select * from languages where lcode = '$lcode'";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        echo json_encode(array('message' => 'language code is already available in database.', 'status' => false, 'error' => 'lcode'));
    } else {
        $sql = "insert into languages(lcode,lname) values('$lcode','$lname')";
        $result = mysqli_query($conn, $sql);
        if ($result) {
            echo json_encode(array('message' => $lname . ' is inserted successfully.', 'status' => true));
        } else {
            echo json_encode(array('message' => 'language code is already available in database.', 'status' => false, 'error' => 'server'));
        }
    }

}
function delete_language($data, $conn)
{
    $lcode = $data['lcode'];

    $sql = "delete from languages where lcode = '$lcode'" or die("sql failed");

    $result = mysqli_query($conn, $sql) or die("query failed");

    if ($result) {
        echo json_encode(array('message' => 'Details Deleted', 'status' => true));
    } else {
        echo json_encode(array('message' => 'Error In Deletion', 'status' => false));
    }
}

function single_fetch_language($data, $conn)
{


    // echo json_encode(array('message' => 'Error In Displaying Language Details Or Else No Record Founded', 'status' => false));

    $lcode = $data['lcode'];

    $sql = "select * from languages where lcode = '$lcode'";

    $result = mysqli_query($conn, $sql) or die("query failed");

    $result = mysqli_fetch_all($result, MYSQLI_ASSOC);

    if ($result) {
        echo json_encode(array('message' => 'Displaying Single Language Details', 'status' => true, 'language' => $result));
    } else {
        echo json_encode(array('message' => 'Error In Displaying Language Details Or Else No Record Founded', 'status' => false));
    }
}


function update_language($data, $conn)
{
    $lcode = $data['lcode'];
    $lname = $data['lname'];

    $sql = "update languages set lname = '$lname' where lcode = '$lcode'" or die("sql failed");

    $result = mysqli_query($conn, $sql) or die("query failed");

    if ($result) {
        echo json_encode(array('message' => 'Information Updated Successfully.', 'status' => true));
    } else {
        echo json_encode(array('message' => 'Error In Updating The Information.', 'status' => false));
    }
}

function search_language($data, $conn)
{
    $search = $data['search'];

    $sql = "select * from languages where lname like '%$search%' or lcode like '%$search%'" or die("sql failed");

    $result = mysqli_query($conn, $sql) or die("query failed");

    $result1 = mysqli_fetch_all($result, MYSQLI_ASSOC);

    if ($result) {
        echo json_encode(array('message' => 'Displaying Searched Language Details', 'status' => true, 'searchdata' => $result1, 'k1' => 'search'));
    } else {
        echo json_encode(array('message' => 'Error In Displaying Search Language Details Or Else No Record Founded', 'status' => false));
    }
}

if ($fkey == "display_language") {
    display_language($data, $conn);
} elseif ($fkey == "add_language") {
    add_language($data, $conn);
} elseif ($fkey == "delete_language") {
    delete_language($data, $conn);
} elseif ($fkey == "single_fetch_language") {
    single_fetch_language($data, $conn);
} elseif ($fkey == "update_language") {
    update_language($data, $conn);
} elseif ($fkey == "search_language") {
    search_language($data, $conn);
} else {
    echo json_encode(array('message' => 'Error in sending Languagemaster Api key', 'status' => false));
}

?>