<?php if (!defined('BASEPATH')) exit('No direct script access allowed');?>

<div class="col-lg-12">
    <?php
    echo form_open(base_url($this->config->item('area_admin') . '/cliente/salvar'), 'id="editar_cliente"'); 
        
    $cliente_id = (isset($cliente->id))? $cliente->id: set_value('id');
    $cliente_id = ($cliente_id === '' && isset($id))? $id: $cliente_id;
    
    
    
    $atributos = array(
        'name'  => 'id',
        'id'    => 'cliente_id',
        'value' => (isset($cliente->id))? $cliente->id: $cliente_id,
        'type'  => 'hidden'
    );
    
    echo form_input($atributos);
    ?>
    
    <div class="row">
        <div class="form-group col-lg-6">
            <?php
            echo form_label('Nome *');
            echo form_input('nome', (isset($cliente->nome)? $cliente->nome: set_value('nome')), 'id="nome" class="form-control" type="password"');
            echo form_error('nome');
            ?>
        </div> 
        <div class="form-group col-lg-3">
            <?php
            echo form_label('Sexo');
            
            $sexos_cliente = $this->config->item('sexos_clientes');
            
            echo '<div class="checkbox">';
            
            foreach ($sexos_cliente as $key => $value){
                
                $selected = ((isset($cliente->sexo) && $cliente->sexo === $key ) || (set_value('sexo') == $key) )? TRUE : FALSE;
                
                echo '<label>' . form_radio('sexo',$key,$selected) . '&nbsp;<span>' . $value . '</span></label>&nbsp;&nbsp;';
            }
            
            echo '</div>';
            echo form_error('sexo');
            ?>
        </div> 
    </div>
    
    <div class="row">
        <div class="form-group col-lg-6">
            <?php 

            echo form_label('E-mail *');
            echo form_input('email',(isset($cliente->email)? $cliente->email: set_value('email')), 'class="form-control " id="email"');
            echo form_error('email');
            ?>
        </div>
        <div class="form-group col-lg-3">
            <?php
            echo form_label('Telefone');
            echo form_input('telefone', (isset($cliente->telefone)? $cliente->telefone: set_value('telefone')), 'class="form-control "');
            ?>
        </div>
    </div>
    <div class="row">
        <div class="form-group col-lg-6">
            <?php 

            echo form_label('Endereco');
            echo form_input('endereco',(isset($cliente->endereco)? $cliente->endereco: set_value('endereco')), 'class="form-control "');

            ?>
        </div>
        <div class="form-group col-lg-2">
            <?php 

            echo form_label('Numero');
            echo form_input('numero',(isset($cliente->numero)? $cliente->numero: set_value('numero')), 'class="form-control "');

            ?>
        </div>
    </div>
    
    <div class="row">
        <div class="form-group col-lg-6">
            <?php 

            echo form_label('Bairro');
            echo form_input('bairro',(isset($cliente->bairro)? $cliente->bairro: set_value('bairro')), 'class="form-control "');

            ?>
        </div>
    </div>
    
    <div class="row">
        <div class="form-group col-lg-2">
            <?php 

            echo form_label('Estado');
            
            $ufs[''] = 'Selecione';
            
            echo form_input(array('name'  => 'base_url',
                                  'type'  => 'hidden',
                                  'id'    => 'base_url',
                                  'value' => base_url($this->config->item('area_admin'))
                ));
            
            echo form_dropdown('estado', $ufs,(isset($cliente->uf)? $cliente->uf : set_value('estado')),' id="estado" class="form-control"');

            ?>
        </div>
        <div class="form-group col-lg-4">
            <?php 

            echo form_label('Cidade');
            
            $cidades = (isset($cidades))? $cidades: array('Selecione');
            
            echo form_dropdown('cidade', $cidades,(isset($cliente->cidade)? $cliente->cidade: set_value('cidade')),'id="cidade" class="form-control"');
            echo '<span id="loader" style="display:none;">' . img(base_url('assets/img/loader.gif')) . '</span>';
            ?>
        </div>
    </div>
    
    <div class="row">
        <div class="form-group col-lg-6">
                <?php
                echo form_label('RG*');
                echo form_input('rg', (isset($cliente->rg)? $cliente->rg: set_value('rg')), 'class="form-control "');
                echo form_error('rg');
                ?>
        </div>
    </div>
    
    <div class="row">
        <div class="form-group col-lg-6">
                <?php
                echo form_label('CPF*');
                echo form_input('cpf', (isset($cliente->cpf)? $cliente->cpf: set_value('cpf')), 'class="form-control "');
                echo form_error('cpf');
                ?>
        </div>
    </div>

    
    <div class="row" style="padding-top: 20px;">
        <div class="form-group col-lg-6">
            <?php 

            echo form_submit('salvar','Salvar', 'class="btn btn-primary"');

            echo '&nbsp;' . form_button('cancelar','Cancelar', ' class="btn btn-danger btn_cancelar" ');
            ?>
        </div>
    </div>
    
    <?php echo form_close(); ?>
</div> 