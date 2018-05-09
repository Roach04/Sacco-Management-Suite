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

	<div style="text-align:center; margin-bottom:10px">
		<img src="img/logo.jpg" width="30%" height="30%">

		<p> 
			<strong> 
				Sacco Balance as of <span> {{ $yesterdayEnd->formatlocalized('%a %d %b %y') }} </span>
			</strong>
		</p>

        <p>
            <div class="pull-right">
                <span style="color:#666"> Opening &nbsp; </span> 
                <span style="color:#ff7676;"> 
                    {{ number_format($closingBalanceBeforeYesterday, 2) }} 
                </span>

                <span style="color:black"> &nbsp;&nbsp; | &nbsp;&nbsp; </span>

                <span style="color:#666"> Closing &nbsp; </span> 
                <span style="color:#54e69d;"> 
                    {{ number_format($closingBalanceYesterday, 2) }} 
                </span>
            </div>
        </p>

		<p> 
            @if(count($today))
                <div class="pull-right">
                    <span style="color:#666"> Cashbook &nbsp; </span> 
                    <span style="color:#DAA520; font:normal 18px book antiqua"> 
                        {{ number_format($cashbookSumYesterday, 0) }} 
                    </span>

                    <span style="color:black"> &nbsp;&nbsp; | &nbsp;&nbsp; </span>

                    <span style="color:#666"> Journal &nbsp; </span> 
                    <span style="color:#DAA520; font:normal 18px book antiqua"> 
                        {{ number_format($equitySumJournalYesterday, 0) }} 
                    </span>

                    <span style="color:black"> &nbsp;&nbsp; | &nbsp;&nbsp; </span>

                    <span style="color:#666"> Deposits &nbsp; </span> 
                    <span style="color:#796AEE; font:normal 18px book antiqua"> 
                        {{ number_format($depositsSumYesterday, 0) }} 
                    </span>

                    <span style="color:black"> &nbsp;&nbsp; | &nbsp;&nbsp; </span>

                    <span style="color:#666"> Disbursements &nbsp; </span> 
                    <span style="color:#ffc36d; font:normal 18px book antiqua"> 
                        {{ number_format($disburseSumYesterday, 0) }} 
                    </span>

                    <span style="color:black"> &nbsp;&nbsp; | &nbsp;&nbsp; </span>

                    <span style="color:#666"> Reimbursements &nbsp; </span> 
                    <span style="color:#ffc36d; font:normal 18px book antiqua"> 
                        {{ number_format($reimburseSumYesterday, 0) }} 
                    </span>
                </div>
            @else
                <div class="pull-right">
                    <span style="color: #666"> Today &nbsp; </span> 
                    <span style="color:#796AEE; font:normal 18px book antiqua"> 
                        {{$today}}
                        <span style="color:black"> | </span>
                        {{ $currenttime }}
                    </span>
                </div>
            @endif
        </p>
	</div>

	<table class="table table-hover table-bordered">
        <thead>
            <tr style="background-color:black; color:lavender">
                <th style="text-align:center" colspan="8"> Cash Book </th>
            </tr>
        </thead>
        <thead>
            <tr>
                <th>#</th>
                <th style="text-align:center"> Transaction Date </th>
                <th style="text-align:center"> Details </th>
                <th style="text-align:center"> Deposits / Payments </th>
                <th style="text-align:center"> Debit </th> 
                <th style="text-align:center"> Credit </th>
                <th style="text-align:center"> Account / Acc No </th>
            </tr>
        </thead>

        @if(count($cashbookYesterday))
            @foreach($cashbookYesterday as $save)
                <tbody>
                    <tr>
                        <td>{{ $save->id }}</td>
                        <td>{{ $save->created_at->formatlocalized('%a %d %b %y') }}</td>
                        <td>{{ $save->details }}</td>
                        <td></td>
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
        @else
            <tbody>
                <tr style="background-color:#ffc36d;">
                    <td colspan="8" style="text-align:center">
                        No Cashbook Transaction as of {{ $yesterdayEnd->formatlocalized('%a %d %b %y') }}
                    </td>
                </tr>
            </tbody>
        @endif
        <!-- Journals -->
        <thead>
            <tr style="background-color:black; color:lavender">
                <th style="text-align:center" colspan="8"> Journal </th>
            </tr>
        </thead>
        @if(count($equityJournalYesterday))
            @foreach($equityJournalYesterday as $save)
                <tbody>
                    <tr>
                        <td>{{ $save->id }}</td>
                        <td>{{ $save->created_at->formatlocalized('%a %d %b %y') }}</td>
                        <td>{{ $save->details }}</td>
                        <td>{{ number_format($save->overpay + $save->actualFigure) }}</td>
                        <td></td>
                        <td></td>                                                                   
                        <td>{{ $save->accountName }}</td>
                    </tr>
                </tbody>
            @endforeach
        @else
            <tbody>
                <tr>
                    <td colspan="8" style="background-color:#ffc36d; text-align:center">
                        No Journal Transaction as of {{ $yesterdayEnd->formatlocalized('%a %d %b %y') }}
                    </td>
                </tr>
            </tbody>
        @endif
        <!-- Member Deposits -->
        <thead>
            <tr style="background-color:black; color:lavender">
                <th style="text-align:center" colspan="8"> Member Deposits </th>
            </tr>
        </thead>
        @if(count($depositsYesterday))
            @foreach($depositsYesterday as $deposit)
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
        @else
            <tbody>
                <tr>
                    <td colspan="8" style="background-color:#ffc36d; text-align:center">
                        No Member Deposits as of {{ $yesterdayEnd->formatlocalized('%a %d %b %y') }}
                    </td>
                </tr>
            </tbody>
        @endif
        <!-- Loan Disbursements -->
        <thead>
            <tr>
                <th style="background-color:black; color:lavender; text-align:center" colspan="8"> 
                    Loan Disbursements 
                </th>
            </tr>
        </thead>
        @if(count($disburseYesterday))
            @foreach($disburseYesterday as $disbursement)
                <tbody>
                    <tr>
                        <th scope="row">{{ $disbursement['id'] }}</th>
                        <td>{{ $disbursement->created_at->formatlocalized('%a %d %b %y') }}</td>
                        <td>
                            {{ $disbursement->loan->member['firstname'] }}
                            &nbsp;
                            {{ $disbursement->loan->member['lastname'] }}
                        </td>
                        <td>{{ number_format($disbursement->disburseMoney) }}</td>
                        <td></td>
                        <td></td>
                        <td>{{ $disbursement->loan->member['accountNumber'] }}</td>                                             
                    </tr>
                </tbody>
            @endforeach
        @else
            <tbody>
                <tr>
                    <td colspan="8" style="background-color:lightblue; text-align:center">
                        No Loan Disbursements as of {{ $yesterdayEnd->formatlocalized('%a %d %b %y') }}
                    </td>
                </tr>
            </tbody>
        @endif
        <!-- Loan Payments -->
        <thead>
            <tr >
                <th style="background-color:black; color:lavender; text-align:center" colspan="8"> 
                    Loan Reimbursements 
                </th>
            </tr>
        </thead>
        @if(count($reimburseYesterday))
            @foreach($reimburseYesterday as $installment)
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
                </tbody>
            @endforeach
        @else
            <tbody>
                <tr>
                    <td colspan="8" style="background-color:lightblue; text-align:center">
                        No Loan Reimbursements as of {{ $yesterdayEnd->formatlocalized('%a %d %b %y') }}
                    </td>
                </tr>
            </tbody>
        @endif
    </table>
</body>
</html>