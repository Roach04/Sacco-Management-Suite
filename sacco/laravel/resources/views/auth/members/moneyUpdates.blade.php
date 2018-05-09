@extends('layout.master')

@section('content')

<div class="page charts-page">

	@include('layout.navigation')

  	<div class="page-content d-flex align-items-stretch"> 
        <div style="width:100%">
          	<!-- Page Header-->
         	<header class="page-header">
	            <div class="container-fluid">
	              <h2 class="no-margin-bottom">System Users</h2>
	            </div>
          	</header>
          	<!-- Page Header-->

          	<!-- Breadcrumb-->
          	<ul class="breadcrumb">
            	<div class="container-fluid">
              		<li class="breadcrumb-item">
	              		<a href=" {{ route('dashboard') }} ">
	              			Home
	              		</a>
              		</li>
              		<li class="breadcrumb-item active">
	              		<a href=" {{ route('memberAccount') }} ">
	              			Member Accounts
	              		</a>
              		</li>
              		<li class="breadcrumb-item active">
	              		Member Account Updates
              		</li>
              		@if(count($accounts))
              			<div class="pull-right">
			                <span style="color: grey"> Latest Update &nbsp; </span> 
			                <span style="color:#796AEE; font:normal 18px book antiqua"> 
			                    {{ $last }}
			                </span>
			                <span style="color:black"> &nbsp;&nbsp; | &nbsp;&nbsp; </span>
			                <span style="color:grey"> Cash &nbsp; </span> 
			                <span style="color:#796AEE; font:normal 18px book antiqua"> 
			                    {{ number_format($cash, 2) }}
			                </span>
			            </div>
              		@else
              			<div class="pull-right">
			                <span style="color: grey"> Today &nbsp; </span> 
			                <span style="color:#796AEE; font:normal 18px book antiqua"> 
			                    {{$today}}
			                    <span style="color:black"> | </span>
			                    {{ $currenttime }}
			                </span>
			                
			            </div>
              		@endif
            	</div>
          	</ul>
          	<!-- Breadcrumb-->

          	<br><br>
          	@if(count($accounts))
          	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding:30px"> 
                <table style="text-align:center; width:100%" class="tea table-hover table-bordered">
                	<thead>
                		<tr>
                			<th style="text-align:center"> Id </th>
                			<th style="text-align:center"> Firstname </span> </th>
                			<th style="text-align:center"> Surname </span> </th>
                			<th style="text-align:center"> Lastname </th>
                			<th style="text-align:center"> Credit Account </th>
                			<th style="text-align:center"> Created At </th>
                			<th style="text-align:center"> Updated At </th>
                			<th style="text-align:center"> Inserted By </th>
                			<th style="text-align:center"> Changes </th>
                		</tr>
                	</thead>
                	@foreach($accounts as $account)
	                	<tbody>
	                		<tr>
	                			<td>{{ $account->id }}</td>
	                			<td>{{ $account->member->firstname }}</td>
	                			<td>{{ $account->member->surname }}</td>
	                			<td>{{ $account->member->lastname }}</td>
	                			<td>{{ number_format($account->money, 0) }}</td>
	                			<td>{{ Carbon\Carbon::createFromTimestamp(strtotime($account->created_at))->diffForHumans() }}</td>
	                			<td>{{ $account->updated_at->formatlocalized('%a %d %b %y') }}</td>
	                			<td>
	                				@if($account->member->user_id == $account->member->user->id)
	                					{{ $account->member->user->lastname }}
	                				@else
	                					Null
	                				@endif
	                			</td>
	                			<td>
	                				<a data-memberId=" {{ $account->member_id }} " data-id="{{ $account->id }}" data-credit="{{ $account->money }}" href="#moneyupdatemodal" data-toggle="modal" class="modal-money-update btn btn-info btn-block"> 
	                					<i class="fa fa-fire"> </i>
	                					Edit 
	                				</a>
	                			</td>
	                		</tr>
	                	</tbody>
                	@endforeach
                </table>
            </div>
            {!! $accounts->render() !!}
            @else
            	<p style="color:red; font-size:24px; padding-left:30px"> There Are No Account Records At This Time. </p>
            @endif

            <!-- Page Footer-->
	      	<footer class="main-footer">
	        	<div class="container-fluid">
	              	<div class="row">
	                	<div class="col-sm-6">
	                  		<p>Paa Tech. &copy; <?php  echo date("Y")?> </p>
	                	</div>
		                <div class="col-sm-6 text-right">
		                  	<p>Powered by <a href="https://paatech.co.ke" class="external">Paa Tech.</a></p>
		                </div>
	              	</div>
	            </div>
	      	</footer>
	      	<!-- Page Footer-->
        </div>
    </div>
</div>

@include('modals.moneyUpdateModal')

@stop