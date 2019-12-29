<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>簡易線上訂單</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <!-- Styles -->
        <style>
            html, body {
                /*background-color: #fff;*/
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 500;
                height: 100vh;
                margin: 0;
                background-image: url("public/bg/we-deliver.png");
                background-repeat: no-repeat;
                background-position: right bottom;
                background-color: #dfe3ee
            }

            .full-height {
                height: 100vh;
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

            .title {
                font-size: 95px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 25px;
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
    <body>
        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/home') }}">Home</a>
                    @else
                        <a href="{{ route('login') }}">Login</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}">Register</a>
                        @endif
                    @endauth
                </div>
            @endif

            <div class="content">
                <div class="title m-b-md" style="background-image: url('public/bg/bg.png'); background-repeat: no-repeat; background-position: left top;background-size: 100px 100px;">
                    簡易線上訂單
                </div>

                <div class="links">
                    <a href="{{ url('/products_list') }}" style="background-image: url('public/bg/goods.png'); background-repeat: no-repeat; background-position: left;background-size: 30px 30px;">商品列表</a>
                    <a href="{{ url('/order') }}" style="background-image: url('public/bg/order.png'); background-repeat: no-repeat; background-position: left;background-size: 30px 30px;">下訂單</a>
                    <a href="{{ url('/order_details') }}" style="background-image: url('public/bg/CART.png'); background-repeat: no-repeat; background-position: left;background-size: 28px 30px;">訂單資料</a>
                    <a href="{{ url('/delivery') }}" style="background-image: url('public/bg/delivery.png'); background-repeat: no-repeat; background-position: left;background-size: 28px 40px;">訂單狀態</a>
                    <a href="{{ url('/contact') }}" style="background-image: url('public/bg/contactus.png'); background-repeat: no-repeat; background-position: left;background-size: 28px 30px;">聯絡我們</a>
                </div>
            </div>
        </div>
    </body>
</html>
