<!DOCTYPE html>
<html>
<head>
	<title> Co-op Bank Cash Book PDF. </title>

	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

	<style>

		table {

		    border-collapse: collapse;
		    width: 100%;
		}
		table, th, td {

		    border: 1px solid black;
		}
		th, td {

		    padding: 5px;

		    text-align: left;
		}
		th {

		    height: 50px;
		}

		p {

			font-size: 20px;
			font-style: book antiqua;
		}

		span {

			font-size: 20px;
			font-style: book antiqua;
			color: #666;
		}
	</style>
</head>
<body>

	<div style="text-align:center">
		<img src="img/logo.jpg" width="20%" height="20%">

		<p> 
			<strong> 
				Equity Bank Cashbook as of <span> {{ $last }} </span>
			</strong>
		</p>

		<p> 
            <span style="color:grey"> Opening Balance & Accounts &nbsp; </span> 
            <span style="color:#ff7676; font:normal 20px book antiqua"> 
                <strong> {{ number_format($equityAccount, 2) }} </strong>
            </span> 

            <span style="color:black"> &nbsp;&nbsp; | &nbsp;&nbsp; </span>

			<span style="color:grey"> Member Deposits &nbsp; </span> 
            <span style="color:#796AEE; font:bold 20px book antiqua"> 
                <strong> {{ number_format($equityDeposit, 2) }} </strong>
            </span>

            <span style="color:black"> &nbsp;&nbsp; | &nbsp;&nbsp; </span>

            <span style="color:grey"> Loans Reimbursements &nbsp; </span> 
            <span style="color:#ffc36d; font:bold 20px book antiqua"> 
                <strong> {{ number_format($equityLoan, 2) }} </strong>
            </span>

            <span style="color:black"> &nbsp;&nbsp; | &nbsp;&nbsp; </span>

            <span style="color:grey"> Equity Bank &nbsp; </span> 
            <span style="color:#54e69d; font:bold 20px book antiqua"> 
                <strong> {{ number_format($equityAggregate, 2) }} </strong>
            </span>
		</p>
	</div>

	<div>
		<table>
			<thead>
        		<tr>
        			<th> # </th>
        			<th> Transaction Date </th>
        			<th> Details </th>
        			<th> Deposits / Payments </th>
        			<th> Debit </th>
        			<th> Credit </th>						                			
        			<th> Account / Acc No </th>
        		</tr>
        	</thead>
        	@foreach($savings as $save)
            	<tbody>
            		<tr>
            			<th scope="row">{{ $save->id }}</th>
            			<td>{{ $save->created_at->formatlocalized('%a %d %b %y') }}</td>
            			<td>{{ $save->details }}</td>
            			<td></td>
            			@if($save->action == 'credit')
            				<td>{{ number_format($save->credit) }}</td>
            			@elseif($save->action != 'credit')
            				<td></td>
            			@endif

            			@if($save->action == 'debit')
            				<td>{{ number_format($save->debit) }}</td>
            			@elseif($save->action != 'debit')
            				<td></td>
            			@endif
            			<td>{{ $save->accounts }}</td>
            		</tr>
            	</tbody>
			@endforeach

			<thead>
        		<tr style="font-size: 18px; background-color:black; color:lavender">
        			<th style="text-align:center" colspan="8"> Member Deposits </th>
        		</tr>
        	</thead>
        	@foreach($depositsEquity as $deposit)
            	<tbody>
            		<tr>
            			<th scope="row">{{ $deposit['id'] }}</th>
            			<td>{{ $deposit->created_at->formatlocalized('%a %d %b %y') }}</td>
            			<td>
            				{{ $deposit->member['firstname'] }}
            				&nbsp;
            				{{ $deposit->member['lastname'] }}
            			</td>
            			<td>{{ number_format($deposit->money) }}</td>
            			<td></td>
            			<td></td>
            			<td>{{ $deposit->member['accountNumber'] }}</td>					                			
            		</tr>
            	</tbody>
        	@endforeach
        	<!-- Member Loan Payments -->
        	<thead>
        		<tr style="font-size: 18px; background-color:black; color:lavender">
        			<th style="text-align:center" colspan="8"> Member Loan Payments </th>
        		</tr>
        	</thead>
        	@foreach($memberLoanPayments as $installment)
            	<tbody>
            		<tr>
            			<th scope="row">{{ $installment['id'] }}</th>
            			<td>{{ $installment->created_at->formatlocalized('%a %d %b %y') }}</td>
            			<td>
            				{{ $installment->loan->member['firstname'] }}
            				&nbsp;
            				{{ $installment->loan->member['lastname'] }}
            			</td>
            			<td>{{ number_format($installment->installment) }}</td>
            			<td></td>
            			<td></td>
            			<td>{{ $installment->loan->member['accountNumber'] }}</td>					                			
            		</tr>
            	</tbody>
        	@endforeach
		</table>
	</div>
</body>
</html>