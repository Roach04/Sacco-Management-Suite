<!-- Side Navbar -->
<nav class="side-navbar">
    <!-- Sidebar Header-->
    <div class="sidebar-header d-flex align-items-center">
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
            <a href=" {{ route('reconcileCoopMarch') }} "> 
                <i class="icon-picture"> </i>
                March
            </a>
        </li>
        <li> 
            <a href=" {{ route('reconcileCoopApril') }} "> 
                <i class="icon-interface-windows"> </i>
                April
            </a>
        </li>
        <!-- <li> 
            <a href=" {{ route('reconcileTwelve') }} "> 
                <i class="icon-page"> </i>
                May
            </a>
        </li> -->
    </ul>

    <span class="heading">Extras</span>

    <ul class="list-unstyled">
        @if(count($trash))
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