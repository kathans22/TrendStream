<?php

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Methods: DELETE');
header('Access-Control-Allow-Methods: PUT');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');


include "./config.php";


$data = json_decode(file_get_contents("php://input"),true);


$fkey = $data['key'];

session_start();
// include "config.php";

function recommendation($data,$conn)
{
    //ama seo add karvanu baaki chhe thai etle add kari deje
    $value = $data['value'];
    $type = $data['type'];
    $sql="";
    if($type == "all"){
        $sql = "select b.*,u.*,l.lname,c.bcname,(select count(*) from blog_likes bl where bl.blog_id = b.blog_id and bl.status_like_dislike = 'like') as likes,
        (select count(*) from blog_comments bc where bc.blog_id = b.blog_id and bc.status_up_del = 'inserted') as comments,
        (select b.blog_view + COUNT(bv.blog_views_id) from blog_viewstb bv where b.blog_id = bv.blog_id) as totalviews
        from blogs b,users u,languages l,blog_categorys c where c.bcid = b.bcid and l.lcode=b.lcode and u.usid=b.usid order by blog_view desc";
    }
    else if($type == "user"){
        $sql = "select b.*,u.*,l.lname,c.bcname,(select count(*) from blog_likes bl where bl.blog_id = b.blog_id and bl.status_like_dislike = 'like') as likes,
        (select count(*) from blog_comments bc where bc.blog_id = b.blog_id and bc.status_up_del = 'inserted') as comments,
        (select b.blog_view + COUNT(bv.blog_views_id) from blog_viewstb bv where b.blog_id = bv.blog_id) as totalviews
        from blogs b,users u,languages l,blog_categorys c where c.bcid = b.bcid and l.lcode=b.lcode and u.usid=b.usid and u.usid = $value order by blog_view desc";
    }
    else if($type == "language"){
        $sql = "select b.*,u.*,l.lname,c.bcname,(select count(*) from blog_likes bl where bl.blog_id = b.blog_id and bl.status_like_dislike = 'like') as likes,
        (select count(*) from blog_comments bc where bc.blog_id = b.blog_id and bc.status_up_del = 'inserted') as comments,
        (select b.blog_view + COUNT(bv.blog_views_id) from blog_viewstb bv where b.blog_id = bv.blog_id) as totalviews
        from blogs b,users u,languages l,blog_categorys c where c.bcid = b.bcid and l.lcode=b.lcode and u.usid=b.usid and l.lcode='$value' order by blog_view desc";
    }
    else if($type == "category"){
        $sql = "select b.*,u.*,l.lname,c.bcname,(select count(*) from blog_likes bl where bl.blog_id = b.blog_id and bl.status_like_dislike = 'like') as likes,
        (select count(*) from blog_comments bc where bc.blog_id = b.blog_id and bc.status_up_del = 'inserted') as comments,
        (select b.blog_view + COUNT(bv.blog_views_id) from blog_viewstb bv where b.blog_id = bv.blog_id) as totalviews
        from blogs b,users u,languages l,blog_categorys c where c.bcid = b.bcid and l.lcode=b.lcode and u.usid=b.usid and c.bcid = $value order by blog_view desc";
    }
    else if($type == "seo"){
        $sql = "select b.*,u.*,l.lname,c.bcname,(select count(*) from blog_likes bl where bl.blog_id = b.blog_id and bl.status_like_dislike = 'like') as likes,
        (select count(*) from blog_comments bc where bc.blog_id = b.blog_id and bc.status_up_del = 'inserted') as comments,
        (select b.blog_view + COUNT(bv.blog_views_id) from blog_viewstb bv where b.blog_id = bv.blog_id) as totalviews
        from blogs b,users u,languages l,blog_categorys c where c.bcid = b.bcid and l.lcode=b.lcode and u.usid=b.usid and b.tags  like '%$value%' order by blog_view desc";
    }
    // $sql = "select b.*,u.username,(select count(*) from blog_likes bl where bl.blog_id = b.blog_id and bl.status_like_dislike = 'like') as 'likes',(select count(*) from blog_comments bc where bc.blog_id = b.blog_id and bc.status_up_del = 'inserted') as 'comments' from blogs b,users u, blog_categorys bcy where u.usid = b.usid and b.bcid = bcy.bcid and (u.username like '%$rkey%' or bcy.bcname  or l.lname like '%$rkey%')" or die("sql failed");
    $result = mysqli_query($conn,$sql) or die("query failed");
    
    $result1 =  mysqli_fetch_all($result,MYSQLI_ASSOC);
    
    if($result)
    {
        echo json_encode(array('message'=>'Displaying Recommendation','status'=>true,'blogsdata'=> $result1));
    }
    else
    {
        echo json_encode(array('message'=>'Error In Displaying Recommendation Details Or Else No Record Found','status'=>false));   
    }
}



if($fkey == "recommendation")
{
    recommendation($data,$conn);
}
else
{
    echo json_encode(array('message' => 'Error in sending recommendation Api key' , 'status' => false));
}

?>