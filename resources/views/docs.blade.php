@inject('helper', 'App\ViewHelper')
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title pull-left"> Generated File List </h3>

                    {{ Form::open(['action' => 'WordDocGenerator', 'method' => 'POST']) }}
                        <button class="btn btn-primary pull-right">Generate</button>
                    {{ Form::close() }}

                    <div class="clearfix"></div>
                </div>

            @include('_alerts')

            @if (!$documentFiles)
                <div class="panel-body">
                    No generated document yet.
                </div>
            @else
                <div class="panel-body">

                    <div class="form-group" id="sort-messages">
                        <span class="help-block">
                            <strong id="form-sort-messages"></strong>
                        </span>
                    </div>

                    <ul class="list-group" id="docs-list">

                        @foreach($documentFiles as $doc)
                            <li class="list-group-item @if ($loop->first && $doc['is_newly_created']) list-group-item-success @endif">
                                <div class="row">

                                    <div class="col-lg-7 col-xs-12">
                                        <a href="downloads/MSWord/{!! $doc['filepath'] !!}">{!! $doc['filepath'] !!} </a>
                                    </div>

                                    <div class="col-lg-5 col-xs-12">
                                        <div class="row">
                                            <div class="col-lg-6 col-xs-6">
                                                {{ $doc['time_elapsed'] }}
                                            </div>
                                            <div class="col-lg-6 col-xs-6">
                                                <div class="pull-right">
                                                    <span class="label" style="background:{{ @$doc['user']->color }}">{{ @$doc['user']->name }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </li>
                        @endforeach

                    </table>
                </div>
            @endif

            </div>
        </div>
    </div>
</div>
@endsection

