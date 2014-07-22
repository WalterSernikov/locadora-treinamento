<?php if (!defined('BASEPATH'))  exit('No direct script access allowed');

$config['status_funcionalidade'] = array( 1 => 'Ativa', 0 => 'Inativa');

$config['regras_validacao'] = array(
    array(
        'field' => 'nome',
        'label' => 'nome',
        'rules' => 'trim|required'
    ),
    array(
        'field' => 'url',
        'label' => 'url',
        'rules' => 'trim|required'
    ),
    
);
