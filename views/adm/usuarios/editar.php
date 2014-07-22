<?php if (!defined('BASEPATH')) exit('No direct script access allowed');?>

<div class="col-lg-12">
    <?php
    echo form_open(base_url($this->config->item('area_admin') . '/usuarios/salvar'), 'id="editar_usuario"'); 
        
    $usuario_id = (isset($usuario->id))? $usuario->id: set_value('id');
    $usuario_id = ($usuario_id === '' && isset($id))? $id: $usuario_id;
    
    
    
    $atributos = array(
        'name'  => 'id',
        'id'    => 'usuario_id',
        'value' => (isset($usuario->id))? $usuario->id: $usuario_id,
        'type'  => 'hidden'
    );
    
    echo form_input($atributos);
    ?>
    
    <div class="row">
        <div class="form-group col-lg-6">
            <?php
            echo form_label('Nome *');
            echo form_input('nome', (isset($usuario->nome)? $usuario->nome: set_value('nome')), 'id="nome" class="form-control" type="password"');
            echo form_error('nome');
            ?>
        </div> 
        <div class="form-group col-lg-3">
            <?php
            echo form_label('Sexo');
            
            $sexos_usuario = $this->config->item('sexos_usuarios');
            
            echo '<div class="checkbox">';
            
            foreach ($sexos_usuario as $key => $value){
                
                $selected = ((isset($usuario->sexo) && $usuario->sexo === $key ) || (set_value('sexo') == $key) )? TRUE : FALSE;
                
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
            echo form_input('email',(isset($usuario->email)? $usuario->email: set_value('email')), 'class="form-control " id="email"');
            echo form_error('email');
            ?>
        </div>
        <div class="form-group col-lg-3">
            <?php
            echo form_label('Telefone');
            echo form_input('telefone', (isset($usuario->telefone)? $usuario->telefone: set_value('telefone')), 'class="form-control "');
            ?>
        </div>
    </div>
    
    <div class="row">
        <div class="form-group col-lg-6">
            <?php 

            echo form_label('Senha');
            echo form_password('senha','', ' id="senha" class="form-control "');
            echo form_error('senha');
            ?>
        </div>
    </div>
    <div class="row">
        <div class="form-group col-lg-6">
            <?php 

            echo form_label('Confirme a senha');
            echo form_password('senha2','', 'class="form-control "');

            ?>
        </div>
    </div>
    <div class="row">
        <div class="form-group col-lg-6">
            <?php 

            echo form_label('Logradouro');
            echo form_input('logradouro',(isset($usuario->logradouro)? $usuario->logradouro: set_value('logradouro')), 'class="form-control "');

            ?>
        </div>
        <div class="form-group col-lg-2">
            <?php 

            echo form_label('Numero');
            echo form_input('numero',(isset($usuario->numero)? $usuario->numero: set_value('numero')), 'class="form-control "');

            ?>
        </div>
    </div>
    
    <div class="row">
        <div class="form-group col-lg-6">
            <?php 

            echo form_label('Bairro');
            echo form_input('bairro',(isset($usuario->bairro)? $usuario->bairro: set_value('bairro')), 'class="form-control "');

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
            
            echo form_dropdown('estado', $ufs,(isset($usuario->uf)? $usuario->uf : set_value('estado')),' id="estado" class="form-control"');

            ?>
        </div>
        <div class="form-group col-lg-4">
            <?php 

            echo form_label('Cidade');
            
            $cidades = (isset($cidades))? $cidades: array('Selecione');
            
            echo form_dropdown('cidade', $cidades,(isset($usuario->cidade)? $usuario->cidade: set_value('cidade')),'id="cidade" class="form-control"');
            echo '<span id="loader" style="display:none;">' . img(base_url('assets/img/loader.gif')) . '</span>';
            ?>
        </div>
    </div>
    
    <div class="row">
        <div class="form-group col-lg-3">
            <?php 

            echo form_label('Status *');

            $status_usuario = $this->config->item('status_usuario');

            echo form_dropdown('status',$status_usuario,(isset($usuario->status)? $usuario->status: set_value('status')),'class="form-control"');
            echo form_error('status');
            ?>
        </div>
    </div>

    <div class="row">
        <div class="form-group col-lg-3 div-grupos">
            <?php 

             $pertenceGrupo = function($grupos_usuario, $grupo) {

                foreach ($grupos_usuario as $g) {

                    if ($g === $grupo) {
                        return TRUE;
                    }
                }

                return FALSE;
            };
            
            echo form_label('Grupos *');
            
            foreach ($grupos as $g) {

                $checked = FALSE;
                
                if(isset($usuario->grupos)){
                    
                    $checked = $pertenceGrupo($usuario->grupos, $g->id);
                }
                
                $atributos = array(
                    'name'    => 'grupos[]',
                    'id'      => 'g_' . $g->id,                    
                    'value'   => $g->id,
                    'class'   => 'grupo',
                    'checked' => $checked
                );

                echo '<div class="checkbox"><label>' . form_checkbox($atributos) . '&nbsp;' . $g->nome . '</label></div>';
                
            }
            ?>
            <label for="grupos" class="" style="display: none;" id="msg_verifica_grupos">&nbsp;Selecione ao menos um grupo.</label>
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