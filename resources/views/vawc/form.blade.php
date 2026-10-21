@extends('layouts.master')

@section('body')
<style>
    .margin-input{
        margin-bottom: -15px;
    }
</style>
<div class="content module-workspace">
    <div class="container-fluid" >
        <div class="row">
            <div class="col-12 module-workspace__main">
                @include('partials.workspace-header', ['module' => 'VAWC', 'title' => 'Add VAWC record', 'description' => 'Complete intake and household details below.', 'backRoute' => 'vawcRead'])
                <div class="card module-workspace__form-card">
                        <div class="card-body">
                            <form action="{{ route('vawcCreate') }}" class="form-horizontal" id="addCitizen" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <div class="form-row">
                                                <h2 class="card-title font-weight-bold badge badge-secondary mb-2 ml-1">Source of Referal</h2>
                                            </div>
                                            <div class="form-row">
                                                <div class="col-md-1 margin-input">
                                                    <div class="form-check">
                                                        <input type="radio" class="form-check-input" name="source" value="Barangay">
                                                        <label class="form-check-label"> Barangay</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-1 margin-input">
                                                    <div class="form-check">
                                                        <input type="radio" class="form-check-input" name="source" value="CHO">
                                                        <label class="form-check-label"> CHO</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-1 margin-input">
                                                    <div class="form-check">
                                                        <input type="radio" class="form-check-input" name="source" value="NGO">
                                                        <label class="form-check-label"> NGO</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-1 margin-input">
                                                    <div class="form-check">
                                                        <input type="radio" class="form-check-input" name="source" value="PNP-WCPD">
                                                        <label class="form-check-label"> PNP-WCPD</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-1 margin-input">
                                                    <div class="form-check">
                                                        <input type="radio" class="form-check-input" name="source" value="MSWDO">
                                                        <label class="form-check-label"> MSWDO</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-1 margin-input">
                                                    <div class="form-check">
                                                        <input type="radio" class="form-check-input" name="source" value="Others">
                                                        <label class="form-check-label"> Others</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="form-row">
                                                <h2 class="card-title font-weight-bold badge badge-secondary mb-2 ml-1 mt-2">Identifying Information</h2>
                                            </div>
                                            <div class="form-row">
                                                <div class="col-md-2 margin-input">
                                                    <span class="font-weight-bold">Complete Name</span>
                                                    <input type="text" name="cname" class="form-control form-control-md text-capitalize" required>
                                                </div>
                                                <div class="col-md-2 margin-input">
                                                    <span class="font-weight-bold">Nickname</span>
                                                    <input type="text" name="nname" class="form-control form-control-md text-capitalize" required>
                                                </div>
                                                <div class="col-md-2 margin-input">
                                                    <span class="font-weight-bold">Date of Birth</span>
                                                    <input type="date" name="dob" id="d_birth" value="{{ old('dob') }}" class="form-control form-control-md" required>
                                                </div>
                                                <div class="col-md-1 margin-input">
                                                    <span class="font-weight-bold">Age</span>
                                                    <input type="text" name="age" id="age" class="form-control form-control-md text-capitalize" readonly required>
                                                </div>
                                                <div class="col-md-1 margin-input">
                                                    <span class="font-weight-bold">Sex</span>
                                                    <select type="text" name="gender" class="form-control form-control-md text-capitalize" required>
                                                        <option value="">-- Select --</option>
                                                        <option value="M">Male</option>
                                                        <option value="F">Female</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-2 margin-input">
                                                    <span class="font-weight-bold">Religion</span>
                                                    <input type="text" name="religion" class="form-control form-control-md text-capitalize" required>
                                                </div>
                                                <div class="col-md-2 margin-input">
                                                    <span class="font-weight-bold">Date of interview</span>
                                                    <input type="date" name="date_int" class="form-control form-control-md text-capitalize" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="form-row">
                                                <div class="col-md-2 margin-input">
                                                    <span class="font-weight-bold">Place of Birth</span>
                                                    <input type="text" name="pb" class="form-control form-control-md text-capitalize" required>
                                                </div>
                                                <div class="col-md-2 margin-input">
                                                    <span class="font-weight-bold">Present Address</span>
                                                    <input type="text" name="p_address" class="form-control form-control-md text-capitalize" required>
                                                </div>
                                                <div class="col-md-2 margin-input">
                                                    <span class="font-weight-bold">Home Address</span>
                                                    <input type="text" name="h_address"  class="form-control form-control-md text-capitalize" required>
                                                </div>
                                                <div class="col-md-2 margin-input">
                                                    <span class="font-weight-bold">Educational Attainment</span>
                                                    <input type="text" name="educ_attain" class="form-control form-control-md text-capitalize" required>
                                                </div>
                                                <div class="col-md-2 margin-input">
                                                    <span class="font-weight-bold">School</span>
                                                    <input type="text" name="school" class="form-control form-control-md text-capitalize" required>
                                                </div>
                                                <div class="col-md-2 margin-input">
                                                    <span class="font-weight-bold">Interviewer</span>
                                                    <input type="text" name="n_viewer" id="n_viewer" class="form-control form-control-md text-capitalize" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="form-row">
                                                <div class="col-md-4 margin-input">
                                                    <span class="font-weight-bold">Presenting Problem</span>
                                                    <textarea type="text" name="problem" class="form-control form-control-md" required></textarea>
                                                </div>
                                                <div class="col-md-4 margin-input">
                                                    <span class="font-weight-bold">Case Findings</span>
                                                    <textarea type="text" name="findings" class="form-control form-control-md" required></textarea>
                                                </div>
                                                <div class="col-md-4 margin-input">
                                                    <span class="font-weight-bold">Recommendation / Remarks</span>
                                                    <textarea type="text" name="remarks" class="form-control form-control-md" required></textarea>
                                                </div>
                                            </div>
                                        </div>
                 
                                        <hr class="mt-5">
                                        <div class="form-group">
                                            <div class="form-row d-flex align-items-center justify-content-between">
                                                <h2 class="card-title font-weight-bold badge badge-secondary mb-2 ml-1">Family household members</h2>
                                                <a class="btn btn-info btn-sm mb-2" onclick="addFamilyMember()"><i class="fas fa-user-plus"></i> Add Member</a>
                                            </div>                                             
                                            <div class="form-row margin-input">
                                                <div class="col-md-2">
                                                    <span class="font-weight-bold">Family Member</span>
                                                </div>
                                                <div class="col-md-2">
                                                    <span class="font-weight-bold">Re. to the Child</span>
                                                </div>
                                                <div class="col-md-1">
                                                    <span class="font-weight-bold">Age</span>
                                                </div>
                                                <div class="col-md-1">
                                                    <span class="font-weight-bold">Sex</span>
                                                </div>
                                                <div class="col-md-2">
                                                    <span class="font-weight-bold">Education</span>
                                                </div>
                                                <div class="col-md-1">
                                                    <span class="font-weight-bold">Occupation</span>
                                                </div>
                                                <div class="col-md-1">
                                                    <span class="font-weight-bold">Monthly Income</span>
                                                </div>
                                                <div class="col-md-2">
                                                    <span class="font-weight-bold">Pres. Address</span>
                                                </div>
                                            </div>    
                                        </div>

                                        <div class="form-group" id="fam-me-row">
                                            <div class="form-row margin-input">
                                                <div class="col-md-2">
                                                    <input type="text" name="mem_fname[]" class="form-control form-control-md text-capitalize" required>
                                                </div>
                                                <div class="col-md-2">
                                                    <select type="text" name="mem_relation[]" class="form-control form-control-md text-capitalize" required>
                                                        <option value="">Select Relation</option>
                                                        <option value="Husband">Husband</option>
                                                        <option value="Wife">Wife</option>
                                                        <option value="Son">Son</option>
                                                        <option value="Daughter">Daughter</option>
                                                        <option value="Father">Father</option>
                                                        <option value="Mother">Mother</option>
                                                        <option value="Brother">Brother</option>
                                                        <option value="Sister">Sister</option>
                                                        <option value="Grandfather">Grandfather</option>
                                                        <option value="Grandmother">Grandmother</option>
                                                        <option value="Grandson">Grandson</option>
                                                        <option value="Granddaughter">Granddaughter</option>
                                                        <option value="Aunt">Aunt</option>
                                                        <option value="Uncle">Uncle</option>
                                                        <option value="First Cousin">Cousin</option>
                                                        <option value="Father-in-law">Father-in-law</option>
                                                        <option value="Mother-in-law">Mother-in-law</option>
                                                        <option value="Brother-in-law">Brother-in-law</option>
                                                        <option value="Sister-in-law">Sister-in-law</option>
                                                        <option value="Son-in-law">Son-in-law</option>
                                                        <option value="Daughter-in-law">Daughter-in-law</option>
                                                        <option value="Niece">Niece</option>
                                                        <option value="Nephew">Nephew</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-1">
                                                    <input type="number" name="mem_age[]" class="form-control form-control-md text-capitalize" required>
                                                </div>
                                                <div class="col-md-1">
                                                    <select type="text" name="mem_gender[]" class="form-control form-control-md text-capitalize" required>
                                                        <option value="">Select Gender</option>
                                                        <option value="M">Male</option>
                                                        <option value="F">Female</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-2">
                                                    <select type="text" name="mem_educ[]" class="form-control form-control-md text-capitalize" required>
                                                        <option value="">Select Educational Attainment</option>
                                                        <option value="1">No Formal Education</option>
                                                        <option value="2">Elementary School Graduate</option>
                                                        <option value="3">High School Graduate</option>
                                                        <option value="4">Vocational or Technical School Graduate</option>
                                                        <option value="5">Associate's Degree Holder</option>
                                                        <option value="6">Bachelor's Degree Holder</option>
                                                        <option value="7">Master's Degree Holder</option>
                                                        <option value="8">Doctoral Degree Holder</option>
                                                        <option value="9">Professional Degree Holder</option>
                                                        <option value="10">High School Dropout</option>
                                                    </select>    
                                                </div>       
                                                <div class="col-md-1">
                                                    <input type="text" name="mem_occup[]" class="form-control form-control-md text-capitalize" required>
                                                </div>                                  
                                                <div class="col-md-1">
                                                    <input type="number" name="mem_monthly[]" class="form-control form-control-md text-capitalize" required>
                                                </div>
                                                <div class="col-md-2">
                                                    <input type="text" name="mem_address[]" class="form-control form-control-md text-capitalize">
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

@push('scripts')
@include('dafac.script')
@endpush

@endsection
