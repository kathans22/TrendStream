setlogindata = () => {
  $.ajax({
    url: "./api/login.php",
    type: "POST",
    data: JSON.stringify({ fkey: 'checklogin' }),
    dataType: "JSON",
    async: false,
    success: (data) => {
      console.log(data);
      // console.log(data.userdata[0].email);
      if (data.status) {
        $("#useremail").html(data.userdata[0].email);
        // $("#useruname").html(data.userdata[0].username);
      }
      loginuserdata = data.userdata;
      $("#useruname").html(data.userdata[0].username);
      loginuserid = data.userdata[0].usid;
    },
    error: (error) => servererror(error)
  });
}
currentUrl = window.location.href;
currentUrl = currentUrl.split(/[\/?]/);
sidebar = () => {
  content = `
    <ul class="nav">`
    if (loginuserdata[0].usid != 0) {
      content+=`
        <li class="nav-item show-profile" data-id= "`+loginuserdata[0].usid+`">
          <a class="nav-link">
            <i class="mdi mdi-account menu-icon"></i>
            <span class="menu-title">My profile</span>
          </a>
        </li>`
    }
  content += `
      <li class="nav-item nav-category">BLOGS</li>
      <li class="nav-item">
        <a class="nav-link" data-bs-toggle="collapse" href="#ui-basic" aria-expanded="false"
          aria-controls="ui-basic">
          <i class="menu-icon mdi mdi-new-box"></i>
          <span class="menu-title">Blogs</span>
          <i class="menu-arrow"></i>
        </a>
        <div class="collapse" id="ui-basic">
          <ul class="nav flex-column sub-menu">
            <li class="nav-item"> <a class="nav-link" href="./pages/blogs/home.html">Home</a></li>
            <li class="nav-item"> <a class="nav-link" href="./pages/blogs/tranding.html">Trending</a></li>`
  if (loginuserdata[0].user_type == "blogger") {
    content += `<li class="nav-item checkloginuser"> <a class="nav-link" href="./pages/blogs/myblogs.html">My blogs</a></li>`
  }
  content += `</ul>
        </div>
      </li>
      <li class="nav-item" id="createblog">
        <a class="nav-link checkloginuser" href="./pages/create/create.html">
          <i class="menu-icon mdi mdi-plus-circle-outline"></i>
          <span class="menu-title">Create</span>
        </a>
      </li>
      <li class="nav-item nav-category">OTHERS</li>
      <li class="nav-item">
        <a class="nav-link" href="./pages/search/search.html">
          <i class="menu-icon icon-search"></i>
          <span class="menu-title">Search </span>
        </a>
      </li>
    <!--  <li class="nav-item">
        <a class="nav-link" href="pages/messages/chat.html">
          <i class="menu-icon mdi mdi-message-text"></i>
          <span class="menu-title">Messages</span>
        </a>
      </li> -->
      <li class="nav-item">
        <a class="nav-link checkloginuser" href="./pages/history/history.html">
          <i class="menu-icon mdi mdi-history"></i>
          <span class="menu-title">History</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link checkloginuser" href="./pages/readlater/readlater.html">
          <i class="menu-icon mdi mdi-clock"></i>
          <span class="menu-title">Read later</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link checkloginuser" href="./pages/readlist/readlist.html">
          <i class="menu-icon mdi mdi-format-list-bulleted"></i>
          <span class="menu-title">Read list</span>
        </a>
      </li>
    <!-- <li class="nav-item">
        <a class="nav-link" data-bs-toggle="collapse" href="#form-elements" aria-expanded="false"
          aria-controls="form-elements">
          <i class="menu-icon mdi mdi-comment-account-outline"></i>
          <span class="menu-title">Comments</span>
          <i class="menu-arrow"></i>
        </a>
        <div class="collapse" id="form-elements">
          <ul class="nav flex-column sub-menu">
            <li class="nav-item"><a class="nav-link" href="#">My comment</a></li>
            <li class="nav-item"><a class="nav-link" href="#">Users comment</a></li>
          </ul>
        </div>
      </li> -->
      <li class="nav-item nav-category">HELP AND SUPPORT</li>
  <!--    <li class="nav-item">
        <a class="nav-link" href="pages/report/reporthistory.html">
          <i class="menu-icon mdi mdi-flag-outline"></i>
          <span class="menu-title">Report history</span>
        </a>
      </li> -->
      <li class="nav-item">
        <a class="nav-link" href="./pages/help/help.html">
          <i class="menu-icon mdi mdi-help-circle-outline"></i>
          <span class="menu-title">Help</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="./pages/sendfeedback/feedback.html">
          <i class="menu-icon mdi mdi-file-document"></i>
          <span class="menu-title">Send feedback</span>
        </a>
      </li>
    </ul>
    `;
  $("#sidebar").append(content)
};
$(document).on("click", ".checkloginuser", function (e) {
  if (loginuserid == 0) {
    e.preventDefault();
    btn = `
                      <div class="d-flex align-items-center">
                          <div class="ms-auto">
                              <button type="button" class="btn btn-danger btn-sm gotologin">
                                  Login
                              </button>
                          </div>
                      </div>`
    showInfoToast("Open Page..!", 'Login to blogsee account is required to open that page.!<br>' + btn)
  }
})

