<?php

require_once __DIR__ . '/../../models/Paciente.php';

$dados = [
    'id'               => $_POST['id'] ?? '',
    'cpf'              => $_POST['cpf'] ?? '',
    'telefone'         => $_POST['telefone'] ?? '',
    'data_nascimento'  => $_POST['data_nascimento'] ?? '',
    'endereco'         => $_POST['endereco'] ?? ''
];

$paciente = new Paciente();

try {

    if (empty($dados['id'])) {
        throw new InvalidArgumentException('Paciente não informado.');
    }

    $resultado = $paciente->atualizar(
        (int) $dados['id'],
        $dados
    );

    header('Content-Type: application/json');

    echo json_encode([
        'status' => 'sucesso'
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
        'mensagem' => 'Erro ao atualizar paciente.'
    ]);
}