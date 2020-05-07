@extends('layouts.app')
@section('content')
<div class="container-fluid">
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
                <div class="row justify-content-center">
                    <div class="col-lg-2 col-md-4 col-sm-6">
                        <img src="{{ isset($current_category) && $current_category->image ? $current_category->image : '/img/empty.jpg' }}" width="100%" />
                    </div>
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
