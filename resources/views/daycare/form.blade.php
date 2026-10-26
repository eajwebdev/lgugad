@extends('layouts.master')

@php
    $isEdit = isset($id);
    $value = fn ($field) => old($field, $worker->{$field});
    $dateValue = fn ($field) => old($field, $worker->{$field}?->format('Y-m-d'));
    $listValue = fn ($field) => array_map('strval', (array) old($field, $worker->{$field} ?? []));
    $trainings = old('trainings', $worker->trainings ?? []);
    $courses = old('other_courses', $worker->other_courses ?? []);
@endphp

{{-- Radio or checkbox group. $options is a list of values or a value => label map. --}}
@php
    $choices = function (string $name, array $options, $selected, bool $multiple = false) {
        $isList = array_is_list($options);
        $html = '';
        foreach ($options as $key => $label) {
            $optionValue = (string) ($isList ? $label : $key);
            $inputId = $name . '_' . md5($optionValue);
            $checked = $multiple ? in_array($optionValue, $selected, true) : (string) $selected === $optionValue;
            $html .= '<div class="custom-control custom-' . ($multiple ? 'checkbox' : 'radio') . ' custom-control-inline mb-1">'
                . '<input type="' . ($multiple ? 'checkbox' : 'radio') . '" class="custom-control-input" id="' . e($inputId) . '" name="' . e($name) . ($multiple ? '[]' : '') . '" value="' . e($optionValue) . '"' . ($checked ? ' checked' : '') . '>'
                . '<label class="custom-control-label font-weight-normal" for="' . e($inputId) . '">' . e($label) . '</label></div>';
        }

        return $html;
    };
@endphp

