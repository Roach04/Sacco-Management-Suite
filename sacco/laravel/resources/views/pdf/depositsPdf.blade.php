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
				Member Deposits as of <span> {{ $last }} </span>
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
                    <th>Total Deposits</th>
                </tr>
            </thead>
            @foreach($deposits as $member)
            <tbody>
                <tr>
                    <th scope="row">{{ $member->accountNumber }}</th>
                    <td>{{ $member->firstname }}</td>
                    <td>{{ $member->lastname }}</td>
                    <td>{{ $member->phoneNumber }}</td>
                    <td>{{ $member->idNumber }}</td>
                    <td>{{ $member->emailAddress }}</td>
                    <td>{{ number_format($member->totals + $member->guarantorMoney) }}</td>
                </tr>
            </tbody>
            @endforeach
        </table>
	</div>
</body>
</html>