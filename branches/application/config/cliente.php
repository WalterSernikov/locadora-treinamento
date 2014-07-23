<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');


$config['sexos_clientes'] = array(
    'm' => 'Masculino',
    'f' => 'Feminino'
);

$config['regras_validacao'] = array(
    array(
        'field' => 'email',
        'label' => 'e-mail',
        'rules' => 'trim|required|valid_email|callback_valida_email'
    ),
    
    array(
        'field' => 'nome',
        'label' => 'nome',
        'rules' => 'trim|required'
    )
    
);
