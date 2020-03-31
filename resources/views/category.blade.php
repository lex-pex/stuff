@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <!-- jumbotron  -->
        <div class="jumbotron">
            <div class="container">
                <h1 class="display-5"> {{ config('app.name') }} </h1>
                <div class="row">
                    <div class="col-8">
                        <p>This is a template for a simple marketing or informational website.
                            It includes a large callout called a jumbotron and three supporting pieces
                            of content. Use it as a starting point to create something more unique.</p>
                    </div>
                    <div class="col-4">
                        @can('create_article')
                        <a href="{{ route('articles.create') }}" class="btn btn-outline-primary">Add New Article</a>
                        @endcan
                    </div>
                </div>
            </div>
        </div>
        <div class="container px-0">
            <div class="row">
                <div class="col-md-2 bg-white py-3 border">
                    @foreach($categories as $category)
                        <a href="#" class="page-link mb-3">{{ $category->name }}</a>
                    @endforeach
                </div>
                <div class="col-md-10">
                    <div class="row">
                        @foreach($articles as $article)
                            <div class="col-md-4 p-4">
                                <h4> {{ $article->title }} </h4>
                                <div class="row">
                                    <div class="col-6">
                                        <img src="{{ $article->image ? $article->image : '/img/empty.jpg' }}" width="100%" />
                                    </div>
                                    <div class="col-6">
                                        {{ mb_strimwidth($article->text, 0, 50, '...') }}
                                        <a class="btn btn-link" href="{{ route('article_show', $article->id) }}">Read &raquo;</a>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 text-right border-bottom">
                                        <hr/>
                                        <span class="text-danger">Category:</span>
                                        <a class="btn btn-outline-dark m-2" href="{{ route('article_show', $article->id) }}">{{ $article->category->name }}</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <hr/>
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-6">
                        {{ $articles->links() }}
                    </div>
                </div>
            </div>
            <hr/>
        </div> <!-- /container -->
    </div>
</div>
@endsection
