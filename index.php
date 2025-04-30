<?php
session_start(); // Inicia a sessão para gerenciar dados entre requisições, como autenticação de usuário
error_reporting(E_ALL & ~E_DEPRECATED); // Mostra todos os erros, exceto os de código obsoleto (deprecated)

require_once("vendor/autoload.php"); // Carrega automaticamente as classes usando o Composer

use Hcode\Model\User; // Usa a classe User do namespace Hcode\Model

$app = new \Slim\Slim(); // Cria uma instância do Slim Framework para gerenciar rotas e requisições

ini_set('display_errors', 1); // Ativa a exibição de erros em tempo de execução
ini_set('display_startup_errors', 1); // Ativa a exibição de erros que ocorrem na inicialização do PHP
error_reporting(E_ALL); // Ativa todos os tipos de erros para facilitar o debug

$app->config('debug', true); // Ativa o modo debug do Slim para mostrar mensagens de erro detalhadas

$app->get('/', function() { // Define a rota GET para a URL raiz ("/")

    $page = new Hcode\Page(); // Cria uma nova página com layout padrão (usuário comum)

    $page->setTpl("index"); // Define que o template a ser carregado é o "index.html"

});

$app->get('/admin', function() { // Define a rota GET para "/admin"

    User::verifyLogin(); // Verifica se o usuário está logado; se não, redireciona para o login

    $page = new Hcode\PageAdmin(); // Cria uma nova página com layout administrativo

    $page->setTpl("index"); // Define que o template a ser exibido é o "admin/index.html"

});

$app->get('/admin/login', function() { // Define a rota GET para "/admin/login"

    $page = new Hcode\PageAdmin([ // Cria uma página administrativa
        "header"=>false, // Desativa o cabeçalho na página de login
        "footer"=>false // Desativa o rodapé na página de login
    ]);

    $page->setTpl("login"); // Define que o template a ser carregado é o "admin/login.html"

});

$app->post('/admin/login', function() { // Define a rota POST para "/admin/login"

    User::login(post('deslogin'), post('despassword')); // Realiza o login usando os dados do formulário

    header("Location: /admin"); // Redireciona para a página administrativa após login bem-sucedido
    exit; // Encerra o script imediatamente após o redirecionamento

});

$app->get('/admin/logout', function() { // Define a rota GET para "/admin/logout"

    User::logout(); // Realiza o logout do usuário (encerra a sessão)
    header("Location: /admin/login"); // Redireciona para a página de login após logout
    exit; // Encerra o script imediatamente

});

$app->run(); // Inicia a aplicação Slim, processando as rotas definidas
