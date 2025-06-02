<?php
require_once __DIR__ . '/../config/Router.php';

$scriptDir = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME']));
$basePath = preg_replace('#/public$#', '', $scriptDir);
if ($basePath === '/' || $basePath === '') {
    $basePath = '';
}

$router = new Router($basePath);

// --- Rotas da API (JSON) ---
// Rotas para Desafios (API)
$router->get('/desafios', 'DesafioController@listar');
$router->post('/desafios', 'DesafioController@criar');
$router->get('/desafios/{id}', 'DesafioController@buscar');
$router->put('/desafios/{id}', 'DesafioController@atualizar');
$router->delete('/desafios/{id}', 'DesafioController@excluir');

// Rotas para Respostas (API)
$router->get('/desafios/{id_desafio}/respostas', 'RespostaController@listarPorDesafio');
$router->post('/desafios/{id_desafio}/respostas', 'RespostaController@criar');
$router->post('/respostas/{id_resposta}/votar', 'RespostaController@votar');
$router->delete('/respostas/{id_resposta}', 'RespostaController@excluir');


// --- Rotas para Interface HTML ---
// Rotas para Desafios (HTML)
$router->get('/desafios_html', 'DesafioController@listarHtml');
$router->get('/desafios/formulario_cadastro_html', 'DesafioController@mostrarFormularioCadastroHtml');
$router->post('/desafios/salvar_form', 'DesafioController@salvarForm'); 
$router->get('/desafios/formulario_edicao_html/{id}', 'DesafioController@mostrarFormularioEdicaoHtml');
$router->post('/desafios/atualizar_form/{id}', 'DesafioController@atualizarForm');
$router->get('/desafios/excluir_html/{id}', 'DesafioController@excluirHtml');

// Rotas para Respostas (HTML)
$router->get('/desafios_html/{id_desafio}/respostas', 'RespostaController@mostrarRespostasHtml');
$router->get('/desafios_html/{id_desafio}/respostas/formulario_html', 'RespostaController@mostrarFormularioRespostaHtml');
$router->post('/desafios_html/{id_desafio}/respostas/salvar_form', 'RespostaController@salvarRespostaForm'); 

// Ações em respostas via HTML 
$router->get('/respostas_html/{id_resposta}/votar_form', 'RespostaController@votarRespostaForm');
$router->get('/respostas_html/{id_resposta}/excluir_form', 'RespostaController@excluirRespostaForm');
$router->get('/respostas_html/{id_resposta}/formulario_edicao_html', 'RespostaController@mostrarFormularioEdicaoRespostaHtml');
$router->post('/respostas_html/{id_resposta}/atualizar_form', 'RespostaController@atualizarRespostaForm');


$router->dispatch();

?>