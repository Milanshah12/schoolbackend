@extends('layouts.app')
@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h3>Add Permission</h3>
                        {{-- Uncomment the Back button if navigation is needed --}}
                        <a href="{{ url('permissions') }}" class="btn btn-primary">Back</a>
                    </div>
                    @if (session('message'))
                        <div class="alert alert-success mt-3">
                            {{ session('message') }}
                        </div>
                    @endif


                    <div class="card-body">
                        <form action="{{ url('permissions') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="roleName" class="form-label">Permission</label>
                                <input type="text" name="permission" id="roleName" class="form-control"
                                    value="{{ old('permission') }}">
                                @error('permission')
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
@endsection
