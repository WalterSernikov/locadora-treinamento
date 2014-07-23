$(document).ready(function() {

    $('#estado').change(function() {

        var url = $('#base_url').val() + '/cidade/load_cidades';

        $('#cidade').hide();
        $('#loader').show();

        $('#cidade').load(url, {uf: $(this).val()}, function() {
            $('#loader').hide();
            $('#cidade').show();
        });

    });
    
    $("#editar_cliente").validate({
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
            email: {
                required: true,
                email:true,
                valida_email:true
            },
            messages: {
            }
        }
    });
});