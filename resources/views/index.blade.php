@extends('layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="px-0 mx-0">
            <div class="row">
                <div class="col-md-2 col-sm-12 py-3 border">
                    <a href="/" class="page-link mb-3 {{ isset($current_category) ? '' : 'bg-info text-light' }}"> All Categories </a>
                    @foreach($categories as $category)
                        <a href="{{ route('category_index', $category->id) }}"
                           class="page-link mb-3 {{ isset($current_category) ? ($current_category->id == $category->id) ? 'bg-info text-light' : '' : '' }}">{{ $category->name }}</a>
                    @endforeach
                </div>
                <div class="col-md-10 col-sm-12">
                    <div class="row justify-content-center">
                        <!-- Main Img Big screen -->
                        <div class="category-bg-image d-lg-block d-md-block d-sm-none hide-small"
                             style="background-image: url({{ isset($current_category) && $current_category->image ? $current_category->image : '/img/empty.jpg' }})">
                        </div>
                        <div class="d-lg-block d-md-block d-sm-none hide-small p-4" style="width:100%;height:200px;text-shadow:0 0 25px white">
                            <h1>{{ $current_category->name }}</h1>
                            <p style="max-width:300px;">{{ $current_category->description }}</p>
                        </div>
                        <!-- End Main Img Big screen -->
                        <!-- Main Img Small screen -->
                        <div class="d-lg-none d-md-none d-sm-block col-12">
                            <div style="position: absolute; top: 20px; left: 20px">
                                <h1>{{ $current_category->name }}</h1>
                                <p>{{ $current_category->description }}</p>
                            </div>
                            <img src="{{ isset($current_category) && $current_category->image ? $current_category->image : '/img/empty.jpg' }}" width="100%">
                        </div>
                        <!-- End Main Img Small screen -->
                    </div>
                    <div class="row no-gutters">
                        @foreach($items as $item)
                            <div class="col-md-4 p-1">
                                <div class="card">
                                    <a class="text-black-50 text-decoration-none" href="{{ route('item_show', $item->id) }}">
                                        <div class="card-header">
                                            <h4> {{ $item->title }} </h4>
                                        </div>
                                        <div class="card-body p-0">
                                            <div class="row">
                                                <div class="col-6">
                                                    <img src="{{ $item->image ? $item->image : '/img/empty.jpg' }}" width="100%" />
                                                </div>
                                                <div class="col-6">
                                                    {{ mb_strimwidth($item->text, 0, 90, '....') }}
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                    <div class="card-footer text-right p-0">
                                        <span class="text-danger">Category:</span>
                                        <a class="btn btn-link" href="{{ route('category_index', $item->category_id) }}">{{ $item->category->name }}</a>
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
        </div>
    </div>
@endsection
