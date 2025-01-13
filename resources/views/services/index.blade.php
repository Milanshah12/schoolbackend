@extends('layouts.app')
@section('content')
    <div class="container mt-0">
        <div class="row justify-content-between align-items-center mb-3">
            <div class="col">
                <h3>Service List</h3>
            </div>
            <div class="col text-end">
                @can('add_services')
                    <a href="{{ url('services/create') }}" class="btn btn-primary">Create Service</a>
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

        <table id="services-table" class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Status</th>
                    <th>Action</th>

                </tr>
            </thead>

        </table>
    </div>
    <script>
        jQuery.noConflict();
        jQuery(document).ready(function($) {
            $('#services-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('services.index') }}",
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },


                    {
                        data: 'price',
                        name: 'price', // Name should match the database column
                        render: function(data) {
                            return `Rs. ${data}`;
                        }
                    },

                    {
                        data: 'status',
                        name: 'status'
                    },

                    {
                        data: 'id',
                        name: 'actions',
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row) {
                            return `

                              @can('edit_services')

                             <a href="/services/${data}/edit" class="btn btn-sm btn-warning me-2">Edit</a>  @endcan
                                @can('delete_services')
                                 <form action="/services/${data}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                        <button type="button" class="btn btn-sm btn-danger btn-delete">Delete</button>
                                </form>
                                @endcan
                            `;
                        }
                    }
                ]
                // order: [[1, 'desc']];
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
