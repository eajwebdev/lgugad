@extends('layouts.master')

@section('body')
<div class="content module-workspace">
    <div class="container-fluid" >
        <div class="row">
            <div class="col-12 module-workspace__main">
                @include('partials.workspace-header', ['module' => 'VAWC', 'title' => 'VAWC records', 'description' => 'Search and review intake records.', 'count' => $vawc->count(), 'actionRoute' => 'vawcForm', 'actionLabel' => 'Add VAWC record'])
                <div class="card module-workspace__list-card">
                    <div class="card-header">
                        <h2 class="card-title mb-0">All records</h2>
                    </div>


                    <div class="card-body">
                        <table id="example1" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Complete Name</th>
                                    <th>Birth Date</th>
                                    <th>Age</th>
                                    <th>Sex</th>
                                    <th>Religion</th>
                                    <th>Present Address</th>
                                    <th>School</th>
                                </tr>
                            </thead>
                            <tbody id="tbody">
                                @foreach($vawc as $va)
                                <tr>
                                    <td>{{ $va->cname }}</td>
                                    <td>{{ $va->dob }}</td>
                                    <td>{{ $va->age }}</td>
                                    <td>{{ $va->gender }}</td>
                                    <td>{{ $va->religion }}</td>
                                    <td>{{ $va->p_address }}</td>
                                    <td>{{ $va->school }}</td>
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
    
@endsection
