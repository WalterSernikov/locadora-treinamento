<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
?>

<div class="col-lg-12">
    <?php
    echo form_open(base_url($this->config->item('area_admin') . '/locacao/salvar'), 'id="editar_locacao"');
          
    $locacao_id = (isset($locacao->id))? $locacao->id: set_value('id');
    $locacao_id = ($locacao_id === '' && isset($id))? $id: $locacao_id;
    
    $atributos = array(
        'name'  => 'id',
        'id'    => 'locacao_id',
        'value' => (isset($locacao->id))? $locacao->id: $locacao_id,
        'type'  => 'hidden'
    );
    
    echo form_input($atributos);
    ?>
    
    <div class='row'>
        <div class="col-lg-6">
            <?php
               echo form_label('Cliente');
               echo form_dropdown('cliente',$cliente,'','class="form-control"');
            ?>
        </div>
        <div class="col-lg-6">
            <?php
            ?>            
        </div>
    </div>
    
    
    
    
    <div class="row" style="padding-top: 20px;">
        <div class="form-group col-lg-6">
            <?php 

            echo form_submit('salvar','Salvar', 'class="btn btn-primary"');

            echo '&nbsp;' . form_button('cancelar','Cancelar', 'class="btn btn-danger btn_cancelar"');
            ?>
        </div>
    </div>
    <?php
            form_close();
    ?>
</div>
