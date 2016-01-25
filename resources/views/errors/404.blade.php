@extends('layouts.master')

@section('title', 'Whoops')

@section('content')
    <h1 class="title">Uh Oh! 404'd</h1>
    <h4 class="text-center"><a href="{{ action('PagesController@getIndex') }}">You're drunk. Go Home</a></h4>
@endsection