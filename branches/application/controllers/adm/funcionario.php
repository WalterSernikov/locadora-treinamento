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
class Funcionario extends CI_Controller{
    public function index(){
        $this->all();
    }
    
    public function all(){
        $dados['view'] = '/funcionario';
        $dados['titulo'] = 'Gerenciar Funcionario';
        
        $this->load->view($this->config->item('area_admin').'/layout',$dados);
    }
}
