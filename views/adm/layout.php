<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
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
        <?php
        $this->load->view($this->config->item('area_admin') . '/topo');
        ?>
        <!--        Area para o conteudo da site     -->
        <div class="wrapper" id="conteudo">

            <div class="container">
                <?php $this->load->view($this->config->item('area_admin').(isset($view)?$view:'')); ?>
            </div>
        </div>

    </body>
</html>