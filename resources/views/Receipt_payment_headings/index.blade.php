@extends('layouts.app')

@section('content')
    <div class="container mt-0">
        <div class="row justify-content-between align-items-center mb-3">
            <div class="col">
                <h3>Receipt List</h3>
            </div>
            <div class="col text-end">
               @can('add_heading')
              <a href="{{ route('headings.create') }}" class="btn btn-primary">Create Receipt</a>

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

        <table id="headings-table" class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Heading</th>
                    <th>Type</th>
                    <th>action</th>
                </tr>
            </thead>
        </table>
    </div>

    <script>
        jQuery.noConflict();
        jQuery(document).ready(function($) {
            $('#headings-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('headings.index') }}",
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'heading', name: 'heading' },
                    { data: 'type', name: 'type' },
                    {
                        data: 'id',
                        name: 'action',
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row) {
                            return `
                            @can('edit_heading')
                            <a href="{{ url('headings/${data}/edit') }}" class="btn btn-sm btn-warning me-2">Edit</a>
                            @endcan

                            @can('delete_heading')
                            <form action="{{ url('headings/${data}') }}" method="POST" class="d-inline" >
                                @csrf
                                @method('DELETE')
                        <button type="button" class="btn btn-sm btn-danger btn-delete">Delete</button>
                            </form>

                            @endcan
                            `;
                        }
                    }
                ],

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
