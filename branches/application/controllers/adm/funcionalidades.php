<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Controladora do gerenciamento de funcionalidades
 * 
 * @package application/controllers/adm
 * @name Funcionalidades
 * @author Joao Claudio Dias Araujo <joao.araujo@tellks.com.br>
 */
class Funcionalidades extends TR_Controller{
    
    function __construct() {
        
        parent::__construct();
        
        if(!$this->autenticacao->verifica_acesso()){
            
            redirect($this->config->item('area_admin') . '/acesso_negado');
        }
        
        $this->load->config('funcionalidades');
        
        $this->load->model(array(
            $this->config->item('area_admin') . '/funcionalidade_model',
        ));
    }
    
    function index(){
        
        $this->all();
    }
    
    /**
     * Lista os registros cadastrados
     * 
     * @return void
     */
    function all(){
        
        $dados['funcionalidades'] = $this->funcionalidade_model->get_all();
        
        $dados['titulo'] = 'Gerenciar funcionalidades';
        $dados['view']   = $this->config->item('area_admin') . '/funcionalidades/index';
        
        $this->load->view($this->config->item('area_admin') . '/layout',$dados);
    }
    
    /**
     * Exibe o formulario de cadastramento de um novo usuario
     * 
     * @return void
     */
    function cadastrar(){
        
        $dados['titulo'] = 'Cadastrar funcionalidade';
        $dados['view']   = $this->config->item('area_admin') . '/funcionalidades/editar';
        $dados['js'][]   = 'plugins/jquery.validate';
        $dados['js'][]   = 'pages/editar_funcionalidade';
        
        $this->load->view($this->config->item('area_admin') . '/layout',$dados);
    }
    
    /**
     * Recebe o ID do registro a ser editado e exibe o formulario de edicao
     * 
     * @param int $id ID do registro a ser editado
     * @return void
     */
    function editar($id){
        
        $dados['funcionalidade'] = $this->funcionalidade_model->get_by_id($id);
        
        $dados['titulo'] = 'Editar funcionalidade';
        $dados['view']   = $this->config->item('area_admin') . '/funcionalidades/editar';
        $dados['js'][]   = 'plugins/jquery.validate';
        $dados['js'][]   = 'pages/editar_funcionalidade';
        
        $this->load->view($this->config->item('area_admin') . '/layout',$dados);
    }
    
    /**
     * Recebe os dados de um registro, valida seus dados e caso sejam validos os insere
     * no banco de dados, caso contrario exibe o formulario de edicao novamente
     * 
     * @return void
     */
    function salvar(){
        
        // Carrega a library de validacao
        $this->load->library('form_validation');
        
        // Busca as regras de validacao nos arquivos de configuracao
        $regras = $this->config->item('regras_validacao');
        
        // Seta as regras na library de validacao
        $this->form_validation->set_rules($regras);
        
        // Seta o html das mensagens de validacao
        $this->form_validation->set_error_delimiters('<label class="error">', '</label>');
        
        // Executa a validacao
        if ($this->form_validation->run() === FALSE) {
            
            // Caso os dados sejam invalidos exibe o formulario de validacao novamente
            
            $dados['titulo'] = 'Editar funcionalidade';
            $dados['view']   = $this->config->item('area_admin') . '/funcionalidades/editar';
            $dados['js'][]   = 'plugins/jquery.validate';
            $dados['js'][]   = 'pages/editar_funcionalidade';
            
            $this->load->view($this->config->item('area_admin') . '/layout',$dados);
        } else {
            
            // Caso os dados sejam validos salva no banco de dados
            
            $funcionalidade = new stdClass();

            $id                           = $this->input->post('id');
            $funcionalidade->nome         = $this->input->post('nome');
            $funcionalidade->icone        = $this->input->post('icone');
            $funcionalidade->url          = $this->input->post('url');
            $funcionalidade->status       = $this->input->post('status');
            $funcionalidade->posicao_menu = $this->input->post('posicao_menu');
            
            if (empty($id)) {

                // Caso nao seja informado o ID do registro a ser atualizado insere um novo
                $resultado = $this->funcionalidade_model->inserir($funcionalidade);
            } else {

                $funcionalidade->id = $id;
                $resultado = $this->funcionalidade_model->atualizar($funcionalidade);
            }

            // Captura o resultado da operacao e seta a mensagem a ser exibida para o usuario
            if ($resultado) {

                if (empty($id)) {

                    $mensagem = array('msg' => 'insert-ok', 'tipo' => 'success');
                } else {

                    $mensagem = array('msg' => 'update-ok', 'tipo' => 'info');
                }
            } else {
                $mensagem = array('msg' => 'erro', 'tipo' => 'danger');
            }

            // Grava a mensagem numa flashdata
            $this->session->set_flashdata('msg', $mensagem);

            // Redireciona o usuario para a tela de gerenciamento
            redirect($this->config->item('area_admin') . '/funcionalidades', 'refresh');
        }
    }
    
    /**
     * Recebe o ID do registro e executa a remocao
     * 
     * @param int $id ID do registro
     * @return void
     */
    function remover($id){
        
        // informa o banco de dados qual registro deve ser removido
        $resultado = $this->funcionalidade_model->remover($id);
        
        // Captura o resultado da operacao
        if($resultado){
            
            $mensagem = array('msg' =>'delete-ok', 'tipo'=> 'success');
        }
        else{
            $mensagem = array('msg' =>'erro', 'tipo'=> 'danger');
        }
        // Seta a mensagem numa flashdata
        $this->session->set_flashdata('msg',$mensagem);
        
        //Redireciona para a tela de gerenciamento
        redirect($this->config->item('area_admin') . '/funcionalidades', 'refresh');
    }

}