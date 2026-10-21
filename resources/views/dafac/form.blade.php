@extends('layouts.master')

@section('body')
@php
    $extensions = ['Jr' => 'Jr', 'Sr' => 'Sr', 'II' => 'II', 'III' => 'III', 'IV' => 'IV'];
    $civilStatuses = ['Single' => 'Single', 'Married' => 'Married', 'Seperated' => 'Separated', 'Widow' => 'Widow'];
    $religions = ['Roman Catholic', 'Protestant', 'Islam', 'Iglesia ni Cristo', 'Aglipayan', 'Adventist', 'Mormons'];
    $identityCards = ['UMID', 'Postal ID', 'PRC', 'National ID', 'GSIS ID', 'OSCA', 'DFA', "Voter's ID", "Driver's License"];
    $relations = ['Husband', 'Wife', 'Son', 'Daughter', 'Father', 'Mother', 'Brother', 'Sister', 'Grandfather', 'Grandmother', 'Grandson', 'Granddaughter', 'Aunt', 'Uncle', 'First Cousin', 'Father-in-law', 'Mother-in-law', 'Brother-in-law', 'Sister-in-law', 'Son-in-law', 'Daughter-in-law', 'Niece', 'Nephew'];
    $educations = [
        '1' => 'No formal education', '2' => 'Elementary school graduate', '3' => 'High school graduate',
        '4' => 'Vocational or technical school graduate', '5' => "Associate's degree holder",
        '6' => "Bachelor's degree holder", '7' => "Master's degree holder",
        '8' => 'Doctoral degree holder', '9' => 'Professional degree holder', '10' => 'High school dropout',
    ];
    $memberCount = max(1, count(old('mem_fname', [])));
