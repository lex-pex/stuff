@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"> Profile </div>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-danger" role="alert">
                            {!! session('status') !!}
                        </div>
                    @endif

                    <div class="row">
                        <div class="col-6">
                            <img src="{{ $user->image ? $user->image : '/img/empty.jpg' }}" width="100%" />
                        </div>
                        <div class="col-6 alert alert-success text-right">
                            <h5> {{ isset($title) ? ucfirst($title) : 'page title' }} </h5>
                            User Name:<br>
                            <strong>{{ $user->name }}</strong><br/>
                            Project Roles:<br/>
                            {{ count($roles = $user->roles) ? '' : 'none' }}
                            @foreach($roles as $role)
                                <code>{{ $role->role }}</code><br>
                            @endforeach
                            <p class="text-left">Description:</p>
                            <div class="p-1 text-left text-black-50 border border-success rounded">
                                {{ $user->description }}
                            </div>
                        </div>
                    </div>

                    <div>
                        <a href="{{ route('users.edit', $user) }}" class="btn btn-sm btn-outline-primary" style="padding: 0 6px 0 6px;"> Edit </a>
                        <a onclick="event.preventDefault();deleteConfirm('{{ $user->id }}', '{{ $user->name }}', 'user')"
                           data-toggle="modal" data-target="#modal-default"
                           class="btn btn-sm btn-outline-danger text-danger" style="padding: 0 8px 0 7px"> Del </a>
                    </div>
                    <hr/>
                </div>
            </div>
        </div>
    </div>
</div>
@include('details.del_popup')
@endsection
