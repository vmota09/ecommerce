<?php

require_once("vendor/autoload.php");
error_reporting(E_ALL & ~E_DEPRECATED & ~E_NOTICE); //some com os erros que dá pela versão antiga do slim

use \Hcode\PageAdmin;

$app = new \Slim\Slim();

$app->config('debug', true);


$app->get('/', function() {

    $page = new Hcode\Page();

    $page->setTpl("index");

});

//parte do admin que ainda não funciona

//$app->get('/admin', function() {

    //$page = new \Hcode\PageAdmin();

    //$page->setTpl("index");

//});

$app->run();


