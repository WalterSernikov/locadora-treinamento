<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

?>

<div class="col-lg-12">
    <div class="row">
        <h2><?php echo $titulo; ?></h2>
    </div>
    <a href="<?php echo base_url($this->config->item('area_admin').'/funcionario/cadastrar'); ?>" class="btn btn-success mg10">Cadastrar</a>
</div>
