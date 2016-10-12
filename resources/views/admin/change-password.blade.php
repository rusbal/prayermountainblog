@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title pull-left"> Names List </h3>
                    <a href="{{ url('/names/new') }}" class="btn btn-primary pull-right">New</a>
                    <div class="clearfix"></div>
                </div>

                <div class="panel-body">

                    @include('_alerts')

                    <fieldset>

                        {{ Form::open(array('method' => 'PATCH', 'id' => 'main-form', 'class' => 'form-horizontal')) }}
                        {!! Form::password('old_password', ['class'=>'form-control']) !!}
                        {!! Form::password('password', ['class'=>'form-control']) !!}
                        {!! Form::password('password_confirmation', ['class'=>'form-control']) !!}
                        {{ Form::end() }}

                    </fieldset>
                </div>

            {{ Form::close() }}

        </div>
    </div>
</div>
@endsection
