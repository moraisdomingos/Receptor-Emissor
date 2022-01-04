<?php

    define('HOST', 'localhost');
    define('BANCO', 'testeterca');
    define('USER', 'root');
    define('PASSWORD', '');

    define('DS', DIRECTORY_SEPARATOR);
    define('DIR_APP', __DIR__);
    define('APP_PROJECT', 'Tr16h');

    if(file_exists('autoload.php')):
        include 'autoload.php';
    else:
        'Erro ao incluir o arquivo de autoload';
    endif;