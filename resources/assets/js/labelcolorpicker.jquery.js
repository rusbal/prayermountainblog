(function ( $ ) {

    $.fn.labelColorPicker = function( options ) {

        var settings = $.extend({
            borderRadius: '5px',
            height: '120px',
            width: '120px',
        }, options );

        return this.each(function() {
            var $this = $(this);
            $('<label>')
                .attr('for', $this.attr('id'))
                .css('backgroundColor', $this.val())
                .css('borderRadius', settings.borderRadius)
                .css('height', settings.height)
                .css('width', settings.width)
            .insertAfter($this);

            $this.on('input', function(){
                $this.next('label').css('backgroundColor', $this.val());
            });

            $this.hide();
        });
    };
}( jQuery ));

