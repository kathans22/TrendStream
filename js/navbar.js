navbar = () => {
  // currentUrl = window.location.href;
  // currentUrl = currentUrl.split("/")
  // navbar_data
  $.ajax({
    url: "../../api/navbar.php",
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
        <div style = "display:flex;">
          <a class="navbar-brand brand-logo" href="../../index.html">
          <img src="../../images/logo.png" alt="logo" style = "height : 22px;" />
            <!-- <img src="images/logo.svg" alt="logo" /> -->
           <!-- <h3>blogger</h3> -->
          </a>
          <a class="navbar-brand brand-logo-mini" href="../../index.html">
            <img src="../../images/logo2.png" alt="logo" />
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
        if (currentUrl.indexOf("home.html") != -1) {
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
        }
        if (loginuserid != 0) {
          content += `
            <!-- notification -->
            <li class="nav-item dropdown d-none d-lg-block">
              <a class="nav-link count-indicator" id="countDropdown" data-bs-toggle="dropdown"
                aria-expanded="false">
                <i class="icon-bell"></i>
                <span class="count"></span>
              </a>`
          content += `<div class="dropdown-menu dropdown-menu-right navbar-dropdown
                        preview-list pb-0" aria-labelledby="countDropdown">`
          if (data.notifications.length > 0) {
            content += `
                        <a href="../notification/notification.html" class="dropdown-item py-3 totalnotification">
                          <p class="mb-0 font-weight-medium float-left">You have `+data.notifications.length+` notification</p>
                          <span class="badge badge-pill badge-primary float-right">View
                            all</span>
                        </a>
                        <div id="notify">`
            for (i = 0; i < 3; i++) {
              if (data.notifications[i] == undefined) {
                continue;
              } else {
                console.log(data.notifications[i])
                content += `
                            <div class="dropdown-divider"></div>
                            <a href="../../pages/blogs/blog.html?s=` + data.notifications[i].blog_id + `" class="dropdown-item preview-item">
                              <div class="preview-thumbnail">
                                <img src="../../images/faces/profile/`+ ((data.notifications[i].photo == null) ? `default.png` : data.notifications[i].photo) + `" alt="image" class="img-sm
                                    profile-pic">
                              </div>
                              <div class="preview-item-content flex-grow py-2">
                              <p class="preview-subject ellipsis font-weight-medium
                                  text-dark">`+ data.notifications[i].e_username + ` </p>`
                if (data.notifications[i].notify_type == "like") {
                  console.log(data.notifications[i]);
                  content += `
                                              <p class="fw-light small-text mb-0">Liked your blog</p>
                                              <p class="fw-light small-text mb-0"><i class="mdi mdi-book-open me-1"></i>`+ data.notifications[i].blog_title + `</p>`
                  // showInfoToast("Notification!!", data.notifications[i].e_username + ` liked your blog.<br><a href="../../pages/blogs/blog.html?s=` + data.notifications[i].blog_id + `">See blog</a>`)
                } else if (data.notifications[i].notify_type == "clike") {
                  content += `
                                              <p class="fw-light small-text mb-0">Liked your comment</p>
                                              <p class="fw-light small-text mb-0"><i class="fa fa-comment-o me-1"></i>` + data.notifications[i].liked_comment + `</p>`
                  // showInfoToast("Notification!!", data.notifications[i].e_username + ` liked your comment.<br><i class="fa fa-comment-o me-1"></i>` + data.notifications[i].liked_comment + ` <a href="../../pages/blogs/blog.html?s=` + data.notifications[i].blog_id + `">See blog</a>`)
                } else if (data.notifications[i].notify_type == "rlike") {
                  content += `
                                    <p class="fw-light small-text mb-0">Liked your blog</p>
                                    <p class="fw-light small-text mb-0">liked your comment.<br><i class="fa fa-comment-o me-1"></i>` + data.notifications[i].liked_reply_comment + `</p>`

                  // showInfoToast("Notification!!", data.notifications[i].e_username + ` liked your comment.<br><i class="fa fa-comment-o me-1"></i>` + data.notifications[i].liked_reply_comment + ` <a href="../../pages/blogs/blog.html?s=` + data.notifications[i].blog_id + `">See blog</a>`)
                } else if (data.notifications[i].notify_type == "comment") {
                  content += `
                                    <p class="fw-light small-text mb-0">Commented on your blog:"` + data.notifications[i].comments + `</p>
                                    <p class="fw-light small-text mb-0"><i class="mdi mdi-book-open me-1"></i>` + data.notifications[i].blog_title + `</p>`

                  // showInfoToast("Notification!!", data.notifications[i].e_username + ` commented on your blog:"` + data.notifications[i].comments + `.<br><i class="mdi mdi-book-open me-1"></i>` + data.notifications[i].blog_title + ` <a href="../../pages/blogs/blog.html?s=` + data.notifications[i].blog_id + `">See blog</a>`)
                } else if (data.notifications[i].notify_type == "reply") {
                  content += `
                                    <p class="fw-light small-text mb-0">replyed on your comment:"` + data.notifications[i].replycomment + ` </p>
                                    <p class="fw-light small-text mb-0"><i class="fa fa-comment-o me-1"></i>` + data.notifications[i].reply_p_comment + `</p>`

                  // showInfoToast("Notification!!", data.notifications[0].e_username + ` replyed on your comment:"` + data.notifications[0].replycomment + `.<br><i class="fa fa-comment-o me-1"></i>` + data.notifications[0].reply_p_comment + ` <a href="../../pages/blogs/blog.html?s=` + data.notifications[0].blog_id + `">See blog</a>`)
                }

                content += `
                              </div>
                            </a>`
              }
            }
            content+=`</div>`

          } else {
            content += `
            <a class="dropdown-item py-3">
                          <p class="mb-0 font-weight-medium float-left">You have no new notification</p>
                        </a>`
          }

          content += `
                      </div>`
          content += `</li>`
        }
        if (loginuserid == 0) {
          content += `
            <!-- profile -->
            <li class="nav-item dropdown d-none d-lg-block user-dropdown">
              <a class="nav-link" id="UserDropdown" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                <img class="img-xs rounded-circle" src="../../images/faces/profile/default.png" alt="Profile image" title="profile"> </a>
              <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="UserDropdown">
                <div class="dropdown-header text-center">
                  <img class="img-xs rounded-circle" src="../../images/faces/profile/default.png" alt="Profile image">
                  <p class="mb-1 mt-3 font-weight-semibold" id="useruname">Guest</p>
                </div>
                <a href="../login/" class="dropdown-item" ><i class="dropdown-item-icon mdi
                      mdi-power text-primary me-2"></i>Sign in</a>
              </div>
            </li>`
        } else {
          content += `
            <!-- profile -->
            <li class="nav-item dropdown d-none d-lg-block user-dropdown">
              <a class="nav-link" id="UserDropdown" href="#" data-bs-toggle="dropdown" aria-expanded="false">`
          if (loginuserdata[0].photo == null) {
            content += `<img class="img-xs rounded-circle" src="../../images/faces/profile/default.png" alt="Profile image" title="profile"> </a>`;
          } else {
            content += `<img class="img-xs rounded-circle" src="../../images/faces/profile/` + loginuserdata[0].photo + `" alt="Profile image">`
          }

          content += `<div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="UserDropdown">
                <div class="dropdown-header text-center">`
          if (loginuserdata[0].photo == null) {
            content += `<img class="img-xs rounded-circle" src="../../images/faces/profile/default.png" alt="Profile image">`
          } else {
            content += `<img class="img-xs rounded-circle" src="../../images/faces/profile/` + loginuserdata[0].photo + `" alt="Profile image">`
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
