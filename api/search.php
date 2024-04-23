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

function search($data, $conn)
{
    $search = $data['search'];
    // $search = str_split($search);
    // $array = [`.`,`"`,`'`];
    $string = explode(" ", $search);
    $sql1 = "SELECT DISTINCT t.* FROM (select DISTINCT * from users u where ";
    if (count($string) > 1) {
        for ($i = 0; $i < count($string); $i++) {
            if ($i != count($string) - 1) {
                $sql1 .= "  u.username like '%$string[$i]%' 
                            or u.ufname like '%$string[$i]%' 
                            or u.ulname like '%$string[$i]%' 
                            OR";
            } else {
                $sql1 .= "  u.username like '%$string[$i]%' 
                            or u.ufname like '%$string[$i]%'    
                            or u.ulname like '%$string[$i]%'
                            ";
            }
        }
    } else {
        $sql1 .= "
        u.username like '%$search%' 
        or u.ufname like '%$search%'    
        or u.ulname like '%$search%'
        ";
    }
    $sql1 .= "
    UNION
    select DISTINCT u.* from users u, blogs b, languages l, blog_categorys bc where u.usid = b.usid and b.bcid = bc.bcid and b.lcode = l.lcode 
    and (";
    if (count($string) > 1) {
        for ($i = 0; $i < count($string); $i++) {
            if ($i != count($string) - 1) {
                $sql1 .= "  u.username like '%$string[$i]%' 
                            or u.ufname like '%$string[$i]%' 
                            or u.ulname like '%$string[$i]%' OR b.blog_title LIKE '%$string[$i]%' 
                            OR b.blog_content LIKE '%$string[$i]%' 
                            OR bc.bcname LIKE '%$string[$i]%' 
                            OR l.lname LIKE '%$string[$i]%' 
                            OR";
            } else {
                $sql1 .= "  u.username like '%$string[$i]%' 
                            or u.ufname like '%$string[$i]%'    
                            or u.ulname like '%$string[$i]%'
                            OR b.blog_title LIKE '%$string[$i]%'
                            OR b.blog_content LIKE '%$string[$i]%' 
                            OR bc.bcname LIKE '%$string[$i]%' 
                            OR l.lname LIKE '%$string[$i]%' 
                            ";
            }
        }
    } else {
        $sql1 .= "
        u.username like '%$search%' 
        or u.ufname like '%$search%'    
        or u.ulname like '%$search%'
        OR b.blog_title LIKE '%$search%'
        OR b.blog_content LIKE '%$search%' 
        OR bc.bcname LIKE '%$search%'
        OR l.lname LIKE '%$search%' 
        ";
    }
    $sql1 .= ")) t";
    // $sql1 = "SELECT DISTINCT u.*
    //         FROM users u, blogs b, blog_categorys bc, languages l 
    //         WHERE u.usid = b.usid 
    //             AND bc.bcid = b.bcid 
    //             AND l.lcode = b.lcode 
    //             AND b.blog_status = 'posted' 
    //             AND (u.user_type = 'blogger' or u.user_type = 'user') 
    //             AND (";
    // if (count($string) > 1) {
    //     for ($i = 0; $i < count($string); $i++) {
    //         if ($i != count($string) - 1) {
    //             $sql1 .= "  u.username like '%$string[$i]%' 
    //                         or u.ufname like '%$string[$i]%' 
    //                         or u.ulname like '%$string[$i]%' OR b.blog_title LIKE '%$string[$i]%' 
    //                         OR b.blog_content LIKE '%$string[$i]%' 
    //                         OR bc.bcname LIKE '%$string[$i]%' 
    //                         OR l.lname LIKE '%$string[$i]%' 
    //                         OR";
    //         } else {
    //             $sql1 .= "  u.username like '%$string[$i]%' 
    //                         or u.ufname like '%$string[$i]%'    
    //                         or u.ulname like '%$string[$i]%'
    //                         OR b.blog_title LIKE '%$string[$i]%'
    //                         OR b.blog_content LIKE '%$string[$i]%' 
    //                         OR bc.bcname LIKE '%$string[$i]%' 
    //                         OR l.lname LIKE '%$string[$i]%' 
    //                         ";
    //         }
    //     }
    // } else {
    //     $sql1 .= "
    //     u.username like '%$search%' 
    //     or u.ufname like '%$search%'    
    //     or u.ulname like '%$search%'
    //     OR b.blog_title LIKE '%$search%'
    //     OR b.blog_content LIKE '%$search%' 
    //     OR bc.bcname LIKE '%$search%'
    //     OR l.lname LIKE '%$search%' 
    //     ";
    // }
    // $sql1 .= ")";

    // $sql1 = "SELECT u.*
    //     FROM users u
    //     WHERE
    //             u.username like '%$search%'
    //             or u.ufname like '%$search%'
    //             or u.ulname like '%$search%'
    //     LIMIT 3" or die('sql failed1');

    $sql2 = "select b.*,u.*,(select count(*) from blog_likes bl where bl.blog_id = b.blog_id and bl.status_like_dislike = 'like') as likes,
    (select count(*) from blog_comments bc where bc.blog_id = b.blog_id and bc.status_up_del = 'inserted') as comments,
    (select b.blog_view + COUNT(bv.blog_views_id) from blog_viewstb bv where b.blog_id = bv.blog_id) as totalviews
    from blogs b,users u where u.usid=b.usid and b.blog_id in(
   select b.blog_id from blogs b,users u, languages l, blog_categorys bc where u.usid = b.usid and b.bcid = bc.bcid and b.lcode = l.lcode and (";
    if (count($string) > 1) {
        for ($i = 0; $i < count($string); $i++) {
            if ($i != count($string) - 1) {
                $sql2 .= "  u.username like '%$string[$i]%' 
                        or u.ufname like '%$string[$i]%' 
                        or u.ulname like '%$string[$i]%' OR b.blog_title LIKE '%$string[$i]%' 
                        OR b.blog_content LIKE '%$string[$i]%' 
                        OR bc.bcname LIKE '%$string[$i]%' 
                        OR l.lname LIKE '%$string[$i]%' 
                        OR b.tags LIKE '%$string[$i]%' 
                        OR";
            } else {
                $sql2 .= "  u.username like '%$string[$i]%' 
                        or u.ufname like '%$string[$i]%'    
                        or u.ulname like '%$string[$i]%'
                        OR b.blog_title LIKE '%$string[$i]%'
                        OR b.blog_content LIKE '%$string[$i]%' 
                        OR bc.bcname LIKE '%$string[$i]%' 
                        OR l.lname LIKE '%$string[$i]%' 
                        OR b.tags LIKE '%$string[$i]%' 
                        ";
            }
        }
    } else {
        $sql2 .= "
        u.username like '%$search%' 
        or u.ufname like '%$search%'    
        or u.ulname like '%$search%'
        OR b.blog_title LIKE '%$search%'
        OR b.blog_content LIKE '%$search%' 
        OR bc.bcname LIKE '%$search%'
        OR l.lname LIKE '%$search%'     
        OR b.tags LIKE '%$search%'     
    ";
    }
    $sql2 .= "))";
    // $sql2 = "select b.*,u.*,(select count(*) from blog_likes bl where bl.blog_id = b.blog_id and bl.status_like_dislike = 'like') as likes,
    // (select count(*) from blog_comments bc where bc.blog_id = b.blog_id and bc.status_up_del = 'inserted') as comments
    // from blogs b,users u where u.usid=b.usid and b.blog_id in(
    //     SELECT DISTINCT b.blog_id
    //     FROM users u, blogs b, blog_categorys bc, languages l
    //     WHERE u.usid = b.usid 
    //         AND bc.bcid = b.bcid 
    //         AND l.lcode = b.lcode 
    //         AND b.blog_status = 'posted'
    //         AND u.user_type = 'blogger' 
    //         AND (";
    // if (count($string) > 1) {
    //     for ($i = 0; $i < count($string); $i++) {
    //         if ($i != count($string) - 1) {
    //             $sql2 .= " b.blog_title LIKE '%$string[$i]%' 
    //                                             OR b.blog_content LIKE '%$string[$i]%' 
    //                                             OR bc.bcname LIKE '%$string[$i]%' 
    //                                             OR l.lname LIKE '%$string[$i]%' 
    //                                             or u.username like '%$string[$i]%' 
    //                                             or u.ufname like '%$string[$i]%' 
    //                                             or u.ulname like '%$string[$i]%' OR";
    //         } else {
    //             $sql2 .= " b.blog_title LIKE '%$string[$i]%'
    //                                             OR b.blog_content LIKE '%$string[$i]%' 
    //                                             OR bc.bcname LIKE '%$string[$i]%' 
    //                                             OR l.lname LIKE '%$string[$i]%' 
    //                                             or u.username like '%$string[$i]%' 
    //                                             or u.ufname like '%$string[$i]%'    
    //                                             or u.ulname like '%$string[$i]%'";
    //         }
    //     }
    // } else {
    //     $sql2 .= "b.blog_title LIKE '%$search%'
    //             OR b.blog_content LIKE '%$search%' 
    //             OR bc.bcname LIKE '%$search%'
    //             OR l.lname LIKE '%$search%' 
    //             or u.username like '%$search%' 
    //             or u.ufname like '%$search%'    
    //             or u.ulname like '%$search%'";
    // }
    // $sql2 .= "))";

    $sql3 = "SELECT DISTINCT u.username as 'text' FROM users u WHERE";
    if (count($string) > 1) {
        for ($i = 0; $i < count($string); $i++) {
            if ($i != count($string) - 1) {
                $sql3 .= "  u.username LIKE '%$string[$i]%' OR";
            } else {
                $sql3 .= " u.username LIKE '%$string[$i]%'";
            }
        }
    } else {
        $sql3 .= " u.username LIKE '%$search%'";
    }
    $sql3 .= " UNION SELECT DISTINCT u.ufname FROM users u WHERE";
    if (count($string) > 1) {
        for ($i = 0; $i < count($string); $i++) {
            if ($i != count($string) - 1) {
                $sql3 .= "  u.ufname LIKE '%$string[$i]%' OR";
            } else {
                $sql3 .= " u.ufname LIKE '%$string[$i]%'";
            }
        }
    } else {
        $sql3 .= " u.ufname LIKE '%$search%'";
    }
    $sql3 .= " UNION SELECT DISTINCT u.ulname FROM users u WHERE";
    if (count($string) > 1) {
        for ($i = 0; $i < count($string); $i++) {
            if ($i != count($string) - 1) {
                $sql3 .= "  u.ulname LIKE '%$string[$i]%' OR";
            } else {
                $sql3 .= " u.ulname LIKE '%$string[$i]%'";
            }
        }
    } else {
        $sql3 .= " u.ulname LIKE '%$search%'";
    }
    $sql3 .= " UNION SELECT DISTINCT b.blog_title FROM blogs b WHERE";
    if (count($string) > 1) {
        for ($i = 0; $i < count($string); $i++) {
            if ($i != count($string) - 1) {
                $sql3 .= "  b.blog_title LIKE '%$string[$i]%' OR";
            } else {
                $sql3 .= " b.blog_title LIKE '%$string[$i]%'";
            }
        }
    } else {
        $sql3 .= " b.blog_title LIKE '%$search%'";
    }
    $sql3 .= " UNION SELECT DISTINCT bc.bcname FROM blog_categorys bc WHERE";
    if (count($string) > 1) {
        for ($i = 0; $i < count($string); $i++) {
            if ($i != count($string) - 1) {
                $sql3 .= "  bc.bcname LIKE '%$string[$i]%' OR";
            } else {
                $sql3 .= " bc.bcname LIKE '%$string[$i]%'";
            }
        }
    } else {
        $sql3 .= " bc.bcname LIKE '%$search%'";
    }
    $sql3 .= " UNION SELECT DISTINCT l.lname FROM languages l WHERE";
    if (count($string) > 1) {
        for ($i = 0; $i < count($string); $i++) {
            if ($i != count($string) - 1) {
                $sql3 .= "  l.lname LIKE '%$string[$i]%' OR";
            } else {
                $sql3 .= " l.lname LIKE '%$string[$i]%'";
            }
        }
    } else {
        $sql3 .= " l.lname LIKE '%$search%'";
    }
    $start = microtime(true);

    $result1 = mysqli_query($conn, $sql1) or die("query failed");
    $resultnew1 = mysqli_fetch_all($result1, MYSQLI_ASSOC);

    $result2 = mysqli_query($conn, $sql2) or die("query failed");
    $resultnew2 = mysqli_fetch_all($result2, MYSQLI_ASSOC);

    $result3 = mysqli_query($conn, $sql3) or die("query failed");
    $resultnew3 = mysqli_fetch_all($result3, MYSQLI_ASSOC);
    // Stop the timer
    $end = microtime(true);

    // Calculate the execution time
    $executionTime = $end - $start;
    
    $executionTime = number_format($executionTime, 3);

    // echo json_encode(array('message' => 'Displaying Searched Data', 'status' => true, 'data'=>$resultnew3));
    if ($result1 && $result2) {
        $usid = 0;
        if(isset($_SESSION['buid'])){
            $usid = $_SESSION['buid'];
        }
        $sql = "select *from users where usid = '$usid'";
        $result4 = mysqli_query($conn, $sql);
        $result4 = mysqli_fetch_all($result4, MYSQLI_ASSOC);
        echo json_encode(array('message' => 'Displaying Searched Data', 'status' => true, 'text' => $resultnew3, 'users' => $resultnew1, 'blogs' => $resultnew2, 'luserdata' => $result4,'executionTime'=>$executionTime));
    } else {
        echo json_encode(array('message' => 'Error in Displaying Searched Data', 'status' => false));
    }

}


if ($fkey == "search") {
    search($data, $conn);
} else {
    echo json_encode(array('message' => 'Error in sending Search Api key', 'status' => false));
}


?>