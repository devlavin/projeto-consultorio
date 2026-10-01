<?php

require_once __DIR__ . '/../config/conexao.php';

class Paciente extends Conexao
{
    public function validarDados(string $cpf, string $telefone)
    {
        $cpf = preg_replace('/[^0-9]/', '', $cpf);

        if (strlen($cpf) !== 11) {
            throw new InvalidArgumentException('CPF inválido.');
        }

        $telefone = preg_replace('/\D/', '', $telefone);

        if (strlen($telefone) !== 10 && strlen($telefone) !== 11) {
            throw new InvalidArgumentException('Celular inválido.');
        }

        return true;
    }

    public function create(array $array)
    {
        try {

            $this->validarDados(
                $array['cpf'],
                $array['telefone']
            );

            $this->pdo->beginTransaction();

            // 1. Cria o usuário
            $sqlUsuario = "INSERT INTO usuarios
                (nome, email, senha, tipo, ativo)
                VALUES
                (:nome, :email, :senha, 'paciente', 1)";

            $stmtUsuario = $this->pdo->prepare($sqlUsuario);

            $stmtUsuario->execute([
                'nome'  => $array['nome'],
                'email' => $array['email'],
                'senha' => password_hash($array['senha'], PASSWORD_DEFAULT)
            ]);

            $usuario_id = $this->pdo->lastInsertId();

            // 2. Cria o paciente
            $sqlPaciente = "INSERT INTO pacientes
                (usuario_id, cpf, telefone, data_nascimento, endereco)
                VALUES
                (:usuario_id, :cpf, :telefone, :data_nascimento, :endereco)";

            $stmtPaciente = $this->pdo->prepare($sqlPaciente);

            $stmtPaciente->execute([
                'usuario_id'      => $usuario_id,
                'cpf'             => $array['cpf'],
                'telefone'        => $array['telefone'],
                'data_nascimento' => $array['data_nascimento'] ?? null,
                'endereco'        => $array['endereco'] ?? null
            ]);

            $paciente_id = $this->pdo->lastInsertId();

            // 3. Confirma os dois INSERTs
            $this->pdo->commit();

            return $paciente_id;

        } catch (PDOException $e) {

            if ($this->pdo->inTransaction()) {
                $this->pdo->rollBack();
            }

            throw $e;
        }
    }

    public function buscarPorId(int $id)
    {
        $sql = "SELECT *
                FROM pacientes
                WHERE id = :id
                LIMIT 1";

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute([
            'id' => $id
        ]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function buscarPorUsuario(int $usuario_id)
    {
        $sql = "SELECT *
                FROM pacientes
                WHERE usuario_id = :usuario_id
                LIMIT 1";

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute([
            'usuario_id' => $usuario_id
        ]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function atualizar(int $id, array $array)
    {
        $this->validarDados(
            $array['cpf'],
            $array['telefone']
        );

        $sql = "UPDATE pacientes
                SET cpf = :cpf,
                    telefone = :telefone,
                    endereco = :endereco
                WHERE id = :id";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            'id'              => $id,
            'cpf'             => $array['cpf'],
            'telefone'        => $array['telefone'],
            'data_nascimento' => $array['data_nascimento'],
            'endereco'        => $array['endereco'] ?? null
        ]);
    }
}