<?php

namespace Src;

use FastRoute\RouteCollector;
use FastRoute\RouteParser\Std;
use FastRoute\DataGenerator\MarkBased;
use FastRoute\Dispatcher\MarkBased as Dispatcher;
use Src\Traits\SingletonTrait;

class Middleware
{
    use SingletonTrait;

    private RouteCollector $middlewareCollector;

    public function add($httpMethod, string $route, array $action): void
    {
        $this->middlewareCollector->addRoute($httpMethod, $route, $action);
    }

    public function group(string $prefix, callable $callback): void
    {
        $this->middlewareCollector->addGroup($prefix, $callback);
    }

    private function __construct()
    {
        $this->middlewareCollector = new RouteCollector(new Std(), new MarkBased());
    }

    // Главный метод, который вызывается из Route::start()
    public function go(string $httpMethod, string $uri, Request $request): Request
    {
        $request = $this->runAppMiddlewares($request);
        $request = $this->runMiddlewares($httpMethod, $uri, $request);
        return $request;
    }

    // Глобальные middleware
    private function runAppMiddlewares(Request $request): Request
    {
        $middlewares = app()->settings->app['routeAppMiddleware'] ?? [];
        foreach ($middlewares as $class) {
            $request = (new $class)->handle($request);
        }
        return $request;
    }

    // Маршрутные middleware (привязанные к конкретным URL)
    private function runMiddlewares(string $httpMethod, string $uri, Request $request): Request
    {
        $routeMiddleware = app()->settings->app['routeMiddleware'] ?? [];
        $middlewares = $this->getMiddlewaresForRoute($httpMethod, $uri);
        foreach ($middlewares as $middleware) {
            $args = explode(':', $middleware);
            $request = (new $routeMiddleware[$args[0]])->handle($request, $args[1] ?? null);
        }
        return $request;
    }

    private function getMiddlewaresForRoute(string $httpMethod, string $uri): array
    {
        $dispatcherMiddleware = new Dispatcher($this->middlewareCollector->getData());
        return $dispatcherMiddleware->dispatch($httpMethod, $uri)[1] ?? [];
    }
}