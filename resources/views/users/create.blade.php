@extends('layouts.app')
@section('content')

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3>Add User</h3>
                    <a href="{{ url('users') }}" class="btn btn-primary">Back</a>
                </div>
                @if (session('message'))
                <div class="alert alert-success mt-3">
                    {{ session('message') }}
                </div>
            @endif
            <div class="card-body">
                <form action="{{ url('users') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="userName" class="form-label">UserName</label>
                        <input type="text" name="name" id="UserName" class="form-control"
                            value="{{ old('name') }}">
                        @error('name')
                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" name="email" id="Useremail" class="form-control"
                            value="{{ old('email') }}">
                        @error('email')
                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="userRole" class="form-label">Role</label>

                        <select class="form-control select2" name="role">
                        <option value="">select role</option>
                        @foreach ($roles as $role)
                        <option value="{{ $role->name }}">{{ $role->name }}</option>

                    @endforeach
                      </select>

                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" name="password" id="Userpassword" class="form-control"
                            value="{{ old('password') }}">
                        @error('password')
                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="c-password" class="form-label">Password</label>
                        <input type="password" name="confirm_password" id="Userpassword" class="form-control"
                            value="{{ old('confirm_password') }}">
                        @error('confirm_password')
                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        // Initialize Select2
        $('.select2').select2();

        // Initialize DataTables
        $('#exampleTable').DataTable();
    });
</script>

@endsection
