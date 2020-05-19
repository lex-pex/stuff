@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center p-0">
        <div class="col-md-8 col-sm-12">
            <div class="card">
                <div class="card-header">{{ ucfirst($title) }}</div>
                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-danger" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif
                    <!-- Greeting with the User -->
                    <div class="alert alert-success text-right">
                        <span class="mark">{{ Auth::user()->name }}</span>
                    </div>
                    <hr/>
                    <div class="row p-2">
                        <div class="col-6 text-left">
                            <h5> {{ isset($title) ? $title : 'page title' }} </h5>
                        </div>
                        <div class="col-6 text-right">
                            <a href="{{ route('users.create') }}" class="btn btn-sm btn-outline-info" style="padding: 0 6px 0 6px;">Add New</a>
                        </div>
                    </div>
                    <table class="table">
                        <thead>
                        <tr class="text-center">
                            <th width="40%" scope="col"> Name </th>
                            <th width="2%" scope="col"> id </th>
                            <th width="5%" scope="col"> Roles <br> Status </th>
                            <th width="10%"> Created<br>Updated </th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($users as $user)
                        <tr>
                            <td>
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-4">
                                        <img src="{{ $user->image ? $user->image : '/img/empty.jpg' }}" width="100%">
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-8">
                                        <a class="btn btn-link" href="{{ route('users.show', $user->id) }}"><strong>{{ $user->name }}</strong></a>
                                    </div>
                                </div>
                            </td>
                            <td class="text-center">
                                {{ $user->id }} <br />
                                <a href="{{ route('users.edit', $user) }}" class="btn btn-sm btn-outline-primary" style="padding: 0 6px 0 6px;"> Edit </a>
                                <br>
                                <a onclick="event.preventDefault();deleteConfirm('{{ $user->id }}', '{{ $user->name }}', 'user')"
                                   data-toggle="modal" data-target="#modal-default"
                                   class="btn btn-sm btn-outline-danger text-danger" style="padding: 0 8px 0 7px"> Del </a>
                            </td>
                            <td>
                                @if(count($user->roles()->get()))
                                    @foreach($user->roles()->get() as $role)
                                        {{ $role->role }} <br>
                                    @endforeach
                                @else
                                    {{ 'none' }} <br>
                                @endif
                                    {{ $user->status }}
                            </td>
                            <td>
                                <small>
                                    {{ $user->created_at ? date_format($user->created_at, 'd/m/y H:i') : 'Date unknown' }}
                                    <br/>
                                    {{ $user->updated_at ? date_format($user->updated_at, 'd/m/y H:i') : 'Have no updated' }}
                                </small>
                            </td>
                        </tr>
                        @endforeach
                        <tr>
                            <td colspan="4" class="text-center bg-light">
                                {{ isset($title) ? ucfirst($title) : 'page title' }}
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
