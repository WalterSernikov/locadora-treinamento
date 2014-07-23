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
            return $resultado->result(0);
        }else{
            return array();
        }
    }
}
