<?php if (!defined('BASEPATH'))  exit('No direct script access allowed');

/**
 * Controladora de logout
 * 
 * @package application/controllers/adm
 * @name Logout
 * @author Joao Claudio Dias Araujo <joao.araujo@tellks.com.br>
 */
class Logout extends CI_Controller{
    
    /**
     * Remove a autenticacao do usuario e redireciona para a tela de login
     * 
     * @return void
     */
    function index(){
        
        $this->session->sess_destroy();
        
        redirect($this->config->item('area_admin') . '/login');
    }
}