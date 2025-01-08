@extends('layouts.app')
@section('content')
    <div class="container mt-0">
        <div class="row justify-content-between align-items-center mb-3">
            <div class="col">
                <h3>receipt List</h3>
            </div>
            <div class="col text-end">
           @can('add_receipt')
           <a href="{{ url('receipts/create') }}" class="btn btn-primary">Create Receipt</a>
           @endcan
            </div>
        </div>
        @if (session('message'))
            <div class="alert alert-success mt-3">
                {{ session('message') }}
            </div>
        @endif
        <table id="receipts-table" class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Date</th>
                    <th>Student_Name</th>
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
            $('#receipts-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('receipts.index') }}",
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'date',
                        name: 'date'
                    },
                    {
                        data: 'student_name',
                        name:'student_name'
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
                        data:'amount',
                        name: 'amount'
                    }

                ]
            });
        });
    </script>
@endsection
