@extends('layouts.app')
@section('content')
    @include('layouts._userNavbar')
    @include('transaction._form', ['action' => 'store', 'title' => 'Add transaction'])
@stop
