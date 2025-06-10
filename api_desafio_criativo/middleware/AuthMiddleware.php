<?php
require_once __DIR__ . '/../services/AuthService.php';

function protegerRota() {
    $headers = getallheaders();
    if (!isset($headers['Authorization'])) {
        http_response_code(401);
        echo json_encode(['erro' => 'Token não enviado']);
        exit;
    }

    $token = str_replace('Bearer ', '', $headers['Authorization']);
    $auth = new AuthService();
    $decodificado = $auth->validarToken($token);

    if (!$decodificado) {
        http_response_code(401);
        echo json_encode(['erro' => 'Token inválido']);
        exit;
    }

    return $decodificado;
}
