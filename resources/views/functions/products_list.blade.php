@extends('layouts.app')

@section('content')
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<form method="post">
{{ csrf_field() }}
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header" align="center">{{ __('商品列表') }}</div>
                @auth
                    <table class=" table table-hover thead-light">
                        <thead align="center" class="thead-light">
                            @if(Auth::user()->auth == "admin")
                                <td width="200px">功能</td>
                            @endif    
                            <td>商品編號</td>
                            <td>商品</td>
                            <td>單位</td>
                            <td align="right">單價</td>
                        </thead>
                        <tbody>
                            @foreach($products as $p)
                                <tr align="center">
                                    @if(Auth::user()->auth == "admin")
                                        <td>
                                            @if(Request::has('edit'))
                                                @if(key(Request::input("edit")) == $p->pId)
                                                    <input name="save[{{ $p->pId }}]" type="submit" class="btn btn-primary btn-sm" value="存">
                                                    <input name="cancel "type="submit" class="btn btn-danger btn-sm" value="取消">
                                                @else
                                                    <input name="edit[{{ $p->pId }}]" type="submit" class="btn btn-primary btn-sm" value="編輯">
                                                    <input name="delete[{{ $p->pId }}]" type="submit" class="btn btn-danger btn-sm" value="刪除">
                                                @endif
                                            @else
                                                <input name="edit[{{ $p->pId }}]" type="submit" class="btn btn-primary btn-sm" value="編輯">
                                                <input name="delete[{{ $p->pId }}]" type="submit" class="btn btn-danger btn-sm" value="刪除">
                                            @endif
                                        </td>
                                    @endif
                                    <td>
                                        @if(Request::has("edit"))
                                            @if(key(Request::input("edit")) == $p->pId)
                                                <input name="edit_id" type="text" value="{{ $p->pId }}">
                                            @else
                                                {{ $p->pId }}
                                            @endif
                                        @else
                                            {{ $p->pId }}
                                        @endif
                                    </td>
                                    <td>
                                        @if(Request::has("edit"))
                                            @if(key(Request::input("edit")) == $p->pId)
                                                <input name="edit_name" type="text" value="{{ $p->pName }}">
                                            @else
                                                {{ $p->pName }}
                                            @endif                                        
                                        @else
                                            {{ $p->pName }}
                                        @endif
                                    </td>
                                    <td>
                                        @if(Request::has("edit"))
                                            @if(key(Request::input("edit")) == $p->pId)
                                                <input name="edit_unit" type="text" value="{{ $p->pUnit }}">
                                            @else
                                                {{ $p->pUnit }}
                                            @endif                                        
                                        @else
                                            {{ $p->pUnit }}
                                        @endif
                                    </td>
                                    <td align="right">
                                        @if(Request::has("edit"))
                                            @if(key(Request::input("edit")) == $p->pId)
                                                <input name="edit_price" type="text" value="{{ $p->pPrice }}">
                                            @else
                                                {{ $p->pPrice }}
                                            @endif
                                        @else
                                            {{ $p->pPrice }}
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
    {{ $products->render() }}
</div>
</form>
@endsection
