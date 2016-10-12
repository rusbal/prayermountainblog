$(function(){

    $('.btn-danger-hover').hover(
        function(){
            $(this).addClass('btn-danger');
        }, function(){
            $(this).removeClass('btn-danger');
        }
    );

});
