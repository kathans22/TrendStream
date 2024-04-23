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

function display_all($conn)
{
    $sql = "select * from users" or die("query failed");

    $result = mysqli_query($conn, $sql) or die("query failed");

    $result1 = mysqli_fetch_all($result, MYSQLI_ASSOC);

    if ($result) {
        echo json_encode(array('message' => 'Displaying All Users Details', 'status' => true, 'allusersdata' => $result1, 'k1' => 'alluserdisplay'));
    } else {
        echo json_encode(array('message' => 'Error In Displaying All User Details', 'status' => false));
    }
}


function display_users($data, $conn)
{
    $index = $data['index'];
    $limit = 10;
    $offset = $index * $limit;
    $user_type = $data['user_type'];
    $status_type = $data['status_type'];
    $search = $data['searchvalue'];
    $sql = "";
    if ($user_type != null || $status_type != null || $search != null) {
        if ($user_type != null && $status_type != null && $search != null) {
            $sql = "";
            if($status_type == "active"){
                $sql = "select * from users where user_type = '$user_type' and (username LIKE '%$search%' or ufname LIKE '%$search%' or ulname LIKE '%$search%' or user_type LIKE '%$search%') LIMIT $limit OFFSET $offset";
            }elseif($status_type == "delete"){
                $sql = "select * from users where user_type = 'deleted' and (username LIKE '%$search%' or ufname LIKE '%$search%' or ulname LIKE '%$search%' or user_type LIKE '%$search%') LIMIT $limit OFFSET $offset";
            }
        } else if ($user_type != null && $status_type != null) {
            $sql = "";
            // if($status_type == "")
            if($status_type == "active"){
                $sql = "select * from users where user_type = '$user_type' LIMIT $limit OFFSET $offset";
            }elseif($status_type == "delete"){
                $sql = "select * from users where user_type = 'deleted' LIMIT $limit OFFSET $offset";
            }
        } else if ($user_type != null && $search != null) {
            $sql = "select * from users where user_type = '$user_type' and (username LIKE '%$search%' or ufname LIKE '%$search%' or ulname LIKE '%$search%' or user_type LIKE '%$search%') LIMIT $limit OFFSET $offset";
        } else if ($status_type != null && $search != null) {
            if($status_type == "active"){
                $sql = "select * from users where (user_type = 'user' or user_type = 'blogger') and (username LIKE '%$search%' or ufname LIKE '%$search%' or ulname LIKE '%$search%' or user_type LIKE '%$search%') LIMIT $limit OFFSET $offset";
            }elseif($status_type == "delete"){
                $sql = "select * from users where user_type = 'deleted' and (username LIKE '%$search%' or ufname LIKE '%$search%' or ulname LIKE '%$search%' or user_type LIKE '%$search%') LIMIT $limit OFFSET $offset";
            }
        } else if ($status_type == null && $search == null) {
            $sql = "select * from users where user_type = '$user_type' LIMIT $limit OFFSET $offset";
        } else if ($user_type == null && $search == null) {
            if($status_type == "active"){
                $sql = "select * from users where user_type = 'user' or user_type = 'blogger' LIMIT $limit OFFSET $offset";
            }elseif($status_type == "delete"){
                $sql = "select * from users where user_type = 'deleted' LIMIT $limit OFFSET $offset";
            }
        } else if ($user_type == null && $status_type == null) {
        $sql = "select * from users where username LIKE '%$search%' or ufname LIKE '%$search%' or ulname LIKE '%$search%' or user_type LIKE '%$search%' LIMIT $limit OFFSET $offset";
        }
    } else {
        $sql = "select * from users LIMIT $limit OFFSET $offset";
    }

    $result = mysqli_query($conn, $sql) or die("query failed");


    if ($result) {
        $result = mysqli_fetch_all($result, MYSQLI_ASSOC);
        echo json_encode(array('message' => 'Displaying Users Details', 'status' => true, 'users' => $result, 'k1' => 'userdisplay'));
    } else {
        echo json_encode(array('message' => 'Error In Displaying User Details Or Else No Record Founded', 'status' => false));
    }



}

