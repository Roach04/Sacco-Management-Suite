<!DOCTYPE html>
<html>
<head>
	<title> PDF Members. </title>
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

			font-size: 40px;
			font-style: book antiqua;
			float: right;
		}

		span {

			font-size: 30px;
			font-style: book antiqua;
			color: #666;
		}
	</style>
</head>
<body>

	<div style="text-align:center">
		<img src="img/logo.jpg" width="40%" height="40%">

		<!-- <p> 
			<strong> Sacco Members </strong>
		</p>

		<p>
			<span style="float:right"> {{ $today }} </span>
		</p> -->

		
	</div>

	<div>
		<table class="table table-hover table-responsive">
            <thead>
              	<tr>
                    <th>#</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Gender</th>
                    <th>Bank</th>
                    <th>Bank Acc No</th>
                    <th>Occupation</th>
                    <th>Acc Type</th>
                    <th>Marital Status</th>
                    <th>Mobile Number</th>
                    <th>ID Number</th>
                    <th>Email Address</th>
                    <th>DOB</th>
                    <th>P.O Box</th>
                    <th>County</th>
                    <th>Nationality</th>
                    <!-- <th>Kin First Name</th>
                    <th>Kin Last Name</th>
                    <th>Kin Gender</th>
                    <th>Kin Occupation</th>
                    <th>Kin Marital Status</th>
                    <th>Kin Mobile Number</th>
                    <th>Kin ID Number</th>
                    <th>Kin Relationship</th>
                    <th>Kin Email Address</th>
                    <th>Kin DOB</th>
                    <th>Kin P.O Box</th>
                    <th>Kin County</th>
                    <th>Kin Nationality</th> -->
                    
              	</tr>
            </thead>
            @foreach($pageMembers as $member)
                <tbody>
                  	<tr>
                        <th scope="row">{{ $member->accountNumber }}</th>
                        <td>{{ $member->firstname }}</td>
                        <td>{{ $member->lastname }}</td>
                        <td>{{ $member->gender }}</td>
                        <td>{{ $member->bankName }}</td>
                        <td>{{ $member->bankAccountNumber }}</td>
                        <td>{{ $member->occupation }}</td>
                        <td>{{ $member->accountType }}</td>
                        <td>{{ $member->maritalStatus }}</td>
                        <td>{{ $member->phoneNumber }}</td>
                        <td>{{ $member->idNumber }}</td>
                        <td>{{ $member->emailAddress }}</td>
                        <td>{{ Carbon\Carbon::createFromTimestamp(strtotime($member->dateOfBirth))->formatlocalized('%a %d %b %y') }}</td>
                        <td>{{ $member->poBox }}</td>
                        <td>{{ $member->county }}</td>
                        <td>{{ $member->nationality }}</td>
                        <!-- <td>{{ $member->firstnameKin }}</td>
                        <td>{{ $member->lastnameKin }}</td>
                        <td>{{ $member->genderKin }}</td>
                        <td>{{ $member->occupationKin }}</td>
                        <td>{{ $member->maritalStatusKin }}</td>
                        <td>{{ $member->phoneNumberKin }}</td>
                        <td>{{ $member->idNumberKin }}</td>
                        <td>{{ $member->relationshipKin }}</td>
                        <td>{{ $member->emailAddressKin }}</td>
                        <td>{{ Carbon\Carbon::createFromTimestamp(strtotime($member->dateOfBirthKin))->formatlocalized('%a %d %b %y') }}</td>
                        <td>{{ $member->poBoxKin }}</td>
                        <td>{{ $member->countyKin }}</td>
                        <td>{{ $member->nationalityKin }}</td> -->
                  	</tr>
                </tbody>
            @endforeach
			</table>
	</div>

		
	
	
</body>
</html>			