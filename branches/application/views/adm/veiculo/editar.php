<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
?>


<div class="col-lg-12">
    <?php
    echo form_open(base_url($this->config->item('area_admin') . '/usuarios/salvar'), 'id="editar_usuario"'); 
        
    $veiculo_id = (isset($veiculo->id))? $veiculo->id: set_value('id');
    $veiculo_id = ($veiculo_id === '' && isset($id))? $id: $veiculo_id;
    
    
    
    $atributos = array(
        'name'  => 'id',
        'id'    => 'veiculo_id',
        'value' => (isset($veiculo->id))? $veiculo->id: $veiculo_id,
        'type'  => 'hidden'
    );
    
    echo form_input($atributos);
    ?>

   <div class="row">
        <div class="col-lg-6">
            <?php
                echo form_label('Modelo');
                echo form_input('modelo','','class = "form-control"');
                echo form_error('modelo');
            ?>
        </div>
    
    
    <div class="col-lg-6">
        <?php
                echo form_label('Placa');
                echo form_input('placa','','class = "form-control"');
                echo form_error('placa');
        ?>
    </div>
   </div>
    
    
  <div class="row">
        <div class="col-lg-6">
            <?php
                echo form_label('Cor');
                echo form_input('cor','','class = "form-control"');
                echo form_error('cor');
            ?>
        </div>
    
    
    <div class="col-lg-6">
        <?php
                echo form_label('Placa');
                echo form_input('placa','','class = "form-control"');
                echo form_error('placa');
        ?>
    </div>
   </div>  
    
    
    
    
    
    
    
</div>

