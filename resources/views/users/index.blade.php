@extends('layouts.app')
@section('content')
    <div class="container mt-0">
        <div class="row justify-content-between align-items-center mb-3">
            <div class="col">
                <h3>User List</h3>
            </div>
            <div class="col text-end">
                @can('add_staff')
                    <a href="{{ url('users/create') }}" class="btn btn-primary">Create User</a>
                @endcan
            </div>
        </div>
        @if (session('message'))
            <script>
                Swal.fire({
                    position: "top-end",
                    icon: "success",
                    title: "{{ session('message') }}",
                    showConfirmButton: false,
                    timer: 1500
                });
            </script>
        @endif
        <ul class="nav nav-tabs" id="userTabs" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="active-users-tab" data-bs-toggle="tab" href="#active-users"
                    role="tab">Active Users</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="soft-deleted-users-tab" data-bs-toggle="tab" href="#soft-deleted-users"
                    role="tab">Soft Deleted Users</a>
            </li>
        </ul>

        <div class="tab-content mt-3">
            <div class="tab-pane fade show active" id="active-users" role="tabpanel">

                <h3>Active Users</h3>
                <table id="active-users-table" class="table table-bordered table-striped">
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

            <div class="tab-pane fade" id="soft-deleted-users" role="tabpanel">
                <h1>Soft Deleted Users</h1>
                <table id="soft-deleted-users-table" class="table table-bordered table-striped">
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
        </div>
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
    let activeTable = $('#active-users-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('users.index') }}",
        columns: [
            { data: 'id', name: 'id' },
            { data: 'name', name: 'name' },
            { data: 'email', name: 'email' },
            { data: 'role', name: 'role', orderable: false, searchable: false },
            {
                data: 'id',
                name: 'action',
                orderable: false,
                searchable: false,
                render: function(data, type, row) {
                    return `
                        @can('edit_staff')
                        <a href="{{ url('users/${data}/edit') }}" class="btn btn-sm btn-warning me-2">Edit</a>
                        @endcan
                        @can('delete_staff')
                        <form action="{{ url('users/${data}') }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="btn btn-sm btn-danger btn-delete">Delete</button>
                        </form>
                        @endcan
                    `;
                }
            }
        ]
    });

    let softDeletedTable = $('#soft-deleted-users-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: '{{ route('users.index') }}',
            data: { type: 'soft_deleted' }
        },
        columns: [
            { data: 'id', name: 'id' },
            { data: 'name', name: 'name' },
            { data: 'email', name: 'email' },
            { data: 'role', name: 'role', orderable: false, searchable: false },
            {
                data: 'id',
                name: 'action',
                orderable: false,
                searchable: false,
                render: function(data, type, row) {
                    return `
                        @can('edit_staff')
                        <a href="{{ url('users/${data}/edit') }}" class="btn btn-sm btn-warning me-2">Edit</a>
                        @endcan
                    `;
                }
            }
        ]
    });

    $('a[data-bs-toggle="tab"]').on('shown.bs.tab', function(e) {
        var target = $(e.target).attr("href");
        if (target === '#soft-deleted-users') {
            softDeletedTable.ajax.reload();
        } else if (target === '#active-users') {
            activeTable.ajax.reload();
        }
    });

    $(document).on('click', '.btn-delete', function(e) {
        e.preventDefault();
        const form = $(this).closest('form');
        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!"
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    });
});

    </script>
@endsection
