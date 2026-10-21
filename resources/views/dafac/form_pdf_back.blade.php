<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>DAFAC FORM</title>
<style>
body {
  font-family: Arial;
  color: rgb(0, 0, 0);
  margin: 0; /* Reset default margin */
}

.split {
  height: 107%;
  width: 52%; 
  position: fixed;
  z-index:0;
  top: -26;
  overflow-x: hidden; 
}

.left {
  left: -3%;
}

.right {
  right: -3%;
}

@media print {
  .left {
    left: -3%;
    border: 1px solid #204c64;
  }

  .right {
    right: -3%;
    border: 1px solid #204c64;
  }
}

td {
    border: 1px solid #262728;
    height: 40px;
    text-align: center; 
    vertical-align: middle;
}

th{
    text-align: center;
    border: 1px solid #262728;
}

.tbody{
    font-size: 8px;
    font-family: Arial, Helvetica, sans-serif;
    color: #1a1b1c;
    font-weight: 700;
}

.thead{
    font-size: 10px;
    font-family: Arial, Helvetica, sans-serif;
    color: #204c64;
    font-weight: 700;
}

.table {
    border-collapse: collapse;
    width: 100%; 
}
</style>
</head>
<body>
<div class="split left">
    <table class="table">
        <thead>
            <th colspan="9" style="background-color: #683c5c; text-align: center; color: white; font-size: 18px; font-family: Helvetica;">FAMILY ASSISTANCE RECORD</th>
        </thead>
        <tbody class="tbody">
            <tr>
                <th rowspan="2" width="45">DATE</th>
                <th rowspan="2" width="80">NAME OF RECEIVING FAMILY MEMBER</th>
                <th width="60"></th>
                <th colspan="5" width="60">ASSISTANCE PROVIDED</th>
                <th rowspan="2" width="50">SIGNATURE/<br>THUMBMARK</th>
            </tr>
            <tr>
                <th>EMERGENCY/<br>DISASTER</th>
                <th>ASSISTANCE</th>
                <th>UNIT</th>
                <th>QUANTITY</th>
                <th>COST</th>
                <th>PROVIDER</th>
            </tr>
            <tr>
                <td>{{ isset($assistances[0]->created_at) ? date('M d, Y', strtotime($assistances[0]->created_at)) : '' }}</td>
                <td>{{ isset($assistances[0]->fam_mem) ? ucwords($assistances[0]->fam_mem) : ''}}</td>
                <td>{{ isset($assistances[0]->em_dis) ? ucwords($assistances[0]->em_dis) : ''}}</td>
                <td>{{ isset($assistances[0]->assistance) ? ucwords($assistances[0]->assistance) : ''}}</td>
                <td>{{ isset($assistances[0]->unit) ? ucwords($assistances[0]->unit) : ''}}</td>
                <td>{{ isset($assistances[0]->quantity) ? ucwords($assistances[0]->quantity) : ''}}</td>
                <td>{{ isset($assistances[0]->cost) ? number_format($assistances[0]->cost, 2) : ''}}</td>
                <td>{{ isset($assistances[0]->provider) ? ucwords($assistances[0]->provider) : ''}}</td>
                <td></td>
            </tr>
            <tr>
                <td>{{ isset($assistances[1]->created_at) ? date('M d, Y', strtotime($assistances[1]->created_at)) : '' }}</td>
                <td>{{ isset($assistances[1]->fam_mem) ? ucwords($assistances[1]->fam_mem) : ''}}</td>
                <td>{{ isset($assistances[1]->em_dis) ? ucwords($assistances[1]->em_dis) : ''}}</td>
                <td>{{ isset($assistances[1]->assistance) ? ucwords($assistances[1]->assistance) : ''}}</td>
                <td>{{ isset($assistances[1]->unit) ? ucwords($assistances[1]->unit) : ''}}</td>
                <td>{{ isset($assistances[1]->quantity) ? ucwords($assistances[1]->quantity) : ''}}</td>
                <td>{{ isset($assistances[1]->cost) ? number_format($assistances[1]->cost, 2) : ''}}</td>
                <td>{{ isset($assistances[1]->provider) ? ucwords($assistances[1]->provider) : ''}}</td>
                <td></td>
            </tr>
            <tr>
                <td>{{ isset($assistances[2]->created_at) ? date('M d, Y', strtotime($assistances[2]->created_at)) : '' }}</td>
                <td>{{ isset($assistances[2]->fam_mem) ? ucwords($assistances[2]->fam_mem) : ''}}</td>
                <td>{{ isset($assistances[2]->em_dis) ? ucwords($assistances[2]->em_dis) : ''}}</td>
                <td>{{ isset($assistances[2]->assistance) ? ucwords($assistances[2]->assistance) : ''}}</td>
                <td>{{ isset($assistances[2]->unit) ? ucwords($assistances[2]->unit) : ''}}</td>
                <td>{{ isset($assistances[2]->quantity) ? ucwords($assistances[2]->quantity) : ''}}</td>
                <td>{{ isset($assistances[2]->cost) ? number_format($assistances[2]->cost, 2) : ''}}</td>
                <td>{{ isset($assistances[2]->provider) ? ucwords($assistances[2]->provider) : ''}}</td>
                <td></td>
            </tr>
            <tr>
                <td>{{ isset($assistances[3]->created_at) ? date('M d, Y', strtotime($assistances[3]->created_at)) : '' }}</td>
                <td>{{ isset($assistances[3]->fam_mem) ? ucwords($assistances[3]->fam_mem) : ''}}</td>
                <td>{{ isset($assistances[3]->em_dis) ? ucwords($assistances[3]->em_dis) : ''}}</td>
                <td>{{ isset($assistances[3]->assistance) ? ucwords($assistances[3]->assistance) : ''}}</td>
                <td>{{ isset($assistances[3]->unit) ? ucwords($assistances[3]->unit) : ''}}</td>
                <td>{{ isset($assistances[3]->quantity) ? ucwords($assistances[3]->quantity) : ''}}</td>
                <td>{{ isset($assistances[3]->cost) ? number_format($assistances[3]->cost, 2) : ''}}</td>
                <td>{{ isset($assistances[3]->provider) ? ucwords($assistances[3]->provider) : ''}}</td>
                <td></td>
            </tr>
            <tr>
                <td>{{ isset($assistances[4]->created_at) ? date('M d, Y', strtotime($assistances[4]->created_at)) : '' }}</td>
                <td>{{ isset($assistances[4]->fam_mem) ? ucwords($assistances[4]->fam_mem) : ''}}</td>
                <td>{{ isset($assistances[4]->em_dis) ? ucwords($assistances[4]->em_dis) : ''}}</td>
                <td>{{ isset($assistances[4]->assistance) ? ucwords($assistances[4]->assistance) : ''}}</td>
                <td>{{ isset($assistances[4]->unit) ? ucwords($assistances[4]->unit) : ''}}</td>
                <td>{{ isset($assistances[4]->quantity) ? ucwords($assistances[4]->quantity) : ''}}</td>
                <td>{{ isset($assistances[4]->cost) ? number_format($assistances[4]->cost, 2) : ''}}</td>
                <td>{{ isset($assistances[4]->provider) ? ucwords($assistances[4]->provider) : ''}}</td>
                <td></td>
            </tr>
            <tr>
                <td>{{ isset($assistances[5]->created_at) ? date('M d, Y', strtotime($assistances[5]->created_at)) : '' }}</td>
                <td>{{ isset($assistances[5]->fam_mem) ? ucwords($assistances[5]->fam_mem) : ''}}</td>
                <td>{{ isset($assistances[5]->em_dis) ? ucwords($assistances[5]->em_dis) : ''}}</td>
                <td>{{ isset($assistances[5]->assistance) ? ucwords($assistances[5]->assistance) : ''}}</td>
                <td>{{ isset($assistances[5]->unit) ? ucwords($assistances[5]->unit) : ''}}</td>
                <td>{{ isset($assistances[5]->quantity) ? ucwords($assistances[5]->quantity) : ''}}</td>
                <td>{{ isset($assistances[5]->cost) ? number_format($assistances[5]->cost, 2) : ''}}</td>
                <td>{{ isset($assistances[5]->provider) ? ucwords($assistances[5]->provider) : ''}}</td>
                <td></td>
            </tr>
            <tr>
                <td>{{ isset($assistances[6]->created_at) ? date('M d, Y', strtotime($assistances[6]->created_at)) : '' }}</td>
                <td>{{ isset($assistances[6]->fam_mem) ? ucwords($assistances[6]->fam_mem) : ''}}</td>
                <td>{{ isset($assistances[6]->em_dis) ? ucwords($assistances[6]->em_dis) : ''}}</td>
                <td>{{ isset($assistances[6]->assistance) ? ucwords($assistances[6]->assistance) : ''}}</td>
                <td>{{ isset($assistances[6]->unit) ? ucwords($assistances[6]->unit) : ''}}</td>
                <td>{{ isset($assistances[6]->quantity) ? ucwords($assistances[6]->quantity) : ''}}</td>
                <td>{{ isset($assistances[6]->cost) ? number_format($assistances[6]->cost, 2) : ''}}</td>
                <td>{{ isset($assistances[6]->provider) ? ucwords($assistances[6]->provider) : ''}}</td>
                <td></td>
            </tr>
            <tr>
                <td>{{ isset($assistances[7]->created_at) ? date('M d, Y', strtotime($assistances[7]->created_at)) : '' }}</td>
                <td>{{ isset($assistances[7]->fam_mem) ? ucwords($assistances[7]->fam_mem) : ''}}</td>
                <td>{{ isset($assistances[7]->em_dis) ? ucwords($assistances[7]->em_dis) : ''}}</td>
                <td>{{ isset($assistances[7]->assistance) ? ucwords($assistances[7]->assistance) : ''}}</td>
                <td>{{ isset($assistances[7]->unit) ? ucwords($assistances[7]->unit) : ''}}</td>
                <td>{{ isset($assistances[7]->quantity) ? ucwords($assistances[7]->quantity) : ''}}</td>
                <td>{{ isset($assistances[7]->cost) ? number_format($assistances[7]->cost, 2) : ''}}</td>
                <td>{{ isset($assistances[7]->provider) ? ucwords($assistances[7]->provider) : ''}}</td>
                <td></td>
            </tr>
            <tr>
                <td>{{ isset($assistances[8]->created_at) ? date('M d, Y', strtotime($assistances[8]->created_at)) : '' }}</td>
                <td>{{ isset($assistances[8]->fam_mem) ? ucwords($assistances[8]->fam_mem) : ''}}</td>
                <td>{{ isset($assistances[8]->em_dis) ? ucwords($assistances[8]->em_dis) : ''}}</td>
                <td>{{ isset($assistances[8]->assistance) ? ucwords($assistances[8]->assistance) : ''}}</td>
                <td>{{ isset($assistances[8]->unit) ? ucwords($assistances[8]->unit) : ''}}</td>
                <td>{{ isset($assistances[8]->quantity) ? ucwords($assistances[8]->quantity) : ''}}</td>
                <td>{{ isset($assistances[8]->cost) ? number_format($assistances[8]->cost, 2) : ''}}</td>
                <td>{{ isset($assistances[8]->provider) ? ucwords($assistances[8]->provider) : ''}}</td>
                <td></td>
            </tr>
            <tr>
                <td>{{ isset($assistances[9]->created_at) ? date('M d, Y', strtotime($assistances[9]->created_at)) : '' }}</td>
                <td>{{ isset($assistances[9]->fam_mem) ? ucwords($assistances[9]->fam_mem) : ''}}</td>
                <td>{{ isset($assistances[9]->em_dis) ? ucwords($assistances[9]->em_dis) : ''}}</td>
                <td>{{ isset($assistances[9]->assistance) ? ucwords($assistances[9]->assistance) : ''}}</td>
                <td>{{ isset($assistances[9]->unit) ? ucwords($assistances[9]->unit) : ''}}</td>
                <td>{{ isset($assistances[9]->quantity) ? ucwords($assistances[9]->quantity) : ''}}</td>
                <td>{{ isset($assistances[9]->cost) ? number_format($assistances[9]->cost, 2) : ''}}</td>
                <td>{{ isset($assistances[9]->provider) ? ucwords($assistances[9]->provider) : ''}}</td>
                <td></td>
            </tr>
            <tr>
                <td>{{ isset($assistances[10]->created_at) ? date('M d, Y', strtotime($assistances[10]->created_at)) : '' }}</td>
                <td>{{ isset($assistances[10]->fam_mem) ? ucwords($assistances[10]->fam_mem) : ''}}</td>
                <td>{{ isset($assistances[10]->em_dis) ? ucwords($assistances[10]->em_dis) : ''}}</td>
                <td>{{ isset($assistances[10]->assistance) ? ucwords($assistances[10]->assistance) : ''}}</td>
                <td>{{ isset($assistances[10]->unit) ? ucwords($assistances[10]->unit) : ''}}</td>
                <td>{{ isset($assistances[10]->quantity) ? ucwords($assistances[10]->quantity) : ''}}</td>
                <td>{{ isset($assistances[10]->cost) ? number_format($assistances[10]->cost, 2) : ''}}</td>
                <td>{{ isset($assistances[10]->provider) ? ucwords($assistances[10]->provider) : ''}}</td>
                <td></td>
            </tr>
            <tr>
                <td>{{ isset($assistances[11]->created_at) ? date('M d, Y', strtotime($assistances[11]->created_at)) : '' }}</td>
                <td>{{ isset($assistances[11]->fam_mem) ? ucwords($assistances[11]->fam_mem) : ''}}</td>
                <td>{{ isset($assistances[11]->em_dis) ? ucwords($assistances[11]->em_dis) : ''}}</td>
                <td>{{ isset($assistances[11]->assistance) ? ucwords($assistances[11]->assistance) : ''}}</td>
                <td>{{ isset($assistances[11]->unit) ? ucwords($assistances[11]->unit) : ''}}</td>
                <td>{{ isset($assistances[11]->quantity) ? ucwords($assistances[11]->quantity) : ''}}</td>
                <td>{{ isset($assistances[11]->cost) ? number_format($assistances[11]->cost, 2) : ''}}</td>
                <td>{{ isset($assistances[11]->provider) ? ucwords($assistances[11]->provider) : ''}}</td>
                <td></td>
            </tr>
            <tr>
                <td>{{ isset($assistances[12]->created_at) ? date('M d, Y', strtotime($assistances[12]->created_at)) : '' }}</td>
                <td>{{ isset($assistances[12]->fam_mem) ? ucwords($assistances[12]->fam_mem) : ''}}</td>
                <td>{{ isset($assistances[12]->em_dis) ? ucwords($assistances[12]->em_dis) : ''}}</td>
                <td>{{ isset($assistances[12]->assistance) ? ucwords($assistances[12]->assistance) : ''}}</td>
                <td>{{ isset($assistances[12]->unit) ? ucwords($assistances[12]->unit) : ''}}</td>
                <td>{{ isset($assistances[12]->quantity) ? ucwords($assistances[12]->quantity) : ''}}</td>
                <td>{{ isset($assistances[12]->cost) ? number_format($assistances[12]->cost, 2) : ''}}</td>
                <td>{{ isset($assistances[12]->provider) ? ucwords($assistances[12]->provider) : ''}}</td>
                <td></td>
            </tr>
            <tr>
                <td>{{ isset($assistances[13]->created_at) ? date('M d, Y', strtotime($assistances[13]->created_at)) : '' }}</td>
                <td>{{ isset($assistances[13]->fam_mem) ? ucwords($assistances[13]->fam_mem) : ''}}</td>
                <td>{{ isset($assistances[13]->em_dis) ? ucwords($assistances[13]->em_dis) : ''}}</td>
                <td>{{ isset($assistances[13]->assistance) ? ucwords($assistances[13]->assistance) : ''}}</td>
                <td>{{ isset($assistances[13]->unit) ? ucwords($assistances[13]->unit) : ''}}</td>
                <td>{{ isset($assistances[13]->quantity) ? ucwords($assistances[13]->quantity) : ''}}</td>
                <td>{{ isset($assistances[13]->cost) ? number_format($assistances[13]->cost, 2) : ''}}</td>
                <td>{{ isset($assistances[13]->provider) ? ucwords($assistances[13]->provider) : ''}}</td>
                <td></td>
            </tr>
            <tr>
                <td>{{ isset($assistances[14]->created_at) ? date('M d, Y', strtotime($assistances[14]->created_at)) : '' }}</td>
                <td>{{ isset($assistances[14]->fam_mem) ? ucwords($assistances[14]->fam_mem) : ''}}</td>
                <td>{{ isset($assistances[14]->em_dis) ? ucwords($assistances[14]->em_dis) : ''}}</td>
                <td>{{ isset($assistances[14]->assistance) ? ucwords($assistances[14]->assistance) : ''}}</td>
                <td>{{ isset($assistances[14]->unit) ? ucwords($assistances[14]->unit) : ''}}</td>
                <td>{{ isset($assistances[14]->quantity) ? ucwords($assistances[14]->quantity) : ''}}</td>
                <td>{{ isset($assistances[14]->cost) ? number_format($assistances[14]->cost, 2) : ''}}</td>
                <td>{{ isset($assistances[14]->provider) ? ucwords($assistances[14]->provider) : ''}}</td>
                <td></td>
            </tr>
            <tr>
                <td>{{ isset($assistances[15]->created_at) ? date('M d, Y', strtotime($assistances[15]->created_at)) : '' }}</td>
                <td>{{ isset($assistances[15]->fam_mem) ? ucwords($assistances[15]->fam_mem) : ''}}</td>
                <td>{{ isset($assistances[15]->em_dis) ? ucwords($assistances[15]->em_dis) : ''}}</td>
                <td>{{ isset($assistances[15]->assistance) ? ucwords($assistances[15]->assistance) : ''}}</td>
                <td>{{ isset($assistances[15]->unit) ? ucwords($assistances[15]->unit) : ''}}</td>
                <td>{{ isset($assistances[15]->quantity) ? ucwords($assistances[15]->quantity) : ''}}</td>
                <td>{{ isset($assistances[15]->cost) ? number_format($assistances[15]->cost, 2) : ''}}</td>
                <td>{{ isset($assistances[15]->provider) ? ucwords($assistances[15]->provider) : ''}}</td>
                <td></td>
            </tr>
            <tr>
                <td>{{ isset($assistances[16]->created_at) ? date('M d, Y', strtotime($assistances[16]->created_at)) : '' }}</td>
                <td>{{ isset($assistances[16]->fam_mem) ? ucwords($assistances[16]->fam_mem) : ''}}</td>
                <td>{{ isset($assistances[16]->em_dis) ? ucwords($assistances[16]->em_dis) : ''}}</td>
                <td>{{ isset($assistances[16]->assistance) ? ucwords($assistances[16]->assistance) : ''}}</td>
                <td>{{ isset($assistances[16]->unit) ? ucwords($assistances[16]->unit) : ''}}</td>
                <td>{{ isset($assistances[16]->quantity) ? ucwords($assistances[16]->quantity) : ''}}</td>
                <td>{{ isset($assistances[16]->cost) ? number_format($assistances[16]->cost, 2) : ''}}</td>
                <td>{{ isset($assistances[16]->provider) ? ucwords($assistances[16]->provider) : ''}}</td>
                <td></td>
            </tr>
            <tr>
                <td>{{ isset($assistances[17]->created_at) ? date('M d, Y', strtotime($assistances[17]->created_at)) : '' }}</td>
                <td>{{ isset($assistances[17]->fam_mem) ? ucwords($assistances[17]->fam_mem) : ''}}</td>
                <td>{{ isset($assistances[17]->em_dis) ? ucwords($assistances[17]->em_dis) : ''}}</td>
                <td>{{ isset($assistances[17]->assistance) ? ucwords($assistances[17]->assistance) : ''}}</td>
                <td>{{ isset($assistances[17]->unit) ? ucwords($assistances[17]->unit) : ''}}</td>
                <td>{{ isset($assistances[17]->quantity) ? ucwords($assistances[17]->quantity) : ''}}</td>
                <td>{{ isset($assistances[17]->cost) ? number_format($assistances[17]->cost, 2) : ''}}</td>
                <td>{{ isset($assistances[17]->provider) ? ucwords($assistances[17]->provider) : ''}}</td>
                <td></td>
            </tr>
            <tr>
                <td>{{ isset($assistances[18]->created_at) ? date('M d, Y', strtotime($assistances[18]->created_at)) : '' }}</td>
                <td>{{ isset($assistances[18]->fam_mem) ? ucwords($assistances[18]->fam_mem) : ''}}</td>
                <td>{{ isset($assistances[18]->em_dis) ? ucwords($assistances[18]->em_dis) : ''}}</td>
                <td>{{ isset($assistances[18]->assistance) ? ucwords($assistances[18]->assistance) : ''}}</td>
                <td>{{ isset($assistances[18]->unit) ? ucwords($assistances[18]->unit) : ''}}</td>
                <td>{{ isset($assistances[18]->quantity) ? ucwords($assistances[18]->quantity) : ''}}</td>
                <td>{{ isset($assistances[18]->cost) ? number_format($assistances[18]->cost, 2) : ''}}</td>
                <td>{{ isset($assistances[18]->provider) ? ucwords($assistances[18]->provider) : ''}}</td>
                <td></td>
            </tr>
            <tr>
                <td>{{ isset($assistances[19]->created_at) ? date('M d, Y', strtotime($assistances[19]->created_at)) : '' }}</td>
                <td>{{ isset($assistances[19]->fam_mem) ? ucwords($assistances[19]->fam_mem) : ''}}</td>
                <td>{{ isset($assistances[19]->em_dis) ? ucwords($assistances[19]->em_dis) : ''}}</td>
                <td>{{ isset($assistances[19]->assistance) ? ucwords($assistances[19]->assistance) : ''}}</td>
                <td>{{ isset($assistances[19]->unit) ? ucwords($assistances[19]->unit) : ''}}</td>
                <td>{{ isset($assistances[19]->quantity) ? ucwords($assistances[19]->quantity) : ''}}</td>
                <td>{{ isset($assistances[19]->cost) ? number_format($assistances[19]->cost, 2) : ''}}</td>
                <td>{{ isset($assistances[19]->provider) ? ucwords($assistances[19]->provider) : ''}}</td>
                <td></td>
            </tr>
        </tbody>
    </table>
