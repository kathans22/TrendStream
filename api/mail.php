<?php

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
function sendOTP($data)
{
    $mail = new PHPMailer(true);
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    // Email password
    $mail->Username = '';
    $mail->Password = '';
    $mail->SMTPSecure = 'ssl';
    $mail->Port = 465;
    $mail->setFrom('abhayprajapati.mscit20@vnsgu.ac.in');
    $email = $data['suemail'];
    $mail->addAddress($email);
    $mail->isHTML(true);
    $mail->Subject = "OTP";
    $otp = generateOTP();
    $_SESSION['otpsend'] = $otp;
    $msg = "<div style='font-family: Helvetica,Arial,sans-serif;min-width:1000px;overflow:auto;line-height:2'>
                <div style='margin:50px auto;width:70%;padding:20px 0'>
                    <div style='border-bottom:1px solid #eee'>
                        <a href='' style='font-size:1.4em;color: #00466a;text-decoration:none;font-weight:600'>Your Brand</a>
                    </div>
                    <p style='font-size:1.1em'>Hi,</p>
                    <p>Thank you for choosing project name. Use the following OTP to complete your Sign Up procedures. OTP is valid for 5 minutes</p>
                    <h2 style='background: #00466a;margin: 0 auto;width: max-content;padding: 0 10px;color: #fff;border-radius: 4px;'>" . ($otp) . "</h2>
                    <p style='font-size:0.9em;'>Regards,<br />project name</p>
                    <hr style='border:none;border-top:1px solid #eee' />
                    <div style='float:right;padding:8px 0;color:#aaa;font-size:0.8em;line-height:1;font-weight:300'>
                        <p>project Inc</p>
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

?>