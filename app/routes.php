<?php

declare(strict_types=1);
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;
use App\Application\Actions\ApplicantController;
use App\Application\Middleware\ApiKeyAuthMiddleware;

return function (App $app) {
    //routes to the applicants search page
    $app->get('/', function (Request $request, Response $response) {
        $response->getBody()->write(file_get_contents('applicants.html'));
        return $response;
    });

    //api calls with authentication through the ApiKeyAuthMiddleware
    $app->group('/api', function (Group $group) {
        $group->get('/applicants', ApplicantController::class . ':search');
        $group->get('/applicants/download-cv', ApplicantController::class . ':downloadCv');
    })->add(ApiKeyAuthMiddleware::class);
};
