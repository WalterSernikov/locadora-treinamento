<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

$config['cambio'] = array (
    0 =>'Manual',
    1 =>'Automático',
    2 =>'CVT'
);

$config['ar'] = array (
    0 =>'Não possui',
    1 =>'Possui'    
);

$config['abs'] = array (
    0 =>'Sim',
    1 =>'Não'
);

$config['status'] = array (
    0 =>'Livre',
    1 =>'Manutenção'
);

$config['regras_validacao'] =array(
    array(
        'field' => 'modelo',
        'label' => 'modelo',
        'rules' => 'trim|required'
    )
);
