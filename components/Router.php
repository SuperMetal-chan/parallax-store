<?php

class Router
{

    private $routes;

    /**
     * Router constructor.
     */
    public function __construct()
    {
        $routesPath = ROOT . '/configuration/routes.php';
        $this->routes = include($routesPath);
    }

    // Возвращает запрос URI типа string

    /**
     * @return string
     */
    public function getURI()
    {
        if (!empty($_SERVER['REQUEST_URI'])) {
            return trim($_SERVER['REQUEST_URI'], '/');
        }
    }

    /**
     *
     */
    public function run()
    {
        // ---------------------------------------------------------------------------
        // Получить строку запроса
        // ---------------------------------------------------------------------------

        $uri = $this->getURI();

        // ---------------------------------------------------------------------------
        // Проверить наличие такого запроса в routes.php и если есть совпадение,
        // определить контроллер, action и параметры
        // ---------------------------------------------------------------------------

        foreach ($this->routes as $uriPattern => $path) {

            // Сравнить $uriPattern и $uri
            if (preg_match("~$uriPattern~", $uri)) {
                {
                    // Получить внутренний путь из внешнего
                    $internalRoute = preg_replace("~$uriPattern~",$path,$uri);

                    // explode - разделяет массив по "/"
                    $segments = explode("/", $internalRoute);

                    // ucfirst - начать слово с большой буквы, array_shift - получить первый элемент массива
                    $contollerName = ucfirst(array_shift($segments))."Controller";
                    $actionName = "action".ucfirst(array_shift($segments));

                    // ---------------------------------------------------------------------------
                    // Подключить файл класса-контроллера
                    // ---------------------------------------------------------------------------

                    $contollerFile = ROOT.'/controllers/'.$contollerName.'.php';

                    if(file_exists($contollerFile))
                        include_once($contollerFile);

                    // ---------------------------------------------------------------------------
                    // Создать объект, вызвать метод (action)
                    // ---------------------------------------------------------------------------

                    $contollerObject = new $contollerName;
                    $result = call_user_func_array(array($contollerObject,$actionName),$segments);
                    if($result!=null)
                        break;

                }
            }

        }

    }
}