navbar = () => {
  // currentUrl = window.location.href;
  // currentUrl = currentUrl.split("/")
  // navbar_data
  $.ajax({
    url: "./api/navbar.php",
    type: "POST",
    data: JSON.stringify({ fkey: 'navbar_data' }),
    dataType: "JSON",
    async: false,
    success: (data) => {
      console.log(data);
      if (data.status) {
        console.log(loginuserdata);
        content = `
        <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-start">
        <div class="me-3">
          <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-bs-toggle="minimize">
            <span class="icon-menu"></span>
          </button>
        </div>
        <div style = "display : flex;">
          <a class="navbar-brand brand-logo" href="index.html">
          <img src="./images/logo.png" alt="logo" style = "height : 22px;"/>
            <!-- <img src="images/logo.svg" alt="logo" /> -->
           <!-- <h3>blogger</h3> -->
          </a>
          <a class="navbar-brand brand-logo-mini" href="index.html">
            <img src="./images/logo2.png" alt="logo" />
          </a>
        </div>
      </div>
      <div class="navbar-menu-wrapper d-flex align-items-top">
        <ul class="navbar-nav">
          <li class="nav-item font-weight-semibold d-none d-lg-block ms-0">
            <h1 class="welcome-text">Good Morning, <span class="text-black
                  fw-bold">blogger name</span></h1>
          </li>
        </ul>
        <ul class="navbar-nav ms-auto">
        `
        // if (currentUrl.indexOf("index.html") != -1) {
        content += `
            <!-- select category -->
            <li class="nav-item dropdown d-none d-lg-block">
              <a class="nav-link dropdown-bordered dropdown-toggle
                  dropdown-toggle-split" id="languagedropdown" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                Select Language
              </a>
              <div class="dropdown-menu dropdown-menu-right navbar-dropdown
                  preview-list pb-0" aria-labelledby="countDropdown"
                  style="max-height: 400px; overflow: hidden; overflow-y: auto;">
                <a class="dropdown-item" >
                                        <h6 class="dropdown-header">Select Language</h6> 
                                        <a class="dropdown-item select-language" data-value="null">All languuages</a>`
        for (i = 0; i < data.languages.length; i++) {
          content += ` 
                                          <a class="dropdown-item select-language" data-value="`+ data.languages[i].lcode + `">` + data.languages[i].lname + `</a>`
        }
        content += `
         
                                      </div>
            </li>
            <!-- select category -->
            <li class="nav-item dropdown d-none d-lg-block">
              <a class="nav-link dropdown-bordered dropdown-toggle
                  dropdown-toggle-split" id="categorydropdown" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                Select Category
              </a>
              <div class="dropdown-menu dropdown-menu-right navbar-dropdown
                  preview-list pb-0" aria-labelledby="countDropdown"
                  style="max-height: 400px; overflow: hidden; overflow-y: auto;">
                <a class="dropdown-item" >
                                        <h6 class="dropdown-header">Select category</h6>
                                        <a class="dropdown-item select-category" data-value="null">All categorys</a>`
        for (i = 0; i < data.categorys.length; i++) {
          content += ` 
                                          <a class="dropdown-item select-category" data-value="`+ data.categorys[i].bcid + `">` + data.categorys[i].bcname + `</a>`
        }
        content += `
         
                                      </div>
            </li>`
        // }
        if (loginuserid != 0) {
          content += `
            <!-- notification -->
            <li class="nav-item dropdown">
              <a class="nav-link count-indicator" id="countDropdown" data-bs-toggle="dropdown"
                aria-expanded="false">
                <i class="icon-bell"></i>
                <span class="count"></span>
              </a>
              <div class="dropdown-menu dropdown-menu-right navbar-dropdown
                  preview-list pb-0" aria-labelledby="countDropdown">
                <a href="../notification/notification.html" class="dropdown-item py-3">
                  <p class="mb-0 font-weight-medium float-left">You have 7
                    unread mails </p>
                  <span class="badge badge-pill badge-primary float-right">View
                    all</span>
                </a>
             <!--   <div class="dropdown-divider"></div>
                <a class="dropdown-item preview-item">
                  <div class="preview-thumbnail">
                    <img src="images/faces/face10.jpg" alt="image" class="img-sm
                        profile-pic">
                  </div>
                  <div class="preview-item-content flex-grow py-2">
                    <p class="preview-subject ellipsis font-weight-medium
                        text-dark">Marian Garner </p>
                    <p class="fw-light small-text mb-0"> The meeting is
                      cancelled </p>
                  </div>
                </a>
                <a class="dropdown-item preview-item">
                  <div class="preview-thumbnail">
                    <img src="images/faces/face12.jpg" alt="image" class="img-sm
                        profile-pic">
                  </div>
                  <div class="preview-item-content flex-grow py-2">
                    <p class="preview-subject ellipsis font-weight-medium
                        text-dark">David Grey </p>
                    <p class="fw-light small-text mb-0"> The meeting is
                      cancelled </p>
                  </div>
                </a>
                <a class="dropdown-item preview-item">
                  <div class="preview-thumbnail">
                    <img src="images/faces/face1.jpg" alt="image" class="img-sm
                        profile-pic">
                  </div>
                  <div class="preview-item-content flex-grow py-2">
                    <p class="preview-subject ellipsis font-weight-medium
                        text-dark">Travis Jenkins </p>
                    <p class="fw-light small-text mb-0"> The meeting is
                      cancelled </p>
                  </div>
                </a> -->
              </div>
            </li>`
        }
        if (loginuserid == 0) {
          content += `
            <!-- profile -->
            <li class="nav-item dropdown d-none d-lg-block user-dropdown">
              <a class="nav-link" id="UserDropdown" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                <img class="img-xs rounded-circle" src="./images/faces/profile/default.png" alt="Profile image" title="profile"> </a>
              <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="UserDropdown">
                <div class="dropdown-header text-center">
                  <img class="img-xs rounded-circle" src="./images/faces/profile/default.png" alt="Profile image">
                  <p class="mb-1 mt-3 font-weight-semibold" id="useruname">Guest</p>
                </div>
                <a href="./pages/login/" class="dropdown-item" ><i class="dropdown-item-icon mdi
                      mdi-power text-primary me-2"></i>Sign in</a>
              </div>
            </li>`
        } else {
          content += `
            <!-- profile -->
            <li class="nav-item dropdown d-none d-lg-block user-dropdown">
              <a class="nav-link" id="UserDropdown" href="#" data-bs-toggle="dropdown" aria-expanded="false">`
          if (loginuserdata[0].photo == null) {
            content += `<img class="img-xs rounded-circle" src="./images/faces/profile/default.png" alt="Profile image" title="profile"> </a>`;
          } else {
            content += `<img class="img-xs rounded-circle" src="./images/faces/profile/` + loginuserdata[0].photo + `" alt="Profile image">`
          }

          content += `<div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="UserDropdown">
                <div class="dropdown-header text-center">`
          if (loginuserdata[0].photo == null) {
            content += `<img class="img-xs rounded-circle" src="./images/faces/profile/default.png" alt="Profile image">`
          } else {
            content += `<img class="img-xs rounded-circle" src="./images/faces/profile/` + loginuserdata[0].photo + `" alt="Profile image">`
          }
          content += `<p class="mb-1 mt-3 font-weight-semibold" id="useruname">` + loginuserdata[0].username + `</p>
                  <p class="fw-light text-muted mb-0" id="useremail">`+ loginuserdata[0].email + `</p>
                </div>
                <a class="dropdown-item show-profile" data-id="`+ loginuserdata[0].usid + `"><i class="dropdown-item-icon mdi
                      mdi-account-outline text-primary me-2"></i> My
                  Profile</a>
                <a class="dropdown-item" id="signout"><i class="dropdown-item-icon mdi
                      mdi-power text-primary me-2"></i>Sign Out</a>
              </div>
            </li>`
        }
        content += `
        </ul >
          <button class="navbar-toggler navbar-toggler-right d-lg-none
            align-self-center" type="button" data-bs-toggle="offcanvas">
            <span class="mdi mdi-menu"></span>
          </button>
      </div >
          `;

      }
    }
  });
  $("#navbar").append(content);
  // if (loginuserdata[0].user_type == "user") {
  //   $("#myblogs").hide();
  //   // alert(1)
  // }
}

$(document).on("click", "#createblog", function (e) {
  if (loginuserid != 0) {
    // alert(1)
    // console.log(loginuserdata);
    if (loginuserdata[0].user_type == "user") {
      showSwal('auto-close', "Not suport in your account", "Please convert bloger account.");
      e.preventDefault();
    }
  }
})
setlogindata = () => {
  $.ajax({
    url: "./api/login.php",
    type: "POST",
    data: JSON.stringify({ fkey: 'checklogin' }),
    dataType: "JSON",
    async: false,
    success: (data) => {
      console.log(data);
      // console.log(data.userdata[0].email);
      if (data.status) {
        $("#useremail").html(data.userdata[0].email);
        // $("#useruname").html(data.userdata[0].username);
      }
      loginuserdata = data.userdata;
      $("#useruname").html(data.userdata[0].username);
      loginuserid = data.userdata[0].usid;
    }
  });
}


