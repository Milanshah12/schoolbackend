@extends('layouts.app')


@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h3>Add Receipt</h3>
                        <a href="{{ url('receipts') }}" class="btn btn-primary">Back</a>
                    </div>

                    <div class="card-body">
                        @if (session('message'))
                            <div class="alert alert-success">
                                {{ session('message') }}
                            </div>
                        @endif

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('receipts.store') }}" method="POST">
                            @csrf

                            <div class="mb-3">
                                <label for="date" class="form-label">Date:</label>
                                <input type="date" name="date" id="date" class="form-control">
                            </div>

                            <div class="mb-3">
                                <label for="bank_id" class="form-label">Bank:</label>
                                <select name="bank_id" id="bank_id" class="form-control select2">
                                    <option value="">-- Select Bank --</option>
                                    @foreach ($banks as $bank)
                                        <option value="{{ $bank->id }}">{{ $bank->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="student_id" class="form-label">Student:</label>
                                <select name="student_id" id="student_id" class="form-control select2">
                                    <option value="">-- Select Student --</option>
                                    @foreach ($students as $student)
                                        <option value="{{ $student->id }}">{{ $student->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="receipt_payment_heading_id" class="form-label">Heading:</label>
                                <select name="receipt_payment_heading_id" id="receipt_payment_heading_id" class="form-control select2">
                                    <option value="">-- Select Heading --</option>
                                    @foreach ($headings as $heading)
                                        <option value="{{ $heading->id }}">{{ $heading->heading }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="amount" class="form-label">Amount:</label>
                                <input type="number" name="amount" id="amount" class="form-control">
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-success">Add Receipt</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            // Initialize Select2
            $('.select2').select2();

            // Initialize DataTables
            $('#exampleTable').DataTable();
        });
    </script>
@endsection






