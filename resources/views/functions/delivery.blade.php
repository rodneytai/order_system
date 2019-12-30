@extends('layouts.app')

@section('content')
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<!--  jquery script  -->
{{-- <script src="http://code.jquery.com/jquery-3.1.1.min.js"></script> --}}
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.3/moment.min.js"></script>
<script>
$(document).ready(function() { 
    $.ajaxSetup({
        headers:{
            'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
        }
    });
//EDIT FUNCTION (POP OUT WINDOW)
    $('#tbody').on('click', '#edit', function () {
        var dId = $(this).data('id');
        $.get('{{ url('/delivery/edit') }}' + '/' +dId , function (data) {
            $('#userCrudModal').html("訂購狀態");
            $('#btn-save').val("edit");
            $('#ajax-crud-modal').modal('show');
            $('#dId').val(dId);
            $('#ID').html(dId);
            $('#dOrderId').html(data[0].dOrderId);
            $('#dOrderId2').val(data[0].dOrderId);
            $('#status').val(data[0].dStatus);
            $('input[name=dTime]').val(data[0].dTime);
            $('input[name=dArriveTime').val(data[0].dArriveTime);
        })
    });
    //SAVE FUNCTION
    $('#btn-save').on('click', function(event){
        event.preventDefault();
        // var actionType = $('#btn-save').val();
        $('#btn-save').html('Sending..');
        var dId = $(this).data('id');
        $.ajax({
            url: '{{ url("/delivery/save") }}',
            data: {
                dId : $('#dId').val(),
                dOrderId : $('#dOrderId2').val(),
                status : $('#status').val(),
                dTime : $('#dTime1').val(),
                dArriveTime : $('#dArriveTime1').val(),
            },
            type: "POST",
            dataType: 'json',
            success: function (data) {
                var d = data.delivery;
                var auth = data.auth;
                var trHTML = '';
                    trHTML += '<tr align="center" id="did_'+d[0].dId+'">'
                    if (auth) 
                    {
                        trHTML += '<td>';
                        trHTML += 
                            '<a href="javascript:void(0)" id="edit" data-id="' + d[0].dId + '" class="btn btn-primary btn-sm">編輯</a>';
                        trHTML += '</td>';
                    }
                    trHTML += '<td>' + d[0].dId + '</td>';
                    trHTML += '<td>' + d[0].dOrderId + '</td>';
                    trHTML += '<td>' + d[0].dStatus + '</td>';
                    trHTML += '<td>' + d[0].dTime + '</td>';
                    trHTML += '<td>' + d[0].dArriveTime + '</td>';
                    trHTML += '</tr>';
                $("#did_" + d[0].dId).replaceWith(trHTML);
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
    // SEARCH FUNCTION
    $("#search").keyup(function(){
        var text = $("#search").val();
        $.ajax({
            url: '{{ url("/delivery/search") }}',
            type: 'POST',
            data: {
                text: text
            },
            success:function(data){
                var d = data.delivery;
                var auth = data.auth;
                var trHTML = '';
                $.each(d.data, function (k, p) {
                    trHTML += '<tr align="center" id="did_'+p.dId+'">'
                    if (auth) 
                    {
                        trHTML += '<td>';
                        trHTML += 
                            '<a href="javascript:void(0)" id="edit" data-id="' + p.dId + '" class="btn btn-primary btn-sm">編輯</a>';
                        trHTML += '</td>';
                    }
                    trHTML += '<td>' + p.dId + '</td>';
                    trHTML += '<td>' + p.dOrderId + '</td>';
                    trHTML += '<td>' + p.dStatus + '</td>';
                    if (p.dTime != null) 
                        trHTML += '<td>' + p.dTime + '</td>';
                    else
                        trHTML += '<td>' + " " + '</td>';
                    if(p.dArriveTime != null)
                        trHTML += '<td>' + p.dArriveTime + '</td>';
                    else
                        trHTML += '<td>' + " " + '</td>';
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
                <div class="card-header" align="center">{{ __('訂單狀態') }}</div>
                @auth
                    <table class=" table table-hover thead-light table-responsive-xl .w-auto">
                        <div style="margin-left: 5px; margin-top: 5px; margin-bottom: 5px;">
                            <div>搜尋：<input type="text" id="search" placeholder="請輸入訂單編號"></div>
                        </div>
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
                        <tbody id="tbody">
                            @foreach($delivery as $d)
                                <tr align="center" id="did_{{ $d->dId }}">
                                    @if(Auth::user()->auth == "admin")
                                        <td>
                                            {{-- @if(Request::has("edit"))
                                                @if(key(Request::input("edit")) == $d->dId)
                                                    <input name="save[{{ $d->dId }}]" type="submit" class="btn btn-primary btn-sm" value="存">
                                                    <input name="cancel "type="submit" class="btn btn-danger btn-sm" value="取消">
                                                @else
                                                    <input name="edit[{{ $d->dId }}]" type="submit" class="btn btn-primary btn-sm" value="編輯">
                                                @endif
                                            @else --}}
                                                {{-- <input name="edit[{{ $d->dId }}]" type="submit" class="btn btn-primary btn-sm" value="編輯">
                                            @endif --}}
                                            <a href="javascript:void(0)" id="edit" data-id="{{ $d->dId }}" class="btn btn-primary btn-sm">編輯</a>
                                        </td>
                                    @endif
                                    <td>{{ $d->dId }}</td>
                                    <td>{{ $d->dOrderId }}</td>
                                    <td>
                                        {{-- @if(Request::has("edit"))
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
                                            @else --}}
                                                {{-- {{ $d->dStatus }}
                                            @endif
                                        @else --}}
                                            {{ $d->dStatus }}
                                        {{-- @endif --}}
                                    </td>
                                    <td>
                                        {{-- @if(Request::has("edit"))
                                            @if(key(Request::input("edit")) == $d->dId)
                                                <input name="dTime" type="text" value="{{ $d->dTime}}">
                                            @else
                                                {{ $d->dTime}}
                                            @endif
                                        @else --}}
                                            {{ $d->dTime}}
                                        {{-- @endif --}}
                                    </td>
                                    <td>
                                        {{-- @if(Request::has("edit"))
                                            @if(key(Request::input("edit")) == $d->dId)
                                                <input name="dArriveTime" type="text" value="{{ $d->dArriveTime }}">
                                            @else
                                                {{ $d->dArriveTime }}
                                            @endif
                                        @else --}}
                                            {{ $d->dArriveTime }}
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
                <input type="hidden" name="dId" id="dId">
                {{-- DELIVERY ID --}}
                <div class="form-group">
                    <label class="col-sm-4 control-label">{{ __('出貨編號') }}</label>
                    <div class="col-md-6">
                        <span id="ID"></span>
                    </div>
                </div>
                {{-- ORDER ID --}}
                <div class="form-group">
                    <label class="col-sm-4 control-label">訂單編號</label>
                    <div class="col-sm-12">
                        <span id="dOrderId"></span>
                        {{-- store ORDER ID --}}
                        <input type="hidden" class="form-control" id="dOrderId2" value="">
                    </div>
                </div>
                {{-- DELIVERY STATUS --}}
                <div class="form-group">
                    <label class="col-sm-4 control-label">出貨狀態</label>
                    <div class="col-sm-6">
                        <select name="status" id="status">
                            <option value="確認訂單中">確認訂單中</option>
                            <option value="準備中">準備中</option>
                            <option value="待出貨">待出貨</option>
                            <option value="已出貨">已出貨</option>
                            <option value="已送達">已送達</option>
                        </select>
                    </div>
                </div>
                {{-- DELIVERY TIME --}}
                <div class="form-group">
                    <label class="col-sm-4 control-label">出貨時間</label>
                    <div class="col-sm-12">
                        <input name="dTime" id="dTime1" type="date" value="">
                    </div>
                </div>
                {{-- ARRIVE TIME --}}
                <div class="form-group">
                    <label class="col-sm-4 control-label">抵達時間</label>
                    <div class="col-sm-12">
                        <input name="dArriveTime" id="dArriveTime1" type="date"value="">
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
    {{ $delivery->render() }}
</div>
</form>
@endsection