$(document).ready(function () {
  setlogindata();
  console.log(loginuserdata);
  //   reportcontentreload();
  sidebar();
  navbar();
  showBlog = () => {
    $.ajax({
      url: "./api/blogop.php",
      type: "POST",
      data: JSON.stringify({ fkey: 'blog_display' }),
      dataType: "JSON",
      success: (data) => {
        // $("#content-cardc").html(" ");
        console.log(data);
        // console.log(data.hasChanges);
        var content = `       
                              <div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true" id="modal">
                                <div class="modal-dialog" role="document">
                                  <div class="modal-content" id="modal-content">
                                  </div>
                                </div>
                              </div>
                              <div class="content-wrapper">
                                  <div class="d-flex align-items-center">
                                    <h4 class="m-0">Blogs</h4>`
        if (loginuserid != 0) {
          content +=
            `
                                                                  <div class="ms-auto">
                                                                    <div class="d-flex">
                                                                      <div class="collapse" id="addbutton">
                                                                        <button type="button" class="btn btn-danger fw-bold  btn-rounded btn-sm" id="cancelselection">
                                                                          <i class="mdi mdi-close-circle-outline"></i><span class="ms-1">Cancel</span>
                                                                        </button>
                                                                        <a class="savereadlist btn btn-info fw-bold  btn-rounded btn-sm savereadlist" data-bs-toggle="modal"
                                                                          data-bs-target="#modal" data-whatever="Add blog in read-list"><i
                                                                            class="mdi mdi-playlist-plus"></i><span class="ms-2">Add readlist</span></a>
                                                                      </div>
                                                                      <button type="button" class="btn btn-outline-secondary btn-sm" id="blogselecting">
                                                                        <i class="mdi mdi-playlist-plus"></i>
                                                                      </button>
                                                                    </div>
                                                                  </div>`
        }
        content += `</div>
                                  <div class="cards grid-row" id="content-cardc">
      `
        var blog = ``;
        for (var i = 0; i < data.allblogsdata.length; i++) {
          if (data.allblogsdata[i].blog_status == "posted" && data.allblogsdata[i].user_type == "blogger") {
            const postdate = data.allblogsdata[i].blog_post_time.split(" ")[0].split("-");
            const sdate = new Date(postdate[0], postdate[1] - 1, postdate[2]);
            const date = sdate.toString().split(" ");
            var strdate = date[0] + ", " + date[1] + " " + date[2] + ", " + date[3];
            //  const spdate = sdate.split(" ");
            // console.log(strdate);
            blog = `<div class="card blog hover" id="card-` + data.allblogsdata[i].blog_id + `" data-id="` + data.allblogsdata[i].blog_id + `">
                                        <div class="dropdown" align= center>
                                            <i class="mdi mdi-dots-horizontal" type="button" id="dropdownMenuSizeButton3" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></i>
                                          <div class="dropdown-menu" aria-labelledby="dropdownMenuSizeButton3">`;
            if (data.userdata.length == 0) {
              blog += `<a class="dropdown-item updateblog" href="./pages/login/index.html"><i class="mdi mdi-login text-info"></i><span class="ms-2">Login</span></a>`
            } else {
              if (data.userdata[0].usid == data.allblogsdata[i].usid) {
                blog += `<a class="dropdown-item updateblog" href="./pages/create/create.html?key=update&s=` + data.allblogsdata[i].blog_id + `"><i class="mdi mdi-pencil text-info"></i><span class="ms-2">Update</span></a>
                                                       <a class="dropdown-item deleteblog" data-id="`+ data.allblogsdata[i].blog_id + `"><i class="mdi mdi-delete text-info"></i><span class="ms-2">Delete</span></a>`;
              }
              // mdi mdi-pencil
              blog += `<a class="dropdown-item savereadlater"  data-id="` + data.allblogsdata[i].blog_id + `"><i class="mdi mdi-clock text-info"></i><span class="ms-2">Save to Read later</span></a>
                                                       <a class="dropdown-item savereadlist"  data-id="`+ data.allblogsdata[i].blog_id + `" data-bs-toggle="modal" data-bs-target="#modal" data-whatever="Add blog in read-list"><i class="mdi mdi-playlist-plus fw-bold text-info"></i><span class="ms-2">Save to Readlist</span></a>`
              if (data.userdata[0].usid != data.allblogsdata[i].usid) {
                blog += `<a class="dropdown-item reportblog"  data-id="` + data.allblogsdata[i].blog_id + `"><i class="mdi mdi-block-helper text-info"></i><span class="ms-2">Report</span></a>`
              }
            }
            blog += `
                                            </div>
                                            </div>
                                            <div class="card-top blogpreview loding" data-id="`+ data.allblogsdata[i].blog_id + `">
                                          <img src="./images/uploadimage/`+ data.allblogsdata[i].blog_cover_photo + `" alt="` + data.allblogsdata[i].blog_title + `">
                                        </div>
                                        <div class="card-bottom flex-row">
                                          <span class="cspaan date">`+ strdate + `</span>
                                          <p class="cp hover-cursor show-profile" data-id=`+ data.allblogsdata[i].usid + `>`
            if (data.allblogsdata[i].photo == null) {
              blog += `  <img class="profile-pic" src="./images/faces/profile/default.png">`
            } else {
              blog += `  <img class="profile-pic" src="./images/faces/profile/` + data.allblogsdata[i].photo + `">`
            }
            blog += data.allblogsdata[i].username + `</p>
                                        </div>
                                        <div class="card-info">
                                          <h2 class="btitle">`+ data.allblogsdata[i].blog_title + `</h2>
                                        </div>
                                        <div class="card-bottom flex-row">
                                          <a class="btn btn-outline-primary btn-sm hover" href="./pages/blogs/blog.html?s=`+ data.allblogsdata[i].blog_id + `">Read
                                          </a>
                                          <p class="nav">
                                          <i class="lcv mdi mdi-heart"></i>&nbsp;`+ data.allblogsdata[i].likes + `
                                          <i class="lcv mdi mdi-comment"></i>&nbsp;`+ data.allblogsdata[i].comments + `
                                          <i class="lcv mdi mdi-eye "></i>&nbsp;`+ data.allblogsdata[i].totalviews + `
                                          </p>  
                                          
                                          </div></div>`;
            // $("#content-cardc").append(blog);
          }
          content += blog;
          //                           <div class="checkbox" style="display:none;">
          //     <input type="checkbox" checked="">
          // </div>
        }
        content += `
        </div>
    </div>
          `
        $("#main-panel").html(content);
        $("#loader").hide()
        $(".body-content").show();
      },
      error: (error) => servererror(error)
    });
  }

  showBlog();
})
$(document).on("click", ".select-language", function () {
  // alert($(this).data("value"));
  selectedlanguage = $(this).data("value");
  $("#languagedropdown").text($(this).text())
  filter_blog();
})
$(document).on("click", ".select-category", function () {
  selectedcategory = $(this).data("value");
  $("#categorydropdown").text($(this).text())
  filter_blog();
})

