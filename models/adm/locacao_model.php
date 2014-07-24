<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of locacao
 *
 * @author tellks
 */
class Locacao_model extends CI_Model{
    private $tabela;
    
    function __construct() {
        parent::__construct();
        
        $this->tabela = 'locacao';
    }
    
    function get_all(){
        $this->db->select('lc.*,vc.modelo,vc.placa,us.nome AS nome_fun,cl.nome AS nome_cli');
        $this->db->from($this->tabela.' AS lc');
        $this->db->join('funcionario as fn', 'fn.id = lc.funcionario_id');
        $this->db->join('usuario AS us', 'us.id = fn.usuario_id ');
        $this->db->join('veiculo AS vc', 'vc.id = lc.veiculo_id');
        $this->db->join('cliente AS cl', 'cl.id = lc.cliente_id');
        $resultado = $this->db->get();
        
        if($resultado->num_rows()>0){
            return $resultado->result();
        }else{
            return array();
        }
    }
    
    function get_by_id($id){
        $this->db->select('lc.*,vc.modelo,vc.placa,us.nome AS nome_fun,cl.nome AS nome_cli');
        $this->db->from($this->tabela.' AS lc');
        $this->db->join('funcionario as fn', 'fn.id = lc.funcionario_id');
        $this->db->join('usuario AS us', 'us.id = fn.usuario_id ');
        $this->db->join('veiculo AS vc', 'vc.id = lc.veiculo_id');
        $this->db->join('cliente AS cl', 'cl.id = lc.cliente_id');
        $this->db->where('lc.id',$id);
        $resultado = $this->db->get();
        
        if($resultado->num_rows()>0){
            return $resultado->row(0);
        }else{
            return array();
        }
    }
    
    function valida_data($data_ini, $data_fim, $veiculo,$id){
        $data_ini = implode('-', array_reverse(explode('/', $data_ini)));
        $data_fim = implode('-', array_reverse(explode('/', $data_fim)));
        
        $this->db->select('locacao.id');
        $this->db->from($this->tabela);
        $this->db->join('veiculo', 'veiculo.id = locacao.veiculo_id');
        $this->db->where('locacao.veiculo_id',$veiculo);
        $this->db->where('locacao.id !=',$id);
        $this->db->where('data_ini >=',$data_ini);
        $this->db->where('data_ini <=',$data_fim);
        $this->db->or_where('data_fim',$data_ini);
        
        
        $resultado = $this->db->get();
        
        if($resultado->num_rows() == 0){
            return TRUE;
        }else{
            return FALSE;
        }
    }
    
    function preco_diaria($veiculo){
        
        $this->db->select('valor_diaria,valor_veiculo');
        $this->db->from('veiculo');
        $this->db->where('id',$veiculo);
        $resultado = $this->db->get();
        
        if($resultado->num_rows() > 0){
            
            $veiculo = $resultado->row(0);
            
            return $veiculo;
            
        }else{
            
            return new stdClass();
        }
    }
    
    function remover($id){
         $this->db->where('id', (int)$id);
        
         $this->db->delete($this->tabela);
        
        $remocao_locacao = (bool)$this->db->affected_rows();
        
        return ($remocao_locacao);
        
        
    }
    
    function inserir($locacao){
        $this->db->insert($this->tabela, $locacao);
        
        return (bool)$this->db->affected_rows();
    }
    
    function alterar($locacao){
        $this->db->where('id', (int)$locacao->id);
        
        $this->db->update($this->tabela,$locacao);
        
        return (bool)$this->db->affected_rows();
    }
    
}
