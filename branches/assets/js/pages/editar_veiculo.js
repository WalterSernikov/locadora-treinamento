$(document).ready(function(){
    
    $("#editar_veiculo").validate({
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
            modelo: {
                required: true
            },
            placa: {
                required: true,
                valida_placa:true
            },
            ano: {
                required:true
            },
            passageiro: {
                required: true
            },
            porta: {
                required:true
            },
            valor: {
                required:true
            },
            messages: {
            }
        }
    });
    jQuery.validator.addMethod("valida_placa", function(value, element) {
        
        var id = $('#veiculo_id').val();
        var placa = $('#placa').val();
        var url = $('#url').val()+'/veiculo/valida_placa/';
       
       
        
        var resultado= $.ajax({url:url,
            dataType:'html',
            type:'post',
            data:'placa='+ placa + '&id='+ id,
            async:false,
        
        }).responseText;
        
        
        if(resultado == 1){
                return true;
            }else{
                return false;
            }

    }, "Já existe um veiculo cadastrado com esta placa.");
});