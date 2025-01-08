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

                        <form action="{{ route('headings.update',$headings->id) }}" method="POST">
                            @method('PUT')
                            @csrf

                            <div class="mb-3">
                                <label for="date" class="form-label">Heahing</label>
                                <input type="text" name="heading" id="heading" class="form-control" value="{{old('heading',$headings->heading)}}">
                            </div>






                            <div class="mb-3">
                                <label class="form-label">Status</label>
                                <div>
                                    <label class="me-3">
                                        <input type="radio" name="type" value="receipt" {{old('type',$headings->type)==='receipt' ? 'checked' : ''}} checked> receipt
                                    </label>
                                    <label>
                                        <input type="radio" name="type" value="payment" {{old('type',$headings->type)==='payment' ? 'checked' : ''}}>payment
                                    </label>
                                </div>
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-success">Add Heading</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection




