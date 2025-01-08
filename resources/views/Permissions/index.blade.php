@extends('layouts.app')
@section('content')
    <div class="container mt-0">
        <div class="row justify-content-between align-items-center mb-3">
            <div class="col">
                <h3>Permission List</h3>
            </div>
            <div class="col text-end">
                @can('add_permission')

              <a href="{{ url('permissions/create') }}" class="btn btn-primary">Create Permission</a>
              @endcan
            </div>
        </div>
        @if (session('message'))
            <div class="alert alert-success mt-3">
                {{ session('message') }}
            </div>
        @endif

        <table id="permissions-table" class="table table-bordered">
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
            $('#permissions-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('permissions.index') }}",
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
                          @can('edit_permission')
                         <a href="{{ url('permissions/${data}/edit') }}" class="btn btn-sm btn-warning me-2">Edit</a>
                          @endcan

                          @can('delete_permission')
                            <form action="{{ url('permissions/${data}') }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this role?');">
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
