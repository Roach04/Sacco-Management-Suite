<!-- Side Navbar -->
<nav class="side-navbar">
    <!-- Sidebar Header-->
    <div class="sidebar-header d-flex align-items-center">
        @foreach($users as $user)
            @if($user->role == 2)
                <div class="avatar">
                    <img style="width:100%; height:60px" src="{{ $user->userPic }}" alt="..." class="img-fluid rounded-circle">
                </div>
                <div class="title">
                    <h1 class="h4"> {{ $user->username }} </h1>
                    <p> {{ $user->jobTitle }} </p>
                </div>
            @endif
        @endforeach         
    </div>
    <!-- Sidebar Header-->

    <!-- Sidebar Navidation Menus-->
    <span class="heading">Main</span>
    <ul class="list-unstyled">
        <li class="active"> 
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
            <a href=" {{ route('memberLoans') }} ">
                <i class="fa fa-fire fa-lg"> </i>
                Loans
            </a>
        </li>
        <li>
            <a href=" {{ route('memberAccount') }} ">
                <i class="fa fa-user fa-lg"> </i>
                Member Accounts
            </a>
        </li>
        <!-- <li>
            <a href=" {{ route('sysAccounts') }} ">
                <i class="fa fa-user-secret fa-lg"> </i>
                System Accounts
            </a>
        </li> -->
        
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
                <a style="color:green" href=" {{ route('trashedAccounts') }} "> 
                    <i class="fa fa-trash fa-lg"> </i>
                    Restore Users
                    <span style="padding:5px" class="badge badge-success pull-right"> {{ count($trash) }} </span>
                </a>
            </li>
        @endif
        <li> <a href="#"> <i class="icon-mail"></i>Demo </a></li>
        @if(count($trashMember))
            <li class="active"> 
                <a style="color:#796AEE" href=" # "> 
                    <i class="fa fa-trash fa-lg"> </i>
                    Restore Members 
                    <span style="padding:5px" class="badge badge-primary pull-right"> {{ count($trashMember) }} </span>
                </a>
            </li>
        @endif
        <li> <a href="#"> <i class="icon-picture"></i>Demo </a></li>
    </ul>
    <!-- Sidebar Navidation Menus-->
</nav>