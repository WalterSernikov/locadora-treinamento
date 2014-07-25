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

    $("#editar_usuario").validate({
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
                email: true,
                valida_email: true
            },
            senha: {
                verifica_senha: true
            },
            senha2: {
                compara_senhas: true
            },
            'grupos[]': {
                verifica_grupos: true
            },
            status: {
                required: true
            },
            cpf: {
                required: true,
                valida_cpf: true,
                confere_cpf: true

            },
            messages: {
            }
        }
    });

    jQuery.validator.addMethod("confere_cpf", function(value, element) {

        var id = $('#usuario_id').val();
        var cpf = $('#cpf').val();
        var url = $('#base_url').val() + '/usuarios/confere_cpf';


        var resultado = $.ajax({url: url,
            dataType: 'html',
            type: 'post',
            data: 'cpf=' + cpf + '&id=' + id,
            async: false,
        }).responseText;
        console.log(resultado);
        if (resultado == 1) {
            return true;
        } else {
            return false;
        }

    }, "Já existe um usuario cadastrado com este cpf.");

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

    }, "CPF invalido!!");
    jQuery.validator.addMethod("verifica_grupos", function(value, element) {

        var grupos = $('.grupo');

        if (((grupos.filter(':checked').length === 0))) {

            $('#div-grupos').addClass('f-error');
            $('#msg_verifica_grupos').show();
            $('#msg_verifica_grupos').addClass('error');
            return false;
        }
        else {
            $('#msg_verifica_grupos').hide();
            $('#msg_verifica_grupos').removeClass('error');
            return true;
        }

    }, "");


    jQuery.validator.addMethod("verifica_senha", function(value, element) {

        if (value === '' && $('#usuario_id').val() === '') {

            return false;
        }
        else {
            return true;
        }

    }, "Ao cadastrar um novo usuário o campo senha é obrigatório.");

    jQuery.validator.addMethod("compara_senhas", function(value, element) {

        var senha = $('#senha').val();

        if (value === senha) {

            return true;
        }
        else {
            return false;
        }

    }, "As senhas informadas são diferentes");

    jQuery.validator.addMethod("valida_email", function(value, element) {

        var id = $('#usuario_id').val();
        var email = $('#email').val();
        var url = $('#base_url').val() + '/usuarios/valida_email/httpx';


        var resultado = $.ajax({url: url,
            dataType: 'html',
            type: 'post',
            data: 'email=' + email + '&id=' + id,
            async: false,
        }).responseText;

        if (resultado == 1) {
            return true;
        } else {
            return false;
        }

    }, "Já existe um usuário cadastrado com este email.");

});