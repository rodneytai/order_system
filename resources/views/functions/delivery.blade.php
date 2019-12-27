@extends('layouts.app')

@section('content')
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<form method="post">
{{ csrf_field() }}
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header" align="center">{{ __('訂單狀態') }}</div>
                @auth
                    <table class=" table table-hover thead-light table-responsive w-auto">
                        <thead align="center" class="thead-light">
                            @if(Auth::user()->auth == "admin")
                                <td>功能</td>
                            @endif
                            <td>出貨編號</td>
                            <td>訂單編號</td>
                            <td>出貨狀態</td>
                            <td>出貨時間(YYYY-MM-DD)</td>
                            <td>抵達時間(YYYY-MM-DD)</td>
                        </thead>
                        <tbody>
                            @foreach($delivery as $d)
                                <tr align="center">
                                    @if(Auth::user()->auth == "admin")
                                        <td>
                                            @if(Request::has("edit"))
                                                @if(key(Request::input("edit")) == $d->dId)
                                                    <input name="save[{{ $d->dId }}]" type="submit" class="btn btn-primary btn-sm" value="存">
                                                    <input name="cancel "type="submit" class="btn btn-danger btn-sm" value="取消">
                                                @else
                                                    <input name="edit[{{ $d->dId }}]" type="submit" class="btn btn-primary btn-sm" value="編輯">
                                                @endif
                                            @else
                                                <input name="edit[{{ $d->dId }}]" type="submit" class="btn btn-primary btn-sm" value="編輯">
                                            @endif
                                        </td>
                                    @endif
                                    <td>{{ $d->dId }}</td>
                                    <td>{{ $d->dOrderId }}</td>
                                    <td>
                                        @if(Request::has("edit"))
                                            @if(key(Request::input("edit")) == $d->dId)
                                                <select name="status">
                                                    @if($d->dStatus == "確認訂單中")
                                                        <option value="{{ $d->dStatus}}" selected>{{ $d->dStatus}}</option>
                                                        <option value="準備中">準備中</option>
                                                        <option value="待出貨">待出貨</option>
                                                        <option value="已出貨">已出貨</option>
                                                        <option value="已送達">已送達</option>
                                                    @elseif($d->dStatus == "準備中")
                                                        <option value="{{ $d->dStatus}}" selected>{{ $d->dStatus}}</option>
                                                        <option value="確認訂單中">確認訂單中</option>
                                                        <option value="待出貨">待出貨</option>
                                                        <option value="已出貨">已出貨</option>
                                                        <option value="已送達">已送達</option>
                                                    @elseif($d->dStatus == "待出貨")
                                                        <option value="{{ $d->dStatus}}" selected>{{ $d->dStatus}}</option>
                                                        <option value="確認訂單中">確認訂單中</option>
                                                        <option value="準備中">準備中</option>
                                                        <option value="已出貨">已出貨</option>
                                                        <option value="已送達">已送達</option>
                                                    @elseif($d->dStatus == "已出貨")
                                                        <option value="{{ $d->dStatus}}" selected>{{ $d->dStatus}}</option>
                                                        <option value="確認訂單中">確認訂單中</option>
                                                        <option value="準備中">準備中</option>
                                                        <option value="待出貨">待出貨</option>
                                                        <option value="已送達">已送達</option>
                                                    @elseif($d->dStatus == "已送達")
                                                        <option value="{{ $d->dStatus}}" selected>{{ $d->dStatus}}</option>
                                                        <option value="確認訂單中">確認訂單中</option>
                                                        <option value="準備中">準備中</option>
                                                        <option value="待出貨">待出貨</option>
                                                        <option value="已出貨">已出貨</option>
                                                    @endif
                                                </select>
                                            @else
                                                {{ $d->dStatus }}
                                            @endif
                                        @else
                                            {{ $d->dStatus }}
                                        @endif
                                    </td>
                                    <td>
                                        @if(Request::has("edit"))
                                            @if(key(Request::input("edit")) == $d->dId)
                                                <input name="dTime" type="text" value="{{ $d->dTime}}">
                                            @else
                                                {{ $d->dTime}}
                                            @endif
                                        @else
                                            {{ $d->dTime}}
                                        @endif
                                    </td>
                                    <td>
                                        @if(Request::has("edit"))
                                            @if(key(Request::input("edit")) == $d->dId)
                                                <input name="dArriveTime" type="text" value="{{ $d->dArriveTime }}">
                                            @else
                                                {{ $d->dArriveTime }}
                                            @endif
                                        @else
                                            {{ $d->dArriveTime }}
                                        @endif
                                    </td>
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
    {{ $delivery->render() }}
</div>
</form>
@endsection
