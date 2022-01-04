<?php

    function autoload($classes) {

        $diretorioBase = DIR_APP . DS;
        $classes = $diretorioBase . 'Classes' . DS . str_replace('\\', DS , $classes). '.php';

        if(file_exists($classes) && !is_dir($classes)):
            include $classes;
        endif;
    }

    spl_autoload_register('autoload');