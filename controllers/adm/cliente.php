<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Cliente extends TR_Controller{
    
    
    function __construct() {
        
        parent::__construct();
        
        // Verifica o acesso do cliente a esta funcionalidade
        if(!$this->autenticacao->verifica_acesso()){
            
            redirect($this->config->item('area_admin') . '/acesso_negado');
        }
        
       // Carrega as configuracoes do cliente
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
        
//        echo '<pre>';
//        print_r($dados['cliente']);
//        die('</pre>');
        
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
    
    function salvar(){
        
        // Busca as regras de validacao nos arquivos de configuracao
        $regras = $this->config->item('regras_validacao');
        
        // Seta as regras na library de validacao
        $this->form_validation->set_rules($regras);
        
        // Seta o html das mensagens de validacao
        $this->form_validation->set_error_delimiters('<label class="error">', '</label>');
        
        $cliente = new stdClass();
        

        $id = $this->input->post('id');
        $cliente->nome = $this->input->post('nome');
        $cliente->email = $this->input->post('email');
        $cliente->sexo = $this->input->post('sexo');
        $cliente->telefone = $this->input->post('telefone');
        $cliente->endereco = $this->input->post('endereco');
        $cliente->numero = $this->input->post('numero');
        $cliente->bairro = $this->input->post('bairro');
        $cliente->cidade = $this->input->post('cidade');
        $cliente->cpf = $this->input->post('cpf');
        $cliente->rg = $this->input->post('rg');
        
        // Executa a validacao
        if ($this->form_validation->run() === FALSE) {
            
            // Caso os dados sejam invalidos exibe o formulario de validacao novamente
            
            $cliente->id = $id;
            $dados['cliente'] = $cliente; 
            
            
            $dados['ufs'] = $this->cidade_model->get_UFs();
            
            
            $dados['titulo'] = 'Editar funcionario';
            $dados['view']   = $this->config->item('area_admin') . '/clientes/editar';
            $dados['js'][]   = 'plugins/jquery.validate';
            $dados['js'][]   = 'pages/editar_cliente';
            
            $this->load->view($this->config->item('area_admin') . '/layout',$dados);
        } else {

            // Verifica se deve atualizar ou inserir o registro
            if (empty($id)) {

                // Caso nao seja informado o ID do registro a ser atualizado insere um novo
                $resultado = $this->cliente_model->inserir($cliente);
                
                
            } else {

                $cliente->id = $id;
                $resultado = $this->cliente_model->atualizar($cliente);
            }

            // Captura o resultado da operacao e seta a mensagem a ser exibida para o cliente
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

            // Redireciona o cliente para a tela de gerenciamento
            redirect($this->config->item('area_admin') . '/cliente', 'refresh');
        }
    }
    
    function editar($id){
        
        $dados['cliente'] = $this->cliente_model->get_by_id($id);
        $dados['ufs']     = $this->cidade_model->get_UFs();
        $dados['cidades'] = $this->cidade_model->get_cid_UF($dados['cliente']->uf);
        
//        echo '<pre>';
//        print_r($dados['cliente']);
//        die('</pre>');
//        
        $dados['titulo'] = 'Editar cliente';
        $dados['view']   = $this->config->item('area_admin') . '/cliente/editar';
        $dados['js'][]   = 'plugins/jquery.validate';
        $dados['js'][]   = 'pages/editar_cliente';
        
        $this->load->view($this->config->item('area_admin') . '/layout',$dados);
    }
    
    function remover($id){
        
        // informa o banco de dados qual registro deve ser removido
        $resultado = $this->cliente_model->remover($id);
        
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
        redirect($this->config->item('area_admin') . '/cliente', 'refresh');
    }
}
