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

// function dba($conn)
// {
//     //top  likes
//     $sql = "select b.*,u.*,(select count(*) from blog_likes bl,users ul where bl.blog_id = b.blog_id and bl.status_like_dislike = 'like' and bl.usid = ul.usid and (ul.user_type = 'user' or ul.user_type = 'blogger')) as likes,
//     (select count(*) from blog_comments bc, users uc where bc.blog_id = b.blog_id and bc.status_up_del = 'inserted' and bc.usid = uc.usid and (uc.user_type = 'user' or uc.user_type = 'blogger')) as comments,
//     (select b.blog_view + COUNT(bv.blog_views_id) from blog_viewstb bv where b.blog_id = bv.blog_id) as totalviews
//     from blogs b,users u where u.usid=b.usid and b.blog_status = 'posted' and u.user_type = 'blogger' ORDER by likes DESC";

//     $result = mysqli_query($conn,$sql) or die("query failed");

//     $result1 = mysqli_query()


//     // cooment 
//     $sql = "select b.*,u.*,(select count(*) from blog_likes bl,users ul where bl.blog_id = b.blog_id and bl.status_like_dislike = 'like' and bl.usid = ul.usid and (ul.user_type = 'user' or ul.user_type = 'blogger')) as likes,
//     (select count(*) from blog_comments bc, users uc where bc.blog_id = b.blog_id and bc.status_up_del = 'inserted' and bc.usid = uc.usid and (uc.user_type = 'user' or uc.user_type = 'blogger')) as comments,
//     (select b.blog_view + COUNT(bv.blog_views_id) from blog_viewstb bv where b.blog_id = bv.blog_id) as totalviews
//     from blogs b,users u where u.usid=b.usid and b.blog_status = 'posted' and u.user_type = 'blogger' ORDER by comments DESC";

//     //view
//     $sql = "select b.*,u.*,(select count(*) from blog_likes bl,users ul where bl.blog_id = b.blog_id and bl.status_like_dislike = 'like' and bl.usid = ul.usid and (ul.user_type = 'user' or ul.user_type = 'blogger')) as likes,
//     (select count(*) from blog_comments bc, users uc where bc.blog_id = b.blog_id and bc.status_up_del = 'inserted' and bc.usid = uc.usid and (uc.user_type = 'user' or uc.user_type = 'blogger')) as comments,
//     (select b.blog_view + COUNT(bv.blog_views_id) from blog_viewstb bv where b.blog_id = bv.blog_id) as totalviews
//     from blogs b,users u where u.usid=b.usid and b.blog_status = 'posted' and u.user_type = 'blogger' ORDER by totalviews DESC";

//     //reported
//     $sql = "select DISTINCT b.*,u.*,l.lname,c.bcname,(select count(*) from blog_likes bl where bl.blog_id = b.blog_id and bl.status_like_dislike = 'like') as likes,
//     (select count(*) from blog_comments bc where bc.blog_id = b.blog_id and bc.status_up_del = 'inserted') as comments,
//     (select count(*) from reports rt where rt.report_type_id = b.blog_id and rt.report_type = 'blog') as totalreports
//     from blogs b,users u,languages l,blog_categorys c, reports r where b.blog_status = 'posted'and b.blog_id = r.report_type_id and r.report_type = 'blog' and c.bcid = b.bcid and l.lcode=b.lcode and u.usid=b.usid";



//     //---------------------------------------------------------------------------------------------------------------------------------------------

//     // active blogs total
//     $totalactiveblogs = "select COUNT(*) as totaldraftblogs from blogs b, users u WHERE u.usid = b.usid and b.blog_status = 'posted" or die("sql failed");

//     // total account 
//     $totalaccounts = "select count(*) as totalaccounts from users u where u.user_type in ('blogger','user')";

//     // total blogger account
//     $totalbloggeraccounts = "select count(*) as totalbloggeraccounts from users u where u.user_type in ('blogger')";

//     // totol user account
//     $totaluseraccounts = "select count(*) as totaluseraccounts from users u where u.user_type in ('user')";

//     // total category
//     $sql = "SELECT count(*) from blog_categorys";

//     // total language
//     $sql = "SELECT count(*) from languages";

