@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header" id="{{ 'item_name_' . $item->id }}">{{ $item->title }}</div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                <img src="{{ $item->image ? $item->image : '/img/empty.jpg' }}" width="100%"/>
                            </div>
                            <div class="col-6">
                                {{ $item->text }}
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-6 text-left">
                                <div class="row">
                                    <div class="col-6 text-left">
                                        <a href="{{ route('category', $item->category->alias) }}">{{ $item->category->name }}</a>
                                    </div>
                                    <div class="col-6 text-right">
                                    @can('delete_item')
                                        <a onclick="event.preventDefault();deleteConfirm('{{ $item->id }}', 'items')" data-toggle="modal" data-target="#modal-default"
                                           class="btn btn-sm btn-outline-danger mx-2 text-danger" style="padding: 0 10px 0 10px;">Del</a>
                                    @endcan
                                    @can('edit_item')
                                        <a href="{{ route('items.edit', $item->id) }}"
                                           class="btn btn-sm btn-outline-primary mx-2" style="padding: 0 7px 0 7px;">Edit</a>
                                    @endcan
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 text-right">
                                <small>
                                    Created: {{ $item->created_at ? date_format($item->created_at, 'd.m.y H:i') : 'Date unknown' }}<br/>
                                    Updated: {{ $item->updated_at ? date_format($item->updated_at, 'd.m.y H:i') : 'Have no updated' }}
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @can('delete_item')
    @include('details.del_popup')
    @endcan
@endsection
