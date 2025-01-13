@extends('layouts.app')
@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h3>Add Heading</h3>
                        <a href="{{ url('headings') }}" class="btn btn-primary">Back</a>
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

                        <form action="{{ route('headings.store') }}" method="POST">
                            @csrf

                            <div class="mb-3">
                                <label for="date" class="form-label">Heahing</label>
                                <input type="text" name="heading" id="heading" class="form-control">
                            </div>






                            <div class="mb-3">
                                <label class="form-label">Status</label>
                                <div>
                                    <label class="me-3">
                                        <input type="radio" name="type" value="receipt" checked> receipt
                                    </label>
                                    <label>
                                        <input type="radio" name="type" value="payment">payment
                                    </label>
                                </div>
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn-payment btn0-success">Add Heading</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).on('click', '.btn-receipt', function(e) {
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




