<?php 
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
session_start();

session_unset();

session_destroy();

echo json_encode(array('message'=> 'successfull logout','status'=>'1'));

?>