@section('body')
<div class="content module-workspace">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 module-workspace__main">
                @include('partials.workspace-header', [
                    'module' => 'Day care workers',
                    'title' => $isEdit ? 'Edit worker profile' : 'Add worker profile',
                    'description' => 'ECCD Form 6 – Child Development Worker Profile. Fields follow the sections of the printed form.',
                    'backRoute' => 'daycareRead',
                ])
                <div class="card module-workspace__form-card">
                    <div class="card-body">
                        <form action="{{ $isEdit ? route('daycareUpdate', ['id' => $id]) : route('daycareCreate') }}" method="POST" id="daycareForm">
                            @csrf

                            {{-- I. Personal information --}}
                            <h2 class="card-title font-weight-bold badge badge-secondary mb-3">I. Child Development Worker Personal Information</h2>
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label for="last_name">Last name <span class="text-danger">*</span></label>
                                    <input type="text" name="last_name" id="last_name" value="{{ $value('last_name') }}" class="form-control form-control-sm text-capitalize" required>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="first_name">First name <span class="text-danger">*</span></label>
                                    <input type="text" name="first_name" id="first_name" value="{{ $value('first_name') }}" class="form-control form-control-sm text-capitalize" required>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="middle_name">Middle name</label>
                                    <input type="text" name="middle_name" id="middle_name" value="{{ $value('middle_name') }}" class="form-control form-control-sm text-capitalize">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-3">
                                    <label for="birthday">Birthday <span class="text-danger">*</span></label>
                                    <input type="date" name="birthday" id="birthday" value="{{ $dateValue('birthday') }}" max="{{ now()->subDay()->format('Y-m-d') }}" class="form-control form-control-sm" required>
                                </div>
                                <div class="form-group col-md-3">
                                    <label>Sex <span class="text-danger">*</span></label>
                                    <div>{!! $choices('sex', \App\Models\DayCareWorker::SEXES, $value('sex')) !!}</div>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="religion">Religion</label>
                                    <input type="text" name="religion" id="religion" value="{{ $value('religion') }}" class="form-control form-control-sm">
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="ethnicity">Ethnicity</label>
                                    <input type="text" name="ethnicity" id="ethnicity" value="{{ $value('ethnicity') }}" class="form-control form-control-sm">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-9">
                                    <label>Civil status <span class="text-danger">*</span></label>
                                    <div>{!! $choices('civil_status', \App\Models\DayCareWorker::CIVIL_STATUSES, $value('civil_status')) !!}</div>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="no_children">No. of children</label>
                                    <input type="number" min="0" name="no_children" id="no_children" value="{{ $value('no_children') }}" class="form-control form-control-sm">
                                </div>
                            </div>

                            <h3 class="h6 font-weight-bold mt-2">Address</h3>
                            <div class="form-row">
                                <div class="form-group col-md-2">
                                    <label for="address_no">No.</label>
                                    <input type="text" name="address_no" id="address_no" value="{{ $value('address_no') }}" class="form-control form-control-sm">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="address_street">Street</label>
                                    <input type="text" name="address_street" id="address_street" value="{{ $value('address_street') }}" class="form-control form-control-sm">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="address_barangay">Subdivision / Barangay <span class="text-danger">*</span></label>
                                    <input type="text" name="address_barangay" id="address_barangay" value="{{ $value('address_barangay') }}" list="barangayList" class="form-control form-control-sm" required>
                                    <datalist id="barangayList">
                                        @foreach ($barangays as $barangay)
                                            <option value="{{ $barangay }}">
                                        @endforeach
                                    </datalist>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label for="address_city">City / Municipality</label>
                                    <input type="text" name="address_city" id="address_city" value="{{ $value('address_city') }}" class="form-control form-control-sm">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="address_province">Province</label>
                                    <input type="text" name="address_province" id="address_province" value="{{ $value('address_province') }}" class="form-control form-control-sm">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="address_region">Region</label>
                                    <input type="text" name="address_region" id="address_region" value="{{ $value('address_region') }}" class="form-control form-control-sm">
                                </div>
                            </div>

                            <h3 class="h6 font-weight-bold mt-2">Contact details</h3>
                            <div class="form-row">
                                <div class="form-group col-md-2">
                                    <label for="home_no">Home nos.</label>
                                    <input type="text" name="home_no" id="home_no" value="{{ $value('home_no') }}" class="form-control form-control-sm">
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="office_no">Office nos.</label>
                                    <input type="text" name="office_no" id="office_no" value="{{ $value('office_no') }}" class="form-control form-control-sm">
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="mobile_no">Mobile nos.</label>
                                    <input type="text" name="mobile_no" id="mobile_no" value="{{ $value('mobile_no') }}" class="form-control form-control-sm">
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="fax_no">Fax number</label>
                                    <input type="text" name="fax_no" id="fax_no" value="{{ $value('fax_no') }}" class="form-control form-control-sm">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="email">Email address</label>
                                    <input type="email" name="email" id="email" value="{{ $value('email') }}" class="form-control form-control-sm">
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-9">
                                    <label>Educational background</label>
                                    <div>{!! $choices('education', \App\Models\DayCareWorker::EDUCATION, $value('education')) !!}</div>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="degree">Degree</label>
                                    <input type="text" name="degree" id="degree" value="{{ $value('degree') }}" class="form-control form-control-sm">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-9">
                                    <label>Eligibility</label>
                                    <div>{!! $choices('eligibility', \App\Models\DayCareWorker::ELIGIBILITY, $listValue('eligibility'), true) !!}</div>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="eligibility_other">Other eligibility, please specify</label>
                                    <input type="text" name="eligibility_other" id="eligibility_other" value="{{ $value('eligibility_other') }}" class="form-control form-control-sm">
                                </div>
                            </div>

                            <hr>
                            {{-- II. Work-related information --}}
                            <h2 class="card-title font-weight-bold badge badge-secondary mb-3">II. Work-Related Information</h2>
                            <div class="form-row">
                                <div class="form-group col-md-3">
                                    <label for="years_as_cdw">1. Number of years as CDW</label>
                                    <input type="number" min="0" name="years_as_cdw" id="years_as_cdw" value="{{ $value('years_as_cdw') }}" class="form-control form-control-sm">
                                </div>
                                <div class="form-group col-md-9">
                                    <label for="center_name">2. Name of child development center being served <span class="text-danger">*</span></label>
                                    <input type="text" name="center_name" id="center_name" value="{{ $value('center_name') }}" class="form-control form-control-sm" required>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-9">
                                    <label>3. Monthly compensation</label>
                                    <div>{!! $choices('compensation_types', \App\Models\DayCareWorker::COMPENSATION_TYPES, $listValue('compensation_types'), true) !!}</div>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="total_compensation">4. Total compensation per month</label>
                                    <input type="number" min="0" step="0.01" name="total_compensation" id="total_compensation" value="{{ $value('total_compensation') }}" class="form-control form-control-sm">
                                </div>
                            </div>

                            <label>5. Source of compensation</label>
                            <div class="form-row">
                                @foreach (\App\Models\DayCareWorker::COMPENSATION_SOURCES as $source => $label)
                                    <div class="form-group col-md-3">
                                        <div class="custom-control custom-checkbox mb-1">
                                            <input type="checkbox" class="custom-control-input" id="source_{{ $source }}" name="compensation_sources[]" value="{{ $source }}" @checked(in_array($source, $listValue('compensation_sources'), true))>
                                            <label class="custom-control-label font-weight-normal" for="source_{{ $source }}">{{ $label }} amount</label>
                                        </div>
                                        <input type="number" min="0" step="0.01" name="amount_{{ $source }}" value="{{ $value('amount_' . $source) }}" class="form-control form-control-sm" aria-label="{{ $label }} amount">
                                    </div>
                                @endforeach
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="source_others">Other sources, please specify</label>
                                    <input type="text" name="source_others" id="source_others" value="{{ $value('source_others') }}" class="form-control form-control-sm">
                                </div>
                            </div>
                            <div class="form-group">
                                <label>6. Terms of employment</label>
                                <div>{!! $choices('employment_term', \App\Models\DayCareWorker::EMPLOYMENT_TERMS, $value('employment_term')) !!}</div>
                            </div>

                            <label>7. ECCD-related trainings</label>
                            <div class="table-responsive">
                                <table class="table table-sm table-bordered mb-3">
                                    <thead>
                                        <tr>
                                            <th scope="col" style="width: 3rem">#</th>
                                            <th scope="col">Title of training</th>
                                            <th scope="col" style="width: 12rem">Inclusive dates</th>
                                            <th scope="col" style="width: 7rem">No. of hours</th>
                                            <th scope="col">Conducted / sponsored by</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @for ($i = 0; $i < \App\Models\DayCareWorker::TRAINING_ROWS; $i++)
                                            <tr>
                                                <td>{{ $i + 1 }}.</td>
                                                <td><input type="text" name="trainings[{{ $i }}][title]" value="{{ $trainings[$i]['title'] ?? '' }}" class="form-control form-control-sm" aria-label="Training {{ $i + 1 }} title"></td>
                                                <td><input type="text" name="trainings[{{ $i }}][dates]" value="{{ $trainings[$i]['dates'] ?? '' }}" placeholder="e.g. Jan 15-19, 2024" class="form-control form-control-sm" aria-label="Training {{ $i + 1 }} inclusive dates"></td>
                                                <td><input type="number" min="0" step="0.5" name="trainings[{{ $i }}][hours]" value="{{ $trainings[$i]['hours'] ?? '' }}" class="form-control form-control-sm" aria-label="Training {{ $i + 1 }} number of hours"></td>
                                                <td><input type="text" name="trainings[{{ $i }}][sponsor]" value="{{ $trainings[$i]['sponsor'] ?? '' }}" class="form-control form-control-sm" aria-label="Training {{ $i + 1 }} conducted or sponsored by"></td>
                                            </tr>
                                        @endfor
                                    </tbody>
                                </table>
                            </div>

                            <label>8. Other courses attended</label>
                            @for ($i = 0; $i < \App\Models\DayCareWorker::COURSE_ROWS; $i++)
                                <div class="form-row">
                                    <div class="form-group col-md-9">
                                        <input type="text" name="other_courses[{{ $i }}][course]" value="{{ $courses[$i]['course'] ?? '' }}" placeholder="Course" class="form-control form-control-sm" aria-label="Course {{ $i + 1 }}">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <input type="number" min="1950" max="{{ date('Y') + 1 }}" name="other_courses[{{ $i }}][year]" value="{{ $courses[$i]['year'] ?? '' }}" placeholder="Year completed" class="form-control form-control-sm" aria-label="Course {{ $i + 1 }} year completed">
                                    </div>
                                </div>
                            @endfor

                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label>9. Status as a child development worker</label>
                                    <div>{!! $choices('accreditation_status', \App\Models\DayCareWorker::ACCREDITATION_STATUSES, $value('accreditation_status')) !!}</div>
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="date_accredited">Date accredited</label>
                                    <input type="date" name="date_accredited" id="date_accredited" value="{{ $dateValue('date_accredited') }}" class="form-control form-control-sm">
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="accreditation_no">Accreditation no.</label>
                                    <input type="text" name="accreditation_no" id="accreditation_no" value="{{ $value('accreditation_no') }}" class="form-control form-control-sm">
                                </div>
                                <div class="form-group col-md-2">
                                    <label>Level</label>
                                    <div>{!! $choices('accreditation_level', \App\Models\DayCareWorker::ACCREDITATION_LEVELS, $value('accreditation_level')) !!}</div>
                                </div>
                            </div>

                            <hr>
                            {{-- III. Working conditions --}}
                            <h2 class="card-title font-weight-bold badge badge-secondary mb-3">III. Working Conditions</h2>
                            <div class="form-row">
                                <div class="form-group col-md-3">
                                    <label for="children_served">1. Total no. of children being served</label>
                                    <input type="number" min="0" name="children_served" id="children_served" value="{{ $value('children_served') }}" class="form-control form-control-sm">
                                </div>
                                <div class="form-group col-md-4">
                                    <label>2. No. of sessions conducted per day</label>
                                    <div>{!! $choices('sessions_per_day', \App\Models\DayCareWorker::SESSIONS_PER_DAY, $value('sessions_per_day')) !!}</div>
                                </div>
                                <div class="form-group col-md-5">
                                    <label>3. No. of hours per session</label>
                                    <div>{!! $choices('hours_per_session', \App\Models\DayCareWorker::HOURS_PER_SESSION, $value('hours_per_session')) !!}</div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>4. Age of children being handled</label>
                                <div>{!! $choices('children_ages', \App\Models\DayCareWorker::CHILDREN_AGES, $listValue('children_ages'), true) !!}</div>
                            </div>
                            <div class="form-group">
                                <label>5. No. of hours staying in the center</label>
                                <div>{!! $choices('hours_in_center', \App\Models\DayCareWorker::HOURS_IN_CENTER, $value('hours_in_center')) !!}</div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-8">
                                    <label>6. How sessions are conducted</label>
                                    <div>{!! $choices('session_method', \App\Models\DayCareWorker::SESSION_METHODS, $value('session_method')) !!}</div>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="date_conducted">Date conducted</label>
                                    <input type="date" name="date_conducted" id="date_conducted" value="{{ $dateValue('date_conducted') }}" class="form-control form-control-sm">
                                </div>
                            </div>

                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-save" aria-hidden="true"></i> {{ $isEdit ? 'Save changes' : 'Save' }}
                            </button>
                            @if ($isEdit)
                                <a href="{{ route('daycarePdf', ['id' => $id]) }}" target="_blank" rel="noopener" class="btn btn-outline-secondary ml-1">
                                    <i class="fas fa-file-pdf" aria-hidden="true"></i> Print Form 6
                                </a>
                            @endif
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
