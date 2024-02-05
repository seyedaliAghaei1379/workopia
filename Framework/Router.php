<?php

namespace Framework;

//$routes = require basePath('routes.php');
//
//
//if(array_key_exists($uri , $routes)){
//    return require basePath($routes[$uri]);
//}else{
//    http_response_code(404);
//    return require basePath($routes['/404']);
//}
class Router {
    protected $routes = [];

    /**
     * @param string $method
     * @param string $uri
     * @param string $action
     * @return void
     */
    public function registeredRoute($method,$uri , $action ){
        list($controller , $controllerMethod) = explode('@' , $action);
//        inspectAndDie($controller);
        $this->routes[] = [
            'method' => $method,
            'uri' => $uri,
            'controller' => $controller,
            'controllerMethod' => $controllerMethod
        ];
    }
    /**
     * Add a GET route
     *
     * @param string $uri
     * @param string $controller
     * @return void
     *
     */
    public function get($uri , $controller)
    {
        $this->registeredRoute('GET' , $uri , $controller);
    }
    /**
     * Add a POST route
     *
     * @param string $uri
     * @param string $controller
     * @return void
     *
     */
    public function post($uri , $controller)
    {
        $this->registeredRoute('POST' , $uri , $controller);
    }
    /**
     * Add a PUT route
     *
     * @param string $uri
     * @param string $controller
     * @return void
     *
     */
    public function put($uri , $controller)
    {
        $this->registeredRoute('PUT' , $uri , $controller);
    }
    /**
     * Add a DELETE route
     *
     * @param string $uri
     * @param string $controller
     * @return void
     *
     */
    public function delete($uri , $controller)
    {
        $this->registeredRoute('DELETE' , $uri , $controller);
    }

    /**
     * Load error page
     * @param int $httpCode
     * 
     * @return void
     */
    public function error($httpCode = 404)
    {
        http_response_code($httpCode);
        loadView("error/$httpCode");
        exit;
    }

    /**
     * Route the request
     *
     * @param string $uri
     * @param string $method
     * @return void
     */
    public function route($uri, $method){
//        inspect($this->routes);
        foreach ($this->routes as $route){
            if($route['uri'] === $uri && $route['method'] === $method){
                $controller = 'App\\Controllers\\' . $route['controller'];
                $controllerMethod = $route['controllerMethod'];

//                Instanciate the controller and call the method
                $controllerInstace = new $controller();
                $controllerInstace->$controllerMethod();


                return;
            }
        }

        $this->error(404);
    }
}