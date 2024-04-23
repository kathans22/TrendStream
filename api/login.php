<?php
session_start();
use PHPMailer\PHPMailer\Exception;

use PHPMailer\PHPMailer\PHPMailer;


require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

header('Content-type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow_Methods: POST');
// header('Access-Control-Allow_Headers: Access-Control-Allow_Headers,Content-type,Access-Control-Allow_Methods,Authorization,X-Requested-With');

include "./config.php";

$data = json_decode(file_get_contents("php://input"), true);
$fkey = $data['fkey'];
// echo json_encode(array('key' => $fkey));
function generateOTP()
{
    $otp = '';
    for ($i = 0; $i < 4; $i++) {
        $otp .= mt_rand(0, 9);
    }
    return $otp;
}
function checkOTP($data)
{
    $botp = "";
    if (isset($_SESSION['BlogregiOTP'])) {
        $botp = $_SESSION['BlogregiOTP'];
    }

    if ($_SESSION['BlogregiOTP'] == $data['otp']) {
        echo json_encode(array('message' => 'OTP is right.', 'status' => true, 'eotp' => $data['otp'], 'otp' => $botp));
    } else {
        echo json_encode(array('message' => 'Enter correct OTP.', 'status' => false));
    }
}
function sendOTP($data)
{
    $mail = new PHPMailer(true);
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    // $mail->Username = 'abhayprajapati.mscit20@vnsgu.ac.in';
    // $mail->Password = 'fyydlhwavfhdoady';
    $mail->Username = 'kathanshah.mscit20@vnsgu.ac.in';
    $mail->Password = 'bszgfblwxrhahkiz';
    $mail->SMTPSecure = 'ssl';
    $mail->Port = 465;
    // $mail->setFrom('abhayprajapati.mscit20@vnsgu.ac.in');
    $mail->setFrom('kathanshah.mscit20@vnsgu.ac.in');
    $email = $data['suemail'];
    $mail->addAddress($email);
    $mail->isHTML(true);
    $mail->Subject = "OTP";
    $otp = generateOTP();
    $_SESSION['BlogregiOTP'] = $otp;
    $msg = "<div style='font-family: Helvetica,Arial,sans-serif;min-width:1000px;overflow:auto;line-height:2'>
    <div style='margin:50px auto;width:70%;padding:20px 0'>
      <div style='border-bottom:1px solid #eee'>
        <a href='' style='font-size:1.4em;color: #00466a;text-decoration:none;font-weight:600'>Your Brand</a>
      </div>
      <p style='font-size:1.1em'>Hi,</p>
      <p>Thank you for choosing TrendStream. Use the following OTP to complete your Sign Up procedures. OTP is valid for 5 minutes</p>
      <h2 style='background: #00466a;margin: 0 auto;width: max-content;padding: 0 10px;color: #fff;border-radius: 4px;'>" . ($otp) . "</h2>
      <p style='font-size:0.9em;'>Regards,<br />TrendStream</p>
      <hr style='border:none;border-top:1px solid #eee' />
      <div style='float:right;padding:8px 0;color:#aaa;font-size:0.8em;line-height:1;font-weight:300'>
        <p>TrendStream Inc</p>
      </div>
    </div>
  </div>";
    $mail->Body = $msg;
    if ($mail->send()) {
        echo json_encode(array('message' => 'otp is send', 'status' => true, 'otp' => $otp));
    } else {
        echo json_encode(array('message' => 'otp is not send', 'status' => false));
    }

}
function checkuser($data, $conn)
{
    $uname = $data['suname'];
    $sql = "select *from users where username = '{$uname}' and (user_type = 'blogger' or user_type = 'user')";
    if (mysqli_num_rows(mysqli_query($conn, $sql)) >= 1) {
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        $_SESSION['forgotuid'] = $row['usid'];
        echo json_encode(array('message' => $uname . ' is already registered.', 'status' => false, 'userdata' => $row));
    } else {
        echo json_encode(array('message' => $uname . 'is not found.', 'status' => true));
    }
}
function changepassword($data, $conn)
{
    $password = $data['password'];
    $usid = $_SESSION['forgotuid'];
    $hashpassword = password_hash($password, PASSWORD_DEFAULT);
    $sql = "UPDATE users set password = '{$hashpassword}' where usid = {$usid}";
    $result = mysqli_query($conn, $sql) or die("query failed");
    if ($result == 1) {
        echo json_encode(array('message' => 'Your password change succesfully.', 'status' => true));
    } else {
        echo json_encode(array('message' => 'Error in Password changging.', 'status' => false));
    }
}
function signup($data, $conn)
{
    $uname = $data['suname'];
    $email = $data['suemail'];
    $password = $data['supassword'];
    $hashpassword = password_hash($password, PASSWORD_DEFAULT);
    // echo $uname . $email;
    $sql = "select *from users where username = '{$uname}'";
    if (mysqli_num_rows(mysqli_query($conn, $sql)) >= 1) {
        echo json_encode(array('message' => $uname . ' is already registered.', 'status' => 0));
    } else {
        $query = "insert into users(username,email,password) values('{$uname}','{$email}','{$hashpassword}')";
        $result = mysqli_query($conn, $query) or die("query failed");
        if ($result == 1) {
            $lastid = mysqli_insert_id($conn);
            $sql = "INSERT into lists (usid,list_title) values($lastid,'History')";
            $result = mysqli_query($conn, $sql);
            $sql = "INSERT into lists (usid,list_title) values($lastid,'Read Later')";
            $result = mysqli_query($conn, $sql);
            echo json_encode(array('message' => 'Successfully Registered.', 'status' => 2));
        } else {
            echo json_encode(array('message' => 'Error in Registering.', 'status' => 1));
        }
    }

}
function signin($data, $conn)
{
    $uname = $data['suname'];
    $password = $data['supassword'];
    // $hashpassword = password_hash($password, PASSWORD_DEFAULT);
    $sql = "select *from users where username = '{$uname}' and (user_type = 'blogger' or user_type = 'user')";
    if (mysqli_num_rows(mysqli_query($conn, $sql)) >= 1) {
        $result = mysqli_query($conn, $sql);
        // echo json_encode(array('message' => 'Enter correct password.', 'status' => '1' , 'result '=>mysqli_fetch_all($result, MYSQLI_ASSOC)));
        while ($rows = mysqli_fetch_assoc($result)) {
            if (password_verify($password, $rows['password'])) {
                $userType = "";
                $_SESSION['buname'] = $rows['username'];
                $_SESSION['buid'] = $rows['usid'];
                $userType = $rows['user_type'];
                echo json_encode(array('message' => 'Login Success', 'status' => '2', 'userType' => $userType));
            } else {
                // $result = mysqli_fetch_all(mysqli_query($conn, $sql), MYSQLI_ASSOC);
                echo json_encode(array('message' => 'Enter correct password.', 'status' => '1', 'password' => $password, 'result ' => mysqli_fetch_all($result, MYSQLI_ASSOC), "user" => $rows['password']));
            }
        }
        //     $hashpassword = $rows['password'];
        //     if (password_verify($password, $hashpassword)) {
        //         $userType = "";
        //         $_SESSION['buname'] = $rows['username'];
        //         $_SESSION['buid'] = $rows['usid'];
        //         $userType = $rows['user_type'];
        //         echo json_encode(array('message' => 'Login Success', 'status' => '2', 'userType' => $userType));
        //     } else {
        //         // $result = mysqli_fetch_all(mysqli_query($conn, $sql), MYSQLI_ASSOC);
        //         echo json_encode(array('message' => 'Enter correct password.', 'status' => '1' ,'password'=> $password, 'result '=>mysqli_fetch_all($result, MYSQLI_ASSOC) , "user"=>$hashpassword));
        //     }
        // }
        // $sql = "select *from users where username = '{$uname}' and password = '{$hashpassword}'";
        // if(mysqli_num_rows(mysqli_query($conn,$sql))==1)
        // {
        //     $userType = "";
        //     $result = mysqli_query($conn,$sql);
        //     while($rows = mysqli_fetch_assoc($result)){
        //         $_SESSION['buname'] = $rows['username'];
        //         $_SESSION['buid'] = $rows['usid'];
        //         $userType = $rows['user_type'];
        //     }
        //     echo json_encode(array('message'=>'Login Success','status'=>'2','userType'=> $userType));
        // }
        // else
        // {
        //     echo json_encode(array('message'=>'Enter correct password.','status'=>'1'));
        // }
    } else {
        echo json_encode(array('message' => $uname . ' is not found.', 'status' => '0'));
    }
    // echo json_encode(array($data));
}
function checklogin($conn)
{
    if (!isset($_SESSION['buid']) && !isset($_SESSION['buname'])) {
        echo json_encode(array('message' => 'not login.', 'status' => false, 'userdata' => [['username' => 'guest', 'usid' => 0, 'user_type' => 'guest']]));
    } else {
        $usid = $_SESSION['buid'];
        $sql = "select *from users where usid = {$usid}";
        if (mysqli_num_rows(mysqli_query($conn, $sql)) == 1) {
            $result = mysqli_query($conn, $sql);
            $result = mysqli_fetch_all($result, MYSQLI_ASSOC);
            echo json_encode(array('message' => 'Login Success', 'status' => true, 'userdata' => $result));
        }
    }
}

