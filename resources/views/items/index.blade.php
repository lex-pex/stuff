@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ ucfirst($title) }}</div>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-danger" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <!-- Greeting the with User's Name and Role -->
                    <div class="alert alert-success text-right">
                        <span class="mark">{{ Auth::user()->name }}</span>
                    </div>
                    <hr/>
                    <div class="row p-2">
                        <div class="col-6 text-left">
                            <h5> {{ isset($title) ? $title : 'page title' }} </h5>
                        </div>
                        <div class="col-6 text-right">
                            <a href="{{ route('items.create') }}" class="btn btn-sm btn-outline-info" style="padding: 0 6px 0 6px;">Add New</a>
                        </div>
                    </div>
                    <table class="table">
                        <thead>
                        <tr class="text-center">
                            <th scope="col" width="1%">id</th>
                            <th scope="col" width="20%">Image</th>
                            <th scope="col">Title</th>
                            <th scope="col" width="5%">Edit</th>
                            <th scope="col"> <small>Created/Updated</small></th>
                        </tr>
                        </thead>
                        <tbody class="text-black-50">
                        @foreach($items as $item)
                        <tr>
                            <th scope="row">{{ $item->id }}</th>
                            <th scope="row">
                                <img src="{{ $item->image ? $item->image : '/img/empty.jpg' }}" width="100%">
                            </th>
                            <td>
                                <strong>{{ $item->title }}</strong>
                                <br />{{ mb_strimwidth($item->text, 0, 120, '....') }}
                            </td>
                            <td>
                                <a href="{{ route('items.edit', $item) }}" class="btn btn-sm btn-outline-primary" style="padding: 0 6px 0 6px;"> Edit </a>
                                <br>
                                <a onclick="event.preventDefault();deleteConfirm('{{ $item->id }}', '{{ $item->name }}', '$item')"
                                   data-toggle="modal" data-target="#modal-default"
                                   class="btn btn-sm btn-outline-danger text-danger" style="padding: 0 8px 0 7px"> Del </a>
                            </td>
                            <th scope="row" width="20%">
                                <small>
                                    {{ $item->created_at ? date_format($item->created_at, 'd/m/y H:i') : 'Date unknown' }}
                                    <br/>
                                    {{ $item->updated_at ? date_format($item->updated_at, 'd/m/y H:i') : 'Have no updated' }}
                                </small>
                            </th>
                        </tr>
                        @endforeach
                        <tr>
                            <td colspan="5" class="text-center bg-light">
                                {{ isset($title) ? $title : 'page title' }}
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            {{ $items->links() }}
        </div>
    </div>
</div>
@endsection
