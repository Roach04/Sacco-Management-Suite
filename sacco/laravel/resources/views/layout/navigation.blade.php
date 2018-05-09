<!-- Main Navbar-->
<header class="header">
    <nav class="navbar">
        <!-- Search Box-->
        <div class="search-box">
            <button class="dismiss"><i class="icon-close"></i></button>
            <form id="searchForm" action="{{ route('memberAccount') }}" role="search">
                <input type="search" name="searchText" id="searchText" placeholder="What are you looking for..." class="form-control">
            </form>
        </div>
        <!-- Search Box-->
        <div class="container-fluid">
            <div class="navbar-holder d-flex align-items-center justify-content-between">
                <!-- Navbar Header-->
                <div class="navbar-header">
                    <!-- Navbar Brand -->
                    <a href="index.html" class="navbar-brand">
                    <div class="brand-text brand-big hidden-lg-down"><span>Sacco </span><strong>Management</strong></div>
                    <div class="brand-text brand-small"><strong>SM</strong></div></a>
                    <!-- Toggle Button-->
                    <a id="toggle-btn" href="#" class="menu-btn active"><span></span><span></span><span></span></a>
                </div>
                <!-- Navbar Menu -->
                <ul class="nav-menu list-unstyled d-flex flex-md-row align-items-md-center">
                    <!-- Search-->
                    <li class="nav-item d-flex align-items-center">
                        <a id="search" href="#"><i class="icon-search"></i></a>
                    </li>
                    <!-- Search-->

                    <!-- Trashed Users-->
                    @if(count($trash) && Auth::user()->role == 1)
                        <li class="nav-item dropdown"> 
                            <a id="notifications" rel="nofollow" data-target="#" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link"><i class="fa fa-trash"></i><span class="badge bg-green"> {{ count($trash) }} </span></a>
                            <ul aria-labelledby="notifications" class="dropdown-menu">
                                
                                @foreach($trash as $trashed)
                                <li>
                                    <a rel="nofollow" class="dropdown-item"> 
                                        <div class="notification">
                                            <div class="notification-content">
                                                <i class="fa fa-trash bg-green"></i>
                                                {{ $trashed->firstname }} | {{ $trashed->lastname }}
                                            </div>
                                            <div class="notification-time">
                                                <small>
                                                    &nbsp; {{ $trashed->created_at->formatlocalized('%a %d %b %y') }}
                                                </small>
                                            </div>
                                      </div>
                                    </a>
                                </li>
                                @endforeach

                                <li>
                                    <a rel="nofollow" href="{{ route('trashedAccounts') }}" class="dropdown-item all-notifications text-center"> 
                                        <strong>view all Trashed Users </strong>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    @endif
                    <!-- Trashed Users-->  


                    <!-- Matured Loans-->
                    @if(count($maturedLoan))
                        <li class="nav-item dropdown"> 
                            <a id="notifications" rel="nofollow" data-target="#" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link"><i class="icon-padnote"></i><span class="badge bg-orange"> {{ count($maturedLoan) }} </span></a>
                            <ul aria-labelledby="notifications" class="dropdown-menu">
                                
                                @foreach($maturedLoan as $loan)
                                <li>
                                    <a rel="nofollow" class="dropdown-item"> 
                                        <div class="notification">
                                            <div class="notification-content">
                                                <i class="icon-padnote bg-orange"></i>
                                                {{ $loan->member->firstname }} | {{ $loan->member->lastname }}
                                            </div>
                                            <div class="notification-time">
                                                <small style="font-size:12px; font-weight:bold">
                                                    &nbsp; Kes {{ number_format($loan->loan) }}
                                                </small>
                                            </div>
                                            <div class="notification-time">
                                                <small>
                                                    &nbsp; {{ $loan->created_at->formatlocalized('%a %d %b %y') }}
                                                </small>
                                            </div>
                                      </div>
                                    </a>
                                </li>
                                @endforeach

                                <li>
                                    <a rel="nofollow" href="{{ route('maturedLoans') }}" class="dropdown-item all-notifications text-center"> 
                                        <strong>view all Trashed Users </strong>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    @endif
                    <!-- Matured Loans-->

                    <!-- Default Loans-->
                    @if(count($defaultLoan))
                        <li class="nav-item dropdown"> 
                            <a id="notifications" rel="nofollow" data-target="#" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link"><i class="icon-check"></i><span class="badge bg-red"> {{ count($defaultLoan) }} </span></a>
                            <ul aria-labelledby="notifications" class="dropdown-menu">
                                
                                @foreach($defaultLoan as $loan)
                                <li>
                                    <a rel="nofollow" class="dropdown-item"> 
                                        <div class="notification">
                                            <div class="notification-content">
                                                <i class="icon-check bg-red"></i>
                                                {{ $loan->member->firstname }} | {{ $loan->member->lastname }}
                                            </div>
                                            <div class="notification-time">
                                                <small style="font-size:12px; font-weight:bold">
                                                    &nbsp; Kes {{ number_format($loan->loan) }}
                                                </small>
                                            </div>
                                            <div class="notification-time">
                                                <small>
                                                    &nbsp; {{ $loan->created_at->formatlocalized('%a %d %b %y') }}
                                                </small>
                                            </div>
                                      </div>
                                    </a>
                                </li>
                                @endforeach

                                <li>
                                    <a rel="nofollow" href="{{ route('defaultLoans') }}" class="dropdown-item all-notifications text-center"> 
                                        <strong>view all Trashed Users </strong>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    @endif
                    <!-- Default Loans-->  
                    

                    <!-- Trashed Members -->
                    @if(count($trashMember))
                        <li class="nav-item dropdown"> 
                            <a id="notifications" rel="nofollow" data-target="#" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link"><i class="fa fa-trash-o"></i><span class="badge bg-primary"> {{ count($trashMember) }} </span></a>
                            <ul aria-labelledby="notifications" class="dropdown-menu">
                                
                                @foreach($trashMember as $trashed)
                                <li>
                                    <a rel="nofollow" class="dropdown-item"> 
                                        <div class="notification">
                                            <div class="notification-content">
                                                <i class="fa fa-trash bg-violet"></i>
                                                {{ $trashed->firstname }} | {{ $trashed->lastname }}
                                            </div>
                                            <div class="notification-time">
                                                <small style="font-size:12px; color:#796AEE; font-weight:bold">
                                                    &nbsp; Trashed By | {{ $trashed->user->username }}
                                                </small>
                                            </div>
                                            <div class="notification-time">
                                                <small>
                                                    &nbsp; {{ $trashed->created_at->formatlocalized('%a %d %b %y') }}
                                                </small>
                                            </div>
                                      </div>
                                    </a>
                                </li>
                                @endforeach

                                <li>
                                    <a rel="nofollow" href="{{ route('trashedMembers') }}" class="dropdown-item all-notifications text-center"> 
                                        <strong>view all Trashed Members </strong>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    @endif
                    <!-- Trashed Members -->

                    <!-- All Notifications-->
                    @if(count($trash) || count($todday == $dueDate))
                    <li class="nav-item dropdown"> 
                        <a id="notifications" rel="nofollow" data-target="#" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link"><i class="fa fa-bell-o"></i><span style="color:grey" class="badge bg-yellow">{{ count(collect([$trash, $todday == $dueDate])) }}</span></a>
                        <ul aria-labelledby="notifications" class="dropdown-menu">
                            @if(count($trash) && Auth::user()->role == 1)
                                @foreach($trash as $trashed)
                                    <li>
                                        <a rel="nofollow" href="#" class="dropdown-item"> 
                                            <div class="notification">
                                                <div class="notification-content"><i class="fa fa-trash bg-green"></i>You have <span style="color:#54e69d; font-weight:bold">{{ count($trash) }} </span> Trashed User </div>
                                                <div class="notification-time"><small> &nbsp; {{ $trashed->created_at->formatlocalized('%a %d %b %y') }}</small></div>
                                            </div>
                                        </a>
                                    </li>
                                @endforeach
                            @endif
                            <!-- <li>
                                <a rel="nofollow" href="#" class="dropdown-item"> 
                                    <div class="notification">
                                        <div class="notification-content"><i class="fa fa-twitter bg-blue"></i>You have 2 followers</div>
                                        <div class="notification-time"><small>4 minutes ago</small></div>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a rel="nofollow" href="#" class="dropdown-item"> 
                                    <div class="notification">
                                        <div class="notification-content"><i class="fa fa-upload bg-orange"></i>Server Rebooted</div>
                                        <div class="notification-time"><small>4 minutes ago</small></div>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a rel="nofollow" href="#" class="dropdown-item"> 
                                    <div class="notification">
                                        <div class="notification-content"><i class="fa fa-twitter bg-blue"></i>You have 2 followers</div>
                                        <div class="notification-time"><small>10 minutes ago</small></div>
                                  </div>
                                </a>
                            </li>
                            <a rel="nofollow" href="#" class="dropdown-item all-notifications text-center"> <strong>view all notifications                                            </strong></a></li> -->
                        </ul>
                    </li>
                    @endif
                    <!-- All Notifications-->

                    <!-- Logout -->
                    <li class="nav-item">
                        <a href=" {{ route('logout') }} " class="nav-link logout">
                            Logout<i class="fa fa-sign-out"></i>
                        </a>
                    </li>
                    <!-- Logout -->
                </ul>
            </div>
        </div>
    </nav>
</header>