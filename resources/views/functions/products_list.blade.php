@extends('layouts.app')

@section('content')
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<!--  jquery script  -->
<script src="http://code.jquery.com/jquery-3.1.1.min.js"></script>
<!--  validation script  -->
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.1/dist/jquery.validate.min.js"></script>
<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
<script>
$(document).ready(function(){
    $.ajaxSetup({
        headers:{
            'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
        }
    });
    // SEARCH FUNCTION
    $("#search").keyup(function(){
        var text = $("#search").val();
        $.ajax({
            url: '{{ url("/products_list/search") }}',
            type: 'POST',
            data: {
                text: text
            },
            success:function(data){
                var products = data.products;
                var auth = data.auth;
                var trHTML = '';
                $.each(products.data, function (k, p) {
                    trHTML += '<tr align="center" id="pid_'+p.pId+'">'
                    if (auth) 
                    {
                        trHTML += '<td>';
                        trHTML += 
                            '<a href="javascript:void(0)" id="edit" data-id="' + p.pId + '" class="btn btn-primary btn-sm">編輯</a>'+
                            '<a href="javascript:void(0)" id="delete" data-id="' + p.pId + '" class="btn btn-danger btn-sm delete-p">刪除</a>';
                        trHTML += '</td>';
                    }
                    trHTML += '<td>' + p.pId + '</td>';
                    trHTML += '<td>' + p.pName + '</td>';
                    trHTML += '<td>' + p.pUnit + '</td>';
                    trHTML += '<td align=right>' + p.pPrice + '</td>';
                    trHTML += '</tr>';
                    $("#tbody").html(trHTML);
                });
            },
            error: function(data){
                console.log('Error', data);
            }
        })
    });
    //EDIT FUNCTION (POP OUT WINDOW)
    $('#tbody').on('click', '#edit', function () {
        var pId = $(this).data('id');
        $.get('{{ url('/products_list/edit') }}' + '/' +pId , function (data) {
            $('#userCrudModal').html("編輯商品");
            $('#btn-save').val("edit");
            $('#ajax-crud-modal').modal('show');
            $('#pId').val(pId);
            $('#edit_id').val(data[0].pId);
            $('#edit_name').val(data[0].pName);
            $('#edit_unit').val(data[0].pUnit);
            $('#edit_price').val(data[0].pPrice);
        })
    });
    //SAVE FUNCTION
    $('#btn-save').on('click', function(event){
        event.preventDefault();
        // var actionType = $('#btn-save').val();
        $('#btn-save').html('Sending..');
        var pid = $('#pId').val();
        $.ajax({
            url: '{{ url("/products_list/save") }}',
            data: {
                pId : $('#pId').val(),
                edit_id : $('#edit_id').val(),
                edit_name : $('#edit_name').val(),
                edit_unit : $('#edit_unit').val(),
                edit_price : $('#edit_price').val()
            },
            type: "POST",
            dataType: 'json',
            success: function (data) {
                var products = data.products;
                var auth = data.auth;
                var trHTML = '';
                    trHTML += '<tr align="center" id="pid_'+products[0].pId+'">'
                    if (auth) 
                    {
                        trHTML += '<td>';
                        trHTML += 
                            '<a href="javascript:void(0)" id="edit" data-id="' + products[0].pId + '" class="btn btn-primary btn-sm">編輯</a>'+
                            '<a href="javascript:void(0)" id="delete" data-id="' + products[0].pId + '" class="btn btn-danger btn-sm delete-p">刪除</a>';
                        trHTML += '</td>';
                    }
                    trHTML += '<td>' + products[0].pId + '</td>';
                    trHTML += '<td>' + products[0].pName + '</td>';
                    trHTML += '<td>' + products[0].pUnit + '</td>';
                    trHTML += '<td align=right>' + products[0].pPrice + '</td>';
                    trHTML += '</tr>';
                $("#pid_" + products[0].pId).replaceWith(trHTML);
                $('#userForm').trigger("reset");
                $('#ajax-crud-modal').modal('hide');
                $('#btn-save').html('Save Changes');
              },
            error: function (data) {
                console.log('Error:', data);
                $('#btn-save').html('Save Changes');
            }
        });
    })
    //DELETE FUNCTION
    $('#tbody').on('click', '.delete-p', function (event) {
        var pid = $(this).data("id");
        var con = confirm("確認刪除？");
        if(!con)
            event.preventDefault();
        else{
            $.ajax({
                type: 'DELETE',
                url: "{{ url('/products_list/delete') }}"+'/'+pid,
                success: function (data) {
                    $("#pid_" + pid).remove();
                },
                error: function (data) {
                    console.log('Error:', data);
                }
            });
        }
    });   
})

