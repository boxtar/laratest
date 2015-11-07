@extends('layouts.master')

@section('title', $title)

@section('content')
    <div class="content">
        <div class = "title">{{ $content }}</div>

        @include('errors.list')

        <div class="small-container">
            {!! Form::open(['route'=>'contact_submit', '']) !!}
                <div class="form-group">
                    {!! Form::label('name', 'Your Name') !!}
                    {!! Form::text('name', null,
                        array('required',
                              'class'=>'form-control',
                              'placeholder'=>'Your name')) !!}
                </div>

                <div class="form-group">
                    {!! Form::label('email', 'Your E-mail Address') !!}
                    {!! Form::text('email', null,
                        array('required',
                              'class'=>'form-control',
                              'placeholder'=>'Your e-mail address')) !!}
                </div>

                <div class="form-group">
                    {!! Form::label('body', 'Your Message') !!}
                    {!! Form::textarea('body', null,
                        array('required',
                              'class'=>'form-control',
                              'placeholder'=>'Your message')) !!}
                </div>

                <div class="form-group">
                    {!! Form::submit('Send',
                      array('class'=>'btn btn-primary')) !!}
                </div>
            {!! Form::close() !!}
        </div>
    </div>
@stop
