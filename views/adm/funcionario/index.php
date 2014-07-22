<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

?>

<div class="col-lg-12">
    <div class="row">
        <h2><?php echo $titulo; ?></h2>
    </div>
    <div class="row col-lg-12">
    <div class="panel panel-default">
        <div class="panel-heading">
    <a href="<?php echo base_url($this->config->item('area_admin').'/funcionario/cadastrar'); ?>" class="btn btn-success ">Cadastrar</a>
        </div>
        <div class="panel-body">

            <?php
            $this->table->set_heading('Id', 'Nome', 'CPF', 'RG','Salário','Função','Telefone','Ações');

            foreach ($funcionario as $obj) {

                $link_editar  = base_url($this->config->item('area_admin') . '/funcionario/editar/' . $obj->id);
                
                $acoes  = '<a href="' . $link_editar . '" class="btn btn-info btn-sm">Editar</a>&nbsp;';
                $acoes .= '<a href="#" data-id="' . $obj->id . '" data-toggle="modal" data-target="#modal_confirmar_remocao" class="btn btn-danger btn-sm btn_remover">Remover</a>';
                
                $this->table->add_row(
                        $obj->id, $obj->nome, $obj->cpf, $obj->rg,$obj->salario,$obj->funcao,$obj->telefone, $acoes
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
                <h4 class="modal-title" id="myModalLabel">Remover usuário</h4>
            </div>
            <div class="modal-body">
                <p>Você realmente deseja remover este usuário?</p>
            </div>
            <div class="modal-footer">
                <a href="#" class="btn btn-default" data-dismiss="modal">Não</a>
                <a href="<?php echo base_url($this->config->item('area_admin') . '/usuarios/remover/'); ?>" id="confirma_remocao" class="btn btn-primary">Sim</a>
            </div>
        </div>
    </div>
</div>
</div>
