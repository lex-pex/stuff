@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"> Profile </div>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <!-- Greeting with the User -->
                    <div class="alert alert-success text-right">
                        <h5> {{ isset($title) ? $title : 'page title' }} </h5>
                        Hello, {{ $user->name }}
                        <br/>
                        Project Role: {{ ($r = $user->roles()->first()) ? $r->role : 'none' }}
                    </div>
                    <hr/>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
