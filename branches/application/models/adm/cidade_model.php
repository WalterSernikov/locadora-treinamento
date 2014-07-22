<?php if (!defined('BASEPATH'))  exit('No direct script access allowed');

/**
 * Realiza a interacao entre a aplicacao e a tabela de cidades no banco de dados
 * 
 * @package application/models/adm
 * @name Cidade_model
 * @author Joao Claudio Dias Araujo <joao.araujo@tellks.com.br>
 */
class Cidade_model extends CI_Model{
    
    private $tabela;

    public function __construct() {
        parent::__construct();
        $this->tabela = 'cidade';
    }
    
    /**
     * Busca as UFs  no banco de dados
     * 
     * @return array
     */
    public function get_UFs() {
        
        $this->db->select('uf')->from($this->tabela)->group_by('uf');
        
        $ufs = $this->db->get();
        
        $result = array();
        
        if($ufs->num_rows() > 0) {
            
            // Itera sob as UFs contruindo um vetor onde a chave e o valor sao
            // a UF
            foreach ($ufs->result() as $uf) {
                
                $result[$uf->uf] = $uf->uf;
            }
        }
        
        return $result;
    }
    
    /**
     * Recebe O ID  de uma cidade e consulta no banco a sua UF
     * 
     * @param  int $id ID da cidade da qual se deseja descubrir a UF
     * @return string
     */
    function get_uf_by_cidade($id) {
        $this->db->select('uf')->from($this->tabela)->where('id', $id);
        return $this->db->get()->row(0)->uf;
    }

    /**
     * Recebe uma UF  e busca no banco de dados todas as cidades desta uf
     * 
     * @param string $uf UF da qual se deseja buscar as cidades
     * @return array
     */
    function get_cid_UF($uf) {
        $cid = array('uf' => $uf);
        $this->db->select('*')->from($this->tabela)->where($cid);
        $cidades = $this->db->get();

        if ($cidades->num_rows() > 0) {

            // Itera sob as cidades construindo um array onde o ID da cidade
            // e a chave e o NOME e o valor
            foreach ($cidades->result() as $cidade) {

                $result[$cidade->id] = $cidade->nome;
            }
        }
        
        // Retorna o array com as cidades da UF 
        return $result;
    }
}