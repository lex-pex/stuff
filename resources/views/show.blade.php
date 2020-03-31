@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ $article->title }}</div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                <img src="{{ $article->image ? $article->image : '/img/empty.jpg' }}" width="100%"/>
                            </div>
                            <div class="col-6">
                                {{ $article->text }}
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-6 text-left">
                                @if($edit_access)
                                    @can('delete_article')
                                    <a onclick="event.preventDefault();" data-toggle="modal" data-target="#modal-default"
                                       class="btn btn-outline-danger mx-2 text-danger">Delete</a>
                                    @endcan
                                    <a href="{{ route('articles.edit', $article->id) }}" class="btn btn-outline-primary mx-2">Edit</a>
                                @endif
                            </div>
                            <div class="col-6 text-right">
                                <small>
                                    {{ $article->created_at ? date_format($article->created_at, 'd/m/y H:i') : 'Date unknown' }} |
                                    {{ $article->updated_at ? date_format($article->updated_at, 'd/m/y H:i') : 'Have no updated' }}
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @can('delete_article')
    <!-- Delete Confirmation Pop-Up Modal -->
    <div class="container">
        <div class="modal fade in" id="modal-default" style="display: none; padding-right: 15px;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header text-center">
                        <span class="modal-title">Deleting an Article</span>
                        <a class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true"> × </span>
                        </a>
                    </div>
                    <div class="modal-body text-center text-bold">
                        <p>Are you sure you want</p>
                        <p>to erase an Article:</p>
                        <p>"{{ $article->title }}"</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-dark" data-dismiss="modal">Cancel</button>
                        <form action="{{ route('articles.destroy', $article->id) }}" method="post" style="display: inline-block">
                            @csrf
                            <input type="hidden" name="_method" value="delete">
                            <button type="submit" class="btn btn-outline-danger">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endcan
@endsection
