@extends('layouts.master')

@section('body')

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Reports</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                        <li class="breadcrumb-item active">Reports</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card card-gray card-outline">
                        <div class="card-header">
                            <h3 class="card-title">
                            </h3>
                            <form class="form-horizontal" action="{{ route('generateReports') }}" method="GET" id="generateReport" target="_blank">  
                                @csrf
                                <div class="form-group">
                                    <div class="form-row">
                                        <div class="col-md-4">
                                            <label><span class="badge badge-secondary">Gender</span></label>
                                            <select class="form-control" name="gender">
                                                <option disabled selected> ---Select--- </option>
                                                <option value="All">ALL Male & Female</option>
                                                <option value="Male">Male</option>
                                                <option value="Female">Female</option>
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <label><span class="badge badge-secondary">Age Bracket</span></label>
                                            <select class="form-control" name="agebracket">
                                                <option disabled selected> ---Select--- </option>
                                                <option value="All">ALL Age</option>
                                                <option value="60-69">60-69</option>
                                                <option value="70-79">70-79</option>
                                                <option value="80-89">80-89</option>
                                                <option value="90-99">90-99</option>
                                                <option value="100-above">100-above</option>
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <label>&nbsp;</label>
                                            <button type="submit" class="form-control btn btn-info">Search</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="example3" class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>OSCA ID No.</th>
                                            <th>Name</th>
                                            <th>Gender</th>
                                            <th>Birthday</th>
                                            <th>Age</th>
                                            <th>Pensioner</th>
                                            <th>Remarks</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tbody">
                                        @php $no = 1; @endphp
                                        @foreach($citizen as $data)
                                        <tr id="tr-{{ $data->id }}" class="">
                                            <td>{{ $no++ }}</td>
                                            <td class="text-capitalize">{{ $data->osca_idnum }}</td>
                                            <td class="text-capitalize">{{ $data->lname }}, {{ $data->fname }}  {{ $data->mname }} {{ $data->ext }}</td>
                                            <td class="text-capitalize">{{ $data->gender }}</td>
                                            <td class="text-capitalize">{{ $data->birth_date_label }}</td>
                                            <td class="text-capitalize">{{ $data->current_age === null ? '—' : $data->current_age . ' yrs. old' }}</td>
                                            <td class="text-capitalize">{{ $data->curr_pension }} yrs. old</td>
                                            <td class="text-capitalize"></td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
        
@endsection
