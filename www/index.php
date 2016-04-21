<?php //фронтконтроллер
//показывать все ошибки php(можно указать в php.ini)
error_reporting(E_ALL);
require_once __DIR__. '/autoload.php';
//конструируем название контроллера, запрашиваемого пользователем, либо News по-умолчанию
$ctrl = isset($_GET['ctrl']) ? $_GET['ctrl'] : 'News';
//конструируем название метода, запрашиваемого пользователем, либо All по-умолчанию
$act = isset($_GET['act']) ? $_GET['act'] : 'All';

//создаём имя класса контроллера
$controllerClassName = $ctrl . 'Controller';
//пытаемся подключить файл созданногоконтроллера
//require_once __DIR__ . '/controllers/' . $controllerClassName . '.php'; //перенесено в автозагрузку(autoload.php)
try{
    //создаём контроллер
    $controller = new $controllerClassName;
    //конструируем action(метод) контроллера
    $method = 'action' . $act;
    //вызываем action(метод) контроллера
    $controller->$method();
    //перехватываем пузырь исключения
}catch (ModelException $e){
    $view = new View();
    $view->error = $e->getMessage();
    $view->display('error.php');
}
