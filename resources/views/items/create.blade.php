@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ $action }}</div>
                    <div class="card-body">
                        <div class="text-danger mr-auto"><small>{{ session('status') }}</small></div>
                        <form method="POST" action="{{ route('articles.store') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group row">
                                <label for="title" class="col-md-4 col-form-label text-md-right">Title:</label>
                                <div class="col-md-6">
                                    <input id="title" type="text" name="title" value="{{ old('title') }}"
                                           class="form-control @error('title') is-invalid @enderror" autocomplete="title" autofocus>
                                    @error('title')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="text" class="col-md-4 col-form-label text-md-right">Text:</label>
                                <div class="col-md-6">
                                    <textarea id="text" rows="10" type="text" name="text" autocomplete="text"
                                              class="form-control @error('text') is-invalid @enderror">{{ old('title') }}</textarea>
                                    @error('text')
                                    <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                    @enderror
                                </div>
                            </div>
                            @can('create_article')
                            <div class="form-group row bg-warning">
                                <label for="text" class="col-md-4 col-form-label text-md-right">Author (Admin Option):</label>
                                <div class="col-md-6">
                                    <select class="form-control custom-select" name="user_id">
                                        @foreach($users as $u)
                                        <option {{ $u->id == $user->id ? 'selected' : '' }}
                                                value="{{ $u->id }}">{{ $u->name . ' ('. ($u->roles()->first() ? $u->roles()->first()->role : 'no role') .')' }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            @endcan
                            <div class="form-group row">
                                <label for="text" class="col-md-4 col-form-label text-md-right">Category:</label>
                                <div class="col-md-6">
                                    <select class="form-control custom-select" name="category_id">
                                        @foreach($categories as $c)
                                            <option value="{{ $c->id }}">{{ $c->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row justify-content-center">
                                <div class="col-md-6 offset-md-2">
                                    <img src="{{ url('/img/empty.jpg') }}" width="100%" />
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="image" class="col-md-4 col-form-label text-md-right">Picture:</label>
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