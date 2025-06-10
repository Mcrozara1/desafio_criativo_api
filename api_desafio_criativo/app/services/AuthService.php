<?php
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class AuthService {
    private $config;

    public function __construct() {
        $this->config = include __DIR__ . '/../../config/jwt.php';
    }

    public function gerarToken($usuarioId) {
        $payload = [
            'iss' => $this->config['issuer'],
            'aud' => $this->config['audience'],
            'iat' => time(),
            'exp' => time() + $this->config['expiration_time'],
            'uid' => $usuarioId
        ];
        return JWT::encode($payload, $this->config['secret_key'], 'HS256');
    }

    public function validarToken($token) {
        try {
            return JWT::decode($token, new Key($this->config['secret_key'], 'HS256'));
        } catch (Exception $e) {
            return false;
        }
    }
}
