<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

$config['status_pagamento'] = array (
    0 =>'Não Pago',
    1 =>'Pago',
);

$config['status_locacao'] = array (
    0 =>'Desistente',
    1 =>'Reservado',
    2 =>'Alocado',
    3 =>'Finalizado'
);

$config['regras_validacao'] = array(
    array('field' => 'data_ini',
        'label' => 'data_ini',
        'rules' => 'callback_valida_data_call'
    )
);