@if (Session::has('flash_notification.message'))
    <script>
        swal({
            title: '{{ Session::pull('flash_notification.title') }}',
            text: '{{ Session::pull('flash_notification.message') }}',
            type: '{{ Session::pull('flash_notification.level') }}',
            confirmButtonText: "Close",
            allowOutsideClick: true
        });
    </script>
@endif