</script>
<form method="post">
{{ csrf_field() }}
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header" align="center">{{ __('商品列表') }}</div>
                @auth
                    <table class="table table-hover thead-light table-responsive-s .w-auto">
                        <div style="margin-left: 5px; margin-top: 5px; margin-bottom: 5px;">
                            <div>搜尋：<input type="text" id="search"></div>
                        </div>
                        <thead align="center" class="thead-light">
                            @if(Auth::user()->auth == "admin")
                                <td width="200px">功能</td>
                            @endif    
                            <td>商品編號</td>
                            <td>商品</td>
                            <td>單位</td>
                            <td align="right">單價</td>
                        </thead>
                        <tbody id="tbody">
                            @foreach($products as $p)
                                <tr align="center" id='pid_{{ $p->pId }}'>
                                    @if(Auth::user()->auth == "admin")
                                        <td>
                                           {{--  @if(Request::has('edit'))
                                                @if(key(Request::input("edit")) == $p->pId)
                                                    <input name="save[{{ $p->pId }}]" type="submit" class="btn btn-primary btn-sm" value="存">
                                                    <input name="cancel "type="submit" class="btn btn-danger btn-sm" value="取消">
                                                @else
                                                    <input name="edit[{{ $p->pId }}]" type="submit" class="btn btn-primary btn-sm" value="編輯">
                                                    <input name="delete[{{ $p->pId }}]" type="submit" class="btn btn-danger btn-sm" value="刪除">
                                                @endif
                                            @else --}}
                                                {{-- <input name="edit[{{ $p->pId }}]" type="submit" class="btn btn-primary btn-sm" value="編輯">
                                                <input name="delete[{{ $p->pId }}]" type="submit" class="btn btn-danger btn-sm" value="刪除"> --}}
                                                
                                            {{-- @endif --}}
                                            <a href="javascript:void(0)" id="edit" data-id="{{ $p->pId }}" class="btn btn-primary btn-sm">編輯</a>
                                            <a href="javascript:void(0)" id="delete" data-id="{{ $p->pId }}" class="btn btn-danger btn-sm delete-p">刪除</a>
                                        </td>
                                    @endif
                                    <td>
                                        {{-- @if(Request::has("edit"))
                                            @if(key(Request::input("edit")) == $p->pId)
                                                <input name="edit_id" type="text" value="{{ $p->pId }}">
                                            @else
                                                {{ $p->pId }}
                                            @endif
                                        @else --}}
                                            {{ $p->pId }}
                                        {{-- @endif --}}
                                    </td>
                                    <td>
                                       {{--  @if(Request::has("edit"))
                                            @if(key(Request::input("edit")) == $p->pId)
                                                <input name="edit_name" type="text" value="{{ $p->pName }}">
                                            @else
                                                {{ $p->pName }}
                                            @endif                                        
                                        @else --}}
                                            {{ $p->pName }}
                                        {{-- @endif --}}
                                    </td>
                                    <td>
                                        {{-- @if(Request::has("edit"))
                                            @if(key(Request::input("edit")) == $p->pId)
                                                <input name="edit_unit" type="text" value="{{ $p->pUnit }}">
                                            @else
                                                {{ $p->pUnit }}
                                            @endif                                        
                                        @else --}}
                                            {{ $p->pUnit }}
                                        {{-- @endif --}}
                                    </td>
                                    <td align="right">
                                        {{-- @if(Request::has("edit"))
                                            @if(key(Request::input("edit")) == $p->pId)
                                                <input name="edit_price" type="text" value="{{ $p->pPrice }}">
                                            @else
                                                {{ $p->pPrice }}
                                            @endif
                                        @else --}}
                                            {{ $p->pPrice }}
                                        {{-- @endif --}}
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
                <input type="hidden" name="pId" id="pId">
                {{-- PRODUCTS ID --}}
                <div class="form-group">
                    <label for="name" class="col-sm-4 control-label">商品編號</label>
                    <div class="col-sm-12">
                        <input type="text" class="form-control" id="edit_id" placeholder="輸入商品編號" value="" maxlength="50">
                    </div>
                </div>
                {{-- PRODUCTS NAME --}}
                <div class="form-group">
                    <label class="col-sm-2 control-label">商品</label>
                    <div class="col-sm-12">
                        <input type="text" class="form-control" id="edit_name" placeholder="輸入商品名稱" value="">
                    </div>
                </div>
                {{-- PRODUCTS UNIT --}}
                <div class="form-group">
                    <label class="col-sm-2 control-label">單位</label>
                    <div class="col-sm-12">
                        <input type="text" class="form-control" id="edit_unit" placeholder="輸入單位" value="">
                    </div>
                </div>
                {{-- PRODCUTS PRICE --}}
                <div class="form-group">
                    <label class="col-sm-2 control-label">單價</label>
                    <div class="col-sm-12">
                        <input type="text" class="form-control" id="edit_price" placeholder="輸入單價" value="">
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
<div class="pagination justify-content-center">
    {{ $products->render() }}
</div>
</form>
@endsection
