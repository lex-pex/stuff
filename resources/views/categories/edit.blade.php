@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ $action }}</div>
                    <div class="card-body">
                        <div class="text-danger mr-auto"><small>{{ session('status') }}</small></div>
                        <form method="POST" action="{{ route('categories.update', $category) }}">
                            @method('put')
                            @csrf
                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">Name:</label>
                                <div class="col-md-6">
                                    <input id="name" type="text" name="name" value="{{ old('name') ? old('name') : $category->name }}"
                                            class="form-control @error('name') is-invalid @enderror" autocomplete="title" autofocus>
                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row mb-0">
                                <label for="submit" class="col-md-4 col-form-label text-md-right">Submit:</label>
                                <div class="col-md-6 offset-md-4">
                                    <button id="submit" type="submit" class="btn btn-outline-danger btn-block">Send</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="card-footer text-center">{{ config('app.name') }}</div>
                </div>
            </div>
        </div>
    </div>
@endsection