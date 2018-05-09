<!-- Side Navbar -->
<nav class="side-navbar">
    <!-- Sidebar Header-->
    <div class="sidebar-header d-flex align-items-center">
        @if($user->role == 1)
            <div class="avatar">
                <img style="width:100%; height:60px" src="{{ $user->userPic }}" alt="Null" class="img-fluid rounded-circle">
            </div>
            <div class="title">
                <h1 class="h4"> {{ $user->username }} </h1>
                <p> {{ $user->jobTitle }} </p>
            </div>
        @endif
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
        <li> <a href=" {{ route('forms') }} "> <i class="icon-padnote"></i>Forms </a></li>
        

        <li>
            <a href=" {{ route('sysAccounts') }} ">
                <i class="fa fa-user-secret fa-lg"> </i>
                System Accounts
            </a>
        </li>
    </ul>

    <span class="heading">Extras</span>

    <ul class="list-unstyled">
        <li>
            <a href="#dash" aria-expanded="false" data-toggle="collapse"> 
                <i class="fa fa-gear fa-lg"></i>Settings 
            </a>
            <ul id="dash" class="collapse list-unstyled">
                <li>
                    <a href=" {{ route('passChange', [Auth::user()->id]) }} ">
                        <i class="fa fa-leaf fa-lg"> </i>
                        Change Password
                    </a>
                </li>
            </ul>
        </li>
        @if(count($trash))
            <li class="active"> 
                <a style="color:red" href=" {{ route('trashedAccounts') }} "> 
                    <i class="fa fa-trash fa-lg"> </i>
                    Restore Users. 
                    <span style="padding:5px" class="badge badge-danger pull-right"> {{ count($trash) }} </span>
                </a>
            </li>
        @endif
        <li> <a href="#"> <i class="icon-mail"></i>Demo </a></li>
    </ul>
    <!-- Sidebar Navidation Menus-->
</nav>