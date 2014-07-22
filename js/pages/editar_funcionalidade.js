$(document).ready(function(){
       
   $("#editar_funcionalidade").validate({
        onkeyup: false,
        errorClass: 'error',
        validClass: 'valid',
        highlight: function(element) {
            $(element).closest('div').addClass("f-error");
        },
        unhighlight: function(element) {
            $(element).closest('div').removeClass("f-error");
        },
        errorPlacement: function(error, element) {
            $(element).closest('div').append(error);
        },
        rules: {
            nome: {
                required: true
            },
            icone: {
                required: true
            },
            url: {
                required: true
            },
            status: {
                required: true
            },
            posicao_menu: {
                required: true
            },
            messages: {
            }
        }
    });
});