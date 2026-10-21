@extends('layouts.master')

@section('body')
<style>
    .margin-input{
        margin-bottom: -15px;
    }
</style>
<div class="content">
    <div class="container-fluid" >
        <div class="row">   

            @include("dafac.submenu")

            <div class="col-lg-10">
                <div class="col-12">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="fas fa-dashboard"></i> Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('dafacRead') }}">FACED</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('dafacRead') }}">Records</a></li>
                            <li class="breadcrumb-item">Edit Record</li>
                        </ol> 
                    </nav>
                </div>
                <div class="card card-gray card-outline">
                        <div class="card-body">
                            <form action="{{ route('dafacUpdate') }}" class="form-horizontal" id="addCitizen" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-10">
                                        <br><br>
                                        <div class="form-group">
                                            <div class="form-row">
                                                <h2 class="card-title font-weight-bold badge badge-secondary mb-2 ml-1">Location of affected family</h2>
                                            </div>
                                            <div class="form-row">
                                                <div class="col-md-3">
                                                    <span class="label">Region </span>
                                                    <input type="hidden" name="id" value="{{ $id }}">
                                                    <select id="region" name="add_region" class="form-control form-control-sm" style="width: 100%;">
                                                        <option value="">Select</option>
                                                        @foreach($regions as $region)
                                                            <option value="{{ $region->region_id }}" @if($dafacedit->add_region == $region->region_id) selected @endif>{{ $region->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                
                                                <div class="col-md-3">
                                                    <span class="label">Province </span>
                                                    <select id="province" name="add_prov" class="form-control form-control-sm" style="width: 100%;">
                                                        <option disabled selected>Select</option>
                                                        @foreach($provinces as $province)
                                                            <option value="{{ $province->province_id }}" @if($dafacedit->add_prov == $province->province_id) selected @endif>{{ $province->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                
                                                <div class="col-md-3">
                                                    <span class="label">City / Municipality</span>
                                                    <select id="city" name="add_city" class="form-control form-control-sm" style="width: 100%;">
                                                        <option disabled selected>Select</option>
                                                        @foreach($cities as $city)
                                                            <option value="{{ $city->city_id }}" @if($dafacedit->add_city == $city->city_id) selected @endif>{{ $city->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                
                                                <div class="col-md-3">
                                                    <span class="label">Barangay</span>
                                                    <select id="barangay" name="add_brgy" class="form-control form-control-sm" style="width: 100%;">
                                                        <option disabled selected>Select</option>
                                                        <option value="{{ (isset($dafacedit->add_brgy)) ? $dafacedit->add_brgy : '' }}" 
                                                                data-column-id="{{ $dafacedit->id }}" 
                                                                data-column-name="add_brgy" 
                                                                selected>
                                                            {{ (isset($dafacedit->add_brgy) && $barangays) ? $barangays->name : 'N/A' }}
                                                        </option>
                                                    </select>
                                                </div>

                                                <div class="col-md-3 margin-input">
                                                    <span class="font-weight-bold">District</span>
                                                    <input type="text" name="district" value="{{ $dafacedit->district }}" class="form-control form-control-sm text-capitalize">
                                                </div>
                                                <div class="col-md-6 margin-input">
                                                    <span class="font-weight-bold">Evac. Center/Site</span>
                                                    <input type="text" name="brgy_evac_site" value="{{ $dafacedit->brgy_evac_site }}" class="form-control form-control-sm text-capitalize" required>
                                                </div>
                                                <div class="col-md-3 margin-input">
                                                    <span class="font-weight-bold">Serial Number</span>
                                                    <input type="hidden" name="count" value="{{ $dafacedit->count }}" required>
                                                    <input type="text" name="serial" id="serial" value="{{ $dafacedit->serial }}" class="form-control form-control-sm text-capitalize" readonly required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="form-row">
                                                <h2 class="card-title font-weight-bold badge badge-secondary mb-2 ml-1 mt-2">Head of the family</h2>
                                            </div>
                                            <div class="form-row">
                                                <div class="col-md-2 margin-input">
                                                    <span class="font-weight-bold">Last Name</span>
                                                    <input type="text" name="surname" class="form-control form-control-sm text-capitalize" value="{{ $dafacedit->surname }}" required>
                                                </div>
                                                <div class="col-md-2 margin-input">
                                                    <span class="font-weight-bold">First Name</span>
                                                    <input type="text" name="fname" class="form-control form-control-sm text-capitalize" value="{{ $dafacedit->fname }}" required>
                                                </div>
                                                <div class="col-md-2 margin-input">
                                                    <span class="font-weight-bold">Middle Name</span>
                                                    <input type="text" name="mname" class="form-control form-control-sm text-capitalize" value="{{ $dafacedit->mname }}" required>
                                                </div>
                                                <div class="col-md-2 margin-input">
                                                    <span class="font-weight-bold">Extension</span>
                                                    <select type="text" name="ext" class="form-control form-control-sm text-capitalize" required>
                                                        <option value="">-- Select --</option>
                                                        <option @if($dafacedit->ext == 'Jr') selected @endif>Jr</option>
                                                        <option @if($dafacedit->ext == 'Sr') selected @endif>Sr</option>
                                                        <option @if($dafacedit->ext == 'II') selected @endif>II</option>
                                                        <option @if($dafacedit->ext == 'III') selected @endif>III</option>
                                                        <option @if($dafacedit->ext == 'IV') selected @endif>IV</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-2 margin-input">
                                                    <span class="font-weight-bold">Date of Birth</span>
                                                    <input type="date" name="d_birth" id="d_birth" value="{{ $dafacedit->d_birth }}" class="form-control form-control-sm text-capitalize" required>
                                                </div>
                                                <div class="col-md-2 margin-input">
                                                    <span class="font-weight-bold">Age</span>
                                                    <input type="text" name="age" id="age" value="{{ $dafacedit->age }}" class="form-control form-control-sm text-capitalize" readonly required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="form-row">
                                                <div class="col-md-2 margin-input">
                                                    <span class="font-weight-bold">Birth Place</span>
                                                    <input type="text" name="b_place" value="{{ $dafacedit->b_place }}" class="form-control form-control-sm text-capitalize" required>
                                                </div>
                                                <div class="col-md-2 margin-input">
                                                    <span class="font-weight-bold">Sex</span>
                                                    <select type="text" name="gender" class="form-control form-control-sm text-capitalize" required>
                                                        <option value="">Select Gender</option>
                                                        <option value="M" @if($dafacedit->gender == "M") selected @endif>Male</option>
                                                        <option value="F" @if($dafacedit->gender == "F") selected @endif>Female</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-2 margin-input">
                                                    <span class="font-weight-bold">Civil Status</span>
                                                    <select type="text" name="civil_status" class="form-control form-control-sm mt2" required>
                                                        <option value="">-- Select --</option>
                                                        <option @if($dafacedit->civil_status == "Single") selected @endif>Single</option>
                                                        <option @if($dafacedit->civil_status == "Married") selected @endif>Married</option>
                                                        <option @if($dafacedit->civil_status == "Seperated") selected @endif>Seperated</option>
                                                        <option @if($dafacedit->civil_status == "Widow") selected @endif>Widow</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-2 margin-input">
                                                    <span class="font-weight-bold">Mothers Maiden Name</span>
                                                    <input type="text" name="m_maid_name" value="{{ $dafacedit->m_maid_name }}" class="form-control form-control-sm text-capitalize" required>
                                                </div>
                                                <div class="col-md-2 margin-input">
                                                    <span class="font-weight-bold">Religion</span>
                                                    <select type="text" name="religion" class="form-control form-control-sm mt2" required>
                                                        <option value="">-- Select --</option>
                                                        <option value="Roman Catholic" @if($dafacedit->religion == "Roman Catholic") selected @endif>Roman Catholic</option>
                                                        <option value="Protestant" @if($dafacedit->religion == "Protestant") selected @endif>Protestant</option>
                                                        <option value="Islam" @if($dafacedit->religion == "Islam") selected @endif>Islam</option>
                                                        <option value="Iglesia ni Cristo" @if($dafacedit->religion == "Iglesia ni Cristo") selected @endif>Iglesia ni Cristo</option>
                                                        <option value="Aglipayan" @if($dafacedit->religion == "Aglipayan") selected @endif>Aglipayan</option>
                                                        <option value="Adventist" @if($dafacedit->religion == "Adventist") selected @endif>Adventist</option>
                                                        <option value="Mormons" @if($dafacedit->religion == "Mormons") selected @endif>Mormons</option>
                                                    </select>
                                                </div>
                                                <!--<div class="col-md-2 margin-input">-->
                                                <!--    <span class="font-weight-bold">City/Municipality</span>-->
                                                <!--    <select type="text" name="city_mun_head" class="form-control form-control-sm mt2" required>-->
                                                <!--        <option disabled selected>Select</option>-->
                                                <!--        @foreach($citys as $city)-->
                                                <!--            <option value="{{ $city->id }}" @if($dafacedit->city_mun_head == $city->id) selected @endif>{{ $city->name }}</option>-->
                                                <!--        @endforeach-->
                                                <!--    </select>-->
                                                <!--</div>-->
                                            </div>    
                                        </div>
                                        <div class="form-group">
                                            <div class="form-row">
                                                <div class="col-md-2 margin-input">
                                                    <span class="font-weight-bold">Occupation</span>
                                                    <input type="text" name="occupation" value="{{ $dafacedit->occupation }}" class="form-control form-control-sm text-capitalize" required>
                                                </div>
                                                <div class="col-md-2 margin-input">
                                                    <span class="font-weight-bold">Monthly Net Income</span>
                                                    <input type="text" name="mincome" value="{{ $dafacedit->mincome }}" class="form-control form-control-sm text-capitalize" oninput="formatNumber(this)" required>
                                                </div>
                                                <div class="col-md-2 margin-input">
                                                    <span class="font-weight-bold">ID Card Presented</span>
                                                    <select type="text" name="id_present" class="form-control form-control-sm text-capitalize" required>
                                                        <option value="">-- Select --</option>
                                                        <option @if($dafacedit->id_present == "UMID") selected @endif>UMID</option>
                                                        <option @if($dafacedit->id_present == "Postal ID") selected @endif>Postal ID</option>
                                                        <option @if($dafacedit->id_present == "PRC") selected @endif>PRC</option>
                                                        <option @if($dafacedit->id_present == "National ID") selected @endif>National ID</option>
                                                        <option @if($dafacedit->id_present == "GSIS ID") selected @endif>GSIS ID</option>
                                                        <option @if($dafacedit->id_present == "OSCA") selected @endif>OSCA</option>
                                                        <option @if($dafacedit->id_present == "DFA") selected @endif>DFA</option>
                                                        <option @if($dafacedit->id_present == "Voter's ID") selected @endif>Voter's ID</option>
                                                        <option @if($dafacedit->id_present == "Driver's License") selected @endif>Driver's License</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-4 margin-input">
                                                    <span class="font-weight-bold">ID Card Number</span>
                                                    <input type="text" name="id_cardnum" value="{{ $dafacedit->id_cardnum }}" class="form-control form-control-sm text-capitalize" required>
                                                </div>
                                                <div class="col-md-2 margin-input">
                                                    <span class="font-weight-bold">Contact #1</span>
                                                    <input type="number" name="contact_1" value="{{ $dafacedit->contact_1 }}" class="form-control form-control-sm text-capitalize" required>
                                                </div>
                                                <div class="col-md-2 margin-input">
                                                    <span class="font-weight-bold">Contact #2</span>
                                                    <input type="number" name="contact_2" value="{{ $dafacedit->contact_2 }}" class="form-control form-control-sm text-capitalize" required>
                                                </div>
                                            </div>  
                                        </div>
                                        <div class="form-group">
                                            <div class="form-row">
                                                <div class="col-md-12 margin-input">
                                                    <span class="font-weight-bold">Permanent Address</span>
                                                    <input type="text" name="per_address" value="{{ $dafacedit->per_address }}" class="form-control form-control-sm text-capitalize" required>
                                                </div>
                                            </div>  
                                        </div>
                                        <hr class="mt-5">
                                        <div class="form-group">
                                            <div class="form-group">
                                                <div class="form-row d-flex align-items-center justify-content-between">
                                                    <h2 class="card-title font-weight-bold badge badge-secondary mb-2 ml-1">Family members</h2>
                                                    <a class="btn btn-info btn-sm mb-2" onclick="addFamilyMember()"><i class="fas fa-user-plus"></i> Add Member</a>
                                                </div>                                             
                                                <div class="form-row margin-input">
                                                    <div class="col-md-2">
                                                        <span class="font-weight-bold">Full Name</span>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <span class="font-weight-bold">Relation to Fam. head</span>
                                                    </div>
                                                    <div class="col-md-1">
                                                        <span class="font-weight-bold">Age</span>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <span class="font-weight-bold">Gender</span>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <span class="font-weight-bold">Education</span>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <span class="font-weight-bold">Occupational Skills</span>
                                                    </div>
                                                    <div class="col-md-1">
                                                        <span class="font-weight-bold">Remarks</span>
                                                    </div>
                                                </div>    
                                            </div>
                                            @php 
                                            $memfnameArray = $dafacedit->mem_fname;
                                            $memfnameArray = explode(',', $memfnameArray);
                                        
                                            $mem_relationArray = $dafacedit->mem_relation;
                                            $mem_relationArray = explode(',', $mem_relationArray);
    
                                            $mem_bdateArray = $dafacedit->mem_bdate;
                                            $mem_bdateArray = explode(',', $mem_bdateArray);
    
                                            $mem_ageArray = $dafacedit->mem_age;
                                            $mem_ageArray = explode(',', $mem_ageArray);
    
                                            $mem_genderArray = $dafacedit->mem_gender;
                                            $mem_genderArray = explode(',', $mem_genderArray);
    
                                            $mem_educArray = $dafacedit->mem_educ;
                                            $mem_educArray = explode(',', $mem_educArray);
    
                                            $mem_occupArray = $dafacedit->mem_occup;
                                            $mem_occupArray = explode(',', $mem_occupArray);
    
                                            $mem_remarksArray = $dafacedit->mem_remarks;
                                            $mem_remarksArray = explode(',', $mem_remarksArray);
                                            
                                            $checklistArray = $dafacedit->checklist;
                                            $checklistArray = explode(',', $checklistArray);
                                            @endphp
                                            
                                            @foreach ($memfnameArray as $index => $memfname)
                                                @php 
                                                    $mem_relation = $mem_relationArray[$index] ?? '';
                                                    $mem_bdate = $mem_bdateArray[$index] ?? '';
                                                    $mem_age = $mem_ageArray[$index] ?? '';
                                                    $mem_gender = $mem_genderArray[$index] ?? '';
                                                    $mem_educ = $mem_educArray[$index] ?? '';
                                                    $mem_occup = $mem_occupArray[$index] ?? '';
                                                    $mem_remarks = $mem_remarksArray[$index] ?? '';
                                                @endphp
                                            
                                                <div class="form-group" id="fam-me-row">
                                                    <div class="form-row margin-input">
                                                        <div class="col-md-2">
                                                            <input type="text" name="mem_fname[]" value="{{ $memfname }}" class="form-control form-control-sm text-capitalize" required>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <select type="text" name="mem_relation[]" class="form-control form-control-sm text-capitalize" required>
                                                                <option value="">Select Relation</option>
                                                                <option value="Husband" {{ $mem_relation == 'Husband' ? 'selected' : '' }}>Husband</option>
                                                                <option value="Wife" {{ $mem_relation == 'Wife' ? 'selected' : '' }}>Wife</option>
                                                                <option value="Son" {{ $mem_relation == 'Son' ? 'selected' : '' }}>Son</option>
                                                                <option value="Daughter" {{ $mem_relation == 'Daughter' ? 'selected' : '' }}>Daughter</option>
                                                                <option value="Father" {{ $mem_relation == 'Father' ? 'selected' : '' }}>Father</option>
                                                                <option value="Mother" {{ $mem_relation == 'Mother' ? 'selected' : '' }}>Mother</option>
                                                                <option value="Brother" {{ $mem_relation == 'Brother' ? 'selected' : '' }}>Brother</option>
                                                                <option value="Sister" {{ $mem_relation == 'Sister' ? 'selected' : '' }}>Sister</option>
                                                                <option value="Grandfather" {{ $mem_relation == 'Grandfather' ? 'selected' : '' }}>Grandfather</option>
                                                                <option value="Grandmother" {{ $mem_relation == 'Grandmother' ? 'selected' : '' }}>Grandmother</option>
                                                                <option value="Grandson" {{ $mem_relation == 'Grandson' ? 'selected' : '' }}>Grandson</option>
                                                                <option value="Granddaughter" {{ $mem_relation == 'Granddaughter' ? 'selected' : '' }}>Granddaughter</option>
                                                                <option value="Aunt" {{ $mem_relation == 'Aunt' ? 'selected' : '' }}>Aunt</option>
                                                                <option value="Uncle" {{ $mem_relation == 'Uncle' ? 'selected' : '' }}>Uncle</option>
                                                                <option value="First Cousin" {{ $mem_relation == 'First Cousin' ? 'selected' : '' }}>Cousin</option>
                                                                <option value="Father-in-law" {{ $mem_relation == 'Father-in-law' ? 'selected' : '' }}>Father-in-law</option>
                                                                <option value="Mother-in-law" {{ $mem_relation == 'Mother-in-law' ? 'selected' : '' }}>Mother-in-law</option>
                                                                <option value="Brother-in-law" {{ $mem_relation == 'Brother-in-law' ? 'selected' : '' }}>Brother-in-law</option>
                                                                <option value="Sister-in-law" {{ $mem_relation == 'Sister-in-law' ? 'selected' : '' }}>Sister-in-law</option>
                                                                <option value="Son-in-law" {{ $mem_relation == 'Son-in-law' ? 'selected' : '' }}>Son-in-law</option>
                                                                <option value="Daughter-in-law" {{ $mem_relation == 'Daughter-in-law' ? 'selected' : '' }}>Daughter-in-law</option>
                                                                <option value="Niece" {{ $mem_relation == 'Niece' ? 'selected' : '' }}>Niece</option>
                                                                <option value="Nephew" {{ $mem_relation == 'Nephew' ? 'selected' : '' }}>Nephew</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-1">
                                                            <input type="date" name="mem_bdate[]" value="{{ $mem_bdate }}" class="form-control form-control-sm text-capitalize" required>
                                                        </div>
                                                        <div class="col-md-1">
                                                            <input type="number" name="mem_age[]" value="{{ $mem_age }}" class="form-control form-control-sm text-capitalize" required>
                                                        </div>
                                                        <div class="col-md-1">
                                                            <select type="text" name="mem_gender[]" value="{{ $mem_gender }}" class="form-control form-control-sm text-capitalize" required>
                                                                <option value="">Select Gender</option>
                                                                <option value="M" {{ $mem_gender == 'M' ? 'selected' : '' }}>Male</option>
                                                                <option value="F" {{ $mem_gender == 'F' ? 'selected' : '' }}>Female</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <select type="text" name="mem_educ[]" class="form-control form-control-sm text-capitalize" required>
                                                                <option value="">Select Educational Attainment</option>
                                                                <option value="1" {{ $mem_educ == 1 ? 'selected' : '' }}>No Formal Education</option>
                                                                <option value="2" {{ $mem_educ == 2 ? 'selected' : '' }}>Elementary School Graduate</option>
                                                                <option value="3" {{ $mem_educ == 3 ? 'selected' : '' }}>High School Graduate</option>
                                                                <option value="4" {{ $mem_educ == 4 ? 'selected' : '' }}>Vocational or Technical School Graduate</option>
                                                                <option value="5" {{ $mem_educ == 5 ? 'selected' : '' }}>Associate's Degree Holder</option>
                                                                <option value="6" {{ $mem_educ == 6 ? 'selected' : '' }}>Bachelor's Degree Holder</option>
                                                                <option value="7" {{ $mem_educ == 7 ? 'selected' : '' }}>Master's Degree Holder</option>
                                                                <option value="8" {{ $mem_educ == 8 ? 'selected' : '' }}>Doctoral Degree Holder</option>
                                                                <option value="9" {{ $mem_educ == 9 ? 'selected' : '' }}>Professional Degree Holder</option>
                                                                <option value="10" {{ $mem_educ == 10 ? 'selected' : '' }}>High School Dropout</option>
                                                            </select>   
                                                        </div>
                                                        <div class="col-md-2">
                                                            <input type="text" name="mem_occup[]" value="{{ $mem_occup }}" class="form-control form-control-sm text-capitalize" required>
                                                        </div>
                                                        <div class="col-md-1">
                                                            <input type="text" name="mem_remarks[]" value="{{ $mem_remarks }}" class="form-control form-control-sm text-capitalize">
                                                        </div>
                                                    </div>    
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="col-2">
                                        <div class="form-row">
                                            <div class="col-md-12">
                                                <hr>
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input" name="ps_benef" value="1" @if($dafacedit->ps_benef == 1) checked @endif>
                                                    <label class="form-check-label">4P's beneficiary</label>
                                                </div>
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input" name="ip" value="1" @if($dafacedit->ip == 1) checked @endif>
                                                    <label class="form-check-label">Indigenous People</label> <br>
                                                    <input type="text" style="height: 20px; font-size: 11px; width: 41%; border-radius: 5px;" name="type_ethnicity" value="{{ $dafacedit->type_ethnicity }}" placeholder="Type of Ethnicity" class="text-capitalize">
                                                </div> 
                                                <hr>
                                                <div class="form-check mb-3">
                                                    <input type="number" style="width: 40px; text-align: center; margin-top: 0.1%; height: 30px; border-radius: 5px;" class="form-check-input mb-1" name="checklist1"  value="{{ ($checklistArray[0] !== 0) ? $checklistArray[0] : '' }}"> <span style="margin-left: 25px;"> No. of Older Person</span>                                                
                                                </div>
                                                <div class="form-check mb-3">
                                                    <input type="number" style="width: 40px; text-align: center; margin-top: 0.1%; height: 30px; border-radius: 5px;" class="form-check-input mb-1" name="checklist2"  value="{{ ($checklistArray[1] !== 0) ? $checklistArray[1] : '' }}"> <span style="margin-left: 25px;"> No. of Pregnant Women</span>                                                
                                                </div>
                                                <div class="form-check mb-3">
                                                    <input type="number" style="width: 40px; text-align: center; margin-top: 0.1%; height: 30px; border-radius: 5px;" class="form-check-input mb-1" name="checklist3"  value="{{ ($checklistArray[2] !== 0) ? $checklistArray[2] : '' }}"> <span style="margin-left: 25px;"> No. of Lactating Women</span>                                                
                                                </div>
                                                <div class="form-check mb-3">
                                                    <input type="number" style="width: 40px; text-align: center; margin-top: 0.1%; height: 30px; border-radius: 5px;" class="form-check-input mb-1" name="checklist4"  value="{{ ($checklistArray[3] !== 0) ? $checklistArray[3] : '' }}"> <span style="margin-left: 25px; float: right;"> No. of PWD's due to Medical &emsp; Condition/s</span>                                                
                                                </div><br><br> 
                                                <hr>
                                                <span class="font-weight-bold">House Ownership</span>
                                                <div class="form-check">
                                                    <input type="radio" class="form-check-input" name="checklist5" value="1" @if(!empty($checklistArray[5]) &&  $checklistArray[5] == 1) checked @endif required>
                                                    <label class="form-check-label">Owner</label>
                                                </div>
                                                <div class="form-check">
                                                    <input type="radio" class="form-check-input" name="checklist5" value="2" @if(!empty($checklistArray[5]) &&  $checklistArray[5] == 2) checked @endif required>
                                                    <label class="form-check-label">Renter</label>
                                                </div>
                                                <div class="form-check">
                                                    <input type="radio" class="form-check-input" name="checklist5" value="3" @if(!empty($checklistArray[5]) &&  $checklistArray[5] == 3) checked @endif required>
                                                    <label class="form-check-label">Sharer</label>
                                                </div>
                                                <span class="font-weight-bold">Shelter Damage Cassification</span>
                                                <div class="form-check">
                                                    <input type="radio" class="form-check-input" name="checklist6" value="1" @if(!empty($checklistArray[5]) &&  $checklistArray[5] == 1) checked @endif required>
                                                    <label class="form-check-label">Partially Damaged</label>
                                                </div>
                                                <div class="form-check">
                                                    <input type="radio" class="form-check-input" name="checklist6" value="2" @if(!empty($checklistArray[5]) &&  $checklistArray[5] == 2) checked @endif required>
                                                    <label class="form-check-label">Totally Damaged</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="form-row">
                                            <div class="col-md-12 mt-2">
                                                <button type="submit" name="btn-submit" class="btn btn-success ml-2">
                                                    <i class="fas fa-save"></i> Save
                                                </button>
                                            </div>
                                        </div>
                                    </div>  
                                </div>
                            </form>
                        </div>
                   </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection