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
class Veiculo extends TR_Controller{
    function __construct() {
        parent::__construct();
        
        if(!$this->autenticacao->verifica_acesso()){
            
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
    
    function index(){
        $this->all();
    }
    
    function all(){
        $dados['veiculo'] = $this->veiculo_model->get_all();
        
        $dados['view'] = $this->config->item('area_admin').'/veiculo/index';
        $dados['titulo'] = 'Gerenciar veiculos';
        
        $this->load->view($this->config->item('area_admin').'/layout',$dados);
    }
    
    function cadastrar (){
        $dados['marca'] = $this->marca_model->get_all();
        $dados['ar'] = $this->config->item('ar');
        $dados['cambio'] = $this->config->item('cambio');
        $dados['abs'] = $this->config->item('abs');
        
        $dados['titulo'] = 'Cadastrar veiculo';
        $dados['view']   = $this->config->item('area_admin') . '/veiculo/editar';
        $dados['js'][]   = 'plugins/jquery.validate';
        $dados['js'][]   = 'pages/editar_veiculo';
        
        $this->load->view($this->config->item('area_admin') . '/layout',$dados);
    }
    
    function salvar () {
        
        
        
        
    }
    
}
