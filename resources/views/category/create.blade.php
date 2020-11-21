@extends('layouts.app')
@section('content')
    @include('layouts._userNavbar')
    @include('category._form', ['action' => 'store', 'title' => 'Add category', 'category' => $category])
@stop
