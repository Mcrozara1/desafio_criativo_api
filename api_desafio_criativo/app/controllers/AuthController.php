<?php
require_once __DIR__ . '/../services/AuthService.php';

class AuthController {
    private $authService;

    public function __construct() {
        $this->authService = new AuthService();
    }

    public function login($email, $senha) {
        try {
           
            if ($email === 'admin@teste.com' && $senha === '123456') {
                $token = $this->authService->gerarToken(1);
                echo json_encode(["token" => $token]);
            } else {
                http_response_code(401);
                echo json_encode(["erro" => "Credenciais inválidas"]);
            }
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(["erro" => "Erro interno no login"]);
        }
    }
}
