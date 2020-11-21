@extends('layouts.app')
@section('content')
    @include('layouts._userNavbar')
    @include('category._form', ['action' => 'update', 'title' => 'Edit category', 'category' => $category])
@stop
