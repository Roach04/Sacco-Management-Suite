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
				Loans Disbursements as of <span> {{ $last }} </span>
			</strong>
		</p>

		
	</div>

	<div>
        <table class="table table-hover table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Transaction Date</th>
                    <th>Details</th>
                    <th>Disbursed Money</th>
                    <th>Cheque Number</th>
                    <th>Bank</th>
                </tr>
            </thead>
            @foreach($disburses as $disburse)
            <tbody>
                <tr>
                    <td>{{ $disburse->id }}</td>
                    <td>{{ Carbon\Carbon::createFromTimestamp(strtotime($disburse->created_at))->formatlocalized('%a %d %b %y') }}</td>
                    <td>{{ $disburse->firstname }} {{ $disburse->lastname }}</td>
                    <td>{{ number_format($disburse->disburseMoney) }}</td>
                    <td>{{ $disburse->chequeNumber }}</td>
                    <td>{{ $disburse->bank }}</td>
                </tr>
            </tbody>
            @endforeach
        </table>
	</div>
</body>
</html>