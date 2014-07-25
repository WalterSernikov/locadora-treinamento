<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<?php echo _mensagem_flashdata();?>

<div class="row col-lg-12">
    <div class="panel panel-default">
        <div class="panel-heading">
            <a class="btn btn-primary" href="<?php echo base_url($this->config->item('area_admin') . '/grupos/cadastrar'); ?>">Cadastrar</a>
        </div> 
        <div class="panel-body">

            <?php
            $this->table->set_heading('Id', 'Nome', 'Ações');
            
            foreach ($grupos as $g) {

                $link_editar  = base_url($this->config->item('area_admin') . '/grupos/editar/' . $g->id);
                
                $acoes  = '<a href="' . $link_editar . '" class="btn btn-info btn-sm">Editar</a>&nbsp;';
                $acoes .= '<a href="#" data-id="' . $g->id . '" data-toggle="modal" data-target="#modal_confirmar_remocao" class="btn btn-danger btn-sm btn_remover">Remover</a>';
                
                $acoes = array('data' => $acoes, 'width' => '170px');
                
                $this->table->add_row(
                        $g->id, $g->nome, $acoes
                );
            }

            $this->table->set_template(array(
                'table_open' => '<table class="table table-striped table-bordered table-hover">',
            ));

            echo $this->table->generate();
            ?>
        </div>
    </div>
</div>
<div class="modal fade" id="modal_confirmar_remocao" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Remover grupo de usuário</h4>
            </div>
            <div class="modal-body">
                <p>Você realmente deseja remover este grupo de usuário?</p>
            </div>
            <div class="modal-footer">
                <a href="#" class="btn btn-default" data-dismiss="modal">Não</a>
                <a href="<?php echo base_url($this->config->item('area_admin') . '/grupos/remover/'); ?>" id="confirma_remocao" class="btn btn-primary">Sim</a>
            </div>
        </div>
    </div>
</div>