//     // differnce graph data
//     $sql = "SELECT DAYNAME(blog_post_time) AS day,
//             SUM(CASE WHEN blog_post_time >= CURDATE() - INTERVAL 7 DAY THEN 1 ELSE 0 END) AS this_week_data,
//             SUM(CASE WHEN blog_post_time >= CURDATE() - INTERVAL 14 DAY
//                     AND blog_post_time < CURDATE() - INTERVAL 7 DAY THEN 1 ELSE 0 END) AS last_week_data
//             FROM blogs
//             GROUP BY DAYOFWEEK(blog_post_time)
//             ORDER BY DAYOFWEEK(blog_post_time)";

//     // today posted blogs
//     $sql = "SELECT COUNT(*) AS total_posted_blogs
//     FROM blogs
//     WHERE DATE(blog_post_time) = CURDATE()";

//     // TOP BLOGGER
//     $sql = "SELECT u.*,ROUND(SUM(b.blog_view) / COUNT(b.blog_id)) + ROUND((SELECT COUNT(bv.blog_views_id)FROM blog_viewstb bv
//     WHERE b.blog_id = bv.blog_id) / COUNT(b.blog_id)) AS newavgviews,(SELECT COUNT(*) FROM blog_likes bl WHERE bl.blog_id IN (SELECT b2.blog_id FROM blogs b2 WHERE b2.usid = u.usid) AND bl.status_like_dislike = 'like') AS totallikes,(SELECT COUNT(*) FROM blogs b WHERE u.usid = b.usid) AS totalblogs,(SELECT COUNT(*) FROM blogs b WHERE b.blog_status = 'posted' AND u.usid = b.usid) AS active
//     FROM users u,blogs b WHERE u.usid = b.usid and b.blog_status = 'posted' and u.user_type = 'blogger' GROUP BY u.username";

//     //TOP CATEGORY 
//     $sql = "select bc.bcname, count(*) as 'total' from blogs b, blog_categorys bc where bc.bcid = b.bcid GROUP by bc.bcname order by total desc limit 5";

//     // top language 
//     $sql = "select l.lname, count(*) as 'total' from blogs b, languages l where l.lcode = b.lcode GROUP by l.lname order by total desc limit 5";


//     // $sqlcounttotalblogs = "select COUNT(*) as totalblogs from blogs b, users u WHERE u.usid = b.usid";

//     // $sqldraftblogs = "select COUNT(*) as totalactiveblogs from blogs b, users u WHERE u.usid = b.usid and b.blog_status = 'drafted'" or die("sql failed");


//     // $sqlcounttotallikes = "select count(*) as totallikes from blog_likes l where l.status_like_dislike = 'like' and blog_id in (select blog_id from blogs)" or die("sql failed");


//     // $sqlcounttotalcomment = "select count(*) from blog_comments bc where bc.status_up_del = 'inserted' and blog_id in (select blog_id from blogs)" or die("sql failed");



//     //-------------------------------------------------------------------------

//     $resultmostview = mysqli_query($conn,$sqlmostview) or die("query failed1");

//     $resultmostlike = mysqli_query($conn,$sqlmostlike) or die("query failed2");

//     $resultmostcomment = mysqli_query($conn,$sqlmostcomment) or die("query failed3");







//     //-------------------------------------------------------------------------------------------------------------------

//     $resultmostview1 = mysqli_fetch_all($resultmostview, MYSQLI_ASSOC) or die("query failed4");

//     $resultmostlike1 = mysqli_fetch_all($resultmostlike, MYSQLI_ASSOC) or die("query failed5");

//     $resultmostcomment1 = mysqli_fetch_all($resultmostcomment, MYSQLI_ASSOC) or die("query failed6");




//     echo json_encode(array('message'=>'Displaying Master Dashboard Data','status'=>true,'mostview'=> $resultmostview1,'mostlike'=> $resultmostlike1,'mostcomment'=> $resultmostcomment1));


// }

