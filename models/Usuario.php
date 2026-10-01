<?php

require_once __DIR__ . '/../config/conexao.php';

class Usuario extends Conexao
{
    public function validarDados(string $email)
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException('E-mail inválido.');
        }

        return true;
    }

    public function create(array $array)
    {
        try {

            $this->validarDados($array['email']);

            $sql = "INSERT INTO usuarios 
                    (nome, email, senha, tipo, ativo)
                    VALUES
                    (:nome, :email, :senha, :tipo, :ativo)";

            $stmt = $this->pdo->prepare($sql);

            $stmt->execute([
                'nome'  => $array['nome'],
                'email' => $array['email'],
                'senha' => password_hash($array['senha'], PASSWORD_DEFAULT),
                'tipo'  => $array['tipo'],
                'ativo' => $array['ativo']
            ]);

            return $this->pdo->lastInsertId();

        } catch (PDOException $e) {

            throw $e;
        }
    }

    public function buscarPorEmail(string $email)
    {
        $sql = "SELECT *
                FROM usuarios
                WHERE email = :email
                LIMIT 1";

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute([
            'email' => $email
        ]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function buscarPorId(int $id)
    {
        $sql = "SELECT *
                FROM usuarios
                WHERE id = :id
                LIMIT 1";

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute([
            'id' => $id
        ]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function alterarStatus(int $id, int $ativo)
    {
        $sql = "UPDATE usuarios
                SET ativo = :ativo
                WHERE id = :id";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            'id' => $id,
            'ativo' => $ativo
        ]);
    }
    
}