function filter_blog() {
  $.ajax({
    url: "./api/blogop.php",
    type: "POST",
    data: JSON.stringify({ fkey: 'filter_blog', language: selectedlanguage, category: selectedcategory }),
    dataType: "JSON",
    success: (data) => {
      console.log(data);
      if (data.status) {
        var blog = ``;
        if (data.allblogsdata.length > 0) {
          for (var i = 0; i < data.allblogsdata.length; i++) {
            if (data.allblogsdata[i].blog_status == "posted" && data.allblogsdata[i].user_type == "blogger") {
              const postdate = data.allblogsdata[i].blog_post_time.split(" ")[0].split("-");
              const sdate = new Date(postdate[0], postdate[1] - 1, postdate[2]);
              const date = sdate.toString().split(" ");
              var strdate = date[0] + ", " + date[1] + " " + date[2] + ", " + date[3];
              //  const spdate = sdate.split(" ");
              // console.log(strdate);
              blog += `<div class="card blog hover" id="card-` + data.allblogsdata[i].blog_id + `" data-id="` + data.allblogsdata[i].blog_id + `">
                                            <div class="dropdown" align= center>
                                                <i class="mdi mdi-dots-horizontal" type="button" id="dropdownMenuSizeButton3" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></i>
                                              <div class="dropdown-menu" aria-labelledby="dropdownMenuSizeButton3">`;
              if (data.userdata.length == 0) {
                blog += `<a class="dropdown-item updateblog" href="./pages/login/index.html"><i class="mdi mdi-login text-info"></i><span class="ms-2">Login</span></a>`
              } else {
                if (data.userdata[0].usid == data.allblogsdata[i].usid) {
                  blog += `<a class="dropdown-item updateblog" href="./pages/create/create.html?key=update&s=` + data.allblogsdata[i].blog_id + `"><i class="mdi mdi-pencil text-info"></i><span class="ms-2">Update</span></a>
                                                           <a class="dropdown-item deleteblog" data-id="`+ data.allblogsdata[i].blog_id + `"><i class="mdi mdi-delete text-info"></i><span class="ms-2">Delete</span></a>`;
                }
                // mdi mdi-pencil
                blog += `<a class="dropdown-item savereadlater"  data-id="` + data.allblogsdata[i].blog_id + `"><i class="mdi mdi-clock text-info"></i><span class="ms-2">Save to Read later</span></a>
                                                           <a class="dropdown-item savereadlist"  data-id="`+ data.allblogsdata[i].blog_id + `" data-bs-toggle="modal" data-bs-target="#modal" data-whatever="Add blog in read-list"><i class="mdi mdi-playlist-plus fw-bold text-info"></i><span class="ms-2">Save to Readlist</span></a>`
                if (data.userdata[0].usid != data.allblogsdata[i].usid) {
                  blog += `<a class="dropdown-item reportblog"  data-id="` + data.allblogsdata[i].blog_id + `"><i class="mdi mdi-block-helper text-info"></i><span class="ms-2">Report</span></a>`

                }
              }
              blog += `
                                                </div>
                                                </div>
                                                <div class="card-top blogpreview loding" data-id="`+ data.allblogsdata[i].blog_id + `">
                                              <img src="./images/uploadimage/`+ data.allblogsdata[i].blog_cover_photo + `" alt="` + data.allblogsdata[i].blog_title + `">
                                            </div>
                                            <div class="card-bottom flex-row">
                                              <span class="cspaan date">`+ strdate + `</span>
                                              <p class="cp hover-cursor show-profile" data-id=`+ data.allblogsdata[i].usid + `>`
              if (data.allblogsdata[i].photo == null) {
                blog += `  <img class="profile-pic" src="./images/faces/profile/default.png">`
              } else {
                blog += `  <img class="profile-pic" src="./images/faces/profile/` + data.allblogsdata[i].photo + `">`
              }
              blog += data.allblogsdata[i].username + `</p>
                                            </div>
                                            <div class="card-info">
                                              <h2 class="btitle">`+ data.allblogsdata[i].blog_title + `</h2>
                                            </div>
                                            <div class="card-bottom flex-row">
                                              <a class="btn btn-outline-primary btn-sm hover" href="./pages/blogs/blog.html?s=`+ data.allblogsdata[i].blog_id + `">Read
                                              </a>
                                              <p class="nav">
                                              <i class="lcv mdi mdi-heart"></i>&nbsp;`+ data.allblogsdata[i].likes + `
                                              <i class="lcv mdi mdi-comment"></i>&nbsp;`+ data.allblogsdata[i].comments + `
                                              <i class="lcv mdi mdi-eye "></i>&nbsp;`+ data.allblogsdata[i].blog_view + `
                                              </p>  
                                              
                                              </div></div>`;
            }
          }
        }
        else {
          blog += "No blog found";
        }
        $("#content-cardc").html(blog);
      }
    },
    error: (error) => servererror(error)
  });
}
servererror = (error) => {
  console.log(error);
  content = ` <div class="container-fluid page-body-wrapper full-page-wrapper">
                <div class="content-wrapper d-flex align-items-center text-center error-page bg-info">
                  <div class="row flex-grow">
                    <div class="col-lg-7 mx-auto text-white">
                      <div class="row align-items-center d-flex flex-row">
                        <div class="col-lg-6 text-lg-right pr-lg-4">
                          <h1 class="display-1 mb-0">500</h1>
                        </div>
                        <div class="col-lg-6 error-page-divider text-lg-left pl-lg-4">
                          <h2>SORRY!</h2>
                          <h3 class="fw-light">Internal server error!</h3>
                        </div>
                      </div>
                      <div class="row mt-5">
                        <div class="col-12 text-center mt-xl-2">
                          <a class="text-white font-weight-medium" href="../blogs/home.html">Back to home</a>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>`
  $(".body-content").html(content);
  $("#loader").hide()
  $(".body-content").show();
}
pagenotfound = () => {
  content = `<div class="container-fluid page-body-wrapper full-page-wrapper">
              <div class="content-wrapper d-flex align-items-center text-center error-page bg-primary">
                <div class="row flex-grow">
                  <div class="col-lg-7 mx-auto text-white">
                    <div class="row align-items-center d-flex flex-row">
                      <div class="col-lg-6 text-lg-right pr-lg-4">
                        <h1 class="display-1 mb-0">404</h1>
                      </div>
                      <div class="col-lg-6 error-page-divider text-lg-left pl-lg-4">
                        <h2>SORRY!</h2>
                        <h3 class="fw-light">The page you're looking for was not found.</h3>
                      </div>
                    </div>
                    <div class="row mt-5">
                      <div class="col-12 text-center mt-xl-2">
                        <a class="text-white font-weight-medium" href="../blogs/home.html">Back to home</a>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>`
  $(".body-content").html(content);
  $("#loader").hide()
  $(".body-content").show();
}
// profile Open
$(document).on("click", ".show-profile", function () {
  window.location = "./pages/profile/profile.html?p=" + $(this).data("id");
})
// blog delete
$(document).on("click", ".deleteblog", function () {
  var id = $(this).data("id");
  // alert(id);
  swal({
    title: 'Are you sure?',
    text: "Do you want to delete your blog?",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3f51b5',
    cancelButtonColor: '#ff4081',
    confirmButtonText: 'Great ',
    buttons: {
      cancel: {
        text: "Cancel",
        value: null,
        visible: true,
        className: "btn btn-danger btn-sm",
        closeModal: true,
      },
      confirm: {
        text: "Delete",
        value: true,
        visible: true,
        className: "btn btn-primary btn-sm",
        closeModal: true
      }
    }
  }).then((result) => {
    if (result) {
      $.ajax({
        url: "./api/blogop.php",
        type: "DELETE",
        data: JSON.stringify({ fkey: 'blog_delete', 'blog_id': id }),
        dataType: "JSON",
        success: (data) => {
          console.log(data);
          if (data.status == 1) {
            showSuccessToast("deleted", data.message);
            $("#card-" + id).remove();
          }
        },
        error: (error) => servererror(error)
      });
    }
  })
});
$(document).on('mouseenter', ".card", function () {
  $(this).addClass("box-shadow");
});

