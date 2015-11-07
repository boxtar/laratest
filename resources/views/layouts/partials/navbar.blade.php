<nav class="navbar navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/">Laravel Tutorials</a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
            <ul class="nav navbar-nav">
                <li>{!! link_to_action('UsersController@index', 'Users') !!}</li>
                <li>{!! link_to_action('GroupsController@index', 'Groups') !!}</li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                @if($user)
                    <li> {!! link_to_action('UsersController@show', $user->name, [$user->profile_link]) !!}  </li>
                    <li>{!! link_to_action('Auth\AuthController@getLogout', 'Log Out') !!}</li>
                @else
                    <li>{!! link_to_action('Auth\AuthController@getLogin', 'Log In') !!}</li>
                    <li>{!! link_to_action('Auth\AuthController@getRegister', 'Sign Up') !!}</li>
                @endif
            </ul>
        </div><!--/.nav-collapse -->
    </div>
</nav>