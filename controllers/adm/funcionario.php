<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of funcionario
 *
 * @author tellks
 */
class Funcionario extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model(array(
            $this->config->item('area_admin') . '/funcionario_model',
        ));
    }

    public function index() {
        $this->all();
    }

    public function all() {
        $dados['view'] = '/funcionario/index';
        $dados['titulo'] = 'Gerenciar Funcionario';
        $dados['funcionario'] = array();
        $this->load->view($this->config->item('area_admin') . '/layout', $dados);
    }

    public function cadastrar() {
        $dados['titulo'] = 'Cadastrar funcionario';
        $dados['view'] = $this->config->item('area_admin') . '/funcionario/editar';
        $dados['js'][] = 'plugins/jquery.validate';
        $dados['js'][] = 'pages/editar_funcionario';

        $this->load->view($this->config->item('area_admin') . '/layout', $dados);
    }

}
