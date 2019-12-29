@extends('layouts.app')

@section('content')
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<!--  jquery script  -->
<script src="http://code.jquery.com/jquery-3.1.1.min.js"></script>

<script>
$(document).ready(function() { 
    var val = <?php echo json_encode($products); ?>;
    $.ajaxSetup({
        headers:{
            'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
        }
    });
    $( "#pName" ).change(function () {
        var id = "";
        var unit = "";
        var unitPrice = "";
        var qty = 0;
        $( "#pName option:selected" ).each(function() {
            $('#totalPrice').text(0);
            var qty = $('#edit_amount').val();
            $('#price').val(0);
            id = $( this ).val();
            var a = $.map(val, function(value, key){ //find id in array and get unit 
                if (value.pId == id) {
                    unit = value.pUnit;
                    unitPrice = value.pPrice;
                }
            });
            var price = $.map(val, function(value, key){ //find id in array and get price
                if (value.pId == id) 
                    return value.pPrice;
            });
            $('#totalPrice').text(qty*price);
            $('#editU').val(unit);
            $('#editUP').val(unitPrice);
            $('#price').val(qty*price);
            $('#edit_amount').on('input',function() {
                var qty = $('#edit_amount').val();
                $('#totalPrice').text(qty*price);
                $('#price').val(qty*price);
            });
        });
        $('#edit_amount').on('input',function() {
            var qty = $('#edit_amount').val();
            var price = $.map(val, function(value, key){ //find id in array and get price
                if (value.pId == id) 
                    return value.pPrice;
            });
            $('#totalPrice').text(qty*price);
            $('#price').val(qty*price);
        });
        $( "#edit_unit" ).text( unit );
        $( "#edit_unitPrice" ).text( unitPrice );
    })
    
    .change();
    //EDIT FUNCTION (POP OUT WINDOW)
    $('#tbody').on('click', '#edit', function () {
        var dId = $(this).data('id');
        $.get('{{ url('/order_details/edit') }}' + '/' +dId , function (data) {
            $('#userCrudModal').html("訂購資料");
            $('#btn-save').val("edit");
            $('#ajax-crud-modal').modal('show');
            $('#dId').val(dId);
            $("#pName").val(data[0].orderGoods); //option select goods
            $('#edit_unit').html(data[0].orderUnit); //show unit
            $('#editU').val(data[0].orderUnit); //store unit
            $('#edit_unitPrice').html(data[0].orderUnitPrice); //show unit price
            $('#editUP').val(data[0].orderUnitPrice); //store unit price
            $('#edit_amount').val(data[0].orderAmount); //show and store amount
            $('#totalPrice').html(data[0].orderTotal) //show total price 
            $('#price').val(data[0].orderTotal) //store total peice
            // console.log(data[0]);
        })
    });
    //SAVE FUNCTION
    $('#btn-save').on('click', function(event){
        event.preventDefault();
        // var actionType = $('#btn-save').val();
        $('#btn-save').html('Sending..');
        var dId = $(this).data('id');
        $.ajax({
            url: '{{ url("/order_details/save") }}',
            data: {
                dId : $('#dId').val(),
                pName : $('#pName').val(),
                edit_unit : $('#editU').val(),
                edit_unitPrice : $('#editUP').val(),
                edit_amount : $('#edit_amount').val(),
                price : $('#price').val()
            },
            type: "POST",
            dataType: 'json',
            success: function (data) {
                var d = data.details;
                var auth = data.auth;
                var trHTML = '';
                    trHTML += '<tr align="center" id="pid_'+d[0].orderId+'">'
                    if (auth) 
                    {
                        trHTML += '<td>';
                        trHTML += 
                            '<a href="javascript:void(0)" id="edit" data-id="' + d[0].orderId + '" class="btn btn-primary btn-sm">編輯</a>'+
                            '<a href="javascript:void(0)" id="delete" data-id="' + d[0].orderId + '" class="btn btn-danger btn-sm delete-p">刪除</a>';
                        trHTML += '</td>';
                    }
                    trHTML += '<td>' + d[0].orderId + '</td>';
                    trHTML += '<td>' + d[0].pName + '</td>';
                    trHTML += '<td>' + d[0].orderUnit + '</td>';
                    trHTML += '<td align=right>' + d[0].orderUnitPrice + '</td>';
                    trHTML += '<td align=right>' + d[0].orderAmount + '</td>';
                    trHTML += '<td align=right>' + d[0].orderTotal + '</td>';
                    trHTML += '<td>' + d[0].cusName + '</td>';
                    trHTML += '</tr>';
                $("#dId_" + d[0].orderId).replaceWith(trHTML);
                $('#userForm').trigger("reset");
                $('#ajax-crud-modal').modal('hide');
                $('#btn-save').html('Save Changes');
              },
            error: function (data) {
                console.log('Error:', data);
                $('#btn-save').html('Save Changes');
            }
        });
    });
    //DELETE FUNCTION
    $('#tbody').on('click', '.delete-p', function (event) {
        var did = $(this).data("id");
        console.log(did);
        var con = confirm("確認刪除？");
        if(!con)
            event.preventDefault();
        else{
            $.ajax({
                type: 'DELETE',
                url: "{{ url('/order_details/delete') }}"+'/'+did,
                success: function (data) {
                    console.log(data);
                    $("#dId_" + did).remove();
                },
                error: function (data) {
                    console.log('Error:', data);
                }
            });
        }
    });   
    // SEARCH FUNCTION
    $("#search").keyup(function(){
        var text = $("#search").val();
        $.ajax({
            url: '{{ url("/order_details/search") }}',
            type: 'POST',
            data: {
                text: text
            },
            success:function(data){
                var d = data.details;
                var auth = data.auth;
                var trHTML = '';
                console.log(data);
                $.each(d.data, function (k, p) {
                    trHTML += '<tr align="center" id="pid_'+p.orderId+'">'
                    if (auth) 
                    {
                        trHTML += '<td>';
                        trHTML += 
                            '<a href="javascript:void(0)" id="edit" data-id="' + p.orderId + '" class="btn btn-primary btn-sm">編輯</a>'+
                            '<a href="javascript:void(0)" id="delete" data-id="' + p.orderId + '" class="btn btn-danger btn-sm delete-p">刪除</a>';
                        trHTML += '</td>';
                    }
                    trHTML += '<td>' + p.orderId + '</td>';
                    trHTML += '<td>' + p.pName + '</td>';
                    trHTML += '<td>' + p.orderUnit + '</td>';
                    trHTML += '<td align=right>' + p.orderUnitPrice + '</td>';
                    trHTML += '<td align=right>' + p.orderAmount + '</td>';
                    trHTML += '<td align=right>' + p.orderTotal + '</td>';
                    trHTML += '<td>' + p.cusName + '</td>';
                    trHTML += '</tr>';
                    $("#tbody").html(trHTML);
                });
            },
            error: function(data){
                console.log('Error', data);
            }
        })
    });
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
                    <table class=" table table-hover thead-light table-responsive-l .w-auto">
                        <div style="margin-left: 5px; margin-top: 5px; margin-bottom: 5px;">
                            <div>搜尋：<input type="text" id="search" placeholder="請輸入訂單編號"></div>
                        </div>
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
                        <tbody id="tbody">
                            @foreach($details as $d)
                                <tr align="center" id="dId_{{ $d->orderId }}">
                                    @if(Auth::user()->auth == "admin")
                                        <td>
                                            {{-- @if(Request::has('edit'))
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
                                            @endif --}}
                                            <a href="javascript:void(0)" id="edit" data-id="{{ $d->orderId }}" class="btn btn-primary btn-sm">編輯</a>
                                            <a href="javascript:void(0)" id="delete" data-id="{{ $d->orderId }}" class="btn btn-danger btn-sm delete-p">刪除</a>
                                        </td>
                                    @endif
                                    <td>{{ $d->orderId }}</td>
                                    <td>
                                        {{-- @if(Request::has("edit"))
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
                                        @else --}}
                                            {{ $d->pName }}
                                        {{-- @endif --}}
                                    </td>
                                    <td> {{-- 單位 --}}
                                        <span class="orderUnit">{{ $d->orderUnit }}</span>
                                        {{-- <input type="hidden" name="unit" class="unit"> --}}
                                    </td>
                                    <td align="right"> {{-- 單價 --}}
                                        <span class="orderUnitPrice">{{ $d->orderUnitPrice }}</span>
                                        {{-- <input type="hidden" name="unitprice" class="unitprice"> --}}
                                    </td>
                                    <td align="right">  {{-- 數量 --}}
                                        {{-- @if(Request::has("edit"))
                                            @if(key(Request::input("edit")) == $d->orderId)
                                                <input name="edit_amount" id="edit_amount" type="number" value="{{ $d->orderAmount }}">
                                            @else
                                                {{ $d->orderAmount }}
                                            @endif                                        
                                        @else --}}
                                           {{ $d->orderAmount }}
                                        {{-- @endif --}}
                                    </td>
                                    <td align="right"> {{-- 總額 --}}
                                        <span>{{ $d->orderTotal }}</span>
                                        <input type="hidden" name="price">
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
{{-- EDIT POP OUT WINDOW --}}
<div class="modal fade" id="ajax-crud-modal" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title" id="userCrudModal"></h4>
        </div>
        <div class="modal-body">
            <form id="userForm"  class="form-horizontal">
                {{ csrf_field() }}
                <input type="hidden" name="dId" id="dId">
                {{-- PRODUCTS NAME --}}
                <div class="form-group">
                    <label class="col-sm-2 control-label">{{ __('商品') }}</label>
                    <div class="col-md-6">
                        <select name="pName" id="pName">
                            @foreach($products as $p)
                                <option value="{{ $p->pId }}">{{ $p->pName }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                {{-- PRODCUTS PRICE --}}
                <div class="form-group">
                    <label class="col-sm-2 control-label">單價</label>
                    <div class="col-sm-12">
                        <span id="edit_unitPrice"></span>
                        {{-- store unit price --}}
                        <input type="hidden" class="form-control" id="editUP" value="">
                    </div>
                </div>
                {{-- PRODUCTS AMOUNT --}}
                <div class="form-group">
                    <label class="col-sm-2 control-label">數量</label>
                    <div class="col-sm-6">
                        <div style="display: inline-block;">
                            <input type="number" class="form-control" id="edit_amount" placeholder="輸入數量" value="">
                        </div>
                        {{-- 單位 --}}
                        <span id="edit_unit"></span>
                        {{-- store unit --}}
                        <input type="hidden" class="form-control" id="editU" value=""> 

                    </div>
                </div>
                {{-- TOTAL PRICE --}}
                <div class="form-group">
                    <label class="col-sm-2 control-label">金額</label>
                    <div class="col-sm-12">
                        <span class='orderTotal' id="totalPrice"></span>
                        <input type="hidden" class="form-control totalPrice" id="price" value="">
                    </div>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-primary" id="btn-save" value="create">存</button>
        </div>
    </div>
  </div>
</div>
{{--  --}}
<div class="pagination justify-content-center">
    {{ $details->render() }}
</div>
</form>
@endsection
