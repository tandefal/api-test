<?php

use Dotenv\Dotenv;
use Illuminate\Database\Capsule\Manager as Capsule;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;

require_once __DIR__ . '/vendor/autoload.php';

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

$config = require __DIR__ . '/src/config/app.php';

$capsule = new Capsule();

$capsule->addConnection($config['database']);

$capsule->setAsGlobal();
$capsule->bootEloquent();

$routes = require __DIR__ . '/src/config/routes.php';

$context = new RequestContext();
$context->fromRequest(Request::createFromGlobals());

$matcher = new UrlMatcher($routes, $context);

try {
    $request = Request::createFromGlobals();
    $parameters = $matcher->match($request->getPathInfo());

    $_method = $parameters['_method'] ?? 'GET';
    $method = $request->getMethod();

    if($method === 'OPTIONS') {
        exit(1);
    }

    if ($_method !== $method) {
        throw new BadMethodCallException("the {$method} method is not available");
    }

    $controller = new $parameters['class']();
    $route = $parameters['_route'];

    $obj = new ReflectionMethod($parameters['class'], $route);
    $response = $obj->invoke($controller, $request);

    if (!$response instanceof Response) {
        $response = new JsonResponse($response);
    }

    $response->send();
} catch (ResourceNotFoundException $e) {
    $response = new JsonResponse(['error' => $e->getMessage()], Response::HTTP_NOT_FOUND);
    $response->send();
} catch (\Throwable $e) {
    $response = new JsonResponse(['error' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
    $response->send();
}