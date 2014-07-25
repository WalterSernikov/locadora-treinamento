<?php if (!defined('BASEPATH'))  exit('No direct script access allowed');

/**
 * Controladora de login
 * 
 * @package application/controllers/adm
 * @name Login
 * @author Joao Claudio Dias Araujo <joao.araujo@tellks.com.br>
 */
class Login extends CI_Controller{
    
    function __construct() {
        parent::__construct();
        
        // Verifica se o usuario ja esta autenticado
        $resultado = $this->autenticacao->verifica_autenticacao();
        
        // Se o usuario ja estive autenticado redireciona ele para a dashboard
        if($resultado){
            
            redirect($this->config->item('area_admin') . '/locacao');
        }
        
         $this->load->library('form_validation');
    }
    
    function index(){
        
        $this->load->view($this->config->item('area_admin') . '/login');
    }
    
    function autenticar(){
        
        $regras = array(
            array(
                'field' => 'email',
                'label' => 'e-mail',
                'rules' => 'trim|required|valid_email'
            ),
            array(
                'field' => 'senha',
                'label' => 'Senha',
                'rules' => 'trim|required'
            ),
        );
        
        // Seta as regras de validacao do formulario de login
        $this->form_validation->set_rules($regras);
        
        // Seta o html das mensagens da validacao
        $this->form_validation->set_error_delimiters('<label class="error">','</label>');
        
        // Executa a validacao
        if($this->form_validation->run() === FALSE){
            
            // Se nao passou nas regras de validacao exibe a view de login
            $this->load->view($this->config->item('area_admin') . '/login');
        }
        else{
            
            // Se passou na validacao tenta autenticar o usuario no banco de dados
            
            $email = $this->input->post('email');
            $senha = $this->input->post('senha');
            
            // Delega a funcao de autenticar para library de autenticacao
            $resultado = $this->autenticacao->autenticar($email,$senha);
            
            // Verifica o resultado da autenticacao
            if($resultado){
                
                // Se autenticou redireciona para a dashboard
                redirect($this->config->item('area_admin') . '/locacao', 'refresh');
            }
            else{
                
                // Se nao autenticou exibe o formulario de login
                
                $dados['msg'] = 'Usuário ou senha incorretos';
                
                $this->load->view($this->config->item('area_admin') . '/login',$dados);
            }
        }
    }
    
}