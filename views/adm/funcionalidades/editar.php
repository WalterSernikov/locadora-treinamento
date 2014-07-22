<?php if (!defined('BASEPATH')) exit('No direct script access allowed');?>

<div class="col-lg-12">
    <?php
    echo form_open(base_url($this->config->item('area_admin') . '/funcionalidades/salvar'), 'id="editar_funcionalidade"'); 
    
    echo form_hidden('id', (isset($funcionalidade->id))? $funcionalidade->id: set_value('id'));
    ?>
    
    <div class="row">
        <div class="form-group col-lg-3">
            <?php
            echo form_label('Nome *');
            echo form_input('nome', (isset($funcionalidade->nome)? $funcionalidade->nome: set_value('nome')), 'class="form-control"');
            echo form_error('nome');
            ?>
        </div>
        <div class="form-group col-lg-3">
            <?php
            echo form_label('Icone *');
            echo form_input('icone', (isset($funcionalidade->icone)? $funcionalidade->icone: set_value('icone')), 'class="form-control"');
            echo form_error('icone');
            ?>
        </div> 
    </div>
    
    <div class="row">
        <div class="form-group col-lg-6">
            <?php
            echo form_label('Url *');
            echo form_input('url', (isset($funcionalidade->url)? $funcionalidade->url: set_value('url')), 'class="form-control"');
            echo form_error('url');
            ?>
        </div> 
    </div>
    
    <div class="row">
        <div class="form-group col-lg-3">
            <?php
            echo form_label('Status *');
            
            $status     = $this->config->item('status_funcionalidade');
            $status[''] = 'Selecione';
            
            echo form_dropdown('status', $status,(isset($funcionalidade->status)? $funcionalidade->status: set_value('status')),'class="form-control"');
            echo form_error('status');
            ?>
        </div> 
        <div class="form-group col-lg-3">
            <?php
            echo form_label('Posição no menu *');
            echo form_input('posicao_menu', (isset($funcionalidade->posicao_menu)? $funcionalidade->posicao_menu: set_value('posicao_menu')), 'class="form-control"');
            echo form_error('posicao_menu');
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