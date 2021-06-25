<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="_token" content="{{ csrf_token() }}">
    <meta name="base_url" content="{{ url('') }}">
    <title>{{ config('app.name') }}</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    
    {{-- fontawesome --}}
    <link href="{{ asset('/css/fontawesome.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/brands.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/solid.css') }}" rel="stylesheet">

    {{-- Toastr --}}
    <link rel="stylesheet" href="{{ asset('/styles/toastr.min.css') }}">

</head>