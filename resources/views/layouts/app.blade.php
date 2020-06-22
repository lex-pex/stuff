<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ (isset($title) ? ucfirst($title) . ' | ' : '') . config('app.name', 'Stuff') }}</title>
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <script src="{{ asset('js/app.js') }}" defer></script>
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-dark bg-dark shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Staff') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarContent" aria-controls="navbarContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarContent">
                    <ul class="navbar-nav ml-auto">
                        <form method="post" action="{{ route('sortFilter') }}" class="form-inline d-inline">
                            @csrf
                            <?php
                            if(isset($_SESSION['sort_criteria'])) {
                                $lifo = $_SESSION['sort_criteria']['order'] === 'descending' ? true : false;
                                $sort_by = $_SESSION['sort_criteria']['sort_by'];
                            }
                            ?>
                            <li class="nav-item d-inline">
                                <select name="order" class="custom-select custom-select-sm mt-1">
                                    <option {{ ($sc = session('sort_criteria')) ? ($sc['order'] == 'desc' ? 'selected' : '') : '' }} value="desc"> Descend </option>
                                    <option {{ ($sc = session('sort_criteria')) ? ($sc['order'] == 'asc' ? 'selected' : '') : '' }} value="asc"> Ascend </option>
                                </select>
                            </li>
                            <li class="nav-item d-inline">
                                <select name="sort_by" class="custom-select custom-select-sm mt-1">
                                    <option {{ ($sc = session('sort_criteria')) ? ($sc['sort_by'] == 'id' ? 'selected' : '') : '' }} value="id"> Item ID </option>
                                    <option {{ ($sc = session('sort_criteria')) ? ($sc['sort_by'] == 'created_at' ? 'selected' : '') : '' }} value="created_at"> Last Added </option>
                                    <option {{ ($sc = session('sort_criteria')) ? ($sc['sort_by'] == 'updated_at' ? 'selected' : '') : '' }} value="updated_at"> Updated </option>
                                    <option {{ ($sc = session('sort_criteria')) ? ($sc['sort_by'] == 'user_id' ? 'selected' : '') : '' }} value="user_id"> User ID </option>
                                    <option {{ ($sc = session('sort_criteria')) ? ($sc['sort_by'] == 'status' ? 'selected' : '') : '' }} value="status"> Status </option>
                                </select>
                            </li>
                            <li class="nav-item d-inline">
                                <input type="submit" class="btn btn-sm btn-outline-light mt-1" href="/task/sort" role="button" value="Sort" />
                            </li>
                        </form>
                        <!-- Authentication Links -->
                        @guest
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                        @if (Route::has('register'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                            </li>
                        @endif
                        @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('cabinet') }}"> Cabinet </a>
                                @can('edit_item')
                                <a class="dropdown-item" href="{{ route('home') }}"> Dashboard </a>
                                @endcan
                                @can('create_item')
                                <a class="dropdown-item" href="{{ route('items.create') }}"> Add Item </a>
                                @endcan
                                @can('categories')
                                    <a class="dropdown-item" href="{{ route('home') }}"> Add Category </a>
                                @endcan
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4 m-0">
            @yield('content')
        </main>
    </div>
    <footer class="container">
        <p>&copy; Acme Corporation <script>document.write(new Date().getFullYear())</script></p>
    </footer>
    @can('delete_item')
        @include('details.del_popup')
    @endcan
</body>
</html>
