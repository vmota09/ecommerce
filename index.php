<?php 

require_once("vendor/autoload.php");

error_reporting(E_ALL & ~E_DEPRECATED & ~E_NOTICE); //some com os erros que dá pela versão antiga do slim

$app = new \Slim\Slim();

$app->config('debug', true);

$app->get('/', function() {
    

    $sql = new Hcode\DB\Sql();
    $results = $sql->select("SELECT * FROM tb_users");

    echo json_encode($results);

});

$app->run();
