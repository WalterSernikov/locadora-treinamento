<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Library criada para criar o menu do usuario
 * 
 * @package application/libraries
 * @name Autenticacao
 * @author Joao Claudio Dias Araujo <joao.araujo@tellks.com.br>
 */
class Autenticacao {
    
    private $CI;
    
    function __construct() {
        
        $this->CI = &get_instance();
        
        $this->CI->load->model($this->CI->config->item('area_admin') . '/autenticacao_model');
    }
    
    /**
     * Recebe as credenciais do usuario e verifica se ele possui acesso ao sistema
     * 
     * @param string $email
     * @param string $senha
     * @return boolean
     */
    function autenticar($email, $senha){
        
        $this->CI->load->library('encrypt');
        
        $usuario = $this->CI->autenticacao_model->get_user($email);
        
        if($usuario){
            
            if($this->CI->encrypt->decode($usuario->senha) === $senha){
                
                $this->set_user_data($usuario);
                
                return TRUE;
            }
        }
        return FALSE;
    }
    
    /**
     * Grava os dados do usuario na sessao
     * 
     * @param sdtClass Object $usuario Dados do usuario
     * @return void
     */
    function set_user_data($usuario){
        
        $user_data = array(
            'nome'       => $usuario->nome,
            'usuario_id' => $usuario->idU,
            'grupos'     => $usuario->grupos,
            'funcionario_id' => $usuario->idF
        );
        
        $this->CI->session->set_userdata($user_data);
    }
    
    /**
     * Verifica se o usuario esta autenticado
     * 
     * @return boolean
     */
    function verifica_autenticacao(){
        
        // Busca o id do usuario no banco
        $usuario_id = (int)$this->CI->session->userdata('usuario_id');
        
        if($usuario_id > 0){
            
            return TRUE;
        }else{
            
            return FALSE;
        }
    }
    
    /**
     * Verifica se o usuario logado possui acesso a funcionalidade que ele tenta acessar
     * 
     * @return boolean
     */
    function verifica_acesso(){
        
        // Captura a controladora que ele tenta acessar
        $controladora = $this->CI->uri->segment(2);
        
        // Se foi especificada uma controladora
        if(!empty($controladora)){
            
            // Busca os grupos do usuario na sessao
            $grupos_usuario = $this->CI->session->userdata('grupos');
            
            // Busca a permissao do usuario para acessar a controladora
            $permissao = $this->CI->autenticacao_model->get_permission($controladora, $grupos_usuario);
            
            // Se encontrou a permissao 
            if($permissao){
                
                return TRUE;
            }
        }
        return FALSE;
    }
}