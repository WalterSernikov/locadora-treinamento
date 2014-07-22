<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Realiza a interacao entre a aplicacao e a tabela de grupos no banco de dados
 * 
 * @package application/models/adm
 * @name Grupo_model
 * @author Joao Claudio Dias Araujo <joao.araujo@tellks.com.br>
 */
class Grupo_model extends CI_Model{
    
    private $tabela;
    
    function __construct() {
        parent::__construct();
        
        $this->tabela = 'grupo';
    }
            
    /**
     * Busca todos os grupos do banco de dados
     * 
     * @return array
     */
    function get_all(){
        
        $grupos = $this->db->get($this->tabela);
        
        if($grupos->num_rows() > 0){
            
            return $grupos->result();
        }
        else {
            
            return array();
        }
    }
    
    /**
     * Busca os dados de um grupo pelo seu ID
     * 
     * @param int $id ID do grupo
     * @return mixed
     */
    function get_by_id($id){
        
        $this->db->select('*');
        
        $this->db->from($this->tabela);
        
        $this->db->where('id', (int)$id);
        
        $grupo = $this->db->get();
        
        if($grupo->num_rows() > 0){
            
            return $grupo->row(0);
        }
        else{
            
            return false;
        }
    }
            
    /**
     * Insere um grupo no banco de dados
     * 
     * @param sdtClass Object $grupo Objeto contendo os dados do grupo
     * @return boolean
     */
    function inserir($grupo){
        
        $this->db->insert($this->tabela,$grupo);
        
        return (bool)$this->db->affected_rows();
    }
    
    /**
     * atualiza um grupo no banco de dados
     * 
     * @param sdtClass Object $grupo Objeto contendo os dados do grupo
     * @return boolean
     */
    function atualizar($grupo){
        
        $this->db->where('id', (int)$grupo->id);
        
        $this->db->update($this->tabela,$grupo);
        
        return (bool)$this->db->affected_rows();
    }
    
    /**
     * Remove um grupo do banco de dados
     * 
     * @param int $id ID do grupo a ser removido
     * @return boolean
     */
    function remover($id){
        
        $this->db->where('id', (int)$id);
        
        $this->db->delete($this->tabela);
        
        return (bool)$this->db->affected_rows();
    }
}