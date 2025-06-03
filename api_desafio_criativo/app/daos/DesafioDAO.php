<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../models/DesafioModel.php';

class DesafioDAO {
    private $pdo;

    public function __construct() {
        $this->pdo = DatabaseConnection::getInstance()->getConnection();
    }

    public function listarTodos() {
        $stmt = $this->pdo->query("SELECT * FROM desafios ORDER BY criado_em DESC");
        return $stmt->fetchAll(PDO::FETCH_CLASS, 'DesafioModel');
    }

    public function buscarPorId($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM desafios WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetchObject('DesafioModel');
    }

    public function salvar(DesafioModel $desafio) {
        $stmt = $this->pdo->prepare("INSERT INTO desafios (titulo, descricao) VALUES (?, ?)");
        $stmt->execute([$desafio->titulo, $desafio->descricao]);
        return $this->pdo->lastInsertId();
    }

    public function atualizar(DesafioModel $desafio) {
        $stmt = $this->pdo->prepare("UPDATE desafios SET titulo = ?, descricao = ? WHERE id = ?");
        return $stmt->execute([$desafio->titulo, $desafio->descricao, $desafio->id]);
    }

    public function excluir($id) {
        $stmt = $this->pdo->prepare("DELETE FROM desafios WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
?>