@extends('layouts.master')

@section('body')
<div class="content module-workspace">
    <div class="container-fluid" >
        <div class="row">
            <div class="col-12 module-workspace__main">
                @include('partials.workspace-header', ['module' => 'PWD', 'title' => 'PWD records', 'description' => 'Search applications and review registered persons with disability.', 'count' => $pwd->count(), 'actionRoute' => 'pwdForm', 'actionLabel' => 'Add PWD record'])
                <div class="card module-workspace__list-card">
                    <div class="card-header">
                        <h2 class="card-title mb-0">All records</h2>
                    </div>
                    <div class="card-body">
                        <table id="example1" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Full Name</th>
                                    <th>Applicant Type</th>
                                    <th>Disability Number</th>
                                    <th>Date Applied</th>
                                    <th>Date of Birth</th>
                                    <th>Sex</th>
                                    <th>Civil Status</th>
                                    <th>Barangay</th>
                                    <th>Municipality</th>
                                    <th>Province</th>
                                    <th>Region</th>
                                </tr>
                            </thead>
                            <tbody id="tbody">
                                @foreach($pwd as $p)
                                <tr>
                                    <td>{{ strtoupper($p->lname) }} {{ strtoupper($p->fname) }} {{ strtoupper($p->mname) }}</td>
                                    <td>{{ $p->applicant }}</td>
                                    <td>{{ $p->person_with }}</td>
                                    <td>{{ $p->date_app }}</td>
                                    <td>{{ $p->dob }}</td>
                                    <td>{{ $p->gender }}</td>
                                    <td>{{ $p->c_status }}</td>
                                    <td>{{ $p->brgy_name }}</td>
                                    <td>{{ $p->municipality }}</td>
                                    <td>{{ $p->province }}</td>
                                    <td>{{ $p->region }}</td>
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