function display_blogger($conn)
{
    $sql = "select * from users where user_type = 'blogger'" or die("query failed");

    $result = mysqli_query($conn, $sql) or die("query failed");

    $result1 = mysqli_fetch_all($result, MYSQLI_ASSOC);

    if ($result) {
        echo json_encode(array('message' => 'Displaying Bloggers Details', 'status' => true, 'allbloggerdata' => $result1, 'k1' => 'bloggerdisplay'));
    } else {
        echo json_encode(array('message' => 'Error In Displaying Blogger Details Or Else No Record Founded', 'status' => false));
    }
}

function delete_user($data, $conn)
{
    $usid = $data['usid'];

    $sql = "update users set user_type = 'deleted' where usid = '$usid'" or die("sql failed");

    $result = mysqli_query($conn, $sql) or die("query failed");

    if ($result) {
        echo json_encode(array('message' => 'Details Deleted', 'status' => true));
    } else {
        echo json_encode(array('message' => 'Error In Deletion', 'status' => false));
    }
}

function single_fetch($data, $conn)
{
    $usid = $data['usid'];
    $sql = "select * from users where usid = '$usid'" or die("query failed");

    $result = mysqli_query($conn, $sql) or die("query failed");

    $result1 = mysqli_fetch_all($result, MYSQLI_ASSOC);

    if ($result) {
        echo json_encode(array('message' => 'Displaying Single Users Details', 'status' => true, 'usersdata' => $result1, 'k1' => 'userdisplay'));
    } else {
        echo json_encode(array('message' => 'Error In Displaying User Details Or Else No Record Founded', 'status' => false));
    }
}


function update_user($data, $conn)
{
    $usid = $data['usid'];
    $ufname = $data['ufname'];
    $ulname = $data['ulname'];
    $email = $data['email'];
    $username = $data['username'];
    $mbno = $data['mbno'];
    $password = $data['password'];
    $photo = $data['photo'];
    $onlinestatus = $data['onlinestatus'];
    $birthdate = $data['birthdate'];
    $gender = $data['gender'];
    $location_js = $data['location_js'];
    $user_type = $data['user_type'];

    $sql = "update users set ufname = '$ufname', ulname = '$ulname',email = '$email', username = '$username', mbno = '$mbno', password = '$password', photo = '$photo', onlinestatus = '$onlinestatus',birthdate = '$birthdate', gender = '$gender', location_js = '$location_js', user_type = '$user_type' where usid = '$usid'" or die("sql failed");

    $result = mysqli_query($conn, $sql) or die("query failed");

    if ($result) {
        echo json_encode(array('message' => 'Information Updated Successfully.', 'status' => true, 'k1' => 'details updated'));
    } else {
        echo json_encode(array('message' => 'Error In Updating The Information.', 'status' => false));
    }
}

function search_user($data, $conn)
{
    $search = $data['search'];

    $sql = "select * from users where ufname like '%$search%' or ulname like '%$search%' or email like '%$search%' or username like '%$search%' or mbno like '%$search%' or password like '%$search%' or photo like '%$search%' or onlinestatus like '%$search%' or birthdate like '%$search%' or gender like '%$search%' or location_js like '%$search%' or user_type like '%$search%' or usid like '%$search%'" or die("sql failed");

    $result = mysqli_query($conn, $sql) or die("query failed");

    $result1 = mysqli_fetch_all($result, MYSQLI_ASSOC);

    if ($result) {
        echo json_encode(array('message' => 'Displaying Searched Users Details', 'status' => true, 'searchdata' => $result1, 'k1' => 'search'));
    } else {
        echo json_encode(array('message' => 'Error In Displaying Searched User Details Or Else No Record Founded', 'status' => false));
    }
}

if ($fkey == "display_all") {
    display_all($data);
} elseif ($fkey == "display_users") {
    display_users($data, $conn);
} elseif ($fkey == "display_blogger") {
    display_blogger($conn);
} elseif ($fkey == "delete_user") {
    delete_user($data, $conn);
} elseif ($fkey == "single_fetch") {
    single_fetch($data, $conn);
} elseif ($fkey == "update_user") {
    update_user($data, $conn);
} elseif ($fkey == "search_user") {
    search_user($data, $conn);
} else {
    echo json_encode(array('message' => 'Error in sending Usermaster Api key', 'status' => false));
}

?>