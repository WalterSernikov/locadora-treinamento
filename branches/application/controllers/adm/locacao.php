<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Locacao extends TR_Controller{
    
    function __construct() {
        
        parent::__construct();
        
        // Verifica o acesso do cliente a esta funcionalidade
        if(!$this->autenticacao->verifica_acesso()){
            
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
    
    function index(){
        
        $dados['status'] = $this->config->item('status_locacao');
        $dados['locacao'] = $this->locacao_model->get_all();
        $dados['view'] = $this->config->item('area_admin').'/locacao/index';
        $dados['titulo'] = 'Gerenciar Locação';
        
        $this->load->view($this->config->item('area_admin').'/layout',$dados);
    }
    
    function cadastrar(){
        $dados['cliente'] = $this->cliente_model->get_cliente();
        $dados['veiculo'] = $this->veiculo_model->get_veiculos();
//        echo '<pre>';
//        print_r($dados['veiculo']);
//        die('</pre>');
        $dados['titulo'] = 'Cadastrar Locação';        
        $dados['view'] = $this->config->item('area_admin').'/locacao/editar';
        
        $dados['js'][]   = 'plugins/jquery.validate';
        $dados['js'][]   = 'pages/editar_cliente';
        
        $this->load->view($this->config->item('area_admin').'/layout',$dados);
    }
}