@extends('layouts.app')

@section('content')
<div class="container mt-0">
    <div class="row justify-content-between align-items-center mb-3">
        <div class="col">
            <h3>Students List</h3>
        </div>
        <div class="col text-end">
            @can('add_student')
                <a href="{{ route('students.create') }}" class="btn btn-primary">Add Student</a>
            @endcan
        </div>
    </div>

    @if (session('message'))
        <div class="alert alert-success mt-3">
            {{ session('message') }}
        </div>
    @endif

    <!-- Add responsive container -->
    <div class="table-responsive">
        <table id="students-table" class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Phone</th>
                    <th>Email</th>
                    <th>Phone 2</th>
                    <th>Emergency Contact</th>
                    <th>Emergency Contact 2</th>
                    <th>Enroll Date</th>
                    <th>Balance</th>
                    <th>Status</th>
                    <th>Services</th>
                    <th>Actions</th>
                </tr>
            </thead>
        </table>
    </div>
</div>

    <script>
        jQuery.noConflict();
        jQuery(document).ready(function($) {
            $('#students-table').DataTable({
    processing: true,
    serverSide: true,
    ajax: "{{ route('students.index') }}",
    columns: [
        { data: 'id', name: 'id' },
        { data: 'name', name: 'name' },
        { data: 'phone', name: 'phone' },
        { data: 'email', name: 'email' },
        { data: 'phone_2', name: 'phone_2', visible: false }, // Hide this column
        { data: 'emergency_contact', name: 'emergency_contact' },
        { data: 'emergency_contact_2', name: 'emergency_contact_2', visible: false }, // Hide this column
        { data: 'enroll_date', name: 'enroll_date' },
        { data: 'balance', name: 'balance' },
        { data: 'status', name: 'status' },
        { data: 'services', name: 'services' },
        {
            data: 'id',
            name: 'action',
            orderable: false,
            searchable: false,
            render: function(data) {
                return `

                @can('add_service_to_student')
                <a href="{{ url('students/${data}/add') }}" class="btn btn-sm btn-success me-2">Add Service</a>
             @endcan

                @can('edit_student')
                    <a href="{{ url('students/${data}/edit') }}" class="btn btn-sm btn-warning me-2">Edit</a>
                @endcan
                @can('delete_student')
                    <form action="{{ url('students/${data}') }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this student?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                    </form>
                @endcan
                `;
            }
        }
    ],
    responsive: true // Enable responsive mode for DataTables
});

        });
    </script>
@endsection
