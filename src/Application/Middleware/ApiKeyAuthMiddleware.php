<?php

namespace App\Application\Middleware;

use App\Models\Company;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Psr7\Response as Psr7Response;

class ApiKeyAuthMiddleware implements MiddlewareInterface
{
    /** @var Company */
    private $companyModel;

    public function __construct(Company $companyModel)
    {
        $this->companyModel = $companyModel;
    }

    public function process(Request $request, RequestHandlerInterface $handler): Response
    {
        // retrieve apiKey headers
        $apiKey = $request->getHeaderLine('Authorisation');

        // authentication logic 
        $company = $this->isValidApiKey($apiKey);
        if(!$company){
            $response = new Psr7Response();
            $response->getBody()->write(json_encode(['error' => 'Unauthorized']));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(401);
        }

        $request = $request->withAttribute('company', $company);
        return $handler->handle($request);
    }

    private function isValidApiKey(string $apiKey): ?Company
    {
        // find if company exists by the apiKey and return an object of the copany if successful or null if not
        $company = $this->companyModel->findByApiKey($apiKey);
        return $company;
    }
}

?>
