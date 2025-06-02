<?php
require_once __DIR__ . '/../daos/DesafioDAO.php';
require_once __DIR__ . '/../models/DesafioModel.php';

class DesafioController {
    private $desafioDAO;

    public function __construct() {
        $this->desafioDAO = new DesafioDAO();
    }

    // --- Métodos da API (JSON) ---

    public function listar() { 
        $desafios = $this->desafioDAO->listarTodos();
        header('Content-Type: application/json');
        echo json_encode($desafios);
    }

    public function buscar($id) { 
        $desafio = $this->desafioDAO->buscarPorId($id);
        if ($desafio) {
            header('Content-Type: application/json');
            echo json_encode($desafio);
        } else {
            header('Content-Type: application/json', true, 404);
            echo json_encode(['erro' => 'Desafio não encontrado']);
        }
    }

    public function criar() { 
        $dados = json_decode(file_get_contents('php://input'), true);

        if (isset($dados['titulo']) && isset($dados['descricao'])) {
            $desafio = new DesafioModel();
            $desafio->titulo = $dados['titulo'];
            $desafio->descricao = $dados['descricao'];
            
            $id = $this->desafioDAO->salvar($desafio);
            header('Content-Type: application/json', true, 201); 
            echo json_encode(['id' => $id, 'mensagem' => 'Desafio criado com sucesso']);
        } else {
            header('Content-Type: application/json', true, 400); 
            echo json_encode(['erro' => 'Dados incompletos']);
        }
    }
    
    public function atualizar($id) { 
        $dados = json_decode(file_get_contents('php://input'), true);
        $desafioExistente = $this->desafioDAO->buscarPorId($id);

        if (!$desafioExistente) {
            header('Content-Type: application/json', true, 404);
            echo json_encode(['erro' => 'Desafio não encontrado']);
            return;
        }

        if (isset($dados['titulo']) && isset($dados['descricao'])) {
            $desafio = new DesafioModel();
            $desafio->id = $id;
            $desafio->titulo = $dados['titulo'];
            $desafio->descricao = $dados['descricao'];
            
            $this->desafioDAO->atualizar($desafio);
            header('Content-Type: application/json');
            echo json_encode(['id' => $id, 'mensagem' => 'Desafio atualizado com sucesso']);
        } else {
            header('Content-Type: application/json', true, 400);
            echo json_encode(['erro' => 'Dados incompletos']);
        }
    }

    public function excluir($id) { 
        $desafioExistente = $this->desafioDAO->buscarPorId($id);
        if (!$desafioExistente) {
            header('Content-Type: application/json', true, 404);
            echo json_encode(['erro' => 'Desafio não encontrado']);
            return;
        }
        $this->desafioDAO->excluir($id);
        header('Content-Type: application/json');
        echo json_encode(['id' => $id, 'mensagem' => 'Desafio excluído com sucesso']);
    }

    // --- Métodos para Views HTML ---

    private function getBasePath() {
        $scriptDir = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME']));
        $basePath = preg_replace('#/public$#', '', $scriptDir);
        return ($basePath === '/' || $basePath === '') ? '' : $basePath;
    }

    public function listarHtml() { 
        $desafios = $this->desafioDAO->listarTodos();
        $basePath = $this->getBasePath(); 
        require_once __DIR__ . '/../views/desafios/listagem_desafios.php';
    }

    public function mostrarFormularioCadastroHtml() { 
        $basePath = $this->getBasePath();
        require_once __DIR__ . '/../views/desafios/cadastro_desafio.php';
    }
   
    public function salvarForm() { 
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['titulo']) && isset($_POST['descricao'])) {
                $desafio = new DesafioModel();
                $desafio->titulo = $_POST['titulo'];
                $desafio->descricao = $_POST['descricao'];
                $this->desafioDAO->salvar($desafio);
                header("Location: " . $this->getBasePath() . "/desafios_html");
                exit;
            } else {
                header("Location: " . $this->getBasePath() . "/desafios/formulario_cadastro_html?erro=dados");
                exit;
            }
        }
    }

    public function mostrarFormularioEdicaoHtml($id) { 
        $desafio = $this->desafioDAO->buscarPorId($id);
        $basePath = $this->getBasePath();
        if ($desafio) {
            require_once __DIR__ . '/../views/desafios/edicao_desafio.php';
        } else {
            echo "Desafio não encontrado para edição.";
           
        }
    }

    public function atualizarForm($id) { 
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $desafioExistente = $this->desafioDAO->buscarPorId($id);
            if (!$desafioExistente) {
                echo "Erro: Desafio não encontrado para atualizar.";
                return;
            }
            if (isset($_POST['titulo']) && isset($_POST['descricao'])) {
                $desafio = new DesafioModel();
                $desafio->id = $id;
                $desafio->titulo = $_POST['titulo'];
                $desafio->descricao = $_POST['descricao'];
                $this->desafioDAO->atualizar($desafio);
                header("Location: " . $this->getBasePath() . "/desafios_html");
                exit;
            } else {
                header("Location: " . $this->getBasePath() . "/desafios/formulario_edicao_html/" . $id . "?erro=dados");
                exit;
            }
        }
    }

    public function excluirHtml($id) {
        $desafioExistente = $this->desafioDAO->buscarPorId($id);
        if ($desafioExistente) {
            $this->desafioDAO->excluir($id);
        }
        header("Location: " . $this->getBasePath() . "/desafios_html");
        exit;
    }
}
?>