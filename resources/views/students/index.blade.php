@extends('layouts.app')
@section('content')
    <div class="container mt-0">
        <div class="row justify-content-between align-items-center mb-3">
            <div class="col">
                <h3>Student List</h3>
            </div>
            <div class="col text-end">
                <a href="{{ url('students/create') }}" class="btn btn-primary">Add Student</a>
            </div>
        </div>
        @if (session('message'))
            <div class="alert alert-success mt-3">
                {{ session('message') }}
            </div>
        @endif

        <table id="students-table" class="table table-bordered">
            <thead>
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
                    <th>Action</th>
                </tr>
            </thead>
        </table>
    </div>
    <script>
        jQuery.noConflict();
        jQuery(document).ready(function($) {
            $('#students-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('students.index') }}",
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'phone',
                        name: 'phone'
                    },
                    {
                        data: 'email',
                        name: 'email'
                    },
                    {
                        data: 'phone_2',
                        name: 'phone_2'
                    },
                    {
                        data: 'emergency_contact',
                        name: 'emergency_contact'
                    },
                    {
                        data: 'emergency_contact_2',
                        name: 'emergency_contact_2'
                    },
                    {
                        data: 'enroll_date',
                        name: 'enroll_date'
                    },
                    {
                        data: 'balance',
                        name: 'balance'
                    },
                    {
                        data: 'status',
                        name: 'status'
                    },
                    {
                        data: 'id',
                        name: 'action',
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row) {
                            return `
<a href="{{ url('students/${data}/edit') }}" class="btn btn-sm btn-warning me-2">Edit</a>
<form action="{{ url('students/${data}') }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this student?');">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
</form>
`;
                        }
                    }
                ]
            });
        });
    </script>
@endsection
