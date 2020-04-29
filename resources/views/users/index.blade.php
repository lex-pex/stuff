@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>
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
                            <th width="5%" scope="col"> id </th>
                            <th width="35%" scope="col"> Name </th>
                            <th width="5%" scope="col"> Edit </th>
                            <th width="10%" scope="col"> Roles </th>
                            <th scope="col"> <small> Created<br>Updated </small> </th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($users as $user)
                        <tr>
                            <td scope="row">{{ $user->id }}</td>
                            <td>
                                <a class="btn btn-link" href="{{ route('users.show', $user->id) }}"><strong>{{ $user->name }}</strong></a>
                            </td>
                            <td>
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
                            </td>
                            <td scope="row" width="20%">
                                <small>
                                    {{ $user->created_at ? date_format($user->created_at, 'd/m/y H:i') : 'Date unknown' }}
                                    <br/>
                                    {{ $user->updated_at ? date_format($user->updated_at, 'd/m/y H:i') : 'Have no updated' }}
                                </small>
                            </td>
                        </tr>
                        @endforeach
                        <tr>
                            <td colspan="5" class="text-center bg-light">
                                {{ isset($title) ? $title : 'page title' }}
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@include('details.del_popup')
@endsection
