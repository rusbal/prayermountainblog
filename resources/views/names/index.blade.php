@inject('helper', 'App\ViewHelper')
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title pull-left"> Names List </h3>
                    <a href="{{ url('/names/new') }}" class="btn btn-primary pull-right">New</a>
                    <div class="clearfix"></div>
                </div>

            @include('_alerts')

            @if ($names->isEmpty())
                <div class="panel-body">
                    There is no name.
                </div>
            @else
                <div class="panel-body">

                    <div class="form-group" id="sort-messages">
                        <span class="help-block">
                            <strong id="form-sort-messages"></strong>
                        </span>
                    </div>

                    <ul class="list-group" id="names-list">
                    @foreach($names as $name)
                        <li class="list-group-item">
                            <div class="row">

                                <div class="col-xs-1 name-order" data-id="{{ $name->id }}">
                                    {{ $name->order }}
                                </div>
                                <div class="col-lg-8 col-xs-6">
                                    <span class="drag-handle">☰</span>
                                    <a href="{{ route('revision', [$name->id, $name->latestRevision->id]) }}">{{ $name->latestRevision->name }} </a>
                                </div>

                                <div class="col-lg-3 col-xs-5">
                                    <div class="row">
                                        <div class="col-lg-6 col-xs-4">
                                            <div class="pull-right">

                                            @foreach($users as $user)
                                                <a data-toggle="tooltip" title="{{ $user->name }}" href="{{ route('latest-author-revision', [$name->id, $user->id]) }}">
                                                    <span class="badge" style="background:{!! $user->color !!}">{!! @$revision_count[$name->id][$user->id] !!}</span>
                                                </a>
                                            @endforeach

                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-xs-8">
                                            {!! $helper->coloredStatus($name->status) !!}
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

@section('footer_script')
<script>
$(function(){
    var collectNameOrder = function() {
        var order = Array();

        $('.name-order').each(function(){
            order.push($(this).data('id'));
        });
        return order;
    };

    var reNumber = function(order_arr) {
        var idx = 0;

        $('.name-order').each(function(){
            $(this).html(order_arr[idx]);
            idx += 1;
        });
    };

    var ajaxSetup = function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $("#sort-messages")
            .removeClass("has-success")
            .removeClass("has-error");
        $('#form-sort-messages').html('&nbsp;');
    };

    var initSortable = function(el){
        return Sortable.create(el, {
            chosenClass: 'sortable-dragged',
            handle: '.drag-handle',

            onUpdate: function (evt) {
                ajaxSetup();
                var data = {
                    order: collectNameOrder()
                };
                $.ajax({
                    type: "POST",
                    url: 'ajax/names/sort',
                    data: data,
                    success: function(response) {
                        $("#sort-messages").addClass("has-success");
                        $('#form-sort-messages').append('Name order was successfully updated.');
                        reNumber(response.order);
                    },
                    error: function(data) {
                        var obj = jQuery.parseJSON(data.responseText),
                            err = obj.order ? obj.order : obj.error;
                        if (err) {
                            $("#sort-messages").addClass("has-error");
                            $('#form-sort-messages').append(err);
                        }
                    },
                    dataType: 'json'
                });
            }
        });
    }

    var el = document.getElementById('names-list');

    if (el) {
        var sortable = initSortable(el);
    }
});
</script>
@endsection

