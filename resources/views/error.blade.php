@extends('layouts.app')
@section('content')
<style>
.full-height {
    height: 75vh;
}
.flex-center {
    align-items: center;
    display: flex;
    justify-content: center;
}
.position-ref {
    position: relative;
}
.code {
    border-right: 2px solid;
    font-size: 26px;
    padding: 0 15px 0 15px;
    text-align: center;
}
.message {
    color: firebrick;
    font-size: 18px;
    text-align: center;
    padding: 10px;
}
</style>
<div class="flex-center position-ref full-height">
    <div class="code">Error</div>
    <div class="message">{{ session('message') }}</div>
</div>
@endsection
