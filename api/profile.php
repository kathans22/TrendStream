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
$fkey = $data['key'];
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
    if (isset($_SESSION['blogpOTP'])) {
        if ($_SESSION['blogpOTP'] == $data['otp']) {
            $_SESSION['blogpOTP'] = "";
            echo json_encode(array('message' => 'OTP is right.', 'status' => true));
        } else {
            echo json_encode(array('message' => 'Enter correct OTP.', 'status' => false));
        }
    } else {
        echo json_encode(array('message' => 'Enter correct OTP.', 'status' => false));
    }

}
function sendOTP($data, $conn)
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
    //$mail->setFrom('abhayprajapati.mscit20@vnsgu.ac.in');
    $mail->setFrom('kathanshah.mscit20@vnsgu.ac.in');
    $email = "";
    if (isset($data['email'])) {
        $email = $data['email'];
    } else {
        $usid = $_SESSION['buid'];
        $sql = "select email from users where usid = $usid";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        $email = $row['email'];
    }
    $mail->addAddress($email);
    $mail->isHTML(true);
    $mail->Subject = "OTP";
    $otp = generateOTP();
    $_SESSION['blogpOTP'] = $otp;
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
function profile_data($conn)
{
    $usid = 0;
    if (isset($_SESSION['buid'])) {
        $usid = $_SESSION['buid'];
    }
    $sql = "select * from users where usid = '$usid'";

    $result = mysqli_query($conn, $sql);
    if ($result) {
        $result = mysqli_fetch_all($result, MYSQLI_ASSOC);
        echo json_encode(array('message' => 'Profile Data', 'status' => true, 'profiledata' => $result));
    } else {
        echo json_encode(array('message' => 'Get profile Data in some error.', 'status' => false));
    }

}

