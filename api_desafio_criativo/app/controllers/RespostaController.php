<?php
require_once __DIR__ . '/../daos/RespostaDAO.php';
require_once __DIR__ . '/../models/RespostaModel.php';
require_once __DIR__ . '/../daos/DesafioDAO.php'; 

class RespostaController {
    private $respostaDAO;
    private $desafioDAO;

    public function __construct() {
        $this->respostaDAO = new RespostaDAO();
        $this->desafioDAO = new DesafioDAO(); 
    }

    // --- Métodos da API (JSON) ---

    public function listarPorDesafio($desafio_id) { 
        $desafio = $this->desafioDAO->buscarPorId($desafio_id);
        if (!$desafio) {
            header('Content-Type: application/json', true, 404);
            echo json_encode(['erro' => 'Desafio não encontrado']);
            return;
        }
        $respostas = $this->respostaDAO->listarPorDesafioId($desafio_id);
        header('Content-Type: application/json');
        echo json_encode($respostas);
    }

    public function criar($desafio_id) { 
        $dados = json_decode(file_get_contents('php://input'), true);
        $desafio = $this->desafioDAO->buscarPorId($desafio_id);

        if (!$desafio) {
            header('Content-Type: application/json', true, 404);
            echo json_encode(['erro' => 'Desafio não encontrado ao tentar criar resposta']);
            return;
        }

        if (isset($dados['autor']) && isset($dados['conteudo'])) {
            $resposta = new RespostaModel();
            $resposta->desafio_id = $desafio_id;
            $resposta->autor = $dados['autor'];
            $resposta->conteudo = $dados['conteudo'];
            
            $id = $this->respostaDAO->salvar($resposta);
            header('Content-Type: application/json', true, 201);
            echo json_encode(['id' => $id, 'mensagem' => 'Resposta criada com sucesso']);
        } else {
            header('Content-Type: application/json', true, 400);
            echo json_encode(['erro' => 'Dados incompletos para criar resposta']);
        }
    }

    public function votar($id_resposta) { 
        $resposta = $this->respostaDAO->buscarPorId($id_resposta);
        if (!$resposta) {
            header('Content-Type: application/json', true, 404);
            echo json_encode(['erro' => 'Resposta não encontrada']);
            return;
        }
        $this->respostaDAO->votar($id_resposta);
        header('Content-Type: application/json');
        echo json_encode(['id' => $id_resposta, 'mensagem' => 'Voto computado']);
    }

    public function excluir($id_resposta) { 
        $resposta = $this->respostaDAO->buscarPorId($id_resposta);
        if (!$resposta) {
            header('Content-Type: application/json', true, 404);
            echo json_encode(['erro' => 'Resposta não encontrada']);
            return;
        }
        $this->respostaDAO->excluir($id_resposta);
        header('Content-Type: application/json');
        echo json_encode(['id' => $id_resposta, 'mensagem' => 'Resposta excluída com sucesso']);
    }

    // --- Métodos para Views HTML ---
    private function getBasePath() {
        $scriptDir = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME']));
        $basePath = preg_replace('#/public$#', '', $scriptDir);
        return ($basePath === '/' || $basePath === '') ? '' : $basePath;
    }

    public function mostrarRespostasHtml($id_desafio) { 
        $desafio = $this->desafioDAO->buscarPorId($id_desafio);
        $respostas = [];
        if ($desafio) {
            $respostas = $this->respostaDAO->listarPorDesafioId($id_desafio);
        }
        $basePath = $this->getBasePath();
        require_once __DIR__ . '/../views/respostas/listagem_respostas.php';
    }

    public function mostrarFormularioRespostaHtml($id_desafio) { 
        $desafio = $this->desafioDAO->buscarPorId($id_desafio);
        $basePath = $this->getBasePath();
        if ($desafio) {
            require_once __DIR__ . '/../views/respostas/formulario_resposta.php';
        } else {
            echo "Desafio para adicionar resposta não encontrado.";
            
        }
    }

