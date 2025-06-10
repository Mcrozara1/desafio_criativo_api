<?php

require_once __DIR__ . '/Router.php';
require_once __DIR__ . '/vendor/autoload.php';

$router = new Router();


$router->post('/login', 'AuthController@login');

$router->get('/rota-protegida', 'AuthController@rotaProtegida');

$router->dispatch();

class Router {
  
    private $routes = [];
    private $basePath = ''; //como a gente vai mexer na raiz do dominio,isso não prewcisa ser configurado 

    public function __construct($basePath = '') {
        // Remove a barra final do basePath, se houver,evitar duplicação de barras (//)
        $this->basePath = rtrim($basePath, '/');
    }

    private function addRoute($method, $path, $handler) {
        $fullPath = $this->basePath . '/' . ltrim($path, '/');
        $fullPath = preg_replace('#/+#', '/', $fullPath);

        $this->routes[] = [
            'method' => strtoupper($method),
            'path' => $fullPath,
            'handler' => $handler 
        ];
    }

    public function get($path, $handler) {
        $this->addRoute('GET', $path, $handler);
    }

    public function post($path, $handler) {
        $this->addRoute('POST', $path, $handler);
    }

    public function put($path, $handler) {
        $this->addRoute('PUT', $path, $handler);
    }

    public function delete($path, $handler) {
        $this->addRoute('DELETE', $path, $handler);
    }

    public function dispatch() {
        $requestMethod = $_SERVER['REQUEST_METHOD'];
        $requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        // aqui é para não vir um viado e tentar manipular a rota, pq aí vai aceitar múltiplas barras na URI da requisicao
        $requestUri = preg_replace('#/+#', '/', $requestUri);


        foreach ($this->routes as $route) {
            if ($requestMethod !== $route['method']) {
                continue;
            }

            // Converte o padrão da rota para uma expressão regular
            // Ex: /desafios/{id} -> #^/desafios/([^/]+)$#
            $pattern = preg_replace_callback('/\{([a-zA-Z0-9_]+)\}/', function ($matches) {
                return '(?P<' . $matches[1] . '>[^/]+)';
            }, $route['path']);
            $pattern = '#^' . $pattern . '$#';


            if (preg_match($pattern, $requestUri, $matches)) {
                $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);

                list($controllerName, $methodName) = explode('@', $route['handler']);

                $controllerFile = __DIR__ . '/../app/controllers/' . $controllerName . '.php';

                if (file_exists($controllerFile)) {
                    require_once $controllerFile;
                    if (class_exists($controllerName)) {
                        $controllerInstance = new $controllerName();
                        if (method_exists($controllerInstance, $methodName)) {
                            call_user_func_array([$controllerInstance, $methodName], $params);
                            return; 
                        }
                    }
                }
                header("HTTP/1.0 500 Internal Server Error");
                echo json_encode(['erro' => "Erro no servidor ao tentar carregar o manipulador da rota."]);
                return;
            }
        }

        header("HTTP/1.0 404 Not Found");
        echo json_encode(['erro' => 'Rota não encontrada']);
    }
}
?>