$(document).on('mouseleave', ".card", function () {
  $(this).removeClass("box-shadow");
});
$(document).on("click", ".reportblog", function () {
  // alert($(this).data("id"));
  reportblogid = $(this).data("id");
  reportcontentreload();
  $("#modal").modal("show");
})
reporttext = rindex = null;
$(document).on("click", ".reportingtypeselect", function () {
  $(".reportingtypeselect").removeClass("card-inverse-success");
  $(".reportingtypeselect").addClass("card-inverse-warning");
  $(this).removeClass("card-inverse-warning");
  $(this).addClass("card-inverse-success");
  rindex = $(this).index(".reportingtypeselect");
  $(".reportingtypeselect").find("i").removeClass(" mdi-checkbox-marked-circle");
  $(".reportingtypeselect").find("i").addClass("mdi-checkbox-blank-circle-outline");
  $(this).find("i").addClass("mdi-checkbox-marked-circle");
  $(this).find("i").removeClass("mdi-checkbox-blank-circle-outline");
  $(".reasoninput").hide(600);
  switch (rindex) {
    case 0:
      reporttext = "It is spam";
      break;
    case 1:
      reporttext = "18+ content use";
      break;
    case 2:
      reporttext = "False information.";
      break;
    case 3:
      reporttext = null;
      $(".reasoninput").show(600);
      break;
    default:
      reporttext = null;
      break;
  }
})
// send report on blog
$(document).on("click", ".send-report", function () {
  console.log(reportblogid + reporttext);
  if (rindex == 3) {
    reporttext = $("#input-report").val()
  }
  if (reporttext == null || reporttext == '') {
    if (rindex == 3) {
      $("#input-report").focus();
      showInfoToast("Reporting on blog!", "Please enter your reason in input box.");
    } else {
      showInfoToast("Reporting on blog!", "Please select any one reason.");
    }
  } else {
    // reporting
    $.ajax({
      url: "./api/reports.php",
      type: "POST",
      data: JSON.stringify({ key: 'reporting', report_type: 'blog', report_type_id: reportblogid, reason: reporttext }),
      dataType: "JSON",
      success: (data) => {
        console.log(data);
      },
      error: (error) => servererror(error)
    })
    $(".reportingtypeselect").removeClass("card-inverse-success");
    $(".reportingtypeselect").addClass("card-inverse-warning");
    $(".reportingtypeselect").find("i").removeClass(" mdi-checkbox-marked-circle");
    $(".reportingtypeselect").find("i").addClass("mdi-checkbox-blank-circle-outline");
    showSuccessToast("Reporting on blog!", "Successfully send your report!");
    //   currentpage = ;
    $("#modal").modal("hide");
    $("#card-" + reportblogid).hide(600);
  }
})

