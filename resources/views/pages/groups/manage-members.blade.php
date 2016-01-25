@extends('layouts.master')

@section('title', 'Manage Members')

@section('content')

    <h1 class="title" xmlns:v-on="http://www.w3.org/1999/xhtml">{{ $group->name }}</h1>
    <h3 class="text-center">Manage Members</h3>

    <div class="small-container">

        @if(! $members->isEmpty())
        <ul class="list-group">
            @foreach($members as $member)

                <li class="list-group-item">{{ $member->name }}</li>

            @endforeach
        </ul>
        @else
            <h4 class="text-center">You have no Group buddies yet :(</h4>
        @endunless

        <br>

        <h3 class="text-center">Invite Some Peeps</h3>

        <form action="{{ action('GroupsController@manageMembers', ['groups' => $group->profile_link]) }}"
              method="post"
              role="search"
              id="search-users"
              v-on:submit.prevent="search">

            {{ csrf_field() }}

            <div class="form-group">
                <input type="search"
                       class="form-control"
                       id="search-users-typeahead"
                       v-model="name"
                       placeholder="Search..."
                       required="required">
            </div>

            <div class="form-group">
                <input type="submit" class="btn btn-primary pull-right" value="Send Invitation">

            </div>

            <input type="hidden"
                   value="{{ request()->root() }}"
                   v-model="request_uri">

            {!! Form::input('hidden', 't', \App\User::class) !!}
            {!! Form::input('hidden', 'c', 'profile_link') !!}

        </form>

    </div>

@endsection

@section('scripts')

    <script>
        new Vue({

            el: '#search-users',

            data: {
                name: '',
                profile_link: '',
                request_uri: ''
            },

            ready: function(){

                // Setup Bloodhound
                var users = new Bloodhound({
                    datumTokenizer: Bloodhound.tokenizers.obj.whitespace('name'),
                    queryTokenizer: Bloodhound.tokenizers.whitespace,
//                    prefetch: this.request_uri + '/hint-search?' + encodeURI('&t=\\App\\User'),
                    remote: {
                        url: this.request_uri + '/hint-search?q=%QUERY' + encodeURI('&t[]=\\App\\User'),
                        wildcard: '%QUERY'
                    }
                });

                // Initialize Bloodhound
                users.initialize();

                // Typeahead Setup
                $('#search-users-typeahead')
                        .typeahead({
                            hint: true,
                            highlight: true,
                            minLength: 1
                        },
                        {
                            source: users.ttAdapter(),
                            limit: 10,
                            displayKey: 'name'
                        })
                        .on('typeahead:select typeahead:autocomplete', function(e, suggestion){
                            this.name = suggestion.name;
                            this.profile_link = suggestion.profile_link;
                        }.bind(this));
            },

            methods: {
                search: function(){
                    var input = $('<input>').attr('type', 'hidden').attr('name', 'q');

                    $(input).val( this.profile_link ? this.profile_link : this.name );

                    $('form#search-users').append($(input)).submit();

                    return false;
                }
            }

        });
    </script>

@endsection