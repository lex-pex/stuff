@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ $title }}</div>
                    <div class="card-body">
                        <div class="text-danger mr-auto"><small>{{ session('status') }}</small></div>
                        <form method="POST" action="{{ route('categories.update', $category) }}" enctype="multipart/form-data">
                            @method('put') @csrf <span></span>
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
                            <div class="form-group row justify-content-center">
                                <div class="col-md-6 offset-md-2">
                                    <img src="{{ $category->image ? $category->image : '/img/empty.jpg' }}" width="100%" />
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="image" class="col-md-4 col-form-label text-md-right">Picture</label>
                                <div class="col-md-6">
                                    <input id="image" type="file" name="image" autocomplete="current-image"
                                           class="btn btn-outline-primary btn-block @error('image') is-invalid @enderror">
                                    @error('image')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-6 offset-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="image_del" id="image_del" {{ old('image_del') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="image_del">Delete Image</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="description" class="col-md-4 col-form-label text-md-right">Description:</label>
                                <div class="col-md-6">
                                    <textarea id="description" rows="5" type="text" name="description" autocomplete="text"
                                              class="form-control @error('description') is-invalid @enderror">{{ old('description') ? old('description') : $category->description }}</textarea>
                                    @error('description')
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