@extends('layouts.app')

@section('content')
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script>
$(document).ready(function() { 
    var val = <?php echo json_encode($products); ?>;
    $( "#product_name" ).change(function () {
        var id = "";
        var unit = "";
        $( "#product_name option:selected" ).each(function() {
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
        });
    })
    
    .change();
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
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="cusName" class="col-md-4 col-form-label text-md-right">{{ __('客戶') }}</label>
                            <div class="col-md-6">
                                {{ Auth::user()->cusName }}
                            </div>
                        </div>
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('確定訂購') }}
                                </button>
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
