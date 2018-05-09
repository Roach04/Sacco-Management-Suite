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
        <p> 
            <span style="color:#666"> Loan &nbsp; </span> 
            <span style="color:#796AEE; font:normal 18px book antiqua"> 
                <strong> {{ number_format($loan->loan, 2) }} </strong>
            </span>

            <span style="color:black"> &nbsp;&nbsp; | &nbsp;&nbsp; </span>

            <span style="color:#666"> Loan Creation &nbsp; </span> 
            <span style="color:#796AEE; font:normal 18px book antiqua"> 
                <strong> 
                    {{ Carbon\Carbon::createFromTimestamp(strtotime($loan->created_at))->formatlocalized('%a %d %b %y') }} 
                </strong>
            </span>

            <span style="color:black"> &nbsp;&nbsp; | &nbsp;&nbsp; </span>

            <span style="color:#666"> Loan Duration &nbsp; </span> 
            <span style="color:#796AEE; font:normal 18px book antiqua"> 
                <strong> 
                    {{ $loan->loanDuration }} Months
                </strong>
            </span>

            <span style="color:black"> &nbsp;&nbsp; | &nbsp;&nbsp; </span>

            <span style="color:#666"> Loan Ageing &nbsp; </span> 
            <span style="color:#796AEE; font:normal 18px book antiqua"> 
                <strong> 
                    {{ $loan->created_at->addMonth($loan->loanDuration)->diffInMonths() }} Months
                </strong>
            </span>
        </p>
		<p> 
            <span style="color:#666"> Firstname &nbsp; </span> 
            <span style="color:#796AEE; font:normal 18px book antiqua"> 
                <strong> {{ $loan->member->firstname }} </strong>
            </span>

            <span style="color:black"> &nbsp;&nbsp; | &nbsp;&nbsp; </span>

            <span style="color:#666"> Lastname &nbsp; </span> 
            <span style="color:#796AEE; font:normal 18px book antiqua"> 
                <strong> {{ $loan->member->lastname }} </strong>
            </span>
            <span style="color:black"> &nbsp;&nbsp; | &nbsp;&nbsp; </span>

            <span style="color:#666"> Acc Number &nbsp; </span> 
            <span style="color:#796AEE; font:normal 18px book antiqua"> 
                <strong> {{ $loan->member->accountNumber }} </strong>
            </span>
        </p>
	</div>

	<div>
        <table class="table table-hover">
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
                    <th>Guaranteed Money</th>
                    <th>Total Deposits</th>
                </tr>
            </thead>
            @foreach($guaranteeStatus as $member)
                @if($member->accountNumber == $guarantees['guaranteesOne'] || $member->accountNumber == $guarantees['guaranteesTwo'] || $member->accountNumber == $guarantees['guaranteesThree'])
                <tbody>
                    <tr>
                        <th scope="row">{{ $member->accountNumber }}</th>
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
                        <td>{{ number_format($member->guarantorMoney) }}</td>
                        <td>{{ number_format($member->totals) }}</td>
                    </tr>
                </tbody>
                @endif
            @endforeach
        </table>
	</div>
</body>
</html>