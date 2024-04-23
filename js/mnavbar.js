navbar = () => {
    $("#navbar").append(`
<div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-start">
  <div class="me-3">
    <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-bs-toggle="minimize">
      <span class="icon-menu"></span>
    </button>
  </div>
  <div style = "display:flex;">
  <a class="navbar-brand brand-logo" href="index.html">
  <img src="../../images/logo.png" alt="logo" style = "height : 22px;"/>
    <!-- <img src="images/logo.svg" alt="logo" /> -->
   <!-- <h3>blogger</h3> -->
  </a>
  <a class="navbar-brand brand-logo-mini" href="index.html">
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
    <!-- select category -->
    <!-- profile -->
    <li class="nav-item dropdown d-none d-lg-block user-dropdown">
      <a class="nav-link" id="UserDropdown" href="#" data-bs-toggle="dropdown" aria-expanded="false">
        <img class="img-xs rounded-circle" src="../../images/faces/face8.jpg" alt="Profile image"> </a>
      <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="UserDropdown">
        <div class="dropdown-header text-center">
          <img class="img-md rounded-circle" src="../../images/faces/face8.jpg" alt="Profile image">
          <p class="mb-1 mt-3 font-weight-semibold" id="useruname">Admin</p>
        <!--  <p class="fw-light text-muted mb-0" id="useremail">allenmoreno@gmail.com</p> -->
        </div>
       <!-- <a class="dropdown-item"><i class="dropdown-item-icon mdi
              mdi-account-outline text-primary me-2"></i> My
          Profile <span class="badge badge-pill badge-danger">1</span></a> -->
        <a class="dropdown-item" id="signout"><i class="dropdown-item-icon mdi
              mdi-power text-primary me-2"></i>Sign Out</a>
      </div>
    </li>
  </ul>
  <button class="navbar-toggler navbar-toggler-right d-lg-none
      align-self-center" type="button" data-bs-toggle="offcanvas">
    <span class="mdi mdi-menu"></span>
  </button>
</div>
`);
}