</div>

<div class="split right">
    <table class="table">
        <thead>
            <th colspan="9" style="background-color: #683c5c; text-align: center; color: white; font-size: 18px; font-family: Helvetica;">FAMILY ASSISTANCE RECORD</th>
        </thead>
        <tbody class="tbody">
            <tr>
                <th rowspan="2" width="45">DATE</th>
                <th rowspan="2" width="80">NAME OF RECEIVING FAMILY MEMBER</th>
                <th width="60"></th>
                <th colspan="5" width="60">ASSISTANCE PROVIDED</th>
                <th rowspan="2" width="50">SIGNATURE/<br>THUMBMARK</th>
            </tr>
            <tr>
                <th>EMERGENCY/<br>DISASTER</th>
                <th>ASSISTANCE</th>
                <th>UNIT</th>
                <th>QUANTITY</th>
                <th>COST</th>
                <th>PROVIDER</th>
            </tr>
            <tr>
                <td>{{ isset($assistances[0]->created_at) ? date('M d, Y', strtotime($assistances[0]->created_at)) : '' }}</td>
                <td>{{ isset($assistances[0]->fam_mem) ? ucwords($assistances[0]->fam_mem) : ''}}</td>
                <td>{{ isset($assistances[0]->em_dis) ? ucwords($assistances[0]->em_dis) : ''}}</td>
                <td>{{ isset($assistances[0]->assistance) ? ucwords($assistances[0]->assistance) : ''}}</td>
                <td>{{ isset($assistances[0]->unit) ? ucwords($assistances[0]->unit) : ''}}</td>
                <td>{{ isset($assistances[0]->quantity) ? ucwords($assistances[0]->quantity) : ''}}</td>
                <td>{{ isset($assistances[0]->cost) ? number_format($assistances[0]->cost, 2) : ''}}</td>
                <td>{{ isset($assistances[0]->provider) ? ucwords($assistances[0]->provider) : ''}}</td>
                <td></td>
            </tr>
            <tr>
                <td>{{ isset($assistances[1]->created_at) ? date('M d, Y', strtotime($assistances[1]->created_at)) : '' }}</td>
                <td>{{ isset($assistances[1]->fam_mem) ? ucwords($assistances[1]->fam_mem) : ''}}</td>
                <td>{{ isset($assistances[1]->em_dis) ? ucwords($assistances[1]->em_dis) : ''}}</td>
                <td>{{ isset($assistances[1]->assistance) ? ucwords($assistances[1]->assistance) : ''}}</td>
                <td>{{ isset($assistances[1]->unit) ? ucwords($assistances[1]->unit) : ''}}</td>
                <td>{{ isset($assistances[1]->quantity) ? ucwords($assistances[1]->quantity) : ''}}</td>
                <td>{{ isset($assistances[1]->cost) ? number_format($assistances[1]->cost, 2) : ''}}</td>
                <td>{{ isset($assistances[1]->provider) ? ucwords($assistances[1]->provider) : ''}}</td>
                <td></td>
            </tr>
            <tr>
                <td>{{ isset($assistances[2]->created_at) ? date('M d, Y', strtotime($assistances[2]->created_at)) : '' }}</td>
                <td>{{ isset($assistances[2]->fam_mem) ? ucwords($assistances[2]->fam_mem) : ''}}</td>
                <td>{{ isset($assistances[2]->em_dis) ? ucwords($assistances[2]->em_dis) : ''}}</td>
                <td>{{ isset($assistances[2]->assistance) ? ucwords($assistances[2]->assistance) : ''}}</td>
                <td>{{ isset($assistances[2]->unit) ? ucwords($assistances[2]->unit) : ''}}</td>
                <td>{{ isset($assistances[2]->quantity) ? ucwords($assistances[2]->quantity) : ''}}</td>
                <td>{{ isset($assistances[2]->cost) ? number_format($assistances[2]->cost, 2) : ''}}</td>
                <td>{{ isset($assistances[2]->provider) ? ucwords($assistances[2]->provider) : ''}}</td>
                <td></td>
            </tr>
            <tr>
                <td>{{ isset($assistances[3]->created_at) ? date('M d, Y', strtotime($assistances[3]->created_at)) : '' }}</td>
                <td>{{ isset($assistances[3]->fam_mem) ? ucwords($assistances[3]->fam_mem) : ''}}</td>
                <td>{{ isset($assistances[3]->em_dis) ? ucwords($assistances[3]->em_dis) : ''}}</td>
                <td>{{ isset($assistances[3]->assistance) ? ucwords($assistances[3]->assistance) : ''}}</td>
                <td>{{ isset($assistances[3]->unit) ? ucwords($assistances[3]->unit) : ''}}</td>
                <td>{{ isset($assistances[3]->quantity) ? ucwords($assistances[3]->quantity) : ''}}</td>
                <td>{{ isset($assistances[3]->cost) ? number_format($assistances[3]->cost, 2) : ''}}</td>
                <td>{{ isset($assistances[3]->provider) ? ucwords($assistances[3]->provider) : ''}}</td>
                <td></td>
            </tr>
            <tr>
                <td>{{ isset($assistances[4]->created_at) ? date('M d, Y', strtotime($assistances[4]->created_at)) : '' }}</td>
                <td>{{ isset($assistances[4]->fam_mem) ? ucwords($assistances[4]->fam_mem) : ''}}</td>
                <td>{{ isset($assistances[4]->em_dis) ? ucwords($assistances[4]->em_dis) : ''}}</td>
                <td>{{ isset($assistances[4]->assistance) ? ucwords($assistances[4]->assistance) : ''}}</td>
                <td>{{ isset($assistances[4]->unit) ? ucwords($assistances[4]->unit) : ''}}</td>
                <td>{{ isset($assistances[4]->quantity) ? ucwords($assistances[4]->quantity) : ''}}</td>
                <td>{{ isset($assistances[4]->cost) ? number_format($assistances[4]->cost, 2) : ''}}</td>
                <td>{{ isset($assistances[4]->provider) ? ucwords($assistances[4]->provider) : ''}}</td>
                <td></td>
            </tr>
            <tr>
                <td>{{ isset($assistances[5]->created_at) ? date('M d, Y', strtotime($assistances[5]->created_at)) : '' }}</td>
                <td>{{ isset($assistances[5]->fam_mem) ? ucwords($assistances[5]->fam_mem) : ''}}</td>
                <td>{{ isset($assistances[5]->em_dis) ? ucwords($assistances[5]->em_dis) : ''}}</td>
                <td>{{ isset($assistances[5]->assistance) ? ucwords($assistances[5]->assistance) : ''}}</td>
                <td>{{ isset($assistances[5]->unit) ? ucwords($assistances[5]->unit) : ''}}</td>
                <td>{{ isset($assistances[5]->quantity) ? ucwords($assistances[5]->quantity) : ''}}</td>
                <td>{{ isset($assistances[5]->cost) ? number_format($assistances[5]->cost, 2) : ''}}</td>
                <td>{{ isset($assistances[5]->provider) ? ucwords($assistances[5]->provider) : ''}}</td>
                <td></td>
            </tr>
            <tr>
                <td>{{ isset($assistances[6]->created_at) ? date('M d, Y', strtotime($assistances[6]->created_at)) : '' }}</td>
                <td>{{ isset($assistances[6]->fam_mem) ? ucwords($assistances[6]->fam_mem) : ''}}</td>
                <td>{{ isset($assistances[6]->em_dis) ? ucwords($assistances[6]->em_dis) : ''}}</td>
                <td>{{ isset($assistances[6]->assistance) ? ucwords($assistances[6]->assistance) : ''}}</td>
                <td>{{ isset($assistances[6]->unit) ? ucwords($assistances[6]->unit) : ''}}</td>
                <td>{{ isset($assistances[6]->quantity) ? ucwords($assistances[6]->quantity) : ''}}</td>
                <td>{{ isset($assistances[6]->cost) ? number_format($assistances[6]->cost, 2) : ''}}</td>
                <td>{{ isset($assistances[6]->provider) ? ucwords($assistances[6]->provider) : ''}}</td>
                <td></td>
            </tr>
            <tr>
                <td>{{ isset($assistances[7]->created_at) ? date('M d, Y', strtotime($assistances[7]->created_at)) : '' }}</td>
                <td>{{ isset($assistances[7]->fam_mem) ? ucwords($assistances[7]->fam_mem) : ''}}</td>
                <td>{{ isset($assistances[7]->em_dis) ? ucwords($assistances[7]->em_dis) : ''}}</td>
                <td>{{ isset($assistances[7]->assistance) ? ucwords($assistances[7]->assistance) : ''}}</td>
                <td>{{ isset($assistances[7]->unit) ? ucwords($assistances[7]->unit) : ''}}</td>
                <td>{{ isset($assistances[7]->quantity) ? ucwords($assistances[7]->quantity) : ''}}</td>
                <td>{{ isset($assistances[7]->cost) ? number_format($assistances[7]->cost, 2) : ''}}</td>
                <td>{{ isset($assistances[7]->provider) ? ucwords($assistances[7]->provider) : ''}}</td>
                <td></td>
            </tr>
            <tr>
                <td>{{ isset($assistances[8]->created_at) ? date('M d, Y', strtotime($assistances[8]->created_at)) : '' }}</td>
                <td>{{ isset($assistances[8]->fam_mem) ? ucwords($assistances[8]->fam_mem) : ''}}</td>
                <td>{{ isset($assistances[8]->em_dis) ? ucwords($assistances[8]->em_dis) : ''}}</td>
                <td>{{ isset($assistances[8]->assistance) ? ucwords($assistances[8]->assistance) : ''}}</td>
                <td>{{ isset($assistances[8]->unit) ? ucwords($assistances[8]->unit) : ''}}</td>
                <td>{{ isset($assistances[8]->quantity) ? ucwords($assistances[8]->quantity) : ''}}</td>
                <td>{{ isset($assistances[8]->cost) ? number_format($assistances[8]->cost, 2) : ''}}</td>
                <td>{{ isset($assistances[8]->provider) ? ucwords($assistances[8]->provider) : ''}}</td>
                <td></td>
            </tr>
            <tr>
                <td>{{ isset($assistances[9]->created_at) ? date('M d, Y', strtotime($assistances[9]->created_at)) : '' }}</td>
                <td>{{ isset($assistances[9]->fam_mem) ? ucwords($assistances[9]->fam_mem) : ''}}</td>
                <td>{{ isset($assistances[9]->em_dis) ? ucwords($assistances[9]->em_dis) : ''}}</td>
                <td>{{ isset($assistances[9]->assistance) ? ucwords($assistances[9]->assistance) : ''}}</td>
                <td>{{ isset($assistances[9]->unit) ? ucwords($assistances[9]->unit) : ''}}</td>
                <td>{{ isset($assistances[9]->quantity) ? ucwords($assistances[9]->quantity) : ''}}</td>
                <td>{{ isset($assistances[9]->cost) ? number_format($assistances[9]->cost, 2) : ''}}</td>
                <td>{{ isset($assistances[9]->provider) ? ucwords($assistances[9]->provider) : ''}}</td>
                <td></td>
            </tr>
            <tr>
                <td>{{ isset($assistances[10]->created_at) ? date('M d, Y', strtotime($assistances[10]->created_at)) : '' }}</td>
                <td>{{ isset($assistances[10]->fam_mem) ? ucwords($assistances[10]->fam_mem) : ''}}</td>
                <td>{{ isset($assistances[10]->em_dis) ? ucwords($assistances[10]->em_dis) : ''}}</td>
                <td>{{ isset($assistances[10]->assistance) ? ucwords($assistances[10]->assistance) : ''}}</td>
                <td>{{ isset($assistances[10]->unit) ? ucwords($assistances[10]->unit) : ''}}</td>
                <td>{{ isset($assistances[10]->quantity) ? ucwords($assistances[10]->quantity) : ''}}</td>
                <td>{{ isset($assistances[10]->cost) ? number_format($assistances[10]->cost, 2) : ''}}</td>
                <td>{{ isset($assistances[10]->provider) ? ucwords($assistances[10]->provider) : ''}}</td>
                <td></td>
            </tr>
            <tr>
                <td>{{ isset($assistances[11]->created_at) ? date('M d, Y', strtotime($assistances[11]->created_at)) : '' }}</td>
                <td>{{ isset($assistances[11]->fam_mem) ? ucwords($assistances[11]->fam_mem) : ''}}</td>
                <td>{{ isset($assistances[11]->em_dis) ? ucwords($assistances[11]->em_dis) : ''}}</td>
                <td>{{ isset($assistances[11]->assistance) ? ucwords($assistances[11]->assistance) : ''}}</td>
                <td>{{ isset($assistances[11]->unit) ? ucwords($assistances[11]->unit) : ''}}</td>
                <td>{{ isset($assistances[11]->quantity) ? ucwords($assistances[11]->quantity) : ''}}</td>
                <td>{{ isset($assistances[11]->cost) ? number_format($assistances[11]->cost, 2) : ''}}</td>
                <td>{{ isset($assistances[11]->provider) ? ucwords($assistances[11]->provider) : ''}}</td>
                <td></td>
            </tr>
            <tr>
                <td>{{ isset($assistances[12]->created_at) ? date('M d, Y', strtotime($assistances[12]->created_at)) : '' }}</td>
                <td>{{ isset($assistances[12]->fam_mem) ? ucwords($assistances[12]->fam_mem) : ''}}</td>
                <td>{{ isset($assistances[12]->em_dis) ? ucwords($assistances[12]->em_dis) : ''}}</td>
                <td>{{ isset($assistances[12]->assistance) ? ucwords($assistances[12]->assistance) : ''}}</td>
                <td>{{ isset($assistances[12]->unit) ? ucwords($assistances[12]->unit) : ''}}</td>
                <td>{{ isset($assistances[12]->quantity) ? ucwords($assistances[12]->quantity) : ''}}</td>
                <td>{{ isset($assistances[12]->cost) ? number_format($assistances[12]->cost, 2) : ''}}</td>
                <td>{{ isset($assistances[12]->provider) ? ucwords($assistances[12]->provider) : ''}}</td>
                <td></td>
            </tr>
            <tr>
                <td>{{ isset($assistances[13]->created_at) ? date('M d, Y', strtotime($assistances[13]->created_at)) : '' }}</td>
                <td>{{ isset($assistances[13]->fam_mem) ? ucwords($assistances[13]->fam_mem) : ''}}</td>
                <td>{{ isset($assistances[13]->em_dis) ? ucwords($assistances[13]->em_dis) : ''}}</td>
                <td>{{ isset($assistances[13]->assistance) ? ucwords($assistances[13]->assistance) : ''}}</td>
                <td>{{ isset($assistances[13]->unit) ? ucwords($assistances[13]->unit) : ''}}</td>
                <td>{{ isset($assistances[13]->quantity) ? ucwords($assistances[13]->quantity) : ''}}</td>
                <td>{{ isset($assistances[13]->cost) ? number_format($assistances[13]->cost, 2) : ''}}</td>
                <td>{{ isset($assistances[13]->provider) ? ucwords($assistances[13]->provider) : ''}}</td>
                <td></td>
            </tr>
            <tr>
                <td>{{ isset($assistances[14]->created_at) ? date('M d, Y', strtotime($assistances[14]->created_at)) : '' }}</td>
                <td>{{ isset($assistances[14]->fam_mem) ? ucwords($assistances[14]->fam_mem) : ''}}</td>
                <td>{{ isset($assistances[14]->em_dis) ? ucwords($assistances[14]->em_dis) : ''}}</td>
                <td>{{ isset($assistances[14]->assistance) ? ucwords($assistances[14]->assistance) : ''}}</td>
                <td>{{ isset($assistances[14]->unit) ? ucwords($assistances[14]->unit) : ''}}</td>
                <td>{{ isset($assistances[14]->quantity) ? ucwords($assistances[14]->quantity) : ''}}</td>
                <td>{{ isset($assistances[14]->cost) ? number_format($assistances[14]->cost, 2) : ''}}</td>
                <td>{{ isset($assistances[14]->provider) ? ucwords($assistances[14]->provider) : ''}}</td>
                <td></td>
            </tr>
            <tr>
                <td>{{ isset($assistances[15]->created_at) ? date('M d, Y', strtotime($assistances[15]->created_at)) : '' }}</td>
                <td>{{ isset($assistances[15]->fam_mem) ? ucwords($assistances[15]->fam_mem) : ''}}</td>
                <td>{{ isset($assistances[15]->em_dis) ? ucwords($assistances[15]->em_dis) : ''}}</td>
                <td>{{ isset($assistances[15]->assistance) ? ucwords($assistances[15]->assistance) : ''}}</td>
                <td>{{ isset($assistances[15]->unit) ? ucwords($assistances[15]->unit) : ''}}</td>
                <td>{{ isset($assistances[15]->quantity) ? ucwords($assistances[15]->quantity) : ''}}</td>
                <td>{{ isset($assistances[15]->cost) ? number_format($assistances[15]->cost, 2) : ''}}</td>
                <td>{{ isset($assistances[15]->provider) ? ucwords($assistances[15]->provider) : ''}}</td>
                <td></td>
            </tr>
            <tr>
                <td>{{ isset($assistances[16]->created_at) ? date('M d, Y', strtotime($assistances[16]->created_at)) : '' }}</td>
                <td>{{ isset($assistances[16]->fam_mem) ? ucwords($assistances[16]->fam_mem) : ''}}</td>
                <td>{{ isset($assistances[16]->em_dis) ? ucwords($assistances[16]->em_dis) : ''}}</td>
                <td>{{ isset($assistances[16]->assistance) ? ucwords($assistances[16]->assistance) : ''}}</td>
                <td>{{ isset($assistances[16]->unit) ? ucwords($assistances[16]->unit) : ''}}</td>
                <td>{{ isset($assistances[16]->quantity) ? ucwords($assistances[16]->quantity) : ''}}</td>
                <td>{{ isset($assistances[16]->cost) ? number_format($assistances[16]->cost, 2) : ''}}</td>
                <td>{{ isset($assistances[16]->provider) ? ucwords($assistances[16]->provider) : ''}}</td>
                <td></td>
            </tr>
            <tr>
                <td>{{ isset($assistances[17]->created_at) ? date('M d, Y', strtotime($assistances[17]->created_at)) : '' }}</td>
                <td>{{ isset($assistances[17]->fam_mem) ? ucwords($assistances[17]->fam_mem) : ''}}</td>
                <td>{{ isset($assistances[17]->em_dis) ? ucwords($assistances[17]->em_dis) : ''}}</td>
                <td>{{ isset($assistances[17]->assistance) ? ucwords($assistances[17]->assistance) : ''}}</td>
                <td>{{ isset($assistances[17]->unit) ? ucwords($assistances[17]->unit) : ''}}</td>
                <td>{{ isset($assistances[17]->quantity) ? ucwords($assistances[17]->quantity) : ''}}</td>
                <td>{{ isset($assistances[17]->cost) ? number_format($assistances[17]->cost, 2) : ''}}</td>
                <td>{{ isset($assistances[17]->provider) ? ucwords($assistances[17]->provider) : ''}}</td>
                <td></td>
            </tr>
            <tr>
                <td>{{ isset($assistances[18]->created_at) ? date('M d, Y', strtotime($assistances[18]->created_at)) : '' }}</td>
                <td>{{ isset($assistances[18]->fam_mem) ? ucwords($assistances[18]->fam_mem) : ''}}</td>
                <td>{{ isset($assistances[18]->em_dis) ? ucwords($assistances[18]->em_dis) : ''}}</td>
                <td>{{ isset($assistances[18]->assistance) ? ucwords($assistances[18]->assistance) : ''}}</td>
                <td>{{ isset($assistances[18]->unit) ? ucwords($assistances[18]->unit) : ''}}</td>
                <td>{{ isset($assistances[18]->quantity) ? ucwords($assistances[18]->quantity) : ''}}</td>
                <td>{{ isset($assistances[18]->cost) ? number_format($assistances[18]->cost, 2) : ''}}</td>
                <td>{{ isset($assistances[18]->provider) ? ucwords($assistances[18]->provider) : ''}}</td>
                <td></td>
            </tr>
            <tr>
                <td>{{ isset($assistances[19]->created_at) ? date('M d, Y', strtotime($assistances[19]->created_at)) : '' }}</td>
                <td>{{ isset($assistances[19]->fam_mem) ? ucwords($assistances[19]->fam_mem) : ''}}</td>
                <td>{{ isset($assistances[19]->em_dis) ? ucwords($assistances[19]->em_dis) : ''}}</td>
                <td>{{ isset($assistances[19]->assistance) ? ucwords($assistances[19]->assistance) : ''}}</td>
                <td>{{ isset($assistances[19]->unit) ? ucwords($assistances[19]->unit) : ''}}</td>
                <td>{{ isset($assistances[19]->quantity) ? ucwords($assistances[19]->quantity) : ''}}</td>
                <td>{{ isset($assistances[19]->cost) ? number_format($assistances[19]->cost, 2) : ''}}</td>
                <td>{{ isset($assistances[19]->provider) ? ucwords($assistances[19]->provider) : ''}}</td>
                <td></td>
            </tr>
        </tbody>
    </table>
</div>

</body>
</html>