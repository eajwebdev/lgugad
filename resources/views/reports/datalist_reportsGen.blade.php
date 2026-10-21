<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title></title>
	<style>
		body {
			font-size: 9;
			font-family: Times New Roman;
		}
	    .title_task{
	        font-size: 12pt;
	        font-family: Arial, sans-serif;
	        font-weight: bold;
	        text-align: center;
	    }
	    .date_gen{
	        margin-top: -2px;
	        font-size: 11pt;
	        font-family: Arial, sans-serif;
	        text-align: center;
	    }
	    table {
	        border-collapse: collapse;
	        width: 100%;
	        font-family: Arial, sans-serif;
	        font-size: 12px;
	    }
	    th, td {
	        padding: 8px;
	        text-align: left;
	        border: 1px solid #000;
	    }
	    th {
	        background-color: #f2f2f2;
	    }
	    tfoot td {
	        font-weight: bold;
	    }
	    .name_person{
	        padding-right: 50px;
	        padding-top: 30px;
	        font-size: 11pt;
	        font-weight: bold;
	        font-family: Arial, sans-serif;
	        text-align: right;
	    }
	    .position_person{
	        padding-right: 100px;
	        margin-top: -30px;
	        font-size: 11pt;
	        font-family: Arial, sans-serif;
	        text-align: right;
	    }
	    .supervisor_person{
	        padding-left: 30px;
	        padding-top: 30px;
	        font-size: 11pt;
	        font-weight: bold;
	        font-family: Arial, sans-serif;
	        text-align: left;
	    }
	    .supervisor_position{
	        padding-left: 35px;
	        margin-top: -30px;
	        font-size: 11pt;
	        font-family: Arial, sans-serif;
	        text-align: left;
	    }
	    .footer-logo-container {
	        position: absolute;
	        left: 10;
	        bottom: -10;
	        width: 100%;
	        text-align: center;
	    }

	    .footer-logo {
	        max-width: 100%;
	        max-height: 20%;
	        display: inline-block;
	        vertical-align: bottom;
	    }
	</style>
</head>
<body>
	<div>
	    <center>
	        <img src="{{ \App\Support\PdfAsset::image('template/img/idheader.png') }}" width="70%" height="8%" style="margin-top: -8px;">
	    </center>
	</div>

	<div style="border-bottom: 1px solid #000; width: 100%;"></div>

	<div>
	    <p class="title_task">Reports</p>
	</div>

	<div>
	    <p class="date_gen">
			@php
			    $gender = request('gender');
			    $agebracket = request('agebracket');
			@endphp
			<p class='date_gen'>Selected Gender: {{ $gender }} - Selected Age Bracket: {{ $agebracket }}</p>
	    </p>
	</div>

	<br>

	<div style="padding-right: 10px; padding-left: 10px;">
	    <table>
	        <thead>
	            <tr>
	                <th>No</th>
                    <th>OSCA ID</th>
                    <th>Name</th>
                    <th>Gender</th>
                    <th>Birthday</th>
                    <th>Age</th>
                    <th>Pensioner</th>
                    <th>Remarks</th>
	            </tr>
	        </thead>
	        <tbody>
	            @if ($genSenior->isEmpty())
				<tr>
				    <td colspan="8" style="text-align: center;">No Data based on selected age bracket.</td>
				</tr>
				@else
					@php $no = 1; @endphp
				    @foreach ($genSenior as $generateReport)
				        <tr>
				            <td>{{ $no++ }}</td>
				            <td class="text-capitalize">{{ $generateReport->osca_idnum }}</td>
                            <td class="text-capitalize">{{ $generateReport->lname }}, {{ $generateReport->fname }}  {{ $generateReport->mname }} {{ $generateReport->ext }}</td>
                            <td class="text-capitalize">{{ $generateReport->gender }}</td>
                            <td class="text-capitalize">{{ $generateReport->birth_date_label }}</td>
                            <td class="text-capitalize">{{ $generateReport->current_age === null ? '—' : $generateReport->current_age . ' yrs. old' }}</td>
                            <td class="text-capitalize">{{ $generateReport->curr_pension }} yrs. old</td>
                            <td class="text-capitalize"></td>


				        </tr>
				    @endforeach
				@endif
	        </tbody>
	    </table>
	</div>

</body>
</html>
