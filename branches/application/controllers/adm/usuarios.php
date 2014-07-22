<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Controladora do gerenciamento de usuarios
 * 
 * @package application/controllers/adm
 * @name Usuarios
 * @author Joao Claudio Dias Araujo <joao.araujo@tellks.com.br>
 */
class Usuarios extends TR_Controller{
    
    function __construct() {
        
        parent::__construct();
        
        // Verifica o acesso do usuario a esta funcionalidade
        if(!$this->autenticacao->verifica_acesso()){
            
            redirect($this->config->item('area_admin') . '/acesso_negado');
        }
        
       // Carrega as configuracoes do usuario
        $this->load->config('usuarios');
        
        // Carrega a library de criptografia para criptografar a senha
        $this->load->library('encrypt');
        
        // Carrega a library de validacao
        $this->load->library('form_validation');
        
        // Carrega models utilizadas
        $this->load->model(array(
            $this->config->item('area_admin') . '/usuario_model',
            $this->config->item('area_admin') . '/cidade_model',
            $this->config->item('area_admin') . '/grupo_model'
        ));
    }
    
    function index(){
        
        // Delega a acao a ser executada para o metodo all
        $this->all();
    }
    
    /**
     * Lista os registros cadastrados
     * 
     * @return void
     */
    function all(){
        
        $dados['usuarios'] = $this->usuario_model->get_all();
        
        $dados['titulo'] = 'Gerenciar usuários';
        $dados['view']   = $this->config->item('area_admin') . '/usuarios/index';
        
        $this->load->view($this->config->item('area_admin') . '/layout',$dados);
    }
    
    /**
     * Exibe o formulario de cadastramento de um novo usuario
     * 
     * @return void
     */
    function cadastrar(){
        
        $dados['ufs']    = $this->cidade_model->get_UFs();
        $dados['grupos'] = $this->grupo_model->get_all();
        
        $dados['titulo'] = 'Cadastrar usuário';
        $dados['view']   = $this->config->item('area_admin') . '/usuarios/editar';
        $dados['js'][]   = 'plugins/jquery.validate';
        $dados['js'][]   = 'pages/editar_usuario';
        
        $this->load->view($this->config->item('area_admin') . '/layout',$dados);
    }
    
    /**
     * Recebe o ID do registro a ser editado e exibe o formulario de edicao
     * 
     * @param int $id ID do registro a ser editado
     * @return void
     */
    function editar($id){
        
        $dados['usuario'] = $this->usuario_model->get_by_id($id);
        $dados['ufs']     = $this->cidade_model->get_UFs();
        $dados['cidades'] = $this->cidade_model->get_cid_UF($dados['usuario']->uf);
        $dados['grupos']  = $this->grupo_model->get_all();
        
        $dados['titulo'] = 'Editar usuário';
        $dados['view']   = $this->config->item('area_admin') . '/usuarios/editar';
        $dados['js'][]   = 'plugins/jquery.validate';
        $dados['js'][]   = 'pages/editar_usuario';
        
        $this->load->view($this->config->item('area_admin') . '/layout',$dados);
    }
    
    /**
     * Recebe os dados de um registro, valida seus dados e caso sejam validos os insere
     * no banco de dados, caso contrario exibe o formulario de edicao novamente
     * 
     * @return void
     */
    function salvar(){
        
        // Busca as regras de validacao nos arquivos de configuracao
        $regras = $this->config->item('regras_validacao');
        
        // Seta as regras na library de validacao
        $this->form_validation->set_rules($regras);
        
        // Seta o html das mensagens de validacao
        $this->form_validation->set_error_delimiters('<label class="error">', '</label>');
        
        $usuario = new stdClass();

        $id = $this->input->post('id');
        $usuario->nome = $this->input->post('nome');
        $usuario->email = $this->input->post('email');
        $usuario->sexo = $this->input->post('sexo');
        $usuario->telefone = $this->input->post('telefone');
        $usuario->logradouro = $this->input->post('logradouro');
        $usuario->numero = $this->input->post('numero');
        $usuario->bairro = $this->input->post('bairro');
        $usuario->cidade = $this->input->post('cidade');
        $usuario->status = $this->input->post('status');
        $usuario->grupos = $this->input->post('grupos');
        // Executa a validacao
        if ($this->form_validation->run() === FALSE) {
            
            // Caso os dados sejam invalidos exibe o formulario de validacao novamente
            
            $usuario->id = $id;
            $dados['usuario']=$usuario; 
            
            $dados['ufs'] = $this->cidade_model->get_UFs();
            $dados['grupos']  = $this->grupo_model->get_all();
            
            $dados['titulo'] = 'Editar usuário';
            $dados['view']   = $this->config->item('area_admin') . '/usuarios/editar';
            $dados['js'][]   = 'plugins/jquery.validate';
            $dados['js'][]   = 'pages/editar_usuario';
            
            $this->load->view($this->config->item('area_admin') . '/layout',$dados);
        } else {
            
            // Caso os dados sejam validos salva no banco de dados
            
            $senha               = $this->input->post('senha');
            
            
            // Se foi informada a senha do usuario criptografa ela
            if (!empty($senha)) {

                $usuario->senha = $this->encrypt->encode($senha);
            }

            // Verifica se deve atualizar ou inserir o registro
            if (empty($id)) {

                // Caso nao seja informado o ID do registro a ser atualizado insere um novo
                $resultado = $this->usuario_model->inserir($usuario);
            } else {

                $usuario->id = $id;
                $resultado = $this->usuario_model->atualizar($usuario);
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
            redirect($this->config->item('area_admin') . '/usuarios', 'refresh');
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
        $resultado = $this->usuario_model->remover($id);
        
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
        redirect($this->config->item('area_admin') . '/usuarios', 'refresh');
    }
    
    /**
     * Verifica se o campo senha foi preenchido
     * 
     * @return boolean
     */
    function valida_senha(){
        
        $id    = $this->input->post('id');
        $senha = $this->input->post('senha');
        
        $this->form_validation->set_message('valida_senha', 'O campo senha é obrigatório.');
        
        // Verifica o campo ID pois a senha so e obrigatoria no cadastramento
        if(empty($id) && empty($senha)){
            
            return FALSE;
        }
        else{
            return TRUE;
        }
        
    }
    
    function valida_email ($tipo_requisicao= 'http'){
        
        $email= $this->input->post('email');
        $id= $this->input->post('id');
        
        $usuario = $this->usuario_model->get_by_email($email,$id);
        
        if($usuario){
            $this->form_validation->set_message('valida_email','Já existe um usuário cadastrado com este email.');
            $resultado = FALSE;
            
        }else{
            
            $resultado = TRUE;
        }
        if ($tipo_requisicao === 'http'){
            return $resultado;
            
        }else{
            echo $resultado;
            
        }
}
}