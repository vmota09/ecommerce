<?php

namespace Hcode; // Define o namespace da classe, útil para organização e evitar conflitos de nomes

use Rain\Tpl; // Importa a classe Tpl da biblioteca RainTPL para renderizar templates HTML

class Page { // Define a classe Page, responsável por gerar páginas com layout padrão

    private $tpl; // Armazena a instância do motor de template Rain\Tpl
    private $options = []; // Guarda as opções passadas pelo usuário (header, footer, data)
    private $defaults = [ // Define valores padrão para as opções a serem exibidas. (todos os templates)
        "header"=>true, // Mostra o cabeçalho por padrão
        "footer"=>true, // Mostra o rodapé por padrão
        "data"=>[] // Dados que serão passados ao template
    ];

    //o $opts serve para personalizar quais páginas vão serem exibidas (header, index, footer). ao não ter nada, o $defaults entra como padrão

    public function __construct($opts = array(), $tpl_dir = "/views/") // Método construtor, executado automaticamente ao criar o objeto
    {

        $this->options = array_merge($this->defaults, $opts); // Junta os valores padrão com os valores passados

        $config = array(
            "base_url"      => null, // Caminho base não usado aqui
            "tpl_dir"       => $_SERVER['DOCUMENT_ROOT'].$tpl_dir, // Caminho absoluto para a pasta de templates
            "cache_dir"     => $_SERVER['DOCUMENT_ROOT']."/views-cache/", // Caminho onde os arquivos compilados ficam armazenados
            "debug"         => false // Desativa modo debug no RainTPL
        );

        Tpl::configure( $config ); // Aplica a configuração ao motor de template

        $this->tpl = new Tpl(); // Cria uma nova instância do template

        if ($this->options['data']) $this->setData($this->options['data']); // Se houver dados, envia para o template

        if ($this->options['header'] === true) $this->tpl->draw("header", false); // Se ativado, renderiza o cabeçalho da página

    }

    public function __destruct() // Método destrutor, executado ao fim da execução da classe
    {

        if ($this->options['footer'] === true) $this->tpl->draw("footer", false); // Se ativado, renderiza o rodapé da página

    }

    private function setData($data = array()) // Define os dados que serão passados para o template
    {

        foreach($data as $key => $val) // Percorre os dados e envia para o template
        {

            $this->tpl->assign($key, $val); // Atribui os dados ao template usando a chave como nome da variável

        }

    }

    public function setTpl($tplname, $data = array(), $returnHTML = false) // Renderiza o template principal da página
    {

        $this->setData($data); // Envia dados ao template, se houver

        return $this->tpl->draw($tplname, $returnHTML); // Desenha o template especificado. Se $returnHTML for true, retorna como string

    }

}
