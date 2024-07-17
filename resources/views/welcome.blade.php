<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>moteur</title>
    <!-- Fonts -->
    <link rel="stylesheet" href="{{asset('css/app.css')}}">

    <style>
        .btn-bar{
            background-color: white;
            color: #121212;
            padding: 5px  15px;
            border-radius: 5px;
            font-weight: bold
            border: none;
        }
        .btn-bar:hover{
            background-color: #505050;
            color: #c1c1c1;
        }
    </style>
</head>

<body>
    
        @if (Route::has('login'))
            <nav class="nav-bar">
                <div>
                    @auth
                    <a href="{{ url('/dashboard') }}"><button class="btn-bar">@lang('content.dashboard')</button> </a>
                    @else
                     <a href="{{ route('login') }}"> <button class="btn-bar"> @lang('content.login') </button></a>
                             @if (Route::has('register'))
                                <a  href="{{ route('register') }}"> <button class="btn-bar"> @lang('content.register') </button></a>
                            @endif
                    @endauth
                </div>
            @include('language-switch')
            </nav>
        @endif

</body>
</html>