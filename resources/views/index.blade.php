@extends('layouts.app')
@section('content')
<div class="container-fluid">

    <!-- jumbotron
    <div class="jumbotron">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h1 class="display-5"> {{ isset($current_category) ? $current_category->name : config('app.name') }} </h1>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="row">
                        <div class="col-8">
                            <p>
                                According to Einstein, gravity is not a force – it is a property of spacetime itself.
                                So far, all attempts to treat gravity as another quantum force equal in importance to
                                electromagnetism and the nuclear forces have failed, and loop quantum gravity is an
                                attempt to develop a quantum theory of gravity based directly on Einstein's geometric
                                formulation rather than the treatment of gravity as a force.
                            </p>
                        </div>
                        <div class="col-4">
                            @can('create_item')
                                <a href="{{ route('items.create') }}" class="btn btn-outline-dark">Add New Article</a>
                            @endcan
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> jumbotron -->

    <div class="px-0 mx-0">
        <div class="row">
            <div class="col-md-2 col-sm-12 bg-white py-3 border">
                <a href="/" class="page-link mb-3 {{ isset($current_category) ? '' : 'bg-info text-light' }}"> All Categories </a>
                @foreach($categories as $category)
                    <a href="{{ route('category_index', $category->id) }}"
                       class="page-link mb-3 {{ isset($current_category) ? ($current_category->id == $category->id) ? 'bg-info text-light' : '' : '' }}">{{ $category->name }}</a>
                @endforeach
            </div>
            <div class="col-md-10 col-sm-12">
                <div class="row">
                    @foreach($items as $item)
                        <div class="col-md-4 p-4">
                            <h4> {{ $item->title }} </h4>
                            <div class="row">
                                <div class="col-6">
                                    <img src="{{ $item->image ? $item->image : '/img/empty.jpg' }}" width="100%" />
                                </div>
                                <div class="col-6">
                                    {{ mb_strimwidth($item->text, 0, 50, '...') }}
                                    <a class="btn btn-link" href="{{ route('item_show', $item->id) }}">Read &raquo;</a>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 text-right border-bottom">
                                    <hr/>
                                    <span class="text-danger">Category:</span>
                                    <a class="btn btn-outline-dark m-2" href="{{ route('category_index', $item->category_id) }}">{{ $item->category->name }}</a>
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
                    {{ $items->links() }}
                </div>
            </div>
        </div>
        <hr/>
    </div> <!-- /container -->

</div>
@endsection
