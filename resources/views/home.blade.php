@extends('layouts.app')
@section('content')
<div class="container-fluid bg-info">

    <div class="row">

        <div class="col-md-2 col-sm-12 bg-white py-3 border">
            <a href="/home" class="page-link mb-3 {{ isset($current_tab) ? '' : 'bg-info text-light' }}"> Main </a>
            @can('categories')
                <a href="{{ route('categories.index') }}"
                   class="page-link mb-3 {{ isset($current_tab) ? ($current_tab == 'categories') ? 'bg-info text-light' : '' : '' }}">
                    Categories
                </a>
            @endcan
            <a href="/home/users"
               class="page-link mb-3 {{ isset($current_tab) ? ($current_tab == 'users') ? 'bg-info text-light' : '' : '' }}">
                Users
            </a>
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
                    <div class="alert alert-success text-right">
                        Hello, <span class="mark">{{ $user_name }}</span> |
                        Project Role: <span class="mark">{{ $user_role }}</span>
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
