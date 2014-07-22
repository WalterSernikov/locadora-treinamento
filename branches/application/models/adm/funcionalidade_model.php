<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Realiza a interacao entre a aplicacao e a tabela de funcionalidades no banco de dados
 * 
 * @package application/models/adm
 * @name Funcionalidade_model
 * @author Joao Claudio Dias Araujo <joao.araujo@tellks.com.br>
 */
class Funcionalidade_model extends CI_Model{
    
    private $tabela;
    
    function __construct() {
        parent::__construct();
        
        $this->tabela = 'funcionalidade';
    }
         
    /**
     * Busca todas a funcionalidades do banco de dados
     * 
     * @return array
     */
    function get_all(){
        
        $funcionalidades = $this->db->get($this->tabela);
        
        if($funcionalidades->num_rows() > 0){
            
            return $funcionalidades->result();
        }
        else {
            
            return array();
        }
    }
    
    /**
     * Busca os dados de uma funcionalidade pelo seu ID
     * 
     * @param int $id ID da funcionalidade
     * @return mixed
     */
    function get_by_id($id){
        
        $this->db->select('*');
        
        $this->db->from($this->tabela);
        
        $this->db->where('id', (int)$id);
        
        $funcionalidade = $this->db->get();
        
        if($funcionalidade->num_rows() > 0){
            
            return $funcionalidade->row(0);
        }
        else{
            
            return false;
        }
    }
            
    /**
     * Insere uma funcionalidade no banco de dados
     * 
     * @param sdtClass Object $funcionalidade Objeto contendo os dados da funcionalidade
     * @return boolean
     */
    function inserir($funcionalidade){
        
        $this->db->insert($this->tabela,$funcionalidade);
        
        return (bool)$this->db->affected_rows();
    }
    
    /**
     * atualiza uma funcionalidade no banco de dados
     * 
     * @param sdtClass Object $funcionalidade Objeto contendo os dados da funcionalidade
     * @return boolean
     */
    function atualizar($funcionalidade){
        
        $this->db->where('id', (int)$funcionalidade->id);
        
        $this->db->update($this->tabela,$funcionalidade);
        
        return (bool)$this->db->affected_rows();
    }
    
    /**
     * Remove uma funcionalidade do banco de dados
     * 
     * @param int $id ID da funcionalidade a ser removida
     * @return boolean
     */
    function remover($id){
        
        $this->db->where('id', (int)$id);
        
        $this->db->delete($this->tabela);
        
        return (bool)$this->db->affected_rows();
    }
    
    /**
     * Busca as permissoes de acesso das funcinalidades cadastradas
     * 
     * @return array
     */
    function get_permissoes() {
        
        $this->db->select('*');

        $this->db->from('funcionalidade_grupo');

        $resultado = $this->db->get();
       
        if ($resultado->num_rows > 0) {
            
            return $resultado->result();
        }
        else {
            
            return array();
        }
    }
    
    /**
     * Seta as novas permissoes de acesso das funcionalidades cadastradas
     * 
     * @param array $fun_grupos Array contendo as novas permissoes de acesso de todas
     *  as funcionalidades
     * @return boolean
     */
    function set_permissoes($fun_grupos = array()) {

        // Array que armazenara os dados a serem inseridos
        $insert_array = array();
        
        for ($i = 0; $i < sizeof($fun_grupos); $i++) {

            for ($j = 0; $j < sizeof($fun_grupos[$i]['grupos']); $j++) {

                $insert_array[] = array(
                    'funcionalidade_id' => $fun_grupos[$i]['fun_id'],
                    'grupo_id' => $fun_grupos[$i]['grupos'][$j]
                );
            }
        }
        
        $this->db->trans_start();
        
        // Remove as permissoes antigas
        $this->db->delete('funcionalidade_grupo',array('funcionalidade_id >' => 0));
        
        // Insere as novas permissoes
        if(sizeof($insert_array) > 0) {
            
            $this->db->insert_batch('funcionalidade_grupo', $insert_array);
        }
        
        $this->db->trans_complete();
        
        return $this->db->trans_status();
    }
}