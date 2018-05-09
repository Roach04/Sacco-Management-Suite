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
				Mature Loans as of <span> {{ $last }} </span>
			</strong>
		</p>

		
	</div>

	<div>
        <table class="table table-hover table-bordered">
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
                </tr>
            </thead>
            @foreach($loanStatus as $member)
            <tbody>
                <tr>
                    <th scope="row">
                        <a href="{{ route('loanGuarantors', [$member->loan->id]) }}">
                            {{ $member->accountNumber }}
                        </a>
                    </th>
                    <td>{{ $member->firstname }}</td>
                    <td>{{ $member->lastname }}</td>
                    <td>{{ $member->phoneNumber }}</td>
                    <td>{{ $member->idNumber }}</td>
                    <td>{{ $member->emailAddress }}</td>
                    @if($member->loanStatus == 0)
                        <td> Free </td>
                    @elseif($member->loanStatus == 1)
                        <td> Active </td>
                    @elseif($member->loanStatus == 2)
                        <td> Cleared </td>
                    @endif

                    @if($member->guaranteeStatus == 0)
                        <td> Free </td>
                    @elseif($member->guaranteeStatus == 1)
                        <td> Guarantor </td>
                    @elseif($member->guaranteeStatus == 2)
                        <td> Cleared </td>
                    @endif
                    <td>{{ number_format($member->totals) }}</td>
                    <td>{{ number_format($member->loan->loan) }}</td>
                    <td>{{ number_format($member->loan->loanDuration) }} Months</td>
                    <td>{{ Carbon\Carbon::createFromTimestamp(strtotime($member->loan->created_at))->formatlocalized('%a %d %b %y') }}</td>
                    <td>{{ $member->loan->created_at->addMonth($member->loan->loanDuration)->diffInMonths() }} Months</td>
                </tr>
            </tbody>
            @endforeach
        </table>
	</div>
</body>
</html>