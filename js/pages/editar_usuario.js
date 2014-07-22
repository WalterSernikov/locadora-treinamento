$(document).ready(function(){
    
    $('#estado').change(function(){
        
        var url = $('#base_url').val()+'/cidade/load_cidades';
        
        $('#cidade').hide();
        $('#loader').show();
        
        $('#cidade').load(url,{uf: $(this).val()},function(){
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
                email:true,
                valida_email:true
            },
            senha: {
                verifica_senha:true
            },
            senha2: {
                compara_senhas:true
            },
            'grupos[]': {
                verifica_grupos: true
            },
            status: {
                required: true
            },
             
            messages: {
            }
        }
    });

   jQuery.validator.addMethod("verifica_grupos", function(value, element) {
        
        var grupos = $('.grupo');
      
        if(((grupos.filter(':checked').length === 0)) ){
            
            $('#div-grupos').addClass('f-error');
            $('#msg_verifica_grupos').show();
            $('#msg_verifica_grupos').addClass('error');
            return false;
        } 
        else{
            $('#msg_verifica_grupos').hide();
            $('#msg_verifica_grupos').removeClass('error');
            return true;        
        }
        
    }, "");


    jQuery.validator.addMethod("verifica_senha", function(value, element) {
        
        if(value === '' && $('#usuario_id').val() === ''){
            
            return false;
        }
        else{
            return true;
        }
        
    }, "Ao cadastrar um novo usuário o campo senha é obrigatório.");

    jQuery.validator.addMethod("compara_senhas", function(value, element) {
        
        var senha = $('#senha').val();
        
        if(value === senha){
            
            return true;
        }
        else{
            return false;
        }
        
    }, "As senhas informadas são diferentes");
    
    jQuery.validator.addMethod("valida_email", function(value, element) {
        
        var id = $('#usuario_id').val();
        var email = $('#email').val();
        var url = $('#base_url').val()+'/usuarios/valida_email/httpx';
       
        
        var resultado= $.ajax({url:url,
            dataType:'html',
            type:'post',
            data:'email='+ email + '&id='+ id,
            async:false,
        
        }).responseText;
        
        if(resultado == 1){
                return true;
            }else{
                return false;
            }

    }, "Já existe um usuário cadastrado com este email.");
    
});