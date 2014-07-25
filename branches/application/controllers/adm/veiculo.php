<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of veiculo
 *
 * @author tellks
 */
class Veiculo extends TR_Controller {

    function __construct() {
        parent::__construct();

        if (!$this->autenticacao->verifica_acesso()) {

            redirect($this->config->item('area_admin') . '/acesso_negado');
        }

        // Carrega as configuracoes do usuario
        $this->load->config('veiculo');

        // Carrega a library de validacao
        $this->load->library('form_validation');

        // Carrega models utilizadas
        $this->load->model(array(
            $this->config->item('area_admin') . '/veiculo_model',
            $this->config->item('area_admin') . '/marca_model'
        ));
    }

    function index() {
        $this->all();
    }
    
    function valida_placa(){
        $placa = $this->input->post('placa');
        $id = $this->input->post('id');
        
        $retorno = $this->veiculo_model->get_by_placa($placa,$id);
        
        if(!$retorno){
            echo (int)TRUE;
        }else{
            echo (int)FALSE;
        }
        
        
    }

    function all() {
        $dados['veiculo'] = $this->veiculo_model->get_all();


        $dados['view'] = $this->config->item('area_admin') . '/veiculo/index';
        $dados['titulo'] = 'Gerenciar veiculos';

        $this->load->view($this->config->item('area_admin') . '/layout', $dados);
    }

    function cadastrar() {
        $dados['marca'] = $this->marca_model->get_marca();
        $dados['ar'] = $this->config->item('ar');
        $dados['cambio'] = $this->config->item('cambio');
        $dados['abs'] = $this->config->item('abs');
        $dados['status'] = $this->config->item('status');

        $dados['titulo'] = 'Cadastrar veiculo';
        $dados['view'] = $this->config->item('area_admin') . '/veiculo/editar';
        $dados['js'][] = 'plugins/jquery.validate';
        $dados['js'][] = 'pages/editar_veiculo';

        $this->load->view($this->config->item('area_admin') . '/layout', $dados);
    }

    function remover($id) {

        // informa o banco de dados qual registro deve ser removido
        $resultado = $this->veiculo_model->remover($id);

        // Captura o resultado da operacao
        if ($resultado) {

            $mensagem = array('msg' => 'delete-ok', 'tipo' => 'success');
        } else {
            $mensagem = array('msg' => 'erro', 'tipo' => 'danger');
        }

        // Seta a mensagem numa flashdata
        $this->session->set_flashdata('msg', $mensagem);

        //Redireciona para a tela de gerenciamento
        redirect($this->config->item('area_admin') . '/veiculo', 'refresh');
    }

    function salvar() {
        // Busca as regras de validacao nos arquivos de configuracao
        $regras = $this->config->item('regras_validacao');

        // Seta as regras na library de validacao
        $this->form_validation->set_rules($regras);

        // Seta o html das mensagens de validacao
        $this->form_validation->set_error_delimiters('<label class="error">', '</label>');

        $id = $this->input->post('id');
        $veiculo = new stdClass();
        $veiculo->modelo = $this->input->post('modelo');
        $veiculo->marca = $this->input->post('marca');
        $veiculo->cor = $this->input->post('cor');
        $veiculo->placa = $this->input->post('placa');
        $veiculo->porta = $this->input->post('porta');
        $veiculo->passageiro = $this->input->post('passageiro');
        $veiculo->cambio = $this->input->post('cambio');
        $veiculo->abs = $this->input->post('abs');
        $veiculo->status = $this->input->post('status');
        $veiculo->ar = $this->input->post('ar');
        $veiculo->valor_veiculo = $this->input->post('valor');
        $veiculo->valor_diaria = $veiculo->valor_veiculo * 0.006;
        $veiculo->ano = $this->input->post('ano');



        if ($this->form_validation->run() === FALSE) {
            $veiculo->id = $id;


            $dados['veiculo'] = $veiculo;
            $dados['marca'] = $this->marca_model->get_marca();
            $dados['ar'] = $this->config->item('ar');
            $dados['cambio'] = $this->config->item('cambio');
            $dados['abs'] = $this->config->item('abs');
            $dados['status'] = $this->config->item('status');

            $dados['titulo'] = 'Editar veiculo';
            $dados['view'] = $this->config->item('area_admin') . '/veiculo/editar';
            $dados['js'][] = 'plugins/jquery.validate';
            $dados['js'][] = 'pages/editar_veiculo';

            $this->load->view($this->config->item('area_admin') . '/layout', $dados);
        } else {

            if (empty($id)) {
                $veiculo->funcionario_id = (int) $this->session->userdata('funcionario_id');

                $retorno = $this->veiculo_model->inserir($veiculo);
            } else {
                $veiculo->id = $id;
                $retorno = $this->veiculo_model->atualizar($veiculo);
            }
        }
        // Captura o resultado da operacao e seta a mensagem a ser exibida para o usuario
        if ($retorno) {

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
        redirect($this->config->item('area_admin') . '/veiculo', 'refresh');
    }

    function editar($id) {
        $dados['veiculo'] = $this->veiculo_model->get_by_id($id);
        $dados['marca'] = $this->marca_model->get_marca();
        $dados['ar'] = $this->config->item('ar');
        $dados['cambio'] = $this->config->item('cambio');
        $dados['abs'] = $this->config->item('abs');
        $dados['status'] = $this->config->item('status');

        $dados['titulo'] = 'Editar veiculo';
        $dados['view'] = $this->config->item('area_admin') . '/veiculo/editar';
        $dados['js'][] = 'plugins/jquery.validate';
        $dados['js'][] = 'pages/editar_veiculo';

        $this->load->view($this->config->item('area_admin') . '/layout', $dados);
    }

}
