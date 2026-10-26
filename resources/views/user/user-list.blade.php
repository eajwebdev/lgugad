@extends('layouts.master')

@section('body')
@php
    $current_route=request()->route()->getName();
@endphp
<div class="container-fluid module-workspace user-workspace">
    @include('partials.workspace-header', ['module' => 'Users', 'title' => $current_route === 'userEdit' ? 'Edit user account' : 'User accounts', 'description' => 'Manage staff accounts, roles, and module access.', 'count' => $users->count(), 'backRoute' => $current_route === 'userEdit' ? 'userRead' : null])
    <div class="row">
        <div class="col-lg-4 col-xl-3">
            <div class="card card-secondary card-outline">
                <div class="card-header">
                    <h2 class="card-title mb-0"><i class="fas fa-user-gear" aria-hidden="true"></i> {{ $current_route == "userRead" ? "Add user" : "Edit user" }}</h2>
                </div>
                <div class="card-body">
                    <form class="form-horizontal" action="{{ $current_route == "userRead" ? route('userCreate') : route('userUpdate') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <div class="form-row">
                                <div class="col-md-12">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-user"></i>
                                            </span>
                                        </div>
                                        <input type="hidden" name="uid" value="{{ $current_route == 'userEdit' ? $userEdit->id : '' }}">
                                        <input type="text" name="lname" value="{{ $current_route == 'userEdit' ? $userEdit->lname : '' }}" oninput="this.value = this.value.toUpperCase()" placeholder="Enter Last Name" class="form-control form-control-sm" required>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="form-row">
                                <div class="col-md-12">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-user"></i>
                                            </span>
                                        </div>
                                        <input type="text" name="fname" value="{{ $current_route == 'userEdit' ? $userEdit->fname : '' }}" oninput="this.value = this.value.toUpperCase()" placeholder="Enter First Name" class="form-control form-control-sm" required>
                                    </div>    
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="form-row">
                                <div class="col-md-12">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-user"></i>
                                            </span>
                                        </div>
                                        <input type="text" name="mname" value="{{ $current_route == 'userEdit' ? $userEdit->mname : '' }}" oninput="this.value = this.value.toUpperCase()" placeholder="Enter Middle Name" class="form-control form-control-sm" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group user-workspace__select-field">
                            <label for="userGender">Gender</label>
                            <select id="userGender" name="gender" class="form-control" required>
                                <option value="">Select gender</option>
                                <option value="Male" @selected(old('gender', $current_route == 'userEdit' ? $userEdit->gender : '') == 'Male')>Male</option>
                                <option value="Female" @selected(old('gender', $current_route == 'userEdit' ? $userEdit->gender : '') == 'Female')>Female</option>
                            </select>
                        </div>
                        <div class="form-group user-workspace__select-field">
                            <label for="roleSelect">Role</label>
                            <select class="form-control select_camp" name="Role" id="roleSelect" onchange="updateCheckboxes()" required>
                                <option value="">Select role</option>
                                <option value="Administrator" @selected(old('Role', $current_route == 'userEdit' ? $userEdit->role : '') == 'Administrator')>Administrator</option>
                                <option value="Office Staff" @selected(old('Role', $current_route == 'userEdit' ? $userEdit->role : '') == 'Office Staff')>Office Staff</option>
                            </select>
                            <span id="error" class="form-text text-danger text-left Role_error"></span>
                        </div>
                        <div class="form-group">
                            <div class="form-row">
                                <div class="col-md-12">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-user"></i>
                                            </span>
                                        </div>
                                        <input type="text" name="username" value="{{ $current_route == 'userEdit' ? $userEdit->username : '' }}" placeholder="Enter Username" class="form-control form-control-sm">
                                    </div>    
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="form-row">
                                <div class="col-md-12">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-lock"></i>
                                            </span>
                                        </div>
                                        <input type="password" name="password" value="{{ $current_route == 'userEdit' ? '' : '' }}" placeholder="Enter Password" class="form-control form-control-sm">
                                    </div>    
                                </div>
                            </div>
                        </div>

                        @php
                            $accessArray = isset($userEdit) ? explode(',', $userEdit->access) : [];
                        @endphp
                        
                        <div class="form-group">
                            <div class="form-row">
                                <div class="col-md-12">
                                    <label>Access Permissions:</label>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-check">
                                        <input type="checkbox" name="access[0]" value="1" id="access0" class="form-check-input" @if(isset($accessArray[0]) && $accessArray[0] == '1') checked @endif>
                                        <label for="access0" class="form-check-label">FACE</label>
                                    </div>
                                    <div class="form-check">
                                        <input type="checkbox" name="access[1]" value="1" id="access1" class="form-check-input" @if(isset($accessArray[1]) && $accessArray[1] == '1') checked @endif>
                                        <label for="access1" class="form-check-label">PWD</label>
                                    </div>
                                    <div class="form-check">
                                        <input type="checkbox" name="access[2]" value="1" id="access2" class="form-check-input" @if(isset($accessArray[2]) && $accessArray[2] == '1') checked @endif>
                                        <label for="access2" class="form-check-label">SOLO PARENT</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-check">
                                        <input type="checkbox" name="access[3]" value="1" id="access3" class="form-check-input" @if(isset($accessArray[3]) && $accessArray[3] == '1') checked @endif>
                                        <label for="access3" class="form-check-label">WOMENS</label>
                                    </div>
                                    <div class="form-check">
                                        <input type="checkbox" name="access[4]" value="1" id="access4" class="form-check-input" @if(isset($accessArray[4]) && $accessArray[4] == '1') checked @endif>
                                        <label for="access4" class="form-check-label">SENIOR</label>
                                    </div>
                                    <div class="form-check">
                                        <input type="checkbox" name="access[5]" value="1" id="access5" class="form-check-input" @if(isset($accessArray[5]) && $accessArray[5] == '1') checked @endif>
                                        <label for="access5" class="form-check-label">VAWC</label>
                                    </div>
                                    <div class="form-check">
                                        <input type="checkbox" name="access[7]" value="1" id="access7" class="form-check-input" @if(isset($accessArray[7]) && $accessArray[7] == '1') checked @endif>
                                        <label for="access7" class="form-check-label">DAY CARE WORKERS</label>
                                    </div>
                                </div>
                            </div>
                        </div>                                       

                        <div class="form-group">
                            <div class="form-row">
                                <div class="col-md-12">
                                    <button type="submit" name="btn-submit" class="btn btn-success">
                                        <i class="fas fa-save"></i> Save
                                    </button>
                                </div>
                            </div>
                        </div>   
                    </form>
                </div>
            </div>
        </div>
        <div class="col-lg-8 col-xl-9">
            <div class="card card-secondary card-outline">
                <div class="card-header">
                    <h2 class="card-title mb-0">All users</h2>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example1" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Last Name</th>
                                    <th>First Name</th>
                                    <th>Middle Name</th>
                                    <th>Gender</th>
                                    <th>Username</th>
                                    <th>Role</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="tbody">
                                @php $no = 1; @endphp
                                @foreach($users as $user)
                                <tr id="tr-{{ $user->id }}">
                                    <td>{{ $no++ }}</td>
                                    <td>{{ $user->lname }}</td>
                                    <td>{{ $user->fname }}</td>
                                    <td>{{ $user->mname }}</td>
                                    <td>{{ $user->gender }}</td>
                                    <td>{{ $user->username }}</td>
                                    <td>{{ $user->role }}</td>
                                    <td>
                                        <a href="{{ route('userEdit', $user->id) }}" class="btn btn-info btn-xs">
                                            <i class="fas fa-exclamation-circle"></i>
                                        </a>
                                        <button value="{{ $user->id }}" class="btn btn-danger btn-xs user-delete">
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
<script>
    function updateCheckboxes() {
        var selectedRole = document.getElementById('roleSelect').value;
        var checkboxes = document.querySelectorAll('.form-check-input');

        checkboxes.forEach(function(checkbox) {
            if (selectedRole === 'Administrator') {
                checkbox.checked = true;
                checkbox.value = '1'; 
            } else {
                checkbox.checked = false;
            }
        });
    }

</script>
@endsection
