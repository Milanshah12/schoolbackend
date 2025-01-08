@extends('layouts.app')
@section('content')
    <div class="container mt-0">
        <h3 class="mb-4 text-center">Add Student</h3>
        @if (session('message'))
            <div class="alert alert-success mt-3">
                {{ session('message') }}
            </div>
        @endif

        <form action="{{ url('students') }}" method="POST">
            @csrf
            <div class="row">
                <!-- Left Column -->
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="studentName" class="form-label">Name</label>
                        <input type="text" name="name" id="studentName" class="form-control" value="{{ old('name') }}">
                        @error('name')
                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="phone" class="form-label">Phone</label>
                        <input type="text" name="phone" id="phone" class="form-control" value="{{ old('phone') }}">
                        @error('phone')
                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}">
                        @error('email')
                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="phone_2" class="form-label">Phone 2</label>
                        <input type="text" name="phone_2" id="phone2" class="form-control" value="{{ old('phone2') }}">
                        @error('phone2')
                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Right Column -->
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="emergency_contact" class="form-label">Emergency Contact</label>
                        <input type="text" name="emergency_contact" id="emergencyContact" class="form-control"
                            value="{{ old('emergency_contact') }}">
                        @error('emergency_contact')
                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="emergencyContact2" class="form-label">Emergency Contact 2</label>
                        <input type="text" name="emergency_contact_2" id="emergencyContact2" class="form-control"
                            value="{{ old('emergency_contact_2') }}">
                        @error('emergency_contact_2')
                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="enrolldate" class="form-label">Enroll Date</label>
                        <input type="date" name="enroll_date" id="enrolldate" class="form-control"
                            value="{{ old('enroll_date') }}">
                        @error('enroll_date')
                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <div>
                            <label class="me-3">
                                <input type="radio" name="status" value="active" checked> Active
                            </label>
                            <label>
                                <input type="radio" name="status" value="inactive"> Inactive
                            </label>
                        </div>
                    </div>


                </div>
            </div>
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



            <div class="text-center">
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
        </form>
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
