<?php 
namespace App\Core;
final class Router{
    private $routes = [];

    public function __construct() {}

    public function add(Route $route){
        $this->routes[] = $route;
    }

    public function find(string $method, $url): ?Route{
        foreach($this->routes as $route){
            if($route->matches($method, $url)){
                return $route;
            }
        }
        throw new \Exception("Route not found for method {$method} and URL {$url}");
    }
}