@extends('layouts.master')

@section('title')
    Edit {!! $group->name !!}
@endsection

@section('content')

    <div class="title">Edit {!! $group->name !!}</div>

    <div class="small-container">

        @include('errors.list')

        {!! Form::model($group, ['method' => 'PATCH', 'action' => ['GroupsController@update', $group->profile_link]]) !!}

        @include('pages.groups.partials.form', ['submitButtonText' => 'Make Changes!'])

        {!! Form::close() !!}
    </div>

@stop