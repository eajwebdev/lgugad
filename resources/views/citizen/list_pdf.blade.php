<!DOCTYPE html>
<html lang="en">
<head>
    <style>{!! file_get_contents(public_path('css/pdf-style.css')) !!}</style>
    
<title>SENIOR CITIZEN FORM</title>
</head>
   
<body class="border">
    <div class="row">
        <div class="col-12">
            <img src="{{ \App\Support\PdfAsset::image('template/img/senior-header.png') }}" class="img-fluid" alt="">
        </div>
    </div>
    <div class="row">
        <div class="col-8">
            <img src="{{ \App\Support\PdfAsset::image('template/img/header-text.png') }}" alt="" style="max-width: 67.4%; height: auto;">
        </div>      
        
        <div class="centered-text">
            NOT FOR SALE
        </div>   
    </div>
    <div class="row"> 
        <img src="{{ \App\Support\PdfAsset::image(
            !empty($citizen->profile) && is_file(public_path($citizen->profile))
                ? $citizen->profile
                : ($citizen->gender === 'Female' ? 'uploads/female-profile.png' : 'uploads/male-profile.png')
        ) }}" class="img-fluid profile-image" alt="Profile Image">
         <div class="col-12">
            <table class="">  
                <thead>
                    <tr>
                        <th width="61"></th>
                        <th width="105"></th>
                        <th width="93"></th>
                        <th width="93"></th>
                        <th width="79"></th>
                        <th width="100"></th>
                    </tr>
                </thead>
                <tbody>     
                    <tr>
                        <td >&nbsp;</td>
                        <td colspan="5" class="default-font bold"><span class="italic">*To be filled-up by NCSC</span></td>
                    </tr>
                    <tr>
                        <td class="default-font bold" style="padding-bottom: 5px;">Reference Code:</td>
                        <td colspan="4">
                            <div class="horizontal-inputs">
                                <input type="text" value="" style="width:15px;"><input type="text" value="-" style="width: 5px; margin: 0; border: none;">
                                <input type="text" value="" style="width:15px;"><input type="text" value="-" style="width: 5px; margin: 0; border: none;">
                                <input type="text" value="" style="width:30px;"><input type="text" value="-" style="width: 5px; margin: 0; border: none;">
                                <input type="text" value="" style="width:53px;"><input type="text" value="-" style="width: 5px; margin: 0; border: none;">
                                <input type="text" value="" style="width:133px;">
                            </div>
                        </td>                      
                        <td colspan="2"></td>
                    </tr>
                    <tr>
                        <td colspan="5" style="background-color: #244464;  color: #FFFF; padding: 2px;" class="bold">I. IDENTIFYING INFORMATION</td>
                    </tr>
                    <tr>
                        <td class="border-2" colspan="6" style="padding-top: 2px;"></td>
                    </tr>
                    <tr class="border-2">
                        <td class="border-2 default-font bold td-bg" rowspan="2">1. Name of Senior Citizen</td>
                        <td class="text-center border-2">{{ ucfirst($citizen->lname) }}</td>
                        <td class="text-center border-2">{{ ucfirst($citizen->fname) }}</td>
                        <td class="text-center border-2">{{ ucfirst($citizen->mname) }}</td>
                        <td class="text-center border-2">{{ ucfirst($citizen->ext) }}</td>
                        <td class="text-center border-2"></td>
                    </tr>
                    <tr class="border-2">
                        <td class="text-center td-bg italic">Last Name</td>
                        <td class="text-center td-bg italic">First Name</td>
                        <td class="text-center td-bg italic">Middle Name</td>
                        <td class="text-center td-bg italic">Extension (Jr,Sr)</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td class="border-2" colspan="6" style="padding-top: 2px;"></td>
                    </tr>
                    <tr>
                        <td class="border-2 default-font bold td-bg" rowspan="4">1. Address</td>
                        <td class="text-center border-2">{{ ucfirst($citizen->region) }}</td>
                        <td class="text-center border-2">{{ ucfirst($citizen->province) }}</td>
                        <td class="text-center border-2">{{ ucfirst($citizen->city_mun) }}</td>
                        <td class="text-center border-2">{{ ucfirst($citizen->brgy) }}</td>
                        <td class="border-2 td-bg" rowspan="4"></td>
                    </tr>
                    <tr class="border-2">
                        <td class="text-center td-bg italic">Region</td>
                        <td class="text-center td-bg italic">Province</td>
                        <td class="text-center td-bg italic">City/Municipality</td>
                        <td class="text-center td-bg italic">Barangay</td>
                    </tr>
                    <tr>
                        <td class="text-center border-2" colspan="3">{{ ucfirst($citizen->house_purok) }}</td>
                        <td class="text-center border-2">{{ ucfirst($citizen->street) }}</td>
                    </tr>
                    <tr>
                        <td class="text-center td-bg italic" colspan="3">House No./Zone/Purok/Sitio</td>
                        <td class="text-center td-bg italic">Street</td>
                    </tr>
                    <tr>
                        <td class="border-2" colspan="6" style="padding-top: 2px;"></td>
                    </tr>
                    <tr>
                        <td class="border-2 default-font bold td-bg" rowspan="2">3. Date of Birth</td>
                        <td class="text-center border-2">
                            <span class="table-like">
                                <span class="table-row">
                                    <span class="table-cell">@php $bday = $citizen->bday; $day = substr($bday, 8, 1); @endphp {{ $day }}</span>
                                    <span class="table-cell">@php $bday = $citizen->bday; $day1 = substr($bday, 9, 1); @endphp {{ $day1 }}</span>
                                    <span class="table-cell">@php $bday = $citizen->bday; $month = substr($bday, 5, 1); @endphp {{ $month }}</span>
                                    <span class="table-cell">@php $bday = $citizen->bday; $month1 = substr($bday, 6, 1); @endphp {{ $month1 }}</span>
                                    <span class="table-cell">@php $bday = $citizen->bday; $year = substr($bday, 2, 1); @endphp {{ $year }}</span>
                                    <span class="table-cell1">@php $bday = $citizen->bday; $year1 = substr($bday, 3, 1); @endphp {{ $year1 }}</span>
                                </span>
                            </span>
                        </td>
                        <td class="border-2 default-font bold td-bg" rowspan="2">4. Place of Birth</td>
                        <td class="text-center border-2" rowspan="2">{{ ucfirst($citizen->p_birth) }}</td>
                        <td class="border-2 default-font bold td-bg" rowspan="2">5. Marital Status</td>
                        <td class="text-center border-2" rowspan="2">{{ ucfirst($citizen->m_status) }}</td>
                    </tr>
                    <tr>
                        <td class="text-center border-2">
                            <span class="table-like">
                                <span class="table-row">
                                    <span class="table-cell">m</span>
                                    <span class="table-cell">m</span>
                                    <span class="table-cell">d</span>
                                    <span class="table-cell">d</span>
                                    <span class="table-cell">y</span>
                                    <span class="table-cell1">y</span>
                                </span>
                            </span>
                        </td>                        
                    </tr>
                    <tr>
                        <td class="border-2" colspan="6" style="padding-top: 2px;"></td>
                    </tr>
                    <tr>
                        <td class="border-2 default-font bold td-bg">6. Gender/Sex</td>
                        <td class="text-center border-2">{{ ucfirst($citizen->gender) }}</td>
                        <td class="border-2 default-font bold td-bg">7. Contact Number</td>
                        <td class="text-center border-2">{{ ucfirst($citizen->contact) }}</td>
                        <td class="border-2 default-font bold td-bg">8. Email Address</td>
                        <td class="text-center border-2">{{ $citizen->email }}</td>
                    </tr>
                       <tr>
                        <td class="border-2" colspan="6" style="padding-top: 5px3"></td>
                    </tr>
                    <tr>
                        <td class="border-2 default-font bold td-bg">9. Religion</td>
                        <td class="text-center border-2">{{ $citizen->religion }}</td>
                        <td class="border-2 default-font bold td-bg">10. Ethnic Origin</td>
                        <td class="text-center border-2">{{ $citizen->ethic_org }}</td>
                        <td class="border-2 default-font bold td-bg">11. Language Spoken / Written</td>
                        <td class="text-center border-2">{{ $citizen->lang_spoke }}</td>
                    </tr>
                    <tr>
                        <td class="border-2" colspan="6" style="padding-top: 2px;"></td>
                    </tr>   
                    <tr>
                        <td class="border-2 default-font bold td-bg">12. OSCA ID Number</td>
                        <td class="text-center border-2">{{ $citizen->osca_idnum }}</td>
                        <td class="border-2 default-font bold ">13. GSIS/SSS</td>
                        <td class="text-center border-2">{{ $citizen->gsis_sss }}</td>
                        <td class="border-2 default-font bold ">14. TIN</td>
                        <td class="text-center border-2">{{ $citizen->tin }}</td>
                    </tr>
                    <tr>
                        <td class="border-2" colspan="6" style="padding-top: 2px;"></td>
                    </tr>
                    <tr>
                        <td class="border-2 default-font bold td-bg">15. Philhealth</td>
                        <td class="text-center border-2">{{ $citizen->ph }}</td>
                        <td class="border-2 default-font bold ">16. SC Association / Org ID No.</td>
                        <td class="text-center border-2">{{ $citizen->sc_ass }}</td>
                        <td class="border-2 default-font bold ">17. Other Gov't. ID</td>
                        <td class="text-center border-2">{{ $citizen->other_gov }}</td>
                    </tr>
                    <tr>
                        <td class="border-2" colspan="6" style="padding-top: 2px;"></td>
                    </tr>
                    <tr>
                        <td class="border-2 default-font bold td-bg">18. Capability to Travel</td>
                        <td class="text-center border-2">
                            <input type="checkbox" style="margin-bottom: 2px;"  @if($citizen->camp_travel == "0") checked @endif> 1 Yes <input type="checkbox" style="margin-bottom: 2px;"  @if($citizen->camp_travel == "1") checked @endif> 2 No
                        </td>
                        <td class="border-2 default-font bold td-bg">19. Service/ Business/ Employment (specify)</td>
                        <td class="text-center border-2">{{ $citizen->sbe }}</td>
                        <td class="border-2 default-font bold td-bg">20. Current Pension (specify)</td>
                        <td class="text-center border-2">{{ $citizen->curr_pension }}</td>
                    </tr>
                    <tr>
                        <td class="border-2" colspan="6" style="padding-top: 2px;"></td>
                    </tr>
                    <tr>
                        <td class="default-font" colspan="6" style="background-color: #244464;  color: #FFFF; padding: 2px;" class="bold">II. FAMILY COMPOSITION</td>
                    </tr>
                    <tr>
                        <td class="border-2" colspan="6" style="padding-top: 2px;"></td>
                    </tr>
                    <tr>
                        <td class="border-2 default-font bold td-bg" rowspan="2">21. Name of Spouse</td>
                        <td class="text-center border-2">{{ $citizen->spouse_lname }}</td>
                        <td class="text-center border-2" colspan="2">{{ $citizen->	spouse_fname }}</td>
                        <td class="text-center border-2">{{ $citizen->spouse_mname }}</td>
                        <td class="text-center border-2">{{ $citizen->spouse_ext }}</td>
                    </tr>
                    <tr>
                        <td class="text-center td-bg italic">Last Name</td>
                        <td class="text-center td-bg italic" colspan="2">First Name</td>
                        <td class="text-center td-bg italic">Middle Name</td>
                        <td class="text-center td-bg italic">Extension (Jr,Sr)</td>
                    </tr>
                    <tr>
                        <td class="border-2 default-font bold td-bg" rowspan="2">22. Father's Name</td>
                        <td class="text-center border-2">{{ $citizen->father_lname }}</td>
                        <td class="text-center border-2" colspan="2">{{ $citizen->father_fname }}</td>
                        <td class="text-center border-2">{{ $citizen->father_mname }}</td>
                        <td class="text-center border-2">{{ $citizen->father_ext }}</td>
                    </tr>
                    <tr>
                        <td class="text-center td-bg italic">Last Name</td>
                        <td class="text-center td-bg italic" colspan="2">First Name</td>
                        <td class="text-center td-bg italic">Middle Name</td>
                        <td class="text-center td-bg italic">Extension (Jr,Sr)</td>
                    </tr>
                    <tr>
                        <td class="border-2 default-font bold td-bg" rowspan="2">23. Mother's Maiden Name</td>
                        <td class="text-center border-2">{{ $citizen->mother_lname }}</td>
                        <td class="text-center border-2" colspan="2">{{ $citizen->mother_fname }}</td>
                        <td class="text-center border-2">{{ $citizen->mother_mname }}</td>
                        <td class="text-center border-2">{{ $citizen->mother_ext }}</td>
                    </tr>
                    <tr>
                        <td class="text-center td-bg italic">Last Name</td>
                        <td class="text-center td-bg italic" colspan="2">First Name</td>
                        <td class="text-center td-bg italic">Middle Name</td>
                        <td class="text-center td-bg italic">Extension (Jr,Sr)</td>
                    </tr>
                    <tr>
                        <td class="border-2" colspan="6" style="padding-top: 2px;"></td>
                    </tr>
                    <tr>
                        <td class="border-2 default-font bold td-bg" rowspan="5">24. Child(ren)</td>
                        <td class="text-center default-font border-2 bold td-bg">Full name</td>
                        <td class="text-center default-font border-2 bold td-bg">Occupation</td>
                        <td class="text-center default-font border-2 bold td-bg">Income</td>
                        <td class="text-center default-font border-2 bold td-bg">Age</td>
                        <td class="text-center default-font border-2 bold td-bg">Working/not working</td>
                    </tr>
                    @php
                        $incomeParts = explode(',', $citizen->child_income);
                        $formattedParts = array_map(fn($part) => number_format((float)$part, 2), $incomeParts);
                    @endphp
                    <tr>
                        <td class="text-center border-2">{{ explode(',', $citizen->child_fname)[0] }} <strong style="color: white;">.</strong></td>
                        <td class="text-center border-2">{{ explode(',', $citizen->child_occup)[0] }}</td>
                        <td class="text-center border-2">@php $firstFormattedPart = isset($formattedParts[0]) ? $formattedParts[0] : ''; @endphp {{ $firstFormattedPart == '0.00' ? '' : $firstFormattedPart }}</td>
                        <td class="text-center border-2">{{ explode(',', $citizen->child_age)[0] }}</td>
                        <td class="text-center border-2"> {{ explode(',', $citizen->child_working)[0] == '0' ? 'Yes' : (explode(',', $citizen->child_working)[0] == '1' ? 'No' : '') }}</td>
                    </tr>
                    <tr>
                        <td class="text-center border-2">{{ explode(',', $citizen->child_fname)[1] }} <strong style="color: white;">.</strong></td>
                        <td class="text-center border-2">{{ explode(',', $citizen->child_occup)[1] }}</td>
                        <td class="text-center border-2">@php $firstFormattedPart1 = isset($formattedParts[1]) ? $formattedParts[1] : ''; @endphp {{ $firstFormattedPart1 == '0.00' ? '' : $firstFormattedPart1 }}</td>
                        <td class="text-center border-2">{{ explode(',', $citizen->child_age)[1] }}</td>
                        <td class="text-center border-2"> {{ explode(',', $citizen->child_working)[1] == '0' ? 'Yes' : (explode(',', $citizen->child_working)[1] == '1' ? 'No' : '') }}</td>
                    </tr>
                    <tr>
                        <td class="text-center border-2">{{ explode(',', $citizen->child_fname)[2] }} <strong style="color: white;">.</strong></td>
                        <td class="text-center border-2">{{ explode(',', $citizen->child_occup)[2] }}</td>
                        <td class="text-center border-2">@php $firstFormattedPart2 = isset($formattedParts[2]) ? $formattedParts[2] : ''; @endphp {{ $firstFormattedPart2 == '0.00' ? '' : $firstFormattedPart2 }}</td>
                        <td class="text-center border-2">{{ explode(',', $citizen->child_age)[2] }}</td>
                        <td class="text-center border-2"> {{ explode(',', $citizen->child_working)[2] == '0' ? 'Yes' : (explode(',', $citizen->child_working)[2] == '1' ? 'No' : '') }}</td>
                    </tr>
                    <tr>
                        <td class="text-center border-2">{{ explode(',', $citizen->child_fname)[3] }} <strong style="color: white;">.</strong></td>
                        <td class="text-center border-2">{{ explode(',', $citizen->child_occup)[3] }}</td>
                        <td class="text-center border-2">@php $firstFormattedPart3 = isset($formattedParts[3]) ? $formattedParts[3] : ''; @endphp {{ $firstFormattedPart3 == '0.00' ? '' : $firstFormattedPart3 }}</td>
                        <td class="text-center border-2">{{ explode(',', $citizen->child_age)[3] }}</td>
                        <td class="text-center border-2"> {{ explode(',', $citizen->child_working)[3] == '0' ? 'Yes' : (explode(',', $citizen->child_working)[3] == '1' ? 'No' : '') }}</td>
                    </tr>
                    @php
                        $incomeParts1 = explode(',', $citizen->depend_income);
                        $formattedParts1 = array_map(fn($part) => number_format((float)$part, 2), $incomeParts1);
                    @endphp
                    <tr>
                        <td class="border-2 default-font bold td-bg" rowspan="3">25. Other Dependents</td>
                        <td class="text-center border-2">{{ explode(',', $citizen->depend_fname)[0] }} <strong style="color: white;">.</strong></td>
                        <td class="text-center border-2">{{ explode(',', $citizen->depend_occup)[0] }}</td>
                        <td class="text-center border-2">@php $firstFormattedPartt = isset($formattedParts1[0]) ? $formattedParts1[0] : ''; @endphp {{ $firstFormattedPartt == '0.00' ? '' : $firstFormattedPartt }}</td>
                        <td class="text-center border-2">{{ explode(',', $citizen->depend_age)[0] }}</td>
                        <td class="text-center border-2"> {{ explode(',', $citizen->depend_working)[0] == '0' ? 'Yes' : (explode(',', $citizen->depend_working)[0] == '1' ? 'No' : '') }}</td>
                    </tr>
                    <tr>
                        <td class="text-center border-2">{{ explode(',', $citizen->depend_fname)[1] }} <strong style="color: white;">.</strong></td>
                        <td class="text-center border-2">{{ explode(',', $citizen->depend_occup)[1] }}</td>
                        <td class="text-center border-2">@php $firstFormattedPartt2 = isset($formattedParts1[1]) ? $formattedParts1[1] : ''; @endphp {{ $firstFormattedPartt2 == '0.00' ? '' : $firstFormattedPartt }}</td>
                        <td class="text-center border-2">{{ explode(',', $citizen->depend_age)[1] }}</td>
                        <td class="text-center border-2"> {{ explode(',', $citizen->depend_working)[1] == '0' ? 'Yes' : (explode(',', $citizen->depend_working)[1] == '1' ? 'No' : '') }}</td>
                    </tr>
                    <tr>
                        <td class="text-center border-2">{{ explode(',', $citizen->depend_fname)[2] }} <strong style="color: white;">.</strong></td>
                        <td class="text-center border-2">{{ explode(',', $citizen->depend_occup)[2] }}</td>
                        <td class="text-center border-2">@php $firstFormattedPartt2 = isset($formattedParts1[2]) ? $formattedParts1[2] : ''; @endphp {{ $firstFormattedPartt2 == '0.00' ? '' : $firstFormattedPartt }}</td>
                        <td class="text-center border-2">{{ explode(',', $citizen->depend_age)[2] }}</td>
                        <td class="text-center border-2"> {{ explode(',', $citizen->depend_working)[2] == '0' ? 'Yes' : (explode(',', $citizen->depend_working)[2] == '1' ? 'No' : '') }}</td>
                    </tr>
                    <tr>
                        <td class="border-2" colspan="6" style="padding-top: 2px;"></td>
                    </tr>
                    <tr>
                        <td class="default-font" colspan="6" style="background-color: #244464;  color: #FFFF; padding: 2px;" class="bold">III. EDUCATION / HR PROFILE</td>
                    </tr>
                    <tr>
                        <td class="default-font border-2 bold td-bg" colspan="3">26. Educational Attainment</td>
                        <td class="default-font border-2 bold td-bg" colspan="3">27. Areas of Specialization / Technical Skills (Check all applicable)</td>
                    </tr>
                </tbody>
            </table>
            <table class="">
                <thead>
                    <tr>
                        <th width="15%"></th>
                        <th width="15%"></th>
                        <th width="15%"></th>
                        <th width="15%"></th>
                        <th width="15%"></th>
                        <th width="15%"></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style="padding-top: 1px;" colspan="6" style="padding-top: 2px;"></td>
                    </tr>
                    <tr>
                        <td class="border-2 default-font"><input type="checkbox" style="margin-bottom: 2px;" @if(explode(',', $citizen->educ_attain)[0] != '') checked @endif> Elementary Level</td>
                        <td class="border-2 default-font"><input type="checkbox" style="margin-bottom: 2px;" @if(explode(',', $citizen->educ_attain)[1] != '') checked @endif> Elementary Graduate</td>
                        <td class="border-2 default-font"><input type="checkbox" style="margin-bottom: 2px;" @if(explode(',', $citizen->educ_attain)[2] != '') checked @endif> High School Level</td>
                        <td class="border-2 default-font"><input type="checkbox" style="margin-bottom: 2px;" @if(explode(',', $citizen->area_techskill)[0] != '') checked @endif> Medical</td>
                        <td class="border-2 default-font"><input type="checkbox" style="margin-bottom: 2px;" @if(explode(',', $citizen->area_techskill)[1] != '') checked @endif> Teaching</td>
                        <td class="border-2 default-font"><input type="checkbox" style="margin-bottom: 2px;" @if(explode(',', $citizen->area_techskill)[2] != '') checked @endif> Legal Services</td>
                    </tr>
                    <tr>
                        <td class="border-2 default-font"><input type="checkbox" style="margin-bottom: 2px;" @if(explode(',', $citizen->educ_attain)[3] != '') checked @endif> High School Graduate</td>
                        <td class="border-2 default-font"><input type="checkbox" style="margin-bottom: 2px;" @if(explode(',', $citizen->educ_attain)[4] != '') checked @endif> College Level</td>
                        <td class="border-2 default-font"><input type="checkbox" style="margin-bottom: 2px;" @if(explode(',', $citizen->educ_attain)[5] != '') checked @endif> College Graduate</td>
                        <td class="border-2 default-font"><input type="checkbox" style="margin-bottom: 2px;" @if(explode(',', $citizen->area_techskill)[3] != '') checked @endif> Dental</td>
                        <td class="border-2 default-font"><input type="checkbox" style="margin-bottom: 2px;" @if(explode(',', $citizen->area_techskill)[4] != '') checked @endif> Counseling</td>
                        <td class="border-2 default-font"><input type="checkbox" style="margin-bottom: 2px;" @if(explode(',', $citizen->area_techskill)[5] != '') checked @endif> Farming</td>
                    </tr>
                    <tr>
                        <td class="border-2 default-font"><input type="checkbox" style="margin-bottom: 2px;" @if(explode(',', $citizen->educ_attain)[6] != '') checked @endif> Post Graduate</td>
                        <td class="border-2 default-font"><input type="checkbox" style="margin-bottom: 2px;" @if(explode(',', $citizen->educ_attain)[7] != '') checked @endif> Vocational</td>
                        <td class="border-2 default-font"><input type="checkbox" style="margin-bottom: 2px;" @if(explode(',', $citizen->educ_attain)[8] != '') checked @endif> Not Attended School</td>
                        <td class="border-2 default-font"><input type="checkbox" style="margin-bottom: 2px;" @if(explode(',', $citizen->area_techskill)[6] != '') checked @endif> Fishing</td>
                        <td class="border-2 default-font"><input type="checkbox" style="margin-bottom: 2px;" @if(explode(',', $citizen->area_techskill)[7] != '') checked @endif> Cooking</td>
                        <td class="border-2 default-font"><input type="checkbox" style="margin-bottom: 2px;" @if(explode(',', $citizen->area_techskill)[8] != '') checked @endif> Arts</td>
                    </tr>
                    <tr>
                        <td class="default-font border-2 bold td-bg" colspan="3">28. Share Skill (Community Service)</td>
                        <td class="border-2 default-font"><input type="checkbox" style="margin-bottom: 2px;" @if(explode(',', $citizen->area_techskill)[9] != '') checked @endif> Engineering</td>
                        <td class="border-2 default-font"><input type="checkbox" style="margin-bottom: 2px;" @if(explode(',', $citizen->area_techskill)[10] != '') checked @endif> Carpenter</td>
                        <td class="border-2 default-font"><input type="checkbox" style="margin-bottom: 2px;" @if(explode(',', $citizen->area_techskill)[11] != '') checked @endif> Plumber</td>
                    </tr>
                    <tr>
                        <td class="default-font border-2 bold" colspan="3">
                            <input type="checkbox" style="margin-bottom: 2px;" @if(explode(',', $citizen->share_skill)[0] != '') checked @endif> 1 @if(explode(',', $citizen->share_skill)[0] != '') {{ explode(',', $citizen->share_skill)[0] }} @endif</td>
                        </td>
                        <td class="border-2 default-font"><input type="checkbox" style="margin-bottom: 2px;" @if(explode(',', $citizen->area_techskill)[12] != '') checked @endif> Barber</td>
                        <td class="border-2 default-font"><input type="checkbox" style="margin-bottom: 2px;" @if(explode(',', $citizen->area_techskill)[13] != '') checked @endif> Mason</td>
                        <td class="border-2 default-font"><input type="checkbox" style="margin-bottom: 2px;" @if(explode(',', $citizen->area_techskill)[14] != '') checked @endif> Sapatero</td>
                    </tr>
                    <tr>
                        <td class="default-font border-2 bold" colspan="3">
                            <input type="checkbox" style="margin-bottom: 2px;" @if(explode(',', $citizen->share_skill)[1] != '') checked @endif> 2  @if(explode(',', $citizen->share_skill)[1] != '') {{ explode(',', $citizen->share_skill)[1] }} @endif</td>
                        </td>
                        <td class="border-2 default-font"><input type="checkbox" style="margin-bottom: 2px;" @if(explode(',', $citizen->area_techskill)[15] != '') checked @endif> Evangelization</td>
                        <td class="border-2 default-font"><input type="checkbox" style="margin-bottom: 2px;" @if(explode(',', $citizen->area_techskill)[16] != '') checked @endif> Tailor</td>
                        <td class="border-2 default-font"><input type="checkbox" style="margin-bottom: 2px;" @if(explode(',', $citizen->area_techskill)[17] != '') checked @endif> Chef/Cook</td>
                    </tr>
                    <tr>
                        <td class="default-font border-2 bold" colspan="3">
                            <input type="checkbox" style="margin-bottom: 2px;" @if(explode(',', $citizen->share_skill)[2] != '') checked @endif> 3  @if(explode(',', $citizen->share_skill)[2] != '') {{ explode(',', $citizen->share_skill)[2] }} @endif</td>
                        </td>
                        <td class="border-2 default-font"><input type="checkbox" style="margin-bottom: 2px;" @if(explode(',', $citizen->area_techskill)[18] != '') checked @endif> Millwright</td>
                        <td class="border-2 default-font" colspan="2"><input type="checkbox" style="margin-bottom: 2px;" @if(explode(',', $citizen->area_techskill)[19] != '') checked @endif> Others, specify: {{ explode(',', $citizen->area_techskill)[19] }}</td>
                    </tr>
                    <tr>
                        <td class="default-font border-2 bold td-bg" colspan="6">29. Community Service and Involvement (Check all applicable)</td>
                    </tr>
                    <tr>
                        <td class="border-2 default-font" colspan="2"><input type="checkbox" style="margin-bottom: 2px;" @if(explode(',', $citizen->comm_serveinv)[0] != '') checked @endif> Medical</td>
                        <td class="border-2 default-font" colspan="2"><input type="checkbox" style="margin-bottom: 2px;" @if(explode(',', $citizen->comm_serveinv)[1] != '') checked @endif> Resource Volunteer</td>
                        <td class="border-2 default-font" colspan="2"><input type="checkbox" style="margin-bottom: 2px;" @if(explode(',', $citizen->comm_serveinv)[2] != '') checked @endif> Community Beautification</td>
                    </tr>
                    <tr>
                        <td class="border-2 default-font" colspan="2"><input type="checkbox" style="margin-bottom: 2px;" @if(explode(',', $citizen->comm_serveinv)[3] != '') checked @endif> Community / Organization Leader</td>
                        <td class="border-2 default-font" colspan="2"><input type="checkbox" style="margin-bottom: 2px;" @if(explode(',', $citizen->comm_serveinv)[4] != '') checked @endif> Dental</td>
                        <td class="border-2 default-font" colspan="2"><input type="checkbox" style="margin-bottom: 2px;" @if(explode(',', $citizen->comm_serveinv)[5] != '') checked @endif> Friendly Visits</td>
                    </tr>
                    <tr>
                        <td class="border-2 default-font" colspan="2"><input type="checkbox" style="margin-bottom: 2px;" @if(explode(',', $citizen->comm_serveinv)[6] != '') checked @endif> Neighborhood Support Services</td>
                        <td class="border-2 default-font" colspan="2"><input type="checkbox" style="margin-bottom: 2px;" @if(explode(',', $citizen->comm_serveinv)[7] != '') checked @endif> Legal Services</td>
                        <td class="border-2 default-font" colspan="2"><input type="checkbox" style="margin-bottom: 2px;" @if(explode(',', $citizen->comm_serveinv)[8] != '') checked @endif> Religious</td>
                    </tr>
                    <tr>
                        <td class="border-2 default-font" colspan="2"><input type="checkbox" style="margin-bottom: 2px;" @if(explode(',', $citizen->comm_serveinv)[9] != '') checked @endif> Counseling / Referral</td>
                        <td class="border-2 default-font" colspan="2"><input type="checkbox" style="margin-bottom: 2px;" @if(explode(',', $citizen->comm_serveinv)[10] != '') checked @endif> Sponsorship</td>
                        <td class="border-2 default-font" colspan="2"><input type="checkbox" style="margin-bottom: 2px;" @if(explode(',', $citizen->comm_serveinv)[11] != '') checked @endif> Others, specify : {{ explode(',', $citizen->comm_serveinv)[11] }}</td>
                    </tr>
                    <tr>
                        <td style="padding-top: 1px;" colspan="6" style="padding-top: 2px;"></td>
                    </tr>
                    <tr>
                        <td class="border-2 default-font" colspan="6" style="padding-top: 2px;">
                            Code reference Prefix : A=Region I (Ilocos); B=Region II (Cagayan Valley); C=Region III (Central Luzon); D=Region IVA (CALABARZON); E=Region IVB (MIMAROPA); 
                            F=Region V (Bicol); G=Region IV (Western Visayas); H=Region VII (Central Visayas); I=Region VIII (Eastern Visayas); J=Region IX (Zamboanga Peninsula); 
                            K=Region X (Northern Mindanao); L=Region XI (Davao); M=Region XII (SOCCSKSARGEN); N=Region XIII (CARAGA); O=NCR; P=CAR; Q=BARMM
                        </td>
                    </tr>
                    <tr>
                        <td class="bold" style="font-size: 9px;" colspan="6">
                            <span style="float: left;">NCSC-SCDF v. 4.0b3</span>
                            <span style="float: right;">THIS FORM IS NOT FOR SALE.</span>
                        </td>
                    </tr>
                    <tr>
                        <td class="text-center" style="font-size: 9px;" colspan="6">Page 1 of 2</td>
                    </tr>
                </tbody>
            </table>
            <table class="">
                <thead>
                    <tr>
                        <th width="17%"></th>
                        <th width="17%"></th>
                        <th width="17%"></th>
                        <th width="17%"></th>
                        <th width="42%"></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="default-font" colspan="6" style="background-color: #244464;  color: #FFFF; padding: 2px;" class="bold">IV. DEPENDENCY PROFILE</td>
                    </tr>
                    <tr>
                        <td class="default-font border-2 bold td-bg" colspan="3">30. Living/Residing with (check all applicable)</td>
                        <td class="default-font border-2 bold td-bg" colspan="3">31. Household Condition</td>
                    </tr>
                    <tr>
                        <td class="border-2 default-font"><input type="checkbox" style="margin-bottom: 2px;"  @if(explode(',', $citizen->living_reside)[0] != '') checked @endif> Alone</td>
                        <td class="border-2 default-font"><input type="checkbox" style="margin-bottom: 2px;"  @if(explode(',', $citizen->living_reside)[1] != '') checked @endif> Grand Child(ren)</td>
                        <td class="border-2 default-font"><input type="checkbox" style="margin-bottom: 2px;"  @if(explode(',', $citizen->living_reside)[2] != '') checked @endif> Common Law Spouse</td>
                        <td class="border-2 default-font"><input type="checkbox" style="margin-bottom: 2px;"  @if(explode(',', $citizen->house_cond)[0] != '') checked @endif> No privacy</td>
                        <td class="border-2 default-font"><input type="checkbox" style="margin-bottom: 2px;"  @if(explode(',', $citizen->house_cond)[1] != '') checked @endif> Overcrowded in home</td>
                    </tr>
                    <tr>
                        <td class="border-2 default-font"><input type="checkbox" style="margin-bottom: 2px;"  @if(explode(',', $citizen->living_reside)[3] != '') checked @endif> Spouse</td>
                        <td class="border-2 default-font"><input type="checkbox" style="margin-bottom: 2px;"  @if(explode(',', $citizen->living_reside)[4] != '') checked @endif> In-law(s)</td>
                        <td class="border-2 default-font"><input type="checkbox" style="margin-bottom: 2px;"  @if(explode(',', $citizen->living_reside)[5] != '') checked @endif> Care Institution</td>
                        <td class="border-2 default-font"><input type="checkbox" style="margin-bottom: 2px;"  @if(explode(',', $citizen->house_cond)[2] != '') checked @endif> Informal Settler</td>
                        <td class="border-2 default-font"><input type="checkbox" style="margin-bottom: 2px;"  @if(explode(',', $citizen->house_cond)[3] != '') checked @endif> No permanent house</td>
                    </tr>
                    <tr>
                        <td class="border-2 default-font"><input type="checkbox" style="margin-bottom: 2px;"  @if(explode(',', $citizen->living_reside)[6] != '') checked @endif> Child(ren)</td>
                        <td class="border-2 default-font"><input type="checkbox" style="margin-bottom: 2px;"  @if(explode(',', $citizen->living_reside)[7] != '') checked @endif> Relative(s)</td>
                        <td class="border-2 default-font"><input type="checkbox" style="margin-bottom: 2px;"  @if(explode(',', $citizen->living_reside)[8] != '') checked @endif> Friend(s)</td>
                        <td class="border-2 default-font"><input type="checkbox" style="margin-bottom: 2px;"  @if(explode(',', $citizen->house_cond)[4] != '') checked @endif> High cost of rent</td>
                        <td class="border-2 default-font"><input type="checkbox" style="margin-bottom: 2px;"  @if(explode(',', $citizen->house_cond)[5] != '') checked @endif> Longing for independent living quiet atmosphere</td>
                    </tr>
                    <tr>
                        <td class="border-2 default-font" colspan="3"><input type="checkbox" style="margin-bottom: 2px;" @if(explode(',', $citizen->living_reside)[6] != '') checked @endif> Others, pls specify : {{ explode(',', $citizen->living_reside)[6] }}</td>
                        <td class="border-2 default-font" colspan="3"><input type="checkbox" style="margin-bottom: 2px;" @if(explode(',', $citizen->house_cond)[6] != '') checked @endif> Others, pls specify : {{ explode(',', $citizen->house_cond)[6] }}</td>
                    </tr>
                    <tr>
                        <td class="default-font" colspan="6" style="background-color: #244464;  color: #FFFF; padding: 2px;" class="bold">V. ECONOMIC PROFILE</td>
                    </tr>
                    <tr>
                        <td class="default-font border-2 bold td-bg" colspan="5">32. Source of Income and Assistance (Check all applicable)</td>
                    </tr>
                    <tr>
                        <td class="border-2 default-font" colspan="2"><input type="checkbox" style="margin-bottom: 2px;" @if(explode(',', $citizen->source_inass)[0] != '') checked @endif> Own earnings, salary / wages</td>
                        <td class="border-2 default-font" colspan="2"><input type="checkbox" style="margin-bottom: 2px;" @if(explode(',', $citizen->source_inass)[1] != '') checked @endif> Own Pension</td>
                        <td class="border-2 default-font" colspan="2"><input type="checkbox" style="margin-bottom: 2px;" @if(explode(',', $citizen->source_inass)[2] != '') checked @endif> Stocks / Dividends</td>
                    </tr>
                    <tr>
                        <td class="border-2 default-font" colspan="2"><input type="checkbox" style="margin-bottom: 2px;" @if(explode(',', $citizen->source_inass)[3] != '') checked @endif> Dependent on children / relatives</td>
                        <td class="border-2 default-font" colspan="2"><input type="checkbox" style="margin-bottom: 2px;" @if(explode(',', $citizen->source_inass)[4] != '') checked @endif> Spouse's salary</td>
                        <td class="border-2 default-font" colspan="2"><input type="checkbox" style="margin-bottom: 2px;" @if(explode(',', $citizen->source_inass)[5] != '') checked @endif> Insurance</td>
                    </tr>
                    <tr>
                        <td class="border-2 default-font" colspan="2"><input type="checkbox" style="margin-bottom: 2px;" @if(explode(',', $citizen->source_inass)[6] != '') checked @endif> Spouse's Pension</td>
                        <td class="border-2 default-font" colspan="2"><input type="checkbox" style="margin-bottom: 2px;" @if(explode(',', $citizen->source_inass)[7] != '') checked @endif> Rentals / sharecrops</td>
                        <td class="border-2 default-font" colspan="2"><input type="checkbox" style="margin-bottom: 2px;" @if(explode(',', $citizen->source_inass)[8] != '') checked @endif> Savings</td>
                    </tr>
                    <tr>
                        <td class="border-2 default-font" colspan="2"><input type="checkbox" style="margin-bottom: 2px;" @if(explode(',', $citizen->source_inass)[9] != '') checked @endif> Livestock / orchard / farm</td>
                        <td class="border-2 default-font" colspan="2"><input type="checkbox" style="margin-bottom: 2px;" @if(explode(',', $citizen->source_inass)[10] != '') checked @endif> Fishing</td>
                        <td class="border-2 default-font" colspan="2"><input type="checkbox" style="margin-bottom: 2px;" @if(explode(',', $citizen->source_inass)[11] != '') checked @endif> Other, specify : {{ explode(',', $citizen->source_inass)[11] }}</td>
                    </tr>
                </tbody>
            </table>
            <table>
                    <img src="{{ \App\Support\PdfAsset::image('template/img/thumb-box.jpg') }}" class="img-fluid thumbmark-image">
                <thead>
                    <tr>
                        <th width="16.6%"></th>
                        <th width="16.6%"></th>
                        <th width="16.6%"></th>
                        <th width="16.6%"></th>
                        <th width="16.6%"></th>
                        <th width="16.6%"></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                    <div class="centered-text1">
                        NOT FOR SALE
                    </div> 
                    <tr>
                        <td class="default-font border-2 bold td-bg" colspan="3">33. Assets: Real and Immovable Properties (Check all applicable)</td>
                        <td class="default-font border-2 bold td-bg" colspan="3">34. Assets: Personal and Movable Properties</td>
                    </tr>
                    <tr>
                        <td class="border-2 default-font"><input type="checkbox" style="margin-bottom: 2px;" @if(explode(',', $citizen->assreal_immov)[0] != '') checked @endif> House</td>
                        <td class="border-2 default-font"><input type="checkbox" style="margin-bottom: 2px;" @if(explode(',', $citizen->assreal_immov)[1] != '') checked @endif> Lot / Farmland</td>
                        <td class="border-2 default-font"><input type="checkbox" style="margin-bottom: 2px;" @if(explode(',', $citizen->assreal_immov)[2] != '') checked @endif> House & Lot</td>
                        <td class="border-2 default-font"><input type="checkbox" style="margin-bottom: 2px;" @if(explode(',', $citizen->assr_permov)[0] != '') checked @endif> Automobile</td>
                        <td class="border-2 default-font"><input type="checkbox" style="margin-bottom: 2px;" @if(explode(',', $citizen->assr_permov)[1] != '') checked @endif> Personal Computer</td>
                        <td class="border-2 default-font"><input type="checkbox" style="margin-bottom: 2px;" @if(explode(',', $citizen->assr_permov)[2] != '') checked @endif> Boats</td>
                    </tr>
                    <tr>
                        <td class="border-2 default-font" colspan="2"><input type="checkbox" style="margin-bottom: 2px;" @if(explode(',', $citizen->assreal_immov)[3] != '') checked @endif> Commercial Building</td>
                        <td class="border-2 default-font"><input type="checkbox" style="margin-bottom: 2px;" @if(explode(',', $citizen->assreal_immov)[4] != '') checked @endif> Fishpond / resort</td>
                        <td class="border-2 default-font"><input type="checkbox" style="margin-bottom: 2px;" @if(explode(',', $citizen->assr_permov)[3] != '') checked @endif> Heavy Equipment</td>
                        <td class="border-2 default-font"><input type="checkbox" style="margin-bottom: 2px;" @if(explode(',', $citizen->assr_permov)[4] != '') checked @endif> Laptops</td>
                        <td class="border-2 default-font"><input type="checkbox" style="margin-bottom: 2px;" @if(explode(',', $citizen->assr_permov)[5] != '') checked @endif> Drones</td>
                    </tr>
                    <tr>
                        <td class="border-2 default-font" colspan="3"><input type="checkbox" style="margin-bottom: 2px;"> Others, specify : {{ explode(',', $citizen->assreal_immov)[5] }}</td>
                        <td class="border-2 default-font"><input type="checkbox" style="margin-bottom: 2px;" @if(explode(',', $citizen->assr_permov)[6] != '') checked @endif> Motorcycle</td>
                        <td class="border-2 default-font"><input type="checkbox" style="margin-bottom: 2px;" @if(explode(',', $citizen->assr_permov)[7] != '') checked @endif> Mobile Phones</td>
                        <td class="border-2 default-font"><input type="checkbox" style="margin-bottom: 2px;" @if(explode(',', $citizen->assr_permov)[8] != '') checked @endif> specify : {{ explode(',', $citizen->assr_permov)[8] }}</td>
                    </tr>
                    <tr>
                        <td class="default-font border-2 bold td-bg" colspan="3">35. Monthly Income (in Philippine Peso)</td>
                        <td class="border-2 default-font" colspan="3"></td>
                    </tr>
                    <tr>
                        <td class="border-2 default-font"><input type="checkbox" style="margin-bottom: 2px;" @if(explode(',', $citizen->month_inc)[0] != '') checked @endif> 60,000 and above</td>
                        <td class="border-2 default-font"><input type="checkbox" style="margin-bottom: 2px;" @if(explode(',', $citizen->month_inc)[1] != '') checked @endif> 50,000 to 60,000</td>
                        <td class="border-2 default-font"><input type="checkbox" style="margin-bottom: 2px;" @if(explode(',', $citizen->month_inc)[2] != '') checked @endif> 40,000 to 50,000</td>
                        <td class="default-font bold" colspan="3" style="background-color: #002060; color: #FFFF; padding: 2px;">36. Problems / Needs Commonly Encountered (Check all applicable)</td>
                    </tr>
                    <tr>
                        <td class="border-2 default-font"><input type="checkbox" style="margin-bottom: 2px;" @if(explode(',', $citizen->month_inc)[3] != '') checked @endif> 30,000 to 40,000</td>
                        <td class="border-2 default-font"><input type="checkbox" style="margin-bottom: 2px;" @if(explode(',', $citizen->month_inc)[4] != '') checked @endif> 20,000 to 30,000</td>
                        <td class="border-2 default-font"><input type="checkbox" style="margin-bottom: 2px;" @if(explode(',', $citizen->month_inc)[5] != '') checked @endif> 10,000 to 20,000</td>
                        <td class="border-2 default-font" colspan="3"><input type="checkbox" style="margin-bottom: 2px;" @if(explode(',', $citizen->prob_needs)[0] != '') checked @endif> Lack of income / resources</td>
                    </tr>
                    <tr>
                        <td class="border-2 default-font"><input type="checkbox" style="margin-bottom: 2px;" @if(explode(',', $citizen->month_inc)[6] != '') checked @endif> 5,000 to 10,000</td>
                        <td class="border-2 default-font"><input type="checkbox" style="margin-bottom: 2px;" @if(explode(',', $citizen->month_inc)[7] != '') checked @endif> 1,000 to 5,000</td>
                        <td class="border-2 default-font"><input type="checkbox" style="margin-bottom: 2px;" @if(explode(',', $citizen->month_inc)[8] != '') checked @endif> Below 1,000</td>
                        <td class="border-2 default-font" colspan="3"><input type="checkbox" style="margin-bottom: 2px;" @if(explode(',', $citizen->prob_needs)[1] != '') checked @endif> Loss of income / resources</td>
                    </tr>
                    <tr>
                        <td class="default-font border-2 bold td-bg" colspan="3" rowspan="3"></td>
                        <td class="border-2 default-font" colspan="3"><input type="checkbox" style="margin-bottom: 2px;" @if(explode(',', $citizen->prob_needs)[2] != '') checked @endif> Skills / capability training (specify)</td>
                    </tr>
                    <tr>
                        <td class="border-2 default-font" colspan="3"><input type="checkbox" style="margin-bottom: 2px;" @if(explode(',', $citizen->prob_needs)[3] != '') checked @endif> Livelihood opportunities (specify)</td>
                    </tr>
                    <tr>
                        <td class="border-2 default-font" colspan="3"><input type="checkbox" style="margin-bottom: 2px;" @if(explode(',', $citizen->prob_needs)[4] != '') checked @endif> Others, specify : {{ explode(',', $citizen->prob_needs)[4] }}</td>
                    </tr>
                    <tr>
                        <td class="default-font" colspan="6" style="background-color: #244464;  color: #FFFF; padding: 2px;" class="bold">VI. HEALTH PROFILE</td>
                    </tr>
                    <tr>
                        <td class="default-font border-2 bold td-bg1" colspan="3">37. Medical Concern</td>
                        <td class="default-font border-2 bold td-bg1" colspan="3">40. Hearing</td>
                    </tr>
                    <tr>
                        <td class="border-2 default-font" colspan="3">
                            <input type="checkbox" style="margin-bottom: 2px; padding-right: 12px;"  @if(explode(',', $citizen->med_concern)[0] != '') checked @endif> Blood type
                            <input type="checkbox" style="margin-bottom: 2px; padding-right: 12px;"  @if(explode(',', $citizen->med_concern)[0] == 1) checked @endif> O
                            <input type="checkbox" style="margin-bottom: 2px; padding-right: 12px;"  @if(explode(',', $citizen->med_concern)[0] == 2) checked @endif> A
                            <input type="checkbox" style="margin-bottom: 2px; padding-right: 12px;"  @if(explode(',', $citizen->med_concern)[0] == 3) checked @endif> B
                            <input type="checkbox" style="margin-bottom: 2px; padding-right: 12px;"  @if(explode(',', $citizen->med_concern)[0] == 4) checked @endif> AB
                            <input type="checkbox" style="margin-bottom: 2px; padding-right: 12px;"  @if(explode(',', $citizen->med_concern)[0] == 5) checked @endif> Don't know
                        </td>
                        <td class="border-2 default-font" colspan="3">
                            <input type="checkbox" style="margin-bottom: 2px;" @if(explode(',', $citizen->hearing)[0] != '') checked @endif> Aural impairment/ Hearing impairment
                        </td>
                    </tr>
                    <tr>
                        <td class="border-2 default-font" colspan="3">
                            <input type="checkbox" style="margin-bottom: 2px;" @if(explode(',', $citizen->med_concern)[1] != '') checked @endif> Physical Disability (specify): : {{ explode(',', $citizen->med_concern)[1] }}</td>
                        </td>
                        <td class="border-2 default-font" colspan="3">
                            <input type="checkbox" style="margin-bottom: 2px;" @if(explode(',', $citizen->hearing)[1] != '') checked @endif> Others : {{ explode(',', $citizen->hearing)[1] }}</td>
                        </td>
                    </tr>
                    <tr>
                        <td class="border-2 default-font" colspan="3">
                            <input type="checkbox" style="margin-bottom: 2px;" @if(explode(',', $citizen->med_concern)[2] != '') checked @endif> Health problems / ailments
                        </td>
                        <td class="default-font border-2 bold" colspan="3">41. Social / Emotional</td>
                    </tr>
                    <tr>
                        <td class="border-2 default-font">
                            <input type="checkbox" style="margin-bottom: 2px;" @if(explode(',', $citizen->med_concern)[3] != '') checked @endif> Hypertension
                        </td>
                        <td class="border-2 default-font">
                            <input type="checkbox" style="margin-bottom: 2px;" @if(explode(',', $citizen->med_concern)[4] != '') checked @endif> Arthritis / Gout
                        </td>
                        <td class="border-2 default-font">
                            <input type="checkbox" style="margin-bottom: 2px;" @if(explode(',', $citizen->med_concern)[5] != '') checked @endif> Coronary Heart Disease
                        </td>
                        <td class="border-2 default-font" colspan="3">
                            <input type="checkbox" style="margin-bottom: 2px;" @if(explode(',', $citizen->soc_emo)[0] != '') checked @endif> Feeling neglect / rejection
                        </td>
                    </tr>
                    <tr>
                        <td class="border-2 default-font">
                            <input type="checkbox" style="margin-bottom: 2px;" @if(explode(',', $citizen->med_concern)[6] != '') checked @endif> Diabetes
                        </td>
                        <td class="border-2 default-font" colspan="2">
                            <input type="checkbox" style="margin-bottom: 2px;" @if(explode(',', $citizen->med_concern)[7] != '') checked @endif> Chronic Kidney Disease
                        </td>
                        <td class="border-2 default-font" colspan="3">
                            <input type="checkbox" style="margin-bottom: 2px;" @if(explode(',', $citizen->soc_emo)[1] != '') checked @endif> Feeling helplessness / worthlessness
                        </td>
                    </tr>
                    <tr>
                        <td class="border-2 default-font" colspan="3">
                            <input type="checkbox" style="margin-bottom: 2px;" @if(explode(',', $citizen->med_concern)[8] != '') checked @endif> Alzheimer's / Dementia
                        </td>
                        <td class="border-2 default-font" colspan="3">
                            <input type="checkbox" style="margin-bottom: 2px;" @if(explode(',', $citizen->soc_emo)[2] != '') checked @endif> Feeling loneliness / isolate
                        </td>
                    </tr>
                    <tr>
                        <td class="border-2 default-font" colspan="3">
                            <input type="checkbox" style="margin-bottom: 2px;" @if(explode(',', $citizen->med_concern)[9] != '') checked @endif> Chronic Obstructive Pulmonary Disease
                        </td>
                        <td class="border-2 default-font" colspan="3">
                            <input type="checkbox" style="margin-bottom: 2px;" @if(explode(',', $citizen->soc_emo)[3] != '') checked @endif> Lack leisure / recreational activities
                        </td>
                    </tr>
                    <tr>
                        <td class="border-2 default-font" colspan="3">
                            <input type="checkbox" style="margin-bottom: 2px;"  @if(explode(',', $citizen->med_concern)[10] != '') checked @endif> Others, specify : {{ explode(',', $citizen->med_concern)[10] }}
                        </td>
                        <td class="border-2 default-font" colspan="3">
                            <input type="checkbox" style="margin-bottom: 2px;" @if(explode(',', $citizen->soc_emo)[4] != '') checked @endif> Lack SC friendly environment
                        </td>
                    </tr>
                    <tr>
                        <td class="default-font border-2 bold td-bg1" colspan="3">38. Dental Concern</td>
                        <td class="border-2 default-font" colspan="3">
                            <input type="checkbox" style="margin-bottom: 2px;" @if(explode(',', $citizen->soc_emo)[5] != '') checked @endif> Others, specify : {{ explode(',', $citizen->soc_emo)[5] }}</td>
                        </td>
                    </tr>
                    <tr>
                        <td class="border-2 default-font" colspan="3">
                            <input type="checkbox" style="margin-bottom: 2px;" @if(explode(',', $citizen->den_conern)[0] != '') checked @endif> Needs Dental Care
                        </td>
                        <td class="default-font border-2 bold td-bg1" colspan="3" rowspan="2">42. Area / Difficulty</td>
                    </tr>
                    <tr>
                        <td class="border-2 default-font" colspan="3">
                            <input type="checkbox" style="margin-bottom: 2px;" @if(explode(',', $citizen->den_conern)[1] != '') checked @endif> Others : {{ explode(',', $citizen->den_conern)[1] }}
                        </td>
                    </tr>
                    <tr>
                        <td class="default-font border-2 bold td-bg1" colspan="3">39. Optical</td>
                        <td class="border-2 default-font" colspan="3">
                            <input type="checkbox" style="margin-bottom: 2px;" @if(explode(',', $citizen->area_diff)[0] != '') checked @endif> High Cost of medicines
                        </td>
                    </tr>
                    <tr>
                        <td class="border-2 default-font" colspan="3">
                            <input type="checkbox" style="margin-bottom: 2px;" @if(explode(',', $citizen->optical)[0] != '') checked @endif> Eye impairment
                        </td>
                        <td class="border-2 default-font" colspan="3">
                            <input type="checkbox" style="margin-bottom: 2px;" @if(explode(',', $citizen->area_diff)[1] != '') checked @endif> Lack of medicines
                        </td>
                    </tr>
                    <tr>
                        <td class="border-2 default-font" colspan="3">
                            <input type="checkbox" style="margin-bottom: 2px;" @if(explode(',', $citizen->optical)[1] != '') checked @endif> Needs eye care
                        </td>
                        <td class="border-2 default-font" colspan="3">
                            <input type="checkbox" style="margin-bottom: 2px;" @if(explode(',', $citizen->area_diff)[2] != '') checked @endif> Lack of medical attention
                        </td>
                    </tr>
                    <tr>
                        <td class="border-2 default-font" colspan="3">
                            <input type="checkbox" style="margin-bottom: 2px;" @if(explode(',', $citizen->optical)[2] != '') checked @endif> Others : {{ explode(',', $citizen->optical)[2] }}
                        </td>
                        <td class="border-2 default-font" colspan="3">
                            <input type="checkbox" style="margin-bottom: 2px;" @if(explode(',', $citizen->area_diff)[3] != '') checked @endif> Others : {{ explode(',', $citizen->area_diff)[3] }}
                        </td>
                    </tr>
                    <tr>
                        <td class="default-font border-2 bold td-bg" colspan="6">43. List of Medicines for Maintenance</td>
                    </tr>
                    <tr>
                        <td class="border-2 default-font" colspan="2">{{ explode(',', $citizen->med_main)[0] }} <strong style="color: white;">.</strong></td>
                        <td class="border-2 default-font" colspan="2">{{ explode(',', $citizen->med_main)[1] }}</td>
                        <td class="border-2 default-font" colspan="2">{{ explode(',', $citizen->med_main)[2] }}</td>
                    </tr>
                    <tr>
                        <td class="border-2 default-font" colspan="2">{{ explode(',', $citizen->med_main)[3] }}<strong style="color: white;">.</strong></td>
                        <td class="border-2 default-font" colspan="2">{{ explode(',', $citizen->med_main)[4] }}</td>
                        <td class="border-2 default-font" colspan="2">{{ explode(',', $citizen->med_main)[5] }}</td>
                    </tr>
                    <tr>
                        <td class="border-2 default-font" colspan="2">{{ explode(',', $citizen->med_main)[6] }}<strong style="color: white;">.</strong></td>
                        <td class="border-2 default-font" colspan="2">{{ explode(',', $citizen->med_main)[7] }}</td>
                        <td class="border-2 default-font" colspan="2">{{ explode(',', $citizen->med_main)[8] }}</td>
                    </tr>
                    <tr>
                        <td class="border-2 default-font" colspan="2">{{ explode(',', $citizen->med_main)[9] }}<strong style="color: white;">.</strong></td>
                        <td class="border-2 default-font" colspan="2">{{ explode(',', $citizen->med_main)[10] }}</td>
                        <td class="border-2 default-font" colspan="2">{{ explode(',', $citizen->med_main)[11] }}</td>
                    </tr>
                    <tr>
                        <td class="default-font border-2 td-bg" colspan="2"><span class="bold">44.</span> Do you have a scheduled medical/physical check-up?</td>
                        <td class="border-2 default-font" colspan="4">
                            <input type="checkbox" style="margin-bottom: 2px; margin-left: 25px;" @if($citizen->med_sched == 0) checked @endif> Yes <input type="checkbox" style="margin-bottom: 2px; margin-left: 25px;" @if($citizen->med_sched == 1) checked @endif> No
                        </td>
                    </tr>
                    <tr>
                        <td class="default-font border-2 td-bg1" colspan="2"><span class="bold">45.</span> If Yes, when is it done?</td>
                        <td class="border-2 default-font" colspan="4">
                            <input type="checkbox" style="margin-bottom: 2px; margin-left: 25px;" @if($citizen->med_schedyes == 0) checked @endif> Yearly <input type="checkbox" style="margin-bottom: 2px; margin-left: 100px;" @if($citizen->med_schedyes == 1) checked @endif> Every 6 months <input type="checkbox" style="margin-bottom: 2px; margin-left: 100px;" @if($citizen->med_schedyes == 2) checked @endif> Others
                        </td>
                    </tr>
                    <tr>
                        <td class="default-font border-2 td-bg1" style="padding-top: 10px;" colspan="6"></td>
                    </tr>
                    <tr>
                        <td style="font-size: 11px;" colspan="6">This certifies that I have willingly given my personal consent and willfully participated in the provision of data and relevant information regarding my
                            person, being part of the establishment of database of Senior Citizens. </td>
                    </tr>
                    <tr>
                        <td class="text-center default-font" colspan="3" style="padding-top: 10px;"><span style="padding-top: 2px; border-top: 1px solid black;">Name and Signature of Senior Citizen</span></td>
                        <td class="text-center default-font" colspan="3" style="padding-top: 88px;">Right Thumb Print of Senior Citizen</td>
                    </tr>
                    <tr>
                        <td class="text-center default-font" colspan="3" style="padding-top: 21px;"><span style="padding-top: 2px; border-top: 1px solid black;">Name and Signature of Assisting Person 1</span></td>
                        <td class="text-center default-font" colspan="3" style="padding-top: 21px;"><span style="padding-top: 2px; border-top: 1px solid black;">Relationship to Senior Citizen</span></td>
                    </tr>
                    <tr>
                        <td class="text-center default-font" colspan="3" style="padding-top: 21px;"><span style="padding-top: 2px; border-top: 1px solid black;">Name and Signature of Assisting Person 2</span></td>
                        <td class="text-center default-font" colspan="3" style="padding-top: 21px;"><span style="padding-top: 2px; border-top: 1px solid black;">Relationship to Senior Citizen</span></td>
                    </tr>
                    <tr>
                        <td class="text-center default-font" colspan="3" style="padding-top: 21px;"><span style="padding-top: 2px; border-top: 1px solid black;">Name and Signature of Interviewer/Verifier</span></td>
                        <td class="text-center default-font" colspan="3" style="padding-top: 21px;"><span style="padding-top: 2px; border-top: 1px solid black;">Organization/Office</span></td>
                    </tr>
                    <tr>
                        <td class="bold default-font" colspan="6">Date of Interview: </td>
                    </tr>
                    <tr>
                        <td class="bold default-font" colspan="6">Place of Interview </td>
                    </tr>
                    
                </tbody>
            </table>
            <span class="bold default-font not-sale" colspan="6">THIS FORM IS NOT FOR SALE</span>
        </div>
    </div>
</body>
</html>
