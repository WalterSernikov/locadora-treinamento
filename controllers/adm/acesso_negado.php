<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of acesso_negado
 *
 * @author jklaus
 */
class Acesso_negado extends CI_Controller{
    
    function __construct() {
        parent::__construct();
        
        $autenticado = $this->autenticacao->verifica_autenticacao();
        
        if(!$autenticado){
            
            redirect($this->config->item('area_admin') . '/login');
        }
    }
    
    function index(){
        
        echo 'Acesso negado';
    }
}