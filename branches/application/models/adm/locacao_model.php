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
    
    
}
