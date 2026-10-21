@extends('layouts.master')

@section('body')
<div class="content module-workspace">
    <div class="container-fluid" >
        <div class="row">
            <div class="col-12 module-workspace__main">
                @include('partials.workspace-header', ['module' => 'Solo parents', 'title' => 'Solo parent records', 'description' => 'Search, review, and add solo parent records.', 'count' => $soloparent->count(), 'actionRoute' => 'soloparentForm', 'actionLabel' => 'Add solo parent'])
                <div class="card module-workspace__list-card">
                    <div class="card-header">
                        <h2 class="card-title mb-0">All records</h2>
                    </div>

                    <div class="card-body">
                        <table id="example1" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Complete Name</th>
                                    <th>Age</th>
                                    <th>Gender</th>
                                    <th>Birth Date</th>
                                    <th>Address</th>
                                    <th>Highest Education</th>
                                    <th>Occupation</th>
                                    <th>Monthly Income</th>
                                </tr>
                            </thead>
                            <tbody id="tbody">
                                @foreach($soloparent as $sp)
                                <tr>
                                    <td>{{ $sp->cname }}</td>
                                    <td>{{ $sp->age }}</td>
                                    <td>{{ $sp->gender }}</td>
                                    <td>{{ $sp->dob }}</td>
                                    <td>{{ $sp->address }}</td>
                                    <td>{{ $sp->h_education }}</td>
                                    <td>{{ $sp->occupation }}</td>
                                    <td>{{ number_format($sp->monthly_income, 2) }}</td>
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
