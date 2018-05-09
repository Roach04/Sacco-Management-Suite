<!-- Side Navbar -->
<nav class="side-navbar">
    <!-- Sidebar Header-->
    <div class="sidebar-header d-flex align-items-center">
        @foreach($users as $user)
            @if($user->role == 1)
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
        <li> <a href=" {{ route('ledgers') }} "> <i class="icon-grid"></i>Ledgers </a></li>
        <li> <a href=" {{ route('charts') }} "> <i class="icon-line-chart"></i>Charts </a></li>

        @if(count($maturedLoan))
            <li class="active">
                <a style="color:#ffc36d" href=" {{ route('maturedLoans') }} ">
                    <i class="icon-padnote"> </i>
                    Matured Loans
                    <span style="padding:5px" class="badge badge-warning pull-right"> {{ count($maturedLoan) }} </span>
                </a>
            </li>
        @endif            
        
        <li>
            <a href=" {{ route('memberLoans') }} ">
                <i class="icon-clock"> </i>
                Member Loans
            </a>
        </li>
        @if(count($defaultLoan))
            <li class="active">
                <a style="color:#ff7676" href=" {{ route('defaultLoans') }} ">
                    <i class="icon-check"> </i>
                    Default Loans
                    <span style="padding:5px" class="badge badge-danger pull-right"> {{ count($defaultLoan) }} </span>
                </a>
            </li>
        @endif
        <li>
            <a href=" {{ route('memberAccount') }} ">
                <i class="icon-interface-windows"> </i>
                Member Accounts
            </a>
        </li>
        @if(Auth::user()->role == 1)
            <li>
                <a href=" {{ route('sysAccounts') }} ">
                    <i class="icon-user"> </i>
                    System Accounts
                </a>
            </li>
        @endif
        
    </ul>

    <span class="heading">Extras</span>

    <ul class="list-unstyled">
        @if(count($trash))
            <li class="active"> 
                <a style="color:green" href=" {{ route('trashedAccounts') }} "> 
                    <i class="icon-bill"> </i>
                    Restore Users
                    <span style="padding:5px" class="badge badge-success pull-right"> {{ count($trash) }} </span>
                </a>
            </li>
        @endif
        <li>
            <a href="#dash" aria-expanded="false" data-toggle="collapse"> 
                <i class="icon-paper-airplane"></i>Settings 
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
        @if(count($trashMember))
            <li class="active"> 
                <a style="color:#796AEE" href=" # "> 
                    <i class="icon-pencil-case"> </i>
                    Restore Members 
                    <span style="padding:5px" class="badge badge-primary pull-right"> {{ count($trashMember) }} </span>
                </a>
            </li>
        @endif
    </ul>
    <!-- Sidebar Navidation Menus-->
</nav>