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

checklogin = ()=>{
    $.ajax({
        url: "../../api/masteradmin/login.php",
        type: "POST",
        data: JSON.stringify({ key: 'checkmlogin' }),
        dataType: "JSON",
        success: function (data) {
            console.log(data);
            if (!data.status) {
                window.location.href = "../index.html";
            } else {
                $("#loader").hide()
                $(".body-content").show();
            }
        },
        error: (error) => servererror(error)
    })
}
$(document).on("click","#signout",(e)=>{
  $.ajax({
    url: "../../api/masteradmin/login.php",
    type: "POST",
    data: JSON.stringify({ key: 'mlogout' }),
    dataType: "JSON",
    success: function (data) {
        console.log(data);
        if (data.status) {
            window.location.href = "../index.html";
        }
    },
    error: (error) => servererror(error)
})
})