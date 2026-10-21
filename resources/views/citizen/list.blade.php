@extends('layouts.master')

@section('body')
<div class="content module-workspace">
    <div class="container-fluid" >
        <div class="row">
            <div class="col-12 module-workspace__main">
                @include('partials.workspace-header', ['module' => 'Senior citizens', 'title' => 'Senior citizen records', 'description' => 'Search, review, and register senior citizens.', 'count' => $citizen->count(), 'modalTarget' => '#modal-citizen', 'actionLabel' => 'Add senior citizen'])
                <div class="card module-workspace__list-card">
                    <div class="card-header">
                        <h2 class="card-title mb-0">All records</h2>
                    </div>

                    @include('citizen/modal-citizen')
                    @include('citizen/modal-idcard')

                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="example1" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Last Name</th>
                                        <th>First Name</th>
                                        <th>Middle Name</th>
                                        <th>Ext. Name</th>
                                        <th>Gender</th>
                                        <th>Birthday</th>
                                        <th>Age</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="tbody">
                                    @php $no = 1; @endphp
                                    @foreach($citizen as $data)
                                    <tr id="tr-{{ $data->id }}" class="">
                                        <td>{{ $no++ }}</td>
                                        <td class="text-capitalize">{{ $data->lname }}</td>
                                        <td class="text-capitalize">{{ $data->fname }}</td>
                                        <td class="text-capitalize">{{ $data->mname }}</td>
                                        <td class="text-capitalize">{{ $data->ext }}</td>
                                        <td class="text-capitalize">{{ $data->gender }}</td>
                                        <td class="text-capitalize">{{ $data->birth_date_label }}</td>
                                        <td class="text-capitalize">{{ $data->current_age ?? '—' }}</td>
                                        <td class="text-capitalize">
                                            <div class="dropdown">
                                                <span class="badge {{ ($data->status == 'Waiting') ? 'badge-warning' : '' }} {{ ($data->status == 'Active / Pensioner') ? 'badge-success' : '' }} {{ ($data->status == 'Deceased') ? 'badge-danger' : '' }} dropdown-toggle" id="statusDropdown-{{ $data->id }}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    {{ $data->status }}
                                                </span>
                                                <div class="dropdown-menu" aria-labelledby="statusDropdown-{{ $data->id }}">
                                                    <a class="dropdown-item" href="#" onclick="updateStatus('{{ $data->id }}', 'Waiting')">Waiting</a>
                                                    <a class="dropdown-item" href="#" onclick="updateStatus('{{ $data->id }}', 'Active / Pensioner')">Active / Pensioner</a>
                                                    <a class="dropdown-item" href="#" onclick="updateStatus('{{ $data->id }}', 'Deceased')">Deceased</a>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <a href="{{ route('citizenReadPdf', ['id' => encrypt($data->id)]) }}" title="View Form" target="_blank" class="btn btn-warning btn-xs btn-edit">
                                                <i class="fas fa-file-pdf"></i>
                                            </a>

                                            <button id="{{ $data->id }}" onclick="printSticker(this.id)" title="Senior ID" class="btn btn-success btn-xs btn-print" href="#"><i class="fas fa-id-card"></i></button>

                                            <a href="{{ route('citizenMoreInfo', ['encryptedId' => encrypt($data->id)]) }}" title="More Info" class="btn btn-info btn-xs btn-edit">
                                                <i class="fas fa-exclamation-circle"></i>
                                            </a>
                                            <button value="{{ $data->id }}" title="Delete" class="btn btn-danger btn-xs citizen-delete">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </td>
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

@endsection
