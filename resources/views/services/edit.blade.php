@extends('layouts.app')
@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h3>Edit Srevice</h3>
                        {{-- Uncomment the Back button if navigation is needed --}}
                        <a href="{{ url('services') }}" class="btn btn-primary">Back</a>
                    </div>
                    @if (session('message'))
                        <div class="alert alert-success mt-3">
                            {{ session('message') }}
                        </div>
                    @endif


                    <div class="card-body">
                        <form action="{{ route('services.update',$service->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label for="serviceName" class="form-label">Service</label>
                                <input type="text" name="service" id="serviceName" class="form-control"
                                    value="{{ old('service',$service->name) }}">
                                @error('service')
                                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="roleName" class="form-label">Price</label>
                                <input type="numbers" name="price" id="priceName" class="form-control"
                                    value="{{ old('price',$service->price) }}">
                                @error('price')
                                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="roleName" class="form-label">Status</label>
                                <div>
                                    <label>
                                        <input type="radio" name="status" value="active"
                                            {{ old('status', $service->status) === 'active' ? 'checked' : '' }}>
                                        Active
                                    </label>
                                </div>
                                <div>
                                    <label>
                                        <input type="radio" name="status" value="inactive"
                                        {{ old('status', $service->status) === 'inactive' ? 'checked' : '' }}>
                                        Inactive
                                    </label>
                                </div>

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
