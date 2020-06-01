@extends('layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="px-0 mx-0">
            <div class="row">
                <div class="col-md-2 col-sm-12 py-3 border">
                    @foreach($categories as $c)
                        <a href="{{ route('category', $c->alias) }}"
                           class="page-link mb-3 {{ $category->id == $c->id ? 'bg-info text-light' : '' }}">{{ $c->name }}</a>
                    @endforeach
                    @can('admin')
                        <hr/>
                        <p> <span class="text-info">Category:</span>
                            <a href="{{ route('categories.edit', $category) }}" class="btn btn-sm btn-outline-primary" style="padding: 0 6px 0 6px;"> Edit </a>
                            <a onclick="event.preventDefault();deleteConfirm('{{ $category->id }}', '{{ $category->name }}', 'category')"
                               data-toggle="modal" data-target="#modal-default"
                               class="btn btn-sm btn-outline-danger text-danger"
                               style="padding: 0 8px 0 7px; {{ $category->id == 1 ? 'display:none' : '' }}"> Del </a>
                        </p>
                    @endcan
                </div>
                <div class="col-md-10 col-sm-12">
                    <div class="row justify-content-center">
                        <!-- Main Img Big screen -->
                        <div class="category-bg-image d-lg-block d-md-block d-sm-none hide-small"
                             style="background-image: url({{ $category->image ? $category->image : '/img/empty.jpg' }})">
                        </div>
                        <div class="d-lg-block d-md-block d-sm-none hide-small p-4" style="width:100%;height:200px">
                            <h1 style="padding:3px;max-width:375px;background-color:rgba(255,255,255, 0.8)">{{ $category->name }}</h1>
                            @if($category->description)
                            <p style="padding:3px;max-width:375px;background-color:rgba(255,255,255, 0.8)">{{ $category->description }}</p>
                            @endif
                        </div>
                        <!-- End Main Img Big screen -->
                        <!-- Main Img Small screen -->
                        <div class="d-lg-none d-md-none d-sm-block col-12">
                            <div style="position: absolute; top: 20px; left: 20px">
                                <h1 style="padding:3px;max-width:375px;background-color:rgba(255,255,255, 0.5)">{{ $category->name }}</h1>
                                @if($category->description)
                                <p style="padding:3px;max-width:375px;background-color:rgba(255,255,255, 0.5)">{{ $category->description }}</p>
                                @endif
                            </div>
                            <img src="{{ $category->image ? $category->image : '/img/empty.jpg' }}" width="100%">
                        </div>
                        <!-- End Main Img Small screen -->
                    </div>
                    <div class="row no-gutters">
                        @foreach($items as $item)
                            <div class="col-md-4 p-1">
                                <div class="card">
                                    <a class="text-black-50 text-decoration-none" href="{{ route('item', $item->alias) }}">
                                        <div class="card-header text-center">
                                            <h4> {{ $item->title }} </h4>
                                            <div class="text-right">
                                                <small>Created: {{ $item->created_at->format('d.m.y H:i') }}</small>
                                            </div>
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

                                        <small>{{ 'ID: '.$item->id.', Status: '.$item->status.', User: '.$item->user_id }}</small>
                                        <span class="text-danger">Category:</span>
                                        <a class="btn btn-link" href="{{ route('category', $item->category->alias) }}">{{ $item->category->name }}</a>
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
    @can('create_item')
    @include('details.create_button')
    @endcan
@endsection


