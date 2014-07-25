<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of cliente_model
 *
 * @author tellks
 */
class Cliente_model extends CI_Model{
    private $tabela;
    
    function __construct() {
        parent::__construct();
        
        $this->tabela = 'cliente';
    }
    
    function get_all(){
        
        $resultado = $this->db->get($this->tabela);
        
        if($resultado->num_rows > 0){
            return $resultado->result();
        }else{
            return array();
        }
    }
    
    function inserir($cliente){
        
                
        $this->db->insert($this->tabela, $cliente);
        
        $inseriu_cliente = (bool)  $this->db->affected_rows();
        
        
        return($inseriu_cliente);
    }
    
    
    function get_by_email($email,$id = 0){
        
        $this->db->select('*');
        
        $this->db->from($this->tabela);
        
        $this->db->where('email',$email);
        
        if ($id > 0) {
            
            $this->db->where_not_in('id',$id);
        }
        
        $resultado = $this->db->get();
        if($resultado->num_rows() > 0){
            
            return $resultado->row(0);
        }else{
            return FALSE;
        }
    }
    
    function get_by_cpf($cpf,$id = 0){
        
        $this->db->select('*');
        
        $this->db->from($this->tabela);
        
        $this->db->where('cpf',$cpf);
        
        if ($id > 0) {
            
            $this->db->where_not_in('id',$id);
        }
        
        $resultado = $this->db->get();
        if($resultado->num_rows() > 0){
            
            return $resultado->row(0);
        }else{
            return FALSE;
        }
    }
    /**
     * atualiza um cliente no banco de dados
     * 
     * @param sdtClass Object $cliente Objeto contendo os dados do cliente
     * @return boolean
     */
    function atualizar($cliente){
        
               
        $this->db->where('id', (int)$cliente->id);
        
        $this->db->update($this->tabela,$cliente);
        
        $atualizou_cliente = (bool)$this->db->affected_rows();
        
                
        return ($atualizou_cliente);
    }
    
    /**
     * Remove um cliente do banco de dados
     * 
     * @param int $id ID do cliente a ser removido
     * @return boolean
     */
    function remover($id){
        
        $this->db->where('id', (int)$id);
        
        $this->db->delete($this->tabela);
        
        return (bool)$this->db->affected_rows();
    }
    
    function get_by_id($id){
        
        $this->db->select('cl.*, c.uf');
        
        $this->db->from($this->tabela .  ' AS cl');
        
        $this->db->join('cidade AS c', 'c.id = cl.cidade', 'LEFT');
        
        $this->db->where('cl.id', $id);
        
        $resultado = $this->db->get();
        
        if($resultado->num_rows() > 0){
            
            $cliente = $resultado->row(0);
            
            return $cliente;
        }
        else{
            
            return false;
        }
        
    }
    
    function get_cliente(){
        $this->db->select('id,nome,cpf');
        $this->db->from($this->tabela);
        
        
        $resultado = $this->db->get();
        
        $retorno = array();
        if($resultado->num_rows() > 0){
            foreach($resultado->result() as $cliente){
                $retorno[$cliente->id]=$cliente->nome.', '.$cliente->cpf;
            }
        }
        return $retorno;
    }
    
}
