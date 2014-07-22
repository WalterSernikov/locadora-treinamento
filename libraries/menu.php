<?php if (!defined('BASEPATH'))  exit('No direct script access allowed');

/**
 * Library criada para criar o menu do usuario
 * 
 * @package application/libraries
 * @name Menu
 * @author Joao Claudio Dias Araujo <joao.araujo@tellks.com.br>
 */
class Menu {
    
    private $CI;
    
    function __construct() {
        
        $this->CI = &get_instance();
        
        $this->CI->load->model($this->CI->config->item('area_admin') . '/menu_model');
    }
            
    /**
     * Responsavel por renderizar o menu
     * 
     * @return string Html do menu do usuario
     */
    function renderizar(){
        
        // Busca os itens no banco de dados
        $itens_menu = $this->get_itens_menu();
        
        // Abre a tag html do menu
        $menu = '<ul class="nav" id="side-menu">';
        
        // Adiciona o campo de busca ao menu
        $menu .= $this->renderizar_busca();
        
        // itera sob os itens de menu adicionando eles ao menu
        foreach ($itens_menu as $item){
            
            $menu .= $this->renderizar_item($item);
        }
        
        // Fecha a tag html do menu
        $menu .= '</ul>';
        
        return $menu;
    }
    
    /**
     * Renderiza o html de um item de menu
     * 
     * @param stdClass Object $item Objeto contendo os dados do item de menu
     * @return string Html do item de menu
     */
    private function renderizar_item($item){
       
        // Abre a tag
        $html_item = '<li>';
        
        // Abre a tag do link
        $html_item .= '<a href="' . base_url($this->CI->config->item('area_admin') . '/' . $item->url) . '">';
        // Adiciona o icone
        $html_item .= '<i class="' . $item->icone . '"></i>&nbsp;';
        // Adiciona o texto do link
        $html_item .= $item->nome;
        // Fecha a tag do link
        $html_item .= '</a>';
        // Fecha a tag do item
        $html_item .= '</li>';
        
        return $html_item;
    }
    
    /**
     * Renderiza o campo de busca
     * 
     * @return string Html do campo de busca
     */
    private function renderizar_busca(){
        
        $busca  = '<li class="sidebar-search">';
        $busca .= '<div class="input-group custom-search-form">';
        $busca .= '<input type="text" class="form-control" placeholder="Buscar...">';
        $busca .= '<span class="input-group-btn">';
        $busca .= '<button class="btn btn-default" type="button">';
        $busca .= '<i class="fa fa-search"></i>';
        $busca .= '</button>';
        $busca .= '</span>';
        $busca .= '</div>';
        $busca .= '</li>';
        
        return $busca;
    }
    
    /**
     * Busca os dados dos itens de menu no banco de dados em funcao dos grupos do
     * usuario logado
     * 
     * @return array
     */
    private function get_itens_menu(){
        
        $grupos = $this->CI->session->userdata('grupos');
        
        return $this->CI->menu_model->get_itens_menu($grupos);
    }
}