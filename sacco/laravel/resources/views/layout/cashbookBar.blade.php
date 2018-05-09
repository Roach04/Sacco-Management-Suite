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
            <a href="#reconciliation" aria-expanded="false" data-toggle="collapse"> 
                <i class="icon-presentation"></i>Reconciliation
            </a>
            <ul id="reconciliation" class="collapse list-unstyled">
                <li>
                    <a href="{{ route('saccoCoopReconcile') }}">
                        <i class="icon-screen"> </i>
                        Co - op Bank.
                    </a>
                </li>
                <li>
                    <a href="{{ route('saccoEquityReconcile') }}">
                        <i class="icon-rss-feed"></i>
                        Equity Bank.
                    </a>
                </li>
                <li>
                    <a href="{{ route('saccoPettycashReconcile') }}">
                        <i class="icon-interface-windows"></i>
                        Petty Cash.
                    </a>
                </li>
            </ul>
        </li>
        <li> 
            <a href=" {{ route('createCashbook') }} "> 
                <i class="icon-user"> </i>
                Create Cashbook.
            </a>
        </li>
        <li>
            <a href="#cashbooks" aria-expanded="false" data-toggle="collapse"> 
                <i class="icon-interface-windows"></i>Cash Books 
            </a>
            <ul id="cashbooks" class="collapse list-unstyled">
                <li>
                    <a href="{{ route('coopCashbook') }}">
                        <i class="icon-screen"> </i>
                        Co - op Bank.
                    </a>
                </li>
                <li>
                    <a href="{{ route('equityCashbook') }}">
                        <i class="icon-rss-feed"></i>
                        Equity Bank.
                    </a>
                </li>
                <li>
                    <a href="{{ route('pettyCashbook') }}">
                        <i class="icon-interface-windows"></i>
                        Petty Cash.
                    </a>
                </li>
            </ul>
        </li>
        <li> 
            <a href=" {{ route('showSavings', [Auth::user()->id]) }} "> 
                <i class="fa fa-money fa-lg"> </i>
                Sacco Savings.
            </a>
        </li>
        <li> 
            <a href=" {{ route('chartAccounts') }} "> 
                <i class="icon-page"> </i>
                Chart of Accounts.
            </a>
        </li>
        <li>
            <a href="#dashvariants" aria-expanded="false" data-toggle="collapse"> 
                <i class="icon-screen"></i>Reports 
            </a>
            <ul id="dashvariants" class="collapse list-unstyled">
                <li>
                    <a href="{{ route('profitLoss') }}">
                        <i class="icon-pencil-case"></i>
                        Profit & Loss
                    </a>
                </li>
                <li>
                    <a href="{{ route('balanceSheet') }}">
                        <i class="icon-ios-email-outline"></i>
                        Balance Sheet
                    </a>
                </li>
                <li> 
                    <a href="{{ route('trialBalance') }}">
                        <i class="icon-bars"></i> Trial Balance
                    </a>
                </li>
            </ul>
        </li>
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