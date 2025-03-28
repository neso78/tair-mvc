<?php 

namespace App\Core;
final class Route {
    private array $methods;
    private string $controller;
    private string $functionName;
    private string $pattern;

    private function __construct(array|string $methods, string $pattern, string $controller, string $functionName) {
        // Ako je prosleđen string, konvertujemo ga u niz
        $this->methods = is_string($methods) ? explode('|', $methods) : $methods;
        $this->controller = $controller;
        $this->functionName = $functionName;
        $this->pattern = $pattern;
    }
    
    public static function get(string $pattern, string $controller, string $functionName): Route {
        return new self('GET', $pattern, $controller, $functionName);
    }

    public static function post(string $pattern, string $controller, string $functionName): Route {
        return new self('POST', $pattern, $controller, $functionName);
    }

    public static function put(string $pattern, string $controller, string $functionName): Route {
        return new self('PUT', $pattern, $controller, $functionName);
    }

    public static function delete(string $pattern, string $controller, string $functionName): Route {
        return new self('DELETE', $pattern, $controller, $functionName);
    }

    public static function any(string $pattern, string $controller, string $functionName): Route {
        return new self(['GET', 'POST', 'PUT', 'DELETE'], $pattern, $controller, $functionName);
    }

    public function matches(string $method, string $url): bool {
        if (!in_array($method, $this->methods)) {
            return false;
        }
        return (bool) preg_match($this->pattern, $url);
    }
    
    public function getControllerName(): string {
        return $this->controller;
    }

    public function getFunctionName(): string {
        return $this->functionName;
    }

    public function &extractsArguments(string $url) {
        $matches = [];
        $arguments = [];
        preg_match($this->pattern, $url, $matches);
        if (isset($matches[1])) {
            $arguments = $matches[1];
        }
        return $arguments;
    }
}