function sendhelp($data, $conn)
{

    $subject = $data['subject'];
    $messagebody = $data['messagebody'];
    $usid = 0;
    $username = "guest";
    if (isset($_SESSION['buid'])) {
        $usid = $_SESSION['buid'];
        $username = $_SESSION['buname'];
    }

    $mail = new PHPMailer(true);

    $mail->isSMTP();

    $mail->Host = 'smtp.gmail.com';

    $mail->SMTPAuth = true;

    $mail->Username = 'kathanshah.mscit20@vnsgu.ac.in';

    // $mail->SMTPSecure = '';
    //$mail->Password = 'fyydlhwavfhdoady';
   $mail->Password = 'bszgfblwxrhahkiz';

    $mail->SMTPSecure = 'ssl';

    $mail->Port = 465;

    $mail->setFrom('kathanshah.mscit20@vnsgu.ac.in');

    $mail->addAddress('kathanshah.mscit20@vnsgu.ac.in');

    $mail->isHTML(true);

    $mail->Subject = $subject;

    $msg = '<div style="font-family: Helvetica, Arial, sans-serif; min-width: 1000px; overflow: auto; line-height: 2;">
                <div style="margin: 50px auto; width: 70%; padding: 20px 0;">
                <div style="border-bottom: 1px solid #eee;">
                    <a href="#" style="font-size: 1.4em; color: #00466a; text-decoration: none; font-weight: 600;">Blog see</a>
                </div>
                <p style="font-size: 1.1em;">Hi,</p>
                <p style="font-size: 1.1em;">User id : '.$usid.', Username : '.$username.' </p>
                <p>User Message : '.$messagebody.'</p>
                <p style="font-size: 0.9em;">Regards,<br />TrendStream</p>
                <hr style="border: none; border-top: 1px solid #eee;" />
                <div style="float: right; padding: 8px 0; color: #aaa; font-size: 0.8em; line-height: 1; font-weight: 300;">
                    <p>TrendStream Inc</p>
                </div>
                </div>
            </div>
  ';
    $mail->Body = $msg;

    if ($mail->send()) {
        echo json_encode(array('message' => 'Send message successfully.', 'status' => true));
    } else {
        echo json_encode(array('message' => 'message notsend', 'status' => false));
    }
}


if ($fkey == "signup") {
    signup($data, $conn);
} elseif ($fkey == "signin") {
    signin($data, $conn);
} elseif ($fkey == "checklogin") {
    checklogin($conn);
} else if ($fkey == "checkuser") {
    checkuser($data, $conn);
} else if ($fkey == "sendotp") {
    sendOTP($data);
} else if ($fkey == "checkotp") {
    checkOTP($data);
} else if ($fkey == "changepassword") {
    changepassword($data, $conn);
} else if ($fkey == "sendhelp") {
    sendhelp($data, $conn);
}
//comment
?>