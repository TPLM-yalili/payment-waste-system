<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Kapays - Home</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <style>
    html,
    body {
        background-color: #fff;
        color: #636b6f;
        font-family: 'Raleway', sans-serif;
        font-weight: 100;
        height: 100vh;
        margin: 0;
    }

    .full-height {
        height: 100vh;
    }

    .flex-center {
        align-items: center;
        display: flex;
        justify-content: center;
        flex-direction: column;
    }

    .position-ref {
        position: relative;
    }

    .top-right {
        position: absolute;
        right: 10px;
        top: 18px;
    }

    .content {
        text-align: center;
        padding: 0 15px;
    }

    .title {
        font-size: 84px;
    }

    .links>a {
        color: #636b6f;
        padding: 10px 15px;
        font-size: 14px;
        font-weight: 600;
        letter-spacing: .1rem;
        text-decoration: none;
        text-transform: uppercase;
        display: inline-block;
    }

    .m-b-md {
        margin-bottom: 30px;
    }

    /* Responsive design for mobile */
    @media (max-width: 768px) {
        .title {
            font-size: 48px;
        }

        .links>a {
            font-size: 12px;
            padding: 8px 10px;
        }

        .top-right {
            right: 5px;
            top: 10px;
        }
    }

    @media (max-width: 480px) {
        .title {
            font-size: 36px;
        }

        .content {
            padding: 0 10px;
        }

        .links>a {
            font-size: 10px;
            padding: 6px 8px;
        }

        .top-right {
            right: 5px;
            top: 8px;
        }
    }
    </style>
</head>

<body>
    <div class="flex-center position-ref full-height">

        @if (Route::has('login') && Auth::check())
        <div class="top-right links">
            <a href="{{ route('dashboard') }}">Dashboard</a>
        </div>
        @elseif (Route::has('login') && !Auth::check())
        <div class="top-right links">
            <a href="{{ url('/login') }}">Login</a>
        </div>
        @endif

        <div class="content">
            <div class="title m-b-md">
                <x-application-logo src="{{ asset('images/kapayss.png') }}" alt="Kapays Logo"
                    style="max-width: 100%; height: auto;" />
            </div>

            <div class="links">
                <a href="https://user-manual.my.canva.site/copy-of-manual-book">Buku Petunjuk</a>
                <a href="https://laracasts.com">Tentang Pengembang</a>
            </div>
        </div>
    </div>
</body>

</html>