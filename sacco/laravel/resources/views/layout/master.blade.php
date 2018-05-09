<!DOCTYPE html>
<html lang="en">
	<head>
		<title> {{ $title }} </title>

		<!-- for-mobile-apps -->
		<meta charset="utf-8">
    	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    	<meta name="description" content="">
    	<meta name="viewport" content="width=device-width, initial-scale=1">
    	<meta name="robots" content="all,follow">

    	<!-- Jquery ui search -->
		{!! Html::style('bootstrap/css/jquery-ui.css') !!}
		<!-- Jquery ui search -->

	    <!-- Google fonts - Roboto -->
	    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,700">

	    <!-- Favicon -->
	    <link rel="shortcut icon" href="img/favicon.ico">

	    <!-- Font Icons CSS -->
	    <link rel="stylesheet" href="https://file.myfontastic.com/da58YPMQ7U5HY8Rb6UxkNf/icons.css">

		<!-- bootstrap css -->
		{!! Html::style('bootstrap/css/bootstrap.css') !!}

		<!-- theme stylesheet -->
		{!! Html::style('bootstrap/css/style.default.css', ['id' => 'theme-stylesheet']) !!}
		<!-- theme stylesheet -->

		<!-- font awesome. -->
		{!! Html::style('font-awesome/css/font-awesome.min.css') !!}
		<!-- font awesome. -->

		<!-- custom css. -->
		{!! Html::style('bootstrap/css/custom.css') !!}
		<!-- custom css. -->

		<!-- preloader css. 
		{!! Html::style('bootstrap/css/preloader.css') !!}
		<!-- preloader css. -->

		<!-- Font Icons CSS-->
    	<link rel="stylesheet" href="https://file.myfontastic.com/da58YPMQ7U5HY8Rb6UxkNf/icons.css">

    	<link rel="stylesheet" href="https://rawgit.com/enyo/dropzone/master/dist/dropzone.css">
	</head>
