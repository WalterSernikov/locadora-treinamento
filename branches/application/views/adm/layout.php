<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 

echo doctype('html5');

?>

<html lang="pt-BR">
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

        //Gera as tags html dos metas definidos acima
        echo meta($meta);
        
        //Gera as tags de carregamento das folhas de estilo
        echo link_tag(base_url('assets/css/bootstrap.min.css'), 'stylesheet', 'text/css', 'screen');lnbreak();
        
        echo link_tag(base_url('assets/font-awesome/css/font-awesome.min.css'), 'stylesheet', 'text/css', 'screen');lnbreak();
        
        echo link_tag(base_url('assets/css/template.css'), 'stylesheet', 'text/css', 'screen');lnbreak();
        
        echo link_tag(base_url('assets/css/custom/projeto.css'), 'stylesheet', 'text/css', 'screen');lnbreak();
        
        $title = $this->config->item('app_nome');
        
        $title .= (isset($titulo))? ' - ' . $titulo: '';
        
        ?>
        
        <title><?php echo $title;?></title>
        
    </head>
    <body>
        
        <div id="wrapper">
            
            <!-- Topo da pagina e menu lateral-->
            <nav class="navbar navbar-default navbar-fixed-top" role="navigation" style="margin-bottom: 0">

                <!-- Carrega a view com o topo da pagina -->
                <?php $this->load->view($this->config->item('area_admin') . '/topo'); ?>

                <!-- Carrega a view com o menu lateral -->
                <?php $this->load->view($this->config->item('area_admin') . '/menu_lateral'); ?>
            </nav>
            
            <div id="page-wrapper">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header"><?php echo (isset($titulo))? $titulo: ''?></h1>
                    </div>
                </div>
                <!-- Area destinada ao conteudo dinamico -->
                <div class="row">
                    <?php $this->load->view($this->config->item('area_admin') . '/' . (isset($view)) ? $view : ''); ?>
                </div>

            </div>

        </div>
        
        <?php
        
        //Gera as tags html de carregamento dos javascripts
        echo script_tag('assets/js/jquery-1.10.2.js', 'text/javascript');lnbreak();
        
        echo script_tag('assets/js/bootstrap.min.js', 'text/javascript');lnbreak();
        
        echo script_tag('assets/js/plugins/metisMenu/jquery.metisMenu.js', 'text/javascript');lnbreak();
        
        echo script_tag('assets/js/template.js', 'text/javascript');lnbreak();
        
        echo script_tag('assets/js/plugins/jquery.inputmask.bundle.min.js', 'text/javascript');lnbreak();
        
        // Carrega os javascripts exclusivos de cada pagina que sao definidos nas controladoras
        if(isset($js) && is_array($js)){
            
            foreach ($js as $j){
                
                echo script_tag('assets/js/' . $j . '.js', 'text/javascript');lnbreak();
            }
        }
        
        ?>
    </body>
</html>