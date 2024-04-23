
sidebar = () => {
    var currentUrl = window.location.href;
    currentUrl = currentUrl.split("/")
    console.log(currentUrl);
    currentpage = currentUrl.indexOf("blogd.html");
    console.log(currentpage);
    // var myblog = "";
    // if(usertype == "bloger"){
    //     myblog = ``;
    // }
    content = `
    <ul class="nav">
        <li class="nav-item">`
        if (currentUrl.indexOf("dashboard.html") == -1) {
            content += `
            <a class="nav-link" href="./dashboard.html">`
        } else {
            content += `
                <a class="nav-link" href="./dashboard.html">`
        }
        content += `
            <i class="mdi mdi-grid-large menu-icon"></i>
            <span class="menu-title">Dashboard</span>
        </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#ui-basic" aria-expanded="false"
            aria-controls="ui-basic">
                <i class="menu-icon mdi mdi-new-box"></i>
                <span class="menu-title">Blogs</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="ui-basic">
                <ul class="nav flex-column sub-menu">`
                if (currentUrl.indexOf("blogposted.html") == -1) {
                    content += `
                    <li class="nav-item"> <a class="nav-link" href="./blogposted.html">Posted blogs</a></li>`
                } else {
                    content += `
                    <li class="nav-item"> <a class="nav-link" href="./blogposted.html">Posted blogs</a></li>`
                }
                if (currentUrl.indexOf("blogdrafted.html") == -1) {
                    content += `
                    <li class="nav-item"> <a class="nav-link" href="./blogdrafted.html">Drafted blogs</a></li>`
                } else {
                    content += `
                    <li class="nav-item"> <a class="nav-link" href="./blogdrafted.html">Drafted blogs</a></li>`
                }
                if (currentUrl.indexOf("blogdeleted.html") == -1) {
                    content += `
                    <li class="nav-item"> <a class="nav-link" href="./blogdeleted.html">Deleted blogs</a></li>`
                } else {
                    content += `
                    <li class="nav-item"> <a class="nav-link" href="./blogdeleted.html">Deleted blogs</a></li>`
                }
                content += `
                </ul>
            </div>
        </li>
        <li class="nav-item">`
        if (currentUrl.indexOf("users.html") == -1) {
            content += `
            <a class="nav-link" href="./users.html">`
        } else {
            content += `
                <a class="nav-link" href="./users.html">`
        }
        content += `
            <i class="mdi mdi-account-multiple menu-icon"></i>
            <span class="menu-title">Users</span>
        </a>
        </li>
        <li class="nav-item">`
        if (currentUrl.indexOf("languages.html") == -1) {
            content += `
            <a class="nav-link" href="./languages.html">`
        } else {
            content += `
                <a class="nav-link" href="./languages.html">`
        }
        content += `
            <i class="mdi mdi-format-list-bulleted-type menu-icon"></i>
            <span class="menu-title">Languages</span>
        </a>
        </li>
        <li class="nav-item">`
        if (currentUrl.indexOf("categorys.html") == -1) {
            content += `
            <a class="nav-link" href="./categorys.html">`
        } else {
            content += `
                <a class="nav-link" href="./categorys.html">`
        }
        content += `
            <i class="mdi mdi-format-list-bulleted-type menu-icon"></i>
            <span class="menu-title">Categorys</span>
        </a>
        </li>
        <li class="nav-item">`
        if (currentUrl.indexOf("reportedblog.html") == -1) {
            content += `
            <a class="nav-link" href="./reportedblog.html">`
        } else {
            content += `
                <a class="nav-link" href="./reportedblog.html">`
        }
        content += `
            <i class="mdi mdi-information menu-icon"></i>
            <span class="menu-title">Reported blogs</span>
        </a>
        </li>
    </ul>
    `;
    $("#sidebar").append(content)
};
