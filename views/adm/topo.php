<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>



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
                    <a href="<?php echo base_url($this->config->item('area_admin') . '/funcionario'); ?>">
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
