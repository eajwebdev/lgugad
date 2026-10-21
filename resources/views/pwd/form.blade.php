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
                @include('partials.workspace-header', ['module' => 'PWD', 'title' => 'Add PWD record', 'description' => 'Complete the application details below.', 'backRoute' => 'pwdRead'])
                <div class="card module-workspace__form-card">
                        <div class="card-body">
                            <form action="{{ route('pwdCreate') }}" class="form-horizontal" id="addCitizen" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-10">
                                        <div class="form-group">
                                            <div class="form-row">
                                                <h2 class="card-title font-weight-bold badge badge-secondary mb-2 ml-1">Personal Information</h2>
                                            </div>
                                            <div class="form-row">
                                                <div class="col-md-3 margin-input">
                                                    <span class="font-weight-bold">Applicant Type</span>
                                                    <select type="text" name="applicant" class="form-control form-control-sm form-control-md text-capitalize" required>
                                                        <option value="">-- Select --</option>
                                                        <option>New Applicant</option>
                                                        <option>Renewal</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-6 margin-input">
                                                    <span class="font-weight-bold">Person with disability number (RR-PPMM-BBB-NNNNNNN)</span>
                                                    <input type="text" name="person_with" class="form-control form-control-sm text-capitalize" required>
                                                </div>
                                                <div class="col-md-3 margin-input">
                                                    <span class="font-weight-bold">Date Applied</span>
                                                    <input type="date" name="date_app" class="form-control form-control-sm text-capitalize" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="form-row">
                                                <div class="col-md-2 margin-input">
                                                    <span class="font-weight-bold">Last Name</span>
                                                    <input type="text" name="lname" class="form-control form-control-sm text-capitalize" required>
                                                </div>
                                                <div class="col-md-2 margin-input">
                                                    <span class="font-weight-bold">First name</span>
                                                    <input type="text" name="fname" class="form-control form-control-sm text-capitalize" required>
                                                </div>
                                                <div class="col-md-2 margin-input">
                                                    <span class="font-weight-bold">Middle Name</span>
                                                    <input type="text" name="mname" class="form-control form-control-sm text-capitalize" required>
                                                </div>
                                                <div class="col-md-2 margin-input">
                                                    <span class="font-weight-bold">Suffix</span>
                                                    <input type="text" name="suffix" class="form-control form-control-sm text-capitalize" required>
                                                </div>
                                                <div class="col-md-2 margin-input">
                                                    <span class="font-weight-bold">Date of birth</span>
                                                    <input type="date" name="dob" class="form-control form-control-sm text-capitalize" required>
                                                </div>
                                                <div class="col-md-2 margin-input">
                                                    <span class="font-weight-bold">Sex</span>
                                                    <select type="text" name="gender" class="form-control form-control-sm text-capitalize" required>
                                                        <option value="">-- Select --</option>
                                                        <option value="M">Male</option>
                                                        <option value="F">Female</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="form-row">
                                                <div class="col-md-2 margin-input">
                                                    <span class="font-weight-bold">Civil Status</span>
                                                    <select type="text" name="c_status" class="form-control form-control-sm text-capitalize" required>
                                                        <option value="">-- Select --</option>
                                                        <option>Single</option>
                                                        <option>Separated</option>
                                                        <option>Cohabitation (live-in)</option>
                                                        <option>Married</option>
                                                        <option>Widow/er</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-4 margin-input">
                                                    <span class="font-weight-bold">Residence Address</span>
                                                    <input type="text" name="r_address" class="form-control form-control-sm text-capitalize" required>
                                                </div>
                                                <div class="col-md-4 margin-input">
                                                    <span class="font-weight-bold">House No. and Street</span>
                                                    <input type="text" name="street" class="form-control form-control-sm text-capitalize" required>
                                                </div>
                                                <div class="col-md-2 margin-input">
                                                    <span class="font-weight-bold">Barangay</span>
                                                    <select type="text" name="brangay" class="form-control form-control-sm text-capitalize"  required>
                                                        <option value="">Select Barangay</option>
                                                        @foreach ($barangays as $brgy)
                                                            <option value="{{ $brgy->id }}">{{ $brgy->brgy_name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="form-row">
                                                <div class="col-md-2 margin-input">
                                                    <span class="font-weight-bold">Municipality</span>
                                                    <input type="text" name="municipality" class="form-control form-control-sm text-capitalize" required>
                                                </div>
                                                <div class="col-md-2 margin-input">
                                                    <span class="font-weight-bold">Province</span>
                                                    <input type="text" name="province" class="form-control form-control-sm text-capitalize" required>
                                                </div>
                                                <div class="col-md-2 margin-input">
                                                    <span class="font-weight-bold">Region</span>
                                                    <input type="text" name="region" class="form-control form-control-sm text-capitalize" required>
                                                </div>
                                                <div class="col-md-2 margin-input">
                                                    <span class="font-weight-bold">Landline No.</span>
                                                    <input type="text" name="l_no" class="form-control form-control-sm text-capitalize" required>
                                                </div>
                                                <div class="col-md-2 margin-input">
                                                    <span class="font-weight-bold">Mobile No.</span>
                                                    <input type="number" name="m_no" class="form-control form-control-sm text-capitalize" required>
                                                </div>
                                                <div class="col-md-2 margin-input">
                                                    <span class="font-weight-bold">Email</span>
                                                    <input type="email" name="email" class="form-control form-control-sm text-capitalize">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <div class="form-row">
                                                <div class="col-md-12 margin-input mb-1">
                                                    <span class="font-weight-bold">TITLE OF DISABILITY</span>
                                                </div>
                                                <div class="col-md-12 margin-input">
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input" name="type_dis[]" value="1">
                                                        <label class="form-check-label"> Deaf or Hard of Hearing</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-12 margin-input mt-2">
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input" name="type_dis[]" value="2">
                                                        <label class="form-check-label"> Intellectual Disability</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-12 margin-input mt-2">
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input" name="type_dis[]" value="3">
                                                        <label class="form-check-label"> Learning Disability</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-12 margin-input mt-2">
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input" name="type_dis[]" value="4">
                                                        <label class="form-check-label"> Mental Disability</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-12 margin-input mt-2">
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input" name="type_dis[]" value="5">
                                                        <label class="form-check-label"> Physical Disability (Orthopedic)</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-12 margin-input mt-2">
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input" name="type_dis[]" value="6">
                                                        <label class="form-check-label"> Psychosocial Disability</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-12 margin-input mt-2">
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input" name="type_dis[]" value="7">
                                                        <label class="form-check-label"> Speech and Language Impairment</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-12 margin-input mt-2">
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input" name="type_dis[]" value="8">
                                                        <label class="form-check-label"> Visual Disability</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-12 margin-input mt-2">
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input" name="type_dis[]" value="9">
                                                        <label class="form-check-label"> Cancer (RA11215)</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-12 margin-input mt-2">
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input" name="type_dis[]" value="10">
                                                        <label class="form-check-label"> Rare Disease (RA10747)</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="form-row">
                                                <div class="col-md-12 margin-input mb-1">
                                                    <span class="font-weight-bold">CAUSE OF DISABILITY</span>
                                                </div>
                                                <div class="col-md-6 margin-input">
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input" name="cause_dis[]" value="1">
                                                        <label class="form-check-label"> Autism</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 margin-input">
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input" name="cause_dis[]" value="5">
                                                        <label class="form-check-label"> Chronic illness</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 margin-input mt-2">
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input" name="cause_dis[]" value="2">
                                                        <label class="form-check-label"> ADHD</label>
                                                    </div>
                                                </div>               
                                                <div class="col-md-6 margin-input mt-2">
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input" name="cause_dis[]" value="6">
                                                        <label class="form-check-label"> Cerebral Paisy</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 margin-input mt-2">
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input" name="cause_dis[]" value="3">
                                                        <label class="form-check-label"> Cerebral paisy</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 margin-input mt-2">
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input" name="cause_dis[]" value="7">
                                                        <label class="form-check-label"> Injury</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 margin-input mt-2">
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input" name="cause_dis[]" value="4">
                                                        <label class="form-check-label"> Down Syndrome</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="form-row">
                                                <div class="col-md-12 margin-input mb-1">
                                                    <span class="font-weight-bold">Educational Attainment</span>
                                                </div>
                                                <div class="col-md-6 margin-input">
                                                    <div class="form-check">
                                                        <input type="radio" class="form-check-input" name="educ_attain" value="1" required>
                                                        <label class="form-check-label"> Autism</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 margin-input">
                                                    <div class="form-check">
                                                        <input type="radio" class="form-check-input" name="educ_attain" value="2" required>
                                                        <label class="form-check-label"> Chronic illness</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 margin-input mt-2">
                                                    <div class="form-check">
                                                        <input type="radio" class="form-check-input" name="educ_attain" value="3" required>
                                                        <label class="form-check-label"> ADHD</label>
                                                    </div>
                                                </div>               
                                                <div class="col-md-6 margin-input mt-2">
                                                    <div class="form-check">
                                                        <input type="radio" class="form-check-input" name="educ_attain" value="4" required>
                                                        <label class="form-check-label"> Cerebral Paisy</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 margin-input mt-2">
                                                    <div class="form-check">
                                                        <input type="radio" class="form-check-input" name="educ_attain" value="5" required>
                                                        <label class="form-check-label"> Cerebral paisy</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 margin-input mt-2">
                                                    <div class="form-check">
                                                        <input type="radio" class="form-check-input" name="educ_attain" value="6" required>
                                                        <label class="form-check-label"> Injury</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 margin-input mt-2">
                                                    <div class="form-check">
                                                        <input type="radio" class="form-check-input" name="educ_attain" value="7" required>
                                                        <label class="form-check-label"> Down Syndrome</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 margin-input mt-2">
                                                    <div class="form-check">
                                                        <input type="radio" class="form-check-input" name="educ_attain" value="8" required>
                                                        <label class="form-check-label"> Down Syndrome</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-12">
                                        <div class="form-group" style="margin-left: -8px;">
                                            <div class="form-row">
                                                <div class="col-md-12 mt-2">
                                                    <button type="submit" name="btn-submit" class="btn btn-success ml-2">
                                                        <i class="fas fa-save"></i> Save
                                                    </button>
                                                </div>
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
