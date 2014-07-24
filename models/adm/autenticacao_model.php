<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Realiza as consultas ao banco de dados necessarias para o funcionamento
 * da library de autenticacao
 * 
 * @package application/models/adm
 * @name Autenticacao_model
 * @author Joao Claudio Dias Araujo <joao.araujo@tellks.com.br>
 */
class Autenticacao_model extends CI_Model{
    
    function __construct() {
        parent::__construct();
    }
    
    /**
     * Busca os dados do usuario requisitado no banco de dados
     * 
     * @param string $email E-mail do usuario requisitado
     * @return mixed
     */
    function get_user($email){
       
        // Dados a serem retornados
        $this->db->select('u.id AS idU, u.nome, u.email,u.senha, ug.grupo_id, f.id as idF');
        
        // Join com a tabela de usuario grupo para buscar os seus grupos
        $this->db->join('usuario_grupo AS ug', 'ug.usuario_id = u.id');
        
        $this->db->join ('funcionario AS f', 'f.usuario_id = u.id');
        
        
        $this->db->from('usuario AS u');
        
        $this->db->where('u.email', $email);
        
        $this->db->where('u.status',1);
        
        $resultado = $this->db->get();
        
        // Se a consulta retornou resultados
        if($resultado->num_rows() > 0){
            
            // Captura os dados do usuario
            $usuario = $resultado->row(0);
            $usuario->grupos = array();
            
            // Itera sob o resultado para popular o array com os grupos do usuario
            foreach ($resultado->result() as $g){
                
                $usuario->grupos[] = $g->grupo_id;
            }
            
            // Retorna os dados do usuario
            return $usuario;
        }
        else{
            // Caso nao encontre nenhum usuario com o e-mail fornecido retorna FALSE
            return FALSE;
        }
    }
    
    /**
     * Recebe uma url e os grupos do usuario e busca a permissao do usuario
     * para acessar a url informada
     * 
     * @param string $url Url da funcionalidade requisitada
     * @param array $grupos Array com os grupos do usuario
     * @return mixed
     */
    function get_permission($url, $grupos){
        
        $this->db->select('fg.*,f.url');
        
        $this->db->from('funcionalidade_grupo AS fg');
        
        // Join necessario para buscar os dados da funcionalidade correspondente
        // a url informada
        $this->db->join('funcionalidade AS f', 'f.id = fg.funcionalidade_id');

        // Restringe a busca em permissoes da url informada
        $this->db->where('f.url',$url);
        
        $this->db->where('f.status',1);
        
        // Restringe a busca em permissoes dos grupos do usuario
        $this->db->where_in('fg.grupo_id',$grupos);
        
        $resultado = $this->db->get();
        
        // Se encontrou alguma permissao
        if($resultado->num_rows() > 0){
            
            // Retorna a primeira permissao
            return $resultado->row(0);
        }
        else{
            
            // Caso nao encontre permissoes retorna FALSE
            return FALSE;
        }
        
    }
}