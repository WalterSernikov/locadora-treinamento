<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Description of controle_acesso
 *
 * @author jklaus
 */
class Controle_acesso extends TR_Controller{
    
    function __construct() {
        parent::__construct();
        
        if(!$this->autenticacao->verifica_acesso()){
            
            redirect($this->config->item('area_admin') . '/acesso_negado');
        }
        
        $this->load->model(array(
            $this->config->item('area_admin') . '/funcionalidade_model',
            $this->config->item('area_admin') . '/grupo_model',
        ));
    }
            
    function index(){
        
        $this->editar();
    }
    
    function editar(){
        
        $dados['funcionalidades'] = $this->funcionalidade_model->get_all();
        $dados['permissoes']      = $this->funcionalidade_model->get_permissoes();
        $dados['grupos']          = $this->grupo_model->get_all();
        
        $dados['titulo'] = 'Controle de acesso';
        $dados['view']   = $this->config->item('area_admin') . '/controle_acesso/editar';
        
        $this->load->view($this->config->item('area_admin') . '/layout',$dados);
    }
    
    function salvar(){
        
        $funcionalidades = $this->funcionalidade_model->get_all();
        
        $k = 0;
        $fun_grupos = array();
        
        foreach($funcionalidades as $f) {
            
            if($this->input->post('grupos' . $f->id) != '') {
                
                $fun_grupos[$k]['fun_id'] = $f->id;
                $fun_grupos[$k]['grupos'] = $this->input->post('grupos' . $f->id);
                $k++;
            }
        }
        
        $resultado = $this->funcionalidade_model->set_permissoes($fun_grupos);
        
        if ($resultado == TRUE) {

            $mensagem = array('msg' => 'sucesso', 'tipo' => 'info');
        } else {
            $mensagem = array('msg' => 'erro', 'tipo' => 'danger');
        }

        $this->session->set_flashdata('msg', $mensagem);
        // Redireciona
        redirect($this->config->item('area_admin') . '/controle_acesso', 'refresh');
    }
}