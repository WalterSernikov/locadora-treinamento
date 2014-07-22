<?php if (!defined('BASEPATH')) exit('No direct script access allowed');?>

<?php echo _mensagem_flashdata();?>

<div class="col-lg-12">
    <?php
    echo form_open(base_url($this->config->item('area_admin') . '/controle_acesso/salvar')); 
    
    $temPermissao = function($permissoes,$funcionalidade, $grupo) {

            foreach ($permissoes as $p) {
                
                if(($p->grupo_id === $grupo) && ($p->funcionalidade_id === $funcionalidade)){
                    
                    return true;
                }
            }
            
            return FALSE;
        };
    
    ?>
    
    <div class="row">
        <div class="panel-group" id="accordion">
            <?php foreach ($funcionalidades as $f): ?>

                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#f_<?php echo $f->id;?>"><?php echo $f->nome;?></a>
                        </h4>
                    </div>
                    <div id="f_<?php echo $f->id;?>" class="panel-collapse collapse">
                        <div class="panel-body">
                                <?php
                                foreach ($grupos as $g) {

                                    $checked = $temPermissao($permissoes, $f->id, $g->id);
                                    
                                    $atributos = array(
                                        'name'    => 'grupos' . $f->id . '[]',
                                        'id'      => 'g_' . $f->id . $g->id,
                                        'value'   => $g->id,
                                        'checked' => $checked
                                    );

                                    echo '<div class="checkbox"><label>' . form_checkbox($atributos) . '&nbsp;' . $g->nome . '</label></div>';
                                }
                                ?>
                        </div>
                    </div>
                </div>

            <?php endforeach; ?>
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