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
            array('name' => 'robots', 'content' => 'no-cache'),
            array('name' => 'description', 'content' => $this->config->item('app_nome')),
            array('name' => 'keywords', 'content' => 'Tellks'),
            array('name' => 'robots', 'content' => 'no-cache'),
            array('name' => 'Content-type', 'content' => 'text/html; charset=utf-8', 'type' => 'equiv'),
            array('name' => 'viewport', 'content' => 'width=device-width, initial-scale=1.0')
        );


        echo meta($meta);

//Gera as tags de carregamento das folhas de estilo
        echo link_tag(base_url('assets/css/bootstrap.min.css'), 'stylesheet', 'text/css', 'screen');
        lnbreak();

        echo link_tag(base_url('assets/css/bootstrap-theme.min.css'), 'stylesheet', 'text/css', 'screen');
        lnbreak();

        echo link_tag(base_url('assets/css/custom/projeto.css'), 'stylesheet', 'text/css', 'screen');
        lnbreak();

//Carrega os javascript para a template
        echo script_tag('assets/js/jquery-1.10.2.js', 'text/javascript');
        lnbreak();

        echo script_tag('assets/js/bootstrap.min.js', 'text/javascript');
        lnbreak();

// Carrega os javascripts exclusivos de cada pagina que sao definidos nas controladoras
        if (isset($js) && is_array($js)) {

            foreach ($js as $j) {

                echo script_tag('assets/js/' . $j . '.js', 'text/javascript');
                lnbreak();
            }
        }



        $title = $this->config->item('app_nome');

        $title .= (isset($titulo)) ? ' - ' . $titulo : '';
        ?>

        <title><?php echo $title; ?></title>
    </head>
    <body>
        <div id="wrapper">
            <div class='container'>
                <div class="row">
                    <div class="col-lg-4">
                    </div>
                    <div class="col-lg-4 alg-center">
                        <h1>Locadora Alpha</h1>
                    </div>
                </div>
                <div class="btn-group btn-group-justified mg10">
                    <div class="btn-group">
                        <a href="<?php echo base_url($this->config->item('area_admin') . '/usuario'); ?>">
                            <button class='btn btn-primary   col-lg-12'>
                                Funcionario
                            </button></a>
                    </div>                

                    <div class="btn-group">
                        <button class='btn btn-primary   col-lg-12'>
                            Cliente
                        </button>
                    </div>
                    <div class="btn-group">
                        <button class='btn btn-primary   col-lg-12'>
                            Usuário
                        </button>
                    </div>
                    <div class="btn-group">
                        <button class='btn btn-primary   col-lg-12'>
                            Locar
                        </button>
                    </div>
                    <div class="btn-group">

                        <button type="button" class="btn btn-primary dropdown-toggle col-lg-12" data-toggle="dropdown">
                            Sistema <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="#">Funcionalidade</a></li>
                            <li><a href="#">Tipo Usuario</a></li>
                            <li><a href="#">Controle de Acesso</a></li>
                        </ul>
                    </div>
                    <div class="btn-group">

                        <button type="button" class="btn btn-primary dropdown-toggle col-lg-12" data-toggle="dropdown">
                            Gerenciar Veiculo <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="#">Carro</a></li>
                            <li><a href="#">Marca</a></li>
                            <li><a href="#">Cambio</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>