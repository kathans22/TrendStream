
currentUrl = window.location.href;
currentUrl = currentUrl.split(/[\/?]/);
sidebar = () => {
  content = `
    <ul class="nav">`
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
            <li class="nav-item"> <a class="nav-link" href="../blogs/home.html">Home</a></li>
            <li class="nav-item"> <a class="nav-link" href="../blogs/tranding.html">Trending</a></li>`
  if (loginuserdata[0].user_type == "blogger") {
    content += `<li class="nav-item checkloginuser"> <a class="nav-link" href="../blogs/myblogs.html">My blogs</a></li>`
  }
  content += `</ul>
        </div>
      </li>
      <li class="nav-item" id="createblog">
        <a class="nav-link checkloginuser" href="../create/create.html">
          <i class="menu-icon mdi mdi-plus-circle-outline"></i>
          <span class="menu-title">Create</span>
        </a>
      </li>
      <li class="nav-item nav-category">OTHERS</li>
      <li class="nav-item">
        <a class="nav-link" href="../search/search.html">
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
        <a class="nav-link checkloginuser" href="../history/history.html">
          <i class="menu-icon mdi mdi-history"></i>
          <span class="menu-title">History</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link checkloginuser" href="../readlater/readlater.html">
          <i class="menu-icon mdi mdi-clock"></i>
          <span class="menu-title">Read later</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link checkloginuser" href="../readlist/readlist.html">
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
        <a class="nav-link" href="../help/help.html">
          <i class="menu-icon mdi mdi-help-circle-outline"></i>
          <span class="menu-title">Help</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="../sendfeedback/feedback.html">
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
    url: "../../api/login.php",
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


// createblog = (e) => {
//   e.preventDefault();
//   $.ajax({
//     url: "http://localhost/mycode/template/star1/api/login.php",
//     type: "POST",
//     data: JSON.stringify({ fkey: 'checklogin' }),
//     dataType: "JSON",
//     success: (data) => {
//       if (data.userdata[0].user_type == "user") {
//         // showSwal('auto-close');
//         showSwal('auto-close', "Not suport in your account", "Please convert bloger account.");
//       } else {
//         window.location = "http://localhost/mycode/template/star1/pages/create/create.html";
//       }
//     }
//   });
// }
