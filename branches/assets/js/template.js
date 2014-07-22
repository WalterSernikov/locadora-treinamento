$(function() {

    $('#side-menu').metisMenu();

});

//Loads the correct sidebar on window load,
//collapses the sidebar on window resize.
$(function() {
    $(window).bind("load resize", function() {
        width = (this.window.innerWidth > 0) ? this.window.innerWidth : this.screen.width;
        if (width < 768) {
            $('div.sidebar-collapse').addClass('collapse')
        } else {
            $('div.sidebar-collapse').removeClass('collapse')
        }
    })
});

$(document).ready(function(){
    
    $('.btn_remover').click(function(e){
        
        e.preventDefault();
        
        var id = $(this).data('id');
        
        $('#confirma_remocao').attr('href',$('#confirma_remocao').attr('href') + '/' + id);
    });
    
    $('.btn_cancelar').click(function(e){
        
        window.history.back();
    });
});
