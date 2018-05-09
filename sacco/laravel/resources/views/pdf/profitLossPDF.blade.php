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
				Profit & Loss as of <span> {{ $last }} </span>
			</strong>
		</p>

		<p> 
            <span style="color:#666"> Co - op &nbsp; </span> 
            <span style="color:#54e69d; font:normal 18px book antiqua"> 
                <strong> {{ number_format($coopAccount, 2) }} </strong>
            </span>

            <span style="color:black"> &nbsp;&nbsp; | &nbsp;&nbsp; </span>

            <span style="color:#666"> Equity &nbsp; </span> 
            <span style="color:#ff7676; font:normal 18px book antiqua"> 
                <strong> {{ number_format($equityAccount, 2) }} </strong>
            </span>

            <span style="color:black"> &nbsp;&nbsp; | &nbsp;&nbsp; </span>

            <span style="color:#666"> Petty Cash &nbsp; </span> 
            <span style="color:#DAA520; font:normal 18px book antiqua"> 
                <strong> {{ number_format($pettycashAccount, 2) }} </strong>
            </span>

            <span style="color:black"> &nbsp;&nbsp; | &nbsp;&nbsp; </span>
            <span style="color:#666"> Balance &nbsp; </span> 
            <span style="color:#796AEE; font:normal 18px book antiqua"> 
                <strong> {{ number_format($runningBal + $pettycashAccount, 2) }} </strong>
            </span>
		</p>
	</div>

	<div>
        <table class="check table table-hover">
            <thead>
                <tr style="font-size: 18px; background-color:black; color:lavender">
                    <th style="text-align:center;" colspan="4"> Income </th>
                </tr>
                <tr>
                    <th> # </th> 
                    <th> Details </th>
                    <th> Account </th>
                    <th> Money </th>
                </tr>
            </thead>
            @foreach($credits as $saving)
                <tbody>
                    <tr>
                        <td>{{ $saving->id }}</td>
                        <td>{{ $saving->details }}</td>
                        <td>{{ $saving->accounts }}</td>
                        <td>{{ number_format($saving->debit) }}</td>
                    </tr>
                </tbody>
            @endforeach
            <tr>
                <td colspan="2" style="text-align:center; font-size: 18px; color:#796AEE"> <strong> Total Income </strong> </td>
                <td colspan="2" style="text-align:center; font-size: 18px; color:#54e69d"> <strong> KES &nbsp; {{ number_format($sumcredit) }} </strong> </td>
            </tr>
            <thead>
                <tr style="font-size: 18px; background-color:black; color:lavender">
                    <th style="text-align:center" colspan="4"> Expense </th>
                </tr>
                <tr>
                    <th> # </th> 
                    <th> Details </th>
                    <th> Account </th>
                    <th> Money </th>
                </tr>
            </thead>
            <!-- Journals -->
            @foreach($debits as $saving)
                <tbody>
                    <tr>
                        <td>{{ $saving->id }}</td>
                        <td>{{ $saving->details }}</td>
                        <td>{{ $saving->accounts }}</td>
                        <td>{{ number_format($saving->debit) }}</td>
                    </tr>
                </tbody>
            @endforeach
            <!-- Journals -->
            @foreach($journals as $journal)
                <tbody>
                    <tr>
                        <td>{{ $journal->id }}</td>
                        <td>{{ $journal->details }}</td>
                        <td>{{ $journal->accountName }}</td>
                        <td>{{ number_format($journal->actualFigure + $journal->overpay) }}</td>
                    </tr>
                </tbody>
            @endforeach
            <tr>
                <td colspan="2" style="text-align:center; font-size: 18px; color:#796AEE"> <strong> Total Expense </strong> </td>
                <td colspan="2" style="text-align:center; font-size: 18px; color:#ff7676"> <strong> KES &nbsp; {{ number_format($sumdebit + $sumJournal) }} </strong> </td>
            </tr>
            
            <thead>
                <tr style="font-size: 18px; background-color:black; color:lavender">
                    <th style="text-align:center" colspan="4"> Totals </th>
                </tr>
            </thead>
            <tbody class="table-warning">
                <tr>
                    @if($sumcredit > $sumdebit)
                        <td colspan="4" style="text-align:center; font-size: 18px; color:#54e69d"> 
                            <strong>
                                KES &nbsp; {{ number_format($sumcredit - ($sumdebit + $sumJournal), 2) }}
                            </strong>
                        </td>
                    @elseif($sumcredit < $sumdebit)
                        <td colspan="4" style="text-align:center; font-size: 18px; color:#ff7676"> 
                            <strong>
                                KES &nbsp; {{ number_format($sumcredit - ($sumdebit + $sumJournal), 2) }}
                            </strong>
                        </td>
                    @elseif($sumdebit == $sumcredit)
                        <td colspan="4" style="text-align:center; font-size: 18px; color:#796AEE"> 
                            <strong>
                                KES &nbsp; {{ number_format($sumcredit - ($sumdebit + $sumJournal), 2) }}
                            </strong>
                        </td>
                    @endif
                </tr>
            </tbody>
        </table>
	</div>
</body>
</html>