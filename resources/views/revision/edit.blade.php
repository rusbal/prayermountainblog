@extends('layouts.app')

@section('content')
<div class="container">
    
    @include('revision._user')

    <div class="row">
        <div class="col-md-10 col-md-offset-1">

            @include('_alerts')

            {{ Form::open(['action' => ['RevisionController@update', $name->id, $revision->id], 'method' => 'PATCH', 'id' => 'main-form', 'class' => 'form-horizontal']) }}

                @include('revision._form', ['showUpdateBtn' => true])

            {{ Form::close() }}

        </div>
    </div>
</div>
@endsection


@section('footer_script')
<script>
$(function(){

    autosize($('textarea'));

    $('#main-form').arrowNextField();

    var serialized = $('#main-form').serialize();
    var revisionId = {{ $revision->id }};

    var submitNewRevision = function() {
        if (serialized == $('#main-form').serialize()) { return; }

        bootbox.prompt({
            title: "Save to new revision:", 
            animate: false,
            callback: function(result){ 
                if (result === null) { return; }

                if (result === '') {
                    submitNewRevision();
                    return
                }
                
                $('#revision_title').val(result);
                $('#main-form').submit();
            }
        });
    };

    $('.submit-new-revision').on('click', function(){
        submitNewRevision();
    });

    $('#menu-submit-save').on('click', function(){
        $('#main-form').submit();
    });

    $('#main-form').submit(function(e){
        if (serialized == $('#main-form').serialize()) {
            e.preventDefault();
            return;
        }

        if ($('#revision_title').val() == '') {
            if ($('input[type=submit]').hasClass('out-of-view')) {
                e.preventDefault();
                submitNewRevision();
                return;
            }
        }
    });

    $('form :input').on('input', function(){
        // Enable buttons
        $('.buttons-group .disabled').removeClass('disabled').addClass('enabled');
    });

    $('form input[type=reset]').on('click', function(){
        // Disable buttons
        $('.buttons-group .enabled').removeClass('enabled').addClass('disabled');
    });

});

/**
 * Status submission handling
 */
$(function(){

    var ajaxSetup = function() {
        $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
    };

    var ajaxSetStatus = function($this) {
        ajaxSetup();
        var data = {
            status: $($this).html()
        };
        $.ajax({
            type: "POST",
            url: '/ajax/names/status/' + window.Laravel.name.id,
            data: data,
            success: function(response) {
                $('#update-status').html(response.html);
                $('.update-status').on('click', function(){ ajaxSetStatus(this); });
            },
            dataType: 'json'
        });
    };

    $('.update-status').on('click', function(){ ajaxSetStatus(this); });

});

/**
 * Comments handling
 */
$(function(){

    /**
     * See comment | Add Comment button
     */
    $('.see-comment-button').on('click', function(){
        var comments = $(this).closest('div.form-group').find('ul.comments'),
            count    = parseInt($(this).attr('data-count')),
            willHideComments = ($(this).text() == 'Hide');

        if (willHideComments) {
            setSeeCommentButtonText(this);
        } else {
            $(this).text('Hide');
        }

        showCommentForm(comments, count);
        toggleComments(comments);

        if (willHideComments || count > 0) {
            $(this).parent().click();
        } else {
            comments.find('textarea').focus();
        }
    });

    var showCommentForm = function(comments, count){
        if (count == 0) {
            comments.find('textarea').show();
        }
    };

    var toggleComments = function(comments){
        if (comments.is(':visible')) {
            comments.find('li').slideUp('slow', function(){ 
                if (comments.find('li:visible').length == 0) {
                    comments.hide();
                }
            });
        } else {
            comments.find('li').hide();
            comments.css('display', 'inline')
                    .find('li').slideDown('slow');
        }
    };

    var adjustCommentCount = function(btn, addVal){
        var count = parseInt($(btn).attr('data-count')),
            newCount = count + addVal;
        $(btn).attr('data-count', newCount);
    }

    var setSeeCommentButtonText = function(btn){
        var count = parseInt($(btn).attr('data-count'));
        $(btn).text( count == 0 ? 'Comment' : count + ' Comments' );
    }

    var addCommentRow = function($this, id){
        var formItem = $($this).closest('li');

        var authorSpan = $('<span>')
            .attr('class', 'label')
            .css('background', window.Laravel.user.color)
            .html(window.Laravel.user.initials);

        var newItem = $('<li>')
            .attr('data-id', id)
            .attr('class', 'list-group-item list-group-item-warning');

        var closeButton = $('<button>')
            .attr('type', 'button')
            .attr('class', 'close')
            .attr('data-dismiss', 'alert')
            .attr('aria-label', 'Close')
            .html('<span aria-hidden="true">×</span>')
            .on('click', function(){ commentClose(this); });

        var entryComment = $('<small>').html(' ' + Global.nl2br( $($this).parent().siblings('textarea').val() ));
            
        $( newItem )
            .append(closeButton)
            .append(authorSpan)
            .append(entryComment)
        .insertBefore( formItem );
    };

    var ajaxAddComment = function($this) {

        var textarea = $($this).parent().siblings('textarea'),
            comment_entry = textarea.val();

        if (comment_entry == '') {
            textarea.attr('placeholder', 'Enter your comment here').focus();
            return;
        }

        $($this).siblings('.message').removeClass('hidden');

        var data = {
            comment: comment_entry,
            comment_on: textarea.data('comment-on')
        };

        window.Global.ajaxSetup();

        $.ajax({
            type: "POST",
            url: '/ajax/' + window.Laravel.name.id + '/comments',
            data: data,
            success: function(response) {
                adjustCommentCount( $($this).closest('.form-group').find('.see-comment-button'), 1 );
                addCommentRow($this, response.id);

                /**
                 * Reset input
                 */
                $($this).parent().siblings('textarea').val('');
                $($this).siblings('.message').addClass('hidden');
            },
            dataType: 'json'
        });
    };

    /**
     * Submit comment
     */
    $('.add-comment-btn').on('click', function(){
        var form = $(this).parent(),
            textarea = $(form).siblings('textarea');

        if (textarea.is(':hidden')) {
            textarea.show().focus();
        } else {
            ajaxAddComment(this);
        }
    });

    /**
     * Deleting of comment
     */
    var ajaxDeleteComment = function(id) {
        var data = {
            _method: 'DELETE',
        };

        window.Global.ajaxSetup();

        $.ajax({
            type: "POST",
            url: '/ajax/comments/' + id,
            data: data,
            dataType: 'json'
        });
    };

    var commentClose = function($this){
        var li = $($this).closest('li');

        if ($($this).find('span').text() == '×') {
            var id = li.data('id'),
                btn = $($this).closest('.form-group').find('button.see-comment-button');

            ajaxDeleteComment(id);

            adjustCommentCount( btn, -1 );

            li.slideUp(function(){
                $(li).remove();
            });
        } else {
            li.slideUp();
        }
    };

    $('ul.comments button.close').on('click', function(){
        commentClose(this);
    });
});

</script>
@endsection
