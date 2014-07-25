<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Locacao extends TR_Controller {

    function __construct() {

        parent::__construct();

        // Verifica o acesso do cliente a esta funcionalidade
        if (!$this->autenticacao->verifica_acesso()) {

            redirect($this->config->item('area_admin') . '/acesso_negado');
        }

        // Carrega as configuracoes do cliente
        $this->load->config('locacao');

        // Carrega a library de criptografia para criptografar a senha
        $this->load->library('encrypt');

        // Carrega a library de validacao
        $this->load->library('form_validation');

        // Carrega models utilizadas
        $this->load->model(array(
            $this->config->item('area_admin') . '/locacao_model',
            $this->config->item('area_admin') . '/usuario_model',
            $this->config->item('area_admin') . '/cliente_model',
            $this->config->item('area_admin') . '/veiculo_model',
        ));
    }

    function index() {
        $this->all();
    }

    function all() {

        $dados['status'] = $this->config->item('status_locacao');
        $dados['locacao'] = $this->locacao_model->get_all();
        $dados['view'] = $this->config->item('area_admin') . '/locacao/index';
        $dados['titulo'] = 'Gerenciar Locação';

        $this->load->view($this->config->item('area_admin') . '/layout', $dados);
    }

    function cadastrar() {
        $dados['cliente'] = $this->cliente_model->get_cliente();
        $dados['veiculo'] = $this->veiculo_model->get_veiculos();
//        echo '<pre>';
//        print_r($dados['veiculo']);
//        die('</pre>');
        $dados['titulo'] = 'Cadastrar Locação';
        $dados['view'] = $this->config->item('area_admin') . '/locacao/editar';

        $dados['js'][] = 'plugins/jquery.validate';
        $dados['js'][] = 'pages/editar_locacao';

        $this->load->view($this->config->item('area_admin') . '/layout', $dados);
    }

    function valida_data() {
        $data_ini = $this->input->post('data_ini');
        $data_fim = $this->input->post('data_fim');
        $veiculo = $this->input->post('veiculo');
        $id = $this->input->post('id');
        $resultado = $this->locacao_model->valida_data($data_ini, $data_fim, $veiculo,$id);
        
        //echo $this->db->last_query();
        echo $resultado;
    }

    function valida_data_call() {
        $data_ini = $this->input->post('data_ini');
        $data_fim = $this->input->post('data_fim');
        $id = $this->input->post('id');
        $veiculo = $this->input->post('veiculo');
        $this->form_validation->set_message('valida_data_call', 'Ja possui cadastro nessa data.');
        $resultado = $this->locacao_model->valida_data($data_ini, $data_fim, $veiculo,$id);

        //echo $this->db->last_query();
        echo $resultado;
    }

    function preco_diaria() {
        $veiculo = $this->input->post('veiculo');
        $data_ini = $this->input->post('data_ini');
        $data_fim = $this->input->post('data_fim');
        $data_ini = $this->geraTimestamp($data_ini);
        $data_fim = $this->geraTimestamp($data_fim);
        $diferenca = $data_fim - $data_ini;
        $dias = (int) floor($diferenca / (60 * 60 * 24));
        $resultado = $this->locacao_model->preco_diaria($veiculo);
        $resultado->precoTotal = $resultado->valor_diaria * $dias;
        echo json_encode($resultado);
    }

    private function geraTimestamp($data) {

        $partes = explode('/', $data);

        return mktime(0, 0, 0, $partes[1], $partes[0], $partes[2]);
    }

    function editar($id) {
        $dados['cliente'] = $this->cliente_model->get_cliente();
        $dados['veiculo'] = $this->veiculo_model->get_veiculos();
        $dados['locacao'] = $this->locacao_model->get_by_id($id);
        
//        echo '<pre>';
//        print_r($dados['locacao']);
//        die('</pre');
        
        $dados['titulo'] = 'Gerenciar Locação';
        $dados['view'] = $this->config->item('area_admin') . '/locacao/editar';

        $dados['js'][] = 'plugins/jquery.validate';
        $dados['js'][] = 'pages/editar_locacao';

        $this->load->view($this->config->item('area_admin') . '/layout', $dados);
    }
    
    function remover($id){
        
        // informa o banco de dados qual registro deve ser removido
        $resultado = $this->locacao_model->remover($id);
        
        // Captura o resultado da operacao
        if($resultado){
            
            $mensagem = array('msg' =>'delete-ok', 'tipo'=> 'success');
        }
        else{
            $mensagem = array('msg' =>'erro', 'tipo'=> 'danger');
        }
        
        // Seta a mensagem numa flashdata
        $this->session->set_flashdata('msg',$mensagem);
        
        //Redireciona para a tela de gerenciamento
        redirect($this->config->item('area_admin') . '/locacao', 'refresh');
    }

    function salvar() {
        // Busca as regras de validacao nos arquivos de configuracao
        $regras = $this->config->item('regras_validacao');

        // Seta as regras na library de validacao
        $this->form_validation->set_rules($regras);

        // Seta o html das mensagens de validacao
        $this->form_validation->set_error_delimiters('<label class="error">', '</label>');

        $id = $this->input->post('id');
        $locacao = new stdClass();
        $data_ini = implode('-', array_reverse(explode('/', $this->input->post('data_ini'))));
        $data_fim = implode('-', array_reverse(explode('/', $this->input->post('data_fim'))));
        $locacao->cliente_id = $this->input->post('cliente');
        $locacao->data_ini = $data_ini;
        $locacao->data_fim = $data_fim;
        $locacao->veiculo_id = $this->input->post('veiculo');
        $locacao->status_pagamento = $this->input->post('status_pagamento');
        $locacao->status_locacao = $this->input->post('status_locacao');
        
        $locacao->valor_total = $this->input->post('preco_total');
        $locacao->caucao = $this->input->post('preco_calcao');
//        echo '<pre>';
//        print_r($locacao);
//        die('</pre>');

        if ($this->form_validation->run() === FALSE) {
            $locacao->id = $id;
            $dados['cliente'] = $this->cliente_model->get_cliente();
            $dados['veiculo'] = $this->veiculo_model->get_veiculos();
            $dados['locacao'] = $locacao;
            $dados['titulo'] = 'Gerenciar Locação';
            $dados['view'] = $this->config->item('area_admin') . '/locacao/editar';

            $dados['js'][] = 'plugins/jquery.validate';
            $dados['js'][] = 'pages/editar_locacao';

            $this->load->view($this->config->item('area_admin') . '/layout', $dados);
        } else {
            if (empty($id)) {
                $locacao->funcionario_id = (int) $this->session->userdata('funcionario_id');
                $resultado = $this->locacao_model->inserir($locacao);
            } else {
                $locacao->id = $id;
                $resultado = $this->locacao_model->alterar($locacao);
            }
        }

        if ($resultado) {

            if (empty($id)) {

                $mensagem = array('msg' => 'insert-ok', 'tipo' => 'success');
            } else {

                $mensagem = array('msg' => 'update-ok', 'tipo' => 'info');
            }
        } else {
            $mensagem = array('msg' => 'erro', 'tipo' => 'danger');
        }

        // Grava a mensagem numa flashdata
        $this->session->set_flashdata('msg', $mensagem);

        // Redireciona o usuario para a tela de gerenciamento
        redirect($this->config->item('area_admin') . '/locacao', 'refresh');
    }

}
