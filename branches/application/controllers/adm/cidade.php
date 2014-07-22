<?php if (!defined('BASEPATH'))  exit('No direct script access allowed');
/**
 * Description of cidade
 *
 * @author jklaus
 */
class Cidade extends TR_Controller{
    
    function load_cidades(){
        
        $this->load->model($this->config->item('area_admin') . '/cidade_model');
        
        $uf = $this->input->post('uf');
        
        $cidades = $this->cidade_model->get_cid_UF($uf);
        
        foreach ($cidades as $key =>$value){
            
            echo '<option value="' . $key .'">' . $value . '</option>';
        }
        
    }
}