@extends('layouts.app')

@section('content')
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<form method="post">
{{ csrf_field() }}
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header" align="center">{{ __('訂購資料') }}</div>
            
                <div class="card-body">
                    @auth
                    <table class=" table table-hover thead-light">
                        <thead align="center" class="thead-light">
                            <td>訂單編號</td>
                            <td>商品</td>
                            <td>單位</td>
                            <td align="right">單價</td>
                            <td align="right">數量</td>
                            <td align="right">金額</td>
                            <td>訂購者</td> 
                        </thead>
                        <tbody>
                            @foreach($details as $d)
                                <tr align="center">
                                    <td>{{ $d->orderId }}</td>
                                    <td>{{ $d->pName }}</td>
                                    <td>{{ $d->orderUnit }}</td>
                                    <td align="right">{{ $d->orderUnitPrice }}</td>
                                    <td align="right">{{ $d->orderAmount }}</td>
                                    <td align="right">{{ $d->orderTotal }}</td>
                                    <td>{{ $d->cusName }}</td>
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
</div>

<div class="pagination justify-content-center">
    {{ $details->render() }}
</div>
</form>
@endsection
