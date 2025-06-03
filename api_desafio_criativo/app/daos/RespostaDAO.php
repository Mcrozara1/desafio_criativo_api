<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../models/RespostaModel.php';

class RespostaDAO {
    private $pdo;

    public function __construct() {
        $this->pdo = DatabaseConnection::getInstance()->getConnection();
    }

    public function listarPorDesafioId($desafio_id) {
        $stmt = $this->pdo->prepare("SELECT * FROM respostas WHERE desafio_id = ? ORDER BY votos DESC, criado_em DESC");
        $stmt->execute([$desafio_id]);
        return $stmt->fetchAll(PDO::FETCH_CLASS, 'RespostaModel');
    }

    public function buscarPorId($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM respostas WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetchObject('RespostaModel');
    }

    public function salvar(RespostaModel $resposta) {
        $stmt = $this->pdo->prepare("INSERT INTO respostas (desafio_id, autor, conteudo) VALUES (?, ?, ?)");
        $stmt->execute([$resposta->desafio_id, $resposta->autor, $resposta->conteudo]);
        return $this->pdo->lastInsertId();
    }

    public function atualizar(RespostaModel $resposta) { 
        $stmt = $this->pdo->prepare("UPDATE respostas SET autor = ?, conteudo = ? WHERE id = ?");
        return $stmt->execute([$resposta->autor, $resposta->conteudo, $resposta->id]);
    }

    public function votar($id) {
        $stmt = $this->pdo->prepare("UPDATE respostas SET votos = votos + 1 WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public function excluir($id) {
        $stmt = $this->pdo->prepare("DELETE FROM respostas WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
?>