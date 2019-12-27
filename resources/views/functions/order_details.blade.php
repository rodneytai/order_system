@extends('layouts.app')

@section('content')
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script>
$(document).ready(function() { 
    var val = <?php echo json_encode($products); ?>;
    $( "#pName" ).change(function () {
        var id = "";
        var unit = "";
        var unitPrice = "";
        var qty = 0;
        $(this)
        $( "#pName option:selected" ).each(function() {
            $('#orderTotal').text(0);
            var qty = $('#edit_amount').val();
            $('#totalPrice').val(0);
            id = $( this ).val();
            console.log(id);
            var a = $.map(val, function(value, key){ //find id in array and get unit 
                if (value.pId == id) 
                    unit = value.pUnit;
                if (value.pId == id) 
                    unitPrice = value.pPrice;
            });
            var price = $.map(val, function(value, key){ //find id in array and get price
                if (value.pId == id) 
                    return value.pPrice;
            });
            $("#pName").closest('tr').find('.orderTotal').text(qty*price);
            $('.unit').val(unit);
            $('.unitprice').val(unitPrice);
            $('.totalPrice').val(qty*price);
            $('#edit_amount').on('input',function() {
                var qty = $('#edit_amount').val();
                $("#pName").closest('tr').find('.orderTotal').text(qty*price);
                $('.totalPrice').val(qty*price);
            });
        });
        $('#edit_amount').on('input',function() {
            var qty = $('#edit_amount').val();
            var price = $.map(val, function(value, key){ //find id in array and get price
                if (value.pId == id) 
                    return value.pPrice;
            });
            $("#pName").closest('tr').find('.orderTotal').text(qty*price);
            $('.totalPrice').val(qty*price);
        });
        $("#pName").closest('tr').find( ".orderUnit" ).text( unit );
        $("#pName").closest('tr').find( ".orderUnitPrice" ).text( unitPrice );
    })
    
    .change();
}); 
</script>
<form method="post">
{{ csrf_field() }}
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header" align="center">{{ __('訂購資料') }}</div>
            
                <div class="card-body">
                    @auth
                    <table class=" table table-hover thead-light table-responsive w-auto">
                        <thead align="center" class="thead-light">
                            @if(Auth::user()->auth == "admin")
                                <td>功能</td>
                            @endif    
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
                                <tr align="center" abd="{{ $d->orderId }}">
                                    @if(Auth::user()->auth == "admin")
                                        <td>
                                            @if(Request::has('edit'))
                                                @if(key(Request::input("edit")) == $d->orderId)
                                                    <input name="save[{{ $d->orderId }}]" type="submit" class="btn btn-primary btn-sm" value="存">
                                                    <input name="cancel "type="submit" class="btn btn-danger btn-sm" value="取消">
                                                @else
                                                    <input name="edit[{{ $d->orderId }}]" type="submit" class="btn btn-primary btn-sm" value="編輯">
                                                    <input name="delete[{{ $d->orderId }}]" type="submit" class="btn btn-danger btn-sm" value="刪除">
                                                @endif
                                            @else
                                                <input name="edit[{{ $d->orderId }}]" type="submit" class="btn btn-primary btn-sm" value="編輯">
                                                <input name="delete[{{ $d->orderId }}]" type="submit" class="btn btn-danger btn-sm" value="刪除">
                                            @endif
                                        </td>
                                    @endif
                                    <td>{{ $d->orderId }}</td>
                                    <td>
                                        @if(Request::has("edit"))
                                            @if(key(Request::input("edit")) == $d->orderId)
                                                <select name="pName" id="pName">
                                                    @foreach($products as $p)
                                                        @if($p->pName == $d->pName)
                                                            <option value="{{ $p->pId }}" selected>{{ $p->pName }}</option>
                                                        @else
                                                            <option value="{{ $p->pId }}">{{ $p->pName }}</option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                            @else
                                                {{ $d->pName }}
                                            @endif
                                        @else
                                            {{ $d->pName }}
                                        @endif
                                    </td>
                                    <td> {{-- 單位 --}}
                                        <span class="orderUnit">{{ $d->orderUnit }}</span>
                                        <input type="hidden" name="unit" class="unit">
                                    </td>
                                    <td align="right"> {{-- 單價 --}}
                                        <span class="orderUnitPrice">{{ $d->orderUnitPrice }}</span>
                                        <input type="hidden" name="unitprice" class="unitprice">
                                    </td>
                                    <td align="right">  {{-- 數量 --}}
                                        @if(Request::has("edit"))
                                            @if(key(Request::input("edit")) == $d->orderId)
                                                <input name="edit_amount" id="edit_amount" type="number" value="{{ $d->orderAmount }}">
                                            @else
                                                {{ $d->orderAmount }}
                                            @endif                                        
                                        @else
                                           {{ $d->orderAmount }}
                                        @endif
                                    </td>
                                    <td align="right"> {{-- 總額 --}}
                                        <span class="orderTotal">{{ $d->orderTotal }}</span>
                                        <input type="hidden" name="price" class="totalPrice">
                                    </td>
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
