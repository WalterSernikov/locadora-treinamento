<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

echo _mensagem_flashdata();
?>

<div class="row col-lg-12">
    <div class="panel panel-default">
        <div class="panel-heading">
            <a class="btn btn-primary" href="<?php echo base_url($this->config->item('area_admin') . '/locacao/cadastrar'); ?>">Cadastrar</a>
        </div> 
        <div class="panel-body">

            <?php
            $this->table->set_heading('Id', 'Cliente', 'Modelo', 'Placa ', 'Funcionario', 'Valor','Caução', 'Data incio', 'Data fim', 'Status', 'Ações');
            $status_locacao = 'asd';
            foreach ($locacao as $l) {

                foreach ($status as $key => $s) {
                    if ($l->status_locacao == $key) {
                        $status_locacao = $s;
                    }
                }


                $link_editar = base_url($this->config->item('area_admin') . '/locacao/editar/' . $l->id);

                $acoes = '<a href="' . $link_editar . '" class="btn btn-info btn-sm">Editar</a>&nbsp;';
                
                if($status_locacao === 'Desistente'){
                    
                        $acoes .= '<a href="#" data-id="' . $l->id . '" data-toggle="modal" data-target="#modal_confirmar_remocao" class="btn btn-danger btn-sm btn_remover">Remover</a>';
                }
                $data_ini = implode('/', array_reverse(explode('-', $l->data_ini)));
                $data_fim = implode('/', array_reverse(explode('-', $l->data_fim)));
                
                $this->table->add_row(
                        $l->id, $l->nome_cli, $l->modelo, $l->placa, $l->nome_fun,$l->valor_total,$l->caucao,$data_ini,$data_fim,$status_locacao, $acoes
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
                <p>Você realmente deseja remover este cliente?</p>
            </div>
            <div class="modal-footer">
                <a href="#" class="btn btn-default" data-dismiss="modal">Não</a>
                <a href="<?php echo base_url($this->config->item('area_admin') . '/locacao/remover/'); ?>" id="confirma_remocao" class="btn btn-primary">Sim</a>
            </div>
        </div>
    </div>
</div>


