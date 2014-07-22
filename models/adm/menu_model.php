<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Realiza a interacao entre a library de menu o banco de dados
 * 
 * @package application/models/adm
 * @name Menu_model
 * @author Joao Claudio Dias Araujo <joao.araujo@tellks.com.br>
 */
class Menu_model extends CI_Model{
    
    function __construct() {
        parent::__construct();
    }
    
    /**
     * Busca os itens de menu em funcao dos grupos de usuario para que apareca no
     * menu apenas os itens que o usuario tem acesso
     * 
     * @param array $grupos Grupos de usuario 
     * @return array
     */
    function get_itens_menu($grupos){
        
        $this->db->select('f.nome,f.url,f.icone');
        
        $this->db->from('funcionalidade AS f');
        
        $this->db->join('funcionalidade_grupo AS fg','fg.funcionalidade_id = f.id');
        
        $this->db->where('f.status',1);
        
        $this->db->where_in($grupos);
        
        $this->db->group_by('f.id');
        
        $this->db->order_by('f.posicao_menu');
        
        $resultado = $this->db->get();
        
        if($resultado->num_rows() > 0){
            
            return $resultado->result();
        }
        else{
            return array();
        }
    }
}