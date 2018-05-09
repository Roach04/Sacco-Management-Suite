<!DOCTYPE html>
<html>
<head>
	<title> Trial Balance PDF. </title>

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
		<img src="img/logo.jpg" width="30%" height="30%">

		<p> 
			<strong> 
				Trial Balance as of <span> {{ $last }} </span>
			</strong>
		</p>

		<p> 
            <span style="color:#666"> Co - op &nbsp; </span> 
            <span style="color:#54e69d; font:normal 18px book antiqua"> 
                <strong> {{ number_format($coopAggregate, 2) }} </strong>
            </span>

            <span style="color:black"> &nbsp;&nbsp; | &nbsp;&nbsp; </span>

            <span style="color:#666"> Equity &nbsp; </span> 
            <span style="color:#ff7676; font:normal 18px book antiqua"> 
                <strong> {{ number_format($equityAggregate, 2) }} </strong>
            </span>

            <span style="color:black"> &nbsp;&nbsp; | &nbsp;&nbsp; </span>

            <span style="color:#666"> Petty Cash &nbsp; </span> 
            <span style="color:#DAA520; font:normal 18px book antiqua"> 
                <strong> {{ number_format($pettycashAccount, 2) }} </strong>
            </span>
            
            <span style="color:#666"> Balance &nbsp; </span> 
            <span style="color:#796AEE; font:normal 18px book antiqua"> 
                <strong> {{ number_format($coopAggregate + $equityAggregate + $pettycashAccount, 2) }} </strong>
            </span>
        </p>
	</div>

	<table class="table table-hover table-bordered">
        <thead>
    		<tr style="font-size: 18px; background-color:black; color:lavender">
    			<th> Account </th>
    			<th> Debit </th>
    			<th> Credit </th>
    			<th> Assets </th>
    			<th> Liabilities </th>
    		</tr>
    	</thead>
    	<tbody>
    		
    		@foreach($charts as $chart)
                @if($chart->detail > 0)
                    <tbody>
                        <tr>
                            <td>{{ $chart->accountName }}</td>
                            @if($chart->category == 'expense' || $chart->category == 'utility' || $chart->category == 'Fixed Asset' || $chart->category == 'Account Receivable')
                                <td>{{ number_format($chart->detail) }}</td>
                            @else
                                <td></td>
                            @endif

                            @if($chart->category == 'Income')
                                <td>{{ number_format($chart->detail) }}</td>
                            @else
                                <td></td>
                            @endif
                            <td></td>
                            <td></td>
                        </tr>
                    </tbody>
                @endif

                <!-- SUBCHARTS -->
                @foreach($chart->subcharts as $subchart)
                    <tbody>
                        <tr>
                            <td>{{ $subchart->subAccountName }}</td>
                            @if($subchart->category == 'expense' || $chart->category == 'utility' || $subchart->category == 'Fixed Asset')
                                <td>{{ number_format($subchart->detail) }}</td>
                            @else
                                <td></td>
                            @endif

                            @if($subchart->category == 'Income')
                                <td>{{ number_format($subchart->detail) }}</td>
                            @else
                                <td></td>
                            @endif
                            <td></td>
                            <td></td>
                        </tr>
                    </tbody>
                @endforeach
            @endforeach
    		<tr style="font-size: 18px; background-color:black; color:lavender">
    			<th style="font-size:18px; font-weight:bold; text-align:center" colspan="8">Members</th>
    		</tr>
    		<tr>
    			<td>Loans</td>
    			<td></td>
    			<td></td>
    			<td>{{ number_format($memberLoans) }}</td>
    			<td></td>
    		</tr>
    		<tr>
    			<td>Deposits</td>
    			<td></td>
    			<td></td>
    			<td></td>
    			<td>{{ number_format($memberDeposits) }}</td>
    		</tr>
            <tr>
                <td>Disbursements</td>
                <td></td>
                <td></td>
                <td></td>
                <td>{{ number_format($loanDisbursements) }}</td>
            </tr>
    		<tr>
    			<td>Reimbursements</td>
    			<td></td>
    			<td></td>
    			<td>{{ number_format($memberInstallments) }}</td>
    			<td></td>
    		</tr>
    		<tr style="font-size: 18px; background-color:black; color:lavender">
    			<th style="font-size:18px; font-weight:bold; text-align:center" colspan="8">Banks</th>
    		</tr>
    		<tr>
    			<td>Co - op Bank</td>
    			<td></td>
    			<td></td>
    			<td>{{ number_format($coopAggregate) }}</td>
    			<td></td>
    		</tr>
    		<tr>
    			<td>Equity Bank</td>
    			<td></td>
    			<td></td>
    			<td>{{ number_format($equityAggregate) }}</td>
    			<td></td>
    		</tr>
            <tr>
                <td>Petty Cash</td>
                <td></td>
                <td></td>
                <td>{{ number_format($pettycashAccount) }}</td>
                <td></td>
            </tr>
	    	<tr style="font-size: 18px; background-color:black; color:lavender">
				<th style="font-size:18px; font-weight:bold; text-align:center;" colspan="8">Totals</th>
			</tr>
	    	<tr>
	    		<td style="font-size:18px; font-weight:bold; text-align:center; color:#54e69d" colspan="8">{{ number_format($chartsummations,2) }}</td>
	    	</tr>
	    </tbody>
    </table>
</body>
</html>