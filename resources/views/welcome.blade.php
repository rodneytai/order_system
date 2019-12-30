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
                height: 103vh;
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
                font-size: 30px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }
            .m-b-md {
                margin-bottom: 30px;
            }
            .container {  
                display: grid;  
                grid-gap: 5px;  
                grid-template-columns: repeat(auto-fit, minmax(100px, 1fr));
                grid-template-rows: repeat(2, 100px);  
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
                <div class="title m-b-md" {{-- style="background-image: url('public/bg/bg.png'); background-repeat: no-repeat; background-position: left top;background-size: 100px 100px;" --}}>
                    <img src="{{ url('public/bg/bg.png') }}" alt="" style="background-repeat: no-repeat; background-position: left top;width: 10vw;">
                    簡易線上訂單
                </div>

                <div class="links container">
                    <a href="{{ url('/products_list') }}" style="background-image: url('public/bg/goods.png'); background-repeat: no-repeat; background-position: left;background-size: 30px 30px;">
                        {{-- <img src="{{ url('public/bg/goods.png') }}" alt="" style="background-repeat: no-repeat; background-position: left top;width:30%; height: 30%;"> --}}
                        商品列表
                    </a>
                    <a href="{{ url('/order') }}" style="background-image: url('public/bg/order.png'); background-repeat: no-repeat; background-position: left;background-size: 30px 30px;">訂購商品</a>
                    <a href="{{ url('/order_details') }}" style="background-image: url('public/bg/CART.png'); background-repeat: no-repeat; background-position: left;background-size: 30px 30px;">訂單資料</a>
                    <a href="{{ url('/delivery') }}" style="background-image: url('public/bg/delivery.png'); background-repeat: no-repeat; background-position: left;background-size: 30px 40px;">訂單狀態</a>
                    <a href="{{ url('/contact') }}" style="background-image: url('public/bg/contactus.png'); background-repeat: no-repeat; background-position: left;background-size: 30px 30px;">聯絡我們</a>
                </div>
                {{-- <table class="table table-responsive-m">
                    <tr >
                        <td class="links">
                            <a href="{{ url('/products_list') }}" style="display: flex; justify-content: center; width: 15vw;">
                                <img src="{{ url('public/bg/goods.png') }}" alt="" style="background-repeat: no-repeat; background-position: left top;width:30%; height: 30%;">商品列表
                            </a>
                        </td>
                        <td class="links">
                            <a href="{{ url('/order') }}" style="display: flex; justify-content: center; width: 15vw;">
                                <img src="{{ url('public/bg/order.png') }}" alt="" style="background-repeat: no-repeat; background-position: left top;width:30%; height: 30%;">下訂單
                            </a>
                        </td>
                        <td class="links">
                            <a href="{{ url('/order_details') }}" style="display: flex; justify-content: center; width: 15vw;">
                                <img src="{{ url('public/bg/CART.png') }}" alt="" style="background-repeat: no-repeat; background-position: left top;width:30%; height: 30%;">訂單資料
                            </a>
                    
                        </td>
                        <td class="links">
                            <a href="{{ url('/delivery') }}" style="display: flex; justify-content: center; width: 15vw;">  
                                <img src="{{ url('public/bg/delivery.png') }}" alt="" style="background-repeat: no-repeat; background-position: left top;width:30%; height: 30%;">訂單狀態
                            </a>
                    
                        </td>
                        <td class="links">
                            <a href="{{ url('/contact') }}" style="display: flex; justify-content: center; width: 15vw;">
                                <img src="{{ url('public/bg/contactus.png') }}" alt="" style="background-repeat: no-repeat; background-position: left top;width:30%; height: 30%;">聯絡我們
                            </a>
                        </td>
                    </tr>
                </table> --}}
            </div>
        </div>
    </body>
</html>