selectingblog = false
selectingblogid = [];
$(document).on("click", ".blog", function () {
  // alert(1)
  if (selectingblog) {
    id = $(this).data("id");
    if (jQuery.inArray(id, selectingblogid) == -1) {
      $(this).addClass("card-inverse-info");
      selectingblogid.push(id)
    } else {
      selectingblogid.splice($.inArray(id, selectingblogid), 1);
      $(this).removeClass("card-inverse-info");
      if (selectingblogid.length == 0) {
        $("#addbutton").toggle(700);
        $("#blogselecting").toggle(700);
        selectingblog = false;
      }
    }
    console.log(selectingblogid)
    console.log()
  }
})
$(document).on("mouseover", ".blogpreview", function () {
  var element = $(this);
  var timeout = setTimeout(function () {
    $.ajax({
      url: "./api/blogop.php",
      type: "POST",
      data: JSON.stringify({ fkey: 'blog_read_one', 'blog_id': element.data("id") }),
      dataType: "JSON",
      async: false,
      success: (data) => {
        content = `
                    <div class="card card-rounded">
                      <div class="card-body">
                        <div class="row">
                          <div class="col-lg-12">
                            <div class="d-flex align-items-center align-content-center">
                              <h4 class="card-title card-title-dash">
                                `+ data.readblogdata[0].blog_title + `
                              </h4>
                              <button type="button" class="badge badge-pill btn-outline-behance ms-auto"
                                data-bs-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <div class="modal-body container-scroller" style="max-height: 350px; ">
                              `+ data.readblogdata[0].blog_content + `
                            </div>
                            <div class="d-flex align-items-center pt-3">
                              <div class="ms-auto">
                                <a class="btn btn-success btn-sm btn-rounded" href="./pages/blogs/blog.html?s=`+ data.readblogdata[0].blog_id + `">Read more</a>`
        content += `<button type="button" class="btn btn-light btn-sm btn-rounded ms-1" data-bs-dismiss="modal">Cancel</button>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>`;
        $("#modal-content").html(content);
        $("#modal").modal("show");

        // console.log(data)
        // target.popover({
        //   container: 'body',
        //   // title: 'Popover title',
        //   content: data.readblogdata[0].blog_content,
        //   html: true,
        //   delay: { show: 1000, hide: 100 },
        //   placement: 'auto',
        //   trigger: 'hover'
        // });
      },
      error: (error) => servererror(error)
    })
  }, 1500); // Delay in milliseconds
  element.data('timeout', timeout);
});
$(document).on("mouseout", ".blogpreview", function () {
  var element = $(this);
  var timeout = element.data('timeout');
  if (timeout) {
    clearTimeout(timeout);
    element.data('timeout', null);
  }
  // $("#modal").modal("hide");
});
$(document).on("click", "#blogselecting", function () {
  $(this).toggle(700);
  $("#addbutton").toggle(700);
  selectingblog = true;
  showInfoToast("Please select blogs", "Add multiple blogs in readlist.")
})
$(document).on("dblclick", ".blog", function () {
  if (loginuserid != 0) {
    id = $(this).data("id")
    if (selectingblogid.length == 0) {
      $("#addbutton").toggle(700);
      $("#blogselecting").toggle(700);
      showInfoToast("Please select blogs", "Add multiple blogs in readlist.");
      // $("#addbutton.very-slow").show(2000);
      selectingblog = true;
      if (jQuery.inArray(id, selectingblogid) == -1) {
        $(this).addClass("card-inverse-info");
        selectingblogid.push(id)
      } else {
        selectingblogid.splice($.inArray(id, selectingblogid), 1);
        $(this).removeClass("card-inverse-info");
      }
    }
  }
})
$(document).on("click", "#cancelselection", function () {
  // alert(1)
  $(".blog").removeClass("card-inverse-info");
  selectingblogid = [];
  $("#addbutton").toggle(700);
  $("#blogselecting").toggle(700);
  selectingblog = false;
  console.log(selectingblogid);
})
// create new readlist
$(document).on("click", "#createnewreadlist", function () {
  // alert(1);
  name = $("#readlistname").val();
  if (name == "") {
    $("#readlistname").addClass('Error');
    showDangerToast("Please Check all field", "Enter readlist name");
  } else {
    // alert($("#readlistname").val())
    // alert($("#readlistprivacy").prop('selectedIndex'));
    if ($("#readlistprivacy").prop('selectedIndex') == 0) {
      list_status = "private";
    } else {
      list_status = "public";
    }
    // create_readlist
    $.ajax({
      url: "./api/historysave.php",
      type: "POST",
      data: JSON.stringify({ key: 'create_readlist', list_title: name, list_status: list_status }),
      dataType: "JSON",
      success: (data) => {
        console.log(data);
        if (data.status) {
          $("#readlistname").removeClass('Error');
          // showSuccessToast("create", name + " readlist Created.");
          // $("#createreadlist").addClass('collapsing');
          $("#createreadlist").toggle(500);
          $("#readlistname").val("")
          content = `<div class="card" id="list-` + data.listcontent[0].list_id + `">
              <div class="card-body pb-0">
                      <!-- <h4 class="card-title">`+ data.listcontent[0].list_title + `</h4> -->
                      <div class="d-flex align-items-center">
                        <div class="d-flex read-list hover-cursor">`;
          if (data.listcontent[0].list_title == "Read Later") {
            content += `<i class="mdi mdi-clock-alert img-sm rounded-10 mdi-36px"></i>`;
          } else {
            content += `<i class="mdi mdi-format-list-bulleted img-sm rounded-10 mdi-36px"></i>`;
          }
          content += `<div class="ms-3">
                            <h6 class="mb-1">`+ data.listcontent[0].list_title + `</h6>
                            <small class="text-muted mb-0"><i class="mdi mdi-format-list-bulleted me-1"></i>`+ data.listcontent[0].totalblog + `
                              Blogs</small>
                          </div>
                        </div>`;
          if (data.listcontent[0].lcid == null) {
            content += `<i class="mdi mdi-plus-circle fw-bold ms-auto px-1 py-1 text-info mdi-24px hover-cursor content-update" data-listid='` + data.listcontent[0].list_id + `' data-op='add'></i>`;
          } else {
            content += `<i class="mdi mdi-minus-circle fw-bold ms-auto px-1 py-1 text-info mdi-24px hover-cursor content-update" data-listid='` + data.listcontent[0].list_id + `' data-lcid='` + data.listcontent[0].lcid + `' data-op='remove'></i>`;
          }
          content += `</div>
                    </div>
                    </div>`;
          $(".readlistcard").append(content);
          showSuccessToast("Add", "Added to " + data.listcontent[0].list_title)
        }
      }
    })

  }
})
var blog_id = null;
// save in readlater
$(document).on("click", ".savereadlater", function () {
  // alert("READLATER");
  // alert($(this).data("id"))
  blog_id = $(this).data("id");
  $.ajax({
    url: "./api/historysave.php",
    type: "POST",
    data: JSON.stringify({ key: 'blog_save', 'blog_id': blog_id }),
    dataType: "JSON",
    success: (data) => {
      console.log(data);
      if (data.status == 1) {
        showInfoToast("Save", data.message);
      }
    },
    error: (error) => servererror(error)
  });

})

