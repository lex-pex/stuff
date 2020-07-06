@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-2 col-sm-12">
            @include('details.admin_bar')
        </div>
        <div class="col-md-8 justify-content-center">
            <div class="card">
                <div class="card-header">Dashboard</div>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <!-- Greeting the with User's Name and Role -->
                    <div class="alert alert-info text-right">
                        {{ $user_name }} | Role: {{ $user_role }}
                    </div>
                    <hr/>
                    <div class="row p-3">
                        <div class="col-6 text-left">
                            ....
                        </div>
                        <div class="col-6 text-right">
                            ....
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
