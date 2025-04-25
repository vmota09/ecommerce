<?php

namespace Hcode;

use Rain\Tpl;

class Page {

    private $tpl;
    private $options = [];
    private $defaults = [
        "header"=>true,
        "footer"=>true,
        "data"=>[]
    ];

    public function __construct($opts = array()) //o primeiro a ser executado
    {

        $this->options = array_merge($this->defaults, $opts);

        $config = array(
            "base_url"      => null,
            "tpl_dir"       => $_SERVER['DOCUMENT_ROOT']."/ecommerce2/views/", //caminho da pasta criada com os templates html
            "cache_dir"     => $_SERVER['DOCUMENT_ROOT']."/ecommerce2/views-cache/",
            "debug"         => false
        );

        Tpl::configure( $config );

        $this->tpl = new Tpl();

        if ($this->options['data']) $this->setData($this->options['data']);

        if ($this->options['header'] === true) $this->tpl->draw("header", false);

    }

    public function __destruct() //o ultimo a ser executado
    {

        if ($this->options['footer'] === true) $this->tpl->draw("footer", false);

    }

    private function setData($data = array())
    {

        foreach($data as $key => $val)
        {

            $this->tpl->assign($key, $val);

        }

    }

    public function setTpl($tplname, $data = array(), $returnHTML = false)
    {

        $this->setData($data);

        return $this->tpl->draw($tplname, $returnHTML);

    }

}

?>