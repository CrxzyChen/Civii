<?php
/**
 * Created by PhpStorm.
 * User: Crxzy
 * Date: 2018/7/26
 * Time: 21:36
 */
if (file_exists('config.json')) {
    $config_json = file_get_contents('config.json');
    $config = json_decode($config_json);
} else {
    die('config.json is not exist!');
}

define("HOST_ROOT", $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['SERVER_ADDR'] . ($_SERVER['SERVER_PORT'] == '80' ? '' : ":{$_SERVER['SERVER_PORT']}") . dirname($_SERVER['SCRIPT_NAME']) . '/');
define('SCRIPT_ROOT', dirname($_SERVER['SCRIPT_FILENAME']));
define('CONTROLLER_PATH', SCRIPT_ROOT . '/' . 'controller' . '/');
define('VIEW_PATH', SCRIPT_ROOT . '/' . 'view' . '/');
define('LAYOUT_PATH', VIEW_PATH . 'layout' . '/');
define('COMPONENT_PATH', VIEW_PATH . 'component' . '/');

if (isset($_GET['args'])) {
    $args = explode('/', $_GET['args']);
    if (sizeof($args) > 1) {
        $controller_name = array_shift($args);
        $method_name = array_shift($args);
        $_GET['args'] = $args;
    } else {
        die('path error!');
    }
} else {
    $controller_name = $_GET['controller'] ?? 'view';
    $method_name = $_GET['method'] ?? 'index';
}


function auto_load_func($classname)
{
    $script = CONTROLLER_PATH . $classname . '.php';
    if (file_exists($script)) {
        require_once $script;
    }
}

spl_autoload_register('auto_load_func', true, true);

$class = new ReflectionClass($controller_name . 'Controller');
$controller = $class->newInstance();
$controller->$method_name();