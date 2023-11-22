<?php

declare(strict_types=1);

namespace App\UserInterface\Film\Http\Rest;

use App\Application\Common\DTO\Response as ApiResponse;
use App\Application\Film\Query\GetSingleFilm\GetSingleFilmQuery;
use App\UserInterface\Common\Http\Rest\CommonController;
use Nelmio\ApiDocBundle\Annotation\Model;
use Nelmio\ApiDocBundle\Annotation\Security;
use OpenApi\Attributes as OA;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route(path: '/api/v1/film', name: 'client_portal_film')]
#[OA\Tag(name: 'Client Portal / Film')]
class GetSingleFilmController extends CommonController
{
    #[OA\Response(
        response: Response::HTTP_OK,
        description: 'Get product',
        content: new Model(type: ApiResponse::class)
    )]
    #[Route('/show/{id}', methods: [Request::METHOD_GET])]
    #[Security(name: 'Bearer')]
    public function __invoke(int $id): JsonResponse
    {
        try{
            $response = $this->queryBus->handle(new GetSingleFilmQuery($id));

            return $this->getResponse(content: $response, groups: ['film_single']);

        } catch (\Throwable $exception) {

            return $this->getErrorResponse($exception);
        }
    }
}