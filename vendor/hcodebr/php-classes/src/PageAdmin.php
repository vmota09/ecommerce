<?php

namespace Hcode;
use Rain\Tpl;

class PageAdmin extends Page {

    public function __construct($opts = array(), $tpl_dir = "/ecommerce2/views/admin/")
    {
        parent::__construct($opts, $tpl_dir);
    }

}