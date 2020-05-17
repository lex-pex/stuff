@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ $title }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('users.update', $user) }}" enctype="multipart/form-data">
                        @method('put')
                        @csrf
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') ? old('name') : $user->name }}" required autocomplete="name" autofocus>
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') ? old('email') : $user->email }}" required autocomplete="email">
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('Roles') }}</label>
                            <div class="col-md-6">
                                @foreach($roles as $role)
                                <div class="form-check">
                                    <input {{ in_array($role->role, $uroles) ? 'checked' : '' }} type="checkbox" name="roles[]" value="{{ $role->role }}" class="form-check-input" id="{{ 'id_'. $role }}">
                                    <label class="form-check-label" for="{{ 'id_'. $role }}">{{ ucfirst($role->role) }}</label>
                                </div>
                                @endforeach
                                @error('roles')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('New Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="* * * * * * * *" autocomplete="new-password">
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="* * * * * * * *" autocomplete="new-password">
                            </div>
                        </div>

                        @can('admin')
                            <div class="form-group row bg-warning">
                                <label for="name" class="col-md-4 col-form-label text-md-right">Status (Admin Option):</label>
                                <div class="col-md-6">
                                    <input id="name" type="text" name="status" value="{{ old('status') ? old('status') : $user->status }}"
                                           class="form-control @error('status') is-invalid @enderror" autocomplete="status" autofocus>
                                    @error('status')
                                    <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                    @enderror
                                </div>
                            </div>
                        @endcan

                        <div class="form-group row justify-content-center">
                            <div class="col-md-6 offset-md-2">
                                <img src="{{ $user->image ? $user->image : '/img/empty.jpg' }}" width="100%" />
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
                                              class="form-control @error('description') is-invalid @enderror">{{ old('description') ? old('description') : $user->description }}</textarea>
                                @error('description')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Submit') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
