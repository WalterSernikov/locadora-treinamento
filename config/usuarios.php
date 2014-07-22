<?php if (!defined('BASEPATH'))  exit('No direct script access allowed');

$config['status_usuario'] = array(
    0 => 'Inativo',
    1 => 'Ativo'
);

$config['sexos_usuarios'] = array(
    'm' => 'Masculino',
    'f' => 'Feminino'
);

$config['grupos_usuario'] = array(
    1 => 'Administradores',
    2 => 'Vendedores',
    3 => 'Suporte'
);

$config['funcao'] = array(
    1 => 'TI',
    2 => 'Atendentes',
    3 => 'Gerente'
    
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
    ),
    array(
        'field' => 'senha',
        'label' => 'confirme a senha',
        'rules' => 'matches[senha2]|trim|callback_valida_senha'
    ),
    array(
        'field' => 'status',
        'label' => 'status',
        'rules' => 'required'
    )
);
