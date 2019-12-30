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
    //MORE FUNCTION (POP OUT WINDOW)
    $('#tbody').on('click', '#more', function () {
        var id = $(this).data('id');
        $.get('{{ url('/checkcontact/more') }}' + '/' +id , function (data) {
            $('#userCrudModal').html("更多");
            $('#btn-save').val("edit");
            $('#ajax-crud-modal').modal('show');
            console.log(data.check[0]);
            $('#id').val(id);
            $('#cname').html(data.check[0].cName);
            $('#cemail').html(data.check[0].cEmail);
            $('#cphone').html(data.check[0].cPhone);
            $('#cdis').html(data.check[0].cDis);
            if (data.check[0].cCheck == "已解決") 
            {
                $('#contacted').hide();
                $('#solved').hide();
            }
        })
    });
    //CONTACTED FUNCTION
    $('#contacted').click(function(event){
        event.preventDefault();
        $('#contacted').html('Sending..');
        $.ajax({
            url: '{{ url("/checkcontact/contact") }}',
            data: {
                id : $('#id').val(),
            },
            type: "POST",
            dataType: 'json',
            success: function (data) {
                var c = data.check;
                var auth = data.auth;
                var trHTML = '';
                    trHTML += '<tr align="center" id="cid_'+c[0].id+'">'
                    if (auth) 
                    {
                        trHTML += '<td>';
                        trHTML += 
                            '<a href="javascript:void(0)" id="more" data-id="' + c[0].id + '" class="btn btn-primary btn-sm">更多</a>';
                        trHTML += '</td>';
                    }
                    trHTML += '<td>' + c[0].cName + '</td>';
                    trHTML += '<td>' + c[0].cEmail + '</td>';
                    trHTML += '<td>' + c[0].cPhone + '</td>';
                    trHTML += '<td>' + c[0].cCheck + '</td>';
                    trHTML += '</tr>';
                $("#cid_" + c[0].id).replaceWith(trHTML);
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
    //CONTACTED FUNCTION
    $('#solved').click(function(event){
        event.preventDefault();
        $('#solved').html('Sending..');
        $.ajax({
            url: '{{ url("/checkcontact/solve") }}',
            data: {
                id : $('#id').val(),
            },
            type: "POST",
            dataType: 'json',
            success: function (data) {
                var c = data.check;
                var auth = data.auth;
                var trHTML = '';
                    trHTML += '<tr align="center" id="cid_'+c[0].id+'">'
                    if (auth) 
                    {
                        trHTML += '<td>';
                        trHTML += 
                            '<a href="javascript:void(0)" id="more" data-id="' + c[0].id + '" class="btn btn-primary btn-sm">更多</a>';
                        trHTML += '</td>';
                    }
                    trHTML += '<td>' + c[0].cName + '</td>';
                    trHTML += '<td>' + c[0].cEmail + '</td>';
                    trHTML += '<td>' + c[0].cPhone + '</td>';
                    trHTML += '<td>' + c[0].cCheck + '</td>';
                    trHTML += '</tr>';
                $("#cid_" + c[0].id).replaceWith(trHTML);
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
}); 
</script>
<form method="post">
{{ csrf_field() }}
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header" align="center">{{ __('查詢聯絡表') }}</div>
                @auth
                    <table class=" table table-hover thead-light table-responsive-xl .w-auto">
                        {{-- <div style="margin-left: 5px; margin-top: 5px; margin-bottom: 5px;">
                            <div>搜尋：<input type="text" id="search" placeholder="請輸入訂單編號"></div>
                        </div> --}}
                        <thead align="center" class="thead-light">
                            @if(Auth::user()->auth == "admin")
                                <td>功能</td>
                            @endif
                            <td>姓名</td>
                            <td>Email</td>
                            <td>電話號碼</td>
                            <td>狀態</td>
                        </thead>
                        <tbody id="tbody">
                            @foreach($check as $c)
                                <tr align="center" id="cid_{{ $c->id }}">
                                    @if(Auth::user()->auth == "admin")
                                        <td align="center"><a href="javascript:void(0)" id="more" data-id="{{ $c->id }}" class="btn btn-primary btn-sm">更多</a></td>
                                    @endif 
                                    <td align="center">{{ $c->cName }}</td>
                                    <td align="center">{{ $c->cEmail }}</td>
                                    <td align="center">{{ $c->cPhone }}</td>
                                    <td align="center">{{ $c->cCheck }}</td>
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
                <input type="hidden" name="id" id="id">
                {{-- DELIVERY ID --}}
                <div class="form-group">
                    <label class="col-sm-4 control-label"><h3>{{ __('姓名') }}</h3></label>
                    <div class="col-md-6">
                        <span id="cname"></span>
                    </div>
                </div>
                {{-- ORDER ID --}}
                <div class="form-group">
                    <label class="col-sm-4 control-label"><h3>Email</h3></label>
                    <div class="col-sm-12">
                        <span id="cemail"></span>
                    </div>
                </div>
                {{-- DELIVERY STATUS --}}
                <div class="form-group">
                    <label class="col-sm-4 control-label"><h3>電話號碼</h3></label>
                    <div class="col-sm-12">
                        <span id="cphone"></span>
                    </div>
                </div>
                {{-- DELIVERY TIME --}}
                <div class="form-group">
                    <label class="col-sm-4 control-label"><h3>說明</h3></label>
                    <div class="col-sm-12">
                        <span id="cdis"></span>
                    </div>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-primary" id="contacted" >已聯絡</button>
            <button type="button" class="btn btn-primary" id="solved" >已解決</button>
        </div>
    </div>
  </div>
</div>
{{--  --}}
<div class="pagination justify-content-center">
    {{ $check->render() }}
</div>
</form>
<script>

</script>
@endsection
