@extends('layouts.master')

@section('title', 'Create A Group')

@section('content')

    <div class="title">Creating a Group</div>

    <div class="small-container">

        @include('errors.list')

        {!! Form::open(['action' => 'GroupsController@store']) !!}

            @include('pages.groups.partials.form', ['submitButtonText' => 'Create Group'])

        {!! Form::close() !!}
    </div>

@stop