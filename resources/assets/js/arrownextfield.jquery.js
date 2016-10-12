/**
 * Plugin Name: arrowNextField
 * Author: Raymond S. Usbal <raymond@philippinedev.com>
 * Date: 29 September 2016
 *
 * A plugin that transfers focus with the use of the arrow keys.
 */
(function ( $ ) {
 
    $.fn.arrowNextField = function( options ) {

        var settings = $.extend({
            selector: '',
            checkbox: false,
            reset: false,
            button: false
        }, options );

        /**
         * Build selector
         */
        settings.selector =  ':input';
        settings.selector += ':not(:hidden)';
        settings.selector += settings.checkbox ? '' : ':not(:checkbox)';
        settings.selector += settings.button   ? '' : ':not(:button)';
        settings.selector += settings.reset    ? '' : ':not(:reset)';

        /**
         * Set data-tabindex of form controls.
         */
        var nextTabindex = -1;
        this.find(settings.selector).each(function(){
            nextTabindex += 1;
            $(this).attr('data-tabindex', nextTabindex);
        });
 
        /**
         * Function to transfer focus to previous or next form control whichever 
         * is appropriate depending on the key pressed.
         */
        var arrowToField = function($this, direction) {

            var selStart = $this.prop("selectionStart"),
                tabindex = parseInt($this.data('tabindex'));

            if ($this.is('textarea')) {
                if (direction == 'up' && selStart == 0) {
                    $('[data-tabindex=' + (tabindex - 1) + ']').focus();
                    return true;

                } else if (direction == 'down' && (selStart == $this.val().length)) {
                    $('[data-tabindex=' + (tabindex + 1) + ']').focus();
                    return true;
                }
            } else {
                if (direction == 'up') {
                    $('[data-tabindex=' + (tabindex - 1) + ']').focus();
                    return true;

                } else if (direction == 'down') {
                    $('[data-tabindex=' + (tabindex + 1) + ']').focus();
                    return true;
                }
            }

            return false;
        }

        /**
         * Call arrowToField() when arrow keys are pressed.
         */
        this.find(settings.selector).keydown(function(e){
            if (e.keyCode == 38) {
                if (arrowToField($(this), 'up')) {
                    e.preventDefault();
                }

            } else if (e.keyCode == 40) {
                if (arrowToField($(this), 'down')) {
                    e.preventDefault();
                }
            }
        });

        return this;
    };
 
}( jQuery ));
