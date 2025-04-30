<?php
// Redireciona para o index.php se o arquivo não existir fisicamente
if (php_sapi_name() === 'cli-server') {
    $url  = parse_url($_SERVER['REQUEST_URI']);
    $file = __DIR__ . $url['path'];

    if (is_file($file)) {
        return false;
    }
}

require_once __DIR__ . '/index.php';

