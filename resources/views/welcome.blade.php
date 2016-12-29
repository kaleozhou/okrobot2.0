<!DOCTYPE html>

<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>OKROBOT</title>
        <style>
html, body {
    background-color: #fff;
    color: #636b6f;
    font-family: 'Raleway', sans-serif;
    font-weight: 100;
    height: 100vh;
    margin: 0;
}

            .full-height {
                height: 94vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
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
            }
            .footer {
                text-align: center;
            }

            .title {
                font-size: 50px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 12px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
    </head>
    <script src="/js/app.js"></script>
    <body>
        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
            <div class="top-right links">
                @if (Auth::check())
                <a href="{{ url('/home') }}">个人中心</a>
                <a href="{{ url('/help') }}">帮助</a>
                @else
                <a href="{{ url('/login') }}">登录</a>
                <a href="{{ url('/register') }}">注册</a>
                <a href="{{ url('/help') }}">帮助</a>
                @endif
            </div>
            @endif

            <div class="content">
                <div  class="title m-b-md">
                    <img class="img-responsive" src="images/logo_300.png"/>
                </div>
            </div>
        </div>
            <div class='footer'>
                {{config('app.copyright')}}
            </div>
    </body>
</html>
