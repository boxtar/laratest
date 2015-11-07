<!DOCTYPE html>
<html lang="en">
	<head>
		<base href="http://laravel.dev">
		<meta charset="UTF-8">
		<title>MVC | @yield('title')</title>
		<link href="https://fonts.googleapis.com/css?family=Lato:100, 400" rel="stylesheet" type="text/css">
		<link href="css/stylesheet.css" rel="stylesheet">
	</head>
	<body>
		<div class="container-fluid">
			@include('layouts.partials.navbar')
		</div>
		<br/>
		<div class = "container">
			{{-- Section for Session Flashing --}}
            <div class="row">
                <div class="col-sm-offset-4 col-sm-4">
					{{-- Laracasts Flash package --}}
					@include('flash::message')
				</div>
            </div>

			@yield('content')
		</div>

        <script src="js/script.js"></script>

        {{-- activate bootstrap modal on any session flashed message with overlay set --}}
        <script>
            $('#flash-overlay-modal').modal();
        </script>

		@yield('footer')

	</body>

</html>