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
                    <div class="row p-2">
                        <div class="col-6 text-left">
                            <h5> Categories: </h5>
                        </div>
                        <div class="col-6 text-right">
                            <a href="{{ route('categories.create') }}" class="btn btn-outline-info">Add New</a>
                        </div>
                    </div>
                    <table class="table">
                        <thead>
                        <tr class="text-center">
                            <th scope="col"> id </th>
                            <th scope="col"> Name </th>
                            <th scope="col"> Actions </th>
                            <th scope="col"> <small> Created/Updated </small> </th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($categories as $category)
                        <tr>
                            <th scope="row">{{ $category->id }}</th>
                            <td><strong>{{ $category->name }}</strong></td>
                            <td>
                                <a href="{{ route('categories.edit', $category) }}" class="btn btn-outline-info">Edit</a>
                                <a onclick="event.preventDefault();myScript('{{ $category->id }}', '{{ $category->name }}')" data-toggle="modal" data-target="#modal-default"
                                   class="btn btn-outline-danger mx-2 text-danger">Del</a>
                            </td>
                            <th scope="row" width="20%">
                                <small>
                                    {{ $category->created_at ? date_format($category->created_at, 'd/m/y H:i') : 'Date unknown' }}
                                    <br/>
                                    {{ $category->updated_at ? date_format($category->updated_at, 'd/m/y H:i') : 'Have no updated' }}
                                </small>
                            </th>
                        </tr>
                        @endforeach
                        <tr><td colspan="4" class="text-center bg-light">app categories</td></tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Delete Confirmation Pop-Up Modal -->
<script>
    /**
     * Get and Substitute parameter of the Delete Form
     * Get and Substitute title of the Category
     * @param id - category id
     * @param name - category name
     */
    function myScript(id, name) {
        document.getElementById('del_form').setAttribute('action', '/categories/' + id);
        document.getElementById('category_name').innerHTML = '\" ' + name + ' \"';
    }
</script>
<!-- Delete Confirmation Pop-Up Modal -->
<div class="container">
    <div class="modal fade in" id="modal-default" style="display: none; padding-right: 15px;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header text-center">
                    <span class="modal-title">Deleting a Category <strong id="category_id"></strong></span>
                    <a class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"> × </span>
                    </a>
                </div>
                <div class="modal-body text-center text-bold">
                    <p>Are you sure you want</p>
                    <p>to erase an Category:</p>
                    <p id="category_name"> </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-dark" data-dismiss="modal">Cancel</button>
                    <form id="del_form" method="post" style="display: inline-block">
                        @csrf
                        <input type="hidden" name="_method" value="delete">
                        <button type="submit" class="btn btn-outline-danger">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
