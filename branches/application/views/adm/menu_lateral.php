<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<div class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
        <?php
        echo $this->menu->renderizar();
        ?>
    </div>
</div>