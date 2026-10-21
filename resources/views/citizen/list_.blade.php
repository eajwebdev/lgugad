@extends('layouts.master')

@section('body')

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Citizen</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                        <li class="breadcrumb-item active">Citizen</li>
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
                                <h3 class="card-title">
                                    <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#modal-citizen">
                                        <i class="fas fa-users"></i> + Add New
                                    </button>
                                </h3>
                            </h3>
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
                                            <td class="text-capitalize">{{ \Carbon\Carbon::parse($data->bday)->format('F j, Y') }}</td>
                                            <td class="text-capitalize">{{ $data->age }}</td>
                                            <td>
                                                
                                                <a href="{{ route('citizenReadPdf', ['id' => encrypt($data->id)]) }}" target="_blank" class="btn btn-warning btn-xs btn-edit">
                                                    <i class="fas fa-file-pdf"></i>
                                                </a>

                                                <button id="{{ $data->id }}" onclick="printSticker(this.id)" class="btn btn-success btn-xs btn-print" href="#"><i class="fas fa-id-card"></i></button>

                                                <a href="{{ route('citizenMoreInfo', ['encryptedId' => encrypt($data->id)]) }}" class="btn btn-info btn-xs btn-edit">
                                                    <i class="fas fa-exclamation-circle"></i>
                                                </a>
                                                <button value="{{ $data->id }}" class="btn btn-danger btn-xs citizen-delete">
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
    
</div>
<script>
    var citizenDeleteRoute = "{{ route('citizenDelete', ':id') }}";
</script> 

<script>
    function printSticker(idcard_id) {
        $.ajax({
            url: "{{ route('citizenPrntSticker', ':id') }}".replace(':id', idcard_id),
            method: 'GET',
            success: function(response) {
                
                $('#modal-prntIDcard .modal-body').html(response);
                
                $('#modal-prntIDcard').modal('show');  

                console.log(response);

                $(".downloadStickerButton").each(function() {
                    $(this).val(idcard_id);
                });
            }
        });
    }
</script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://html2canvas.hertzen.com/dist/html2canvas.min.js"></script>
@endsection