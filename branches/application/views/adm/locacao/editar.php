<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
?>
<div class="row">
    <div class="col-lg-12">
        <?php
        echo form_open(base_url($this->config->item('area_admin') . '/locacao/salvar'), 'id="editar_locacao"');

        $locacao_id = (isset($locacao->id)) ? $locacao->id : set_value('id');
        $locacao_id = ($locacao_id === '' && isset($id)) ? $id : $locacao_id;

        $atributos = array(
            'name' => 'id',
            'id' => 'id',
            'value' => (isset($locacao->id)) ? $locacao->id : $locacao_id,
            'type' => 'hidden'
        );

        echo form_input($atributos);

        $data_ini = (isset($locacao->data_ini)) ? (implode('/', array_reverse(explode('-', $locacao->data_ini)))) : '';
        $data_fim = (isset($locacao->data_fim)) ? (implode('/', array_reverse(explode('-', $locacao->data_fim)))) : '';


        $url = array(
            'name' => 'url',
            'id' => 'url',
            'value' => base_url($this->config->item('area_admin')),
            'type' => 'hidden'
        );

        echo form_input($url);
        ?>

        <div class="row">
            <div class="col-lg-6">
                <?php
                echo form_label('Cliente');
                echo form_dropdown('cliente', $cliente, (isset($locacao->cliente_id) ? $locacao->cliente_id : set_value('cliente')), 'class="form-control"');
                ?>
            </div>
            <div class="col-lg-6">
                <?php
                echo form_label('Veiculo');
                echo form_dropdown('veiculo', $veiculo, (isset($locacao->veiculo_id) ? $locacao->veiculo_id : set_value('veiculo_id')), 'id="veiculo" class="form-control"');
                ?>            
            </div>
        </div>
        <div class="row" >
            <div class="col-lg-3">
                <?php
                echo form_label('Data inicio ');

                echo form_input('data_ini', $data_ini, 'id="data_ini" class="form-control data_loc"');
                ?>
                <span class="error" id="msg_data_pas" style="display:none;">A data inicio deve ser apartir de hoje</span>
            </div>
            <div class="col-lg-3">
                <?php
                echo form_label('Data fim ');

                echo form_input('data_fim', $data_fim, 'id="data_fim" class="form-control data_loc"');
                ?>
                <span class="error" id="msg_dataFinal" style="display:none;">A data final deve ser posterior a inicial</span>

            </div>

        </div>
        <div class="row ">
            <div class="col-lg-12">
                <span class="error" id="msg_data_inds" style="display:none;">O veiculo está indisponivel nessa data.</span>
            </div>
        </div>
        <div class="row ">
            <div class="col-lg-6">
                <?php
                echo form_label('Preço Total');
                echo form_input('preco_total1', (isset($locacao->valor_total) ? $locacao->valor_total : set_value('preco_total')), 'id="preco_total1" class="form-control total" disabled="true"');
                $total = array(
                    'name' => 'preco_total',
                    'id' => 'preco_total',
                    'value' => (isset($locacao->valor_total) ? $locacao->valor_total : set_value('preco_total')),
                    'type' => 'hidden'
                );
                echo form_input($total);
                ?>
            </div>
            <div class="col-lg-6">
                <?php
                echo form_label('Preço Caução');
                echo form_input('preco_calcao1', (isset($locacao->caucao) ? $locacao->caucao : set_value('preco_calcao')), 'id="preco_calcao1" class="form-control calcao" disabled="true"');
                $calcao = array(
                    'name' => 'preco_calcao',
                    'id' => 'preco_calcao',
                    'value' => (isset($locacao->nome) ? $locacao->caucao : set_value('preco_calcao')),
                    'type' => 'hidden'
                );
                echo form_input($calcao);
                ?>
            </div>
        </div>
        <div class="row mg10">
            <div class="col-lg-6">
                <?php
                $status_pagamento = $this->config->item('status_pagamento');
                echo form_label('Status Pagamento');
                echo form_dropdown('status_pagamento', $status_pagamento, (isset($locacao->status_pagamento) ? $locacao->status_pagamento : set_value('status_pagamento')), 'class="form-control"');
                ?>
            </div>
            <div class="col-lg-6">
                <?php
                $status_locacao = $this->config->item('status_locacao');
                echo form_label('Status locação');
                echo form_dropdown('status_locacao', $status_locacao, (isset($locacao->status_locacao) ? $locacao->status_locacao : set_value('status_locacao')), 'class="form-control"');
                ?>
            </div>
        </div>


        <div class="row" style="padding-top: 20px;">
            <div class="form-group col-lg-6">
                <?php
                echo form_submit('salvar', 'Salvar', 'class="btn btn-primary"');

                echo '&nbsp;' . form_button('cancelar', 'Cancelar', 'class="btn btn-danger btn_cancelar"');
                ?>
            </div>
        </div>
        <?php
        form_close();
        ?>
    </div>
</div>
