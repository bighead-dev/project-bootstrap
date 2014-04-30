<?php

defined('KERN_PATH') || define('KERN_PATH', './application/Kern');
defined('API_PATH')  || define('API_PATH', './application/Api');
defined('LIB_PATH')  || define('LIB_PATH', './application/Lib');

/* load up composer */
require_once 'vendor/autoload.php';

/* load up krak */
require_once './application/third_party/Krak/Autoload.php';

/* load up the loader */
require_once LIB_PATH . '/Loader.php';

/* make sure user defined the proper functions before running the bootstrap */
function check_project_functions()
{
    $funcs = [
        'get_app_env',
        'get_app_loaders'
    ];
    
    foreach ($funcs as $f)
    {
        if (!function_exists($f)) {
            throw new Exception("function '{$f}' was not defined. please double check your project setup");
        }
    }
}

/* set error reporting */
function set_erp()
{
    switch (Lib\Config::$env)
    {
        case Lib\Config::ENV_DEV:
        case Lib\Config::ENV_STG:
            error_reporting(E_ALL);
            break;
        case Lib\Config::ENV_PRD:
            error_reporting(0);
            ini_set('display_errors', 0);
            break;
    }
}

function main()
{
    check_project_functions();

    /* run the loaders */
    $loaders = [
        new Lib\Loader('Lib',  LIB_PATH .'/'),
        require_once KERN_PATH . '/Autoload.php',
        new Lib\Loader('Api',  API_PATH . '/'),
    ] + get_app_loaders();
    
    foreach ($loaders as $ldr)
    {
        if ($ldr instanceof Lib\Loader == false) {
            throw new Exception('A loader defined is not an instance of Lib\Loader');
        }
        
        $ldr->register();
    }
    
    Lib\Config::setEnv(get_app_env());
    set_erp();
}

main();
