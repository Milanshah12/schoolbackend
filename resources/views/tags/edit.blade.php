@extends('layouts.app')
@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h3>Add Tag</h3>
                        {{-- Uncomment the Back button if navigation is needed --}}
                        <a href="{{ url('tags') }}" class="btn btn-primary">Back</a>
                    </div>
                    @if (session('message'))
                        <div class="alert alert-success mt-3">
                            {{ session('message') }}
                        </div>
                    @endif


                    <div class="card-body">
                        <form action="{{ route('tags.update',$tag->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label for="tagName" class="form-label">Tag</label>
                                <input type="text" name="tag" id="tagName" class="form-control"
                                    value="{{ old('tag',$tag->name) }}">
                                @error('tag')
                                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <button type="submit" class="btn btn-primary">Change</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
