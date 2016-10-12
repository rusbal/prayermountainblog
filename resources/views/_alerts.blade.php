@foreach ($errors->all() as $error)
    <p class="alert alert-danger">{!! $error !!}</p>
@endforeach

@if (session('status'))
    <div class="alert alert-success">
        {!! session('status') !!}
    </div>
@endif
