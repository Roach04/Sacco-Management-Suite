<!-- Side Navbar -->
<nav class="side-navbar">
    <!-- Sidebar Header-->
    <div class="sidebar-header d-flex align-items-center">
        @if(Auth::user()->role == 1)
            @foreach($users as $user)
                @if($user->role == 1)
                    <div class="avatar">
                        <img style="width:100%; height:60px" src="{{ $user->userPic }}" alt="Null" class="img-fluid rounded-circle">
                    </div>
                    <div class="title">
                        <h1 class="h4"> {{ $user->username }} </h1>
                        <p> {{ $user->jobTitle }} </p>
                    </div>
                @endif
            @endforeach
        @elseif(Auth::user()->role == 2)
            @foreach($users as $user)
                @if($user->role == 2)
                    <div class="avatar">
                        <img style="width:100%; height:60px" src="{{ $user->userPic }}" alt="Null" class="img-fluid rounded-circle">
                    </div>
                    <div class="title">
                        <h1 class="h4"> {{ $user->username }} </h1>
                        <p> {{ $user->jobTitle }} </p>
                    </div>
                @endif
            @endforeach
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
            <a href=" {{ route('createMember') }} "> 
                <i class="icon-user fa-lg"> </i>
                Create Members.
            </a>
        </li>
        <li>
            <a href="#dashvariants" aria-expanded="false" data-toggle="collapse"> 
                <i class="icon-interface-windows"></i>Accounts 
            </a>
            <ul id="dashvariants" class="collapse list-unstyled">
                <li> 
                    <a href=" {{ route('fixedAccount') }} "> 
                        <i class="fa fa-leaf fa-lg"> </i>
                        Fixed Accounts.
                    </a>
                </li>
                <li> 
                    <a href=" {{ route('savingsAccount') }} "> 
                        <i class="fa fa-cog fa-lg"> </i>
                        Savings Accounts.
                    </a>
                </li>
                <li> 
                    <a href=" {{ route('assetAccount') }} "> 
                        <i class="fa fa-key fa-lg"> </i>
                        Assets Accounts.
                    </a>
                </li>
            </ul>
        </li> 
        <li> 
            <a href=" {{ route('accountsReconcile') }} "> 
                <i class="icon-flask"> </i>
                Reconciliation.
            </a>
        </li>
    </ul>

    <span class="heading">Extras</span>

    <ul class="list-unstyled">
        @if(count($trash) && Auth::user()->role == 1)
            <li class="active"> 
                <a style="color:green" href=" {{ route('trashedAccounts') }} "> 
                    <i class="icon-bill"> </i>
                    Restore System Users. 
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
                <a style="color:#796AEE" href=" {{ route('trashedMembers') }} "> 
                    <i class="icon-pencil-case"> </i>
                    Restore Members 
                    <span style="padding:5px" class="badge badge-primary pull-right"> {{ count($trashMember) }} </span>
                </a>
            </li>
        @endif
    </ul>
    <!-- Sidebar Navidation Menus-->
</nav>