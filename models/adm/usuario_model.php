<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Realiza a interacao entre a aplicacao e a tabela de usuarios no banco de dados
 * 
 * @package application/models/adm
 * @name Usuario_model
 * @author Joao Claudio Dias Araujo <joao.araujo@tellks.com.br>
 */
class Usuario_model extends CI_Model{
    
    private $tabela;
    
    function __construct() {
        parent::__construct();
        
        $this->tabela = 'usuario';
    }
            
    /**
     * Busca todos os usuarios do banco de dados
     * 
     * @return array
     */
    function get_all(){
        
        $usuarios = $this->db->get($this->tabela);
        
        if($usuarios->num_rows() > 0){
            
            return $usuarios->result();
        }
        else {
            
            return array();
        }
    }
    
    /**
     * Busca os dados de um usuario pelo seu ID
     * 
     * @param int $id ID do grupo
     * @return mixed
     */
    function get_by_id($id){
        
        $this->db->select('u.*, c.uf, ug.grupo_id');
        
        $this->db->from($this->tabela .  ' AS u');
        
        $this->db->join('cidade AS c', 'c.id = u.cidade', 'LEFT');
        
        $this->db->join('usuario_grupo AS ug', 'ug.usuario_id = u.id', 'LEFT');
        
        $this->db->where('u.id', $id);
        
        $resultado = $this->db->get();
        
        if($resultado->num_rows() > 0){
            
            $usuario = $resultado->row(0);
            
            $usuario->grupos = array();
            
            foreach ($resultado->result() as $g){
                
                $usuario->grupos[] = $g->grupo_id;
            }
            
            return $usuario;
        }
        else{
            
            return false;
        }
        
    }
    
    function get_by_cpf($cpf,$id = 0){
        
        $this->db->select('*');
        
        $this->db->from($this->tabela);
        
        $this->db->join('funcionario', 'funcionario.usuario_id = usuario.id');
        
        $this->db->where('funcionario.cpf',$cpf);
        
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
     * Insere um usuario no banco de dados
     * 
     * @param sdtClass Object $usuario Objeto contendo os dados do usuario
     * @return boolean
     */
    function inserir($usuario,$funcionario){
        
        $grupos = $usuario->grupos;
        
        unset($usuario->grupos);
        
        $this->db->insert($this->tabela, $usuario);
        
        $inseriu_usuario = (bool)  $this->db->affected_rows();
        
        $id = $this->db->insert_id();
        
        
        
        $inseriu_grupos = $this->salvar_grupos($id,$grupos);
        
        $inseriu_funcionario = $this->salvar_funcionario($id,$funcionario);
        
        return($inseriu_usuario && $inseriu_grupos && $inseriu_funcionario);
    }
    
    /**
     * atualiza um usuario no banco de dados
     * 
     * @param sdtClass Object $usuario Objeto contendo os dados do usuario
     * @return boolean
     */
    function atualizar($usuario,$funcionario){
        
        $grupos = $usuario->grupos;
        
        unset($usuario->grupos);
        
        $this->db->where('id', (int)$usuario->id);
        
        $this->db->update($this->tabela,$usuario);
        
        $atualizou_usuario = (bool)$this->db->affected_rows();
        
        $removeu_grupos = $this->remover_grupos($usuario->id);
        
        $inseriu_grupos = $this->salvar_grupos($usuario->id, $grupos);
        
        $inseriu_funcionario = $this->salvar_funcionario($usuario->id,$funcionario);
        
        return ($atualizou_usuario || ($removeu_grupos || $inseriu_grupos) || $inseriu_funcionario);
    }
    
    /**
     * Remove um usuario do banco de dados
     * 
     * @param int $id ID do usuario a ser removido
     * @return boolean
     */
    function remover($id){
        
        $this->db->where('id', (int)$id);
        
        $this->db->delete($this->tabela);
        
        $remocao_usuario = (bool)$this->db->affected_rows();
        
        
        
        $this->db->where('usuario_id', (int)$id);
        $this->db->delete('funcionario');
        
        $remocao_funcionario = (bool)$this->db->affected_rows();
        
        return ($remocao_funcionario && $remocao_usuario);
    }
    
    /**
     * Insere o usuario nos grupos recebidos por paramentro
     * 
     * @param int $id ID do usuario
     * @param array $grupos Grupos do usuario
     * @return boolean
     */
    function salvar_grupos($id, $grupos){
        
        $insert_array = array();
        
        //Itera sob os grupos selecionados no formulario preparando o array para 
        // Insercao em lote
        foreach ($grupos as $g){
            
            $insert_array[] = array(
                'usuario_id' => $id,
                'grupo_id'   => $g
            );
        }
        
        // Se ha valores a serem inseridos
        if(sizeof($insert_array) > 0 ){
            
            // Realiza a insercao em lote
            $this->db->insert_batch('usuario_grupo', $insert_array);
            
            return (bool)$this->db->affected_rows();
        }
        
        return true;
    }
         
    /**
     * Retira o usuario de todos os grupos em que ele esteja inserido
     * @param int $id ID do usuario
     * @return boolean
     */
    function remover_grupos($id){
        
        $this->db->where('usuario_id',(int)$id);
        
        $this->db->delete('usuario_grupo');
        
        return (bool)$this->db->affected_rows();
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
    
    function salvar_funcionario($id,$funcionario){
             
        $this->db->select('id');
        $this->db->from('funcionario');
        $this->db->where('usuario_id',$id);
        $resultado = $this->db->get();
        
        if($resultado->num_rows() > 0){
            
            $this->db->where('usuario_id',$id);
            $this->db->update('funcionario',$funcionario);
            
            return (bool)  $this->db->affected_rows();
            
        } else {
            $funcionario->usuario_id = $id;
            
            $this->db->insert('funcionario',$funcionario);
            
            return (bool) $this->db->affected_rows();
        }
    }
    
    function get_fun_by_id($id){
        
        $this->db->select('*');
        $this->db->from('funcionario');
        $this->db->where('usuario_id',$id);
        $resultado = $this->db->get();
        
        if($resultado->num_rows() > 0){
            
            return $resultado->row(0);
            
        }else{
            return FALSE;
        }
    }
    
}