<body>

		
	<!-- Preloader -->
	<div id="preloader">
	  <div id="load"></div>
	</div>

	<!-- global.. -->
	<div style="background-color:#f7f7f7; margin-top:20px" id="success">
		<!-- lets do a session to be used throught our auth app. -->
		@if(Session::has('global'))
			<p> {!! Session::get('global') !!} </p>
		@endif	
	</div>
	<!-- global.. -->

	@yield('content')

	<!-- Dropzone JS -->
	{!! Html::script('bootstrap/js/dropzone.js') !!}
	<!-- Dropzone JS -->

	<!-- jquery. -->
	<script src="http://code.jquery.com/jquery-1.12.4.min.js">
	</script>
	

	<!-- bootstrap js. -->
	{!! Html::script('bootstrap/js/bootstrap.min.js') !!}

	<!-- Jquery easing in-->
	{!! Html::script('bootstrap/js/bs-modal-fullscreen.min.js') !!}

	<!-- Jquery easing in-->
	{!! Html::script('bootstrap/js/tether.min.js') !!}

	<!-- Jquery cookie -->
	{!! Html::script('bootstrap/js/jquery.cookie.js') !!}

	<!-- Jquery validate -->
	{!! Html::script('bootstrap/js/jquery.validate.min.js') !!}

	<!-- Custom Theme JavaScript -->
	{!! Html::script('bootstrap/js/front.js') !!}
	<!-- Custom Theme JavaScript -->

	

	<!-- Modal JS -->
	{!! Html::script('bootstrap/js/modal.js') !!}
	<!-- Modal JS -->

	<!-- Account Edit JS -->
	{!! Html::script('bootstrap/js/accountEdit.js') !!}
	<!-- Account Edit JS -->

	<!-- Member Account JS -->
	{!! Html::script('bootstrap/js/memberAccount.js') !!}
	<!-- Member Account JS -->

	<!-- Global JS -->
	{!! Html::script('bootstrap/js/global.js') !!}
	<!-- Global JS -->

	<!-- Savings JS -->
	{!! Html::script('bootstrap/js/savings.js') !!}
	<!-- Savings JS -->

	<!-- Savings Update JS -->
	{!! Html::script('bootstrap/js/savingsUpdate.js') !!}
	<!-- Savings Update JS -->

	<!-- Money Update JS -->
	{!! Html::script('bootstrap/js/moneyUpdate.js') !!}
	<!-- Money Update JS -->

	<!-- Create Loans JS -->
	{!! Html::script('bootstrap/js/loans.js') !!}
	<!-- Create Loans JS -->

	<!-- Installments JS -->
	{!! Html::script('bootstrap/js/installments.js') !!}
	<!-- Installments JS -->

	<!-- Installment Updates JS -->
	{!! Html::script('bootstrap/js/installmentUpdates.js') !!}
	<!-- Installment Updates JS -->

	<!-- March Reconcile JS -->
	{!! Html::script('bootstrap/js/reconcileCoopMarch.js') !!}
	<!-- March Reconcile JS -->

	<!-- April coop Reconcile JS -->
	{!! Html::script('bootstrap/js/reconcileCoopApril.js') !!}
	<!-- April coop Reconcile JS -->

	<!-- March Equity Reconcile JS -->
	{!! Html::script('bootstrap/js/reconcileEquityMarch.js') !!}
	<!-- March Equity Reconcile JS -->

	<!-- April Equity Reconcile JS -->
	{!! Html::script('bootstrap/js/reconcileEquityApril.js') !!}
	<!-- April Equity Reconcile JS -->

	<!-- March Pettycash Reconcile JS -->
	{!! Html::script('bootstrap/js/reconcilePettycashMarch.js') !!}
	<!-- March Pettycash Reconcile JS -->

	<!-- April Pettycash Reconcile JS -->
	{!! Html::script('bootstrap/js/reconcilePettycashApril.js') !!}
	<!-- April Pettycash Reconcile JS -->

	<!-- 12 Month Reconcile JS -->
	{!! Html::script('bootstrap/js/reconcileTwelve.js') !!}
	<!-- 12 Month Reconcile JS -->

	<!-- 3 Month Member Account Reconcile JS -->
	{!! Html::script('bootstrap/js/reconcileAccountsThree.js') !!}
	<!-- 3 Month Member Account Reconcile JS -->

	<!-- 6 Month Member Account Reconcile JS -->
	{!! Html::script('bootstrap/js/reconcileAccountsSix.js') !!}
	<!-- 6 Month Member Account Reconcile JS -->

	<!-- 12 Month Member Account Reconcile JS -->
	{!! Html::script('bootstrap/js/reconcileAccountsTwelve.js') !!}
	<!-- 12 Month Member Account Reconcile JS -->

	<!-- Active Loans JS -->
	{!! Html::script('bootstrap/js/activeLoans.js') !!}
	<!-- Active Loans JS -->

	<!-- Default Loans JS -->
	{!! Html::script('bootstrap/js/defaultLoans.js') !!}
	<!-- Default Loans JS -->

	<!-- Default Installments JS -->
	{!! Html::script('bootstrap/js/installmentsDefault.js') !!}
	<!-- Default Installments JS -->

	<!-- Dropzone Response JS -->
	{!! Html::script('bootstrap/js/dropzone-response.js') !!}
	<!-- Dropzone Response JS -->

	<!-- Moment JS -->
	{!! Html::script('bootstrap/js/moment.min.js') !!}
	<!-- Moment JS -->

	<!-- Jquery ui search -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
	<!-- Jquery ui search -->

	<!-- search -->
	{!! Html::script('bootstrap/js/search.js') !!}
	<!-- search -->

	<!-- chart of accounts -->
	{!! Html::script('bootstrap/js/chartAccounts.js') !!}
	<!-- chart of accounts -->

	<!-- cashbook -->
	{!! Html::script('bootstrap/js/cashbook.js') !!}
	<!-- cashbook -->

	<!-- calculator -->
	{!! Html::script('bootstrap/js/calculator.js') !!}
	<!-- calculator -->

	<!-- disbursements Update -->
	{!! Html::script('bootstrap/js/disbursementsUpdate.js') !!}
	<!-- disbursements Update -->

	<!-- journals Update -->
	{!! Html::script('bootstrap/js/journalsUpdate.js') !!}
	<!-- journals Update -->

	<!-- Chart -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>
	<!-- Chart -->

	<!-- Charts home -->
	{!! Html::script('bootstrap/js/charts-home.js') !!}
	<!-- Charts home -->

	<!-- Charts custom -->
	{!! Html::script('bootstrap/js/charts-custom.js') !!}
	<!-- Charts custom -->
</body>
</html>