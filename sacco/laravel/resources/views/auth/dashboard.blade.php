@extends('layout.master')

@section('content')
	
<div class="page home-page">

  	<!-- Main Navbar-->
  	@include('layout.navigation')
  	<!-- Main Navbar-->

    <div class="page-content d-flex align-items-stretch">

        <!-- Side Navbar -->
        @include('layout.dashboardBar')
        <!-- Side Navbar -->

        <div class="content-inner">

          	<!-- Page Header-->
          	<header class="page-header">
            	<div class="container-fluid">
              		<h2 class="no-margin-bottom">Dashboard</h2>
            	</div>
          	</header>
          	<!-- Page Header-->           

          	<!-- Dashboard Counts Section-->
          	<section class="dashboard-counts no-padding-bottom">
            	<div class="container-fluid">
              		<div class="row bg-white has-shadow">

		                <!-- Item -->
		                <div class="col-xl-3 col-sm-6">
		                  	<div class="item d-flex align-items-center">
		                    	<div class="icon bg-green">
		                    		<i class="icon-user"></i>
		                    	</div>
			                    <div class="title">
			                    	<span>System<br>Accounts</span>
				                    <div class="progress">
				                    	<div role="progressbar" style="width: 25%; height: 4px;" aria-valuenow="95" aria-valuemin="0" aria-valuemax="100" class="progress-bar bg-green">
				                        </div>
				                    </div>
			                    </div>
			                    <div class="number">
			                    	<strong> {{ $users->count() }} </strong>
			                    </div>
		                  	</div>
		                </div>
	                	<!-- Item -->

	                	<!-- Item -->
		                <div class="col-xl-3 col-sm-6">
		                  	<div class="item d-flex align-items-center">
		                    	<div class="icon bg-violet">
		                    		<i class="icon-bill"></i>
		                    	</div>
		                    	<div class="title">
		                    		<span>Sacco<br>Members</span>
		                      		<div class="progress">
			                        	<div role="progressbar" style="width: 25%; height: 4px;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" class="progress-bar bg-violet">
			                        	</div>
		                      		</div>
		                    	</div>
		                    	<div class="number">
		                    		<strong> {{ $members->count() }}</strong>
		                    	</div>
		                  	</div>
		                </div>
                		<!-- Item -->

		                <div class="col-xl-3 col-sm-6">
		                  	<div class="item d-flex align-items-center">
		                    	<div class="icon bg-orange">
		                    		<i class="icon-padnote"></i>
		                    	</div>
		                    	<div class="title">
		                    		<span>Mature<br>Loans</span>
		                      		<div class="progress">
			                        	<div role="progressbar" style="width: 25%; height: 4px;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" class="progress-bar bg-orange">
			                        	</div>
		                      		</div>
		                    	</div>
			                    <div class="number">
			                    	<strong> {{ $maturedLoan->count() }} </strong>
			                    </div>
		                  	</div>
		                </div>

		                <div class="col-xl-3 col-sm-6">
		                  	<div class="item d-flex align-items-center">
		                    	<div class="icon bg-red">
		                    		<i class="icon-check"></i>
		                    	</div>
		                    	<div class="title">
		                    		<span>Loan<br>Defaulters</span>
			                      	<div class="progress">
			                        	<div role="progressbar" style="width: 25%; height: 4px;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" class="progress-bar bg-red">
			                        	</div>
			                      	</div>
		                    	</div>
		                    	<div class="number">
		                    		<strong> {{ count($defaultLoan) }} </strong>
		                    	</div>
		                  	</div>
		                </div>
              		</div>
            	</div>
          	</section>
          <!-- Dashboard Header Section    -->

          	<section class="dashboard-header">
            	<div class="container-fluid">
              		<div class="row">

		                <!-- Statistics -->
		                <div class="statistics col-lg-3 col-12">
		                  	<div class="statistic d-flex align-items-center bg-white has-shadow">
		                    	<div class="icon bg-green">
		                    		<i class="fa fa-tasks"></i>
		                    	</div>
		                    	<div class="text">
		                    		<strong>{{ number_format($sumdebit - $sumcredit, 2) }}</strong><br><small>Sacco Account.</small>
		                    	</div>
		                  	</div>
		                  	<div class="statistic d-flex align-items-center bg-white has-shadow">
		                    	<div class="icon bg-violet">
		                    		<i class="fa fa-calendar-o"></i>
		                    	</div>
		                    	<div class="text">
		                    		<strong>{{ number_format($money, 2) }}</strong><br><small>Members' Deposits.</small>
		                    	</div>
		                  	</div>
		                  	<div class="statistic d-flex align-items-center bg-white has-shadow">
		                    	<div class="icon bg-orange">
		                    		<i class="fa fa-paper-plane-o"></i>
		                    	</div>
		                    	<div class="text">
		                    		<strong>{{ number_format($disbursed, 2) }}</strong><br><small>Loans' Disbursed.</small>
		                    	</div>
		                  	</div>
		                </div>
		                <!-- Statistics -->

		                <!-- Line Chart -->
		                <div class="chart col-lg-6 col-12">
		                  	<div class="line-chart bg-white d-flex align-items-center justify-content-center has-shadow">
		                    	<canvas id="lineChartMemberRegistration"></canvas>
		                  	</div>
		                </div>
		                <!-- Line Chart -->

		                <div class="chart col-lg-3 col-12">
		                  	<!-- Bar Chart -->
		                  	<a href="{{ route('membersJson') }}"> Members</a> 
		                  	<div class="bar-chart has-shadow bg-white">
		                    	<div class="title">
		                    		<strong class="text-violet">Member Deposits</strong><br>
		                    		<small><?php  echo date("Y")?></small> 
		                    	</div>
		                    	<canvas id="barChartMemberDeposits"></canvas>
		                  	</div>
		                  	<!-- Bar Chart -->

		                  	<!-- Numbers-->
		                  	<div class="statistic d-flex align-items-center bg-white has-shadow">
		                    	<div class="icon bg-violet">
		                    		<i class="fa fa-line-chart"></i>
		                    	</div>
		                    	<div class="text">
		                    		<strong id="percentage"></strong><br><small>Active Members</small>
		                    	</div>
		                  	</div>
		                  	<!-- Numbers-->
		                </div>
              		</div>
            	</div>
          	</section>


          	<!-- Charts Sacco-->
          	<section class="charts">
	            <div class="container-fluid">
	              	<div class="row">
	                	<!-- Line Charts-->
		                <div class="col-lg-8">
		                  	<div class="line-chart-example card">
		                    	<div class="card-close">
		                      		<div class="dropdown">
		                        		<button type="button" id="closeCard" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-toggle"><i class="fa fa-ellipsis-v"></i></button>
			                        	<div aria-labelledby="closeCard" class="dropdown-menu has-shadow">
			                        		<a href="#" class="dropdown-item remove"> 
			                        			<i class="fa fa-times"></i>Close
			                        		</a>
			                        		<a href="#" class="dropdown-item edit"> 
			                        			<i class="fa fa-gear"></i>Edit
			                        		</a>
			                        	</div>
		                      		</div>
		                    	</div>
			                    <div class="card-header d-flex align-items-center">
			                      	<h3 class="h4">Sacco's Account</h3>
			                    </div>
			                    <div class="card-body">
			                      	<canvas id="lineChartExample"></canvas>
			                    </div>
		                  	</div>
		                </div>
		                <!-- <a href="{{route('savingsJson')}}"> Sacco Savings In Json Format.</a> -->
		                <div class="col-lg-4">
		                  	<div class="line-chart-example card no-margin-bottom">
		                    	<div class="card-close">
		                      		<div class="dropdown">
		                        		<button type="button" id="closeCard" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-toggle"><i class="fa fa-ellipsis-v"></i></button>
				                        <div aria-labelledby="closeCard" class="dropdown-menu has-shadow">
				                        	<a href="#" class="dropdown-item remove"> 
				                        		<i class="fa fa-times"></i>Close
				                        	</a>
				                        	<a href="#" class="dropdown-item edit"> 
				                        		<i class="fa fa-gear"></i>Edit
				                        	</a>
				                        </div>
		                      		</div>
		                    	</div>
			                    <div class="card-header d-flex align-items-center">
			                      	<h3 class="h4">Credit & Debit</h3>
			                    </div>
			                    <div class="card-body">
			                      	<canvas id="lineChartExample1"></canvas>
			                    </div>
		                  	</div>
			                <div class="line-chart-example card">
			                    <!-- <div class="card-close">
			                      	<div class="dropdown">
			                        	<button type="button" id="closeCard" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-toggle"><i class="fa fa-ellipsis-v"></i></button>
				                        <div aria-labelledby="closeCard" class="dropdown-menu has-shadow">
				                        	<a href="#" class="dropdown-item remove"> 
				                        		<i class="fa fa-times"></i>Close
				                        	</a>
				                        	<a href="#" class="dropdown-item edit"> 
				                        		<i class="fa fa-gear"></i>Edit
				                        	</a>
				                        </div>
			                      	</div>
			                    </div> -->
			                    <div class="card-body">
			                      	<canvas id="lineChartExample2"></canvas>
			                    </div>
			                </div>
	                	</div>
	                	<!--Line Charts-->
		            </div>
		        </div>
		    </section>
		    <!-- Charts Sacco-->


          	<!-- Projects Section
          	<section class="projects no-padding-top">
            	<div class="container-fluid">
              	
	              	<!-- Project
	              	<div class="project">
	                	<div class="row bg-white has-shadow">
	                  		<div class="left-col col-lg-6 d-flex align-items-center justify-content-between">
	                    		<div class="project-title d-flex align-items-center">
	                      			<div class="image has-shadow">
	                      				<img src="img/project-1.jpg" alt="..." class="img-fluid">
	                      			</div>
	                      			<div class="text">
		                        		<h3 class="h4">Project Title</h3><small>Lorem Ipsum Dolor</small>
		                      		</div>
	                    		</div>
	                    		<div class="project-date">
	                    			<span class="hidden-sm-down">Today at 4:24 AM</span>
	                    		</div>
	                  		</div>
	                  		<div class="right-col col-lg-6 d-flex align-items-center">
	                    		<div class="time">
	                    			<i class="fa fa-clock-o"></i>12:00 PM 
	                    		</div>
	                    		<div class="comments">
	                    			<i class="fa fa-comment-o"></i>20
	                    		</div>
			                    <div class="project-progress">
			                      	<div class="progress">
			                        	<div role="progressbar" style="width: 45%; height: 6px;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" class="progress-bar bg-red">
			                        	</div>
			                      	</div>
			                    </div>
	                  		</div>
	                	</div>
	              	</div>

	              	<!-- Project

	              	<div class="project">
	                	<div class="row bg-white has-shadow">
	                  		<div class="left-col col-lg-6 d-flex align-items-center justify-content-between">
	                    		<div class="project-title d-flex align-items-center">
	                      			<div class="image has-shadow">
	                      				<img src="img/project-2.jpg" alt="..." class="img-fluid">
	                      			</div>
			                      	<div class="text">
			                        	<h3 class="h4">Project Title</h3><small>Lorem Ipsum Dolor</small>
			                      	</div>
	                    		</div>
	                    		<div class="project-date">
	                    			<span class="hidden-sm-down">Today at 4:24 AM</span>
	                    		</div>
	                  		</div>
		                  	<div class="right-col col-lg-6 d-flex align-items-center">
		                    	<div class="time">
		                    		<i class="fa fa-clock-o"></i>12:00 PM 
		                    	</div>
		                    	<div class="comments">
		                    		<i class="fa fa-comment-o"></i>20
		                    	</div>
			                    <div class="project-progress">
			                      	<div class="progress">
			                        	<div role="progressbar" style="width: 60%; height: 6px;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" class="progress-bar bg-green">
			                        	</div>
			                      	</div>
			                    </div>
		                  	</div>
	                	</div>
	              	</div>

	              	<!-- Project

	              	<div class="project">
	                	<div class="row bg-white has-shadow">
	                  		<div class="left-col col-lg-6 d-flex align-items-center justify-content-between">
	                    		<div class="project-title d-flex align-items-center">
	                      			<div class="image has-shadow">
	                      				<img src="img/project-3.jpg" alt="..." class="img-fluid">
	                      			</div>
			                      	<div class="text">
			                        	<h3 class="h4">Project Title</h3><small>Lorem Ipsum Dolor</small>
			                      	</div>
	                    		</div>
	                    		<div class="project-date">
	                    			<span class="hidden-sm-down">Today at 4:24 AM</span>
	                    		</div>
	                  		</div>
		                  	<div class="right-col col-lg-6 d-flex align-items-center">
		                    	<div class="time">
		                    		<i class="fa fa-clock-o"></i>12:00 PM 
		                    	</div>
		                    	<div class="comments">
		                    		<i class="fa fa-comment-o"></i>20
		                    	</div>
			                    <div class="project-progress">
			                      	<div class="progress">
			                        	<div role="progressbar" style="width: 50%; height: 6px;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" class="progress-bar bg-violet">
			                        	</div>
			                      	</div>
			                    </div>
		                  	</div>
	                	</div>
	              	</div>

	              	<!-- Project

	              	<div class="project">
	                	<div class="row bg-white has-shadow">
	                  		<div class="left-col col-lg-6 d-flex align-items-center justify-content-between">
	                    		<div class="project-title d-flex align-items-center">
	                      			<div class="image has-shadow">
	                      				<img src="img/project-4.jpg" alt="..." class="img-fluid">
	                      			</div>
			                      	<div class="text">
			                        	<h3 class="h4">Project Title</h3><small>Lorem Ipsum Dolor</small>
			                      	</div>
	                    		</div>
	                    		<div class="project-date">
	                    			<span class="hidden-sm-down">Today at 4:24 AM</span>
	                    		</div>
	                  		</div>
	                  		<div class="right-col col-lg-6 d-flex align-items-center">
	                    		<div class="time">
	                    			<i class="fa fa-clock-o"></i>12:00 PM 
	                    		</div>
	                    		<div class="comments">
	                    			<i class="fa fa-comment-o"></i>20
	                    		</div>
			                    <div class="project-progress">
			                      	<div class="progress">
			                        	<div role="progressbar" style="width: 50%; height: 6px;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" class="progress-bar bg-orange">
			                        	</div>
			                      	</div>
			                    </div>
	                  		</div>
	                	</div>
	              	</div>
            	</div>
          	</section>
          	<!-- Projects Section-->

          	<!-- Client Section
          	<section class="client no-padding-top">
            	<div class="container-fluid">
              		<div class="row">
                	
                		<!-- Work Amount  
                		<div class="col-lg-4">
                  			<div class="work-amount card">
			                    <div class="card-close">
			                      	<div class="dropdown">
			                        	<button type="button" id="closeCard" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-toggle"><i class="fa fa-ellipsis-v"></i></button>
			                        	<div aria-labelledby="closeCard" class="dropdown-menu has-shadow">
			                        		<a href="#" class="dropdown-item remove"> 
			                        			<i class="fa fa-times"></i>Close
			                        		</a>
			                        		<a href="#" class="dropdown-item edit"> 
			                        			<i class="fa fa-gear"></i>Edit
			                        		</a>
			                        	</div>
			                      	</div>
			                    </div>
			                    <div class="card-body">
			                      	<h3>Work Hours</h3><small>Lorem ipsum dolor sit amet.</small>
			                      	<div class="chart text-center">
			                        	<div class="text">
			                        		<strong>90</strong><br><span>Hours</span>
			                        	</div>
			                        	<canvas id="pieChart"></canvas>
			                      	</div>
			                    </div>
                  			</div>
                		</div>
                		<!-- Work Amount  

                		<!-- Client Profile 
                		<div class="col-lg-4">
                  			<div class="client card">
                    			<div class="card-close">
		                     		<div class="dropdown">
		                        		<button type="button" id="closeCard" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-toggle"><i class="fa fa-ellipsis-v"></i></button>
		                        		<div aria-labelledby="closeCard" class="dropdown-menu has-shadow">
		                        			<a href="#" class="dropdown-item remove"> 
		                        				<i class="fa fa-times"></i>Close
		                        			</a>
		                        			<a href="#" class="dropdown-item edit"> 
		                        				<i class="fa fa-gear"></i>Edit
		                        			</a>
		                        		</div>
		                      		</div>
                    			</div>
			                    <div class="card-body text-center">
			                      	<div class="client-avatar">
			                      		<img src="img/avatar-2.jpg" alt="..." class="img-fluid rounded-circle">
			                        	<div class="status bg-green"></div>
			                      	</div>
			                      	<div class="client-title">
			                        	<h3>Jason Doe</h3><span>Web Developer</span><a href="#">Follow</a>
			                      	</div>
			                      	<div class="client-info">
				                        <div class="row">
				                          	<div class="col-4"><strong>20</strong><br><small>Photos</small></div>
				                          	<div class="col-4"><strong>54</strong><br><small>Videos</small></div>
				                          	<div class="col-4"><strong>235</strong><br><small>Tasks</small></div>
				                        </div>
			                      	</div>
			                      	<div class="client-social d-flex justify-content-between">
			                      		<a href="#" target="_blank">
			                      			<i class="fa fa-facebook"></i>
			                      		</a>
			                      		<a href="#" target="_blank">
			                      			<i class="fa fa-twitter"></i>
			                      		</a>
			                      		<a href="#" target="_blank">
			                      			<i class="fa fa-google-plus"></i>
			                      		</a>
			                      		<a href="#" target="_blank">
			                      			<i class="fa fa-instagram"></i>
			                      		</a>
			                      		<a href="#" target="_blank">
			                      			<i class="fa fa-linkedin"></i>
			                      		</a>
			                      	</div>
			                    </div>
                  			</div>
                		</div>
                		<!-- Client Profile 

		                <!-- Total Overdue 
		                <div class="col-lg-4">
		                  	<div class="overdue card">
		                    	<div class="card-close">
		                      		<div class="dropdown">
		                        		<button type="button" id="closeCard" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-toggle"><i class="fa fa-ellipsis-v"></i></button>
		                        		<div aria-labelledby="closeCard" class="dropdown-menu has-shadow">
			                        		<a href="#" class="dropdown-item remove"> 
			                        			<i class="fa fa-times"></i>Close
			                        		</a>
			                        		<a href="#" class="dropdown-item edit"> 
			                        			<i class="fa fa-gear"></i>Edit
			                        		</a>
		                        		</div>
		                      		</div>
		                    	</div>
			                    <div class="card-body">
			                      	<h3>Total Overdue</h3><small>Lorem ipsum dolor sit amet.</small>
			                      	<div class="number text-center">$20,000</div>
			                      	<div class="chart">
			                        	<canvas id="lineChart1"></canvas>
			                      	</div>
			                    </div>
		                  	</div>
		                </div>
		                <!-- Total Overdue 

              		</div>
            	</div>
          	</section>
          	<!-- Client Section-->

          	<!-- Feeds Section
          	<section class="feeds no-padding-top">
            	<div class="container-fluid">
              		<div class="row">
                		
                		<!-- Trending Articles
                		<div class="col-lg-6">
                  			<div class="articles card">
			                    <div class="card-close">
			                      	<div class="dropdown">
			                        	<button type="button" id="closeCard" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-toggle"><i class="fa fa-ellipsis-v"></i></button>
			                        	<div aria-labelledby="closeCard" class="dropdown-menu has-shadow">
			                        		<a href="#" class="dropdown-item remove"> 
			                        			<i class="fa fa-times"></i>Close
			                        		</a>
			                        		<a href="#" class="dropdown-item edit"> 
			                        			<i class="fa fa-gear"></i>Edit
			                        		</a>
			                        	</div>
			                      	</div>
			                    </div>
			                    <div class="card-header d-flex align-items-center">
			                      	<h2 class="h3">Trending Articles </h2>
			                      	<div class="badge badge-rounded bg-green">4 New</div>
			                    </div>
                    			<div class="card-body no-padding">
		                      		<div class="item d-flex align-items-center">
		                        		<div class="image">
		                        			<img src="img/avatar-1.jpg" alt="..." class="img-fluid rounded-circle">
		                        		</div>
		                        		<div class="text">
		                        			<a href="#">
		                            			<h3 class="h5">Lorem Ipsum Dolor</h3>
		                            		</a>
		                            		<small>Posted on 5th June 2017 by Aria Smith.</small>
		                            	</div>
		                      		</div>
			                      	<div class="item d-flex align-items-center">
			                        	<div class="image">
			                        		<img src="img/avatar-2.jpg" alt="..." class="img-fluid rounded-circle">
			                        	</div>
			                        	<div class="text">
			                        		<a href="#">
			                            		<h3 class="h5">Lorem Ipsum Dolor</h3>
			                            	</a>
			                            	<small>Posted on 5th June 2017 by Frank Williams.</small>
			                            </div>
			                      	</div>
			                      	<div class="item d-flex align-items-center">
			                        	<div class="image">
			                        		<img src="img/avatar-3.jpg" alt="..." class="img-fluid rounded-circle">
			                        	</div>
			                        	<div class="text">
			                        		<a href="#">
			                            		<h3 class="h5">Lorem Ipsum Dolor</h3>
			                            	</a><small>Posted on 5th June 2017 by Ashley Wood.</small>
			                            </div>
			                      	</div>
			                      	<div class="item d-flex align-items-center">
			                        	<div class="image">
			                        		<img src="img/avatar-4.jpg" alt="..." class="img-fluid rounded-circle">
			                        	</div>
			                        	<div class="text">
			                        		<a href="#">
			                            		<h3 class="h5">Lorem Ipsum Dolor</h3>
			                            	</a><small>Posted on 5th June 2017 by Jason Doe.</small>
			                            </div>
			                      	</div>
			                     	<div class="item d-flex align-items-center">
			                        	<div class="image">
			                        		<img src="img/avatar-5.jpg" alt="..." class="img-fluid rounded-circle">
			                        	</div>
			                        	<div class="text">
			                        		<a href="#">
			                            		<h3 class="h5">Lorem Ipsum Dolor</h3>
			                            	</a><small>Posted on 5th June 2017 by Sam Martinez.</small>
			                            </div>
			                      	</div>
                    			</div>
                  			</div>
                		</div>
                		<!-- Trending Articles-->

		                <!-- Check List 
		                <div class="col-lg-6">
		                  	<div class="checklist card">
		                    	<div class="card-close">
		                      		<div class="dropdown">
		                        		<button type="button" id="closeCard" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-toggle"><i class="fa fa-ellipsis-v"></i></button>
		                        		<div aria-labelledby="closeCard" class="dropdown-menu has-shadow">
		                        			<a href="#" class="dropdown-item remove"> 
		                        				<i class="fa fa-times"></i>Close
		                        			</a>
		                        			<a href="#" class="dropdown-item edit"> 
		                        				<i class="fa fa-gear"></i>Edit
		                        			</a>
		                        		</div>
		                      		</div>
		                    	</div>
			                    <div class="card-header d-flex align-items-center">           
			                    	<h2 class="h3">To Do List </h2>
			                    </div>
		                    	<div class="card-body no-padding">
		                      		<div class="item d-flex">
		                        		<input type="checkbox" id="input-1" name="input-1" class="checkbox-template">
		                        		<label for="input-1">Lorem ipsum dolor sit amet, consectetur adipisicing elit.</label>
		                      		</div>
			                      	<div class="item d-flex">
			                        	<input type="checkbox" id="input-2" name="input-2" class="checkbox-template">
			                        	<label for="input-2">Lorem ipsum dolor sit amet, consectetur adipisicing elit.</label>
			                      	</div>
			                      	<div class="item d-flex">
			                        	<input type="checkbox" id="input-3" name="input-3" class="checkbox-template">
			                        	<label for="input-3">Lorem ipsum dolor sit amet, consectetur adipisicing elit.</label>
			                      	</div>
			                      	<div class="item d-flex">
			                        	<input type="checkbox" id="input-4" name="input-4" class="checkbox-template">
			                        	<label for="input-4">Lorem ipsum dolor sit amet, consectetur adipisicing elit.</label>
			                      	</div>
			                      	<div class="item d-flex">
			                        	<input type="checkbox" id="input-5" name="input-5" class="checkbox-template">
			                        	<label for="input-5">Lorem ipsum dolor sit amet, consectetur adipisicing elit.</label>
			                      	</div>
			                      	<div class="item d-flex">
			                        	<input type="checkbox" id="input-6" name="input-6" class="checkbox-template">
			                        	<label for="input-6">Lorem ipsum dolor sit amet, consectetur adipisicing elit.</label>
			                      	</div>
		                    	</div>
		                  	</div>
		                </div>
		                <!-- Check List 
              		</div>
            	</div>
          	</section>
          	<!-- Feeds Section-->

          	<!-- Updates Section -->
          	<section class="updates no-padding-top">
            	<div class="container-fluid">
              		<div class="row">
                		
                		<!-- Guarantors -->
                		<div class="col-lg-4">
                  			<div class="daily-feeds card"> 
                    			<div class="card-close">
			                    	<div class="dropdown">
			                        	<button type="button" id="closeCard" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-toggle"><i class="fa fa-ellipsis-v"></i></button>
			                        	<div aria-labelledby="closeCard" class="dropdown-menu has-shadow">
			                        		<a href="#" class="dropdown-item remove"> 
			                        			<i class="fa fa-times"></i>Close
			                        		</a>
			                        		<a href="#" class="dropdown-item edit"> 
			                        			<i class="fa fa-gear"></i>Edit
			                        		</a>
			                        	</div>
			                      	</div>
                    			</div>
			                    <div class="card-header">
			                      	<h3 class="h4">Guarantors</h3>
			                    </div>
                    			<div class="card-body no-padding">
			                      
			                      	<!-- Item-->
			                      	@foreach($guarantors as $guarantor)
			                      	<div class="item">
			                        	<div class="feed d-flex justify-content-between">
			                          		<div class="feed-body d-flex justify-content-between">
			                          			<a href="#" class="feed-profile">
			                          				<img src="{{$guarantor->memberPic}}" alt="person" class="img-fluid rounded-circle">
			                          			</a>
					                            <div class="content">
					                              	<h4>
					                              		{{ $guarantor->firstname }} {{ $guarantor->lastname }}
					                              	</h4> 
					                              	<p>Acc No: {{ $guarantor->accountNumber }} </p>
					                              	<div style="font:bold 16px book antiqua">
					                              		<strong>
					                              			KES {{ number_format($guarantor->guarantorMoney) }}
					                              		</strong>
					                              	</div>
					                            </div>
			                          		</div>
			                          		<div class="date text-right"><small>{{ $guarantor->created_at->formatLocalized('%a %d %b %y') }}</small></div>
			                        	</div>
			                      	</div>
			                      	@endforeach
			                      	<!-- Item-->
                    			</div>
                  			</div>
                		</div>
                		<!-- Guarantors -->

                		<!-- Debits-->
                		<div class="col-lg-4">
                  			<div class="recent-updates card">
			                    <div class="card-close">
			                      	<div class="dropdown">
			                        	<button type="button" id="closeCard" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-toggle"><i class="fa fa-ellipsis-v"></i></button>
			                        	<div aria-labelledby="closeCard" class="dropdown-menu has-shadow">
			                        		<a href="#" class="dropdown-item remove"> 
			                        			<i class="fa fa-times"></i>Close
			                        		</a>
			                        		<a href="#" class="dropdown-item edit"> 
			                        			<i class="fa fa-gear"></i>Edit
			                        		</a>
			                        	</div>
			                      </div>
			                    </div>
			                    <div class="card-header">
			                      	<h3 class="h4">Sacco Debits</h3>
			                    </div>
                    			<div class="card-body no-padding">
			                      	<!-- Item-->
			                      	@foreach($debits as $debit)
				                      	<div class="item d-flex justify-content-between">
				                        	<div class="info d-flex">
				                          		<div class="icon">
				                          			<i class="icon-rss-feed"></i>
				                          		</div>
					                          	<div class="title">
					                            	<h4>KES {{ number_format($debit->debit) }}.</h4>
					                            	<p> {{ $debit->accounts }} </p>
					                          	</div>
				                        	</div>
				                        	<div class="date text-right">
				                        		<strong>
				                        			{{ $debit->created_at->formatLocalized('%d') }}
				                        		</strong>
				                        		<span>
				                        			{{ $debit->created_at->formatLocalized('%b') }}
				                        		</span>
				                        	</div>
				                      	</div>
			                      	@endforeach
			                      	<!-- Item-->
                    			</div>
                  			</div>
                		</div>
                		<!-- Debits-->

                		<!-- Member Deposits-->
                		<div class="col-lg-4">
                  			<div class="articles card">
			                    <div class="card-close">
			                      	<div class="dropdown">
			                        	<button type="button" id="closeCard" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-toggle"><i class="fa fa-ellipsis-v"></i></button>
			                        	<div aria-labelledby="closeCard" class="dropdown-menu has-shadow">
			                        		<a href="#" class="dropdown-item remove"> 
			                        			<i class="fa fa-times"></i>Close
			                        		</a>
			                        		<a href="#" class="dropdown-item edit"> 
			                        			<i class="fa fa-gear"></i>Edit
			                        		</a>
			                        	</div>
			                      	</div>
			                    </div>
			                    <div class="card-header d-flex align-items-center">
			                      	<h2 class="h3">Member Deposits</h2>
			                      	<div class="badge badge-rounded bg-violet">{{ $accounts->count() }}</div>
			                    </div>
                    			<div class="card-body no-padding">
                    				@foreach($accounts as $account)
			                      		<div class="item d-flex align-items-center">
			                        		<div class="image">
			                        			<img src="{{ $account->memberPic }}" alt="..." class="img-fluid rounded-circle">
			                        		</div>
			                        		<div class="text">
			                        			<a href="#">
			                            			<h3 class="h5">
			                            				{{ $account->firstname }} {{ $account->lastname }}
			                            			</h3>
			                            		</a>
			                            		<div>
				                            		<small class="date text-right">
				                               			@if($account->loanStatus == 1)
				                            				<span style="color:#796AEE"> Active Loan </span>
				                            			@elseif($account->guaranteeStatus == 1)
				                            				<span style="color:#796AEE"> Guarantor </span>
				                            			@else
				                            				<span style="color:#796AEE"> Clean </span>
				                            			@endif

				                            			<span style="color:black"> | </span>

				                            			Kes {{ number_format($account->guarantorMoney) }}				                            			
				                            		</small>
			                            		</div>
			                            		<p style="font:bold 18px book antiqua">
			                            			Kes {{ number_format($account->totals) }}
			                            		</p>
			                            	</div>
			                      		</div>
		                      		@endforeach
                    			</div>
                  			</div>
                		</div>
                		<!-- Member Deposits-->
              		</div>
            	</div>
          	</section>
          	<!-- Updates Section -->

          	<!-- Charts Loan-->
          	<section class="charts">
	            <div class="container-fluid">
	              	<div class="row">
	                	<!-- Line Charts-->
		                <div class="col-lg-8">
		                  	<div class="line-chart-example card">
		                    	<div class="card-close">
		                      		<div class="dropdown">
		                        		<button type="button" id="closeCard" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-toggle"><i class="fa fa-ellipsis-v"></i></button>
			                        	<div aria-labelledby="closeCard" class="dropdown-menu has-shadow">
			                        		<a href="#" class="dropdown-item remove"> 
			                        			<i class="fa fa-times"></i>Close
			                        		</a>
			                        		<a href="#" class="dropdown-item edit"> 
			                        			<i class="fa fa-gear"></i>Edit
			                        		</a>
			                        	</div>
		                      		</div>
		                    	</div>
			                    <div class="card-header d-flex align-items-center">
			                      	<h3 class="h4">Member's Loans</h3>
			                    </div>
			                    <div class="card-body">
			                      	<canvas id="lineChartLoans"></canvas>
			                    </div>
		                  	</div>
		                </div>
		                <!--Line Charts-->
		                <!-- Trending Articles-->
                		<div class="col-lg-4">
                  			<div class="articles card">
			                    <div class="card-close">
			                      	<div class="dropdown">
			                        	<button type="button" id="closeCard" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-toggle"><i class="fa fa-ellipsis-v"></i></button>
			                        	<div aria-labelledby="closeCard" class="dropdown-menu has-shadow">
			                        		<a href="#" class="dropdown-item remove"> 
			                        			<i class="fa fa-times"></i>Close
			                        		</a>
			                        		<a href="#" class="dropdown-item edit"> 
			                        			<i class="fa fa-gear"></i>Edit
			                        		</a>
			                        	</div>
			                      	</div>
			                    </div>
			                    <div class="card-header d-flex align-items-center">
			                      	<h2 class="h3">Member Loans</h2>
			                      	<div class="badge badge-rounded bg-orange">{{ $maturedLoan->count() }}</div>
			                    </div>
                    			<div class="card-body no-padding">
                    				@foreach($loanMember as $loan)
			                      		<div class="item d-flex align-items-center">
			                        		<div class="image">
			                        			<img src="{{ $loan['member']['memberPic'] }}" alt="..." class="img-fluid rounded-circle">
			                        		</div>
			                        		<div class="text">
			                        			<a href="#">
			                            			<h3 class="h5">
			                            				{{ $loan['member']['firstname'] }} {{ $loan['member']['lastname'] }}
			                            			</h3>
			                            		</a>
			                            		<small>
			                            			{{ $loan->created_at->formatLocalized('%a %d %b %y') }}
			                            		</small><br>

			                            		<p style="font:bold 18px book antiqua">
			                            			Kes {{ number_format($loan->loan) }}
			                            		</p>
			                            	</div>
			                      		</div>
		                      		@endforeach
                    			</div>
                  			</div>
                		</div>
                		<!-- Trending Articles-->
		            </div>
		        </div>
		    </section>
		    <!-- Charts Loan-->

		    

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
@stop