<?php if (!defined('BASEPATH')) exit('No direct script access allowed');?>

<div class="col-lg-12">
    <?php
    echo form_open(base_url($this->config->item('area_admin') . '/marca/salvar'), 'id="editar_marca"'); 
    
    echo form_hidden('id', (isset($marca->id))? $marca->id: set_value('id'));
    ?>
    
    <div class="row">
        <div class="form-group col-lg-6">
            <?php
            echo form_label('Nome *');
            echo form_input('nome', (isset($marca->nome)? $marca->nome: set_value('nome')), 'id="nome" class="form-control"');
            echo form_error('nome');
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
    
    <?php echo form_close(); ?>
</div> 