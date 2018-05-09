<!DOCTYPE html>
<html>
<head>
	<title> Co-op Bank Cash Book PDF. </title>

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
				Petty Cash Cashbook as of <span> {{ $last }} </span>
			</strong>
		</p>

		<p> 
            <span style="color:grey"> Opening Balance &nbsp; </span> 
            <span style="color:#ff7676; font:normal 20px book antiqua"> 
                <strong> {{ number_format($pettycashopeningbalance, 2) }} </strong>
            </span> 

            <span style="color:black"> &nbsp;&nbsp; | &nbsp;&nbsp; </span>

			<span style="color:grey"> Ending Balance &nbsp; </span> 
            <span style="color:#796AEE; font:bold 20px book antiqua"> 
                <strong> {{ number_format($pettycashAccount, 2) }} </strong>
            </span>

            <!-- <span style="color:black"> &nbsp;&nbsp; | &nbsp;&nbsp; </span>

            <span style="color:grey"> Equity Bank &nbsp; </span> 
            <span style="color:#54e69d; font:bold 20px book antiqua"> 
                <strong> {{ number_format($equityAggregate, 2) }} </strong>
            </span> -->
		</p>
	</div>

	<div>
		<table>
			<thead>
        		<tr>
        			<th> # </th>
        			<th> Transaction Date </th>
        			<th> Details </th>
        			<th> Debit </th>
        			<th> Credit </th>						                			
        			<th> Account </th>
        		</tr>
        	</thead>
        	@foreach($savings as $save)
            	<tbody>
            		<tr>
            			<th scope="row">{{ $save->id }}</th>
            			<td>{{ $save->created_at->formatlocalized('%a %d %b %y') }}</td>
            			<td>{{ $save->details }}</td>
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
		</table>
	</div>
</body>
</html>