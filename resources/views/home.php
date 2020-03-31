@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
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
                            <h5> Articles: </h5>
                        </div>
                        <div class="col-6 text-right">
                            @can('categories')
                            Admin Option:
                            <a href="{{ route('categories.index') }}" class="btn btn-outline-dark mx-2"> Manage Categories </a>
                            @endcan
                        </div>
                    </div>

                    <table class="table">
                        <thead>
                        <tr class="text-center">
                            <th scope="col">id</th>
                            <th scope="col">Image</th>
                            <th scope="col" width="50%"><strong>Title</strong> | Text</th>
                            <th scope="col"> <small> Created <br/> Updated </small> </th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($articles as $article)
                        <tr>
                            <th scope="row">{{ $article->id }}</th>
                            <td><img src="{{ $article->image ? $article->image : '/img/empty.jpg' }}" width="100%"></td>
                            <td>
                                <strong>{{ $article->title }}</strong>
                                <br/>
                                {{ $article->text }}
                            </td>
                            <th scope="row" width="20%">
                                <small>
                                    {{ $article->created_at ? date_format($article->created_at, 'd/m/y H:i') : 'Date unknown' }}
                                    <br/>
                                    {{ $article->updated_at ? date_format($article->updated_at, 'd/m/y H:i') : 'Have no updated' }}
                                </small>
                            </th>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
