@extends('layouts.app')
@section('content')
    <div class="container mt-0">
        <div class="row justify-content-between align-items-center mb-3">
            <div class="col">
                <h3>Tag List</h3>
            </div>
            <div class="col text-end">
                @can('add_role')
                    <a href="{{ url('tags/create') }}" class="btn btn-primary">Create Tag</a>
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

        <table id="tags-table" class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tag Name</th>
                    <th>Action</th>

                </tr>
            </thead>
        </table>
    </div>

    <script>
        jQuery.noConflict();
        jQuery(document).ready(function($) {
            $('#tags-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('tags.index') }}",
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
                        name: 'action',
                        orderable: false,
                        searchable: false,
                        render: function(data) {
                            return `

                @can('edit_student')
                    <a href="{{ url('tags/${data}/edit') }}" class="btn btn-sm btn-warning me-2">Edit</a>
                @endcan
                @can('delete_student')
                    <form action="{{ url('tags/${data}') }}" method="POST" class="d-inline delete-form">
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
