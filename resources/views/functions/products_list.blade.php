@extends('layouts.app')

@section('content')
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                @auth
                    <table class="card-header">
                        <thead align="center">
                            @if(Auth::user()->userName == "rodneytai97")
                                <td>功能</td>
                            @endif    
                            <td>商品編號</td>
                            <td>商品</td>
                            <td>單位</td>
                            <td>單價</td>
                        </thead>
                        <tbody>
                            @for($i = 1; $i <= 10; $i++)
                                <tr align="center">
                                    @if(Auth::user()->userName == "rodneytai97")
                                        <td>a</td>
                                    @endif
                                    <td>b</td>
                                    <td>c</td>
                                    <td>d</td>
                                    <td>e</td>
                                </tr>
                            @endfor
                        </tbody>
                    </table>
                @endauth
                @guest
                    Please login motherfucker.
                @endguest
            </div>
        </div>
    </div>
</div>
@endsection
