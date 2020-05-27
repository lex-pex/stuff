@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-6">{{ $title }}</div>
                            <div class="col-6 text-right">
                                <a href="{{ route('item', $item->alias) }}">{{ $item->title }}</a>
                            </div>
                        </div>

                    </div>
                    <div class="card-body">
                        <div class="text-danger mr-auto">
                            <small>{{ session('status') }}</small>
                        </div>
                        <form method="POST" action="{{ route('items.update', $item) }}" enctype="multipart/form-data">
                            @method('put') @csrf <span></span>
                            <div class="form-group row">
                                <label for="title" class="col-md-4 col-form-label text-md-right">Title:</label>
                                <div class="col-md-6">
                                    <input id="title" type="text" name="title" value="{{ old('title') ? old('title') : $item->title }}"
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
                                            class="form-control @error('text') is-invalid @enderror">{{ old('text') ? old('text') : $item->text }}</textarea>
                                    @error('text')
                                    <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                    @enderror
                                </div>
                            </div>
                            @can('admin')
                            <div class="form-group row bg-warning">
                                <label for="text" class="col-md-4 col-form-label text-md-right">Author (Admin Option):</label>
                                <div class="col-md-6">
                                    <select class="form-control custom-select" name="user_id">
                                        @foreach($users as $u)
                                        <option {{ $u->id == $item->user_id ? 'selected' : '' }}
                                                value="{{ $u->id }}">{{ $u->name . ' ('. ($u->roles()->first() ? $u->roles()->first()->role : 'no role') .')' }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row bg-warning">
                                <label for="status" class="col-md-4 col-form-label text-md-right">Status:</label>
                                <div class="col-md-6">
                                    <input id="status" type="text" name="status" value="{{ old('status') ? old('status') : $item->status }}"
                                           class="form-control @error('status') is-invalid @enderror" autocomplete="title" autofocus>
                                    @error('status')
                                    <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                    @enderror
                                </div>
                            </div>
                            @endcan
                            <div class="form-group row">
                                <label for="text" class="col-md-4 col-form-label text-md-right">Category:</label>
                                <div class="col-md-6">
                                    <select class="form-control custom-select" name="category_id">
                                        @foreach($categories as $c)
                                            @if($c->id == 1)
                                                @continue
                                            @endif
                                            <option {{ $c->id == $item->category_id ? 'selected' : '' }} value="{{ $c->id }}">{{ $c->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row justify-content-center">
                                <div class="col-md-6 offset-md-2">
                                    <img src="{{ $item->image ? $item->image : '/img/empty.jpg' }}" width="100%" />
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
                                <label for="alias" class="col-md-4 col-form-label text-md-right">Alias:</label>
                                <div class="col-md-6">
                                    <input id="alias" type="text" name="alias" value="{{ old('alias') ? old('alias') : $item->alias }}"
                                           class="form-control @error('alias') is-invalid @enderror" autocomplete="alias" autofocus>
                                    @error('alias')
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