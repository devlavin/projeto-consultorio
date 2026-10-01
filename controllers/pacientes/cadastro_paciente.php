<?php

require_once __DIR__ . '/../../models/Paciente.php';

$dados = [
    'nome'             => $_POST['nome'] ?? '',
    'email'            => $_POST['email'] ?? '',
    'senha'            => $_POST['senha'] ?? '',
    'cpf'              => $_POST['cpf'] ?? '',
    'telefone'         => $_POST['telefone'] ?? '',
    'data_nascimento'  => $_POST['data_nascimento'] ?? '',
    'endereco'         => $_POST['endereco'] ?? ''
];

$paciente = new Paciente();

try {

    $resultado = $paciente->create($dados);

    header('Content-Type: application/json');

    echo json_encode([
        'status'      => 'sucesso',
        'paciente_id' => $resultado
    ]);

} catch (InvalidArgumentException $e) {

    http_response_code(422);

    header('Content-Type: application/json');

    echo json_encode([
        'status'   => 'erro',
        'mensagem' => $e->getMessage()
    ]);

} catch (PDOException $e) {

    http_response_code(500);

    header('Content-Type: application/json');

    echo json_encode([
        'status'   => 'erro',
        'mensagem' => 'Erro ao cadastrar paciente.'
    ]);
}