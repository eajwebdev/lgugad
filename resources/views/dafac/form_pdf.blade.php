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
  border: 3px solid #204c64;
}

.right {
  right: -3%;
  border: 3px solid #204c64;
}
@media print {
  .left {
    left: -3%;
    border: 3px solid #204c64;
  }

  .right {
    right: -3%;
    border: 3px solid #204c64;
  }
}

.left img {
  max-width: 100%;
  height: auto;
}

.tbody{
    font-size: 10px;
    font-family: Arial, Helvetica, sans-serif;
    color: #204c64;
    font-weight: 700;
}

.tbody-2{
    font-size: 7px;
    font-family: Arial, Helvetica, sans-serif;
    color: #204c64;
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

.table-2 {
    border-collapse: collapse;
    width: 98%; 
    margin-left: 1%;
}

.member {
    border: 0.5px solid black;
    height: 17px;
    text-align: center;
    font-size: 8px;
    overflow: hidden;
}

.member-1{
    font-size: 8px; 
}

.border-b{
    border-bottom: 1px solid black;
    width: 100%;
}
.border-t{
    border-top: 1px solid black;
}
input[type="checkbox"] {
    transform: scale(1.5); 
    border-color: #204c64;
    text-align: center;
    padding: 0px;
    margin: 0%;
    width: 35%;
    color: #204c64;
}
input[type="text"]{
    height: 16px;
    border-color: #204c64;
    text-align: center;
    padding: 0px;
    margin: 0%;
    width: 95%;
    padding-top: 2px; 
    color: rgb(48, 47, 47);
}
.float-container {
    position: relative;
}

.serial-float-over {
    position: absolute;
    top: 49px;
    left: 43%; 
    transform: translateX(-50%);
    padding: 1px; 
    font-size: 9px;
    color: #204c64;
}
</style>
</head>
<body>
@php
    $age = (string)$dafac->age;
    $digone = $age[0];
    $digtwo = $age[1];

    $memfnameArray = $dafac->mem_fname;
    $memfnameArray = explode(',', $memfnameArray);

    $mem_relationArray = $dafac->mem_relation;
    $mem_relationArray = explode(',', $mem_relationArray);

    $mem_bDateArray = $dafac->mem_bdate;
    $mem_bDateArray = explode(',', $mem_bDateArray);

    $mem_ageArray = $dafac->mem_age;
    $mem_ageArray = explode(',', $mem_ageArray);

    $mem_genderArray = $dafac->mem_gender;
    $mem_genderArray = explode(',', $mem_genderArray);

    $mem_educArray = $dafac->mem_educ;
    $mem_educArray = explode(',', $mem_educArray);

    $mem_occupArray = $dafac->mem_occup;
    $mem_occupArray = explode(',', $mem_occupArray);

    $mem_remarksArray = $dafac->mem_remarks;
    $mem_remarksArray = explode(',', $mem_remarksArray);
    
    $checklistArray = $dafac->checklist;
    $checklistArray = explode(',', $checklistArray);

    
@endphp

<div class="split left">
    <table class="table">
        <thead>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
        </thead>
        <tbody class="tbody">
            <tr>
                <td width="80%"><img src="{{ asset('uploads/dafac-header-2024.png') }}"  alt=""></td>
                <td width="27%" class="float-container">
                    <img src="{{ asset('uploads/dafac-bene-copy.png') }}" width="100%" alt="">
                    <span class="serial-float-over">{{ $dafac->serial }}</span>
                </td>
            <tr>
                <td colspan="4" style="background-color: #204c64;  height: 16px; text-align: center; color: white; font-weight: 700;">LOCATION OF AFFECTED FAMILY</td>
            </tr>
        </tbody>
    </table>
    <table class="table">
        <thead>
            <th width="17%"></th>
            <th width="30%"></th>
            <th width="25%"></th>
            <th width="30%"></th>
        </thead>
        <tbody class="tbody">
            <tr>
                <td>1. REGION</td>
                <td><input type="text" value="{{ $dafac->regionname }}"></td>
                <td>4. CITY/MUNICIPALITY</td>
                <td><input type="text" value="{{ $dafac->cityname }}"></td>
            </tr>
            <tr>
                <td>2. PROVINCE</td>
                <td><input type="text" value="{{ $dafac->provincename }}"></td>
                <td>5. BRANGAY</td>
                <td><input type="text" value="{{ $dafac->brgyname }}"></td>
            </tr>
            <tr>
                <td>3. DISTRICT</td>
                <td><input type="text" value="{{ $dafac->district }}"></td>
                <td>6. EVACUATION CENTER/<br>EVACUATION SITE</td>
                <td><input type="text" value="{{ $dafac->brgy_evac_site }}"></td>
            </tr>
            <tr>
                <td colspan="4" style="background-color: #204c64;  height: 16px; margin-bottom: 5px; text-align: center; color: white; font-weight: 700;">HEAD OF THE FAMILY</td>
            </tr>
            <tr>
                <td>7. LAST NAME</td>
                <td><input type="text" value="{{ ucwords(strtoupper($dafac->surname)) }}"></td>
                <td>15. CIVIL STATUS</td>
                <td><input type="text" value="{{ ucwords(strtoupper($dafac->civil_status)) }}"></td>
            </tr>
            <tr>
                <td>8. FIRST NAME</td>
                <td><input type="text" value="{{ ucwords(strtoupper($dafac->fname)) }}"></td>
                <td>16. MOTHER'S MAIDEN NAME</td>
                <td><input type="text" value="{{ ucwords(strtoupper($dafac->m_maid_name)) }}"></td>
            </tr>
            <tr>
                <td>9. MIDDLE NAME</td>
                <td><input type="text" value="{{ ucwords(strtoupper($dafac->mname)) }}"></td>
                <td>17. RELIGION</td>
                <td><input type="text" value="{{ ucwords(strtoupper($dafac->religion)) }}"></td>
            </tr>
            <tr>
                <td>10. NAME EXT.<span style="font-size: 6px; margin-left: 30px;">(Jr.,S.I)</span></td>
                <td><input type="text" value="{{ $dafac->ext }}"></td>
                <td>18. CITY/MUNICIPALITY</td>
                <td style="border-bottom: 1px solid black; padding: 8px 5px; text-align: center; text-transform: capitalize;">
                    {{ ucwords(strtolower($headbrgy?->name ?? '')) }}
                </td>
            </tr>
            <tr>
                <td>11. BIRTH DATE<span style="font-size: 6px; margin-left: 13px;">(Ex. 01 January 2021)</span></td>
                <td><input type="text" value="{{ \Carbon\Carbon::parse($dafac->d_birth)->format('d F Y') }}"></td>
                <td>19. OCCUPATION</td>
                <td><input type="text" value="{{ ucwords(strtoupper($dafac->occupation)) }}"></td>
            </tr>
            <tr>
                <td>12. AGE</td>
                <td><input type="text" value="{{ $dafac->age }}"></td>
                <td>20. MONTHLY FAMILY INCOME</td>
                <td><input type="text" value="{{ number_format($dafac->mincome, 2) }}"></td>
            </tr>
            <tr>
                <td>13. BIRTHPLACE</td>
                <td><input type="text" value="{{ ucwords(strtoupper($dafac->b_place)) }}"></td>
                <td>21. ID CARD PRESENTED</td>
                <td><input type="text" value="{{ ucwords(strtoupper($dafac->id_present)) }}"></td>
            </tr>
            <tr>
                <td>14. SEX</td>
                <td>
                    <div style="float: left; position: relative; margin-left: 6px; margin-top: 10px;">
                        <input type="checkbox" @if($dafac->gender == "M") checked @endif> 
                        <span style="position: absolute; top: 2px; left: 150%; transform: translateX(-40%);">MALE</span>
                    </div>
                    
                    <div style="float: left; position: relative; margin-top: 10px;  margin-left: 50px;">
                        <input type="checkbox" @if($dafac->gender == "F") checked @endif> 
                        <span style="position: absolute; top: 2px; left: 180%; transform: translateX(-40%);">FEMALE</span>
                    </div>
                </td>
                              
                <td>22. ID CARD NUMBER</td>
                <td style="float: left; position: relative; margin-top: 10px;  margin-left: 50px;"><input type="text" value="{{ ucwords(strtoupper($dafac->id_cardnum)) }}"></td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td>23. CONTACT NUMBER</td>
                <td>
                    <input style="width: 46%; height: 25px; margin-top: 8px;" type="text" value="{{ $dafac->contact_1 }}">
                    <input style="width: 46%; height: 25px;" type="text" value="{{ $dafac->contact_2 }}">
                </td>                
                
            </tr>
            <tr>
                <td>24. PERMANENT <span style="margin-left: 22px;">ADDRESS</span></td>
                <td colspan="4">
                    <input style="width: 98.3%; height: 20px; margin-top: -6px; padding-left: 2px; text-align: left;" type="text" value="{{ $dafac->per_address }}">
                    <p style="font-size: 7px; margin-top: -1px;">
                        <span style="margin-right: 18px;">House/block/Lot No.</span> 
                        <span style="margin-right: 18px;">Street</span>
                        <span style="margin-right: 18px;">Subdivision/Village</span>
                        <span style="margin-right: 18px;">Barangay</span>
                        <span style="margin-right: 18px;">City/Municipality</span>
                        <span style="margin-right: 18px;">Province</span>
                        <span style="margin-right: 18px;">Zipcode</span>
                    </p>
                </td>
            </tr>
            <tr>
                <td>25. OTHERS</td>
                <td colspan="4" width="100%">
                    <div style="float: left; position: relative; margin-left: -6px; width:20%;">
                        <input type="checkbox" value="" @if($dafac->ps_benef == 1) checked @endif> 
                        <span style="position: absolute; top: 2px; left: 80%; transform: translateX(-40%); width: 100px;">4Ps Beneficiary</span>
                    </div>
                    <div style="float: left; position: relative; margin-left: 50px;">
                        <input type="checkbox" value="" @if($dafac->ip == 1) checked @endif> 
                        <span style="position: absolute; top: 2px; left: 300%; transform: translateX(-40%); width: 100px;">IP-Type of Ethnicity </span>
                    </div>     
                    <div style="float: left; position: relative; margin-left: 50px;">
                        <div style="float: left; position: relative; margin-left: 90px;">
                            <span style="position: absolute; top: 2px; left: 300%; transform: translateX(-40%); width: 100px;"><u>{{ $dafac->type_ethnicity }}</u></span>
                        </div>
                    </div>                   
                </td>
            </tr>
            <tr>
                <td colspan="5"><br>26. FAMILY INFORMATION</td>
            </tr>
        </tbody>
    </table>

    <table class="table-2">
        <thead class="thead">
            <th class="member" style="background-color: #8596B0; color: black;" width="18%">FAMILY MEMBERS</th>
            <th class="member" style="background-color: #8596B0; color: black;" width="18%">RELATION TO <br> FAMILY HEAD</th>
            <th class="member" style="background-color: #8596B0; color: black;" width="12%">BIRTHDATE</th>
            <th class="member" style="background-color: #8596B0; color: black;" width="6%">AGE</th>
            <th class="member" style="background-color: #8596B0; color: black;" width="6%">SEX</th>
            <th class="member" style="background-color: #8596B0; color: black;" width="22%">HIGHEST EDUCATIONAL</th>
            <th class="member" style="background-color: #8596B0; color: black;" width="18%">OCCUPATION</th>
            <th class="member" style="background-color: #8596B0; color: black;" width="14%">REMARKS</th>
        </thead>
        <tbody class="tbody-2">
            <tr>
                <td class="member">{{ isset($memfnameArray[0]) ? ucfirst($memfnameArray[0]) : '' }}</td>
                <td class="member">{{ isset($mem_relationArray[0]) ? ucfirst($mem_relationArray[0]) : '' }}</td>
                <td class="member">{{ isset($mem_bDateArray[0]) ? \Carbon\Carbon::parse($mem_bDateArray[0])->format('M d, Y') : '' }}</td>
                <td class="member">{{ isset($mem_ageArray[0]) ? $mem_ageArray[0] : '' }}</td>
                <td class="member">{{ isset($mem_genderArray[0]) ? $mem_genderArray[0] : '' }}</td>
                <td class="member" style="overflow-y: hidden; height: 5px; @isset($mem_educArray[0]) @if($mem_educArray[0] == 4) font-size: 6px; @endif @endif">
                    @isset($mem_educArray[0]) 
                        @if ($mem_educArray[0] == 1) No Formal Education @elseif ($mem_educArray[0] == 2) Elementary School Graduate @elseif ($mem_educArray[0] == 3) High School Graduate
                        @elseif ($mem_educArray[0] == 4) Vocational or Technical School Graduate @elseif ($mem_educArray[0] == 5) Associate's Degree Holder @elseif ($mem_educArray[0] == 6) Bachelor's Degree Holder
                        @elseif ($mem_educArray[0] == 7) Master's Degree Holder @elseif ($mem_educArray[0] == 8) Doctoral Degree Holder @elseif ($mem_educArray[0] == 9) Professional Degree Holder
                        @elseif ($mem_educArray[0] == 10) High School Dropout @endif
                    @endisset
                </td>
                <td class="member">{{ isset($mem_occupArray[0]) ? ucfirst($mem_occupArray[0]) : '' }}</td>
                <td class="member">{{ isset($mem_remarksArray[0]) ? ucfirst($mem_remarksArray[0]) : '' }}</td>
            </tr>
            <tr>
                <td class="member">{{ isset($memfnameArray[1]) ? ucfirst($memfnameArray[1]) : '' }}</td>
                <td class="member">{{ isset($mem_relationArray[1]) ? ucfirst($mem_relationArray[1]) : '' }}</td>
                <td class="member">{{ isset($mem_bDateArray[1]) ? \Carbon\Carbon::parse($mem_bDateArray[1])->format('M d, Y') : '' }}</td>
                <td class="member">{{ isset($mem_ageArray[1]) ? $mem_ageArray[1] : '' }}</td>
                <td class="member">{{ isset($mem_genderArray[1]) ? $mem_genderArray[1] : '' }}</td>
                <td class="member" style="overflow-y: hidden; height: 5px; @isset($mem_educArray[1]) @if($mem_educArray[1] == 4) font-size: 6px; @endif @endif">
                    @isset($mem_educArray[1]) 
                        @if ($mem_educArray[1] == 1) No Formal Education @elseif ($mem_educArray[1] == 2) Elementary School Graduate @elseif ($mem_educArray[1] == 3) High School Graduate
                        @elseif ($mem_educArray[1] == 4) Vocational or Technical School Graduate @elseif ($mem_educArray[1] == 5) Associate's Degree Holder @elseif ($mem_educArray[1] == 6) Bachelor's Degree Holder
                        @elseif ($mem_educArray[1] == 7) Master's Degree Holder @elseif ($mem_educArray[1] == 8) Doctoral Degree Holder @elseif ($mem_educArray[1] == 9) Professional Degree Holder
                        @elseif ($mem_educArray[1] == 10) High School Dropout @endif
                    @endisset
                </td>
                <td class="member">{{ isset($mem_occupArray[1]) ? ucfirst($mem_occupArray[1]) : '' }}</td>
                <td class="member">{{ isset($mem_remarksArray[1]) ? ucfirst($mem_remarksArray[1]) : '' }}</td>
            </tr>
            <tr>
                <td class="member">{{ isset($memfnameArray[2]) ? ucfirst($memfnameArray[2]) : '' }}</td>
                <td class="member">{{ isset($mem_relationArray[2]) ? ucfirst($mem_relationArray[2]) : '' }}</td>
                <td class="member">{{ isset($mem_bDateArray[2]) ? \Carbon\Carbon::parse($mem_bDateArray[2])->format('M d, Y') : '' }}</td>
                <td class="member">{{ isset($mem_ageArray[2]) ? $mem_ageArray[2] : '' }}</td>
                <td class="member">{{ isset($mem_genderArray[2]) ? $mem_genderArray[2] : '' }}</td>
                <td class="member" style="overflow-y: hidden; height: 5px; @isset($mem_educArray[2]) @if($mem_educArray[2] == 4) font-size: 6px; @endif @endif">
                    @isset($mem_educArray[2]) 
                        @if ($mem_educArray[2] == 1) No Formal Education @elseif ($mem_educArray[2] == 2) Elementary School Graduate @elseif ($mem_educArray[2] == 3) High School Graduate
                        @elseif ($mem_educArray[2] == 4) Vocational or Technical School Graduate @elseif ($mem_educArray[2] == 5) Associate's Degree Holder @elseif ($mem_educArray[2] == 6) Bachelor's Degree Holder
                        @elseif ($mem_educArray[2] == 7) Master's Degree Holder @elseif ($mem_educArray[2] == 8) Doctoral Degree Holder @elseif ($mem_educArray[2] == 9) Professional Degree Holder
                        @elseif ($mem_educArray[2] == 10) High School Dropout @endif
                    @endisset
                </td>
                <td class="member">{{ isset($mem_occupArray[2]) ? ucfirst($mem_occupArray[2]) : '' }}</td>
                <td class="member">{{ isset($mem_remarksArray[2]) ? ucfirst($mem_remarksArray[2]) : '' }}</td>
            </tr>
            <tr>
                <td class="member">{{ isset($memfnameArray[3]) ? ucfirst($memfnameArray[3]) : '' }}</td>
                <td class="member">{{ isset($mem_relationArray[3]) ? ucfirst($mem_relationArray[3]) : '' }}</td>
                <td class="member">{{ isset($mem_bDateArray[3]) ? \Carbon\Carbon::parse($mem_bDateArray[3])->format('M d, Y') : '' }}</td>
                <td class="member">{{ isset($mem_ageArray[3]) ? $mem_ageArray[3] : '' }}</td>
                <td class="member">{{ isset($mem_genderArray[3]) ? $mem_genderArray[3] : '' }}</td>
                <td class="member" style="overflow-y: hidden; height: 5px; @isset($mem_educArray[3]) @if($mem_educArray[3] == 4) font-size: 6px; @endif @endif">
                    @isset($mem_educArray[3]) 
                        @if ($mem_educArray[3] == 1) No Formal Education @elseif ($mem_educArray[3] == 2) Elementary School Graduate @elseif ($mem_educArray[3] == 3) High School Graduate
                        @elseif ($mem_educArray[3] == 4) Vocational or Technical School Graduate @elseif ($mem_educArray[3] == 5) Associate's Degree Holder @elseif ($mem_educArray[3] == 6) Bachelor's Degree Holder
                        @elseif ($mem_educArray[3] == 7) Master's Degree Holder @elseif ($mem_educArray[3] == 8) Doctoral Degree Holder @elseif ($mem_educArray[3] == 9) Professional Degree Holder
                        @elseif ($mem_educArray[3] == 10) High School Dropout @endif
                    @endisset
                </td>
                <td class="member">{{ isset($mem_occupArray[3]) ? ucfirst($mem_occupArray[3]) : '' }}</td>
                <td class="member">{{ isset($mem_remarksArray[3]) ? ucfirst($mem_remarksArray[3]) : '' }}</td>
            </tr>
            <tr>
                <td class="member">{{ isset($memfnameArray[4]) ? ucfirst($memfnameArray[4]) : '' }}</td>
                <td class="member">{{ isset($mem_relationArray[4]) ? ucfirst($mem_relationArray[4]) : '' }}</td>
                <td class="member">{{ isset($mem_bDateArray[4]) ? \Carbon\Carbon::parse($mem_bDateArray[4])->format('M d, Y') : '' }}</td>
                <td class="member">{{ isset($mem_ageArray[4]) ? $mem_ageArray[4] : '' }}</td>
                <td class="member">{{ isset($mem_genderArray[4]) ? $mem_genderArray[4] : '' }}</td>
                <td class="member" style="overflow-y: hidden; height: 5px; @isset($mem_educArray[4]) @if($mem_educArray[4] == 4) font-size: 6px; @endif @endif">
                    @isset($mem_educArray[4]) 
                        @if ($mem_educArray[4] == 1) No Formal Education @elseif ($mem_educArray[4] == 2) Elementary School Graduate @elseif ($mem_educArray[4] == 3) High School Graduate
                        @elseif ($mem_educArray[4] == 4) Vocational or Technical School Graduate @elseif ($mem_educArray[4] == 5) Associate's Degree Holder @elseif ($mem_educArray[4] == 6) Bachelor's Degree Holder
                        @elseif ($mem_educArray[4] == 7) Master's Degree Holder @elseif ($mem_educArray[4] == 8) Doctoral Degree Holder @elseif ($mem_educArray[4] == 9) Professional Degree Holder
                        @elseif ($mem_educArray[4] == 10) High School Dropout @endif
                    @endisset
                </td>
                <td class="member">{{ isset($mem_occupArray[4]) ? ucfirst($mem_occupArray[4]) : '' }}</td>
                <td class="member">{{ isset($mem_remarksArray[4]) ? ucfirst($mem_remarksArray[4]) : '' }}</td>
            </tr>
            <tr>
                <td class="member">{{ isset($memfnameArray[5]) ? ucfirst($memfnameArray[5]) : '' }}</td>
                <td class="member">{{ isset($mem_relationArray[5]) ? ucfirst($mem_relationArray[5]) : '' }}</td>
                <td class="member">{{ isset($mem_bDateArray[5]) ? \Carbon\Carbon::parse($mem_bDateArray[5])->format('M d, Y') : '' }}</td>
                <td class="member">{{ isset($mem_ageArray[5]) ? $mem_ageArray[5] : '' }}</td>
                <td class="member">{{ isset($mem_genderArray[5]) ? $mem_genderArray[5] : '' }}</td>
                <td class="member" style="overflow-y: hidden; height: 5px; @isset($mem_educArray[5]) @if($mem_educArray[5] == 4) font-size: 6px; @endif @endif">
                    @isset($mem_educArray[5]) 
                        @if ($mem_educArray[5] == 1) No Formal Education @elseif ($mem_educArray[5] == 2) Elementary School Graduate @elseif ($mem_educArray[5] == 3) High School Graduate
                        @elseif ($mem_educArray[5] == 4) Vocational or Technical School Graduate @elseif ($mem_educArray[5] == 5) Associate's Degree Holder @elseif ($mem_educArray[5] == 6) Bachelor's Degree Holder
                        @elseif ($mem_educArray[5] == 7) Master's Degree Holder @elseif ($mem_educArray[5] == 8) Doctoral Degree Holder @elseif ($mem_educArray[5] == 9) Professional Degree Holder
                        @elseif ($mem_educArray[5] == 10) High School Dropout @endif
                    @endisset
                </td>
                <td class="member">{{ isset($mem_occupArray[5]) ? ucfirst($mem_occupArray[5]) : '' }}</td>
                <td class="member">{{ isset($mem_remarksArray[5]) ? ucfirst($mem_remarksArray[5]) : '' }}</td>
            </tr>
            <tr>
                <td class="member">{{ isset($memfnameArray[6]) ? ucfirst($memfnameArray[6]) : '' }}</td>
                <td class="member">{{ isset($mem_relationArray[6]) ? ucfirst($mem_relationArray[6]) : '' }}</td>
                <td class="member">{{ isset($mem_bDateArray[6]) ? \Carbon\Carbon::parse($mem_bDateArray[6])->format('M d, Y') : '' }}</td>
                <td class="member">{{ isset($mem_ageArray[6]) ? $mem_ageArray[6] : '' }}</td>
                <td class="member">{{ isset($mem_genderArray[6]) ? $mem_genderArray[6] : '' }}</td>
                <td class="member" style="overflow-y: hidden; height: 5px; @isset($mem_educArray[6]) @if($mem_educArray[6] == 4) font-size: 6px; @endif @endif">
                    @isset($mem_educArray[6]) 
                        @if ($mem_educArray[6] == 1) No Formal Education @elseif ($mem_educArray[6] == 2) Elementary School Graduate @elseif ($mem_educArray[6] == 3) High School Graduate
                        @elseif ($mem_educArray[6] == 4) Vocational or Technical School Graduate @elseif ($mem_educArray[6] == 5) Associate's Degree Holder @elseif ($mem_educArray[6] == 6) Bachelor's Degree Holder
                        @elseif ($mem_educArray[6] == 7) Master's Degree Holder @elseif ($mem_educArray[6] == 8) Doctoral Degree Holder @elseif ($mem_educArray[6] == 9) Professional Degree Holder
                        @elseif ($mem_educArray[6] == 11) High School Dropout @endif
                    @endisset
                </td>
                <td class="member">{{ isset($mem_occupArray[6]) ? ucfirst($mem_occupArray[6]) : '' }}</td>
                <td class="member">{{ isset($mem_remarksArray[6]) ? ucfirst($mem_remarksArray[6]) : '' }}</td>
            </tr>
            <tr>
                <td class="member">{{ isset($memfnameArray[7]) ? ucfirst($memfnameArray[7]) : '' }}</td>
                <td class="member">{{ isset($mem_relationArray[7]) ? ucfirst($mem_relationArray[7]) : '' }}</td>
                <td class="member">{{ isset($mem_bDateArray[7]) ? \Carbon\Carbon::parse($mem_bDateArray[7])->format('M d, Y') : '' }}</td>
                <td class="member">{{ isset($mem_ageArray[7]) ? $mem_ageArray[7] : '' }}</td>
                <td class="member">{{ isset($mem_genderArray[7]) ? $mem_genderArray[7] : '' }}</td>
                <td class="member" style="overflow-y: hidden; height: 5px; @isset($mem_educArray[7]) @if($mem_educArray[7] == 4) font-size: 6px; @endif @endif">
                    @isset($mem_educArray[7]) 
                        @if ($mem_educArray[7] == 1) No Formal Education @elseif ($mem_educArray[7] == 2) Elementary School Graduate @elseif ($mem_educArray[7] == 3) High School Graduate
                        @elseif ($mem_educArray[7] == 4) Vocational or Technical School Graduate @elseif ($mem_educArray[7] == 5) Associate's Degree Holder @elseif ($mem_educArray[7] == 6) Bachelor's Degree Holder
                        @elseif ($mem_educArray[7] == 7) Master's Degree Holder @elseif ($mem_educArray[7] == 8) Doctoral Degree Holder @elseif ($mem_educArray[7] == 9) Professional Degree Holder
                        @elseif ($mem_educArray[7] == 11) High School Dropout @endif
                    @endisset
                </td>
                <td class="member">{{ isset($mem_occupArray[7]) ? ucfirst($mem_occupArray[7]) : '' }}</td>
                <td class="member">{{ isset($mem_remarksArray[7]) ? ucfirst($mem_remarksArray[7]) : '' }}</td>
            </tr>
            <tr>
                <td class="member">{{ isset($memfnameArray[8]) ? ucfirst($memfnameArray[8]) : '' }}</td>
                <td class="member">{{ isset($mem_relationArray[8]) ? ucfirst($mem_relationArray[8]) : '' }}</td>
                <td class="member">{{ isset($mem_bDateArray[8]) ? \Carbon\Carbon::parse($mem_bDateArray[8])->format('M d, Y') : '' }}</td>
                <td class="member">{{ isset($mem_ageArray[8]) ? $mem_ageArray[8] : '' }}</td>
                <td class="member">{{ isset($mem_genderArray[8]) ? $mem_genderArray[8] : '' }}</td>
                <td class="member" style="overflow-y: hidden; height: 5px; @isset($mem_educArray[8]) @if($mem_educArray[8] == 4) font-size: 6px; @endif @endif">
                    @isset($mem_educArray[8]) 
                        @if ($mem_educArray[8] == 1) No Formal Education @elseif ($mem_educArray[8] == 2) Elementary School Graduate @elseif ($mem_educArray[8] == 3) High School Graduate
                        @elseif ($mem_educArray[8] == 4) Vocational or Technical School Graduate @elseif ($mem_educArray[8] == 5) Associate's Degree Holder @elseif ($mem_educArray[8] == 6) Bachelor's Degree Holder
                        @elseif ($mem_educArray[8] == 7) Master's Degree Holder @elseif ($mem_educArray[8] == 8) Doctoral Degree Holder @elseif ($mem_educArray[8] == 9) Professional Degree Holder
                        @elseif ($mem_educArray[8] == 11) High School Dropout @endif
                    @endisset
                </td>
                <td class="member">{{ isset($mem_occupArray[8]) ? ucfirst($mem_occupArray[8]) : '' }}</td>
                <td class="member">{{ isset($mem_remarksArray[8]) ? ucfirst($mem_remarksArray[8]) : '' }}</td>
            </tr>
            <tr>
                <td class="member">{{ isset($memfnameArray[9]) ? ucfirst($memfnameArray[9]) : '' }}</td>
                <td class="member">{{ isset($mem_relationArray[9]) ? ucfirst($mem_relationArray[9]) : '' }}</td>
                <td class="member">{{ isset($mem_bDateArray[9]) ? \Carbon\Carbon::parse($mem_bDateArray[9])->format('M d, Y'): '' }}</td>
                <td class="member">{{ isset($mem_ageArray[9]) ? $mem_ageArray[9] : '' }}</td>
                <td class="member">{{ isset($mem_genderArray[9]) ? $mem_genderArray[9] : '' }}</td>
                <td class="member" style="overflow-y: hidden; height: 5px; @isset($mem_educArray[9]) @if($mem_educArray[9] == 4) font-size: 6px; @endif @endif">
                    @isset($mem_educArray[9]) 
                        @if ($mem_educArray[9] == 1) No Formal Education @elseif ($mem_educArray[9] == 2) Elementary School Graduate @elseif ($mem_educArray[9] == 3) High School Graduate
                        @elseif ($mem_educArray[9] == 4) Vocational or Technical School Graduate @elseif ($mem_educArray[9] == 5) Associate's Degree Holder @elseif ($mem_educArray[9] == 6) Bachelor's Degree Holder
                        @elseif ($mem_educArray[9] == 7) Master's Degree Holder @elseif ($mem_educArray[9] == 8) Doctoral Degree Holder @elseif ($mem_educArray[9] == 9) Professional Degree Holder
                        @elseif ($mem_educArray[9] == 11) High School Dropout @endif
                    @endisset
                </td>
                <td class="member">{{ isset($mem_occupArray[9]) ? ucfirst($mem_occupArray[9]) : '' }}</td>
                <td class="member">{{ isset($mem_remarksArray[9]) ? ucfirst($mem_remarksArray[9]) : '' }}</td>
            </tr>
            <tr>
                <td class="member">{{ isset($memfnameArray[10]) ? ucfirst($memfnameArray[10]) : '' }}</td>
                <td class="member">{{ isset($mem_relationArray[10]) ? ucfirst($mem_relationArray[10]) : '' }}</td>
                <td class="member">{{ isset($mem_bDateArray[10]) ? \Carbon\Carbon::parse($mem_bDateArray[10])->format('M d, Y'): '' }}</td>
                <td class="member">{{ isset($mem_ageArray[10]) ? $mem_ageArray[10] : '' }}</td>
                <td class="member">{{ isset($mem_genderArray[10]) ? $mem_genderArray[10] : '' }}</td>
                <td class="member" style="overflow-y: hidden; height: 5px; @isset($mem_educArray[10]) @if($mem_educArray[10] == 4) font-size: 6px; @endif @endif">
                    @isset($mem_educArray[10]) 
                        @if ($mem_educArray[10] == 1) No Formal Education @elseif ($mem_educArray[10] == 2) Elementary School Graduate @elseif ($mem_educArray[10] == 3) High School Graduate
                        @elseif ($mem_educArray[10] == 4) Vocational or Technical School Graduate @elseif ($mem_educArray[10] == 5) Associate's Degree Holder @elseif ($mem_educArray[10] == 6) Bachelor's Degree Holder
                        @elseif ($mem_educArray[10] == 7) Master's Degree Holder @elseif ($mem_educArray[10] == 8) Doctoral Degree Holder @elseif ($mem_educArray[10] == 9) Professional Degree Holder
                        @elseif ($mem_educArray[10] == 11) High School Dropout @endif
                    @endisset
                </td>
                <td class="member">{{ isset($mem_occupArray[10]) ? ucfirst($mem_occupArray[10]) : '' }}</td>
                <td class="member">{{ isset($mem_remarksArray[10]) ? ucfirst($mem_remarksArray[10]) : '' }}</td>
            </tr>
            <tr>
                <td class="member">{{ isset($memfnameArray[11]) ? ucfirst($memfnameArray[11]) : '' }}</td>
                <td class="member">{{ isset($mem_relationArray[11]) ? ucfirst($mem_relationArray[11]) : '' }}</td>
                <td class="member">{{ isset($mem_bDateArray[11]) ? \Carbon\Carbon::parse($mem_bDateArray[11])->format('M d, Y') : '' }}</td>
                <td class="member">{{ isset($mem_ageArray[11]) ? $mem_ageArray[11] : '' }}</td>
                <td class="member">{{ isset($mem_genderArray[11]) ? $mem_genderArray[11] : '' }}</td>
                <td class="member" style="overflow-y: hidden; height: 5px; @isset($mem_educArray[11]) @if($mem_educArray[11] == 4) font-size: 6px; @endif @endif">
                    @isset($mem_educArray[11]) 
                        @if ($mem_educArray[11] == 1) No Formal Education @elseif ($mem_educArray[11] == 2) Elementary School Graduate @elseif ($mem_educArray[11] == 3) High School Graduate
                        @elseif ($mem_educArray[11] == 4) Vocational or Technical School Graduate @elseif ($mem_educArray[11] == 5) Associate's Degree Holder @elseif ($mem_educArray[11] == 6) Bachelor's Degree Holder
                        @elseif ($mem_educArray[11] == 7) Master's Degree Holder @elseif ($mem_educArray[11] == 8) Doctoral Degree Holder @elseif ($mem_educArray[11] == 9) Professional Degree Holder
                        @elseif ($mem_educArray[11] == 11) High School Dropout @endif
                    @endisset
                </td>
                <td class="member">{{ isset($mem_occupArray[11]) ? ucfirst($mem_occupArray[11]) : '' }}</td>
                <td class="member">{{ isset($mem_remarksArray[11]) ? ucfirst($mem_remarksArray[11]) : '' }}</td>
            </tr>
    </table>
    <table class="table">
        <thead>
            <th width="18%"></th>
            <th width="9%"></th>
            <th width=""></th>
            <th width=""></th>
            <th width=""></th>
            <th width=""></th>
            <th width=""></th>
            <th width=""></th>
            <th width="15%"></th>
        </thead>
        <tbody class="tbody">
            <tr>
                <td class="member-1">26. NO. OF VOLNERABLE <br>FAMILY MEMBERS:</td>
                <td class="member-1" style=" padding: 0px;">No. of Older<br> Persons</td>
                <td class="member-1" style="" colspan="2">
                    <input type="text" value="{{ isset($checklistArray[0]) ? ucfirst($checklistArray[0]) : '' }}" style="width: 16; color: #204c64;">
                </td>
                <td class="member-1" style="">No. of Pregnant Women</td>
                <td class="member-1" >
                    <input type="text" value="{{ isset($checklistArray[1]) ? ucfirst($checklistArray[1]) : '' }}" style="width: 16; color: #204c64;">
                </td>
                <td class="member-1" style="">No. of Lactating Women</td>
                <td class="member-1">
                    <input type="text" value="{{ isset($checklistArray[2]) ? ucfirst($checklistArray[2]) : '' }}" style="width: 16; color: #204c64;">
                </td>
                <td class="member-1" style="">No. of PWD's due to Medical Condition/s</td>
                <td class="member-1">
                    <input type="text" value="{{ isset($checklistArray[3]) ? ucfirst($checklistArray[3]) : '' }}" style="width: 16; color: #204c64;">
                </td>
            </tr>
        </tbody>
        
    </table>
    <table style="width: 98%; margin-left: 1%;">
        <thead>
            <th width="48%"></th>
            <th></th>
            <th width="48%"></th>
        </thead>
        <tbody class="tbody">
            <tr>
                <td style="background-color: #683c5c; padding: 1px; color: white; text-align: center;">27. HOUSE OWNERSHIP</td>
                <td></td>
                <td style="background-color: #683c5c; padding: 1px; color: white; text-align: center;">28. SHELTER DAMAGE CLASSIFICATION</td>
            </tr>
            <tr>
                <td style="vertical-align: middle; height: 2px; text-align: center;">
                    <input style="border-color: #204c64; width: 20px; color: #204c64; transform: scale(0.8); vertical-align: middle;" type="checkbox" {{ isset($checklistArray[4]) ? ($checklistArray[4] == 1 ? 'checked' : '') : '' }}>
                    <span style="margin-top: -2px; vertical-align: middle;">Owner</span>
                
                    <input style="border-color: #204c64; width: 20px; color: #204c64; transform: scale(0.8); vertical-align: middle;" type="checkbox" {{ isset($checklistArray[4]) ? ($checklistArray[4] == 2 ? 'checked' : '') : '' }}>
                    <span style="margin-top: -2px; vertical-align: middle;">Renter</span>
                
                    <input style="border-color: #204c64; width: 20px; color: #204c64; transform: scale(0.8); vertical-align: middle;" type="checkbox" {{ isset($checklistArray[4]) ? ($checklistArray[4] == 3 ? 'checked' : '') : '' }}>
                    <span style="margin-top: -2px; vertical-align: middle;">Sharer</span>
                </td>                
                <td></td>
                <td style="vertical-align: middle; height: 2px; text-align: center;">
                    <input style="border-color: #204c64; width: 20px; color: #204c64; transform: scale(0.8); vertical-align: middle;" type="checkbox" {{ isset($checklistArray[5]) ? ($checklistArray[5] == 1 ? 'checked' : '') : '' }}>
                    <span style="margin-top: -2px; vertical-align: middle;">Partially Damaged</span>
                
                    <input style="border-color: #204c64; width: 20px; color: #204c64; transform: scale(0.8); vertical-align: middle;" type="checkbox" {{ isset($checklistArray[5]) ? ($checklistArray[5] == 2 ? 'checked' : '') : '' }}>
                    <span style="margin-top: -2px; vertical-align: middle;">Totally Damaged</span>
                </td>   
            </tr>
        </tbody>
    </table>
    <table style="width: 98%; margin-left: 1%;">
        <thead>
            <th></th>
            <th width="42%"></th>
            <th width="42%"></th>
        </thead>
        <tbody class="tbody">
            <tr>
                <td style="background-color: padding: 1px; color: white; text-align: center;">
                    <div style="width: 85%; height: 59px; border: 1px solid black;">
                        <!-- Your content goes here -->
                    </div>
                    <div style="width: 85%; border: 1px solid black;">
                        <span style="color: rgb(30, 29, 29); font-size: 7px;">RIGHT THUMBMARK</span>
                    </div>
                </td>                
                <td style="padding: 1px; color: white; text-align: center;">
                    <div style="border-top: 1px solid black; width: 80%; margin: 0 auto;"></div>
                    <span style="color: rgb(30, 29, 29); padding-top: 1px;">Signature/Thumbmark of Family Head</span>
                    <br><br><br>
                    <div style="border-top: 1px solid black; width: 80%; margin: 0 auto;"></div>
                    <span style="color: rgb(30, 29, 29); padding-top: 1px;">Date Registered</span>
                </td>
                              
                <td style="padding: 1px; color: white; text-align: center;">
                    <div style="border-top: 1px solid black; width: 80%; margin: 0 auto;"></div>
                    <span style="color: rgb(30, 29, 29); padding-top: 1px;">Name/Signature of Brgy. Captain</span>
                    <br><br><br>
                    <div style="border-top: 1px solid black; width: 80%; margin: 0 auto;"></div>
                    <span style="color: rgb(30, 29, 29); padding-top: 1px;">Name/Signature of LSWDO</span>
                </td>
            </tr>
            <tr>
                <td colspan="3" style="text-align: center; font-size: 6px; ">
                    <span style="color: rgb(53, 50, 50);">29. DATA PRIVACY DECLARATION</span><br>
                    <span style="color: rgb(62, 59, 59); font-style: italic;">
                    All data and information indicated herein shall be used for identification purposes for the implementation of disaster risk reduction and management<br>
                    (DRRM) programs, projects and activities and its disclosure shall be in compliance to Republic Act 10173 (Data Privacy Act of 2012)
                    </span>
                </td>
            </tr>
        </tbody>
    </table>
</div>

<div class="split right">
    <table class="table">
        <thead>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
        </thead>
        <tbody class="tbody">
            <tr>
                <td width="80%"><img width="100%" src="{{ asset('uploads/dafac-header-2024.png') }}"  alt=""></td>
                <td width="27%" class="float-container">
                    <img src="{{ asset('uploads/dafac-social-workers-copy.png') }}" width="100%" alt="">
                    <span class="serial-float-over">{{ $dafac->serial }}</span>
                </td>
            <tr>
                <td colspan="4" style="background-color: #204c64;  height: 16px; text-align: center; color: white; font-weight: 700;">LOCATION OF AFFECTED FAMILY</td>
            </tr>
        </tbody>
    </table>
    <table class="table">
        <thead>
            <th width="17%"></th>
            <th width="30%"></th>
            <th width="25%"></th>
            <th width="30%"></th>
        </thead>
       <tbody class="tbody">
            <tr>
                <td>1. REGION</td>
                <td><input type="text" value="{{ $dafac->regionname }}"></td>
                <td>4. CITY/MUNICIPALITY</td>
                <td><input type="text" value="{{ $dafac->cityname }}"></td>
            </tr>
            <tr>
                <td>2. PROVINCE</td>
                <td><input type="text" value="{{ $dafac->provincename }}"></td>
                <td>5. BRANGAY</td>
                <td><input type="text" value="{{ $dafac->brgyname }}"></td>
            </tr>
            <tr>
                <td>3. DISTRICT</td>
                <td><input type="text" value="{{ $dafac->district }}"></td>
                <td>6. EVACUATION CENTER/<br>EVACUATION SITE</td>
                <td><input type="text" value="{{ $dafac->brgy_evac_site }}"></td>
            </tr>
            <tr>
                <td colspan="4" style="background-color: #204c64;  height: 16px; margin-bottom: 5px; text-align: center; color: white; font-weight: 700;">HEAD OF THE FAMILY</td>
            </tr>
            <tr>
                <td>7. LAST NAME</td>
                <td><input type="text" value="{{ ucwords(strtoupper($dafac->surname)) }}"></td>
                <td>15. CIVIL STATUS</td>
                <td><input type="text" value="{{ ucwords(strtoupper($dafac->civil_status)) }}"></td>
            </tr>
            <tr>
                <td>8. FIRST NAME</td>
                <td><input type="text" value="{{ ucwords(strtoupper($dafac->fname)) }}"></td>
                <td>16. MOTHER'S MAIDEN NAME</td>
                <td><input type="text" value="{{ ucwords(strtoupper($dafac->m_maid_name)) }}"></td>
            </tr>
            <tr>
                <td>9. MIDDLE NAME</td>
                <td><input type="text" value="{{ ucwords(strtoupper($dafac->mname)) }}"></td>
                <td>17. RELIGION</td>
                <td><input type="text" value="{{ ucwords(strtoupper($dafac->religion)) }}"></td>
            </tr>
            <tr>
                <td>10. NAME EXT.<span style="font-size: 6px; margin-left: 30px;">(Jr.,S.I)</span></td>
                <td><input type="text" value="{{ $dafac->ext }}"></td>
                <td>18. CITY/MUNICIPALITY</td>
                <td style="border-bottom: 1px solid black; padding: 8px 5px; text-align: center; text-transform: capitalize;">
                    {{ ucwords(strtolower($headbrgy?->name ?? '')) }}
                </td>
            </tr>
            <tr>
                <td>11. BIRTH DATE<span style="font-size: 6px; margin-left: 13px;">(Ex. 01 January 2021)</span></td>
                <td><input type="text" value="{{ \Carbon\Carbon::parse($dafac->d_birth)->format('d F Y') }}"></td>
                <td>19. OCCUPATION</td>
                <td><input type="text" value="{{ ucwords(strtoupper($dafac->occupation)) }}"></td>
            </tr>
            <tr>
                <td>12. AGE</td>
                <td><input type="text" value="{{ $dafac->age }}"></td>
                <td>20. MONTHLY FAMILY INCOME</td>
                <td><input type="text" value="{{ number_format($dafac->mincome, 2) }}"></td>
            </tr>
            <tr>
                <td>13. BIRTHPLACE</td>
                <td><input type="text" value="{{ ucwords(strtoupper($dafac->b_place)) }}"></td>
                <td>21. ID CARD PRESENTED</td>
                <td><input type="text" value="{{ ucwords(strtoupper($dafac->id_present)) }}"></td>
            </tr>
            <tr>
                <td>14. SEX</td>
                <td>
                    <div style="float: left; position: relative; margin-left: 6px; margin-top: 10px;">
                        <input type="checkbox" @if($dafac->gender == "M") checked @endif> 
                        <span style="position: absolute; top: 2px; left: 150%; transform: translateX(-40%);">MALE</span>
                    </div>
                    
                    <div style="float: left; position: relative; margin-top: 10px;  margin-left: 50px;">
                        <input type="checkbox" @if($dafac->gender == "F") checked @endif> 
                        <span style="position: absolute; top: 2px; left: 180%; transform: translateX(-40%);">FEMALE</span>
                    </div>
                </td>
                              
                <td>22. ID CARD NUMBER</td>
                <td style="float: left; position: relative; margin-top: 10px;  margin-left: 50px;"><input type="text" value="{{ ucwords(strtoupper($dafac->id_cardnum)) }}"></td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td>23. CONTACT NUMBER</td>
                <td>
                    <input style="width: 46%; height: 25px; margin-top: 8px;" type="text" value="{{ $dafac->contact_1 }}">
                    <input style="width: 46%; height: 25px;" type="text" value="{{ $dafac->contact_2 }}">
                </td>                
                
            </tr>
            <tr>
                <td>24. PERMANENT <span style="margin-left: 22px;">ADDRESS</span></td>
                <td colspan="4">
                    <input style="width: 98.3%; height: 20px; margin-top: -6px; padding-left: 2px; text-align: left;" type="text" value="{{ $dafac->per_address }}">
                    <p style="font-size: 7px; margin-top: -1px;">
                        <span style="margin-right: 18px;">House/block/Lot No.</span> 
                        <span style="margin-right: 18px;">Street</span>
                        <span style="margin-right: 18px;">Subdivision/Village</span>
                        <span style="margin-right: 18px;">Barangay</span>
                        <span style="margin-right: 18px;">City/Municipality</span>
                        <span style="margin-right: 18px;">Province</span>
                        <span style="margin-right: 18px;">Zipcode</span>
                    </p>
                </td>
            </tr>
            <tr>
                <td>25. OTHERS</td>
                <td colspan="4" width="100%">
                    <div style="float: left; position: relative; margin-left: -6px; width:20%;">
                        <input type="checkbox" value="" @if($dafac->ps_benef == 1) checked @endif> 
                        <span style="position: absolute; top: 2px; left: 80%; transform: translateX(-40%); width: 100px;">4Ps Beneficiary</span>
                    </div>
                    <div style="float: left; position: relative; margin-left: 50px;">
                        <input type="checkbox" value="" @if($dafac->ip == 1) checked @endif> 
                        <span style="position: absolute; top: 2px; left: 300%; transform: translateX(-40%); width: 100px;">IP-Type of Ethnicity </span>
                    </div>     
                    <div style="float: left; position: relative; margin-left: 50px;">
                        <div style="float: left; position: relative; margin-left: 90px;">
                            <span style="position: absolute; top: 2px; left: 300%; transform: translateX(-40%); width: 100px;"><u>{{ $dafac->type_ethnicity }}</u></span>
                        </div>
                    </div>                   
                </td>
            </tr>
            <tr>
                <td colspan="5"><br>26. FAMILY INFORMATION</td>
            </tr>
        </tbody>
    </table>

    <table class="table-2">
        <thead class="thead">
            <th class="member" style="background-color: #8596B0; color: black;" width="18%">FAMILY MEMBERS</th>
            <th class="member" style="background-color: #8596B0; color: black;" width="18%">RELATION TO <br> FAMILY HEAD</th>
            <th class="member" style="background-color: #8596B0; color: black;" width="12%">BIRTHDATE</th>
            <th class="member" style="background-color: #8596B0; color: black;" width="6%">AGE</th>
            <th class="member" style="background-color: #8596B0; color: black;" width="6%">SEX</th>
            <th class="member" style="background-color: #8596B0; color: black;" width="22%">HIGHEST EDUCATIONAL</th>
            <th class="member" style="background-color: #8596B0; color: black;" width="18%">OCCUPATION</th>
            <th class="member" style="background-color: #8596B0; color: black;" width="14%">REMARKS</th>
        </thead>
        <tbody class="tbody-2">
            <tr>
                <td class="member">{{ isset($memfnameArray[0]) ? ucfirst($memfnameArray[0]) : '' }}</td>
                <td class="member">{{ isset($mem_relationArray[0]) ? ucfirst($mem_relationArray[0]) : '' }}</td>
                <td class="member">{{ isset($mem_bDateArray[0]) ? \Carbon\Carbon::parse($mem_bDateArray[0])->format('M d, Y') : '' }}</td>
                <td class="member">{{ isset($mem_ageArray[0]) ? $mem_ageArray[0] : '' }}</td>
                <td class="member">{{ isset($mem_genderArray[0]) ? $mem_genderArray[0] : '' }}</td>
                <td class="member" style="overflow-y: hidden; height: 5px; @isset($mem_educArray[0]) @if($mem_educArray[0] == 4) font-size: 6px; @endif @endif">
                    @isset($mem_educArray[0]) 
                        @if ($mem_educArray[0] == 1) No Formal Education @elseif ($mem_educArray[0] == 2) Elementary School Graduate @elseif ($mem_educArray[0] == 3) High School Graduate
                        @elseif ($mem_educArray[0] == 4) Vocational or Technical School Graduate @elseif ($mem_educArray[0] == 5) Associate's Degree Holder @elseif ($mem_educArray[0] == 6) Bachelor's Degree Holder
                        @elseif ($mem_educArray[0] == 7) Master's Degree Holder @elseif ($mem_educArray[0] == 8) Doctoral Degree Holder @elseif ($mem_educArray[0] == 9) Professional Degree Holder
                        @elseif ($mem_educArray[0] == 10) High School Dropout @endif
                    @endisset
                </td>
                <td class="member">{{ isset($mem_occupArray[0]) ? ucfirst($mem_occupArray[0]) : '' }}</td>
                <td class="member">{{ isset($mem_remarksArray[0]) ? ucfirst($mem_remarksArray[0]) : '' }}</td>
            </tr>
            <tr>
                <td class="member">{{ isset($memfnameArray[1]) ? ucfirst($memfnameArray[1]) : '' }}</td>
                <td class="member">{{ isset($mem_relationArray[1]) ? ucfirst($mem_relationArray[1]) : '' }}</td>
                <td class="member">{{ isset($mem_bDateArray[1]) ? \Carbon\Carbon::parse($mem_bDateArray[1])->format('M d, Y') : '' }}</td>
                <td class="member">{{ isset($mem_ageArray[1]) ? $mem_ageArray[1] : '' }}</td>
                <td class="member">{{ isset($mem_genderArray[1]) ? $mem_genderArray[1] : '' }}</td>
                <td class="member" style="overflow-y: hidden; height: 5px; @isset($mem_educArray[1]) @if($mem_educArray[1] == 4) font-size: 6px; @endif @endif">
                    @isset($mem_educArray[1]) 
                        @if ($mem_educArray[1] == 1) No Formal Education @elseif ($mem_educArray[1] == 2) Elementary School Graduate @elseif ($mem_educArray[1] == 3) High School Graduate
                        @elseif ($mem_educArray[1] == 4) Vocational or Technical School Graduate @elseif ($mem_educArray[1] == 5) Associate's Degree Holder @elseif ($mem_educArray[1] == 6) Bachelor's Degree Holder
                        @elseif ($mem_educArray[1] == 7) Master's Degree Holder @elseif ($mem_educArray[1] == 8) Doctoral Degree Holder @elseif ($mem_educArray[1] == 9) Professional Degree Holder
                        @elseif ($mem_educArray[1] == 10) High School Dropout @endif
                    @endisset
                </td>
                <td class="member">{{ isset($mem_occupArray[1]) ? ucfirst($mem_occupArray[1]) : '' }}</td>
                <td class="member">{{ isset($mem_remarksArray[1]) ? ucfirst($mem_remarksArray[1]) : '' }}</td>
            </tr>
            <tr>
                <td class="member">{{ isset($memfnameArray[2]) ? ucfirst($memfnameArray[2]) : '' }}</td>
                <td class="member">{{ isset($mem_relationArray[2]) ? ucfirst($mem_relationArray[2]) : '' }}</td>
                <td class="member">{{ isset($mem_bDateArray[2]) ? \Carbon\Carbon::parse($mem_bDateArray[2])->format('M d, Y') : '' }}</td>
                <td class="member">{{ isset($mem_ageArray[2]) ? $mem_ageArray[2] : '' }}</td>
                <td class="member">{{ isset($mem_genderArray[2]) ? $mem_genderArray[2] : '' }}</td>
                <td class="member" style="overflow-y: hidden; height: 5px; @isset($mem_educArray[2]) @if($mem_educArray[2] == 4) font-size: 6px; @endif @endif">
                    @isset($mem_educArray[2]) 
                        @if ($mem_educArray[2] == 1) No Formal Education @elseif ($mem_educArray[2] == 2) Elementary School Graduate @elseif ($mem_educArray[2] == 3) High School Graduate
                        @elseif ($mem_educArray[2] == 4) Vocational or Technical School Graduate @elseif ($mem_educArray[2] == 5) Associate's Degree Holder @elseif ($mem_educArray[2] == 6) Bachelor's Degree Holder
                        @elseif ($mem_educArray[2] == 7) Master's Degree Holder @elseif ($mem_educArray[2] == 8) Doctoral Degree Holder @elseif ($mem_educArray[2] == 9) Professional Degree Holder
                        @elseif ($mem_educArray[2] == 10) High School Dropout @endif
                    @endisset
                </td>
                <td class="member">{{ isset($mem_occupArray[2]) ? ucfirst($mem_occupArray[2]) : '' }}</td>
                <td class="member">{{ isset($mem_remarksArray[2]) ? ucfirst($mem_remarksArray[2]) : '' }}</td>
            </tr>
            <tr>
                <td class="member">{{ isset($memfnameArray[3]) ? ucfirst($memfnameArray[3]) : '' }}</td>
                <td class="member">{{ isset($mem_relationArray[3]) ? ucfirst($mem_relationArray[3]) : '' }}</td>
                <td class="member">{{ isset($mem_bDateArray[3]) ? \Carbon\Carbon::parse($mem_bDateArray[3])->format('M d, Y') : '' }}</td>
                <td class="member">{{ isset($mem_ageArray[3]) ? $mem_ageArray[3] : '' }}</td>
                <td class="member">{{ isset($mem_genderArray[3]) ? $mem_genderArray[3] : '' }}</td>
                <td class="member" style="overflow-y: hidden; height: 5px; @isset($mem_educArray[3]) @if($mem_educArray[3] == 4) font-size: 6px; @endif @endif">
                    @isset($mem_educArray[3]) 
                        @if ($mem_educArray[3] == 1) No Formal Education @elseif ($mem_educArray[3] == 2) Elementary School Graduate @elseif ($mem_educArray[3] == 3) High School Graduate
                        @elseif ($mem_educArray[3] == 4) Vocational or Technical School Graduate @elseif ($mem_educArray[3] == 5) Associate's Degree Holder @elseif ($mem_educArray[3] == 6) Bachelor's Degree Holder
                        @elseif ($mem_educArray[3] == 7) Master's Degree Holder @elseif ($mem_educArray[3] == 8) Doctoral Degree Holder @elseif ($mem_educArray[3] == 9) Professional Degree Holder
                        @elseif ($mem_educArray[3] == 10) High School Dropout @endif
                    @endisset
                </td>
                <td class="member">{{ isset($mem_occupArray[3]) ? ucfirst($mem_occupArray[3]) : '' }}</td>
                <td class="member">{{ isset($mem_remarksArray[3]) ? ucfirst($mem_remarksArray[3]) : '' }}</td>
            </tr>
            <tr>
                <td class="member">{{ isset($memfnameArray[4]) ? ucfirst($memfnameArray[4]) : '' }}</td>
                <td class="member">{{ isset($mem_relationArray[4]) ? ucfirst($mem_relationArray[4]) : '' }}</td>
                <td class="member">{{ isset($mem_bDateArray[4]) ? \Carbon\Carbon::parse($mem_bDateArray[4])->format('M d, Y') : '' }}</td>
                <td class="member">{{ isset($mem_ageArray[4]) ? $mem_ageArray[4] : '' }}</td>
                <td class="member">{{ isset($mem_genderArray[4]) ? $mem_genderArray[4] : '' }}</td>
                <td class="member" style="overflow-y: hidden; height: 5px; @isset($mem_educArray[4]) @if($mem_educArray[4] == 4) font-size: 6px; @endif @endif">
                    @isset($mem_educArray[4]) 
                        @if ($mem_educArray[4] == 1) No Formal Education @elseif ($mem_educArray[4] == 2) Elementary School Graduate @elseif ($mem_educArray[4] == 3) High School Graduate
                        @elseif ($mem_educArray[4] == 4) Vocational or Technical School Graduate @elseif ($mem_educArray[4] == 5) Associate's Degree Holder @elseif ($mem_educArray[4] == 6) Bachelor's Degree Holder
                        @elseif ($mem_educArray[4] == 7) Master's Degree Holder @elseif ($mem_educArray[4] == 8) Doctoral Degree Holder @elseif ($mem_educArray[4] == 9) Professional Degree Holder
                        @elseif ($mem_educArray[4] == 10) High School Dropout @endif
                    @endisset
                </td>
                <td class="member">{{ isset($mem_occupArray[4]) ? ucfirst($mem_occupArray[4]) : '' }}</td>
                <td class="member">{{ isset($mem_remarksArray[4]) ? ucfirst($mem_remarksArray[4]) : '' }}</td>
            </tr>
            <tr>
                <td class="member">{{ isset($memfnameArray[5]) ? ucfirst($memfnameArray[5]) : '' }}</td>
                <td class="member">{{ isset($mem_relationArray[5]) ? ucfirst($mem_relationArray[5]) : '' }}</td>
                <td class="member">{{ isset($mem_bDateArray[5]) ? \Carbon\Carbon::parse($mem_bDateArray[5])->format('M d, Y') : '' }}</td>
                <td class="member">{{ isset($mem_ageArray[5]) ? $mem_ageArray[5] : '' }}</td>
                <td class="member">{{ isset($mem_genderArray[5]) ? $mem_genderArray[5] : '' }}</td>
                <td class="member" style="overflow-y: hidden; height: 5px; @isset($mem_educArray[5]) @if($mem_educArray[5] == 4) font-size: 6px; @endif @endif">
                    @isset($mem_educArray[5]) 
                        @if ($mem_educArray[5] == 1) No Formal Education @elseif ($mem_educArray[5] == 2) Elementary School Graduate @elseif ($mem_educArray[5] == 3) High School Graduate
                        @elseif ($mem_educArray[5] == 4) Vocational or Technical School Graduate @elseif ($mem_educArray[5] == 5) Associate's Degree Holder @elseif ($mem_educArray[5] == 6) Bachelor's Degree Holder
                        @elseif ($mem_educArray[5] == 7) Master's Degree Holder @elseif ($mem_educArray[5] == 8) Doctoral Degree Holder @elseif ($mem_educArray[5] == 9) Professional Degree Holder
                        @elseif ($mem_educArray[5] == 10) High School Dropout @endif
                    @endisset
                </td>
                <td class="member">{{ isset($mem_occupArray[5]) ? ucfirst($mem_occupArray[5]) : '' }}</td>
                <td class="member">{{ isset($mem_remarksArray[5]) ? ucfirst($mem_remarksArray[5]) : '' }}</td>
            </tr>
            <tr>
                <td class="member">{{ isset($memfnameArray[6]) ? ucfirst($memfnameArray[6]) : '' }}</td>
                <td class="member">{{ isset($mem_relationArray[6]) ? ucfirst($mem_relationArray[6]) : '' }}</td>
                <td class="member">{{ isset($mem_bDateArray[6]) ? \Carbon\Carbon::parse($mem_bDateArray[6])->format('M d, Y') : '' }}</td>
                <td class="member">{{ isset($mem_ageArray[6]) ? $mem_ageArray[6] : '' }}</td>
                <td class="member">{{ isset($mem_genderArray[6]) ? $mem_genderArray[6] : '' }}</td>
                <td class="member" style="overflow-y: hidden; height: 5px; @isset($mem_educArray[6]) @if($mem_educArray[6] == 4) font-size: 6px; @endif @endif">
                    @isset($mem_educArray[6]) 
                        @if ($mem_educArray[6] == 1) No Formal Education @elseif ($mem_educArray[6] == 2) Elementary School Graduate @elseif ($mem_educArray[6] == 3) High School Graduate
                        @elseif ($mem_educArray[6] == 4) Vocational or Technical School Graduate @elseif ($mem_educArray[6] == 5) Associate's Degree Holder @elseif ($mem_educArray[6] == 6) Bachelor's Degree Holder
                        @elseif ($mem_educArray[6] == 7) Master's Degree Holder @elseif ($mem_educArray[6] == 8) Doctoral Degree Holder @elseif ($mem_educArray[6] == 9) Professional Degree Holder
                        @elseif ($mem_educArray[6] == 11) High School Dropout @endif
                    @endisset
                </td>
                <td class="member">{{ isset($mem_occupArray[6]) ? ucfirst($mem_occupArray[6]) : '' }}</td>
                <td class="member">{{ isset($mem_remarksArray[6]) ? ucfirst($mem_remarksArray[6]) : '' }}</td>
            </tr>
            <tr>
                <td class="member">{{ isset($memfnameArray[7]) ? ucfirst($memfnameArray[7]) : '' }}</td>
                <td class="member">{{ isset($mem_relationArray[7]) ? ucfirst($mem_relationArray[7]) : '' }}</td>
                <td class="member">{{ isset($mem_bDateArray[7]) ? \Carbon\Carbon::parse($mem_bDateArray[7])->format('M d, Y') : '' }}</td>
                <td class="member">{{ isset($mem_ageArray[7]) ? $mem_ageArray[7] : '' }}</td>
                <td class="member">{{ isset($mem_genderArray[7]) ? $mem_genderArray[7] : '' }}</td>
                <td class="member" style="overflow-y: hidden; height: 5px; @isset($mem_educArray[7]) @if($mem_educArray[7] == 4) font-size: 6px; @endif @endif">
                    @isset($mem_educArray[7]) 
                        @if ($mem_educArray[7] == 1) No Formal Education @elseif ($mem_educArray[7] == 2) Elementary School Graduate @elseif ($mem_educArray[7] == 3) High School Graduate
                        @elseif ($mem_educArray[7] == 4) Vocational or Technical School Graduate @elseif ($mem_educArray[7] == 5) Associate's Degree Holder @elseif ($mem_educArray[7] == 6) Bachelor's Degree Holder
                        @elseif ($mem_educArray[7] == 7) Master's Degree Holder @elseif ($mem_educArray[7] == 8) Doctoral Degree Holder @elseif ($mem_educArray[7] == 9) Professional Degree Holder
                        @elseif ($mem_educArray[7] == 11) High School Dropout @endif
                    @endisset
                </td>
                <td class="member">{{ isset($mem_occupArray[7]) ? ucfirst($mem_occupArray[7]) : '' }}</td>
                <td class="member">{{ isset($mem_remarksArray[7]) ? ucfirst($mem_remarksArray[7]) : '' }}</td>
            </tr>
            <tr>
                <td class="member">{{ isset($memfnameArray[8]) ? ucfirst($memfnameArray[8]) : '' }}</td>
                <td class="member">{{ isset($mem_relationArray[8]) ? ucfirst($mem_relationArray[8]) : '' }}</td>
                <td class="member">{{ isset($mem_bDateArray[8]) ? \Carbon\Carbon::parse($mem_bDateArray[8])->format('M d, Y') : '' }}</td>
                <td class="member">{{ isset($mem_ageArray[8]) ? $mem_ageArray[8] : '' }}</td>
                <td class="member">{{ isset($mem_genderArray[8]) ? $mem_genderArray[8] : '' }}</td>
                <td class="member" style="overflow-y: hidden; height: 5px; @isset($mem_educArray[8]) @if($mem_educArray[8] == 4) font-size: 6px; @endif @endif">
                    @isset($mem_educArray[8]) 
                        @if ($mem_educArray[8] == 1) No Formal Education @elseif ($mem_educArray[8] == 2) Elementary School Graduate @elseif ($mem_educArray[8] == 3) High School Graduate
                        @elseif ($mem_educArray[8] == 4) Vocational or Technical School Graduate @elseif ($mem_educArray[8] == 5) Associate's Degree Holder @elseif ($mem_educArray[8] == 6) Bachelor's Degree Holder
                        @elseif ($mem_educArray[8] == 7) Master's Degree Holder @elseif ($mem_educArray[8] == 8) Doctoral Degree Holder @elseif ($mem_educArray[8] == 9) Professional Degree Holder
                        @elseif ($mem_educArray[8] == 11) High School Dropout @endif
                    @endisset
                </td>
                <td class="member">{{ isset($mem_occupArray[8]) ? ucfirst($mem_occupArray[8]) : '' }}</td>
                <td class="member">{{ isset($mem_remarksArray[8]) ? ucfirst($mem_remarksArray[8]) : '' }}</td>
            </tr>
            <tr>
                <td class="member">{{ isset($memfnameArray[9]) ? ucfirst($memfnameArray[9]) : '' }}</td>
                <td class="member">{{ isset($mem_relationArray[9]) ? ucfirst($mem_relationArray[9]) : '' }}</td>
                <td class="member">{{ isset($mem_bDateArray[9]) ? \Carbon\Carbon::parse($mem_bDateArray[9])->format('M d, Y'): '' }}</td>
                <td class="member">{{ isset($mem_ageArray[9]) ? $mem_ageArray[9] : '' }}</td>
                <td class="member">{{ isset($mem_genderArray[9]) ? $mem_genderArray[9] : '' }}</td>
                <td class="member" style="overflow-y: hidden; height: 5px; @isset($mem_educArray[9]) @if($mem_educArray[9] == 4) font-size: 6px; @endif @endif">
                    @isset($mem_educArray[9]) 
                        @if ($mem_educArray[9] == 1) No Formal Education @elseif ($mem_educArray[9] == 2) Elementary School Graduate @elseif ($mem_educArray[9] == 3) High School Graduate
                        @elseif ($mem_educArray[9] == 4) Vocational or Technical School Graduate @elseif ($mem_educArray[9] == 5) Associate's Degree Holder @elseif ($mem_educArray[9] == 6) Bachelor's Degree Holder
                        @elseif ($mem_educArray[9] == 7) Master's Degree Holder @elseif ($mem_educArray[9] == 8) Doctoral Degree Holder @elseif ($mem_educArray[9] == 9) Professional Degree Holder
                        @elseif ($mem_educArray[9] == 11) High School Dropout @endif
                    @endisset
                </td>
                <td class="member">{{ isset($mem_occupArray[9]) ? ucfirst($mem_occupArray[9]) : '' }}</td>
                <td class="member">{{ isset($mem_remarksArray[9]) ? ucfirst($mem_remarksArray[9]) : '' }}</td>
            </tr>
            <tr>
                <td class="member">{{ isset($memfnameArray[10]) ? ucfirst($memfnameArray[10]) : '' }}</td>
                <td class="member">{{ isset($mem_relationArray[10]) ? ucfirst($mem_relationArray[10]) : '' }}</td>
                <td class="member">{{ isset($mem_bDateArray[10]) ? \Carbon\Carbon::parse($mem_bDateArray[10])->format('M d, Y'): '' }}</td>
                <td class="member">{{ isset($mem_ageArray[10]) ? $mem_ageArray[10] : '' }}</td>
                <td class="member">{{ isset($mem_genderArray[10]) ? $mem_genderArray[10] : '' }}</td>
                <td class="member" style="overflow-y: hidden; height: 5px; @isset($mem_educArray[10]) @if($mem_educArray[10] == 4) font-size: 6px; @endif @endif">
                    @isset($mem_educArray[10]) 
                        @if ($mem_educArray[10] == 1) No Formal Education @elseif ($mem_educArray[10] == 2) Elementary School Graduate @elseif ($mem_educArray[10] == 3) High School Graduate
                        @elseif ($mem_educArray[10] == 4) Vocational or Technical School Graduate @elseif ($mem_educArray[10] == 5) Associate's Degree Holder @elseif ($mem_educArray[10] == 6) Bachelor's Degree Holder
                        @elseif ($mem_educArray[10] == 7) Master's Degree Holder @elseif ($mem_educArray[10] == 8) Doctoral Degree Holder @elseif ($mem_educArray[10] == 9) Professional Degree Holder
                        @elseif ($mem_educArray[10] == 11) High School Dropout @endif
                    @endisset
                </td>
                <td class="member">{{ isset($mem_occupArray[10]) ? ucfirst($mem_occupArray[10]) : '' }}</td>
                <td class="member">{{ isset($mem_remarksArray[10]) ? ucfirst($mem_remarksArray[10]) : '' }}</td>
            </tr>
            <tr>
                <td class="member">{{ isset($memfnameArray[11]) ? ucfirst($memfnameArray[11]) : '' }}</td>
                <td class="member">{{ isset($mem_relationArray[11]) ? ucfirst($mem_relationArray[11]) : '' }}</td>
                <td class="member">{{ isset($mem_bDateArray[11]) ? \Carbon\Carbon::parse($mem_bDateArray[11])->format('M d, Y') : '' }}</td>
                <td class="member">{{ isset($mem_ageArray[11]) ? $mem_ageArray[11] : '' }}</td>
                <td class="member">{{ isset($mem_genderArray[11]) ? $mem_genderArray[11] : '' }}</td>
                <td class="member" style="overflow-y: hidden; height: 5px; @isset($mem_educArray[11]) @if($mem_educArray[11] == 4) font-size: 6px; @endif @endif">
                    @isset($mem_educArray[11]) 
                        @if ($mem_educArray[11] == 1) No Formal Education @elseif ($mem_educArray[11] == 2) Elementary School Graduate @elseif ($mem_educArray[11] == 3) High School Graduate
                        @elseif ($mem_educArray[11] == 4) Vocational or Technical School Graduate @elseif ($mem_educArray[11] == 5) Associate's Degree Holder @elseif ($mem_educArray[11] == 6) Bachelor's Degree Holder
                        @elseif ($mem_educArray[11] == 7) Master's Degree Holder @elseif ($mem_educArray[11] == 8) Doctoral Degree Holder @elseif ($mem_educArray[11] == 9) Professional Degree Holder
                        @elseif ($mem_educArray[11] == 11) High School Dropout @endif
                    @endisset
                </td>
                <td class="member">{{ isset($mem_occupArray[11]) ? ucfirst($mem_occupArray[11]) : '' }}</td>
                <td class="member">{{ isset($mem_remarksArray[11]) ? ucfirst($mem_remarksArray[11]) : '' }}</td>
            </tr>
    </table>
    <table class="table">
        <thead>
            <th width="18%"></th>
            <th width="9%"></th>
            <th width=""></th>
            <th width=""></th>
            <th width=""></th>
            <th width=""></th>
            <th width=""></th>
            <th width=""></th>
            <th width="15%"></th>
        </thead>
        <tbody class="tbody">
            <tr>
                <td class="member-1">26. NO. OF VOLNERABLE <br>FAMILY MEMBERS:</td>
                <td class="member-1" style=" padding: 0px;">No. of Older<br> Persons</td>
                <td class="member-1" style="" colspan="2">
                    <input type="text" value="{{ isset($checklistArray[0]) ? ucfirst($checklistArray[0]) : '' }}" style="width: 16; color: #204c64;">
                </td>
                <td class="member-1" style="">No. of Pregnant Women</td>
                <td class="member-1" >
                    <input type="text" value="{{ isset($checklistArray[1]) ? ucfirst($checklistArray[1]) : '' }}" style="width: 16; color: #204c64;">
                </td>
                <td class="member-1" style="">No. of Lactating Women</td>
                <td class="member-1">
                    <input type="text" value="{{ isset($checklistArray[2]) ? ucfirst($checklistArray[2]) : '' }}" style="width: 16; color: #204c64;">
                </td>
                <td class="member-1" style="">No. of PWD's due to Medical Condition/s</td>
                <td class="member-1">
                    <input type="text" value="{{ isset($checklistArray[3]) ? ucfirst($checklistArray[3]) : '' }}" style="width: 16; color: #204c64;">
                </td>
            </tr>
        </tbody>
        
    </table>
    <table style="width: 98%; margin-left: 1%;">
        <thead>
            <th width="48%"></th>
            <th></th>
            <th width="48%"></th>
        </thead>
        <tbody class="tbody">
            <tr>
                <td style="background-color: #683c5c; padding: 1px; color: white; text-align: center;">27. HOUSE OWNERSHIP</td>
                <td></td>
                <td style="background-color: #683c5c; padding: 1px; color: white; text-align: center;">28. SHELTER DAMAGE CLASSIFICATION</td>
            </tr>
            <tr>
                <td style="vertical-align: middle; height: 2px; text-align: center;">
                    <input style="border-color: #204c64; width: 20px; color: #204c64; transform: scale(0.8); vertical-align: middle;" type="checkbox" {{ isset($checklistArray[4]) ? ($checklistArray[4] == 1 ? 'checked' : '') : '' }}>
                    <span style="margin-top: -2px; vertical-align: middle;">Owner</span>
                
                    <input style="border-color: #204c64; width: 20px; color: #204c64; transform: scale(0.8); vertical-align: middle;" type="checkbox" {{ isset($checklistArray[4]) ? ($checklistArray[4] == 2 ? 'checked' : '') : '' }}>
                    <span style="margin-top: -2px; vertical-align: middle;">Renter</span>
                
                    <input style="border-color: #204c64; width: 20px; color: #204c64; transform: scale(0.8); vertical-align: middle;" type="checkbox" {{ isset($checklistArray[4]) ? ($checklistArray[4] == 3 ? 'checked' : '') : '' }}>
                    <span style="margin-top: -2px; vertical-align: middle;">Sharer</span>
                </td>                
                <td></td>
                <td style="vertical-align: middle; height: 2px; text-align: center;">
                    <input style="border-color: #204c64; width: 20px; color: #204c64; transform: scale(0.8); vertical-align: middle;" type="checkbox" {{ isset($checklistArray[5]) ? ($checklistArray[5] == 1 ? 'checked' : '') : '' }}>
                    <span style="margin-top: -2px; vertical-align: middle;">Partially Damaged</span>
                
                    <input style="border-color: #204c64; width: 20px; color: #204c64; transform: scale(0.8); vertical-align: middle;" type="checkbox" {{ isset($checklistArray[5]) ? ($checklistArray[5] == 2 ? 'checked' : '') : '' }}>
                    <span style="margin-top: -2px; vertical-align: middle;">Totally Damaged</span>
                </td>   
            </tr>
        </tbody>
    </table>
    <table style="width: 98%; margin-left: 1%;">
        <thead>
            <th></th>
            <th width="42%"></th>
            <th width="42%"></th>
        </thead>
        <tbody class="tbody">
            <tr>
                <td style="background-color: padding: 1px; color: white; text-align: center;">
                    <div style="width: 85%; height: 59px; border: 1px solid black;">
                        <!-- Your content goes here -->
                    </div>
                    <div style="width: 85%; border: 1px solid black;">
                        <span style="color: rgb(30, 29, 29); font-size: 7px;">RIGHT THUMBMARK</span>
                    </div>
                </td>                
                <td style="padding: 1px; color: white; text-align: center;">
                    <div style="border-top: 1px solid black; width: 80%; margin: 0 auto;"></div>
                    <span style="color: rgb(30, 29, 29); padding-top: 1px;">Signature/Thumbmark of Family Head</span>
                    <br><br><br>
                    <div style="border-top: 1px solid black; width: 80%; margin: 0 auto;"></div>
                    <span style="color: rgb(30, 29, 29); padding-top: 1px;">Date Registered</span>
                </td>
                              
                <td style="padding: 1px; color: white; text-align: center;">
                    <div style="border-top: 1px solid black; width: 80%; margin: 0 auto;"></div>
                    <span style="color: rgb(30, 29, 29); padding-top: 1px;">Name/Signature of Brgy. Captain</span>
                    <br><br><br>
                    <div style="border-top: 1px solid black; width: 80%; margin: 0 auto;"></div>
                    <span style="color: rgb(30, 29, 29); padding-top: 1px;">Name/Signature of LSWDO</span>
                </td>
            </tr>
            <tr>
                <td colspan="3" style="text-align: center; font-size: 6px; ">
                    <span style="color: rgb(53, 50, 50);">29. DATA PRIVACY DECLARATION</span><br>
                    <span style="color: rgb(62, 59, 59); font-style: italic;">
                    All data and information indicated herein shall be used for identification purposes for the implementation of disaster risk reduction and management<br>
                    (DRRM) programs, projects and activities and its disclosure shall be in compliance to Republic Act 10173 (Data Privacy Act of 2012)
                    </span>
                </td>
            </tr>
        </tbody>
    </table>
</div>

</body>
</html>