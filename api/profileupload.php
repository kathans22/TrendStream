<?php
session_start();
header('Content-type: text');
header('Access-Control-Allow-Origin: *');

include "./config.php";


//upload.php

if (isset($_POST['image'])) {
    $data = $_POST['image'];

    $usid = $_SESSION['buid'];

    // $sql = "select from users where usid = $usid";
    // $result = mysqli_query($conn, $sql) or die("query failed");
    // $row = mysqli_fetch_assoc($result);
    // $photo = $row['photo']; 

    $image_array_1 = explode(";", $data);

    $image_array_2 = explode(",", $image_array_1[1]);

    $data = base64_decode($image_array_2[1]);

    $image_name = 'profile' . time() . '.png';

    $image_path = '../images/faces/profile/' . $image_name;

    file_put_contents($image_path, $data);

    $sql = "update users set photo = '$image_name' where usid = '$usid'" or die("sql failed");

    $result = mysqli_query($conn, $sql) or die("query failed");
    if ($result) {
        echo json_encode(array('message' => 'Profile image updated successfully.', 'status' => true, 'profilepic' => $image_name));
    } else {
        echo json_encode(array('message' => 'Error In Updating The Profile Pic.', 'status' => false));
    }

    //echo $image_name;
}

?>