function profile_display($data, $conn)
{

    $usid = $data['usid'];

    $sql = "select * from users where usid = '$usid' and (user_type = 'blogger' or user_type = 'user')";

    $result = mysqli_query($conn, $sql);

    $result1 = mysqli_fetch_all($result, MYSQLI_ASSOC);

    $sql = "select count(*) as totallikes from blog_likes l where l.status_like_dislike = 'like' and blog_id in (select blog_id from blogs where blog_status = 'posted' and usid = '$usid')";

    $result = mysqli_query($conn, $sql);

    $result2 = mysqli_fetch_all($result, MYSQLI_ASSOC);

    $sql = "select count(*) as totalcomments from blog_comments  where status_up_del='inserted' and blog_id in (select blog_id from blogs where blog_status = 'posted' and usid = '$usid') ";

    $result = mysqli_query($conn, $sql);

    $result6 = mysqli_fetch_all($result, MYSQLI_ASSOC);

    $sql = "select count(*) as totalblogs from blogs where blog_status='posted' and usid = '$usid'";

    $result = mysqli_query($conn, $sql);

    $result7 = mysqli_fetch_all($result, MYSQLI_ASSOC);

    if (isset($_SESSION['buid'])) {
        if ($usid == $_SESSION['buid']) {
            // $sql = "SELECT l.*,(SELECT COUNT(*) from lists_content lc WHERE l.list_id = lc.list_id) as totalblog FROM lists l where l.usid = $usid";
            $sql = "select b.*,u.*,(select count(*) from blog_likes bl,users ul where bl.blog_id = b.blog_id and bl.status_like_dislike = 'like' and bl.usid = ul.usid and (ul.user_type = 'user' or ul.user_type = 'blogger')) as likes,
            (select count(*) from blog_comments bc, users uc where bc.blog_id = b.blog_id and bc.status_up_del = 'inserted' and bc.usid = uc.usid and (uc.user_type = 'user' or uc.user_type = 'blogger')) as comments,
            (select b.blog_view + COUNT(bv.blog_views_id) from blog_viewstb bv where b.blog_id = bv.blog_id) as totalviews
            from blogs b,users u where u.usid=b.usid and b.usid = $usid order by b.blog_id desc";
        } else {
            $sql = "select b.*,u.*,(select count(*) from blog_likes bl,users ul where bl.blog_id = b.blog_id and bl.status_like_dislike = 'like' and bl.usid = ul.usid and (ul.user_type = 'user' or ul.user_type = 'blogger')) as likes,
            (select count(*) from blog_comments bc, users uc where bc.blog_id = b.blog_id and bc.status_up_del = 'inserted' and bc.usid = uc.usid and (uc.user_type = 'user' or uc.user_type = 'blogger')) as comments,
            (select b.blog_view + COUNT(bv.blog_views_id) from blog_viewstb bv where b.blog_id = bv.blog_id) as totalviews
            from blogs b,users u where b.blog_status='posted' and u.usid=b.usid and b.usid = $usid order by b.blog_id desc";
            // $sql = "SELECT l.*,(SELECT COUNT(*) from lists_content lc WHERE l.list_id = lc.list_id and lc.contant_status= 'public') as totalblog FROM lists l where l.usid = $usid and l.list_status = 'publc'";
        }
    } else {
        $sql = "select b.*,u.*,(select count(*) from blog_likes bl,users ul where bl.blog_id = b.blog_id and bl.status_like_dislike = 'like' and bl.usid = ul.usid and (ul.user_type = 'user' or ul.user_type = 'blogger')) as likes,
        (select count(*) from blog_comments bc, users uc where bc.blog_id = b.blog_id and bc.status_up_del = 'inserted' and bc.usid = uc.usid and (uc.user_type = 'user' or uc.user_type = 'blogger')) as comments,
        (select b.blog_view + COUNT(bv.blog_views_id) from blog_viewstb bv where b.blog_id = bv.blog_id) as totalviews
        from blogs b,users u where b.blog_status='posted' and u.usid=b.usid and b.usid = $usid order by b.blog_id desc";
    }
    $result = mysqli_query($conn, $sql);
    $result3 = mysqli_fetch_all($result, MYSQLI_ASSOC);
    if (isset($_SESSION['buid'])) {
        if ($usid == $_SESSION['buid']) {
            $sql = "SELECT l.*,(SELECT COUNT(*) from lists_content lc,blogs b,users ub WHERE lc.blog_id = b.blog_id and ub.usid = b.usid and ub.user_type = 'blogger' and l.list_id = lc.list_id) as totalblog FROM lists l where l.usid = $usid";
        } else {
            $sql = "SELECT l.*,(SELECT COUNT(*) from lists_content lc,blogs b,users ub WHERE lc.blog_id = b.blog_id and ub.usid = b.usid and ub.user_type = 'blogger' and l.list_id = lc.list_id and lc.contant_status= 'public') as totalblog FROM lists l where l.usid = $usid and l.list_status = 'public'";
        }
    } else {
        $sql = "SELECT l.*,(SELECT COUNT(*) from lists_content lc,blogs b,users ub WHERE lc.blog_id = b.blog_id and ub.usid = b.usid and ub.user_type = 'blogger' and l.list_id = lc.list_id and lc.contant_status= 'public') as totalblog FROM lists l where l.usid = $usid and l.list_status = 'public'";
    }
    // $sql = "SELECT l.*,(SELECT lcid FROM lists_content lc WHERE lc.list_id = l.list_id and lc.blog_id = $blog_id) as lcid FROM lists l where l.usid = $usid";
    $result = mysqli_query($conn, $sql) or die("query failed");
    $result4 = mysqli_fetch_all($result, MYSQLI_ASSOC);
    $usid = 0;
    if (isset($_SESSION['buid'])) {
        $usid = $_SESSION['buid'];
    }
    $sql = "select *from users where usid = '$usid'";
    $result = mysqli_query($conn, $sql);
    $result5 = mysqli_fetch_all($result, MYSQLI_ASSOC);
    echo json_encode(array('message' => 'Profile Data', 'status' => true, 'profiledata' => $result1, 'totallike' => $result2,'totalcomment'=>$result6,'totalblog' => $result7,'blogdata' => $result3, 'readlistdata' => $result4, 'loginudata' => $result5));
}

