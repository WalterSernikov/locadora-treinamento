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
                email: true,
                valida_email: true
            },
            cpf: {
                required: true,
                valida_cpf: true,
                confere_cpf:true

            },
            messages: {
            }
        }
    });

    jQuery.validator.addMethod("valida_email", function(value, element) {

        var id = $('#cliente_id').val();
        var email = $('#email').val();
        var url = $('#base_url').val() + '/cliente/valida_email/httpx';


        var resultado = $.ajax({url: url,
            dataType: 'html',
            type: 'post',
            data: 'email=' + email + '&id=' + id,
            async: false,
        }).responseText;
        console.log(resultado);
        if (resultado == 1) {
            return true;
        } else {
            return false;
        }

    }, "Já existe um cliente cadastrado com este email.");
    
    jQuery.validator.addMethod("confere_cpf", function(value, element) {

        var id = $('#cliente_id').val();
        var cpf = $('#cpf').val();
        var url = $('#base_url').val() + '/cliente/confere_cpf';


        var resultado = $.ajax({url: url,
            dataType: 'html',
            type: 'post',
            data: 'cpf=' + cpf + '&id=' + id,
            async: false,
        }).responseText;

        if (resultado == 1) {
            return true;
        } else {
            return false;
        }

    }, "Já existe um cliente cadastrado com este cpf.");

    jQuery.validator.addMethod("valida_cpf", function(value, element) {
        var numeros, digitos, soma, i, resultado, digitos_iguais;
        digitos_iguais = 1;
        var cpf = $('#cpf').val();
        if (cpf.length < 11)
            return false;
        for (i = 0; i < cpf.length - 1; i++)
            if (cpf.charAt(i) != cpf.charAt(i + 1))
            {
                digitos_iguais = 0;
                break;
            }
        if (!digitos_iguais)
        {
            numeros = cpf.substring(0, 9);
            digitos = cpf.substring(9);
            soma = 0;
            for (i = 10; i > 1; i--)
                soma += numeros.charAt(10 - i) * i;
            resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
            if (resultado != digitos.charAt(0))
                return false;
            numeros = cpf.substring(0, 10);
            soma = 0;
            for (i = 11; i > 1; i--)
                soma += numeros.charAt(11 - i) * i;
            resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
            if (resultado != digitos.charAt(1))
                return false;
            return true;
        }
        else
            return false;
    
    },"CPF invalido!!");
});