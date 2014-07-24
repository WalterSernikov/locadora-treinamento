$(document).ready(function() {
    

    $("#editar_locacao").validate({
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
            data_ini: {
                required: true,
                
            },
            data_fim: {
                required: true,
            },
            messages: {
            }
        }
    });
    $('.data_loc').inputmask('dd/mm/yyyy');
    


    $('#calcula_data').click(function(e) {
        e.preventDefault();


        var data_ini = $('#data_ini').val();
        var data_fim = $('#data_fim').val();
        var veiculo = $('#veiculo').val();

        var precos = 0;

        var data_ini1 = data_ini.split("/");
        var data_fim1 = data_fim.split("/");
        var id = $('#id').val();
        data_ini1 = new Date(data_ini1[2], data_ini1[1], data_ini1[0]);
        data_fim1 = new Date(data_fim1[2], data_fim1[1], data_fim1[0]);
        
        if (data_fim1 > data_ini1) {


            var url = $('#url').val();

            $('#msg_dataFinal').hide();
            var resultado = $.ajax({url: url + '/locacao/valida_data',
                dataType: 'html',
                type: 'post',
                data: 'data_ini=' + data_ini + '&data_fim=' + data_fim + '&veiculo=' + veiculo + '&id='+id,
                async: false,
                success: function(data) {
                    
                }
            }).responseText;
            
            if (resultado == 1) {
                $('#msg_data_inds').hide();
                
                $.ajax({url: url + '/locacao/preco_diaria',
                    dataType: 'html',
                    type: 'post',
                    data: 'veiculo=' + veiculo + '&data_ini=' + data_ini + '&data_fim=' + data_fim,
                    async: false,
                    success: function(veiculo) {
                        
                        precos = JSON.parse(veiculo);
                        $('#preco_total1').val(precos.precoTotal);
                        $('#preco_total').val(precos.precoTotal);
                        
                        var calcao = precos.valor_veiculo * 0.04;
                        $('#preco_calcao').val(calcao);
                        $('#preco_calcao1').val(calcao);

                    }
                });
                


            } else {
                $('#msg_data_inds').show();
            }

        } else {

            $('#msg_dataFinal').show();
        }

    });
});
