<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title }}</title>
    <link rel="stylesheet" href="{{ asset('/assets/stisla/css/bootstrap.min.css') }}" />
    @stack('general-css')

    <link rel="stylesheet" href="{{ asset('/assets/stisla/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('/assets/stisla/css/components.css') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body style="background-color: white">

    <div>
        {{ $slot }}
    </div>


    <!-- General JS Scripts -->
    <script src="{{ asset('/assets/midragon/select2/jquery.min.js') }}"></script>
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script> --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.nicescroll/3.7.6/jquery.nicescroll.min.js"></script>
    @stack('js-libraries')
    @stack('scripts')
</body>

</html>
