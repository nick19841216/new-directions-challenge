<?php

namespace App\Application\Actions;

use App\Models\Applicant;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class ApplicantController
{
    public function search(Request $request, Response $response, $args)
    {
        //fetch applicants from search criteria
        $company = $request->getAttribute('company');
        $queryParams = $request->getQueryParams();
        $county = $queryParams['county'] ?? null;
        $requiresDbs = $queryParams['requires_dbs'] ?? null;
        $positionAppliedFor = $queryParams['position'] ?? null;
        $selectedApplicants = Applicant::getApplicants($company, $county, $requiresDbs, $positionAppliedFor);

    
        // return a JSON response
        $data = json_encode($selectedApplicants);
        $response->getBody()->write($data);
        $response = $response->withHeader('Content-Type', 'application/json');
        
        return $response;
    }

    
    public function downloadCv(Request $request, Response $response, $args)
    {
        //decode the base64 encoded rtf file
        $decdodedFile = base64_decode(Applicant::cv_template());

        // prepare the response with the correct headers for an rtf file to be returned
        $response = $response
            ->withHeader('Content-Description', 'File Transfer')
            ->withHeader('Content-Type', 'application/rtf')
            ->withHeader('Content-Disposition', 'attachment; filename="cv.rtf"')
            ->withHeader('Content-Transfer-Encoding', 'binary')
            ->withHeader('Expires', '0')
            ->withHeader('Cache-Control', 'must-revalidate')
            ->withHeader('Pragma', 'public');

        $response->getBody()->write($decdodedFile);

        return $response;

    }
}

?>