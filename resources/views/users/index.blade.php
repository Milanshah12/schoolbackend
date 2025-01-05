@extends('layouts.app')
@section('content')
    <div class="container mt-0">
        <div class="row justify-content-between align-items-center mb-3">
            <div class="col">
                <h3>User List</h3>
            </div>
            <div class="col text-end">
                <a href="{{ url('users/create') }}" class="btn btn-primary">Create User</a>
            </div>
        </div>
        @if (session('message'))
            <div class="alert alert-success mt-3">
                {{ session('message') }}
            </div>
        @endif

        <table id="users-table" class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Action</th>

                </tr>
            </thead>

        </table>
    </div>
    <!-- Load jQuery first -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>

    <!-- Load DataTables CSS and JS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

    <!-- Your Custom Script -->
    <script>
        jQuery.noConflict();
        jQuery(document).ready(function($) {
            $('#users-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('users.index') }}",
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'email',
                        name: 'email'
                    },
                    {
                        data: 'role',
                        name: 'role',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'id',
                        name: 'action',
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row){
                            return `
                            <a href="{{ url('users/${data}/edit') }}" class="btn btn-sm btn-warning me-2">Edit</a>
                            <form action="{{ url('users/${data}') }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this role?');">
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
