<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Cliente extends TR_Controller{
    
    
    function __construct() {
        
        parent::__construct();
        
        // Verifica o acesso do usuario a esta funcionalidade
        if(!$this->autenticacao->verifica_acesso()){
            
            redirect($this->config->item('area_admin') . '/acesso_negado');
        }
        
       // Carrega as configuracoes do usuario
        $this->load->config('cliente');
        
        // Carrega a library de criptografia para criptografar a senha
        $this->load->library('encrypt');
        
        // Carrega a library de validacao
        $this->load->library('form_validation');
        
        // Carrega models utilizadas
        $this->load->model(array(
            $this->config->item('area_admin') . '/cliente_model',
            $this->config->item('area_admin') . '/cidade_model',
        ));
    }
   
    function index (){
        
        $this->all();        
        
    }
    
    function all(){
        
        $dados['cliente'] = $this->cliente_model->get_all();
        
        $dados['titulo'] = 'Gerenciar cliente';
        $dados['view'] = $this->config->item('area_admin') . '/cliente/index';
        
        
        $this->load->view($this->config->item('area_admin').'/layout',$dados);
        
        
    }
    
    
    function cadastrar(){
        $dados['ufs']    = $this->cidade_model->get_UFs();
        
        
        $dados['titulo'] = 'Cadastrar cliente';        
        $dados['view'] = $this->config->item('area_admin').'/cliente/editar';
        
        $dados['js'][]   = 'plugins/jquery.validate';
        $dados['js'][]   = 'pages/editar_cliente';
        
        $this->load->view($this->config->item('area_admin').'/layout',$dados);
        
    }
    
    
}
