<?php 

/**
* Автозагрузка классов
*/

function ds_autoload($class) 
{
    $filename = 'class.' . $class . '.php';
    $file = dirname(__FILE__) . DIRECTORY_SEPARATOR . $filename;
    
    if (file_exists($file) == false) {
        return false;
    }

    include ($file);
}

/**
* PHP_VERSION >= 7.2.0
* Регистрируем автозагрузчик классов
*/

if (function_exists('spl_autoload_register')) {
    spl_autoload_register('ds_autoload');
} 

else {
    require(dirname(__FILE__) . DIRECTORY_SEPARATOR . '__autoload.php');
}