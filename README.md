# 🚀 Desafio Criativo API

## 📖 Visão Geral

A "Desafio Criativo API" é uma aplicação web desenvolvida em PHP que permite aos usuários criar, gerenciar e responder a desafios criativos. Ela oferece tanto uma API JSON para acesso programático quanto uma interface HTML simples para interação direta do usuário. O projeto segue o padrão MVC (Model-View-Controller) e inclui funcionalidades para gerenciar desafios e suas respectivas respostas, incluindo um sistema de votação para as respostas.

## ✨ Funcionalidades

A aplicação inclui as seguintes funcionalidades:

* **Desafios:**
    * Cadastro de novos desafios.
    * Edição de desafios existentes.
    * Listagem de todos os desafios.
    * Remoção de desafios.
* **Respostas:**
    * Envio de respostas para desafios específicos.
    * Edição de respostas existentes.
    * Listagem de respostas por desafio.
    * Exclusão de respostas.
    * Votação em respostas.
* **API:**
    * Endpoints baseados em JSON para todas as funcionalidades centrais (CRUD para desafios e respostas, votação).
* **Interface HTML:**
    * Páginas web para interagir com desafios e respostas de forma visual.
* **Sistema de Rotas:**
    * Configurado em `api_desafio_criativo/config/Router.php` e as rotas definidas em `api_desafio_criativo/public/index.php`.
* **Interação com Banco de Dados:**
    * Gerenciada via padrão DAO (Data Access Object).
    * Configuração em `api_desafio_criativo/config/database.php`.

## ⚙️ Tecnologias Utilizadas

* **PHP** (7.4 ou superior recomendado)
* **MySQL** (ou banco de dados compatível)
* **HTML** (para as views básicas)
* **Padrão MVC** (Model-View-Controller)
* **Servidor Apache** (ou similar como XAMPP, WAMP, Laragon)

## 📁 Estrutura do Projeto

.
└── api_desafio_criativo/
├── app/
│   ├── controllers/
│   │   ├── DesafioController.php  # Controla a lógica para desafios (API e HTML)
│   │   └── RespostaController.php # Controla a lógica para respostas (API e HTML)
│   ├── daos/
│   │   ├── DesafioDAO.php         # Objeto de Acesso a Dados para desafios
│   │   └── RespostaDAO.php        # Objeto de Acesso a Dados para respostas
│   ├── models/
│   │   ├── DesafioModel.php       # Modelo de dados para um desafio
│   │   └── RespostaModel.php      # Modelo de dados para uma resposta
│   └── views/
│       ├── desafios/
│       │   ├── cadastro_desafio.php    # Formulário HTML para criar desafios
│       │   ├── edicao_desafio.php      # Formulário HTML para editar desafios
│       │   └── listagem_desafios.php   # Página HTML para listar desafios
│       └── respostas/
│           ├── edicao_resposta.php       # Formulário HTML para editar respostas
│           ├── formulario_resposta.php # Formulário HTML para submeter respostas
│           └── listagem_respostas.php  # Página HTML para listar respostas de um desafio
├── config/
│   ├── database.php             # Configurações de conexão com o banco de dados
│   └── routes.php               # Classe Router para definir e despachar rotas
└── public/
└── index.php                # Ponto de entrada da aplicação, onde as rotas são definidas


## ✅ Pré-requisitos

* PHP 7.4 ou superior.
* MySQL (ou um sistema de banco de dados compatível).
* Servidor Web Apache (XAMPP, WAMP, Laragon ou similar são recomendados para facilidade de configuração).
* `mod_rewrite` do Apache habilitado (para URLs amigáveis, dependendo da configuração do servidor).

## 🛠️ Configuração e Instalação

1.  **Clone o Repositório:**
    ```bash
    git clone <url-do-seu-repositorio>
    cd <pasta-do-projeto>
    ```
