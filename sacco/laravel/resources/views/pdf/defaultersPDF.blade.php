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
		<img src="img/logo.jpg" width="40%" height="40%">

		<p> 
			<strong> 
				Default Loans as of <span> {{ $last }} </span>
			</strong>
		</p>

		
	</div>

	<div>
        <table class="table table-hover table-responsive">
            <thead>
                <tr>
                    <th>#</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Mobile Number</th>
                    <th>ID Number</th>
                    <th>Email Address</th>
                    <th>Loan Status</th>
                    <th>Guarantee Status</th>
                    <th>Total Deposits</th>
                    <th>Loan</th>
                    <th>Loan Duration</th>
                    <th>Creation Date</th>
                    <th>Loan Ageing</th>
                    <th>Defaulters</th>
                </tr>
            </thead>
            @foreach($defaulters as $installment)
            <tbody>
                <tr>
                    <th scope="row">{{ $installment->loan->member->accountNumber }}</th>
                    <td>{{ $installment->loan->member->firstname }}</td>
                    <td>{{ $installment->loan->member->lastname }}</td>
                    <td>{{ $installment->loan->member->phoneNumber }}</td>
                    <td>{{ $installment->loan->member->idNumber }}</td>
                    <td>{{ $installment->loan->member->emailAddress }}</td>
                    @if($installment->loan->member->loanStatus == 0)
                        <td> Free </td>
                    @elseif($installment->loan->member->loanStatus == 1)
                        <td> Active </td>
                    @elseif($installment->loan->member->loanStatus == 2)
                        <td> Cleared </td>
                    @endif

                    @if($installment->loan->member->guaranteeStatus == 0)
                        <td> Free </td>
                    @elseif($installment->loan->member->guaranteeStatus == 1)
                        <td> Guarantor </td>
                    @elseif($installment->loan->member->guaranteeStatus == 2)
                        <td> Cleared </td>
                    @endif
                    <td>{{ number_format($installment->loan->totals) }}</td>
                    <td>{{ number_format($installment->loan->loan) }}</td>
                    <td>{{ number_format($installment->loan->loanDuration) }} Months</td>
                    <td>{{ Carbon\Carbon::createFromTimestamp(strtotime($installment->loan->created_at))->formatlocalized('%a %d %b %y') }}</td>
                    <td>{{ $installment->loan->created_at->addMonth($installment->loan->loanDuration)->diffInMonths() }} Months</td>
                    <td>{{ count($installment->defaults) }}</td>
                </tr>
            </tbody>
            @endforeach
        </table>
	</div>
</body>
</html>