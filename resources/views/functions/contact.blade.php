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

    $('#confirm').click(function(event){
        event.preventDefault();
        var e = $('#cphone').val();
        console.log(e);
        $.ajax({
            url: '{{ url("/contact/contact") }}',
            type: 'POST',
            data: {
                cName : $('#cname').val(),
                cEmail : $('#cemail').val(),
                cPhone : $('#cphone').val(),
                cDis : $('#cdis').val(),
            },
            success:function(data){
                console.log(data);
                confirm(data.msg);
            },
            error: function(data){
                console.log('Error', data.msg);
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
                <div class="card-header" align="center">{{ __('聯絡我們') }}
                    <div align="right" style="display: inline;">
                        @if(Auth::user()->auth == "admin")
                            <a href="{{ url("/checkcontact") }}" class="btn btn-primary btn-sm">查看聯絡</a>
                        @endif
                    </div>
                </div>
                <div class="card-body">
                    <form method="POST">
                        <div class="form-group row">
                            <label for="pName" class="col-md-4 col-form-label text-md-right">{{ __('姓名') }}</label>
                            <div class="col-md-6">
                               <input type="text" name="name" id="cname"><span id="pUnit"></span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="pName" class="col-md-4 col-form-label text-md-right">{{ __('Email') }}</label>
                            <div class="col-md-6">
                                <input type="email" name="email" id="cemail"><span id="pUnit"></span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="pAmount" class="col-md-4 col-form-label text-md-right">{{ __('電話號碼') }}</label>
                            <div class="col-md-6">
                                <input type="text"  name="phone" id="cphone"><span id="pUnit"></span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="pPrice" class="col-md-4 col-form-label text-md-right">{{ __('說明') }}</label>
                            <div class="col-md-6">
                                <textarea name="dis" id="cdis" cols="30" rows="5"></textarea>
                            </div>
                        </div>
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="button" class="btn btn-primary" name="confirm" id="confirm" value="">{{ __('確定') }}</button>
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
