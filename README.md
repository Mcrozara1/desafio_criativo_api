🚀 Funcionalidades

Desafios: Cadastro, edição, listagem e remoção.

Respostas: Envio, edição, listagem e exclusão.

Sistema de Rotas: Configurado em config/Router.php.

Banco de Dados: Configurado em config/database.php.

⚙️ Tecnologias Utilizadas

PHP

MySQL (ou compatível)

HTML (para views básicas)

Padrão MVC

🛠️ Como Executar

Clone este repositório.

Configure o banco de dados em config/database.php.

Coloque os arquivos na pasta pública do seu servidor Apache (ex.: htdocs no XAMPP).

Acesse via navegador:
http://localhost/api_desafio_criativo/public/

✅ Pré-requisitos

PHP 7.4 ou superior

MySQL

Servidor Apache (XAMPP, WAMP, Laragon ou similar)

📝 Rotas Principais

Desafios
GET /desafios - Listar desafios

GET /desafios/cadastrar - Formulário de cadastro

POST /desafios/cadastrar - Cadastrar desafio

GET /desafios/editar/{id} - Formulário de edição

POST /desafios/editar/{id} - Editar desafio

GET /desafios/deletar/{id} - Deletar desafio

Respostas

GET /respostas - Listar respostas

GET /respostas/cadastrar - Formulário de resposta

POST /respostas/cadastrar - Enviar resposta

GET /respostas/editar/{id} - Formulário de edição

POST /respostas/editar/{id} - Editar resposta

GET /respostas/deletar/{id} - Deletar resposta