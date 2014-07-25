<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of veiculo_model
 *
 * @author tellks
 */
class Veiculo_model extends CI_Model {

    private $tabela;

    function __construct() {
        parent::__construct();
        $this->tabela = 'veiculo';
    }

    function get_all() {
        $resultado = $this->db->get($this->tabela);
        if ($resultado->num_rows() > 0) {
            return $resultado->result();
        } else {
            return array();
        }
    }

    function get_by_id($id) {

        $this->db->select('*');

        $this->db->from($this->tabela);

        $this->db->where('id', (int) $id);

        $marca = $this->db->get();

        if ($marca->num_rows() > 0) {

            return $marca->row(0);
        } else {

            return false;
        }
    }
    
    function get_by_placa($placa,$id = 0){
        
        $this->db->select('*');
        
        $this->db->from($this->tabela);
        
        $this->db->where('placa',$placa);
        
        if ($id > 0) {
            
            $this->db->where_not_in('id',$id);
        }
        
        $resultado = $this->db->get();
        
        if($resultado->num_rows() > 0){
            
            return $resultado->row(0);
            
        }else{
            return FALSE;
        }
       // return $this->db->last_query();
    }

    function get_veiculos() {
        $this->db->select('id,modelo,cor,placa');
        $this->db->from($this->tabela);
        $this->db->where('status', (int) 0);

        $resultado = $this->db->get();

        $retorno = array();
        if ($resultado->num_rows() > 0) {
            foreach ($resultado->result() as $veiculo) {
                $retorno[$veiculo->id] = $veiculo->modelo . ', ' . $veiculo->cor . ', ' . $veiculo->placa;
            }
        }
        return $retorno;
    }

    function inserir($veiculo) {
        $this->db->insert($this->tabela, $veiculo);

        return (bool) $this->db->affected_rows();
    }

    function atualizar($veiculo) {

        $this->db->where('id', (int) $veiculo->id);

        $this->db->update($this->tabela, $veiculo);

        return (bool) $this->db->affected_rows();
    }

    function remover($id) {

        $this->db->where('id', (int) $id);

        $this->db->delete($this->tabela);

        return (bool) $this->db->affected_rows();
    }

}