function dba($conn)
{
    //top  likes
    $sql = "select b.*,u.*,(select count(*) from blog_likes bl,users ul where bl.blog_id = b.blog_id and bl.status_like_dislike = 'like' and bl.usid = ul.usid and (ul.user_type = 'user' or ul.user_type = 'blogger')) as likes,
    (select count(*) from blog_comments bc, users uc where bc.blog_id = b.blog_id and bc.status_up_del = 'inserted' and bc.usid = uc.usid and (uc.user_type = 'user' or uc.user_type = 'blogger')) as comments,
    (select b.blog_view + COUNT(bv.blog_views_id) from blog_viewstb bv where b.blog_id = bv.blog_id) as totalviews
    from blogs b,users u where u.usid=b.usid and b.blog_status = 'posted' and u.user_type = 'blogger' ORDER by likes DESC";

    $result = mysqli_query($conn, $sql) or die("query failed");

    $result1 = mysqli_fetch_all($result, MYSQLI_ASSOC) or die("query failed");


    // comment 
    $sql = "select b.*,u.*,(select count(*) from blog_likes bl,users ul where bl.blog_id = b.blog_id and bl.status_like_dislike = 'like' and bl.usid = ul.usid and (ul.user_type = 'user' or ul.user_type = 'blogger')) as likes,
    (select count(*) from blog_comments bc, users uc where bc.blog_id = b.blog_id and bc.status_up_del = 'inserted' and bc.usid = uc.usid and (uc.user_type = 'user' or uc.user_type = 'blogger')) as comments,
    (select b.blog_view + COUNT(bv.blog_views_id) from blog_viewstb bv where b.blog_id = bv.blog_id) as totalviews
    from blogs b,users u where u.usid=b.usid and b.blog_status = 'posted' and u.user_type = 'blogger' ORDER by comments DESC";

    $result = mysqli_query($conn, $sql) or die("query failed");

    $result2 = mysqli_fetch_all($result, MYSQLI_ASSOC) or die("query failed");

    //view
    $sql = "select b.*,u.*,(select count(*) from blog_likes bl,users ul where bl.blog_id = b.blog_id and bl.status_like_dislike = 'like' and bl.usid = ul.usid and (ul.user_type = 'user' or ul.user_type = 'blogger')) as likes,
    (select count(*) from blog_comments bc, users uc where bc.blog_id = b.blog_id and bc.status_up_del = 'inserted' and bc.usid = uc.usid and (uc.user_type = 'user' or uc.user_type = 'blogger')) as comments,
    (select b.blog_view + COUNT(bv.blog_views_id) from blog_viewstb bv where b.blog_id = bv.blog_id) as totalviews
    from blogs b,users u where u.usid=b.usid and b.blog_status = 'posted' and u.user_type = 'blogger' ORDER by totalviews DESC";

    $result = mysqli_query($conn, $sql) or die("query failed");

    $result3 = mysqli_fetch_all($result, MYSQLI_ASSOC) or die("query failed");

    //reported
    $sql = "select DISTINCT b.*,u.*,l.lname,c.bcname,(select count(*) from blog_likes bl where bl.blog_id = b.blog_id and bl.status_like_dislike = 'like') as likes,
    (select count(*) from blog_comments bc where bc.blog_id = b.blog_id and bc.status_up_del = 'inserted') as comments,
    (select count(*) from reports rt where rt.report_type_id = b.blog_id and rt.report_type = 'blog') as totalreports
    from blogs b,users u,languages l,blog_categorys c, reports r where b.blog_status = 'posted'and b.blog_id = r.report_type_id and r.report_type = 'blog' and c.bcid = b.bcid and l.lcode=b.lcode and u.usid=b.usid";

    $result = mysqli_query($conn, $sql) or die("query failed");

    $result4 = mysqli_fetch_all($result, MYSQLI_ASSOC) or die("query failed");



    //---------------------------------------------------------------------------------------------------------------------------------------------

    // active blogs total
    $sql = "select COUNT(*) as totalavtiveblogs from blogs b, users u WHERE u.usid = b.usid and b.blog_status = 'posted'" or die("sql failed");

    $result = mysqli_query($conn, $sql) or die("query failed");

    $result5 = mysqli_fetch_all($result, MYSQLI_ASSOC) or die("query failed");

    // total account 
    $sql = "select count(*) as totalaccounts from users u where u.user_type in ('blogger','user')";

    $result = mysqli_query($conn, $sql) or die("query failed");

    $result6 = mysqli_fetch_all($result, MYSQLI_ASSOC) or die("query failed");

    // total blogger account
    $sql = "select count(*) as totalbloggeraccounts from users u where u.user_type in ('blogger')";

    $result = mysqli_query($conn, $sql) or die("query failed");

    $result7 = mysqli_fetch_all($result, MYSQLI_ASSOC) or die("query failed");

    // total user account
    $sql = "select count(*) as totaluseraccounts from users u where u.user_type in ('user')";

    $result = mysqli_query($conn, $sql) or die("query failed");

    $result8 = mysqli_fetch_all($result, MYSQLI_ASSOC) or die("query failed");

    // total category
    $sql = "SELECT count(*) as totalcategorys from blog_categorys";

    $result = mysqli_query($conn, $sql) or die("query failed");

    $result9 = mysqli_fetch_all($result, MYSQLI_ASSOC) or die("query failed");

    // total language
    $sql = "SELECT count(*) totallanguages from languages";

    $result = mysqli_query($conn, $sql) or die("query failed");

    $result10 = mysqli_fetch_all($result, MYSQLI_ASSOC) or die("query failed");

    // differnce graph data
    $sql = "SELECT weekdays.day_of_week, IFNULL(view_counts.total_blogs, 0) AS total_blogs
    FROM
    (
        SELECT 'Monday Morning' AS day_of_week
        UNION SELECT 'Monday Evening'
        UNION SELECT 'Tuesday Morning'
        UNION SELECT 'Tuesday Evening'
        UNION SELECT 'Wednesday Morning'
        UNION SELECT 'Wednesday Evening'
        UNION SELECT 'Thursday Morning'
        UNION SELECT 'Thursday Evening'
        UNION SELECT 'Friday Morning'
        UNION SELECT 'Friday Evening'
        UNION SELECT 'Saturday Morning'
        UNION SELECT 'Saturday Evening'
        UNION SELECT 'Sunday Morning'
        UNION SELECT 'Sunday Evening'
    ) AS weekdays
    LEFT JOIN
    (
        SELECT CONCAT(DAYNAME(b.blog_post_time), IF(HOUR(b.blog_post_time) < 12, ' Morning', ' Evening')) AS day_of_week, COUNT(*) AS total_blogs
        FROM blogs b
        WHERE YEARWEEK(b.blog_post_time, 1) = YEARWEEK(CURDATE(), 1) AND b.blog_status = 'posted'
        GROUP BY day_of_week
    ) AS view_counts ON weekdays.day_of_week = view_counts.day_of_week
    ORDER BY FIELD(weekdays.day_of_week, 
        'Monday Morning', 'Monday Evening', 
        'Tuesday Morning', 'Tuesday Evening',
        'Wednesday Morning', 'Wednesday Evening',
        'Thursday Morning', 'Thursday Evening',
        'Friday Morning', 'Friday Evening',
        'Saturday Morning', 'Saturday Evening',
        'Sunday Morning', 'Sunday Evening')
    ";

    $result = mysqli_query($conn, $sql) or die("query failed");

    $result11a = mysqli_fetch_all($result, MYSQLI_ASSOC) or die("query failed");
    $sql = "SELECT weekdays.day_of_week, IFNULL(view_counts.total_blogs, 0) AS total_blogs
    FROM
    (
        SELECT 'Monday Morning' AS day_of_week
        UNION SELECT 'Monday Evening'
        UNION SELECT 'Tuesday Morning'
        UNION SELECT 'Tuesday Evening'
        UNION SELECT 'Wednesday Morning'
        UNION SELECT 'Wednesday Evening'
        UNION SELECT 'Thursday Morning'
        UNION SELECT 'Thursday Evening'
        UNION SELECT 'Friday Morning'
        UNION SELECT 'Friday Evening'
        UNION SELECT 'Saturday Morning'
        UNION SELECT 'Saturday Evening'
        UNION SELECT 'Sunday Morning'
        UNION SELECT 'Sunday Evening'
    ) AS weekdays
    LEFT JOIN
    (
        SELECT CONCAT(DAYNAME(b.blog_post_time), IF(HOUR(b.blog_post_time) < 12, ' Morning', ' Evening')) AS day_of_week, COUNT(*) AS total_blogs
        FROM blogs b
        WHERE  YEARWEEK(b.blog_post_time, 1) = YEARWEEK(CURDATE() - INTERVAL 1 WEEK, 1)  AND b.blog_status = 'posted'
        GROUP BY day_of_week
    ) AS view_counts ON weekdays.day_of_week = view_counts.day_of_week
    ORDER BY FIELD(weekdays.day_of_week, 
        'Monday Morning', 'Monday Evening', 
        'Tuesday Morning', 'Tuesday Evening',
        'Wednesday Morning', 'Wednesday Evening',
        'Thursday Morning', 'Thursday Evening',
        'Friday Morning', 'Friday Evening',
        'Saturday Morning', 'Saturday Evening',
        'Sunday Morning', 'Sunday Evening')";

    $result = mysqli_query($conn, $sql) or die("query failed");

    $result11B = mysqli_fetch_all($result, MYSQLI_ASSOC) or die("query failed");

    // today posted blogs
    $sql = "SELECT COUNT(*) AS total_posted_blogs
    FROM blogs
    WHERE DATE(blog_post_time) = CURDATE()";

    $result = mysqli_query($conn, $sql) or die("query failed");

    $result12 = mysqli_fetch_all($result, MYSQLI_ASSOC) or die("query failed");

    // TOP BLOGGER
    $sql = "SELECT u.*,ROUND(SUM(b.blog_view) / COUNT(b.blog_id)) + ROUND((SELECT COUNT(bv.blog_views_id)FROM blog_viewstb bv
    WHERE b.blog_id = bv.blog_id) / COUNT(b.blog_id)) AS newavgviews,(SELECT COUNT(*) FROM blog_likes bl WHERE bl.blog_id IN (SELECT b2.blog_id FROM blogs b2 WHERE b2.usid = u.usid) AND bl.status_like_dislike = 'like') AS totallikes,(SELECT COUNT(*) FROM blogs b WHERE u.usid = b.usid) AS totalblogs,(SELECT COUNT(*) FROM blogs b WHERE b.blog_status = 'posted' AND u.usid = b.usid) AS active
    FROM users u,blogs b WHERE u.usid = b.usid and b.blog_status = 'posted' and u.user_type = 'blogger' GROUP BY u.username";

    $result = mysqli_query($conn, $sql) or die("query failed");

    $result13 = mysqli_fetch_all($result, MYSQLI_ASSOC) or die("query failed");

    //TOP CATEGORY 
    $sql = "select bc.bcname, count(*) as 'total' from blogs b, blog_categorys bc where bc.bcid = b.bcid GROUP by bc.bcname order by total desc limit 5";

    $result = mysqli_query($conn, $sql) or die("query failed");

    $result14 = mysqli_fetch_all($result, MYSQLI_ASSOC) or die("query failed");

    // top language 
    $sql = "select l.lname, count(*) as 'total' from blogs b, languages l where l.lcode = b.lcode GROUP by l.lname order by total desc limit 5";

    $result = mysqli_query($conn, $sql) or die("query failed");

    $result15 = mysqli_fetch_all($result, MYSQLI_ASSOC) or die("query failed");

    $sql = "SELECT genders.gender, IFNULL(gender_counts.gendercount1, 0) AS gendercount
    FROM
    (
        SELECT 'male' AS gender
        UNION SELECT 'female'
        UNION SELECT 'other'
         UNION SELECT 'NULL'
    ) AS genders
    LEFT JOIN
    (
        SELECT u.gender, COUNT(*) AS gendercount1
        FROM users u
        WHERE u.user_type IN ('blogger', 'user')
        GROUP BY u.gender
    ) AS gender_counts ON genders.gender = gender_counts.gender";

    $result = mysqli_query($conn, $sql) or die("query failed");

    $result16 = mysqli_fetch_all($result, MYSQLI_ASSOC) or die("query failed");

    // $sqlcounttotalblogs = "select COUNT(*) as totalblogs from blogs b, users u WHERE u.usid = b.usid";

    // $sqldraftblogs = "select COUNT(*) as totalactiveblogs from blogs b, users u WHERE u.usid = b.usid and b.blog_status = 'drafted'" or die("sql failed");


    // $sqlcounttotallikes = "select count(*) as totallikes from blog_likes l where l.status_like_dislike = 'like' and blog_id in (select blog_id from blogs)" or die("sql failed");


    // $sqlcounttotalcomment = "select count(*) from blog_comments bc where bc.status_up_del = 'inserted' and blog_id in (select blog_id from blogs)" or die("sql failed");

    $sql = 'select b.blog_status,count(*) as newtotal from blogs b group by b.blog_status';

    $result = $result = mysqli_query($conn, $sql) or die("query failed");

    $r1 = mysqli_fetch_all($result, MYSQLI_ASSOC) or die("query failed");



    echo json_encode(array('message' => 'Displaying Master Dashboard Data', 'status' => true, 'toplikes' => $result1, 'comment' => $result2, 'view' => $result3, 'reported' => $result4, 'activeblogs' => $result5, 'totalaccounts' => $result6, 'totalblogger' => $result7, 'totaluser' => $result8, 'totalcategory' => $result9, 'totallanguage' => $result10, 'differncegrapcurentdata' => $result11a, 'differncegrapprevdata' => $result11B, 'todaypostedblogs' => $result12, 'topblogger' => $result13, 'topcategory' => $result14, 'toplanguage' => $result15,'gender'=>$result16,'r1'=>$r1));


}
if ($fkey == "dba") {
    dba($conn);
} else {
    echo json_encode(array('message' => 'Error in sending master admin dashboard Api key', 'status' => false));
}

?>