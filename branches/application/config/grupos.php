<?php if (!defined('BASEPATH'))  exit('No direct script access allowed');

$config['regras_validacao'] = array(
    array(
        'field' => 'nome',
        'label' => 'nome',
        'rules' => 'trim|required'
    ),
);
