@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ $item->title }}</div>
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
                                        <a onclick="event.preventDefault();deleteConfirm('{{ $item->id }}', '{{ $item->title }}', 'item')" data-toggle="modal" data-target="#modal-default"
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
                                    {{ $item->created_at ? date_format($item->created_at, 'd/m/y H:i') : 'Date unknown' }} |
                                    {{ $item->updated_at ? date_format($item->updated_at, 'd/m/y H:i') : 'Have no updated' }}
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @can('delete_item')
        <!-- Delete Confirmation Pop-Up Modal -->
        <div class="container">
            <div class="modal fade in" id="modal-default" style="display:none;padding-right:15px;">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header text-center">
                            <span id="del_modal_title" class="modal-title"> Delete </span>
                            <a class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true"> × </span>
                            </a>
                        </div>
                        <div class="modal-body text-center text-bold">
                            <p>Are you sure you want</p>
                            <p>to erase the <i id="item">Item</i> :</p>
                            <p id="item_name"> </p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-sm btn-outline-dark" data-dismiss="modal">Cancel</button>
                            <form id="del_form" method="post" action="404" style="display: inline-block">
                                @csrf
                                <input type="hidden" name="_method" value="delete">
                                <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endcan
@endsection
