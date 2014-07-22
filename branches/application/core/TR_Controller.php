<?php if (!defined('BASEPATH'))  exit('No direct script access allowed');

/**
 * Controladora base criada para centralizar metodos comuns a todas as controladoras
 * 
 * @package application/core
 * @name TR_Controller
 * @author Joao Claudio Dias Araujo <joao.araujo@tellks.com.br>
 */
class TR_Controller extends CI_Controller{
    
    function __construct() {
        parent::__construct();
        
        $autenticado = $this->autenticacao->verifica_autenticacao();
        
        if(!$autenticado){
            
            redirect($this->config->item('area_admin') . '/login');
        }
    }
}