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
                            <form action="{{ url('roles/${data}') }}" method="POST" class="d-inline">
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
        });
    </script>
     <script>
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
    </script>
@endsection
