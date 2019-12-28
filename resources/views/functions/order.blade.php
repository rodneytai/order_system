@extends('layouts.app')

@section('content')
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script>
$(document).ready(function() { 
    $.ajaxSetup({
        headers:{
            'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
        }
    });
    var val = <?php echo json_encode($products); ?>;
    $( "#product_name" ).change(function () {
        var id = "";
        var unit = "";
        $( "#product_name option:selected" ).each(function() {
            $('#qty').val('');
            $('#total').text(0);
            $('#totalPrice').val(0);
            id = $( this ).val();
            var a = $.map(val, function(value, key){ //find id in array and get unit 
                if (value.pId == id) 
                    unit = value.pUnit;
            });
        });
        $( "#pUnit" ).text( unit );
        $('#qty').on('input',function() {
            var qty = $('#qty').val();
            var price = $.map(val, function(value, key){ //find id in array and get price
                if (value.pId == id) 
                    return value.pPrice;
            });
            $('#total').text(qty*price);
            $('#totalPrice').val(qty*price);
        });
    })
    
    .change();

    $('#order').click(function(event){
        event.preventDefault();
        $.ajax({
            url: '{{ url("/order/order") }}',
            type: 'POST',
            data: {
                product_name : $('#product_name').val(),
                qty : $('#qty').val(),
                price : $('#totalPrice').val(),
                customer : $('input[name=customer]').val()
            },
            success:function(data){
                console.log(data);
                confirm("成功下訂單!");
            },
            error: function(data){
                console.log('Error', data);
            }
        });
    });
}); 
</script>
<form method="post">
{{ csrf_field() }}
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header" align="center">{{ __('訂購商品') }}</div>
            
                <div class="card-body">
                    @if($errors)
                        <span style="color: red; align-items: center;">{{ $errors->first('qty') }}</span>
                    @endif
                    @if($msg)
                        <span style="color: red; align-items: center;">{{ $msg }}</span>
                    @endif
                    <form method="POST">
                        @csrf
                        <div class="form-group row">
                            <label for="pName" class="col-md-4 col-form-label text-md-right">{{ __('商品') }}</label>
                            <div class="col-md-6">
                                <select name="product_name" id="product_name">
                                    @foreach($products as $p)
                                        <option value="{{ $p->pId }}">{{ $p->pName }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="pAmount" class="col-md-4 col-form-label text-md-right">{{ __('數量') }}</label>
                            <div class="col-md-6">
                                <input type="number" name="qty" id="qty"><span id="pUnit"></span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="pPrice" class="col-md-4 col-form-label text-md-right">{{ __('金額') }}</label>
                            <div class="col-md-6">
                                <span name="total" id="total"></span>NTD
                                <input type="hidden" name="price" id="totalPrice">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="cusName" class="col-md-4 col-form-label text-md-right">{{ __('客戶') }}</label>
                            <div class="col-md-6">
                                <input type="hidden" value="{{ Auth::user()->id }}" name="customer">
                                {{ Auth::user()->cusName }}
                            </div>
                        </div>
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="button" class="btn btn-primary" name="order" id="order" value="">{{ __('確定訂購') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</form>
<script>

</script>
@endsection
