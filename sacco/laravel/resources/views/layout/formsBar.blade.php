<!-- Side Navbar -->
<nav class="side-navbar">
    <!-- Sidebar Header-->
    <div class="sidebar-header d-flex align-items-center">
        <div class="avatar">
            <img src="img/avatar-1.jpg" alt="..." class="img-fluid rounded-circle">
        </div>
        <div class="title">
            <h1 class="h4">Mark Stephen</h1>
            <p>Web Designer</p>
        </div>
    </div>
    <!-- Sidebar Header-->

    <!-- Sidebar Navidation Menus-->
    <span class="heading">Main</span>
    <ul class="list-unstyled">
        <li> 
            <a href=" {{ route('dashboard') }} ">
                <i class="icon-home"></i>Home
            </a>
        </li>
        <li>
            <a href="#dashvariants" aria-expanded="false" data-toggle="collapse"> 
                <i class="icon-interface-windows"></i>Dropdown 
            </a>
            <ul id="dashvariants" class="collapse list-unstyled">
                <li><a href="#">Page</a></li>
                <li><a href="#">Page</a></li>
                <li><a href="#">Page</a></li>
                <li><a href="#">Page</a></li>
            </ul>
        </li>
        <li> <a href=" {{ route('tables') }} "> <i class="icon-grid"></i>Tables </a></li>
        <li> <a href=" {{ route('charts') }} "> <i class="fa fa-bar-chart"></i>Charts </a></li>
        <li class="active"> <a href=" {{ route('forms') }} "> <i class="icon-padnote"></i>Forms </a></li>
        <li> <a href="login.html"> <i class="icon-interface-windows"></i>Login Page</a></li>
    </ul>

    <span class="heading">Extras</span>

    <ul class="list-unstyled">
        <li> <a href="#"> <i class="icon-flask"></i>Demo </a></li>
        <li> <a href="#"> <i class="icon-screen"></i>Demo </a></li>
        <li> <a href="#"> <i class="icon-mail"></i>Demo </a></li>
        <li> <a href="#"> <i class="icon-picture"></i>Demo </a></li>
    </ul>
    <!-- Sidebar Navidation Menus-->
</nav>