2.  **Configuração do Banco de Dados:**
    * Localize o arquivo de configuração do banco de dados em `api_desafio_criativo/config/database.php`.
    * Crie um banco de dados no seu MySQL. Por exemplo, `desafios_criativos`.
    * Atualize as variáveis `$host`, `$dbname`, `$username`, e `$password` no arquivo `database.php` com as suas credenciais do MySQL.
    * **Schema SQL:** Crie as tabelas `desafios` e `respostas` no seu banco de dados.
        * **Tabela `desafios`**:
            ```sql
            CREATE TABLE desafios (
                id INT AUTO_INCREMENT PRIMARY KEY,
                titulo VARCHAR(255) NOT NULL,
                descricao TEXT NOT NULL,
                criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            );
            ```
            *(Baseado em `DesafioModel.php` e `DesafioDAO.php`)*
        * **Tabela `respostas`**:
            ```sql
            CREATE TABLE respostas (
                id INT AUTO_INCREMENT PRIMARY KEY,
                desafio_id INT NOT NULL,
                autor VARCHAR(100) NOT NULL,
                conteudo TEXT NOT NULL,
                votos INT DEFAULT 0,
                criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                FOREIGN KEY (desafio_id) REFERENCES desafios(id) ON DELETE CASCADE
            );
            ```
            *(Baseado em `RespostaModel.php` e `RespostaDAO.php`)*

3.  **Configuração do Servidor Web:**
    * Copie a pasta `api_desafio_criativo` (ou o conteúdo dela, ajustando os caminhos se necessário) para o diretório público do seu servidor Apache (ex: `htdocs` no XAMPP, `www` no WAMP).
    * Certifique-se de que o servidor Apache está configurado para permitir a reescrita de URL (`AllowOverride All` no arquivo de configuração do virtual host ou `.htaccess`, e `mod_rewrite` habilitado).

## 🚀 Executando a Aplicação

Acesse a aplicação através do seu navegador. O URL base será tipicamente:
`http://localhost/api_desafio_criativo/public/`

Por exemplo, para ver a lista de desafios via HTML:
`http://localhost/api_desafio_criativo/public/desafios_html`

## 📄 Descrição dos Arquivos Chave

* **`api_desafio_criativo/public/index.php`**: Ponto de entrada principal da aplicação. Ele inicializa o `Router` e define todas as rotas da API e da interface HTML.
* **`api_desafio_criativo/config/routes.php`**: Contém a classe `Router`, responsável por mapear os padrões de URL para as ações dos controllers.
* **`api_desafio_criativo/config/database.php`**: Contém a classe `DatabaseConnection`, que gerencia a conexão com o banco de dados MySQL usando PDO.
* **Controllers (`api_desafio_criativo/app/controllers/`)**:
    * `DesafioController.php`: Gerencia as requisições relacionadas a desafios, tanto para a API (retornando JSON) quanto para renderizar as views HTML.
    * `RespostaController.php`: Gerencia as requisições relacionadas a respostas, de forma similar ao `DesafioController`.
* **DAOs (`api_desafio_criativo/app/daos/`)**:
    * `DesafioDAO.php`: Manipula todas as operações de banco de dados para a tabela `desafios` (CRUD).
    * `RespostaDAO.php`: Manipula todas as operações de banco de dados para a tabela `respostas` (CRUD e votação).
* **Models (`api_desafio_criativo/app/models/`)**:
    * `DesafioModel.php`: Representa a estrutura de uma entidade 'desafio'.
    * `RespostaModel.php`: Representa a estrutura de uma entidade 'resposta'.
* **Views (`api_desafio_criativo/app/views/`)**: Contêm os arquivos HTML para apresentar os dados ao usuário. Estão organizados em subdiretórios para `desafios` e `respostas`.

## 📡 Endpoints da API (JSON)

O caminho base da API é `/api_desafio_criativo/public`. Todas as respostas da API são em formato JSON.

### Desafios (Challenges)

* **`GET /desafios`**: Lista todos os desafios.
    * Controlador: `DesafioController@listar`
* **`POST /desafios`**: Cria um novo desafio.
    * Corpo da Requisição: `{ "titulo": "string", "descricao": "string" }`
    * Controlador: `DesafioController@criar`
* **`GET /desafios/{id}`**: Obtém um desafio específico pelo ID.
    * Controlador: `DesafioController@buscar`
* **`PUT /desafios/{id}`**: Atualiza um desafio existente.
    * Corpo da Requisição: `{ "titulo": "string", "descricao": "string" }`
    * Controlador: `DesafioController@atualizar`
