@extends('layouts.app')
@section('content')
    <div class="container mt-0">
        <div class="row justify-content-between align-items-center mb-3">
            <div class="col">
                <h3>receipt List</h3>
            </div>
            <div class="col text-end">
                @can('add_payment')
                    <a href="{{ url('payments/create') }}" class="btn btn-primary">Create Payment</a>
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
        <table id="payments-table" class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Date</th>
                    <th>Bank_name</th>
                    <th>Heading</th>
                    <th>Amount</th>
                </tr>
            </thead>
        </table>
    </div>

    <script>
        jQuery.noConflict();
        jQuery(document).ready(function($) {
            $('#payments-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('payments.index') }}",
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'date',
                        name: 'date'
                    },

                    {
                        data: 'bank_name',
                        name: 'bank_name'
                    },
                    {
                        data: 'heading',
                        name: 'heading'
                    },
                    {
                        data: 'amount',
                        name: 'amount', // Name should match the database column
                        render: function(data) {
                            return `Rs. ${data}`;
                        }
                    }


                ]
            });
        });
    </script>
@endsection
