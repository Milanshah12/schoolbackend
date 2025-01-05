@extends('layouts.app')
@section('content')

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3>Update Role</h3>

                    <a href="{{ url('roles') }}" class="btn btn-primary">Back</a>
                </div>
                @if(session('message'))
    <div class="alert alert-success mt-3">
        {{ session('message') }}
    </div>
@endif


                <div class="card-body">
                    <form action="{{ route('roles.update', $role->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="roleName" class="form-label">Role</label>
                            <input type="text" name="role" id="roleName" class="form-control"  value="{{ old('name', $role->name) }}">
                            @error('role')
                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary">Change</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
