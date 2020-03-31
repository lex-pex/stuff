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
                    <!-- Greeting the with User's Name and Role -->
                    <div class="alert alert-success text-right">
                        Hello, <span class="mark">{{ $user->name }}</span>
                        <br/>
                        Project Role: <span class="mark">{{ $r = $user->roles()->first() ? $r : 'none' }}</span>
                    </div>

                    <hr/>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
