// profile Open
$(document).on("click", ".show-profile", function () {
  window.location = "../profile/profile.html?p=" + $(this).data("id");
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
        url: "../../api/blogop.php",
        type: "DELETE",
        data: JSON.stringify({ fkey: 'blog_delete', 'blog_id': id }),
        dataType: "JSON",
        success: (data) => {
          console.log(data);
          if (data.status == 1) {
            // showSwal('success-message', 'Blog posted', data.message, "okay");
            if (currentUrl.indexOf("blog.html") > -1) {
              window.location.href = "./home.html";
            } else {
              showSuccessToast("deleted", data.message);
              $("#card-" + id).remove();
            }
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
      url: "../../api/reports.php",
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

    if (currentUrl.indexOf("blog.html") > -1) {
      window.location.href = "./home.html";
    } else {
      $("#modal").modal("hide");
      $("#card-" + reportblogid).hide(600);
    }
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
      url: "../../api/blogop.php",
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
                              <div class="ms-auto">`
        if (currentUrl.indexOf("home.html") != -1 || currentUrl.indexOf("trending.html") != -1 || currentUrl.indexOf("myblog.html") != -1 || currentUrl.indexOf("blog.html") != -1) {
          content += `
                                <a class="btn btn-success btn-sm btn-rounded" href="./blog.html?s=`+ data.readblogdata[0].blog_id + `">Read more</a>`
        } else {
          content += `
                                <a class="btn btn-success btn-sm btn-rounded" href="../blogs/blog.html?s=`+ data.readblogdata[0].blog_id + `">Read more</a>`
        }
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
    if (currentUrl.indexOf("home.html") > -1) {
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
      url: "../../api/historysave.php",
      type: "DELETE",
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
    url: "../../api/historysave.php",
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
      url: "../../api/historysave.php",
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
      url: "../../api/historysave.php",
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
      url: "../../api/historysave.php",
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
        url: "../../api/historysave.php",
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
        url: "../../api/historysave.php",
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
    url: "../../api/logout.php",
    type: "GET",
    dataType: "JSON",
    success: (data) => {
      if (data.status == 1) {
        window.location.href = "../blogs/home.html";
      }
    },
    error: (error) => servererror(error)
  });
})
// filter blog
function filter_blog() {
  $.ajax({
    url: "../../api/blogop.php",
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
                blog += `<a class="dropdown-item updateblog" href="../login/index.html"><i class="mdi mdi-login text-info"></i><span class="ms-2">Login</span></a>`
              } else {
                if (data.userdata[0].usid == data.allblogsdata[i].usid) {
                  blog += `<a class="dropdown-item updateblog" href="../create/create.html?key=update&s=` + data.allblogsdata[i].blog_id + `"><i class="mdi mdi-pencil text-info"></i><span class="ms-2">Update</span></a>
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
                                              <img src="../../images/uploadimage/`+ data.allblogsdata[i].blog_cover_photo + `" alt="` + data.allblogsdata[i].blog_title + `">
                                            </div>
                                            <div class="card-bottom flex-row">
                                              <span class="cspaan date">`+ strdate + `</span>
                                              <p class="cp hover-cursor show-profile" data-id=`+ data.allblogsdata[i].usid + `>`
              if (data.allblogsdata[i].photo == null) {
                blog += `  <img class="profile-pic" src="../../images/faces/profile/default.png">`
              } else {
                blog += `  <img class="profile-pic" src="../../images/faces/profile/` + data.allblogsdata[i].photo + `">`
              }
              blog += data.allblogsdata[i].username + `</p>
                                            </div>
                                            <div class="card-info">
                                              <h2 class="btitle">`+ data.allblogsdata[i].blog_title + `</h2>
                                            </div>
                                            <div class="card-bottom flex-row">
                                              <a class="btn btn-outline-primary btn-sm hover" href="./blog.html?s=`+ data.allblogsdata[i].blog_id + `">Read
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
    },
    error: (error) => servererror(error)
  });
}
// ----- show notification ----------------//
$('#notificationstatus').change(function () {
  console.log(1);
  if ($(this).is(':checked')) {
    localStorage.setItem("shownotificationstatus", "true");
    $('#notificationstatus').prop('checked', true);
    $('#notificationstatustext').text('On');
    shownotification();
  } else {
    localStorage.setItem("shownotificationstatus", "false");
    $('#notificationstatus').prop('checked', false);
    $('#notificationstatustext').text('Off');
  }
});
function checknotification() {
  if (loginuserdata[0].user_type != "guest") {
    if (localStorage.getItem("shownotificationstatus") !== null) {
      var statusFromLocalStorage = localStorage.getItem("shownotificationstatus");
      if (statusFromLocalStorage === "true") {
        $('#notificationstatus').prop('checked', true);
        $('#notificationstatustext').text('On');
        shownotification();
      } else {
        $('#notificationstatus').prop('checked', false);
        $('#notificationstatustext').text('Off');
      }
    } else {
      localStorage.setItem("shownotificationstatus", "true");
    }
  } else {
    $('.divnotification').remove();
  }
}
function shownotification() {
  if (loginuserdata[0].user_type != "guest") {
    setInterval(() => {
      if (localStorage.getItem("shownotificationstatus") == "true") {

        $.ajax({
          url: "../../api/notify.php",
          type: "POST",
          data: JSON.stringify({ key: 'notify' }),
          dataType: "JSON",
          success: (data) => {
            console.log(data);
            if (data.status) {
              if (data.notifications.length > 0) {
                jQuery('#audioBox')[0].play();
                if (data.notifications.length > 1) {
                  showInfoToast("Notification!!", 'Check your notification!<br>')
                } else {
                  $('#notify a:eq(2)').remove();
                  content = `
                          <div class="dropdown-divider"></div>
                          <a href="../../pages/blogs/blog.html?s=` + data.notifications[0].blog_id + `" class="dropdown-item preview-item">
                            <div class="preview-thumbnail">
                              <img src="../../images/faces/profile/`+ ((data.notifications[0].photo == null) ? `default.png` : data.notifications[0].photo) + `" alt="image" class="img-sm
                                  profile-pic">
                            </div>
                            <div class="preview-item-content flex-grow py-2">
                            <p class="preview-subject ellipsis font-weight-medium
                                text-dark">`+ data.notifications[0].e_username + ` </p>`
                  if (data.notifications[0].notify_type == "like") {
                    content += `
                              <p class="fw-light small-text mb-0">Liked your blog</p>
                              <p class="fw-light small-text mb-0"><i class="mdi mdi-book-open me-1"></i>`+ data.notifications[0].blog_title + `</p>`
                    showInfoToast("Notification!!", data.notifications[0].e_username + ` liked your blog.<br><a href="../../pages/blogs/blog.html?s=` + data.notifications[0].blog_id + `">See blog</a>`)
                  } else if (data.notifications[0].notify_type == "clike") {
                    content += `
                              <p class="fw-light small-text mb-0">Liked your comment</p>
                              <p class="fw-light small-text mb-0"><i class="fa fa-comment-o me-1"></i>` + data.notifications[0].liked_comment + `</p>`
                    showInfoToast("Notification!!", data.notifications[0].e_username + ` liked your comment.<br><i class="fa fa-comment-o me-1"></i>` + data.notifications[0].liked_comment + ` <a href="../../pages/blogs/blog.html?s=` + data.notifications[0].blog_id + `">See blog</a>`)
                  } else if (data.notifications[0].notify_type == "rlike") {
                    content += `
                              <p class="fw-light small-text mb-0">Liked your blog</p>
                              <p class="fw-light small-text mb-0">liked your comment.<br><i class="fa fa-comment-o me-1"></i>` + data.notifications[0].liked_reply_comment + `</p>`
                    showInfoToast("Notification!!", data.notifications[0].e_username + ` liked your comment.<br><i class="fa fa-comment-o me-1"></i>` + data.notifications[0].liked_reply_comment + ` <a href="../../pages/blogs/blog.html?s=` + data.notifications[0].blog_id + `">See blog</a>`)
                  } else if (data.notifications[0].notify_type == "comment") {
                    content += `
                              <p class="fw-light small-text mb-0">Commented on your blog:"` + data.notifications[0].comments + `</p>
                              <p class="fw-light small-text mb-0"><i class="mdi mdi-book-open me-1"></i>` + data.notifications[0].blog_title + `</p>`
                    showInfoToast("Notification!!", data.notifications[0].e_username + ` commented on your blog:"` + data.notifications[0].comments + `.<br><i class="mdi mdi-book-open me-1"></i>` + data.notifications[0].blog_title + ` <a href="../../pages/blogs/blog.html?s=` + data.notifications[0].blog_id + `">See blog</a>`)
                  } else if (data.notifications[0].notify_type == "reply") {
                    content += `
                              <p class="fw-light small-text mb-0">replyed on your comment:"` + data.notifications[0].replycomment + ` </p>
                              <p class="fw-light small-text mb-0"><i class="fa fa-comment-o me-1"></i>` + data.notifications[0].reply_p_comment + `</p>`
                    showInfoToast("Notification!!", data.notifications[0].e_username + ` replyed on your comment:"` + data.notifications[0].replycomment + `.<br><i class="fa fa-comment-o me-1"></i>` + data.notifications[0].reply_p_comment + ` <a href="../../pages/blogs/blog.html?s=` + data.notifications[0].blog_id + `">See blog</a>`)
                  }
                  content += `
                            </div>
                          </a>`
                  $('#notify').prepend(content);
                  content = `<p class="mb-0 font-weight-medium float-left">You have ` + data.totalnotifications[0].totalnotifications + ` notification</p>
                      <span class="badge badge-pill badge-primary float-right">View
                        all</span>`
                  $(".totalnotification").html(content)
                }
              }
            }
          },
          error: (error) => servererror(error)
        })
      }
    }, 1000);
  }
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
checkguest = () => {
  if (loginuserdata[0].user_type == "guest") {
    pagenotfound();
    console.log(loginuserdata);
    return true;
  }
  return false;
}

checkuser = () => {
  if (loginuserdata[0].user_type == "user") {
    pagenotfound();
    console.log(loginuserdata);
    return true;
  }
  return false;
}
