<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

?>

<!DOCTYPE html>
<html>
    <head>
        <?php
        
        // Define os metas a serem criados
        $meta = array(
            array('name' => 'robots', 'content'       => 'no-cache'),
            array('name' => 'description', 'content'  => $this->config->item('app_nome')),
            array('name' => 'keywords', 'content'     => 'Tellks'),
            array('name' => 'robots', 'content'       => 'no-cache'),
            array('name' => 'Content-type', 'content' => 'text/html; charset=utf-8', 'type' => 'equiv'),
            array('name' => 'viewport', 'content'     => 'width=device-width, initial-scale=1.0')
        );
        
        
        echo meta($meta);
        
        //Gera as tags de carregamento das folhas de estilo
        echo link_tag(base_url('assets/css/bootstrap.min.css'), 'stylesheet', 'text/css', 'screen');lnbreak();
        
        echo link_tag(base_url('assets/css/bootstrap-theme.min.css'), 'stylesheet', 'text/css', 'screen');lnbreak();
        
        //Carrega os javascript para a template
        echo script_tag('assets/js/jquery-1.10.2.js', 'text/javascript');lnbreak();
        
        echo script_tag('assets/js/bootstrap.min.js', 'text/javascript');lnbreak();
        
        // Carrega os javascripts exclusivos de cada pagina que sao definidos nas controladoras
        if(isset($js) && is_array($js)){
            
            foreach ($js as $j){
                
                echo script_tag('assets/js/' . $j . '.js', 'text/javascript');lnbreak();
            }
        }
        
        
        
        $title = $this->config->item('app_nome');
        
        $title .= (isset($titulo))? ' - ' . $titulo: '';
        ?>
        
        <title><?php echo $title; ?></title>
    </head>
    <body>
        <div class="row-fluid">
            <div class="col-lg-4">
            </div>
            <div class="col-lg-4">
                <h1>Locadora Alpha</h1>
            </div>
            <div class="col-lg-4">
            </div>
        </div>
        <div class="row-fluid">
            <button class='btn btn-success tamanho'>
                Funcionario
            </button>
        </div>
    </body>