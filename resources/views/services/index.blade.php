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
            <div class="alert alert-success mt-3">
                {{ session('message') }}
            </div>
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
                columns: [
                    {
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },

                    {
                        data: 'price',
                        name: 'price'
                    },
                    {
                        data:'status',
                        name:'status'
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
                                 <form action="/services/${data}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this service?');">
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
