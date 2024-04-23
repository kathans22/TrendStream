<?php
header('Content-type: text');
header('Access-Control-Allow-Origin: *');
$src= $_FILES['coverimage']['tmp_name'];
$filename = $_FILES['coverimage']['name'];
$output_dir = '../images/uploadimage/'.$filename;
// $target_path_2="C:\xampp\htdocs\mycode\shpoingcart\customerpnl";
if (move_uploaded_file($src, $output_dir)) {
    echo json_encode(array('message'=>'file uploaded successfully.','status'=>1));
} else{
    echo json_encode(array('message'=>'file was not upload.','status'=>0));
}   