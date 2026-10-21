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
                @include('partials.workspace-header', ['module' => 'Solo parents', 'title' => 'Add solo parent', 'description' => 'Complete the personal and household details below.', 'backRoute' => 'soloparentRead'])
                <div class="card module-workspace__form-card">
                        <div class="card-body">
                            <form action="{{ route('soloparentCreate') }}" class="form-horizontal" id="addCitizen" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <div class="form-row">
                                                <h2 class="card-title font-weight-bold badge badge-secondary mb-2 ml-1">Citizen Information</h2>
                                            </div>
                                            <div class="form-row">
                                                <div class="col-md-3 margin-input">
                                                    <span class="font-weight-bold">Complete Name</span>
                                                    <input type="text" name="cname" class="form-control form-control-sm text-capitalize" required>
                                                </div>
                                                <div class="col-md-3 margin-input">
                                                    <span class="font-weight-bold">Gender</span>
                                                    <select name="gender" class="form-control form-control-sm" required>
                                                        <option value="Male">Male</option>
                                                        <option value="Female">Female</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-3 margin-input">
                                                    <span class="font-weight-bold">Date of Birth</span>
                                                    <input type="date" name="dob" id="d_birth" value="{{ old('dob') }}" class="form-control form-control-sm" required>
                                                </div>
                                                <div class="col-md-3 margin-input">
                                                    <span class="font-weight-bold">Age</span>
                                                    <input type="text" name="age" id="age" class="form-control form-control-sm text-capitalize" readonly required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="form-row">
                                                <div class="col-md-3 margin-input">
                                                    <span class="font-weight-bold">Address</span>
                                                    <input type="text" name="address" class="form-control form-control-sm text-capitalize" required>
                                                </div>
                                                <div class="col-md-3 margin-input">
                                                    <span class="font-weight-bold">Highest Education</span>
                                                    <input type="text" name="h_education" class="form-control form-control-sm text-capitalize" required>
                                                </div>
                                                <div class="col-md-3 margin-input">
                                                    <span class="font-weight-bold">Occupation</span>
                                                    <input type="text" name="occupation" class="form-control form-control-sm text-capitalize" required>
                                                </div>
                                                <div class="col-md-3 margin-input">
                                                    <span class="font-weight-bold">Monthly Income</span>
                                                    <input type="number" name="monthly_income" class="form-control form-control-sm text-capitalize" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="form-row">
                                                <div class="col-md-6 margin-input">
                                                    <span class="font-weight-bold">Classification/Circumstance of being a Solo parent</span>
                                                    <textarea type="text" name="class_circum" class="form-control form-control-md" required></textarea>
                                                </div>
                                                <div class="col-md-6 margin-input">
                                                    <span class="font-weight-bold">Needs/Problem of Solo parent</span>
                                                    <textarea type="text" name="needs_prob" class="form-control form-control-md" required></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <hr class="mt-5">
                                        <div class="form-group">
                                            <div class="form-row d-flex align-items-center justify-content-between">
                                                <h2 class="card-title font-weight-bold badge badge-secondary mb-2 ml-1">Family Members</h2>
                                                <a class="btn btn-info btn-sm mb-2" onclick="addFamilyMember()"><i class="fas fa-user-plus"></i> Add Member</a>
                                            </div>
                                            <div class="form-row margin-input">
                                                <div class="col-md-2">
                                                    <span class="font-weight-bold">Member Full Name</span>
                                                </div>
                                                <div class="col-md-2">
                                                    <span class="font-weight-bold">Relation to Member</span>
                                                </div>
                                                <div class="col-md-2">
                                                    <span class="font-weight-bold">Age</span>
                                                </div>
                                                <div class="col-md-2">
                                                    <span class="font-weight-bold">Status</span>
                                                </div>
                                                <div class="col-md-2">
                                                    <span class="font-weight-bold">Education</span>
                                                </div>
                                                <div class="col-md-2">
                                                    <span class="font-weight-bold">Birth Date</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group" id="fam-me-row">
                                            <div class="form-row margin-input">
                                                <div class="col-md-2">
                                                    <input type="text" name="mem_fname[]" class="form-control form-control-sm text-capitalize" required>
                                                </div>
                                                <div class="col-md-2">
                                                    <select type="text" name="mem_relation[]" class="form-control form-control-sm text-capitalize" required>
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
                                                <div class="col-md-2">
                                                    <input type="number" name="mem_age[]" class="form-control form-control-sm" required>
                                                </div>
                                                <div class="col-md-2">
                                                    <select type="text" name="mem_status[]" class="form-control form-control-sm mt2" data-update="m_status" required>
                                                        <option value="">Select Status</option>
                                                        <option>Single</option>
                                                        <option>Married</option>
                                                        <option>Seperated</option>
                                                        <option>Widow</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-2">
                                                    <input type="text" name="mem_educ[]" class="form-control form-control-sm text-capitalize" required>
                                                </div>
                                                <div class="col-md-2">
                                                    <input type="date" name="mem_bdate[]" class="form-control form-control-sm" required>
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
