@extends('layouts.app')
@section('content')
    <div class="container mt-0">
        <div class="row justify-content-between align-items-center mb-3">
            <div class="col">
                <h3>Role List</h3>
            </div>
            <div class="col text-end">
          @can('add_role')
  <a href="{{ url('roles/create') }}" class="btn btn-primary">Create Role</a>

  @endcan
            </div>
        </div>
        @if (session('message'))
            <div class="alert alert-success mt-3">
                {{ session('message') }}
            </div>
        @endif

        <table id="roles-table" class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Actions</th>
                </tr>
            </thead>
        </table>
    </div>

    <script>
        jQuery.noConflict();
        jQuery(document).ready(function($) {
            $('#roles-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('roles.index') }}",
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'id',
                        name: 'actions',
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row) {
                            return `
                        @can('add_edit_permission_to_role')
                        <a href="{{ url('roles/${data}/give-permission') }}" class="btn btn-sm btn-warning me-2">Edit/Add role permission</a>
                        @endcan

                        @can('edit_role')
                            <a href="{{ url('roles/${data}/edit') }}" class="btn btn-sm btn-success me-2">Edit</a>
                             @endcan

                             @can('delete_role')
                            <form action="{{ url('roles/${data}') }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this role?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                            </form>

                             @endcan
                        `;
                        }
                    }
                ]
            });
        });
    </script>
@endsection