// add multiple blog show readlist
$(document).on("click", ".savereadlist", function () {
  // alert("LIST");
  console.log(selectingblog);
  if (selectingblog) {
    // addmultipleblog_show_readlist
    $.ajax({
      url: "./api/historysave.php",
      type: "POST",
      data: JSON.stringify({ key: 'addmultipleblog_show_readlist' }),
      dataType: "JSON",
      success: (data) => {
        console.log(data);
        var content = `
                <div class="card card-rounded">
                <div class="card-body">
                  <div class="row">
                    <div class="col-lg-12">
                      <div class="d-flex align-items-center align-content-center">
                        <h4 class="card-title card-title-dash">
                          Add blog in readlist
                        </h4>
                        <button type="button" class="badge badge-pill btn-outline-behance ms-auto"
                          data-bs-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <p class="card-text pt-1">
                        Would you like to add the blog to a readlist?
                        <span class="text-small text-muted">Choose any readlist..!</span>
                      </p>
                      <div class="mt-3">
                        <div class="d-flex align-items-center mb-1">
                        <a data-bs-toggle="collapse" id="createreadlistb" href="#createreadlist" aria-expanded="false"
                          aria-controls="createreadlist"
                          class="collapsed ms-3 ml-3 show-reply btn btn-info ms-auto btn-rounded btn-sm">
                          <i class="mdi mdi-plus-circle fw-bold ms-auto px-1 py-1 hover-cursor read-list-status"></i>
                          Create ReadList
                        </a>
                      </div>
                      <div class="cards readlistcard">
                  `;
        if (data.status) {
          for (i = 1; i < data.listcontent.length; i++) {
            console.log(data.listcontent[i]);

            content += `<div class="card" id="list-` + data.listcontent[i].list_id + `">
                              <div class="card-body pb-0">
                            <!-- <h4 class="card-title">`+ data.listcontent[i].list_title + `</h4> -->
                            <div class="d-flex align-items-center">
                              <div class="d-flex read-list hover-cursor">`;
            if (i == 1) {
              content += `<i class="mdi mdi-clock-alert img-sm rounded-10 mdi-36px"></i>`;
            } else {
              content += `<i class="mdi mdi-format-list-bulleted img-sm rounded-10 mdi-36px"></i>`;
            }
            content += `<div class="ms-3">
                                  <h6 class="mb-1">`+ data.listcontent[i].list_title + `</h6>
                                  <small class="text-muted mb-0"><i class="mdi mdi-format-list-bulleted me-1"></i>`+ data.listcontent[i].totalblog + `
                                    Blogs</small>
                                </div>
                              </div>
                    <i class="mdi mdi-plus-circle fw-bold ms-auto px-1 py-1 text-info mdi-24px hover-cursor content-update" data-listid='` + data.listcontent[i].list_id + `'></i>
                  </div>
                          </div>
                        </div>
                        `}
          content += `</div>
                              <div id="createreadlist" class="collapse" role="tabpanel" aria-labelledby="createreadlist"
                                      data-bs-parent="#accordion-2">
                                      <div class="card">
                                        <div class="card-body pb-0">
                                          <!-- <h4 class="card-title">Read list</h4> -->
                                          <!-- <div class="d-flex align-items-center"> -->
                                          <div class="row">
                                            <div class="form-group">
                                              <label for="exampleInputName1">Name</label>
                                              <input type="text" class="form-control" id="readlistname"
                                                placeholder="Enter Readlist Name">
                                            </div>
                                            <div class="form-group">
                                              <label for="exampleSelectGender">Priavcy</label>
                                              <select class="form-control" id="readlistprivacy">
                                                <option>Private</option>
                                                <option>Public</option>
                                              </select>
                                            </div>
                                            <div class="d-flex align-items-center">
                                              <button type="button"
                                                class="button btn btn-primary ms-auto btn-rounded btn-sm" id="createnewreadlist"><span>Create</span></button>
                                            </div>
                                          </div>
                                          <!-- </div> -->
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                  </div>
                                </div>
                              </div> `
            ;

          $("#modal-content").html(content)
        }
      },
      error: (error) => servererror(error)
    })
  } else {
    blog_id = $(this).data("id");
    $.ajax({
      url: "./api/historysave.php",
      type: "POST",
      data: JSON.stringify({ key: 'addblog_show_readlist', 'blog_id': blog_id }),
      dataType: "JSON",
      success: (data) => {
        console.log(data);
        var content = `                <div class="card card-rounded">
                <div class="card-body">
                  <div class="row">
                    <div class="col-lg-12">
                      <div class="d-flex align-items-center align-content-center">
                        <h4 class="card-title card-title-dash">
                          Add blog in readlist
                        </h4>
                        <button type="button" class="badge badge-pill btn-outline-behance ms-auto"
                          data-bs-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <p class="card-text pt-1">
                        Would you like to add the blog to a readlist?
                        <span class="text-small text-muted">Choose any readlist..!</span>
                      </p>
                      <div class="mt-3>
                        <div class="d-flex align-items-center mb-1">
                        <a data-bs-toggle="collapse" id="createreadlistb" href="#createreadlist" aria-expanded="false"
                          aria-controls="createreadlist"
                          class="collapsed ms-3 ml-3 show-reply btn btn-info ms-auto btn-rounded btn-sm">
                          <i class="mdi mdi-plus-circle fw-bold ms-auto px-1 py-1 hover-cursor read-list-status"></i>
                          Create ReadList
                        </a>
                      </div>
                      <div class="cards readlistcard">
                  `;
        if (data.status) {
          for (i = 1; i < data.listcontent.length; i++) {
            console.log(data.listcontent[i]);

            content += `<div class="card" id="list-` + data.listcontent[i].list_id + `">
                              <div class="card-body pb-0">
                            <!-- <h4 class="card-title">`+ data.listcontent[i].list_title + `</h4> -->
                            <div class="d-flex align-items-center">
                              <div class="d-flex read-list hover-cursor">`;
            if (i == 1) {
              content += `<i class="mdi mdi-clock-alert img-sm rounded-10 mdi-36px"></i>`;
            } else {
              content += `<i class="mdi mdi-format-list-bulleted img-sm rounded-10 mdi-36px"></i>`;
            }
            content += `<div class="ms-3">
                                  <h6 class="mb-1">`+ data.listcontent[i].list_title + `</h6>
                                  <small class="text-muted mb-0"><i class="mdi mdi-format-list-bulleted me-1"></i>`+ data.listcontent[i].totalblog + `
                                    Blogs</small>
                                </div>
                              </div>`;
            if (data.listcontent[i].lcid == null) {
              content += `<i class="mdi mdi-plus-circle fw-bold ms-auto px-1 py-1 text-info mdi-24px hover-cursor content-update" data-listid='` + data.listcontent[i].list_id + `' data-op='add'></i>`;
            } else {
              content += `<i class="mdi mdi-minus-circle fw-bold ms-auto px-1 py-1 text-info mdi-24px hover-cursor content-update" data-listid='` + data.listcontent[i].list_id + `' data-lcid='` + data.listcontent[i].lcid + `' data-op='remove'></i>`;

            }
            content += `</div>
                          </div>
                        </div>`;
          }
          content += `</div>
                <div id="createreadlist" class="collapse" role="tabpanel" aria-labelledby="createreadlist"
                        data-bs-parent="#accordion-2">
                        <div class="card">
                          <div class="card-body pb-0">
                            <!-- <h4 class="card-title">Read list</h4> -->
                            <!-- <div class="d-flex align-items-center"> -->
                            <div class="row">
                              <div class="form-group">
                                <label for="exampleInputName1">Name</label>
                                <input type="text" class="form-control" id="readlistname"
                                  placeholder="Enter Readlist Name">
                              </div>
                              <div class="form-group">
                                <label for="exampleSelectGender">Priavcy</label>
                                <select class="form-control" id="readlistprivacy">
                                  <option>Private</option>
                                  <option>Public</option>
                                </select>
                              </div>
                              <div class="d-flex align-items-center">
                                <button type="button"
                                  class="button btn btn-primary ms-auto btn-rounded btn-sm" id="createnewreadlist"><span>Create</span></button>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    </div>
                  </div>
                </div>`;
        }
        $("#modal-content").html(content)
      },
      error: (error) => servererror(error)
    })
  }
  // alert(blog_id);

})
// add one blog in readlist 
$(document).on("click", ".content-update", function () {
  var list_id = $(this).data("listid");
  if (selectingblog) {
    // alert(list_id);
    $.ajax({
      url: "./api/historysave.php",
      type: "POST",
      data: JSON.stringify({ key: 'add_multiplecontent_to_readlist', 'blog_id': selectingblogid, list_id: list_id }),
      dataType: "JSON",
      success: (data) => {
        console.log(data);
        if (data.status) {
          // $(".blog").removeClass("card-inverse-info");
          // selectingblogid = [];
          // $("#addbutton").toggle();
          // selectingblog = false;
          // console.log(selectingblogid);
          content = `<div class="card-body pb-0">
                      <div class="d-flex align-items-center">
                        <div class="d-flex read-list hover-cursor">`;
          if (data.listcontent.list_title == "Read Later") {
            content += `<i class="mdi mdi-clock-alert img-sm rounded-10 mdi-36px"></i>`;
          } else {
            content += `<i class="mdi mdi-format-list-bulleted img-sm rounded-10 mdi-36px"></i>`;
          }
          content += `<div class="ms-3">
                            <h6 class="mb-1">`+ data.listcontent.list_title + `</h6>
                            <small class="text-muted mb-0"><i class="mdi mdi-format-list-bulleted me-1"></i>`+ data.listcontent.totalblog + `
                              Blogs</small>
                          </div>
                        </div>`;
          content += `<i class="mdi mdi-check-circle fw-bold ms-auto px-1 py-1 text-info mdi-24px hover-cursor"></i>`;
          `</div>
                    </div>`;
          $("#list-" + list_id).html(content);
          showSuccessToast("Added", data.message)
        }
      },
      error: (error) => servererror(error)

    })
  } else {
    var opration = $(this).data("op");
    // var list_id = $(this).data("listid");
    if (opration == "remove") {
      // delete_content_from_readlist
      var lcid = $(this).data("lcid");
      $.ajax({
        url: "./api/historysave.php",
        type: "DELETE",
        data: JSON.stringify({ key: 'delete_content_from_readlist_h', 'blog_id': blog_id, list_id: list_id, lcid: lcid }),
        dataType: "JSON",
        success: (data) => {
          console.log(data);
          content = `<div class="card-body pb-0">
                      <!-- <h4 class="card-title">`+ data.listcontent[0].list_title + `</h4> -->
                      <div class="d-flex align-items-center">
                        <div class="d-flex read-list hover-cursor">`;
          if (data.listcontent[0].list_title == "Read Later") {
            content += `<i class="mdi mdi-clock-alert img-sm rounded-10 mdi-36px"></i>`;
          } else {
            content += `<i class="mdi mdi-format-list-bulleted img-sm rounded-10 mdi-36px"></i>`;
          }
          content += `<div class="ms-3">
                            <h6 class="mb-1">`+ data.listcontent[0].list_title + `</h6>
                            <small class="text-muted mb-0"><i class="mdi mdi-format-list-bulleted me-1"></i>`+ data.listcontent[0].totalblog + `
                              Blogs</small>
                          </div>
                        </div>`;
          if (data.listcontent[0].lcid == null) {
            content += `<i class="mdi mdi-plus-circle fw-bold ms-auto px-1 py-1 text-info mdi-24px hover-cursor content-update" data-listid='` + data.listcontent[0].list_id + `' data-op='add'></i>`;
          } else {
            content += `<i class="mdi mdi-minus-circle fw-bold ms-auto px-1 py-1 text-info mdi-24px hover-cursor content-update" data-listid='` + data.listcontent[0].list_id + `' data-lcid='` + data.listcontent[0].lcid + `' data-op='remove'></i>`;

          }
          content += `</div>
                    </div>`;
          $("#list-" + list_id).html(content);
          showSuccessToast("Remove", "Removed from " + data.listcontent[0].list_title)
        },
        error: (error) => servererror(error)
      })
    } else if (opration == "add") {
      // alert(list_id);
      $.ajax({
        url: "./api/historysave.php",
        type: "DELETE",
        data: JSON.stringify({ key: 'add_content_to_readlist', 'blog_id': blog_id, list_id: list_id }),
        dataType: "JSON",
        success: (data) => {
          console.log(data);
          content = `<div class="card-body pb-0">
                      <!-- <h4 class="card-title">`+ data.listcontent[0].list_title + `</h4> -->
                      <div class="d-flex align-items-center">
                        <div class="d-flex read-list hover-cursor">`;
          if (data.listcontent[0].list_title == "Read Later") {
            content += `<i class="mdi mdi-clock-alert img-sm rounded-10 mdi-36px"></i>`;
          } else {
            content += `<i class="mdi mdi-format-list-bulleted img-sm rounded-10 mdi-36px"></i>`;
          }
          content += `<div class="ms-3">
                            <h6 class="mb-1">`+ data.listcontent[0].list_title + `</h6>
                            <small class="text-muted mb-0"><i class="mdi mdi-format-list-bulleted me-1"></i>`+ data.listcontent[0].totalblog + `
                              Blogs</small>
                          </div>
                        </div>`;
          if (data.listcontent[0].lcid == null) {
            content += `<i class="mdi mdi-plus-circle fw-bold ms-auto px-1 py-1 text-info mdi-24px hover-cursor content-update" data-listid='` + data.listcontent[0].list_id + `' data-op='add'></i>`;
          } else {
            content += `<i class="mdi mdi-minus-circle fw-bold ms-auto px-1 py-1 text-info mdi-24px hover-cursor content-update" data-listid='` + data.listcontent[0].list_id + `' data-lcid='` + data.listcontent[0].lcid + `' data-op='remove'></i>`;
          }
          content += `</div>
                    </div>`;
          $("#list-" + list_id).html(content);
          showSuccessToast("Add", "Added from " + data.listcontent[0].list_title)
        },
        error: (error) => servererror(error)

      })
    }
  }
})
// report content append in modal
function reportcontentreload() {
  content = `
            <div class="card card-rounded">
              <div class="card-body">
                <div class="row">
                  <div class="col-lg-12">
                    <div class="d-flex align-items-center align-content-center">
                      <h4 class="card-title card-title-dash">
                        Reporting on blog
                      </h4>
                      <button type="button" class="badge badge-pill btn-outline-behance ms-auto"
                        data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                      </div>
                      <p class="card-text pt-1">
                      Why are you reporting this blog?
                      <span class="text-small text-muted">Select any one reason..!</span>
                    </p>
                    <div class="mt-3">
                      <div class="card card-inverse-warning mb-2 hover-cursor reportingtypeselect">
                        <div class="card-body">
                          <div class="d-flex align-content-center">
                            <i class="mdi mdi-checkbox-blank-circle-outline text-info"></i>
                            <p class="ms-2 card-text">
                              It's spam.
                            </p>
                          </div>
                        </div>
                      </div>
                      <div class="card card-inverse-warning mb-2 hover-cursor reportingtypeselect">
                        <div class="card-body">
                          <div class="d-flex align-content-center">
                            <i class="mdi mdi-checkbox-blank-circle-outline text-info"></i>
                            <p class="ms-2 card-text">
                              18+ content use.
                            </p>
                          </div>
                        </div>
                      </div>
                      <div class="card card-inverse-warning mb-2 hover-cursor reportingtypeselect">
                        <div class="card-body">
                          <div class="d-flex align-content-center">
                            <i class="mdi mdi-checkbox-blank-circle-outline text-info"></i>
                            <p class="ms-2 card-text">
                              False information.
                            </p>
                          </div>
                        </div>
                      </div>
                      <div class="card card-inverse-warning mb-2 hover-cursor reportingtypeselect">
                        <div class="card-body">
                          <div class="d-flex align-content-center">
                            <i class="mdi mdi-checkbox-blank-circle-outline text-info"></i>
                            <p class="ms-2 card-text">
                              Something else.
                              </p>
                              </div>
                        </div>
                      </div>
                      <div class="card mb-2 collapse reasoninput">
                        <div class="card-body">
                          <div class="d-flex align-content-center">
                            <input type="text" class="form-control" placeholder="Enter report reason"
                              title="Report reason" id="input-report">
                          </div>
                        </div>
                      </div>
                      <div class="d-flex align-items-center">
                        <div class="ms-auto">
                          <button type="button"
                            class="btn btn-outline-danger btn-sm btn-rounded send-report">Report</button>
                          <button type="button" class="btn btn-outline-light btn-sm btn-rounded "
                            data-bs-dismiss="modal">Cancel</button>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>`
  $("#modal-content").html(content);
}

$(document).on("click", "#signout", () => {
  $.ajax({
    url: "./api/logout.php",
    type: "GET",
    dataType: "JSON",
    success: (data) => {
      if (data.status == 1) {
        window.location.href = "./index.html";
      }
    },
    error: (error) => servererror(error)
  });
})