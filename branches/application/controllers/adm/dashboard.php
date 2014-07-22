<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of dashboard
 *
 * @author tellks
 */
class Dashboard extends CI_Controller{
    public function index() {
        $dados['titulo'] = 'Dashboard';

        $this->load->view($this->config->item('area_admin') . '/index_menu', $dados);
    }
}
