<?php

namespace Framework;
//use Framework\Middleware\Authorize;
use App\Controllers\ErrorController;
use Framework\Middleware\Authorize;

//use Framework\Middleware\Authorize;

//$routes = require basePath('routes.php');
//
//
//if(array_key_exists($uri , $routes)){
//    return require basePath($routes[$uri]);
//}else{
//    http_response_code(404);
//    return require basePath($routes['/404']);
//}


class Router
{

    protected $routes = [];

    /**
     * @param string $method
     * @param string $uri
     * @param string $action
     * @param array $middleware
     * @return void
     */
    public function registeredRoute($method, $uri, $action, $middleware = [])
    {
        list($controller, $controllerMethod) = explode('@', $action);
//        inspectAndDie($controller);
        $this->routes[] = [
            'method' => $method,
            'uri' => $uri,
            'controller' => $controller,
            'controllerMethod' => $controllerMethod,
            'middleware' => $middleware
        ];
    }

    /**
     * Add a GET route
     *
     * @param string $uri
     * @param string $controller
     * @param array $middleware
     * @return void
     *
     */
    public function get($uri, $controller, $middleware = [])
    {
        $this->registeredRoute('GET', $uri, $controller, $middleware);
    }

    /**
     * Add a POST route
     *
     * @param string $uri
     * @param string $controller
     * @param array $middleware
     * @return void
     *
     */
    public function post($uri, $controller, $middleware = [])
    {
        $this->registeredRoute('POST', $uri, $controller, $middleware);
    }

    /**
     * Add a PUT route
     *
     * @param string $uri
     * @param string $controller
     * @param array $middleware
     * @return void
     *
     */
    public function put($uri, $controller, $middleware = [])
    {
        $this->registeredRoute('PUT', $uri, $controller, $middleware);
    }

    /**
     * Add a DELETE route
     *
     * @param string $uri
     * @param string $controller
     * @param array $middleware
     * @return void
     *
     */
    public function delete($uri, $controller, $middleware = [])
    {
        $this->registeredRoute('DELETE', $uri, $controller, $middleware);
    }

    /**
     * Route the request
     *
     * @param string $uri
     * @param string $method
     * @return void
     */
    public function route($uri)
    {
        $requestMethod = $_SERVER['REQUEST_METHOD'];
//        inspectAndDie($this);

        // Check for _method input
        if ($requestMethod === 'POST' && isset($_POST['_method'])) {
            // Override the request method with the value of _method
            $requestMethod = strtoupper($_POST['_method']);
        }


        foreach ($this->routes as $route) {
//            Split the current Uri into segments
            $uriSegments = explode('/', trim($uri, '/'));

//            Split the route Uri into segments
            $routeSegments = explode('/', trim($route['uri'], '/'));

            $match = true;

            if (count($uriSegments) === count($routeSegments) && strtoupper($route['method']) === $requestMethod) {
                $params = [];

                $match = true;

                for ($i = 0; $i < count($uriSegments); $i++) {
//                    if the uri's do not match  and there is no param
                    if ($routeSegments[$i] !== $uriSegments[$i] && !preg_match('/\{(.+?)\}/', $routeSegments[$i])) {
                        $match = false;
                        break;
                    }

                    // check for the param and add to $params array
                    if (preg_match('/\{(.+?)\}/', $routeSegments[$i], $matches)) {
//                        inspectAndDie($matches[1]);
//                        inspectAndDie($uriSegments[$i]);
                        $params[$matches[1]] = $uriSegments[$i];
                    }
                }

                if ($match) {
//                    inspectAndDie($route['middleware']);
//                    inspectAndDie($route['middleware']);
                    foreach ($route['middleware'] as $middleware) {
                        (new Authorize())->handle($middleware);
//                        inspect("salam");
                    }

                    $controller = 'App\\Controllers\\' . $route['controller'];
                    $controllerMethod = $route['controllerMethod'];

//                Instanciate the controller and call the method
                    $controllerInstace = new $controller();
                    $controllerInstace->$controllerMethod($params);
                    return;
                }
            }

        }

        ErrorController::notFound();
    }
}