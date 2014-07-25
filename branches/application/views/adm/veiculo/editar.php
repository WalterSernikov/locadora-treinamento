<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
?>


<div class="col-lg-12">
    <?php
    echo form_open(base_url($this->config->item('area_admin') . '/veiculo/salvar'), 'id="editar_veiculo"');

    $veiculo_id = (isset($veiculo->id)) ? $veiculo->id : set_value('id');
    $veiculo_id = ($veiculo_id === '' && isset($id)) ? $id : $veiculo_id;



    $atributos = array(
        'name' => 'id',
        'id' => 'veiculo_id',
        'value' => (isset($veiculo->id)) ? $veiculo->id : $veiculo_id,
        'type' => 'hidden'
    );

    $url = array(
        'name' => 'url',
        'id' => 'url',
        'value' => base_url($this->config->item('area_admin')),
        'type' => 'hidden'
    );

    echo form_input($url);

    echo form_input($atributos);
    ?>

    <div class="row">
        <div class="col-lg-6">
            <?php
            echo form_label('Modelo');
            echo form_input('modelo', (isset($veiculo->modelo) ? $veiculo->modelo : set_value('modelo')), 'class = "form-control"');
            echo form_error('modelo');
            ?>
        </div>

        <div class="col-lg-2">
            <?php
            echo form_label('Marca');
            echo form_dropdown('marca', $marca, (isset($veiculo->marca) ? $veiculo->marca : set_value('marca')), 'class="form-control"');
            ?>
        </div>
        <div class="col-lg-2">
            <?php
            echo form_label('Placa');
            echo form_input('placa', (isset($veiculo->placa) ? $veiculo->placa : set_value('placa')), 'id="placa" class = "form-control"');
            echo form_error('placa');
            ?>
        </div>

        <div class="col-lg-2">
            <?php
            echo form_label('Cor');
            echo form_input('cor', (isset($veiculo->cor) ? $veiculo->cor : set_value('cor')), 'class = "form-control"');
            echo form_error('cor');
            ?>
        </div>
    </div>



    <div class="row mg10">   

        <div class="col-lg-1">
            <?php
            echo form_label('Portas:');
            echo form_input('porta', (isset($veiculo->porta) ? $veiculo->porta : set_value('porta')), 'class = "form-control"');
            echo form_error('porta');
            ?>
        </div>

        <div class="col-lg-1">
            <?php
            echo form_label('Passageiros:');
            echo form_input('passageiro', (isset($veiculo->passageiro) ? $veiculo->passageiro : set_value('passageiro')), 'class = "form-control"');
            echo form_error('passageiro');
            ?>
        </div>


        <div class="col-lg-1">
            <?php
            echo form_label('Valor:');
            echo form_input('valor', (isset($veiculo->valor_veiculo) ? $veiculo->valor_veiculo : set_value('valor')), 'class = "form-control"');
            echo form_error('valor');
            ?>
        </div>

        <div class="col-lg-2">
            <?php
            echo form_label('Ar cond.:');
            echo form_dropdown('ar', $ar, (isset($veiculo->ar) ? $veiculo->ar : set_value('ar')), 'class = "form-control"');
            echo form_error('ar');
            ?>
        </div>

        <div class="col-lg-1">
            <?php
            echo form_label('ABS:');
            echo form_dropdown('abs', $abs, (isset($veiculo->abs) ? $veiculo->abs : set_value('abs')), 'class = "form-control"');
            echo form_error('abs');
            ?>
        </div>

        <div class="col-lg-2">
            <?php
            echo form_label('Transmissão:');
            echo form_dropdown('cambio', $cambio, (isset($veiculo->cambio) ? $veiculo->cambio : set_value('cambio')), 'class = "form-control"');
            echo form_error('cambio');
            ?>
        </div>

        <div class="col-lg-1">
            <?php
            echo form_label('Ano:');
            echo form_input('ano', (isset($veiculo->ano) ? $veiculo->ano : set_value('ano')), 'class = "form-control"');
            echo form_error('ano');
            ?>
        </div>
        
        <div class="col-lg-2">
            <?php
            echo form_label('Status:');
            echo form_dropdown('status', $status, (isset($veiculo->status) ? $veiculo->status : set_value('status')), 'class = "form-control"');
            echo form_error('status');
            ?>
        </div>
        

    </div>  


    <div class="row" style="padding-top: 20px;">
        <div class="form-group col-lg-6">
            <?php
            echo form_submit('salvar', 'Salvar', 'class="btn btn-primary"');

            echo '&nbsp;' . form_button('cancelar', 'Cancelar', 'class="btn btn-danger btn_cancelar"');
            ?>
        </div>
    </div>
    <?php
    form_close();
    ?>




</div>

