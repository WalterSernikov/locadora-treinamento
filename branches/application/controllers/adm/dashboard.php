<?php if (!defined('BASEPATH'))  exit('No direct script access allowed');

/**
 * Description of dashboard
 *
 * @author jklaus
 */
class Dashboard extends TR_Controller{
    
    function __construct() {
        parent::__construct();
    }
            
    function index(){
        
        $dados['titulo'] = 'Dashboard';
        $dados['view']   = $this->config->item('area_admin') . '/dashboard/index';
        
        $this->load->view($this->config->item('area_admin') . '/layout',$dados);
    }
}