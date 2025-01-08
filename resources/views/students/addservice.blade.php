@extends('layouts.app')
@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h3>Add Services</h3>
                        {{-- Uncomment the Back button if navigation is needed --}}
                        {{-- <a href="{{ url('roles') }}" class="btn btn-primary">Back</a> --}}
                    </div>
                    @if (session('message'))
                        <div class="alert alert-success mt-3">
                            {{ session('message') }}
                        </div>
                    @endif


                    <div class="card-body">
                        <form action="{{ url("students/$id/add") }}" method="POST">

                            @csrf


                            <div class="mb-3">
                                <label for="services" class="form-label ">Services</label>
                                <select class="form-select select2" name="service[]" multiple aria-label="Select services">
                                    <option value="">--Select service--</option>
                                    @foreach ($services as $service)
                                        <option value="{{ $service->id }}">{{ $service->name }}</option>
                                    @endforeach
                                </select>

                                @error('service')
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