function signin($data, $conn)
{
    $uname = $data['suname'];
    $password = $data['supassword'];
    // $hashpassword = password_hash($password, PASSWORD_DEFAULT);
    $sql = "select *from users where username = '{$uname}'";
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
    } else {
        echo json_encode(array('message' => $uname . ' is not found.', 'status' => '0'));
    }
    // echo json_encode(array($data));
}
function checkpassword($data, $conn)
{
    $usid = $_SESSION['buid'];
    $password = $data['password'];
    $sql = "select *from users where usid = $usid";
    if (mysqli_num_rows(mysqli_query($conn, $sql)) >= 1) {
        $result = mysqli_query($conn, $sql);
        // echo json_encode(array('message' => 'Enter correct password.', 'status' => '1' , 'result '=>mysqli_fetch_all($result, MYSQLI_ASSOC)));
        while ($rows = mysqli_fetch_assoc($result)) {
            if (password_verify($password, $rows['password'])) {
                echo json_encode(array('message' => 'Password matched.', 'status' => true));
            } else {
                echo json_encode(array('message' => 'Enter correct password.', 'status' => false));
            }
        }
    }
}
function updateprofile($data, $conn)
{
    $type = $data['type'];

    $val = $data['val'];
    $usid = $_SESSION['buid'];
    $sql = '';
    if ($type == 'name') {
        if ($val[0] == "" && $val[1] == "") {
            $sql = "update users set ufname = NULL,ulname= NULL where usid = '$usid'" or die("sql failed");
        } elseif ($val[0] == "") {
            $sql = "update users set ufname = NULL,ulname='$val[1]' where usid = '$usid'" or die("sql failed");
        } elseif ($val[1] == "") {
            $sql = "update users set ufname = '$val[0]',ulname= NULL where usid = '$usid'" or die("sql failed");
        } else {
            $sql = "update users set ufname = '$val[0]',ulname= '$val[1]' where usid = '$usid'" or die("sql failed");
        }
    } elseif ($type == 'email') {
        $sql = "update users set email = '$val' where usid = '$usid'" or die("sql failed");
    } elseif ($type == 'username') {
        $sql = "update users set username = '$val' where usid = '$usid'" or die("sql failed");
    } elseif ($type == 'mbno') {
        $sql = "update users set mbno = '$val' where usid = '$usid'" or die("sql failed");
    } elseif ($type == 'password') {
        $hashpassword = password_hash($val, PASSWORD_DEFAULT);
        $sql = "update users set password = '$hashpassword' where usid = '$usid'" or die("sql failed");
    } elseif ($type == 'photo') {
        $sql = "update users set photo = '$val' where usid = '$usid'" or die("sql failed");
    } elseif ($type == 'username') {
        $sql = "update users set username = '$val' where usid = '$usid'" or die("sql failed");
    } elseif ($type == 'birthdate') {
        $sql = "update users set photo = '$val' where usid = '$usid'" or die("sql failed");
    } elseif ($type == 'gender') {
        if ($val == "") {
            $sql = "update users set gender = NULL where usid = '$usid'" or die("sql failed");
        } else {
            $sql = "update users set gender = '$val' where usid = '$usid'" or die("sql failed");

        }
    } elseif ($type == 'location_js') {
        $sql = "update users set location_js = '$val' where usid = '$usid'" or die("sql failed");
    } elseif ($type == 'user_type') {
        $sql = "update users set user_type = '$val' where usid = '$usid'" or die("sql failed");
    }
    $result = mysqli_query($conn, $sql) or die("query failed");
    if ($result) {
        $sql = "select * from users where usid = '$usid'";
        $result = mysqli_query($conn, $sql);
        $result = mysqli_fetch_assoc($result);
        echo json_encode(array('message' => 'data Updated Successfully.', 'status' => true, 'profiledata' => $result));
    } else {
        echo json_encode(array('message' => 'Error In Updating data.', 'status' => false));
    }


}

function remove_photo($conn)
{
    $usid = $_SESSION['buid'];
    $sql = "update users set photo = NULL where usid = '$usid'" or die("sql failed");

    $result = mysqli_query($conn, $sql) or die("query failed");
    if ($result) {
        echo json_encode(array('message' => 'Profile image updated successfully.', 'status' => true, 'profilepic' => "default.png"));
    } else {
        echo json_encode(array('message' => 'Error In Updating The Profile Pic.', 'status' => false));
    }

}



if ($fkey == "profile_display") {
    profile_display($data, $conn);
} elseif ($fkey == "profile_data") {
    profile_data($conn);
} elseif ($fkey == "checkpassword") {
    checkpassword($data, $conn);
} elseif ($fkey == "sendOTP") {
    sendOTP($data, $conn);
} elseif ($fkey == "checkOTP") {
    checkOTP($data);
} elseif ($fkey == "updateprofile") {
    updateprofile($data, $conn);
} elseif ($fkey == "remove_photo") {
    remove_photo($conn);
} else {
    echo json_encode(array('message' => 'Error in sending Profile Api key', 'status' => false));
}


?>