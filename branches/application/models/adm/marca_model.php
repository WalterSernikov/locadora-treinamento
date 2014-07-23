<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of marca_model
 *
 * @author tellks
 */
class Marca_model extends CI_Model{
    private $tabela;
    
    function __construct() {
        parent::__construct();
        
        $this->tabela = 'marca';
    }
            
    /**
     * Busca todos os marca do banco de dados
     * 
     * @return array
     */
    function get_all(){
        
        $marca = $this->db->get($this->tabela);
        
        if($marca->num_rows() > 0){
            
            return $marca->result();
        }
        else {
            
            return array();
        }
    }
    
    /**
     * Busca os dados de um marca pelo seu ID
     * 
     * @param int $id ID do marca
     * @return mixed
     */
    function get_by_id($id){
        
        $this->db->select('*');
        
        $this->db->from($this->tabela);
        
        $this->db->where('id', (int)$id);
        
        $marca = $this->db->get();
        
        if($marca->num_rows() > 0){
            
            return $marca->row(0);
        }
        else{
            
            return false;
        }
    }
            
    /**
     * Insere um marca no banco de dados
     * 
     * @param sdtClass Object $marca Objeto contendo os dados do marca
     * @return boolean
     */
    function inserir($marca){
        
        $this->db->insert($this->tabela,$marca);
        
        return (bool)$this->db->affected_rows();
    }
    
    /**
     * atualiza um marca no banco de dados
     * 
     * @param sdtClass Object $marca Objeto contendo os dados do marca
     * @return boolean
     */
    function atualizar($marca){
        
        $this->db->where('id', (int)$marca->id);
        
        $this->db->update($this->tabela,$marca);
        
        return (bool)$this->db->affected_rows();
    }
    
    /**
     * Remove um marca do banco de dados
     * 
     * @param int $id ID do marca a ser removido
     * @return boolean
     */
    function remover($id){
        
        $this->db->where('id', (int)$id);
        
        $this->db->delete($this->tabela);
        
        return (bool)$this->db->affected_rows();
    }
}
