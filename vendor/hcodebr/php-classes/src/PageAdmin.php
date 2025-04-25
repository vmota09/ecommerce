<?php

namespace Hcode;

class PageAdmin extends Page{

    public function __construct($opts = array(), $tpl_dir = "/ecommerce2/views/admin")
    {
        parent::__construct($opts, $tpl_dir);
    }
}