@endphp
<div class="content dafac-page">
    <div class="container-fluid">
        <div class="row dafac-shell">
            <div class="col-12 dafac-workspace">
                <div class="dafac-breadcrumb-row">
                    <nav aria-label="Breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('dafacRead') }}">FACED records</a></li>
                            <li class="breadcrumb-item" aria-current="page">Add family</li>
                        </ol>
                    </nav>
                    <div class="dafac-header-actions">
                        <a href="{{ route('assRead') }}" class="dafac-header-link"><i class="fas fa-hand-holding-heart" aria-hidden="true"></i> Assistance</a>
                        <a href="{{ route('dafacRead') }}" class="dafac-back-icon" aria-label="Back to FACED records" title="Back to records">
                            <i class="fas fa-arrow-left" aria-hidden="true"></i>
                        </a>
                    </div>
                </div>

                <div class="dafac-page-head">
                    <div>
                        <p class="dafac-eyebrow">FACED workspace · New family assistance record</p>
                        <h1>Add a family</h1>
                        <p class="dafac-page-head__copy">Complete each section below. Fields marked <span aria-hidden="true">*</span> are required.</p>
                    </div>
                </div>

                @if ($errors->any())
                    <div class="alert alert-danger dafac-error-summary" role="alert">
                        <strong>Check the details before saving.</strong>
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('dafacCreate') }}" method="POST" id="addCitizen" class="dafac-entry-form">
                    @csrf
                    <input type="hidden" name="count" value="{{ $count }}">

                    <section class="dafac-form-section" id="family-location" aria-labelledby="location-title">
                        <div class="dafac-form-section__heading">
                            <span class="dafac-step" aria-hidden="true">01</span>
                            <div>
                                <h2 id="location-title">Location of affected family</h2>
                                <p>Choose the location and enter the evacuation site for this family.</p>
                            </div>
                        </div>
                        <div class="dafac-field-grid">
                            <label class="dafac-field">
                                <span>Region</span>
                                <select id="region" name="add_region" class="form-control">
                                    <option value="">Select region</option>
                                    @foreach ($regions as $region)
                                        <option value="{{ $region->region_id }}" @selected(old('add_region', '07') == $region->region_id)>{{ $region->name }}</option>
                                    @endforeach
                                </select>
                            </label>
                            <label class="dafac-field">
                                <span>Province</span>
                                <select id="province" name="add_prov" class="form-control">
                                    <option value="">Select province</option>
                                    @foreach ($selectedProvinces as $province)
                                        <option value="{{ $province->province_id }}" @selected(old('add_prov', '0746') == $province->province_id)>{{ $province->name }}</option>
                                    @endforeach
                                </select>
                            </label>
                            <label class="dafac-field">
                                <span>City / Municipality</span>
                                <select id="city" name="add_city" class="form-control">
                                    <option value="">Select city or municipality</option>
                                    @foreach ($selectedCities as $city)
                                        <option value="{{ $city->city_id }}" @selected(old('add_city', '074614') == $city->city_id)>{{ $city->name }}</option>
                                    @endforeach
                                </select>
                            </label>
                            <label class="dafac-field">
                                <span>Barangay <span class="dafac-required">*</span></span>
                                <select id="barangay" name="add_brgy" class="form-control" onchange="genSerial(this.value, '{{ $count }}')" required>
                                    <option value="">Select barangay</option>
                                    @foreach ($selectedBarangays as $brgy)
                                        <option value="{{ $brgy->id }}" @selected(old('add_brgy') == $brgy->id)>{{ $brgy->name ?? $brgy->brgy_name }}</option>
                                    @endforeach
                                </select>
                            </label>
                            <label class="dafac-field">
                                <span>District <span class="dafac-required">*</span></span>
                                <input type="text" name="district" class="form-control" value="{{ old('district') }}" autocomplete="address-level3" required>
                            </label>
                            <label class="dafac-field dafac-span-2">
                                <span>Evacuation center / site <span class="dafac-required">*</span></span>
                                <input type="text" name="brgy_evac_site" class="form-control" value="{{ old('brgy_evac_site') }}" required>
                            </label>
                            <label class="dafac-field">
                                <span>Serial number</span>
                                <input type="text" name="serial" id="serial" class="form-control" value="{{ old('serial') }}" readonly aria-describedby="serial-help">
                                <small id="serial-help">Generated after choosing a barangay.</small>
                            </label>
                        </div>
                    </section>

                    <section class="dafac-form-section" id="family-head" aria-labelledby="head-title">
                        <div class="dafac-form-section__heading">
                            <span class="dafac-step" aria-hidden="true">02</span>
                            <div>
                                <h2 id="head-title">Head of the family</h2>
                                <p>Enter the main contact's personal details.</p>
                            </div>
                        </div>
                        <div class="dafac-field-grid">
                            <label class="dafac-field"><span>Last name <span class="dafac-required">*</span></span><input type="text" name="surname" class="form-control" value="{{ old('surname') }}" autocomplete="family-name" required></label>
                            <label class="dafac-field"><span>First name <span class="dafac-required">*</span></span><input type="text" name="fname" class="form-control" value="{{ old('fname') }}" autocomplete="given-name" required></label>
                            <label class="dafac-field"><span>Middle name <span class="dafac-required">*</span></span><input type="text" name="mname" class="form-control" value="{{ old('mname') }}" required></label>
                            <label class="dafac-field"><span>Name extension</span><select name="ext" class="form-control"><option value="">None</option>@foreach ($extensions as $value => $label)<option value="{{ $value }}" @selected(old('ext') == $value)>{{ $label }}</option>@endforeach</select></label>

                            <label class="dafac-field"><span>Date of birth <span class="dafac-required">*</span></span><input type="date" name="d_birth" id="d_birth" class="form-control" value="{{ old('d_birth') }}" required></label>
                            <label class="dafac-field"><span>Age <span class="dafac-required">*</span></span><input type="number" name="age" id="age" class="form-control" value="{{ old('age') }}" readonly required aria-describedby="head-age-help"><small id="head-age-help">Calculated from date of birth.</small></label>
                            <label class="dafac-field"><span>Birthplace <span class="dafac-required">*</span></span><input type="text" name="b_place" class="form-control" value="{{ old('b_place') }}" required></label>
                            <label class="dafac-field"><span>Sex <span class="dafac-required">*</span></span><select name="gender" class="form-control" required><option value="">Select sex</option><option value="M" @selected(old('gender') == 'M')>Male</option><option value="F" @selected(old('gender') == 'F')>Female</option></select></label>

                            <label class="dafac-field"><span>Civil status <span class="dafac-required">*</span></span><select name="civil_status" class="form-control" required><option value="">Select status</option>@foreach ($civilStatuses as $value => $label)<option value="{{ $value }}" @selected(old('civil_status') == $value)>{{ $label }}</option>@endforeach</select></label>
                            <label class="dafac-field"><span>Mother's maiden name <span class="dafac-required">*</span></span><input type="text" name="m_maid_name" class="form-control" value="{{ old('m_maid_name') }}" required></label>
                            <label class="dafac-field"><span>Religion <span class="dafac-required">*</span></span><select name="religion" class="form-control" required><option value="">Select religion</option>@foreach ($religions as $religion)<option value="{{ $religion }}" @selected(old('religion') == $religion)>{{ $religion }}</option>@endforeach</select></label>
                            <label class="dafac-field"><span>Occupation <span class="dafac-required">*</span></span><input type="text" name="occupation" class="form-control" value="{{ old('occupation') }}" required></label>

                            <label class="dafac-field"><span>Monthly net income <span class="dafac-required">*</span></span><input type="text" name="mincome" class="form-control" value="{{ old('mincome') }}" inputmode="decimal" placeholder="0.00" required></label>
                            <label class="dafac-field"><span>ID card presented <span class="dafac-required">*</span></span><select name="id_present" class="form-control" required><option value="">Select ID type</option>@foreach ($identityCards as $card)<option value="{{ $card }}" @selected(old('id_present') == $card)>{{ $card }}</option>@endforeach</select></label>
                            <label class="dafac-field dafac-span-2"><span>ID card number <span class="dafac-required">*</span></span><input type="text" name="id_cardnum" class="form-control" value="{{ old('id_cardnum') }}" required></label>

                            <label class="dafac-field"><span>Primary contact number</span><input type="tel" name="contact_1" class="form-control" value="{{ old('contact_1') }}" inputmode="tel" autocomplete="tel"></label>
                            <label class="dafac-field"><span>Other contact number</span><input type="tel" name="contact_2" class="form-control" value="{{ old('contact_2') }}" inputmode="tel"></label>
                            <label class="dafac-field dafac-span-2"><span>Permanent address <span class="dafac-required">*</span></span><input type="text" name="per_address" class="form-control" value="{{ old('per_address') }}" autocomplete="street-address" required></label>
                        </div>
                    </section>

                    <section class="dafac-form-section" id="family-members" aria-labelledby="members-title">
                        <div class="dafac-form-section__heading dafac-form-section__heading--action">
                            <span class="dafac-step" aria-hidden="true">03</span>
                            <div>
                                <h2 id="members-title">Family members</h2>
                                <p>Add the other people in this family. Leave the blank row empty if there are none.</p>
                            </div>
                            <button type="button" class="btn btn-outline-primary dafac-add-member" id="addFamilyMemberButton"><i class="fas fa-plus" aria-hidden="true"></i> Add member</button>
                        </div>
                        <div id="dafac-members">
                            @for ($i = 0; $i < $memberCount; $i++)
                                <div class="dafac-member">
                                    <div class="dafac-member__head"><h3>Member <span class="dafac-member-number">{{ $i + 1 }}</span></h3><button type="button" class="btn btn-link dafac-remove-member"><i class="fas fa-xmark" aria-hidden="true"></i> Remove</button></div>
                                    <div class="dafac-field-grid">
                                        <label class="dafac-field dafac-span-2"><span>Full name</span><input type="text" name="mem_fname[]" class="form-control" value="{{ old('mem_fname.' . $i) }}"></label>
                                        <label class="dafac-field"><span>Relationship to family head</span><select name="mem_relation[]" class="form-control"><option value="">Select relationship</option>@foreach ($relations as $relation)<option value="{{ $relation }}" @selected(old('mem_relation.' . $i) == $relation)>{{ $relation === 'First Cousin' ? 'Cousin' : $relation }}</option>@endforeach</select></label>
                                        <label class="dafac-field"><span>Date of birth</span><input type="date" name="mem_bdate[]" class="form-control" value="{{ old('mem_bdate.' . $i) }}"></label>
                                        <label class="dafac-field"><span>Age</span><input type="number" min="0" max="150" name="mem_age[]" class="form-control" value="{{ old('mem_age.' . $i) }}"></label>
                                        <label class="dafac-field"><span>Sex</span><select name="mem_gender[]" class="form-control"><option value="">Select sex</option><option value="M" @selected(old('mem_gender.' . $i) == 'M')>Male</option><option value="F" @selected(old('mem_gender.' . $i) == 'F')>Female</option></select></label>
                                        <label class="dafac-field"><span>Education</span><select name="mem_educ[]" class="form-control"><option value="">Select education</option>@foreach ($educations as $value => $label)<option value="{{ $value }}" @selected(old('mem_educ.' . $i) == $value)>{{ $label }}</option>@endforeach</select></label>
                                        <label class="dafac-field"><span>Occupational skills</span><input type="text" name="mem_occup[]" class="form-control" value="{{ old('mem_occup.' . $i) }}"></label>
                                        <label class="dafac-field dafac-span-4"><span>Remarks</span><input type="text" name="mem_remarks[]" class="form-control" value="{{ old('mem_remarks.' . $i) }}"></label>
                                    </div>
                                </div>
                            @endfor
                        </div>
                    </section>

                    <section class="dafac-form-section" id="household-details" aria-labelledby="household-title">
                        <div class="dafac-form-section__heading">
                            <span class="dafac-step" aria-hidden="true">04</span>
                            <div>
                                <h2 id="household-title">Household details</h2>
                                <p>Record special circumstances and housing information.</p>
                            </div>
                        </div>
                        <div class="dafac-household-grid">
                            <fieldset class="dafac-choice-group">
                                <legend>Family circumstances</legend>
                                <label class="dafac-check"><input type="checkbox" name="ps_benef" value="1" @checked(old('ps_benef'))><span>4Ps beneficiary</span></label>
                                <label class="dafac-check"><input type="checkbox" name="ip" value="1" @checked(old('ip'))><span>Indigenous people</span></label>
                                <label class="dafac-field dafac-ethnicity"><span>Ethnicity, if applicable</span><input type="text" name="type_ethnicity" class="form-control" value="{{ old('type_ethnicity') }}"></label>
                            </fieldset>
                            <fieldset class="dafac-choice-group">
                                <legend>People needing support</legend>
                                <div class="dafac-count-grid">
                                    <label class="dafac-field"><span>Older persons</span><input type="number" min="0" name="checklist1" class="form-control" value="{{ old('checklist1') }}" placeholder="0"></label>
                                    <label class="dafac-field"><span>Pregnant women</span><input type="number" min="0" name="checklist2" class="form-control" value="{{ old('checklist2') }}" placeholder="0"></label>
                                    <label class="dafac-field"><span>Lactating women</span><input type="number" min="0" name="checklist3" class="form-control" value="{{ old('checklist3') }}" placeholder="0"></label>
                                    <label class="dafac-field"><span>Persons with disabilities due to medical conditions</span><input type="number" min="0" name="checklist4" class="form-control" value="{{ old('checklist4') }}" placeholder="0"></label>
                                </div>
                            </fieldset>
                            <fieldset class="dafac-choice-group">
                                <legend>House ownership</legend>
                                <label class="dafac-check"><input type="radio" name="checklist5" value="1" @checked(old('checklist5') == '1')><span>Owner</span></label>
                                <label class="dafac-check"><input type="radio" name="checklist5" value="2" @checked(old('checklist5') == '2')><span>Renter</span></label>
                                <label class="dafac-check"><input type="radio" name="checklist5" value="3" @checked(old('checklist5') == '3')><span>Sharer</span></label>
                            </fieldset>
                            <fieldset class="dafac-choice-group">
                                <legend>Shelter damage</legend>
                                <label class="dafac-check"><input type="radio" name="checklist6" value="1" @checked(old('checklist6') == '1')><span>Partially damaged</span></label>
                                <label class="dafac-check"><input type="radio" name="checklist6" value="2" @checked(old('checklist6') == '2')><span>Totally damaged</span></label>
                            </fieldset>
                        </div>
                    </section>

                    <div class="dafac-form-actions">
                        <p>Review the details before saving this family record.</p>
                        <div>
                            <a href="{{ route('dafacRead') }}" class="btn btn-outline-secondary">Cancel</a>
                            <button type="submit" class="btn btn-success" id="dafacSaveButton"><i class="fas fa-check" aria-hidden="true"></i> Save family record</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('addCitizen');
    const members = document.getElementById('dafac-members');
    const addButton = document.getElementById('addFamilyMemberButton');
    const saveButton = document.getElementById('dafacSaveButton');
    if (!form || !members || !addButton) return;

    function renumberMembers() {
        members.querySelectorAll('.dafac-member-number').forEach((number, index) => {
            number.textContent = index + 1;
        });
    }

    addButton.addEventListener('click', function () {
        const first = members.querySelector('.dafac-member');
        const clone = first.cloneNode(true);
        clone.querySelectorAll('input, select').forEach(field => {
            if (field.type === 'checkbox' || field.type === 'radio') field.checked = false;
            else field.value = '';
        });
        members.appendChild(clone);
        renumberMembers();
        clone.querySelector('input[name="mem_fname[]"]').focus();
    });

    members.addEventListener('click', function (event) {
        const button = event.target.closest('.dafac-remove-member');
        if (!button) return;
        const card = button.closest('.dafac-member');
        if (members.querySelectorAll('.dafac-member').length === 1) {
            card.querySelectorAll('input, select').forEach(field => field.value = '');
        } else {
            card.remove();
            renumberMembers();
        }
    });

    form.addEventListener('submit', function () {
        if (form.checkValidity() && saveButton) {
            saveButton.disabled = true;
            saveButton.innerHTML = '<i class="fas fa-spinner fa-spin" aria-hidden="true"></i> Saving…';
        }
    });
});
</script>
@endpush
