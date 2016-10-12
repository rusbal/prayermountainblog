/**
 * Author: Raymond S. Usbal <raymond@philippinedev.com>
 * Date: 2 Oct 2016
 *
 * Automatically create form for input[data-delete-confirm] to submit deletion
 * in a restful way.
 *
 *      <input class="btn btn-danger-hover" data-domain-name="foo" data-delete-confirm="Are you sure?" type="button" value="Delete">
 *
 * Uses bootbox.js to ask for confirmation before submitting the delete form.
 */

$(function(){

    var createDeleteForm = function(formId) {
        var form = $('<form>')
            .attr('id', formId)
            .attr('action', window.location.href)
            .attr('method', 'POST');

        var spoofed_method = $('<input>')
            .attr('name', '_method')
            .attr('type', 'hidden')
            .val('DELETE');

        var token = $('<input>')
            .attr('name', '_token')
            .attr('type', 'hidden')
            .val(window.Laravel.csrfToken);

        form.append(spoofed_method)
            .append(token);

        $(document.body).append(form);
    };

    var deleteRecord = function(domainName) {
        var formId = 'delete-' + domainName;
        createDeleteForm(formId);
        $('#' + formId).submit();
    };

    $('input[data-delete-confirm]').on('click', function(){
        var domainName = $(this).data('domain-name'),
            question = $(this).data('delete-confirm'),
            domainTitle = $('#' + domainName + '-title').html();
        
        bootbox.confirm({
            title: question,
            message: 'Delete ' + domainName + (domainTitle ? ': <b>' + domainTitle + '</b>' : ''),
            buttons: {
                confirm: {
                    label: 'Yes, delete this ' + domainName,
                    className: 'btn-danger'
                },
                cancel: { 
                    label: 'Cancel',
                    className: 'btn-primary'
                }
            },
            callback: function (result) {
                if (result) {
                    deleteRecord(domainName);
                }
            }
        });
    });

});
