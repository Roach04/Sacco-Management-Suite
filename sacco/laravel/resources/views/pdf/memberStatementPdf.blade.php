<!DOCTYPE html>
<html>
<head>
	<title> Loans PDF. </title>

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
				Member Statement as of <span> {{ $today }} </span>
			</strong>
		</p>
		<p> 
            <span style="color:grey"> Account Number &nbsp; </span> 
            <span style="color:#54e69d; font:normal 18px book antiqua"> 
                <strong> {{ $member->accountNumber }} </strong>
            </span>

            <span style="color:black"> &nbsp;&nbsp; | &nbsp;&nbsp; </span>

            <span style="color:grey"> Firstname &nbsp; </span> 
            <span style="color:#ff7676; font:normal 18px book antiqua"> 
                <strong> {{ $member->firstname }} </strong>
            </span>

            <span style="color:black"> &nbsp;&nbsp; | &nbsp;&nbsp; </span>
            <span style="color:grey"> Lastname &nbsp; </span> 
            <span style="color:#796AEE; font:normal 18px book antiqua"> 
                <strong> {{ $member->lastname }} </strong>
            </span>
		</p>		

        <table class="table table-hover">
        	<thead>
        		<tr style="background-color:black">
        			<th style="color:lavender; text-align:center" colspan="10"> Deposits </th>
        		</tr>
        		<tr>
        			<th colspan="2" style="text-align:center"> # </th> 
        			<th colspan="2" style="text-align:center"> Transaction Date </th>
        			<th colspan="2" style="text-align:center"> Deposits </th>
                    <th colspan="2" style="text-align:center"> Bank </th>
                    <th colspan="2" style="text-align:center"> Account Number </th>
        		</tr>
        	</thead>
        	
        	@foreach($member->account as $account)
        	<tbody align="center">
        		<tr>
                    <td colspan="2">{{ $account->id }}</td>
        			<td colspan="2">{{ $account->created_at->formatlocalized('%a %d %b %y') }}</td>
        			<td colspan="2">{{ number_format($account->money) }}</td>
                    <td colspan="2">{{ $account->bank }}</td>
                    <td colspan="2">{{ $member->accountNumber }}</td>
        		</tr>
        	</tbody>
        	@endforeach

        	<tr style="background-color:lightblue">
        		<td colspan="5" style="text-align:center; font-size: 18px; color:#796AEE"> <strong> Total Deposits </strong> </td>
            	<td colspan="5" style="text-align:center; font-size: 18px; color:#796AEE"> <strong> KES &nbsp; {{ number_format($member->totals + $member->guarantorMoney) }} </strong> </td>
            </tr>
            
            @if(count($loans))
                <thead>
                    <tr style="background-color:black; color:lavender;">
                        <th style="text-align:center" colspan="10"> Loan </th>
                    </tr>
                    <tr>
                        <th style="text-align:center;" colspan="2"> Loan Type </th>
                        <th style="text-align:center;" colspan="2"> Loan Amount </th>
                        <th style="text-align:center;" colspan="2"> 
                            @foreach($loans as $loan)
                                @if($today < $loan->created_at->addDays($loan->gracePeriod)->diffInDays())
                                    Grace Period
                                @elseif($today > $loan->created_at->addDays($loan->gracePeriod)->diffInDays())
                                    <p style="color:#ffc36d"> Loan Ageing </p>
                                @endif
                            @endforeach
                        </th>
                        <th style="text-align:center;" colspan="2"> Loan Disbursement </th>
                        <th style="text-align:center;" colspan="2"> Installments Paid </th>
                    </tr>
                </thead>
                @foreach($loans as $loan)
                <tbody>
                    <tr>
                        <td style="text-align:center;" colspan="2">{{ ucfirst($loan->loanType) }} Loan</td>
                        <td style="text-align:center;" colspan="2">{{ number_format($loan->amount) }}</td>
                        <td style="text-align:center;" colspan="2">
                            @if($today < $loan->created_at->addDays($loan->gracePeriod)->diffInDays())
                                <p style="color:#54e69d"> <strong> {{ $loan->created_at->addDays($loan->gracePeriod)->diffInDays() }} Days </strong> </p>
                            @elseif($today > $loan->created_at->addDays($loan->gracePeriod)->diffInDays())
                                <p style="color:#ffc36d"> <strong> {{ $loan->created_At->addMonths($loan->loanDuration)->diffInMonths() }} </strong> </p>
                            @endif
                        </td>
                        @if(count($loan->disbursements))
                            @foreach($loan->disbursements as $disburse)
                                <td style="text-align:center;" colspan="2">{{ number_format($disburse->disburseMoney) }}</td>   
                            @endforeach
                        @else
                            <td style="text-align:center;" colspan="2"> No Disbursement </td>
                        @endif
                        <td style="text-align:center;" colspan="2"> {{ number_format($loan->totalInstallments) }} </td>
                    </tr>
                </tbody>
                @endforeach
                <tr class="table-info">
                    <td colspan="5" style="text-align:center; font-size: 18px; color:#796AEE"> <strong> Total Balance </strong> </td>
                    <td colspan="5" style="text-align:center; font-size: 18px; color:#ff7676"> <strong> KES {{ number_format( $sumLoans, 0) }} </strong> </td>
                </tr>

                @if(count($loan->installments))
                    <thead>
                        <tr class="thead-inverse">
                            <th style="text-align:center" colspan="10"> Installments </th>
                        </tr>
                        <tr>
                            <th> Creation Date </th>
                            <th> Installment Paid </th>
                            <th> Months Left </th>
                            <th> Number of Defaults </th>
                        </tr>
                    </thead>

                    @foreach($member->loan->installments as $installment)
                    <tbody>
                        <tr>
                            <td>{{ $installment->created_at->formatlocalized('%a %d %b %y') }}</td>
                            <td>{{ number_format($installment->installment) }}</td>
                            <td>{{ $installment->daysLeft }} Months </td>
                            <td>{{ $installment->defaults }}</td>
                        </tr>
                    </tbody>
                    @endforeach
                @endif
            @else
                <thead>
                    <tr style="background-color:black; color:lavender;">
                        <th style="text-align:center" colspan="10"> Loan </th>
                    </tr>
                </thead>
                <tbody>
                    <tr style="background-color:lightyellow">
                        <th style="text-align:center" colspan="10"> Your Loan Status is &nbsp; <b>CLEAR</b> </th>
                    </tr>
                </tbody>
            @endif						                	

        	@if($member->guaranteeStatus == 1)
            	<thead>
                    <tr style="background-color:black; color:lavender;">
                        <th style="text-align:center" colspan="10"> Guarantor </th>
                    </tr>
                    <tr>
                        <th colspan="2" style="text-align:center;"> Loan Type </th>
                        <th colspan="2" style="text-align:center;"> Loan Amount </th>
                        <th colspan="2" style="text-align:center;"> Guaranteed Money</th>
                        <th colspan="2" style="text-align:center;"> Loan Disbursement</th>
                        <th colspan="2" style="text-align:center;"> Installments Paid </th>
                    </tr>
                </thead>

                @foreach($guaranteed as $guarantee)
                    <tbody>
                        <tr>
                            <td colspan="2" style="text-align:center;">{{ ucfirst($guarantee->loanType) }}</td>
                            <td colspan="2" style="text-align:center;">{{ number_format($guarantee->loan) }}</td>
                            @if($member->accountNumber == $guarantee->guaranteeOne)
                                <td colspan="2" style="text-align:center;">{{ number_format($guarantee->moneyOne) }}</td>
                            @elseif($member->accountNumber == $guarantee->guaranteeTwo)
                                <td colspan="2" style="text-align:center;">{{ number_format($guarantee->moneyTwo) }}</td>
                            @elseif($member->accountNumber == $guarantee->guaranteeThree)
                                <td colspan="2" style="text-align:center;">{{ number_format($guarantee->moneyThree) }}</td>
                            @endif
                            @if(count($guarantee->disbursements))
                                @foreach($guarantee->disbursements as $disburse)
                                    <td style="text-align:center;" colspan="2">{{ number_format($disburse->disburseMoney) }}</td>   
                                @endforeach
                            @else
                                <td style="text-align:center;" colspan="2"> No Disbursement </td>
                            @endif
                            <td colspan="2" style="text-align:center;"> {{ number_format($guarantee->totalInstallments) }} </td>
                        </tr>
                    </tbody>
                @endforeach
                
            @elseif($member->guaranteeStatus == 0)
                <thead>
                    <tr style="background-color:black; color:lavender;">
                        <th style="text-align:center" colspan="10"> Guarantor </th>
                    </tr>
                </thead>
                <tbody>
                    <tr style="background-color:lightgreen; color:black;">
                        <th style="text-align:center" colspan="10"> Your Guarantor Status is &nbsp; <b>CLEAR</b> </th>
                    </tr>
                </tbody>
            @endif
            <tr style="background-color:black; color:lavender;">
                <th style="text-align:center" colspan="10"> Balance </th>
            </tr>
            <tr style="background-color:lightblue; color:lavender;">
                <th colspan="5" style="text-align:center; font-size: 18px; color:#796AEE"><strong> Running Balance </strong></th>
                <th colspan="5" style="text-align:center; font-size: 18px; color:#796AEE"><strong> KES &nbsp; {{ number_format($member->totals) }} </strong></th>
            </tr>
        </table>
	</div>
</body>
</html>