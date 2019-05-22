@extends('layouts.app')

@section('content')
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        var count = 2;
        $('#msg').text(count);
        setTimeout(function () {
            count = count -1;
            window.location = '{{ url('/') }}';
            $('#msg').text(count);
        }, 3000);
    });
</script>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    You are logged in!
                    Redirecting in <span id="msg"></span> seconds
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
