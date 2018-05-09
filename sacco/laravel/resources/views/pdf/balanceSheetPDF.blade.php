<!DOCTYPE html>
<html>
<head>
	<title> Profit & Loss PDF. </title>

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
				Balance Sheet as of <span> {{ $last }} </span>
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

            <span style="color:black"> &nbsp;&nbsp; | &nbsp;&nbsp; </span>
            <span style="color:#666"> Balance &nbsp; </span> 
            <span style="color:#796AEE; font:normal 18px book antiqua"> 
                <strong> {{ number_format($coopAggregate + $equityAggregate + $pettycashAccount, 2) }} </strong>
            </span>
		</p>
	</div>

	<div>
		<table class="check table table-hover table-bordered">
            <thead>
                <tr style="font-size: 18px; background-color:black; color:lavender">
                    <th style="text-align:center" colspan="4"> Assets </th>
                </tr>
            </thead>
            <thead>
                <tr>
                    <th colspan="2"> Fixed Assets </th>
                    <th colspan="2"> Money </th> 
                </tr>
            </thead>                                                 
            @foreach($charts as $chart)
                @if($chart->category != 'bank' && $chart->category == 'Fixed Asset' && $chart->detail > 0)
                    <tbody>                                 
                        <tr>
                            <td colspan="2">{{ $chart->accountName }}</td>
                            <td colspan="2">{{ number_format($chart->detail) }}</td>
                        </tr>
                    </tbody>
                @endif

                @foreach($chart->subcharts as $subchart)
                    @if($subchart->category != 'bank' && $subchart->category == 'Fixed Asset' && $subchart->detail > 0)
                        <tbody>                                 
                            <tr>
                                <td colspan="2">{{ $subchart->subAccountName }}</td>
                                <td colspan="2">{{ number_format($subchart->detail) }}</td>
                            </tr>
                        </tbody>
                    @endif
                @endforeach
            @endforeach
            <tr>
                <td colspan="2" style="text-align:center; font-size: 18px; color:#796AEE"> <strong> Total Fixed Assets </strong> </td>
                <td colspan="2" style="text-align:center; font-size: 18px; color:#54e69d"> <strong> KES &nbsp; {{ number_format(abs($fixedassetsummation)) }} </strong> </td>
            </tr>            
            <thead>
                <tr>
                    <th colspan="2"> Current Assets </th>
                    <th colspan="2"></th>
                </tr>
            </thead>
            @foreach($charts as $chart)
                @if($chart->category == 'Income')
                    <tbody>
                        <tr>
                            <td colspan="2">{{ $chart->accountName }}</td>
                            <td colspan="2">{{ number_format($chart->detail) }}</td>
                        </tr>
                    </tbody>
                @elseif($chart->category == 'Account Receivable')
                    <tbody>
                        <tr>
                            <td colspan="2">{{ $chart->accountName }}</td>
                            <td colspan="2">{{ $chart->detail }}</td>
                        </tr>
                    </tbody>
                @endif

                @foreach($chart->subcharts as $subchart)
                    @if($subchart->category == 'Income')
                        <tbody>
                            <tr>
                                <td colspan="2">{{ $subchart->accountName }}</td>
                                <td colspan="2">{{ number_format($subchart->detail) }}</td>
                            </tr>
                        </tbody>
                    @elseif($subchart->category == 'Account Receivable')
                        <tbody>
                            <tr>
                                <td colspan="2">{{ $subchart->accountName }}</td>
                                <td colspan="2">{{ $subchart->detail }}</td>
                            </tr>
                        </tbody>
                    @endif
                @endforeach
            @endforeach
            <tbody>
                <tr>
                    <td colspan="2">Member Loans</td>
                    <td colspan="2">{{ number_format($memberLoans) }}</td>
                </tr>
                <tr>
                    <td colspan="2">Co - op Bank</td>
                    <td colspan="2">{{ number_format($coopAggregate) }}</td>
                </tr>
                <tr>
                    <td colspan="2">Equity Bank</td>
                    <td colspan="2">{{ number_format($equityAggregate) }}</td>
                </tr>
                <tr>
                    <td colspan="2">Petty Cash</td>
                    <td colspan="2">{{ number_format($pettycashAccount) }}</td>
                </tr>
            </tbody>
            <tr>
                <td colspan="2" style="text-align:center; font-size: 18px; color:#796AEE"> <strong> Total Current Assets </strong> </td>
                <td colspan="2" style="text-align:center; font-size: 18px; color:#54e69d"> <strong> KES &nbsp; {{ number_format(abs($memberLoans + $reimbursementsChart + $income + $coopAggregate + $equityAggregate + $pettycashAccount)) }} </strong> </td>
            </tr>
            <tbody>
                <tr>
                    <th colspan="2" style="text-align:center; font-size: 20px; color:#54e69d">Total Assets</th>
                    <td colspan="2" style="text-align:center; font-size: 20px; color:#796AEE"> <strong> KES &nbsp; {{ number_format(abs($fixedassetsummation + $reimbursementsChart + $memberLoans + $income + $coopAggregate + $equityAggregate + $pettycashAccount)) }} </strong> </td>
                </tr>
            </tbody>
            <thead>
                <tr style="font-size: 18px; background-color:black; color:lavender">
                    <th style="text-align:center" colspan="4"> Liabilities </th>
                </tr>
                <tr>
                    <th colspan="2"> Current Liabilities </th>
                    <th colspan="2"></th>
                </tr>
            </thead>
            @foreach($charts as $chart)
                @if($chart->category == 'expense' || $chart->category == 'utility' && $chart->detail > 0)
                    <tbody>
                        <tr>
                            <td colspan="2">{{ $chart->accountName }}</td>
                            <td colspan="2">{{ number_format($chart->detail) }}</td>
                        </tr>
                    </tbody>
                @endif

                @foreach($chart->subcharts as $subchart)
                    @if($subchart->category == 'expense' || $chart->category == 'utility' && $subchart->detail > 0)
                        <tbody>
                            <tr>
                                <td colspan="2">{{ $subchart->accountName }}</td>
                                <td colspan="2">{{ $subchart->detail }}</td>
                            </tr>
                        </tbody>
                    @endif
                @endforeach
                </tbody>
            @endforeach 
            <tbody>
                <tr>
                    <td colspan="2">Member Deposits</td>                                                    
                    <td colspan="2">
                        {{ number_format($memberDeposits) }}
                    </td>
                </tr>
                <tr>
                    <td colspan="2">Loan Disbursements</td>                                                 
                    <td colspan="2">
                        {{ number_format($loanDisbursements) }}
                    </td>
                </tr>
            </tbody>

            <tr>
                <td colspan="2" style="text-align:center; font-size: 18px; color:#796AEE"> <strong> Total Liabilities </strong> </td>
                <td colspan="2" style="text-align:center; font-size: 18px; color:#ff7676"> 
                    <strong> 
                        KES &nbsp; {{ number_format(abs($memberDeposits + $expensesummation + $loanDisbursements)) }} 
                    </strong> 
                </td>
            </tr>
        </table>
	</div>
</body>
</html>