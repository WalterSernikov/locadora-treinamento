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
class Veiculo_model extends CI_Model{
    
    private $tabela;
    
    function __construct() {
        parent::__construct();
        $this->tabela = 'veiculo';
    }
    
    function get_all(){
        $resultado = $this->db->get($this->tabela);
        if($resultado->num_rows() > 0){
            return  $resultado->result();
        }
        else{
            return array();
        }
    }
}
