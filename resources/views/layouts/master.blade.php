<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<title>MVC | @yield('title')</title>
		<link href="https://fonts.googleapis.com/css?family=Lato:100, 400" rel="stylesheet" type="text/css">
		<link href="{{ URL::asset('css/stylesheet.css') }}" rel="stylesheet">
	</head>
	<body>
		<div class="container-fluid">
			@include('layouts.partials.navbar')
		</div>
		<br/>
		<div class = "container">

			@yield('content')

		</div>

        <script src="{{ URL::asset('js/script.js') }}"></script>

        {{-- activate bootstrap modal on any session flashed message with overlay set --}}
        {{--<script>
            $('#flash-overlay-modal').modal();
        </script>--}}

		@yield('footer')

		{{--Using SweetAlert Flash Messaging--}}
		@include('layouts.flash')

	</body>

</html>