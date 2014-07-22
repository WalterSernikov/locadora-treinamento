<?php if (!defined('BASEPATH'))  exit('No direct script access allowed');

echo doctype('html5');

?>
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

        //Gera as tags html dos metas definidos acima
        echo meta($meta);
        
        //Gera as tags de carregamento das folhas de estilo
        echo link_tag(base_url('assets/css/bootstrap.min.css'), 'stylesheet', 'text/css', 'screen');lnbreak();
        
        echo link_tag(base_url('assets/font-awesome/css/font-awesome.min.css'), 'stylesheet', 'text/css', 'screen');lnbreak();
        
        echo link_tag(base_url('assets/css/template.css'), 'stylesheet', 'text/css', 'screen');lnbreak();
        
        $title = $this->config->item('app_nome');
        
        $title .= (isset($titulo))? ' - ' . $titulo: '';
        
        ?>
        
        <title><?php echo $title;?></title>
        
    </head>
    
    <body>

        <div class="container">
            <div class="row">
                <div class="col-md-4 col-md-offset-4">
                    <div class="login-panel panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">Login</h3>
                        </div>
                        <div class="panel-body">
                                                        
                            <?php echo form_open($this->config->item('area_admin') . '/login/autenticar'); ?>

                                <fieldset>
                                    <div class="form-group">
                                        <?php
                                        
                                        $input_email = array(
                                            'name'        => 'email',
                                            'value'       => set_value('email'),
                                            'placeholder' => 'E-mail',
                                            'type'        => 'email',
                                            'class'       => 'form-control',
                                            'autofocus'   => ''
                                        );
                                        
                                        echo form_input($input_email);
                                        echo form_error('email');
                                        ?>
                                    </div>
                                    <div class="form-group">
                                        
                                        <?php
                                        
                                        $input_senha = array(
                                            'name'        => 'senha',
                                            'placeholder' => 'Senha',
                                            'type'        => 'password',
                                            'class'       => 'form-control',
                                        );
                                        
                                        echo form_input($input_senha);
                                        echo form_error('senha');
                                        
                                        if(isset($msg)){
                                            
                                            echo form_label($msg,'msg',array('class' => 'error'));
                                        }
                                        ?>
                                    </div>
                                    
                                    <?php echo form_submit('entrar', 'Entrar','class="btn btn-lg btn-success btn-block"');?>
                                </fieldset>

                            <?php echo form_close(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
        //Gera as tags html de carregamento dos javascripts
        echo script_tag('assets/js/jquery-1.10.2.js', 'text/javascript');lnbreak();

        echo script_tag('assets/js/bootstrap.min.js', 'text/javascript');
        lnbreak();
        echo script_tag('assets/js/plugins/metisMenu/jquery.metisMenu.js', 'text/javascript');lnbreak();

        echo script_tag('assets/js/template.js', 'text/javascript');lnbreak();
        ?>
    </body>
</html>