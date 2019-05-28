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
                            @foreach($products as $p)
                                <tr align="center">
                                    <td>
                                        <button type="button" class="btn btn-primary btn-sm" value="{{ $p->pId }}">編輯</button>
                                        <button type="button" class="btn btn-danger btn-sm" value="{{ $p->pId }}">刪除</button>
                                    </td>
                                    <td>{{ $p->pId }}</td>
                                    <td>{{ $p->pName }}</td>
                                    <td>{{ $p->pUnit }}</td>
                                    <td align="right">{{ $p->pPrice }}</td>
                                </tr>
                            @endforeach
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
<div class="pagination justify-content-center">
    {{ $products->render() }}
</div>
@endsection