* **`DELETE /desafios/{id}`**: Remove um desafio pelo ID.
    * Controlador: `DesafioController@excluir`

### Respostas (Answers)

* **`GET /desafios/{id_desafio}/respostas`**: Lista todas as respostas para um desafio específico.
    * Controlador: `RespostaController@listarPorDesafio`
* **`POST /desafios/{id_desafio}/respostas`**: Cria uma nova resposta para um desafio específico.
    * Corpo da Requisição: `{ "autor": "string", "conteudo": "string" }`
    * Controlador: `RespostaController@criar`
* **`POST /respostas/{id_resposta}/votar`**: Incrementa a contagem de votos para uma resposta específica.
    * Controlador: `RespostaController@votar`
* **`DELETE /respostas/{id_resposta}`**: Remove uma resposta pelo ID.
    * Controlador: `RespostaController@excluir`
    * *Nota: A edição de respostas via API não está explicitamente definida nas rotas. Ela é feita via formulário HTML ou precisaria de um novo endpoint PUT.*

## 🖥️ Rotas da Interface HTML

Estas rotas fornecem uma interface baseada na web para interagir com a aplicação. O caminho base é `/api_desafio_criativo/public`.

### Desafios (Challenges) - HTML

* **`GET /desafios_html`**: Exibe uma lista de todos os desafios.
    * Controlador: `DesafioController@listarHtml`
* **`GET /desafios/formulario_cadastro_html`**: Mostra o formulário para criar um novo desafio.
    * Controlador: `DesafioController@mostrarFormularioCadastroHtml`
* **`POST /desafios/salvar_form`**: Processa o envio do formulário de novo desafio.
    * Controlador: `DesafioController@salvarForm`
* **`GET /desafios/formulario_edicao_html/{id}`**: Mostra o formulário para editar um desafio existente.
    * Controlador: `DesafioController@mostrarFormularioEdicaoHtml`
* **`POST /desafios/atualizar_form/{id}`**: Processa o envio do formulário de edição de desafio.
    * Controlador: `DesafioController@atualizarForm`
* **`GET /desafios/excluir_html/{id}`**: Remove um desafio (e suas respostas associadas).
    * Controlador: `DesafioController@excluirHtml`

### Respostas (Answers) - HTML

* **`GET /desafios_html/{id_desafio}/respostas`**: Exibe as respostas para um desafio específico.
    * Controlador: `RespostaController@mostrarRespostasHtml`
* **`GET /desafios_html/{id_desafio}/respostas/formulario_html`**: Mostra o formulário para adicionar uma nova resposta a um desafio.
    * Controlador: `RespostaController@mostrarFormularioRespostaHtml`
* **`POST /desafios_html/{id_desafio}/respostas/salvar_form`**: Processa o envio do formulário de nova resposta.
    * Controlador: `RespostaController@salvarRespostaForm`
* **`GET /respostas_html/{id_resposta}/votar_form`**: Registra um voto para uma resposta.
    * Controlador: `RespostaController@votarRespostaForm`
* **`GET /respostas_html/{id_resposta}/formulario_edicao_html`**: Mostra o formulário para editar uma resposta existente.
    * Controlador: `RespostaController@mostrarFormularioEdicaoRespostaHtml`
* **`POST /respostas_html/{id_resposta}/atualizar_form`**: Processa o envio do formulário de edição de resposta.
    * Controlador: `RespostaController@atualizarRespostaForm`
* **`GET /respostas_html/{id_resposta}/excluir_form`**: Remove uma resposta.
    * Controlador: `RespostaController@excluirRespostaForm`

## 📝 Observações

* O projeto utiliza um roteador simples (`config/Router.php`) para lidar com as requisições.
* A persistência de dados é feita em um banco de dados MySQL, com interações encapsuladas nas classes DAO.
* A interface HTML é básica e serve para demonstrar as funcionalidades.
* Certifique-se de que o `basePath` em `public/index.php` e nos controllers (`getBasePath()`) esteja configurado corretamente caso sua aplicação não esteja na raiz do servidor ou em um subdiretório padrão.
