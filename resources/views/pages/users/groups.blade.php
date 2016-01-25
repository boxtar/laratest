@extends('layouts.master')

@section('title', 'Groups')

@section('content')

    <h1 class="title">{{ $user->name }}'s Groups</h1>
    <hr>
    @if($groups->isEmpty())
        <p class="text-center">{{ $user->name }} isn't a member of any groups yet</p>
    @else
        <div class="small-container">
            <ul class="list-group">
                @foreach($groups as $group)
                <li class="list-group-item">
                    <a href="{{ action('GroupsController@show', ['groups' => $group->profile_link]) }}">
                        {{ $group->name }}
                    </a>
                </li>
                @endforeach
            </ul>
        </div>
    @endif

@endsection