    public function salvarRespostaForm($id_desafio) { 
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $desafio = $this->desafioDAO->buscarPorId($id_desafio);
            if (!$desafio) {
                echo "Erro: Desafio não encontrado ao salvar resposta.";
                return; 
            }

            if (isset($_POST['autor']) && isset($_POST['conteudo'])) {
                $resposta = new RespostaModel();
                $resposta->desafio_id = $id_desafio;
                $resposta->autor = $_POST['autor'];
                $resposta->conteudo = $_POST['conteudo'];
                $this->respostaDAO->salvar($resposta);
                header("Location: " . $this->getBasePath() . "/desafios_html/" . $id_desafio . "/respostas?sucesso=resposta_criada");
                exit;
            } else {
                header("Location: " . $this->getBasePath() . "/desafios_html/" . $id_desafio . "/respostas/formulario_html?erro=dados_incompletos");
                exit;
            }
        }
    }

    public function votarRespostaForm($id_resposta) { 
        $resposta = $this->respostaDAO->buscarPorId($id_resposta);
        $desafio_id_para_redirecionar = isset($_GET['desafio_id']) ? $_GET['desafio_id'] : null;

        if ($resposta) {
            $this->respostaDAO->votar($id_resposta);
            $mensagem = "&sucesso=voto_computado";
        } else {
            $mensagem = "&erro=resposta_nao_encontrada_para_voto";
        }
        
        if ($desafio_id_para_redirecionar) {
            header("Location: " . $this->getBasePath() . "/desafios_html/" . $desafio_id_para_redirecionar . "/respostas" . $mensagem);
        } else {
            header("Location: " . $this->getBasePath() . "/desafios_html?aviso=votado_sem_contexto_desafio" . ($resposta ? '' : $mensagem));
        }
        exit;
    }

    public function excluirRespostaForm($id_resposta) { 
        $resposta = $this->respostaDAO->buscarPorId($id_resposta);
        $desafio_id_para_redirecionar = isset($_GET['desafio_id']) ? $_GET['desafio_id'] : null;

        if ($resposta) {
            $this->respostaDAO->excluir($id_resposta);
            $mensagem = "&sucesso=resposta_excluida";
        } else {
            $mensagem = "&erro=resposta_nao_encontrada_para_excluir";
        }

        if ($desafio_id_para_redirecionar) {
            header("Location: " . $this->getBasePath() . "/desafios_html/" . $desafio_id_para_redirecionar . "/respostas" . $mensagem);
        } else {
            header("Location: " . $this->getBasePath() . "/desafios_html?aviso=excluido_sem_contexto_desafio" . ($resposta ? '' : $mensagem));
        }
        exit;
    }


    public function mostrarFormularioEdicaoRespostaHtml($id_resposta) {
        $resposta = $this->respostaDAO->buscarPorId($id_resposta);
        $desafio = null;
        $basePath = $this->getBasePath();

        if ($resposta) {
            $desafio = $this->desafioDAO->buscarPorId($resposta->desafio_id);
           
        } else {
           
            error_log("RespostaController: Resposta com ID {$id_resposta} não encontrada para edição.");
        }
        
        require_once __DIR__ . '/../views/respostas/edicao_resposta.php';
    }

    public function atualizarRespostaForm($id_resposta) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $respostaExistente = $this->respostaDAO->buscarPorId($id_resposta);
            
            $desafio_id_para_redirecionar = isset($_POST['desafio_id']) ? $_POST['desafio_id'] : (isset($_GET['desafio_id']) ? $_GET['desafio_id'] : null);

            if (!$respostaExistente) {
                echo "Erro: Resposta não encontrada para atualizar."; 
                exit;
            }

            if (isset($_POST['autor']) && isset($_POST['conteudo'])) {
                $respostaAtualizada = new RespostaModel();
                $respostaAtualizada->id = $id_resposta;
                $respostaAtualizada->desafio_id = $respostaExistente->desafio_id; 
                $respostaAtualizada->autor = $_POST['autor'];
                $respostaAtualizada->conteudo = $_POST['conteudo'];
             
                $this->respostaDAO->atualizar($respostaAtualizada); 

                if ($desafio_id_para_redirecionar) {
                    header("Location: " . $this->getBasePath() . "/desafios_html/" . $desafio_id_para_redirecionar . "/respostas?sucesso=resposta_atualizada");
                } else {
                    header("Location: " . $this->getBasePath() . "/desafios_html?sucesso=resposta_atualizada_sem_ctx");
                }
                exit;
            } else {
                $queryString = $desafio_id_para_redirecionar ? "desafio_id=" . $desafio_id_para_redirecionar . "&" : "";
                header("Location: " . $this->getBasePath() . "/respostas_html/" . $id_resposta . "/formulario_edicao_html?" . $queryString . "erro=dados_incompletos_att");
                exit;
            }
        }
    }
}
?>