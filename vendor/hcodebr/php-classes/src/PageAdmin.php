<?php

namespace Hcode; // Define o namespace da classe, agrupando-a logicamente com outras do projeto

use Rain\Tpl; // Importa a classe Rain\Tpl para renderização de templates (mesmo que não seja usada diretamente aqui)

class PageAdmin extends Page { // Define a classe PageAdmin que estende (herda) a classe Page

    public function __construct($opts = array(), $tpl_dir = "/views/admin/") // Construtor da PageAdmin
    {
        parent::__construct($opts, $tpl_dir); // Chama o construtor da classe pai (Page), passando as opções e o diretório específico de templates do admin
    }

}
